<?php

App::uses('AppModel', 'Model');

/**
 * NodeTerm Model
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
class NodeTerm extends AppModel {
    /**
     * Defined to load the config file stored.
     *
     * @var string
     */
    public $configKey = 'NodeTerm';

    /**
     * Validation rules.
     *
     * @var array
     */
    public $validate = array(
        'node_id' => array(
            'notempty' => array(
                'allowEmpty' => false,
                'rule' => 'notempty',
                'message' => 'This is a required information',
                'on' => 'create',
                'required' => true
            ),
        ),
        'term_id' => array(
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
        'Node' => array(
            'className' => 'Node.Node',
            'foreignKey' => 'node_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => ''
        ),
        'Term' => array(
            'className' => 'Node.Term',
            'foreignKey' => 'term_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => ''
        )
    );
}

?>