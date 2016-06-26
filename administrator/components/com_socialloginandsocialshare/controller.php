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

/**
 * Controller of SocialLogin component.
 */
class SocialLoginAndSocialShareController extends SLASSController
{
	protected static $actions;
	public function display ($cachable = false, $urlparams = false)
	{
		JRequest::setVar ('view', JRequest::getCmd('view', 'SocialLoginAndSocialShare'));
		parent::display ($cachable);
	}

	/**
	 * Save settings
	 */
	public function apply ()
	{
	    $mainframe = JFactory::getApplication();
		$model = $this->getModel ();
		$input = JFactory::getApplication()->input;
		$view   = $input->get('view', 'socialloginandsocialshare');
		$option   = $input->get('option', 'socialloginandsocialshare');
		$model->saveSettings($view);
		$mainframe->enqueueMessage (JText::_ ('COM_SOCIALLOGIN_SETTING_SAVED'));
		$this->setRedirect (JRoute::_ ('index.php?option='.$option.'&view='.$view.'&layout=default', false));
	}
	
	/**
	 * Save and close settings
	 */
	public function save()
	{  
	    $mainframe = JFactory::getApplication();
		$model = &$this->getModel();
		$input = JFactory::getApplication()->input;
		$view   = $input->get('view', 'socialloginandsocialshare');
		$model->saveSettings ($view);
		$mainframe->enqueueMessage (JText::_ ('COM_SOCIALLOGIN_SETTING_SAVED'));	
        $this->setRedirect (JRoute::_ ('index.php', false));
	}
	
	/**
	 * cancel settings
	 */
	
	public function cancel ()
	{
		$this->setRedirect (JRoute::_ ('index.php', false));
	}	
	
}
