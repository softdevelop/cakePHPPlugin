<?php

/**
 * Block View
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
 * @package       Block.View.Element
 * @since         Green v 1.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php

$element = '';
switch ($block['delta']) {
    case 'footer': {
            $element = 'footer';
            break;
        }
}
$block['content'] = $this->element('Node.Block' . DS . $block['delta'], compact('block'));
echo $this->element('User.block', compact('block'));
?>