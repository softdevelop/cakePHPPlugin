<?php

App::uses('AppModel', 'Model');

/**
 * Role Model
 * 
 * PHP versions 5
 * CAKEPHP versions 2.x
 * 
 * TvPanel - Admin Control Panel Powerfull Cakephp Framework
 * Copyright 2011, Tien Van Vo <vantienvnn@gmail.com>
 * 
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        Tien Van Vo <vantienvnn@gmail.com>
 * @link          
 * @package       Tvpanel
 * @subpackage    Tvpanel.Model
 * @since         TvPanel v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * @property UserRole $UserRole
 */
class Role extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Defined to load the config file stored.
     *
     * @var string
     */
    public $configKey = 'Role';

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
        'name' => array(
            'notempty' => array(
                'allowEmpty' => false,
                'rule' => 'notempty',
                'message' => 'This is a required information',
                'on' => 'created',
                'required' => true
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Name already exists please choose another name.'
            )
        )
    );

    /**
     * hasMany associations.
     *
     * @var array
     */
    public $hasMany = array(
        'UserRole' => array(
            'className' => 'User.UserRole',
            'foreignKey' => 'role_id',
            'dependent' => true
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed
    /**
     * Before delete callback
     *
     * Check core role will be delete
     *
     * @return boolean true if not found core role , fasle on found
     */
    public function beforeDelete($cascade = true) {
        if (in_array($this->id, $this->roleMap())) {
            return false;
        }
        return parent::beforeDelete($cascade);
    }

    /**
     * Wrap User roleMap
     * 
     * @param key to get
     * @return array
     */
    public function roleMap($key = null) {
        return $this->UserRole->User->roleMap($key);
    }

}

?>