<?php

App::uses('AppModel', 'Model');

/**
 * NodeType Model
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
 * @package       Green.Model
 * @since         Green v 1.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * @property Role $Role
 */
class NodeType extends AppModel {

    /**
     * List of behaviors
     *
     * @var array
     */
    public $actsAs = array(
        'Translator'
    );

    /**
     * Defined fields using for I18n
     * 
     * @var array
     */
    public $translateFields = array('name');

    /**
     * Defined to load the config file stored.
     *
     * @var string
     */
    public $configKey = 'NodeType';

    /**
     * Timestamp Unix maps.
     *
     * @var array
     */
    public $timestamp = array(
        'created' => 'datetime',
        'updated' => 'datetime'
    );

    /**
     * Validation rules.
     *
     * @var array
     */
    public $validate = array(
        'type' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Name of Type already exists please choose another name.'
            )
        ),
        'name' => array(
            'notempty' => array(
                'allowEmpty' => false,
                'rule' => 'notempty',
                'message' => 'This is a required information',
                'on' => 'create',
                'required' => true
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Name of Type already exists please choose another name.'
            )
        ),
        'enabled' => array(
            'boolean' => array(
                'allowEmpty' => true,
                'rule' => 'boolean',
                'message' => 'Incorrect value for this field'
            )
        )
    );

    /**
     * hasMany associations.
     *
     * @var array
     */
    public $hasMany = array(
        'Node' => array(
            'className' => 'Node.Node',
            'foreignKey' => 'node_type_id',
            'dependent' => true
        ),
        'Term' => array(
            'className' => 'Node.Term',
            'foreignKey' => 'type_id',
            'dependent' => true
        ),
        'Field' => array(
            'className' => 'Node.Field',
            'foreignKey' => 'type_id',
            'dependent' => true
        )
    );

    /**
     * Before save callback
     *
     * Hash password
     *
     * @return boolean
     */
    public function beforeSave($options = array()) {
        if (!empty($this->data['NodeType']['name'])) {
            $this->data['NodeType']['type'] = Inflector::slug($this->data['NodeType']['name']);
        }
        return parent::beforeSave($options);
    }
}
?>