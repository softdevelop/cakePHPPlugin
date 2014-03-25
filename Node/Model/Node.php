<?php

App::uses('AppModel', 'Model');

/**
 * Node Model
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
class Node extends AppModel {

    /**
     * List of behaviors
     *
     * @var array
     */
    public $actsAs = array(
        'Translator',
         'CreateAlias' => array(
            'label' => 'title',
            'alias' => 'alias'
         )
    );

    /**
     * Defined fields using for I18n
     * 
     * @var array
     */
    public $translateFields = array('title', 'field_body', 'field_description');

    /**
     * Defined to load the config file stored.
     *
     * @var string
     */
    public $configKey = 'Node';

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
        'title' => array(
            'notempty' => array(
                'allowEmpty' => false,
                'rule' => 'notempty',
                'message' => 'This is a required information',
                'on' => 'create',
                'required' => true
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Name of Node already exists please choose another name.'
            )
        ),
        'enabled' => array(
            'boolean' => array(
                'allowEmpty' => true,
                'rule' => 'boolean',
                'message' => 'Incorrect value for this field'
            )
        ),
        'node_type_id' => array(
            'notempty' => array(
                'allowEmpty' => false,
                'rule' => 'notempty',
                'message' => 'This is a required information',
                'on' => 'create',
                'required' => true
            )
        ),
        'user_id' => array(
            'notempty' => array(
                'allowEmpty' => false,
                'rule' => 'notempty',
                'message' => 'This is a required information',
                'on' => 'create',
                'required' => true
            )
        )
    );

    /**
     * belongsTo associations.
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User.User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => ''
        ),
        'NodeType' => array(
            'className' => 'Node.NodeType',
            'foreignKey' => 'node_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => ''
        )
    );

    /**
     * hasMany associations.
     *
     * @var array
     */
    public $hasMany = array(
        'NodeTerm' => array(
            'className' => 'Node.NodeTerm',
            'foreignKey' => 'node_id',
            'dependent' => true
        )
    );

}

?>