<?php

/**
 * Terms Controller.
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
 * @package       TaxonomyTermDatas.Controller
 * @since         Green v 1.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('NodeAppController', 'Node.Controller');

/**
 * Autocomple in PHP's IDE solution
 * 
 * @property Content $TaxonomyTermDatas
 * 
 */
Class TermsController extends NodeAppController {

    /**
     * Use model class
     *
     * @var array
     */
    public $uses = array('Node.Term');

    /**
     * Called after the controller action.  
     *
     * @return void
     */
    public function beforeRender() {
        parent::beforeRender();
        if (in_array($this->request['action'], array('admin_add', 'admin_edit'))) {
            $layouts = $this->Dashboard->get($this->Term, 'layouts');
            if (empty($layouts)) {
                $layouts = array(null, array_keys($this->Term->schema()));
            }
            $this->set('_layouts', $layouts);
        }
    }

    /**
     * Management data
     *
     * @return void
     */
    public function admin_index($type_id = null) {
        if($type_id == null){
            $this->Dashboard->toolbar(__d('system', 'Please chose Type'), array(
            ));
            $listTypes = $this->Term->NodeType->find('all', array('fields' => array('id', 'name')));
            $this->set(compact('listTypes'));
        }
        else{
            $_paginate = array(
                'order' => array('rght' => 'asc'),
                'fields' => array('id', 'parent_id'),
                'conditions' => array('type_id' => $type_id)
            );
            $this->Dashboard->toolbar(__d('system', 'Content Type management'), array(
                'add' => array('action' => 'add', 'text' => __d('system', 'Add')),
                'edit' => array('action' => 'edit', 'text' => __d('system', 'Edit')),
                'remove' => array('action' => 'removes', 'text' => __d('system', 'Delete'))
            ));
            $conditions = $this->Dashboard->parseRequest($this->Term, $_paginate, array('name'));
            $listTerms = $this->paginate();
            $this->Dashboard->translateMaps($this->Term, $listTerms);
            /* --------- Tree ------------ */
            if (!empty($conditions['parent_id'])) {
                $_crumbs = $this->Term->getPath($conditions['parent_id'], array('id', $this->Term->displayField));
            } else {
                $conditions['parent_id'] = null;
            }
            $_toParent = $this->Term->isParentExist(array($conditions['parent_id']), true);

            $this->Dashboard->toolbar(__d('system', 'Term management'), array(
                'add' => array('action' => 'add', 'text' => __d('system', 'Add')),
                'copy' => array('action' => 'copy', 'text' => __d('system', 'Copy')),
                'edit' => array('action' => 'edit', 'text' => __d('system', 'Edit')),
                'remove' => array('action' => 'removes', 'text' => __d('system', 'Delete'))
            ));
            if (!empty($this->data['Paginate'])) {
                $data = array_merge(array('task' => '', 'id' => array(0)), $this->data['Paginate']);
                switch (strtolower($data['task'])) {
                    case 'add': {
                            $this->Dashboard->redirect(array('action' => 'add', $type_id, $data['id'][0], $conditions['parent_id']));
                        }
                    case 'copy': {
                            $this->Dashboard->redirect(array('action' => 'add', $type_id, $data['id'][0], $conditions['parent_id']));
                        }
                    case 'edit': {
                            $this->Dashboard->redirect(array('action' => 'edit', $type_id, $data['id'][0]));
                        }
                    case 'remove': {
                            $this->Dashboard->redirect(array('action' => 'delete', '?' => array('keys' => $data['id'])));
                        }
                }
            }
            $this->set(compact('listTerms', '_crumbs', '_toParent', 'type_id'));                    
        }        

    }

    /**
     * Add data
     *
     * @return void
     */
    public function admin_add($typeId = 0, $id = null, $parentId = null) {       
        if($typeId == 0){
            $this->Dashboard->exists($this->Term, $id, false);
            $this->Dashboard->toolbar(__d('system', 'Please chose Type'), array());
            $listTypes = $this->Term->NodeType->find('all', array('fields' => array('id', 'name')));
            $this->set(compact('listTypes'));
        }
        else{
            $this->Dashboard->toolbar(__d('system', 'Add new Term'), array(
                'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
                'next' => array('action' => 'save', 'text' => __d('system', 'Save & Add New')),
                'cancel' => __d('system', 'Cancel')
            ));
            //debug($this->data);exit;
            $menus = $this->Term->generateTreeList(array('Term.type_id' => $typeId), null, null, '&nbsp;&nbsp;&nbsp;|-&nbsp;');
            //if(!empty($this->request->data['Term']['image']['name'])){
//                  $pre = time();                     
//                  if (file_exists(WWW_ROOT.'/files/'.$this->request->data['Term']['image']['name'])) {
//                    $this->request->data['Term']['image']['name'] = $pre.'_'.$this->request->data['Term']['image']['name'];                            
//                  }   
//                  $fileName = $this->request->data['Term']['image']['name'];                                            
//                  $tmpName  =  $this->request->data['Term']['image']['tmp_name'];
//                  move_uploaded_file($tmpName, WWW_ROOT.'/files/'.$fileName); 
//            }
            if ($this->request->is('post')) {
                $this->Term->create();
                $task = strtolower($this->data['Paginate']['task']);
                   //$this->request->data['Term']['image'] = $this->request->data['Term']['image']['name'];
                if (!$task || $task === 'cancel') {
                    $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
                } elseif ($this->Term->save($this->request->data)) {
                    $this->setFlash(__d('system', 'The %s has been saved', __d('system', 'Term')), 'success');
                    switch ($task) {
                        case 'next': {
                                $this->redirect($this->request->here(false));
                            }
                        case 'apply': {
                                $this->Dashboard->redirect(array('action' => 'edit', $typeId, $this->Term->getInsertID()), false, true);
                            }
                    }
                    $this->Dashboard->redirect(array('action' => 'index', $typeId, 'ext' => false), true);
                    
                } else {
                    $this->setFlash(__d('system', 'The %s could not be saved. Please, try again.', __d('system', 'Term')), 'error');
                }
            } elseif ($id) {
                $this->request->data = $this->Term->find('first', array('conditions' => array('Term.id' => $id), 'recursive' => -1));
            }
        }
        
        $this->set(compact('id', 'typeId', 'parentId', 'menus'));
    }

    /**
     * Edit data
     *
     * @return void
     */
    public function admin_edit($typeId, $id, $parentId = null) {
        $menus = $this->Term->generateTreeList(array('Term.type_id' => $typeId), null, null, '&nbsp;&nbsp;&nbsp;|-&nbsp;');
        $this->Dashboard->exists($this->Term, $id);
        $this->Dashboard->toolbar(__d('system', 'Edit Term #%s', $id), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'remove' => array('action' => 'remove', 'text' => __d('system', 'Delete')),
            'cancel' => __d('system', 'Cancel')
        ));
        if (!empty($this->request->data)) {
            $task = strtolower($this->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif ($this->Term->save($this->request->data)) {
                if ($task !== 'remove') {
                    $this->setFlash(__d('system', 'The %s has been updated', __d('system', 'Term')), 'success');
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
                $this->setFlash(__d('system', 'The %s could not be updated. Please, try again.', __d('system', 'Term')));
            }
        } else {
            $this->request->data = $this->Term->find('first', array('conditions' => array('Term.id' => $id), 'recursive' => -1));
        }
        $this->set(compact('id', 'typeId', 'menus'));
    }

    /**
     * Delete data
     *
     * @return void
     */
    public function admin_delete() {
        $this->layout = null;
        if (empty($this->request->query['keys'])) {
            $this->setFlash(__d('system', 'Select elements should be deleted from the list below!', __d('system', 'Term')));
        } else {
            $complete = 0;
            $message = null;
            $keys = (array) $this->request->query['keys'];
            foreach ($keys as $key) {
                if (!$this->Term->delete($key)) {
                    $message = $this->Term->getMessage();
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
            $this->setFlash(__d('system', 'The %1$s has been deleted %2$s / %3$s rows.', __d('system', 'Term'), $complete, count($keys)) . $message, 'warning');
        }
        $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
    }

    /**
     * Translate data
     *
     * @return void
     */
    public function admin_translate($id = null, $language = null) {
        $this->Dashboard->exists($this->Term, $id);
        $this->Dashboard->toolbar(__d('system', 'Translate Term #%s', $id), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'apply' => array('action' => 'save', 'text' => __d('system', 'Apply')),
            'remove' => array('action' => 'remove', 'text' => __d('system', 'Remove')),
            'cancel' => __d('system', 'Cancel')
        ));
        $locale = $this->Dashboard->getLocale($language);
        if (empty($locale)) {
            $this->setFlash(__d('system', 'The language code <b>%s</b> does not exist', $language));
        }
        $translateFields = $this->Dashboard->translateFields($this->Term);
        if (empty($translateFields)) {
            $this->setFlash(__d('system', 'The %s not be configured a multilingual', __d('system', 'Term')));
        }
        if (empty($locale) || empty($translateFields)) {
            $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
        }
        $this->Term->locale = $locale;
        if ($this->request->is('post')) {
            $task = strtolower($this->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif ($this->Term->translate($this->request->data)) {
                if ($task !== 'remove') {
                    $this->setFlash(__d('system', 'The %s has been translated', __d('system', 'Term')), 'success');
                } else {
                    $this->Dashboard->removeTranslated($this->Term);
                    $this->setFlash(__d('system', 'The translated data of %s has been removed', __d('system', 'Term')), 'success');
                }
                switch ($task) {
                    case 'remove':
                    case 'apply': {
                            $this->redirect($this->request->here(false));
                        }
                }
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } else {
                $this->setFlash(__d('system', 'The %s could not be translated. Please, try again.', __d('system', 'Term')));
            }
        }
        $term = $this->Dashboard->getTranslated($this->Term, $translateFields);
        $this->set(compact('locale', 'language', 'term', 'id'));
    }
    /**
     * Tree node move
     *
     * @return void
     */
    public function admin_move($id = null, $direction = 'up') {
        $this->Dashboard->exists($this->Term, $id);
        $message = '';
        if ($direction == 'up') {
            if ($this->Term->moveUp($id)) {
                $message = __d('system', 'The %s has been moved up.', __d('system', 'Term'));
            }
        } else {
            if ($this->Term->moveDown($id)) {
                $message = __d('system', 'The %s has been moved down.', __d('system', 'Term'));
            }
        }
        if (!$message) {
            $this->setFlash(__d('system', 'The %s could not be moved. Please, try again.', __d('system', 'Term')), 'warning');
        } else {
            $this->setFlash($message, 'success');
        }
        $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
    }
}

?>
