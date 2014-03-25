<?php

/**
 * User Hook helps create page view.
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
 * @package       Node.Helper
 * @since         Green v 1.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class NodeFieldHookHelper extends AppHelper {

    protected $_hasLib = false;

    /**
     * Block Hook
     *
     * @param array $block
     * @param array $params
     * @param array $options
     * 
     * @return void
     */
    public function input($fieldName, $options = array()) {
        if (isset($options['type']) && $options['type'] === 'file') {
            $options['type'] = 'text';
            $options['class'] = isset($options['class']) ? (array) $options['class'] : array();
            $options['class'][] = 'file-upload';
            $this->_includeLib();
        }
    }

    /**
     * Returns a list of events this object is implementing, when the class is registered
     * in an event manager, each individual method will be associated to the respective event.
     *
     * @return array associative array or event key names pointing to the function
     * that should be called in the object when the respective event is fired
     */
    public function implementedEvents() {
        return array(
            'Helper.Form.input' => 'input'
        );
    }

    /**
     * Returns a list of events this object is implementing, when the class is registered
     * in an event manager, each individual method will be associated to the respective event.
     *
     * @return array associative array or event key names pointing to the function
     * that should be called in the object when the respective event is fired
     */
    protected function _includeLib() {
        if ($this->_hasLib) {
            return;
        }
        $this->_hasLib = true;
        $this->_View->Html->script(array('elfinder/js/elfinder.min', 'elfinder/js/i18n/elfinder.vi', '/js/modules/elfinder'), array('inline' => false));
        $this->_View->Html->css(array('../js/elfinder/css/theme.css', '../js/elfinder/css/elfinder.min'), null, array('inline' => false));
    }

}
