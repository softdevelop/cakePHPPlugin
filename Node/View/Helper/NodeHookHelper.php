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
class NodeHookHelper extends AppHelper {

    /**
     * Block Hook
     *
     * @param array $block
     * @param array $params
     * @param array $options
     * 
     * @return void
     */
    public function block($block, $params, $options = array()) {
        $element = '';
        switch ($block['delta']) {
            case 'language': {
                    $element = 'language';
                    break;
                }
            case 'search': {
                    $element = 'search';
                    break;
                }
            case 'home': {
                    $element = 'home';
                    break;
                }
            case 'about': {
                    $element = 'about';
                    break;
                }
            case 'right': {
                    $element = 'right_content';
                    break;
                }
            case 'left': {
                    $element = 'left_content';
                    break;
                }
            case 'social': {
                    $element = 'social';
                    break;
                }
            case 'social_detail': {
                    $element = 'social_detail';
                    break;
                }    
            case 'banner': {
                    $element = 'banner';
                    break;
                }
           case 'slider': {
                    $element = 'slider';
                    break;
                } 
           case 'gallery': {
                    $element = 'gallery';
                    break;
                }
           case 'gallery_detail': {
                    $element = 'gallery_detail';
                    break;
                }     
           case 'footer_left': {
                    $element = 'footer_left';
                    break;
                }
            case 'footer_right': {
                    $element = 'footer_right';
                    break;
                }   
            case 'news': {
                    $element = 'news';
                    break;
                } 
           case 'news_detail_company': {
                    $element = 'news_detail_company';
                    break;
                } 
           case 'news_detail_recruitment': {
                    $element = 'news_detail_recruitment';
                    break;
                }
           case 'news_detail_social': {
                    $element = 'news_detail_social';
                    break;
                }          
           case 'news_company': {
                    $element = 'news_company';
                    break;
                } 
            case 'news_recruitment': {
                    $element = 'news_recruitment';
                    break;
                } 
             case 'news_social': {
                    $element = 'news_social';
                    break;
                }          
           case 'customer_detail': {
                    $element = 'customer_detail';
                    break;
                } 
           case 'contact_add': {
                    $element = 'contact_add';
                    break;
                }
           case 'contact_thanks': {
                    $element = 'contact_thanks';
                    break;
                } 
           case 'agency': {
                    $element = 'agency';
                    break;
                } 
          case 'project': {
                    $element = 'project';
                    break;
                } 
          case 'project_detail': {
                    $element = 'project_detail';
                    break;
                }   
           case 'business': {
                    $element = 'business';
                    break;
                }  
           case 'customer_view': {
                    $element = 'customer_view';
                    break;
                }   
           case 'other_about': {
                    $element = 'other_about';
                    break;
                }   
           case 'agency_detail': {
                    $element = 'agency_detail';
                    break;
                }  
           case 'static_page': {
                    $element = 'static_page';
                    break;
                } 
           case 'business_detail': {
                    $element = 'business_detail';
                    break;
                }                                                
                                
        }
        $block['content'] = $this->_View->element('Node.block' . DS . $element, compact('block', 'params'), $options);
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
            'Helper.Layout.Node.block' => 'block'
        );
    }

}
