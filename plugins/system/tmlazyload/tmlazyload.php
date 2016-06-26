<?php
/**
 * @Copyright
 * @package     TM Lazy Load
 * @author      TemplateMonster
 * @version     1.1.4
 * @link        http://www.templatemonster.com/
 *
 * @license     GNU/GPL
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');

require_once dirname(__FILE__).DS.'HTML5'.DS.'Parser.php';

class PlgSystemTmLazyLoad extends JPlugin
{
    protected $_execute;

    function __construct(&$subject, $config)
    {
        // First check whether version requirements are met for this specific version
        if($this->checkVersionRequirements(false, '3.2', 'TM Lazy Load', 'plg_system_tmlazyload', JPATH_ADMINISTRATOR))
        {
            parent::__construct($subject, $config);
            $this->loadLanguage('', JPATH_ADMINISTRATOR);
            $this->_execute = true;
        }
    }

    /**
     * Do all checks whether the plugin has to be loaded and load needed JavaScript instructions
     */
    public function onBeforeCompileHead()
    {
        if($this->params->get('exclude_editor'))
        {
            if(class_exists('JEditor', false))
            {
                $this->_execute = false;
            }
        }

        if($this->params->get('exclude_bots') AND $this->_execute == true)
        {
            $this->excludeBots();
        }

        if($this->params->get('exclude_components') AND $this->_execute == true)
        {
            $this->excludeComponents();
        }

        if($this->params->get('exclude_urls') AND $this->_execute == true)
        {
            $this->excludeUrls();
        }

        if($this->_execute == true)
        {
            JHtml::_('jquery.framework');

            $doc = JFactory::getDocument();
            $document =& $doc;

            $document->addScript(JURI::base() . 'plugins/system/tmlazyload/tmlazyload.js');
            $document->addScriptDeclaration('
                jQuery(function($) {
                    $("img.lazy").lazy({
                        threshold: 200,
                        visibleOnly: false,
                        effect: "show",
                        effectTime: 0,
                        throttle: 500,
                        beforeLoad: function(element) {
                            element.unwrap();
                            element.next().remove();
                        },
                        afterLoad: function(element) {
                            setTimeout(function(){
                                element.removeClass("lazy");
                                if(typeof $.fn.BlackAndWhite_init == "function"){
                                    jQuery(element).parent("a").BlackAndWhite_init();
                                }
                            },100)
                        },
                        onError: function(element) {
                            alert("image "+element.attr(\'src\')+" not exist");
                        }
                    });
                });
            ');
        }
    }

    /**
     * Trigger onAfterRender executes the main plugin procedure
     */
    public function onAfterRender()
    {

        if(JFactory::getApplication()->input->getWord('view')=='image'){
            $this->_execute = false;
        }
        if($this->_execute == true)
        {
            $exclude_image_names = array_map('trim', explode("\n", $this->params->get('exclude_imagenames')));
            $exclude_imagenames_toggle = $this->params->get('exclude_imagenames_toggle');
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $body = JFactory::getApplication()->getBody(false);
            $dom = HTML5_Parser::parse($body);
            foreach($dom->getElementsByTagName('img') as $img) 
            {
                $src = $img->getAttribute('src');
                $img_name = parse_url($src);
                $img_name = $img_name['path'];
                $img_name = explode('/', $img_name);
                $img_name = end($img_name);
                if(count($exclude_image_names)){
                    $continue = false;
                    if($exclude_imagenames_toggle == 0){
                        foreach($exclude_image_names as $exclude_image_name){
                            if($exclude_image_name != '' && strpos($img_name, $exclude_image_name)===0){
                                $continue = true;
                            }
                        }
                    }
                    else{
                        $continue = true;
                        foreach($exclude_image_names as $exclude_image_name){
                            if($exclude_image_name != '' && strpos($img_name, $exclude_image_name)===0){
                                $continue = false;
                            }
                        }
                    }
                    if ($continue === true){
                        continue;
                    }
                }
                $attributes = array();
                foreach($img->attributes as $attribute_name => $attribute_node)
                {
                  $attributes[$attribute_name] = $attribute_node->nodeValue;
                }
                $host = parse_url($src);
                if(isset($host['host']) && ($host['host'] == $_SERVER['SERVER_ADDR'] || $host['host'] == $_SERVER['SERVER_NAME'])) {
                    $src = str_replace(JURI::base(), '', $src);
                }
                if(!array_key_exists('host',parse_url($src)) && ini_get('allow_url_fopen') ) {
                    $src = str_replace(JURI::base(true).'/', '', $src);
                    $size = @getimagesize($src);
                    if($size){
                        $width = $size[0];
                        $height = $size[1]; 
                        if(!array_key_exists('width',$attributes) || $attributes['width']==0 || $attributes['width']==''){
                            $img->setAttribute('width',''.$width);
                        }
                        if(!array_key_exists('height',$attributes) || $attributes['height']==0 || $attributes['height']==''){
                            $img->setAttribute('height',''.$height);
                        }
                        $wrapper = $dom->createElement('span','');
                        $wrapper = $img->parentNode->insertBefore($wrapper, $img);
                        $wrapper->setAttribute('class','lazy_preloader');
                        $img->parentNode->removeChild($img);
                        $wrapper->appendChild($img);
                        $wrapper_inner = $dom->createElement('span','');
                        $wrapper->appendChild($wrapper_inner);
                        $wrapper_inner->setAttribute('class','lazy_preloader_inner');
                        $wrapper_inner->setAttribute('style','width: '.$width.'px; padding-top: '.(100*$height/$width).'%;');
                    }
                }
                if(array_key_exists('class',$attributes)){
                    $img->setAttribute('class', $attributes['class'].' lazy');
                }
                else{
                    $img->setAttribute('class','lazy');
                }
                $img->setAttribute('data-src',''.$img->getAttribute('src'));
                $img->setAttribute('src', JURI::base(true).'/plugins/system/tmlazyload/blank.gif');
            }
            JFactory::getApplication()->setBody("<!DOCTYPE html>\n".$dom->saveHTML());
        }
    }

    /**
     * Excludes the execution in specified components if option is selected
     */
    private function excludeComponents()
    {
        $option = JFactory::getApplication()->input->getWord('option');
        $exclude_components = array_map('trim', explode("\n", $this->params->get('exclude_components')));
        $hit = false;

        foreach($exclude_components as $exclude_component)
        {
            if($option == $exclude_component)
            {
                $hit = true;
                break;
            }
        }

        if($this->params->get('exclude_components_toggle'))
        {
            if($hit == false)
            {
                $this->_execute = false;
            }
        }
        else
        {
            if($hit == true)
            {
                $this->_execute = false;
            }
        }
    }

    /**
     * Excludes the execution in specified URLs if option is selected
     */
    private function excludeUrls()
    {
        $url = JUri::getInstance()->toString();
        $exclude_urls = array_map('trim', explode("\n", $this->params->get('exclude_urls')));
        $hit = false;

        foreach($exclude_urls as $exclude_url)
        {
            if($url == $exclude_url)
            {
                $hit = true;
                break;
            }
        }

        if($this->params->get('exclude_urls_toggle'))
        {
            if($hit == false)
            {
                $this->_execute = false;
            }
        }
        else
        {
            if($hit == true)
            {
                $this->_execute = false;
            }
        }
    }

    /**
     * Excludes the execution in specified image names if option is selected
     *
     * @param $matches
     */
    private function excludeImageNames(&$matches)
    {
        $exclude_image_names = array_map('trim', explode("\n", $this->params->get('exclude_imagenames')));
        $exclude_imagenames_toggle = $this->params->get('exclude_imagenames_toggle');
        $matches_temp = array();

        foreach($exclude_image_names as $exclude_image_name)
        {
            $count = 0;

            foreach($matches[1] as $match)
            {
                if(preg_match('@'.preg_quote($exclude_image_name).'@', $match))
                {
                    if(empty($exclude_imagenames_toggle))
                    {
                        unset($matches[0][$count]);
                    }
                    else
                    {
                        $matches_temp[] = $matches[0][$count];
                    }
                }

                $count++;
            }
        }

        if($exclude_imagenames_toggle)
        {
            unset($matches[0]);
            $matches[0] = $matches_temp;
        }
    }

    /**
     * Excludes the execution for specified bots if option is selected
     */
    private function excludeBots()
    {
        $exclude_bots = array_map('trim', explode(",", $this->params->get('botslist')));
        $agent = $_SERVER['HTTP_USER_AGENT'];

        foreach($exclude_bots as $exclude_bot)
        {
            if(preg_match('@'.$exclude_bot.'@i', $agent))
            {
                $this->_execute = false;
                break;
            }
        }
    }

    /**
     * Checks whether all requirements are met for the execution
     *
     * @param $admin                 Allow backend execution - true or false
     * @param $version_min           Minimum required Joomla! version - e.g. 3.2
     * @param $extension_name        Name of the extension of the warning message
     * @param $extension_system_name System name of the extension for the language file loading - e.g. plg_system_xxx
     * @param $jpath                 Path of the language file - JPATH_ADMINISTRATOR or JPATH_SITE
     *
     * @return bool
     */
    private function checkVersionRequirements($admin, $version_min, $extension_name, $extension_system_name, $jpath)
    {
        $execution = true;
        $version = new JVersion();

        if(!$version->isCompatible($version_min))
        {
            $execution = false;
            $backend_message = true;
        }

        if(empty($admin))
        {
            if(JFactory::getApplication()->isAdmin())
            {
                $execution = false;

                if(!empty($backend_message))
                {
                    $this->loadLanguage($extension_system_name, $jpath);
                    JFactory::getApplication()->enqueueMessage(JText::sprintf('KR_JOOMLA_VERSION_REQUIREMENTS_NOT_MET', $extension_name, $version_min), 'warning');
                }
            }
        }

        return $execution;
    }
}
