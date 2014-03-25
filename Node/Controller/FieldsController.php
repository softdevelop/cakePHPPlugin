<?php

/**
 * Fields Controller.
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

Class FieldsController extends NodeAppController {

    /**
     * Use model class
     *
     * @var array
     */
    public $uses = array('Node.Field');

    /**
     * Called after the controller action.  
     *
     * @return void
     */
    public function beforeRender() {
        parent::beforeRender();
        if (in_array($this->request['action'], array('admin_add', 'admin_edit'))) {
            $layouts = $this->Dashboard->get($this->Field, 'layouts');
            if (empty($layouts)) {
                $layouts = array(null, array_keys($this->Field->schema()));
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
        if (empty($type_id)) {
            $this->redirect(array('controller' => 'NodeTypes', 'action' => 'index'));
        }
        $_paginate = array(
            'order' => array('id' => 'desc'),
            'fields' => array('id'),
            'conditions' => array('type_id' => $type_id)
        );
        $conditions = $this->Dashboard->parseRequest($this->Field, $_paginate, array('name'));
        $list_fields = $this->paginate();
        $this->Dashboard->translateMaps($this->Field, $list_fields);
        $this->Dashboard->toolbar(__d('system', 'Field management'), array(
            'add' => array('action' => 'add', 'text' => __d('system', 'Add')),
            'edit' => array('action' => 'edit', 'text' => __d('system', 'Edit')),
            'remove' => array('action' => 'removes', 'text' => __d('system', 'Delete'))
        ));
        if (!empty($this->request->data['Paginate'])) {
            $data = array_merge(array('task' => '', 'id' => array(0)), $this->request->data['Paginate']);
            switch (strtolower($data['task'])) {
                case 'add': {
                        $this->Dashboard->redirect(array('action' => 'add', $type_id, $data['id'][0]));
                    }
                case 'copy': {
                        $this->Dashboard->redirect(array('action' => 'add', $type_id, $data['id'][0]));
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
        $this->set(compact('list_fields'));
    }

    /**
     * Add data
     *
     * @return void
     */
    public function admin_add($type_id, $id = null) {
        if (empty($type_id)) {
            $this->redirect(array('controller' => 'NodeTypes', 'action' => 'index'));
        }
        $this->Dashboard->exists($this->Field, $id, false);
        $this->Dashboard->toolbar(__d('system', 'Add new Field'), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'cancel' => __d('system', 'Cancel')
        ));
        if ($this->request->is('post')) {
            $this->Field->create();
            $task = strtolower($this->request->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif ($this->Field->save($this->request->data)) {
                switch ($this->request->data['Field']['field_type']) {
                    case 'date': {
                            $this->Field->query("ALTER TABLE nodes ADD COLUMN field_" . $this->request->data['Field']['name'] . " datetime NULL");
                            break;
                        }
                    case 'img': {
                            $this->Field->query("ALTER TABLE nodes ADD COLUMN field_" . $this->request->data['Field']['name'] . " varchar(250) NULL");
                            break;
                        }
                    case 'file': {
                            $this->Field->query("ALTER TABLE nodes ADD COLUMN field_" . $this->request->data['Field']['name'] . " varchar(250) NULL");
                            break;
                        }
                    case 'textarea': {
                            $this->Field->query("ALTER TABLE nodes ADD COLUMN field_" . $this->request->data['Field']['name'] . " longtext NULL");
                            break;
                        }
                    case 'text': {
                            $this->Field->query("ALTER TABLE nodes ADD COLUMN field_" . $this->request->data['Field']['name'] . " text NULL");
                            break;
                        }
                    case 'checkbox': {
                            $this->Field->query("ALTER TABLE nodes ADD COLUMN field_" . $this->request->data['Field']['name'] . " tinyint NULL");
                            break;
                        }
                }
                $this->setFlash(__d('system', 'The %s has been saved', __d('system', 'Field')), 'success');
                $this->redirect(array('action' => 'field_settings', $this->Field->id, 'ext' => false), true);
            } else {
                $this->setFlash(__d('system', 'The %s could not be saved. Please, try again.', __d('system', 'Node')), 'error');
            }
        } elseif ($id) {
            $this->request->data = $this->Field->find('first', array('conditions' => array('Field.id' => $id), 'recursive' => -1));
        }
        $this->set(compact('id', 'type_id'));
    }

    /**
     * Manager Field 
     *
     * @return void
     */
    public function admin_field_settings($id) {
        if ($id == null) {
            $this->redirect(array('controller' => 'NodeTypes', 'action' => 'index'));
        }
        $this->Dashboard->exists($this->Field, $id);
        $this->Dashboard->toolbar(__d('system', 'Manage Field #%s', $id), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'remove' => array('action' => 'remove', 'text' => __d('system', 'Delete')),
            'cancel' => __d('system', 'Cancel')
        ));
        $field = $this->Field->read();
        $list_types = $this->Field->NodeType->find('list', array('fields' => array('id', 'name')));
        $this->set(compact('list_types'));
        if ($this->request->is('post')) {
            $task = strtolower($this->request->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif (!empty($this->request->data)) {
                $data = array('datas' => $this->request->data);
                $this->request->data['Field']['params'] = serialize($data);
                $this->Field->save($this->request->data);
                //debug($this->request->data['Field']['params']);exit;
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
                $this->Dashboard->redirect(array('action' => 'index', $field['Field']['type_id'], 'ext' => false), true);
            } else {
                $this->setFlash(__d('system', 'The %s could not be updated. Please, try again.', __d('system', 'Node Type')));
            }
        } else {
            $this->request->data = $this->Field->find('first', array('conditions' => array('Field.id' => $id), 'recursive' => -1));
        }
    }

    /**
     * Edit Field 
     *
     * @return void
     */
    public function admin_edit_field_settings($id) {
        $this->Dashboard->exists($this->Field, $id);
        $this->Dashboard->toolbar(__d('system', 'Manage Field #%s', $id), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'remove' => array('action' => 'remove', 'text' => __d('system', 'Delete')),
            'cancel' => __d('system', 'Cancel')
        ));
        $field = $this->Field->read();
        $data = unserialize($field['Field']['params']);
        $field_setting = $data['datas'];
        $list_types = $this->Field->NodeType->find('list', array('fields' => array('id', 'name')));
        $this->set(compact('list_types', 'field_setting', 'field'));
        if ($this->request->is('post')) {
            $task = strtolower($this->request->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif (!empty($this->request->data)) {
                $data = array('datas' => $this->request->data);
                $this->request->data['Field']['params'] = serialize($data);
                $this->Field->save($this->request->data);
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
                $this->Dashboard->redirect(array('action' => 'index', $field['Field']['type_id'], 'ext' => false), true);
            } else {
                $this->setFlash(__d('system', 'The %s could not be updated. Please, try again.', __d('system', 'Node Type')));
            }
        } else {
            $this->request->data = $this->Field->find('first', array('conditions' => array('Field.id' => $id), 'recursive' => -1));
        }
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
                $field = $this->Field->read(null, $key);
                if (!$this->Field->delete($key)) {
                    $message = $this->Field->getMessage();
                    if (!$message) {
                        $message = __d('system', 'Cannot delete row #%s.', $key);
                    }
                    break;
                } else {
                    $this->Field->query('ALTER TABLE nodes DROP COLUMN field_' . $field['Field']['name']);
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
            $task = strtolower($this->request->data['Paginate']['task']);
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
