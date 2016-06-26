<?php
/****************************************************************************************\
**   Plugin 'JoomFancyBox' 1.0                                                          **
**   By: fabrice jossa, edited by JoomGallery::ProjectTeam                              **
**   Copyright (C) 2012 - 2012 JoomGallery::ProjectTeam                                 **
**   Released under GNU GPL Public License                                              **
**   License: http://www.gnu.org/copyleft/gpl.html or have a look                       **
**   at administrator/components/com_joomgallery/LICENSE.TXT                            **
\****************************************************************************************/

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

require_once JPATH_ADMINISTRATOR.'/components/com_joomgallery/helpers/openimageplugin.php';

/**
 * JoomGallery fancyBox Plugin
 *
 * With this plugin JoomGallery is able to use fancyBox
 * (http://fancyapps.com/fancybox/) for displaying images.
 *
 * PLEASE NOTE: fancyBox is licensed under Creative Commons Attribution-NonCommercial 3.0
 * If you want to use fancyBox on a commercial website you will have to pay a fee to its developer.
 *
 * @package     Joomla
 * @subpackage  JoomGallery
 * @since       1.0
 */
class plgJoomGalleryJoomFancyBox extends JoomOpenImagePlugin
{
  /**
   * Name of this popup box
   *
   * @var   string
   * @since 1.0
   */
  protected $title = 'fancyBox';

  /**
   * Initializes the box by adding all necessary JavaScript and CSS files.
   * This is done only once per page load.
   *
   * Please use the document object of Joomla! to add JavaScript and CSS files, e.g.:
   * <code>
   * $doc = JFactory::getDocument();
   * $doc->addStyleSheet(JUri::root().'media/plg_exampleopenimage/css/exampleopenimage.css');
   * $doc->addScript(JUri::root().'media/plg_exampleopenimage/js/exampleopenimage.js');
   * $doc->addScriptDeclaration("    jQuery(document).ready(function(){ExampleOpenImage.init()}");
   * </code>
   *
   * or if using Mootools or jQuery the respective JHtml method:
   * <code>
   * JHtml::_('jquery.framework');
   * JHtml::_('behavior.framework');
   * </code>
   *
   * @return  void
   * @since   1.0
   */
  protected function init()
  {
    JHtml::_('jquery.framework', $this->params->get('noconflict', 1));

    $doc = JFactory::getDocument();
    $doc->addStyleSheet(JUri::root().'media/plg_joomfancybox/jquery.fancybox.css?v=2.1.4');

    // Optionally add helpers css - thumbs
    if($this->params->get('thumbs'))
    {
      $doc->addStyleSheet(JURI::root().'media/plg_joomfancybox/helpers/jquery.fancybox-thumbs.css?v=2.1.4');
    }

    // Optionally add helpers css - button
    if($this->params->get('buttons'))
    {
      $doc->addStyleSheet(JURI::root().'media/plg_joomfancybox/helpers/jquery.fancybox-buttons.css?v=2.1.4');
    }

    if($this->params->get('script_position', 'head') == 'head')
    {
      // Optionally add mousewheel plugin
      if($this->params->get('mousewheel'))
      {
        $doc->addScript(JURI::root().'media/plg_joomfancybox/helpers/jquery.mousewheel-3.0.6.pack.js');
      }
      
      $doc->addScript(JURI::root().'media/plg_joomfancybox/jquery.fancybox.pack.js?v=2.1.4');

      // Optionally add helpers script - button
      if($this->params->get('buttons'))
      {
        $doc->addScript(JURI::root().'media/plg_joomfancybox/helpers/jquery.fancybox-buttons.js?v=1.0.2');
      }

      // Optionally add helpers script - thumbs
      if($this->params->get('thumbs'))
      {
        $doc->addScript(JURI::root().'media/plg_joomfancybox/helpers/jquery.fancybox-thumbs.js?v=2.1.4');
      }

      /*if($this->params->get('media'))
      {
        // Optionally add helpers script - media
        $doc->addScript(JURI::root().'media/plg_joomfancybox/source/helpers/jquery.fancybox-media.js?v=1.0.0');
      }*/

      if(!$this->params->get('init_script'))
      {
        $doc->addScriptDeclaration("    jQuery(document).ready(function(){jQuery('a[data-fancybox=\"fancybox\"]').fancybox();})");
      }
      else
      {
        $doc->addScriptDeclaration($this->params->get('init_script'));
      }
    }
  }

  /**
   * This method should set an associative array of attributes for the 'a'-Tag (key/value pairs) which opens the image.
   *
   * <code>
   * $attribs['data-rel']   = 'examplebox';
   * $attribs['data-group'] = $group;
   * </code>
   *
   * The example above will create a link tag like that: <a href="<image URL>"  data-rel="examplebox" group="<image group>" ... >
   *
   * ($attribs is passed by references and should only be filled)
   *
   * By default the attribute 'href' is filled with the URL to the image which shall be opened. You only have to set that
   * attribute if you want to change that (the image URL is passed in the third argument of this method).
   *
   * NOTE!!!: You are not allowed to set the attributes 'title' and 'class' because these are handled internally by JoomGallery.
   *
   * @param   array   $attribs  Associative array of HTML attributes which you have to fill
   * @param   object  $image    An object holding all the relevant data about the image to open
   * @param   string  $img_url  The URL to the image which shall be openend
   * @param   string  $group    The name of an image group, most popup boxes are able to group the images with that
   * @param   string  $type     'orig' for original image, 'img' for detail image or 'thumb' for thumbnail
   * @return  void
   * @since   1.0
   */
  protected function getLinkAttributes(&$attribs, $image, $img_url, $group, $type)
  {
    $attribs['data-fancybox'] = 'fancybox';
    $attribs['data-fancybox-group'] = $group;
    $attribs['data-fancybox-type'] = 'image';

    // You can add more fancyBox options here (in the following form), but you shouldn't change the above ones
    // $attribs['data-fancybox-<option name>'] = '<option value>';
  }
}