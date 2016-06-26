<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

JHtml::_('behavior.framework');
JHtml::_('formbehavior.chosen', 'select');

// Get the user object.
$user = JFactory::getUser();

// Check if user is allowed to add/edit based on tags permissions.
// Do we really have to make it so people can see unpublished tags???
$canEdit = $user->authorise('core.edit', 'com_tags');
$canCreate = $user->authorise('core.create', 'com_tags');
$canEditState = $user->authorise('core.edit.state', 'com_tags');
$items = $this->items;
$n = count($this->items);
$app = JFactory::getApplication('site');
$template = $app->getTemplate(true);

?>
	<?php if ($this->items == false || $n == 0) : ?>
	<p><?php echo JText::_('COM_TAGS_NO_ITEMS'); ?></p>
	<?php else : ?>
	<div class="items-row">
		<?php foreach ($items as $i => $item) :
		if ($item->core_state == 0) : ?>
		<article class="system-unpublished cat-list-row<?php echo $i % 2; ?>">
		<?php else: ?>
		<article class="item" >
			<?php echo '<'. $template->params->get('categoryItemHeading', 'h4') .' class="item_title">'; ?>
				<a href="<?php echo JRoute::_(TagsHelperRoute::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router)); ?>">
					<?php echo $this->escape($item->core_title); ?>
				</a>
			<?php echo '</'. $template->params->get('categoryItemHeading', 'h4') .'>';
			endif;
			$images  = json_decode($item->core_images);
			if ($this->params->get('tag_list_show_item_image', 1) == 1 && !empty($images->image_intro)) :
			$imgfloat = (empty($images->float_intro)) ? $this->params->get('float_intro') : $images->float_intro; ?>
      <div class="item_img img-intro img-intro__<?php echo htmlspecialchars($imgfloat); ?>">
				<a href="<?php echo JRoute::_(TagsHelperRoute::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router)); ?>">
          <img <?php if ($images->image_intro_caption): echo 'class="caption"'.' title="' .htmlspecialchars($images->image_intro_caption) .'"'; endif; ?> src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"> 
        </a>
      </div>
      <?php endif;
			if ($this->params->get('tag_list_show_item_description', 1)) : ?>
			<div class="tag-body">
				<?php echo JHtml::_('string.truncate', $item->core_body, $this->params->get('tag_list_item_maximum_characters')); ?>
			</div>
      <!-- More -->
			<?php 
      $link = JRoute::_(TagsHelperRoute::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router));
      ?>
      <a class="btn btn-info" href="<?php echo $link; ?>"><span>
      	<?php 
      	if ($this->params->get('show_readmore_title', 0) == 0) :
        echo JText::sprintf('TPL_COM_CONTENT_READ_MORE_TITLE');
      	else :
         echo JText::_('TPL_COM_CONTENT_READ_MORE');
        echo JHtml::_('string.truncate', ($item->core_title), $this->params->get('readmore_limit'));
      	endif; ?>
      </span></a>
			<?php endif; ?>
			<div class="clearfix"></div>
		</article>
		<?php endforeach; ?>
	</div>
	<?php if ($this->params->get('show_pagination')&&$this->pagination->getPagesLinks()) : ?>
	<div class="pagination">
		<?php if ($this->params->get('show_pagination_results', 1)) : ?>
		<p class="counter"><?php echo $this->pagination->getPagesCounter(); ?></p>
		<?php endif;
		echo $this->pagination->getPagesLinks(); ?>
	</div>
	</br>
	<?php endif; ?>
<?php endif; ?>