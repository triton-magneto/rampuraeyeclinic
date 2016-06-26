<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * marker_class: Class based on the selection of text, none, or #__
 * jicon-text, jicon-none, jicon-icon
 */
 
 
$app = JFactory::getApplication('site');
$template = $app->getTemplate(true);
?>


<div class="contact_details">
	<?php if (($this->params->get('address_check') > 0) && ($this->contact->address || $this->contact->suburb  || $this->contact->state || $this->contact->country || $this->contact->postcode)) : ?>
	<div class="contact_details_item span4">
		<<?php echo $template->params->get('categoryPageHeading'); ?>><?php echo JText::_('TPL_CONTACT_ADDRESS'); ?></<?php echo $template->params->get('categoryPageHeading'); ?>>
		<?php if ($this->params->get('address_check') > 0) : ?>
		<i class="icons-marker fa fa-home"></i>
		<?php endif; ?>
		<div class="contact_address">
			<?php if ($this->contact->address && $this->params->get('show_street_address')) :
			echo $this->contact->address; ?><br/>
			<?php endif;
			if ($this->contact->suburb && $this->params->get('show_suburb')) :
			echo $this->contact->suburb; ?><br/>
			<?php endif;
			if ($this->contact->state && $this->params->get('show_state')) :
			echo $this->contact->state;
			endif;
			if ($this->contact->postcode && $this->params->get('show_postcode')) :
			echo $this->contact->postcode; ?><br/>
			<?php endif;
			if ($this->contact->country && $this->params->get('show_country')) :
			echo $this->contact->country;
			endif; ?>
		</div>
	</div>
	<?php endif; ?>
	<div class="contact_details_item span4">
		<<?php echo $template->params->get('categoryPageHeading'); ?>><?php echo JText::_('TPL_CONTACT_PHONES'); ?></<?php echo $template->params->get('categoryPageHeading'); ?>>
		<?php if ($this->contact->telephone && $this->params->get('show_telephone')) : ?>
		<i class="icons-marker fa fa-phone"></i>
		<div class="contact_details_telephone">
			<?php echo nl2br($this->contact->telephone); ?>
		</div>			
		<div class="clearfix"></div>
		<?php endif;
		if ($this->contact->fax && $this->params->get('show_fax')) : ?>
		<i class="icons-marker fa fa-print"></i>
		<div class="contact_details_fax">
			<?php echo nl2br($this->contact->fax); ?>
		</div>
		<div class="clearfix"></div>
		<?php endif;
		if ($this->contact->mobile && $this->params->get('show_mobile')) :?>
		<i class="icons-marker fa fa-mobile"></i>
		<div class="contact_details_mobile">
			<?php echo nl2br($this->contact->mobile); ?>
		</div>
		<div class="clearfix"></div>
		<?php endif;
		if ($this->contact->webpage && $this->params->get('show_webpage')) : ?>
		<i class="icons-marker fa fa-list-alt"></i>
		<div class="contact_details_webpage">
			<a href="<?php echo $this->contact->webpage; ?>" target="_blank"><?php echo $this->contact->webpage; ?></a>
		</div>
		<div class="clearfix"></div>
		<?php endif; ?>
	</div>
	<div class="contact_details_item span4">
		<<?php echo $template->params->get('categoryPageHeading'); ?>><?php echo JText::_('TPL_CONTACT_MAILTO'); ?></<?php echo $template->params->get('categoryPageHeading'); ?>>
		<?php if ($this->contact->email_to && $this->params->get('show_email')) : ?>
		<i class="icons-marker fa fa-envelope"></i>
		<div class="contact_details_emailto">				
			<?php echo $this->contact->email_to; ?>
		</div>
		<div class="clearfix"></div>
		<?php endif;
		if ($this->params->get('allow_vcard')) : ?>
    <div class="contact_vcard">
    	<i class="muted"><?php echo JText::_('COM_CONTACT_DOWNLOAD_INFORMATION_AS');?>
      	<a href="<?php echo JRoute::_('index.php?option=com_contact&amp;view=contact&amp;id='.$this->contact->id . '&amp;format=vcf'); ?>"><?php echo JText::_('COM_CONTACT_VCARD');?></a>
    	</i>
    </div>
     <div class="clearfix"></div>
	 <?php endif; ?>
	</div>
</div>