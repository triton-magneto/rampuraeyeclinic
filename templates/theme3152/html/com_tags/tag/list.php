<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
// Note that there are certain parts of this layout used only when there is exactly one tag.

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
$n = count($this->items);
?>
<section class="tag-category<?php echo $this->pageclass_sfx; ?>">
	<?php  if ($this->params->get('show_page_heading')) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	<?php endif;
	if($this->params->get('show_tag_title', 1)) : ?>
	<h2><?php echo JHtml::_('content.prepare', $this->document->title, '', 'com_tag.tag'); ?></h2>
	<?php endif;
	// We only show a tag description if there is a single tag.
	if (count($this->item) == 1 && (($this->params->get('tag_list_show_tag_image', 1)) || $this->params->get('tag_list_show_tag_description', 1))) : ?>
	<div class="category-desc">
		<?php  $images  = json_decode($this->item[0]->images);
		if ($this->params->get('tag_list_show_tag_image', 1) == 1 && !empty($images->image_fulltext)) :?>
		<img src="<?php echo htmlspecialchars($images->image_fulltext);?>">
		<?php endif;
		if ($this->params->get('tag_list_show_tag_description') == 1 && $this->item[0]->description) :
		echo JHtml::_('content.prepare', $this->item[0]->description, '', 'com_tags.tag');
		endif; ?>
		<div class="clr"></div>
	</div>
	<?php endif;
	// If there are multiple tags and a description or image has been supplied use that.
	if ($this->params->get('tag_list_show_tag_description', 1) || $this->params->get('show_description_image', 1)):
	if ($this->params->get('show_description_image', 1) == 1 && $this->params->get('tag_list_image')) :?>
	<img src="<?php echo $this->params->get('tag_list_image');?>">
	<?php endif;
	if ($this->params->get('tag_list_description', '') > '') :
	echo JHtml::_('content.prepare', $this->params->get('tag_list_description'), '', 'com_tags.tag');
	endif;

	endif;

	echo $this->loadTemplate('items'); ?>
</section>