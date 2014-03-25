<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @package       ModuleName.Config
 * @since         Green v 1.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
  //Router::connect('/ajax-upload', array('plugin'=>'Node','controller' => 'Node', 'action' => 'admin_ajax_upload'));
 /*
 Router::connect('/gioi-thieu/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'about'));
 Router::connect('/linh-vuc-kinh-doanh/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'business'));
 Router::connect('/du-an/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'project'));
 Router::connect('/dai-ly/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'agency'));
 Router::connect('/hoat-dong-xa-hoi/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'social'));
  Router::connect('/hoat-dong-xa-hoi-chi-tiet/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'social_detail'));
 Router::connect('/tin-tuc-su-kien/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'news'));
 Router::connect('/hinh-anh/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'gallery'));
 Router::connect('/customer/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'customer_detail'));
  Router::connect('/tin-cong-ty-chi-tiet/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'news_company'));
  Router::connect('/tin-xa-hoi-chi-tiet/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'news_social'));
  Router::connect('/tin-tuyen-dung-chi-tiet/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'news_recruitment'));
  Router::connect('/tin-cong-ty/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'news_detail_company'));
  Router::connect('/tin-xa-hoi/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'news_detail_social'));
  Router::connect('/tin-tuyen-dung/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'news_detail_recruitment'));
  Router::connect('/hinh-anh-chi-tiet/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'gallery_detail'));
  Router::connect('/du-an-chi-tiet/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'project_detail'));
  Router::connect('/cam-on/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'contact_thanks'));
  Router::connect('/doi-tac-chi-tiet/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'customer_view'));
  Router::connect('/gioi-thieu-viet-huong/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'other_about'));
  Router::connect('/dai-ly-chi-tiet/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'agency_detail'));
  Router::connect('/tim-kiem/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'search_result'));
  Router::connect('/trang-tinh/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'static_page'));
  Router::connect('/san-pham-chi-tiet/*', array('plugin'=>'Node','controller' => 'Node', 'action' => 'business_detail'));
  */