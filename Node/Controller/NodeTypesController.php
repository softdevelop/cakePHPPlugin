<?php

/**
 * NodeType Controller.
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
 * @package       NodeType.Controller
 * @since         Green v 1.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('NodeAppController', 'Node.Controller');

Class NodeTypesController extends NodeAppController {

    /**
     * Use model class
     *
     * @var array
     */
    public $uses = array('Node.NodeType');

    /**
     * Called after the controller action.  
     *
     * @return void
     */
    public function beforeRender() {
        parent::beforeRender();
        if (in_array($this->request['action'], array('admin_add', 'admin_edit'))) {
            $layouts = $this->Dashboard->get($this->NodeType, 'layouts');
            if (empty($layouts)) {
                $layouts = array(null, array_keys($this->NodeType->schema()));
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
        $conditions = $this->Dashboard->parseRequest($this->NodeType, $_paginate, array('name'));
        $listNodeTypes = $this->paginate();
        $this->Dashboard->translateMaps($this->NodeType, $listNodeTypes);
        $this->Dashboard->toolbar(__d('system','Content Type management'), array(
            'add' => array('action' => 'add', 'text' => __d('system', 'Add')),
            'edit' => array('action' => 'edit', 'text' => __d('system', 'Edit')),
            'remove' => array('action' => 'removes', 'text' => __d('system', 'Delete'))
        ));
        if (!empty($this->data['Paginate'])) {
            $data = array_merge(array('task' => '', 'id' => array(0)), $this->data['Paginate']);
            switch (strtolower($data['task'])) {
                case 'add': {
                        $this->Dashboard->redirect(array('action' => 'add', $data['id'][0]));
                    }
                case 'copy': {
                        $this->Dashboard->redirect(array('action' => 'import', $data['id'][0]));
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
        $this->set(compact('listNodeTypes'));
    }

    /**
     * Add data
     *
     * @return void
     */
    public function admin_add($id = null, $parent = null) {
        $this->Dashboard->exists($this->NodeType, $id, false);
        $this->Dashboard->toolbar(__d('system', 'Add new Node Type'), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'next' => array('action' => 'save', 'text' => __d('system', 'Save & Add New')),
            'cancel' => __d('system', 'Cancel')
        ));
        if ($this->request->is('post')) {
            $this->NodeType->create();
            $task = strtolower($this->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif ($this->NodeType->save($this->request->data)) {
                $this->setFlash(__d('system', 'The %s has been saved', __d('system', 'Node Type')), 'success');
                switch ($task) {
                    case 'next': {
                            $this->redirect($this->request->here(false));
                        }
                    case 'apply': {
                            $this->Dashboard->redirect(array('action' => 'edit', $this->NodeType->getInsertID()), false, true);
                        }
                }

                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } else {
                $this->setFlash(__d('system', 'The %s could not be saved. Please, try again.', __d('system', 'Node Type')), 'error');
            }
        } elseif ($id) {
            $this->request->data = $this->NodeType->find('first', array('conditions' => array('NodeType.id' => $id), 'recursive' => -1));
        }
        $this->set(compact('id'));
    }

    /**
     * Edit data
     *
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Dashboard->exists($this->NodeType, $id);
        $this->Dashboard->toolbar(__d('system', 'Edit Node Type #%s', $id), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'remove' => array('action' => 'remove', 'text' => __d('system', 'Delete')),
            'cancel' => __d('system', 'Cancel')
        ));
        if ($this->request->is('post')) {
            $task = strtolower($this->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif ($this->NodeType->save($this->request->data)) {
                if ($task !== 'remove') {
                    $this->setFlash(__d('system', 'The %s has been updated', __d('system', 'Node Type')), 'success');
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
                $this->setFlash(__d('system', 'The %s could not be updated. Please, try again.', __d('system', 'Node Type')));
            }
        } else {
            $this->request->data = $this->NodeType->find('first', array('conditions' => array('NodeType.id' => $id), 'recursive' => -1));
        }
        $this->set(compact('id'));
    }

    /**
     * Import data
     *
     * @return void
     */
    public function admin_import($id = null) {
        $this->Dashboard->exists($this->NodeType, $id);
        $step = 1;
        $file = $exist = null;
        $action = array('next' => array('action' => 'save', 'text' => __d('system', 'Next')));
        $this->loadModel('Node.Node');
        $this->Node->cacheQueries = false;
        $info = array(
            'node_type_id' => $id,
            'user_id' => $this->Auth->user('id')
        );
        if ($this->request->is('ajax') || isset($this->request->query['ajax'])) {
            $reponse = array(
                'error' => true,
                'value' => 0,
                'message' => __d('system', 'Your session has been lost, please do again from step 1.')
            );
            //$this->Session->delete('Import.NoteType');
            if ($this->Session->check('Import.NoteType')) {
                extract($this->Session->read('Import.NoteType'));
                if (($cells = $this->_getImportData($file))) {
                    $length = $current + min(mt_rand(100, 200), $total - $current);
                    for ($current; $current < $length; $current++) {
                        $save = array();
                        $index = 0;
                        foreach ($cells->item($current)->getElementsByTagName('Cell') as $node) {
                            $_index = $node->getAttribute('ss:Index');
                            if ($_index !== '') {
                                $index = $_index = $_index - 1;
                            }
                            if (isset($fieldset[$index])) {
                                $save[$fieldset[$index]] = trim($node->childNodes->item(0)->nodeValue);
                            }
                            $index++;
                        }
                        if ($save) {
                            $save = array_merge($info, $save);
                            $this->Node->create();
                            $node = $this->Node->find('first', array(
                                'recursive' => -1,
                                'callbacks' => false,
                                'fields' => array('id'),
                                'conditions' => array(
                                    'title' => $save['title'],
                                    'node_type_id' => $id)));
                            $nothing = false;
                            switch ((int) $exist) {
                                case 1: {
                                        if ($node) {
                                            $this->Node->id = $node['Node']['id'];
                                        }
                                        break;
                                    }
                                case 2: {
                                        if ($node) {
                                            $this->Node->delete($node['Node']['id']);
                                        }
                                        $this->Node->create();
                                        break;
                                    }
                                case 3 : {
                                        break;
                                    }
                                default : {
                                        if ($node) {
                                            $nothing = true;
                                        }
                                    }
                            }
                            if ($nothing === false && $this->Node->save($save)) {
                                $success++;
                            }
                        }
                    }
                    $reponse = array(
                        'error' => false,
                        'value' => round(($current / $total) * 100),
                        'message' => __d('system', '%1$s / %2$s nodes have been processed. %3$s nodes was imported', $current, $total, $success)
                    );
                    $this->Session->write('Import.NoteType', compact('current', 'success', 'total', 'exist', 'file', 'fieldset'));
                } else {
                    $reponse['message'] = __d('system', 'Import error. File you choose was lost.');
                }
            }
            echo json_encode($reponse);
            Configure::write('debug', 0);
            exit();
        } elseif (!empty($this->request->data)) {
            $task = strtolower($this->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Session->delete('Import.NoteType');
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            }
            $step = (int) $this->data['Paginate']['step'];
            if ($step == 2) {
                $this->Node->set(array_merge($this->request->data['Node'], $info));
                if (!$this->Node->validates()) {
                    $step = 1;
                    $this->setFlash(__d('system', 'Import error, Please choose fields to import.'));
                }
            }
            switch ($step) {
                case 1: {
                        if (!empty($this->request->data['NodeType']['file'])) {
                            $file = $this->request->data['NodeType']['file'];
                            $exist = $this->request->data['NodeType']['exist'];
                            if (($cells = $this->_getImportData($file))) {
                                $this->loadModel('Node.Field');
                                $fieldsets = $this->Field->find('all', array('fields' => array('name'),
                                    'recursive' => -1, 'order' => 'id ASC', 'conditions' => array('type_id' => $id)));
                                $fields = array();
                                $default = array('title' => 'title', 'body' => 'content', 'description' => 'description');
                                foreach ($fieldsets as &$field) {
                                    $fields[$field['Field']['name']] = Inflector::humanize(preg_replace('/_id$/', '', $field['Field']['name']));
                                }
                                $fields = array_merge($default, $fields);
                                $fieldset = $this->_getImportFields($cells);
                                $step = 2;
                            }
                        } else {
                            $this->setFlash(__d('system', 'Please choose file to import data'));
                        }
                        break;
                    }
                case 2: {
                        $file = $this->request->data['NodeType']['file'];
                        $exist = $this->request->data['NodeType']['exist'];
                        if (($cells = $this->_getImportData($file))) {
                            $this->Session->write('Import.NoteType', array(
                                'current' => 1,
                                'success' => 0,
                                'total' => $cells->length,
                                'file' => $file,
                                'exist' => $exist,
                                'fieldset' => array_flip($this->request->data['Node'])
                            ));
                            $action = array();
                            $step = 3;
                        } else {
                            $this->redirect($this->request->here(false));
                        }
                        break;
                    }
            }

            if ($step != 1) {
                $this->view .= '_step' . $step;
            }
        }
        $this->Dashboard->toolbar(__d('system', 'Import node to type #%s', $id), array_merge($action, array(
                    'cancel' => __d('system', 'Cancel')
                )));
        $this->set(compact('id', 'file', 'step', 'fields', 'fieldset', 'exist'));
    }

    /**
     * Get Import data
     * 
     * @param string xml file
     * @return DOMNodeList
     */
    protected function _getImportData($file) {
        $domDoc = new DOMDocument();
        $file = WWW_ROOT . 'img' . DS . str_replace('/', DS, $file);
        if (!file_exists($file) || !is_file($file)) {
            $this->setFlash(__d('system', 'Import error, file you chosen does not exists. Please make sure file %s exists', $file));
            return false;
        }
        if (!@$domDoc->load($file) || (!($sheet = $domDoc->getElementsByTagName('Worksheet'))
                || $sheet->length <= 0) || (!($cells = $sheet->item(0)->getElementsByTagName('Row')) || $cells->length <= 1)) {
            $this->setFlash(__d('system', 'Import error, file format is invalid or empty.', $file));
            return false;
        }
        return $cells;
    }

    /**
     * Delete data
     *
     * @param DOMNodeList $cells
     * @return array
     */
    protected function _getImportFields(DOMNodeList $cells) {
        $fieldset = array();
        foreach ($cells->item(0)->getElementsByTagName('Data') as $index => $row) {
            $fieldset[$index] = trim($row->nodeValue);
        }
        return $fieldset;
    }

    /**
     * Delete data
     *
     * @return void
     */
    public function admin_delete() {
        $this->layout = null;
        if (empty($this->request->query['keys'])) {
            $this->setFlash(__d('system', 'Select elements should be deleted from the list below!', __d('system', 'Node Type')));
        } else {
            $complete = 0;
            $message = null;
            $keys = (array) $this->request->query['keys'];
            foreach ($keys as $key) {
                if (!$this->NodeType->delete($key)) {
                    $message = $this->NodeType->getMessage();
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
            $this->setFlash(__d('system', 'The %1$s has been deleted %2$s / %3$s rows.', __d('system', 'Node Type'), $complete, count($keys)) . $message, 'warning');
        }
        $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
    }

    /**
     * Translate data
     *
     * @return void
     */
    public function admin_translate($id = null, $language = null) {
        $this->Dashboard->exists($this->NodeType, $id);
        $this->Dashboard->toolbar(__d('system', 'Translate Node Type #%s', $id), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'apply' => array('action' => 'save', 'text' => __d('system', 'Apply')),
            'remove' => array('action' => 'remove', 'text' => __d('system', 'Remove')),
            'cancel' => __d('system', 'Cancel')
        ));
        $locale = $this->Dashboard->getLocale($language);
        if (empty($locale)) {
            $this->setFlash(__d('system', 'The language code <b>%s</b> does not exist', $language));
        }
        $translateFields = $this->Dashboard->translateFields($this->NodeType);
        if (empty($translateFields)) {
            $this->setFlash(__d('system', 'The %s not be configured a multilingual', __d('system', 'Node Type')));
        }
        if (empty($locale) || empty($translateFields)) {
            $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
        }
        $this->NodeType->locale = $locale;
        if ($this->request->is('post')) {
            $task = strtolower($this->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif ($this->NodeType->translate($this->request->data)) {
                if ($task !== 'remove') {
                    $this->setFlash(__d('system', 'The %s has been translated', __d('system', 'Node Type')), 'success');
                } else {
                    $this->Dashboard->removeTranslated($this->NodeType);
                    $this->setFlash(__d('system', 'The translated data of %s has been removed', __d('system', 'Node Type')), 'success');
                }
                switch ($task) {
                    case 'remove':
                    case 'apply': {
                            $this->redirect($this->request->here(false));
                        }
                }
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } else {
                $this->setFlash(__d('system', 'The %s could not be translated. Please, try again.', __d('system', 'Node Type')));
            }
        }
        $nodetype = $this->Dashboard->getTranslated($this->NodeType, $translateFields);
        $this->set(compact('locale', 'language', 'nodetype', 'id'));
    }

}

?>
