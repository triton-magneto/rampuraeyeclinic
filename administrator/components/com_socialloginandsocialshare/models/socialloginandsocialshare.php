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
jimport ('joomla.application.component.modellist');

/**
 * SocialLoginAndSocialShare Model.
 */
 
class SocialLoginAndSocialShareModelSocialLoginAndSocialShare extends JModelList
{
	/**
	 * Save Settings.
	 */
	public function saveSettings ()
	{
		$db = $this->getDbo ();
        $mainframe = JFactory::getApplication();
		//Get database handle
		//Read Settings
			$settings = JRequest::getVar ('settings');
			$articles = JRequest::getVar ('articles');
			$settings['articles'] = (sizeof($articles) > 0 ? serialize($articles) : "");
			$sql = "DELETE FROM #__loginradius_settings";
			$db->setQuery ($sql);
			$db->query ();
		  
			//Insert new settings
			foreach ($settings as $k => $v){
			  $sql = "INSERT INTO #__loginradius_settings ( setting, value )" . " VALUES ( " . $db->Quote ($k) . ", " . $db->Quote ($v) . " )";
			  $db->setQuery ($sql);
			  $db->query ();
		 }
	}
	/**
	 * Read Settings
	 */
	public function getSettings()
	{
		$settings = array ();
        $db = $this->getDbo();
		$sql = "CREATE TABLE IF NOT EXISTS  `#__loginradius_settings` (
				`id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
				`setting` VARCHAR( 255 ) NOT NULL ,
				`value` VARCHAR( 1000 ) NOT NULL ,
				PRIMARY KEY (  `id` ) ,
				UNIQUE KEY  `setting` (  `setting` )
				) ENGINE = MYISAM DEFAULT CHARSET = utf8";
		$db->setQuery ($sql);
		$db->query ();
		$sql = "CREATE TABLE IF NOT EXISTS  `#__loginradius_users` (
				`id` int(11),
				`loginradius_id` varchar(255) NULL,
				`provider` varchar(255) NULL,
				`lr_picture` varchar(255) NULL
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
		$db->setQuery ($sql);
		$db->query ();
		$sql = "SELECT * FROM #__loginradius_settings";
		$db->setQuery ($sql);
		$rows = $db->LoadAssocList();
		if (is_array ($rows))
		{
			foreach ($rows AS $key => $data)
			{
				$settings [$data['setting']] = $data ['value'];				
			}
		}
		return $settings;
	}
 }