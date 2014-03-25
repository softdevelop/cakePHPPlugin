<?php

/**
 * Node Controller.
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
App::uses('my_image', 'Vendor');
Class NodeController extends NodeAppController {

    /**
     * Use model class
     *
     * @var array
     */
    public $uses = array('Node.Node','Node.NodeTerm','Node.Term', 'Node.Gallery');

    /**
     * Use model class
     *
     * @var array
     */
    public $helpers = array('Text');
    /**
     * Called after the controller action.
     *
     * @return void
     */
    public function beforeRender() {
        parent::beforeRender();
        if (in_array($this->request['action'], array('admin_add', 'admin_edit'))) {
            $layouts = $this->Dashboard->get($this->Node, 'layouts');
            if (empty($layouts)) {
                $layouts = array(null, array_keys($this->Node->schema()));
            }
            $this->set('_layouts', $layouts);
        }
        if (in_array($this->request['action'], array('admin_reply'))) {
            $layouts = $this->Dashboard->get($this->Node, 'layouts_reply');
            if (empty($layouts)) {
                $layouts = array(null, array_keys($this->Node->schema()));
            }
            $this->set('_layouts', $layouts);
        }
    }
    
    public function beforeFilter() {
        // open new
        parent::beforeFilter();
        if (in_array($this->request['action'], array('delete_image', 'reply','admin_list_index'))) {
            $this->Components->disable('Security');
            
        }
    }

    /**
     * Management data
     *
     * @return void
     */
    public function admin_index() {
         $_paginate = array(
            'order' => array('id' => 'desc'),
            'fields' => array('id')
        );
        $conditions = $this->Dashboard->parseRequest($this->Node, $_paginate, array('title'));
        $listNodes = $this->paginate();
        $nodeTypes = $this->Node->NodeType->find('list');
        $users = $this->Node->User->find('list');

        $this->Dashboard->translateMaps($this->Node, $listNodes);
        $this->Dashboard->toolbar(__d('system', 'Content management'), array(
          //  'add' => array('action' => 'add', 'text' => __d('system', 'Add')),
            'edit' => array('action' => 'edit', 'text' => __d('system', 'Edit')),
            'remove' => array('action' => 'removes', 'text' => __d('system', 'Delete'))
        ));
        if (!empty($this->data['Paginate'])) {
            $data = array_merge(array('task' => '', 'id' => array(0)), $this->data['Paginate']);
            switch (strtolower($data['task'])) {
                case 'add': {
                        $this->Dashboard->redirect(array('plugin'=>'node','controller'=>'node','action' => 'add', $data['id'][0]));
                    }
                case 'edit': {
                        $this->Dashboard->redirect(array('plugin'=>'node','controller'=>'node','action' => 'edit', $data['id'][0]));
                    }
                case 'remove': {
                        $this->Dashboard->redirect(array('plugin'=>'node','controller'=>'node','action' => 'delete', '?' => array('keys' => $data['id'])));
                    }
            }
        }
        //debug($list_node_types);
        $this->set(compact('listNodes','nodeTypes','users'));
    }
    /**
     * Management data
     *
     * @return void
     */
    public function admin_list_index($id = null) {
        //pr($this->data);exit();
         $_paginate = array(
            'order' => array('created' => 'desc'),
            'fields' => array('id'),
            'conditions'=>array('node_type_id'=>$id)            
        );
        $conditions = $this->Dashboard->parseRequest($this->Node, $_paginate, array('title'));
        $listNodes = $this->paginate();
        $nodeTypes = $this->Node->NodeType->find('list');
        $users = $this->Node->User->find('list');
        $list_names = $this->Node->NodeType->find('first',array(
        'conditions'=>array('id'=>$id),
        'locale'=>true,
        'fields'=>array('NodeType.id','NodeType.name'),
    ));
        $this->Dashboard->translateMaps($this->Node, $listNodes);

        $this->Dashboard->toolbar(__d('system', 'Content management'), array(
            'add' => array('action' => 'add', 'text' => __d('system', 'Add New')),
            'edit' => array('action' => 'edit', 'text' => __d('system', 'Edit')),
            'remove' => array('action' => 'removes', 'text' => __d('system', 'Delete'))
        ));
        //pr($this->data);exit();
        if (!empty($this->data['Paginate'])) {
    
            $data = array_merge(array('task' =>$id, 'id' => array(0)), $this->data['Paginate']);
            switch (strtolower($data['task'])) {
                case 'add': {
                        $this->Dashboard->redirect(array('plugin'=>'node','controller'=>'node','action' => 'add',$id));
                    }
                case 'edit': {
                        $this->Dashboard->redirect(array('plugin'=>'node','controller'=>'node','action' => 'edit', $id));
                    }
                case 'remove': {
                        $this->Dashboard->redirect(array('plugin'=>'node','controller'=>'node','action' => 'delete', '?' => array('keys' => $id)));
                    }
            }
        }
        //debug($list_node_types);
        $this->set(compact('listNodes','nodeTypes','users','id','list_names'));
    }
    /**
     * Add data
     *
     * @return void
     */
    public function admin_add($typeId = null, $id = null) {
        if (empty($typeId)) {
            $this->Dashboard->exists($this->Node->NodeType, $typeId, false);
            $this->Dashboard->toolbar(__d('system', 'Add new Content'), array());
            $listTypes = $this->Node->NodeType->find('all', array('fields' => array('id', 'name', 'type')));
            $this->set(compact('listTypes', 'typeId'));
        } else {
            $this->loadModel('Node.Field');
            $fields = $this->Field->find('all', array('recursive' => -1, 'order' => 'id ASC', 'conditions' => array('type_id' => $typeId)));
            if (!empty($fields)) {
                foreach ($fields as &$field) {
                    $field['Field']['params'] = unserialize($field['Field']['params']);
                }
            }
            $this->loadModel('Node.Term');
            $list_terms = $this->Term->generateTreeList(array('Term.type_id' => $typeId), null, null, '&nbsp;&nbsp;&nbsp;|-&nbsp;');
            if($typeId== 245||$typeId== 252){//nurseries
                    //list images
                    $this->set('images', 'images');

               }
            $this->set(compact('list_terms'));
            $user = $this->Auth->user();
            $type = $this->Node->NodeType->findById($typeId);
            $this->Dashboard->exists($this->Node, $id, false);
            $this->Dashboard->toolbar(__d('system', 'Add new Content'), array(
                'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
                'next' => array('action' => 'save', 'text' => __d('system', 'Save & Add New')),
                'cancel' => __d('system', 'Cancel')
            ));
            if (!empty($this->request->data)) {
                
                $this->Node->create();
                $task = strtolower($this->data['Paginate']['task']);
                if (!$task || $task === 'cancel') {
                    $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
                } elseif (!empty($this->request->data)) {
                    $data= $this->request->data;
                    if($typeId== 45||$typeId== 52){//projects
                        $image_rels= $data['ProImage'];
                    }   
                    if ($this->Node->save($this->request->data)) {
                        if (!empty($this->request->data['Node']['term_id'])) {
                            $term = array();
                            $term['NodeTerm']['node_id'] = $this->Node->id;
                            $term['NodeTerm']['term_id'] = $this->request->data['Node']['term_id'];
                            $this->Node->NodeTerm->save($term);
                        }
                    }
                        if(!empty($image_rels)){
                            $id= $this->Node->id;
                            $images= $image_rels;
                            foreach($images as $key=> $value){
                                if(!empty($value)){
                                    $this->Gallery->create();
                                    $gallery['Gallery']['node_id']= $id;
                                    $gallery['Gallery']['path']= $value;
                                    $this->Gallery->save($gallery);
                                }
                            }
                        }
                        if(!empty($polls)){
                            $id= $this->Node->id;
                            foreach($polls as $key=> $value){
                                if(!empty($value)){
                                    //save into table gallegies
                                    $this->Question->create();
                                    $poll['Question']['node_id']= $id;
                                    $poll['Question']['name']= $value;
                                    $this->Question->save($poll);
                                }
                            }
                        }
                    $this->setFlash(__d('system', 'The %s has been saved', __d('system', 'Node')), 'success');
                    switch ($task) {
                        case 'next': {
                                $this->redirect($this->request->here(false));
                            }
                        case 'apply': {
                                $this->Dashboard->redirect(array('action' => 'edit', $this->Node->getInsertID()), false, true);
                            }
                    }

                    $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
                } else {
                    $this->setFlash(__d('system', 'The %s could not be saved. Please, try again.', __d('system', 'Node')), 'error');
                }
            } elseif ($id) {
                $this->request->data = $this->Node->find('first', array('conditions' => array('Node.id' => $id), 'recursive' => -1));
            }
            $this->set(compact('id', 'user', 'type', 'fields', 'layoutFields', 'fields', 'typeId'));
        }
    }

    /**
     * Edit data
     *
     * @return void
     */
    public function admin_edit($typeId, $id = null) {
        $this->Dashboard->exists($this->Node, $id);
        $this->Dashboard->toolbar(__d('system', 'Edit Node #%s', $id), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'remove' => array('action' => 'remove', 'text' => __d('system', 'Delete')),
            'cancel' => __d('system', 'Cancel')
        ));
        $datas = $this->Node->find('first', array('conditions' => array('Node.id' => $id)));
        $this->loadModel('Node.Field');
        $fields = $this->Field->find('all', array('recursive' => -1, 'order' => 'id ASC', 'conditions' => array('type_id' => $typeId)));
        if (!empty($fields)) {
            foreach ($fields as &$field) {
                $field['Field']['params'] = unserialize($field['Field']['params']);
            }
        }
        $this->loadModel('Node.Term');
        $listTerms = $this->Term->generateTreeList(array('Term.type_id' => $typeId), null, null, '&nbsp;&nbsp;&nbsp;|-&nbsp;');
        if($typeId== 45||$typeId== 52){//nurseries
                //list images
                $this->set('images', 'images');
                $galleries= $this->Gallery->find('list', array(
                    'conditions'=> array('Gallery.node_id'=> $id),
                    'fields'=> array('Gallery.id', 'Gallery.path')
                ));
                $this->set('galleries', $galleries);
            }
        
        $nodeTerm = $this->Node->NodeTerm->find('first', array('conditions' => array('NodeTerm.node_id' => $id)));
        $this->set(compact('listTerms', 'nodeTerm'));
        if (!empty($this->request->data)) {
            $task = strtolower($this->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif ($this->Node->save($this->request->data)) {
               
                $data= $this->request->data;
                    if($typeId== 45||$typeId== 52){//projects
                        $image_rels= $data['ProImage'];
                    }

                        if(!empty($image_rels)){
                            $id= $this->Node->id;
                            $images= $image_rels;
                            foreach($images as $key=> $value){
                                if(!empty($value)){
                                    $this->Gallery->create();
                                    $gallery['Gallery']['node_id']= $id;
                                    $gallery['Gallery']['path']= $value;
                                    $this->Gallery->save($gallery);
                                }
                            }
                        }
                if (!empty($this->request->data['Node']['term_id'])) {
                    $term = array();
                    $term['NodeTerm']['id'] = $this->request->data['Node']['node_term_id'];
                    $term['NodeTerm']['node_id'] = $id;
                    $term['NodeTerm']['term_id'] = $this->request->data['Node']['term_id'];
                    $this->Node->NodeTerm->save($term);
                }else{
                    $this->NodeTerm->id = $this->request->data['Node']['node_term_id'];
                    $this->NodeTerm->delete();
                }
                if ($task !== 'remove') {
                    $this->setFlash(__d('system', 'The %s has been updated', __d('system', 'Node')), 'success');
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
                $this->setFlash(__d('system', 'The %s could not be updated. Please, try again.', __d('system', 'Node')));
            }
        } else {
            $this->request->data = $this->Node->find('first', array('conditions' => array('Node.id' => $id)));
        }
        $this->set(compact('id', 'fields','typeId','datas'));
    }

    /**
     * Delete data
     *
     * @return void
     */
    public function admin_delete() {
        $this->layout = null;
        if (empty($this->request->query['keys'])) {
            $this->setFlash(__d('system', 'Select elements should be deleted from the list below!', __d('system', 'Node')));
        } else {
            $complete = 0;
            $message = null;
            $keys = (array) $this->request->query['keys'];
            foreach ($keys as $key) {
                if (!$this->Node->delete($key)) {
                    $message = $this->Node->getMessage();
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
            $this->setFlash(__d('system', 'The %1$s has been deleted %2$s / %3$s rows.', __d('system', 'Node'), $complete, count($keys)) . $message, 'warning');
        }
        $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
    }

    /**
     * Translate data
     *
     * @return void
     */
    public function admin_translate($id = null, $language = null) {
        $this->Dashboard->exists($this->Node, $id);
        $this->Dashboard->toolbar(__d('system', 'Translate Node #%s', $id), array(
            'save' => array('action' => 'save', 'text' => __d('system', 'Save')),
            'remove' => array('action' => 'remove', 'text' => __d('system', 'Remove')),
            'cancel' => __d('system', 'Cancel')
        ));
        $locale = $this->Dashboard->getLocale($language);
        if (empty($locale)) {
            $this->setFlash(__d('system', 'The language code <b>%s</b> does not exist', $language));
        }
        $translateFields = $this->Dashboard->translateFields($this->Node);
        if (empty($translateFields)) {
            $this->setFlash(__d('system', 'The %s not be configured a multilingual', __d('system', 'Node')));
        }
        if (empty($locale) || empty($translateFields)) {
            $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
        }
        $this->Node->locale = $locale;
        if ($this->request->is('post')) {
            $task = strtolower($this->data['Paginate']['task']);
            if (!$task || $task === 'cancel') {
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } elseif ($this->Node->translate($this->request->data)) {
                if ($task !== 'remove') {
                    $this->setFlash(__d('system', 'The %s has been translated', __d('system', 'Node')), 'success');
                } else {
                    $this->Dashboard->removeTranslated($this->Node);
                    $this->setFlash(__d('system', 'The translated data of %s has been removed', __d('system', 'Node')), 'success');
                }
                switch ($task) {
                    case 'remove':
                    case 'apply': {
                            $this->redirect($this->request->here(false));
                        }
                }
                $this->Dashboard->redirect(array('action' => 'index', 'ext' => false), true);
            } else {
                $this->setFlash(__d('system', 'The %s could not be translated. Please, try again.', __d('system', 'Node')));
            }
        }
        $node = $this->Dashboard->getTranslated($this->Node, $translateFields);
        $this->set(compact('locale', 'language', 'node', 'id'));
    }
    //delete image 
    public function delete_image($id){
        $this->layout= 'ajax';
        $this->autoRender = false;
        $this->Gallery->id = $id;
        $this->Gallery->delete();
    }
    
    //ajaxfile upload image
    public function admin_upload(){
        Configure::write('debug', 3);
        if(isset($_SERVER["CONTENT_LENGTH"])){
            print_r($_SERVER["CONTENT_LENGTH"]);
            //die;
        }
        $this->autoRender = false;
        App::uses('qqFileUploader','Vendor');
        
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array();
        
        // max file size in bytes
        $sizeLimit = 24 * 1024 * 1024;
        $uploaddir = WWW_ROOT.'img\nurseries\\';

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        
        $result = $uploader->handleUpload($uploaddir);
        // to pass data through iframe you will need to encode all html tags
        
        
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        exit;

    }
}

?>
