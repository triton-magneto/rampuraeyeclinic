<?php
/**
 * IceMegaMenu Extension for Joomla 1.6 By IceTheme
 * 
 * 
 * @copyright	Copyright (C) 2008 - 2011 IceTheme.com. All rights reserved.
 * @license		GNU General Public License version 2
 * 
 * @Website 	http://www.icetheme.com/Joomla-Extensions/icemegamenu.html
 * @Support 	http://www.icetheme.com/Forums/IceMegaMenu/
 *
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemIcemegamenu extends JPlugin
{    
	var $plugin 	= null;
	var $plgParams 	= null;
	var $time 		= 0;
    
    function __construct(&$subject, $config)
	{      
        parent::__construct($subject, $config);
    }
    
    function onContentPrepareForm($form, $data)
    {           
        if($form->getName() == 'com_menus.item')
		{            
			if(!defined("DS")){
				define("DS", DIRECTORY_SEPARATOR);
			}
            $xmlFile = dirname(__FILE__). DS."icemegamenu" . DS . 'params';
            JForm::addFormPath($xmlFile);
            $form->loadFile('params', false); 
        }
    }
    public function onAfterRender()
    {
        $app = JFactory::getApplication();
        $itemid   = $app->input->getCmd('Itemid', '');
        //echo $itemid;
        $body = JFactory::getApplication()->getBody(false);
        $regex = "@<a[^>]*href=[\"\']#([^\"\']*)[\"\'][^>]*class=[\"\'][^>]*iceMenuTitle[^>]*[\"\'][^>]*data-anchor=[\"\']([^\"\']*)[\"\'][^>]*>@";
        preg_match_all($regex, $body, $matches);
        if(!empty($matches[2])){
            foreach($matches[2] as $key => $match){
                $el = "@<div[^>]*id=[\"\'][^>]*".$match."[^>]*[\"\'][^>]*>@";
                preg_match_all($el, $body, $el_matches);
                if(!empty($el_matches[0])){
                    $elem = $el_matches[0][0] . '<a name="' . $matches[1][$key] . '"></a>';
                    //var_dump($el_matches[0][0]);
                    $body = str_replace($el_matches[0][0], $elem, $body);
                }
            }
            JFactory::getApplication()->setBody($body);
        }
    }

}