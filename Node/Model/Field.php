<?php

App::uses('AppModel', 'Model');

/**
 * Field Model
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
class Field extends AppModel {

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
    public $translateFields = array('params');

    /**
     * Defined to load the config file stored.
     *
     * @var string
     */
    public $configKey = 'Field';
    
    /**
     * Validation rules.
     *
     * @var array
     */
    public $validate = array(
        'label' => array(
            'notempty' => array(
                'allowEmpty' => false,
                'rule' => 'notempty',
                'message' => 'This is a required information',
                'on' => 'create',
                'required' => true
            )
        ),
        'name' => array(
            'notempty' => array(
                'allowEmpty' => false,
                'rule' => 'notempty',
                'message' => 'This is a required information',
                'on' => 'create',
                'required' => true
            )
        ),
        'type_id' => array(
            'notempty' => array(
                'allowEmpty' => false,
                'rule' => 'notempty',
                'message' => 'This is a required information',
                'on' => 'create',
                'required' => true
            )
        ),
        'field_type' => array(
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
        'NodeType' => array(
            'className' => 'Node.NodeType',
            'foreignKey' => 'type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => ''
        )
    );
}

?>