<?php
/*------------------------------------------------------------------------
# mod_SocialLoginandSocialShare
# ------------------------------------------------------------------------
# author    LoginRadius inc.
# copyright Copyright (C) 2013 loginradius.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.loginradius.com
# Technical Support:  Forum - http://community.loginradius.com/
-------------------------------------------------------------------------*/

 // no direct access
defined ('_JEXEC') or die ('Direct Access to this location is not allowed.');
jimport ('joomla.application.component.controller');
if(!class_exists('SLASSController')){
    if(class_exists('JControllerLegacy')){
        class SLASSController extends JControllerLegacy{}
    }
    else{
        class SLASSController extends JController{}
    }
}
// Get an instance of the controller
$controller = SLASSController::getInstance ('SocialLoginAndSocialShare');

// Perform the requested task
$controller->execute (JRequest::getCmd ('task', 'display'));

// Redirect if set by the controller
$controller->redirect ();
