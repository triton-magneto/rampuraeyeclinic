<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$cparams = JComponentHelper::getParams('com_media');
require_once JPATH_BASE . '/templates/' . $template . '/includes/Mobile_Detect.php';
$detect = new Mobile_Detect;

jimport('joomla.html.html.bootstrap');

$app = JFactory::getApplication('site');
$template = $app->getTemplate(true);
?>
<div class="page page-contact page-contact__<?php echo $this->pageclass_sfx?>">

  <?php if ($this->params->get('show_page_heading')) : ?>
  <!-- Heading -->
  <div class="page_header">
    <<?php echo $template->params->get('categoryPageHeading','h3'); ?>><?php echo $this->escape($this->params->get('page_heading')); ?></<?php echo $template->params->get('categoryPageHeading','h3'); ?>>
  </div>
  <?php endif;

  if ($this->contact->name && $this->params->get('show_name')) : ?>
  <!-- Contact name -->
  <div clas="contact_name">
    <?php echo '<'. $template->params->get('categoryPageHeading') .'>';
      if ($this->item->published == 0): ?>
      <span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
      <?php endif;
      echo $this->contact->name;
		echo '</'. $template->params->get('categoryPageHeading') .'>'; ?>
  </div>
  <?php endif;
  
  if ($this->params->get('show_contact_category') == 'show_no_link') : ?>
  <!-- Category -->
  <div class="contact_category">
    <h3><?php echo $this->contact->category_title; ?></h3>
  </div>
  <?php endif;

  if ($this->params->get('show_contact_category') == 'show_with_link') : ?>
  <!-- Category With link -->
  <?php $contactLink = ContactHelperRoute::getCategoryRoute($this->contact->catid); ?>
  <div class="contact_category contact_category__link">
    <h3>
      <a href="<?php echo $contactLink; ?>"><?php echo $this->escape($this->contact->category_title); ?></a>
    </h3>
  </div>
  <?php endif;

  if ($this->params->get('show_contact_list') && count($this->contacts) > 1) : ?>
  <!-- Contact list -->
  <form action="#" method="get" name="selectForm" id="selectForm">
    <?php echo JText::_('COM_CONTACT_SELECT_CONTACT');
    echo JHtml::_('select.genericlist', $this->contacts, 'id', 'class="inputbox" onchange="document.location.href = this.value"', 'link', 'name', $this->contact->link);?>
  </form>
  <?php endif;

  if ($this->params->get('presentation_style') == 'tabs'):?>
  <!-- TABS Contact details -->
  <ul class="nav nav-tabs" id="myTab">
    <li><a data-toggle="tab" href="#basic-details"><?php echo JText::_('COM_CONTACT_DETAILS'); ?></a></li>
    <?php if ($this->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) : ?>
    <li><a data-toggle="tab" href="#display-form"><?php echo JText::_('COM_CONTACT_EMAIL_FORM'); ?></a></li>
    <?php endif;
    if ($this->params->get('show_links')) : ?>
    <li><a data-toggle="tab" href="#display-links"><?php echo JText::_('COM_CONTACT_LINKS'); ?></a></li>
    <?php endif;
    if ($this->params->get('show_articles') && $this->contact->user_id && $this->contact->articles) : ?>
    <li><a data-toggle="tab" href="#display-articles"><?php echo JText::_('JGLOBAL_ARTICLES'); ?></a></li>
    <?php endif;
    if ($this->params->get('show_profile') && $this->contact->user_id && JPluginHelper::isEnabled('user', 'profile')) : ?>
    <li><a data-toggle="tab" href="#display-profile"><?php echo JText::_('COM_CONTACT_PROFILE'); ?></a></li>
    <?php endif;
    if ($this->contact->misc && $this->params->get('show_misc')) : ?>
      <li><a data-toggle="tab" href="#display-misc"><?php echo JText::_('COM_CONTACT_OTHER_INFORMATION'); ?></a></li>
    <?php endif; ?>
  </ul>
  <?php endif;

  if ($this->params->get('presentation_style') == 'sliders'):
  echo JHtml::_('bootstrap.startAccordion', 'slide-contact', array('active' => 'basic-details'));
  endif;
  if ($this->params->get('presentation_style') == 'tabs'):
  echo JHtml::_('bootstrap.startPane', 'myTab', array('active' => 'basic-details'));
  endif;
    
  if ($this->params->get('presentation_style') == 'sliders'):
  echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('COM_CONTACT_DETAILS'), 'basic-details');
  endif;
  if ($this->params->get('presentation_style') == 'tabs'):
  echo JHtml::_('bootstrap.addPanel', 'myTab', 'basic-details');
  endif;
    
  if ($this->contact->image && $this->params->get('show_image')) : ?>
  <div class="thumbnail pull-right">
    <?php echo JHtml::_('image', $this->contact->image, JText::_('COM_CONTACT_IMAGE_DETAILS'), array('align' => 'middle')); ?>
  </div>
  <?php endif;

  if ($this->contact->con_position && $this->params->get('show_position')) : ?>
  <dl class="contact-position dl-horizontal">
    <dd>
       <?php echo $this->contact->con_position; ?>
    </dd>
  </dl>
  <?php endif;
  if ($this->params->get('presentation_style') !== 'plain'):
  echo $this->loadTemplate('address');
  endif;
    
  if ($this->params->get('presentation_style') == 'sliders'):
  echo JHtml::_('bootstrap.endSlide');
  endif;
  if ($this->params->get('presentation_style') == 'tabs'):
  echo JHtml::_('bootstrap.endPanel');
  endif; ?>
  <!-- CONTACT FORM -->
  <?php if ($this->params->get('presentation_style') == 'sliders'):
  echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('COM_CONTACT_EMAIL_FORM'), 'display-form');
  endif;
  if ($this->params->get('presentation_style') == 'tabs'):
  echo JHtml::_('bootstrap.addPanel', 'myTab', 'display-form');
  endif; ?>

  <!-- Map -->
  <div class="contact_map" id="contact_map">

  <?php if($detect->isMobile() || $detect->isIpad()){ ?>
  {mosmap dragging='0'}
  <?php } else { ?>
  {mosmap}
  <?php } ?>
  </div>

  <!-- Address -->
  <?php if ($this->params->get('presentation_style') == 'plain'):?>
  <div class="row-fluid">
    <?php echo $this->loadTemplate('address'); ?>
  </div>
  <?php endif; ?>

  <!-- Misc -->
  <?php if ($this->contact->misc && $this->params->get('show_misc')) :
  if ($this->params->get('presentation_style') == 'plain'):?>                
  <div class="contact_misc">
	  <?php echo '<'. $template->params->get('categoryPageHeading') .'>'. JText::_('TPL_CONTACT_MISC').'</'. $template->params->get('categoryPageHeading') .'>';
    echo $this->contact->misc; ?>
  </div>
  <?php endif;
  endif;

  if ($this->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) :
  
  echo $this->loadTemplate('form');
  endif;

  if ($this->params->get('presentation_style') == 'sliders'):
  echo JHtml::_('bootstrap.endSlide');
  endif;
  if ($this->params->get('presentation_style') == 'tabs'):
  echo JHtml::_('bootstrap.endPanel');
  endif; ?>

  <!-- MISC INFO -->

  <?php if ($this->contact->misc && $this->params->get('show_misc')) :
  if ($this->params->get('presentation_style') == 'sliders'):
  echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('COM_CONTACT_OTHER_INFORMATION'), 'display-misc');
  endif;
  if ($this->params->get('presentation_style') == 'tabs'):
  echo JHtml::_('bootstrap.addPanel', 'myTab', 'display-misc');
  endif;
  if ($this->params->get('presentation_style') == 'sliders'):
  echo JHtml::_('bootstrap.endSlide');
  endif;
  if ($this->params->get('presentation_style') == 'tabs')
  echo JHtml::_('bootstrap.endPanel');
  endif;
  if ($this->params->get('show_links')) :
  echo $this->loadTemplate('links');
  endif;
  if ($this->params->get('show_articles') && $this->contact->user_id && $this->contact->articles) :
  if ($this->params->get('presentation_style') == 'sliders'):
  echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('JGLOBAL_ARTICLES'), 'display-articles');
  endif;
  if ($this->params->get('presentation_style') == 'tabs'):
  echo JHtml::_('bootstrap.addPanel', 'myTab', 'display-articles');
  endif;
  if ($this->params->get('presentation_style') == 'plain'):
  echo '<h3>'. JText::_('JGLOBAL_ARTICLES').'</h3>';
  endif;
  echo $this->loadTemplate('articles');
  if ($this->params->get('presentation_style') == 'sliders'):
  echo JHtml::_('bootstrap.endSlide');
  endif;
  if ($this->params->get('presentation_style') == 'tabs'):
  echo JHtml::_('bootstrap.endPanel');
  endif;                                   
  endif;
  if ($this->params->get('show_profile') && $this->contact->user_id && JPluginHelper::isEnabled('user', 'profile')) :
  if ($this->params->get('presentation_style') == 'sliders'):
  echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('COM_CONTACT_PROFILE'), 'display-profile');
  endif;
  if ($this->params->get('presentation_style') == 'tabs'):
  echo JHtml::_('bootstrap.addPanel', 'myTab', 'display-profile');
  endif;
  if ($this->params->get('presentation_style') == 'plain'):
  echo '<h3>'. JText::_('COM_CONTACT_PROFILE').'</h3>';
  endif;
  echo $this->loadTemplate('profile');
  if ($this->params->get('presentation_style') == 'sliders'):
  echo JHtml::_('bootstrap.endSlide');
  endif;
  if ($this->params->get('presentation_style') == 'tabs'):
  echo JHtml::_('bootstrap.endPanel');
  endif;
  endif;
  if ($this->params->get('presentation_style') == 'sliders'):
  echo JHtml::_('bootstrap.endAccordion');
  endif;
  if ($this->params->get('presentation_style') == 'tabs'):
  echo JHtml::_('bootstrap.endPane');
  endif; ?>    
</div>