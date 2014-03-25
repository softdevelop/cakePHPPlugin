<?php

/**
 * TaxonomyVocabularies Controller.
 *
 * Helpful methods to make Controller.
 *
 * PHP versions 5
 * CAKEPHP versions 2.x
 * 
 * Green CMS - Content Management System and Framework Powerfull by Cakephp
 * Copyright 2012, GREEN GLOBAL CO., LTD (toancauxanh.vn)
 * 
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        Technology Lab No.I <tech1@toancauxanh.vn>
 * @link          
 * @package       TaxonomyVocabularies.Controller
 * @since         Green v 1.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('NodeAppController', 'Node.Controller');

/**
 * Autocomple in PHP's IDE solution
 * 
 * @property Content $Taxonomy
 * 
 */
Class TaxonomyVocabulariesController extends NodeAppController {

    /**
     * Use model class
     *
     * @var array
     */
    public $uses = array('Node.TaxonomyVocabulary');

    /**
     * Called after the controller action.  
     *
     * @return void
     */
    public function beforeRender() {
        parent::beforeRender();
        if (in_array($this->request['action'], array('admin_add', 'admin_edit'))) {
            $layouts = $this->Dashboard->get($this->TaxonomyVocabulary, 'layouts');
            if (empty($layouts)) {
                $layouts = array(null, array_keys($this->TaxonomyVocabulary->schema()));
            }
            $this->set('_layouts', $layouts);
        }
    }

    /**
     * Management data
     *
     * @return void
     */
    public function admin_index() {
        $_paginate = array(
            'order' => array('created' => 'desc'),
            'fields' => array('id')
        );
        $conditions = $this->Dashboard->parseRequest($this->TaxonomyVocabulary, $_paginate, array('name'));
        $list_taxonomies = $this->paginate();
        $this->Dashboard->translateMaps($this->TaxonomyVocabulary, $list_taxonomies);
        $this->Dashboard->toolbar(__d('system', 'Taxonomy management'), array(
            'add' => array('action' => 'add', 'text' => __d('system', 'Add')),
            'copy' => array('action' => 'copy', 'text' => __d('system', 'Copy')),
            'edit' => array('action' => 'edit', 'text' => __d('system', 'Edit')),
            'remove' => array('action' => 'removes', 'text' => __d('system', 'Delete'))
        ));
        if (!empty($this->data['Paginate'])) {
            $data = array_merge(array('task' => '', 'id' => array(0)), $this->data['Paginate']);
            switch (strtolower($data['task'])) {
                case 'add': {
                        $this->Dashboard->redirect(array('action' => 'add', $data['id'][0], $conditions['parent_id']));
                    }
                case 'copy': {
                        $this->Dashboard->redirect(array('action' => 'add', $data['id'][0], $conditions['parent_id']));
                    }
                case 'edit': {
                        $this->Dashboard->redirect(array('action' => 'edit', $data['id'][0]));
                    }
                case 'remove': {
                        $this->Dashboard->redirect(array('action' => 'delete', '?' => array('keys' => $data['id'])));
                    }
            }
        }
        $this->set(compact('list_taxonomies'));
    }

    /**
     * Add data
     *
     * @return void
     */
    public function admin_add($id = null, $parent = null) { 
        $this->Dashboard->exists($this->TaxonomyVocabulary, $id, false);
        $this->Dashboard->toolbar(__d('system', 'T?o m?i Danh m?c'), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'next' => array('action' => 'save', 'text' => __d('system', 'Save & Add New')),
            'apply' => array('action' => 'save', 'text' => __d('system', 'Apply')),
            'cancel' => __d('system', 'Cancel')
        ));
        if ($this->request->is('post')) {
            $this->TaxonomyVocabulary->create();
            $task = strtolower($this->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif ($this->TaxonomyVocabulary->save($this->request->data)) {
                $this->setFlash(__d('system', 'The %s has been saved', __d('system', 'Taxonomy')), 'success');
                switch ($task) {
                    case 'next': {
                            $this->redirect($this->request->here(false));
                        }
                    case 'apply': {
                            $this->Dashboard->redirect(array('action' => 'edit', $this->TaxonomyVocabulary->getInsertID()), false, true);
                        }
                }
               
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } else {
                $this->setFlash(__d('system', 'The %s could not be saved. Please, try again.', __d('system', 'Taxonomy')), 'error');
            }
        } elseif ($id) {
            $this->request->data = $this->TaxonomyVocabulary->find('first', array('conditions' => array('TaxonomyVocabulary.id' => $id), 'recursive' => -1));
        }
        $this->set(compact('id'));
    }

    /**
     * Edit data
     *
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Dashboard->exists($this->TaxonomyVocabulary, $id);
        $this->Dashboard->toolbar(__d('system', 'Ch?nh s?a Danh m?c #%s', $id), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'apply' => array('action' => 'save', 'text' => __d('system', 'Apply')),
            'remove' => array('action' => 'remove', 'text' => __d('system', 'Delete')),
            'cancel' => __d('system', 'Cancel')
        ));
        if ($this->request->is('post')) {
            $task = strtolower($this->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif ($this->TaxonomyVocabulary->save($this->request->data)) {
                if ($task !== 'remove') {
                    $this->setFlash(__d('system', 'The %s has been updated', __d('system', 'Taxonomy')), 'success');
                }
                switch ($task) {
                    case 'remove': {
                            $this->Dashboard->redirect(array('action' => 'delete', '?' => array('keys' => $id)), false, true);
                        }
                    case 'apply': {
                            $this->redirect($this->request->here(false));
                        }
                }
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } else {
                $this->setFlash(__d('system', 'The %s could not be updated. Please, try again.', __d('system', 'Taxonomy')));
            }
        } else {
            $this->request->data = $this->TaxonomyVocabulary->find('first', array('conditions' => array('TaxonomyVocabulary.id' => $id), 'recursive' => -1));
        }
        $this->set(compact('id'));
    }

    /**
     * Delete data
     *
     * @return void
     */
    public function admin_delete() {
        $this->layout = null;
        if (empty($this->request->query['keys'])) {
            $this->setFlash(__d('system', 'Select elements should be deleted from the list below!', __d('system', 'Taxonomy')));
        } else {
            $complete = 0;
            $message = null;
            $keys = (array) $this->request->query['keys'];
            foreach ($keys as $key) {
                if (!$this->TaxonomyVocabulary->delete($key)) {
                    $message = $this->TaxonomyVocabulary->getMessage();
                    if (!$message) {
                        $message = __d('system', 'Cannot delete row #%s.', $key);
                    }
                    break;
                } else {
                    $complete++;
                }
            }
            if ($message) {
                $message = __d('system', '<br/>The processing has stopped because : <b>%s</b>', $message);
            }
            $this->setFlash(__d('system', 'The %1$s has been deleted %2$s / %3$s rows.', __d('system', 'Taxonomy'), $complete, count($keys)) . $message, 'warning');
        }
        $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
    }

    /**
     * Translate data
     *
     * @return void
     */
    public function admin_translate($id = null, $language = null) {
        $this->Dashboard->exists($this->TaxonomyVocabulary, $id);
        $this->Dashboard->toolbar(__d('system', 'Translate Taxonomy #%s', $id), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'apply' => array('action' => 'save', 'text' => __d('system', 'Apply')),
            'remove' => array('action' => 'remove', 'text' => __d('system', 'Remove')),
            'cancel' => __d('system', 'Cancel')
        ));
        $locale = $this->Dashboard->getLocale($language);
        if (empty($locale)) {
            $this->setFlash(__d('system', 'The language code <b>%s</b> does not exist', $language));
        }
        $translateFields = $this->Dashboard->translateFields($this->TaxonomyVocabulary);
        if (empty($translateFields)) {
            $this->setFlash(__d('system', 'The %s not be configured a multilingual', __d('system', 'Taxonomy')));
        }
        if (empty($locale) || empty($translateFields)) {
            $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
        }
        $this->TaxonomyVocabulary->locale = $locale;
        if ($this->request->is('post')) {
            $task = strtolower($this->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif ($this->TaxonomyVocabulary->translate($this->request->data)) {
                if ($task !== 'remove') {
                    $this->setFlash(__d('system', 'The %s has been translated', __d('system', 'Taxonomy')), 'success');
                } else {
                    $this->Dashboard->removeTranslated($this->TaxonomyVocabulary);
                    $this->setFlash(__d('system', 'The translated data of %s has been removed', __d('system', 'Taxonomy')), 'success');
                }
                switch ($task) {
                    case 'remove':
                    case 'apply': {
                            $this->redirect($this->request->here(false));
                        }
                }
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } else {
                $this->setFlash(__d('system', 'The %s could not be translated. Please, try again.', __d('system', 'Taxonomy')));
            }
        }
        $tax = $this->Dashboard->getTranslated($this->TaxonomyVocabulary, $translateFields);
        $this->set(compact('locale', 'language', 'tax', 'id'));
    }
    
    public function admin_list_terms($tax_alias) {
        $_paginate = array(
            'order' => array('created' => 'desc'),
            'fields' => array('id')
        );
        
        $conditions = $this->Dashboard->parseRequest($this->TaxonomyVocabulary, $_paginate, array('name'));
        $list_taxonomies = $this->paginate();
        $this->Dashboard->translateMaps($this->TaxonomyVocabulary, $list_taxonomies);
        $this->Dashboard->toolbar(__d('system', 'Taxonomy management'), array(
            'add' => array('action' => 'add', 'text' => __d('system', 'Add')),
            'copy' => array('action' => 'copy', 'text' => __d('system', 'Copy')),
            'edit' => array('action' => 'edit', 'text' => __d('system', 'Edit')),
            'remove' => array('action' => 'removes', 'text' => __d('system', 'Delete'))
        ));
        if (!empty($this->data['Paginate'])) {
            $data = array_merge(array('task' => '', 'id' => array(0)), $this->data['Paginate']);
            switch (strtolower($data['task'])) {
                case 'add': {
                        $this->Dashboard->redirect(array('action' => 'add', $data['id'][0], $conditions['parent_id']));
                    }
                case 'copy': {
                        $this->Dashboard->redirect(array('action' => 'add', $data['id'][0], $conditions['parent_id']));
                    }
                case 'edit': {
                        $this->Dashboard->redirect(array('action' => 'edit', $data['id'][0]));
                    }
                case 'remove': {
                        $this->Dashboard->redirect(array('action' => 'delete', '?' => array('keys' => $data['id'])));
                    }
            }
        }
        //debug($list_node_types);
        $this->set(compact('list_taxonomies'));
    }
}

?>
