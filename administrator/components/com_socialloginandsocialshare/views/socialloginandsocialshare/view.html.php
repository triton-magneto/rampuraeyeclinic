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
defined ('_JEXEC') or die ('Restricted access');
jimport ('joomla.application.component.view');
if(!class_exists('SLASSViewSettings')){
    if(class_exists('JViewLegacy')){
        class SLASSViewSettings extends JViewLegacy{}
    }
    else{
        class SLASSViewSettings extends JView{}
    }
}
/**
 * Class generate view.
 */
class SocialLoginAndSocialShareViewSocialLoginAndSocialShare extends SLASSViewSettings
{
	public $settings;
	
	/**
	 * SocialLogin - Display administration area
	 */
	public function display ($tpl = null)
	{
		$document = JFactory::getDocument ();
		$document->addStyleSheet ('components/com_socialloginandsocialshare/assets/css/socialloginandsocialshare.css');
		$model = $this->getModel ();
		$this->settings = $model->getSettings ();
     	$this->form = $this->get ('Form');
		$this->addToolbar ();
        parent::display ($tpl);
	}

	
	/**
	 * SocialLogin - Add admin option on toolbar
	 */
	protected function addToolbar ()
	{
		JRequest::setVar ('hidemainmenu', false);
		JToolBarHelper::title (JText::_ ('COM_SOCIALLOGINANDSOCIALSHARE_CONFIGURATION_TITLE'), 'configuration.gif');
		JToolBarHelper::apply ('apply');
		JToolBarHelper::save($task = 'save', $alt = 'JTOOLBAR_SAVE');
		JToolBarHelper::cancel ('cancel');
	}
}