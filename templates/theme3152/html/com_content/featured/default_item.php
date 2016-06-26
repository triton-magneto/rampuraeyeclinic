<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$app = JFactory::getApplication('site');
$template = $app->getTemplate(true);

// Create a shortcut for params.
$params = &$this->item->params;
$images = json_decode($this->item->images);
$canEdit	= $this->item->params->get('access-edit');
$info    = $this->item->params->get('info_block_position', 0);
if ($this->item->state == 0) : ?>
<div class="system-unpublished">
	<?php endif;
	if ($params->get('show_print_icon') || $params->get('show_email_icon') || $canEdit) : ?>
	<div class="btn-group pull-right"> <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-cog"></i><span class="caret"></span> </a>
		<ul class="dropdown-menu">
			<?php if ($params->get('show_print_icon')) : ?>
			<li class="print-icon"> <?php echo JHtml::_('icon.print_popup', $this->item, $params); ?> </li>
			<?php endif;
			if ($params->get('show_email_icon')) : ?>
			<li class="email-icon"> <?php echo JHtml::_('icon.email', $this->item, $params); ?> </li>
			<?php endif;
			if ($canEdit) : ?>
			<li class="edit-icon"> <?php echo JHtml::_('icon.edit', $this->item, $params); ?> </li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif;

	if ($params->get('show_title')) : ?>
	<header class="item_header">
		<?php echo '<'. $template->params->get('featuredItemHeading', 'h4') .' class="item_title">';
			if ($params->get('link_titles') && $params->get('access-view')) : ?>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>"> <?php echo $this->escape($this->item->title); ?></a>
			<?php else :
			echo $this->escape($this->item->title);
			endif;
		echo '</'. $template->params->get('featuredItemHeading', 'h4') .'>'; ?>
	</header>
	<?php endif;

	if ($this->item->state == 0): ?>
	<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
	<?php endif;

	if ($params->get('show_author') && !empty($this->item->author )) : ?>
	<div class="item_author">
		<?php $author = $this->item->author;
		$author = ($this->item->created_by_alias ? $this->item->created_by_alias : $author);
		if (!empty($this->item->contactid ) &&  $params->get('link_author') == true) :
		echo JText::sprintf('TPL_BY',	JHtml::_('link', JRoute::_('index.php?option=com_contact&view=contact&id='.$this->item->contactid), $author));
		else :
		echo JText::sprintf('TPL_BY', $author);
		endif; ?>
	</div>
	<?php endif;

	if ($params->get('show_tags', 1) && !empty($this->item->tags)) :
	$this->item->tagLayout = new JLayoutFile('joomla.content.tags');

	echo $this->item->tagLayout->render($this->item->tags->itemTags);
	endif;

	// Todo Not that elegant would be nice to group the params
	$useDefList = (($params->get('show_modify_date')) or ($params->get('show_publish_date')) or ($params->get('show_hits')));
	if ($useDefList AND ($info == 0 OR $info == 2)) : ?>
	<div class="article-info muted">
		<dl class="article-info">
			<dt class="article-info-term"><?php  echo JText::_('COM_CONTENT_ARTICLE_INFO'); ?></dt>
			<?php if ($params->get('show_parent_category') && !empty($this->item->parent_slug)) : ?>
			<dd>
				<div class="item_parent-category-name">
					<?php	$title = $this->escape($this->item->parent_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)).'">'.$title.'</a>';
					if ($params->get('link_parent_category') and !empty($this->item->parent_slug)) :
					echo JText::sprintf('COM_CONTENT_PARENT', $url);
					else :
					echo JText::sprintf('COM_CONTENT_PARENT', $title);
					endif; ?>
				</div>
			</dd>
			<?php endif;
			if ($params->get('show_category')) : ?>
			<dd>
				<div class="item_category-name">
					<?php 	$title = $this->escape($this->item->category_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)).'">'.$title.'</a>';
					if ($params->get('link_category') and $this->item->catslug) :
					echo JText::sprintf('TPL_IN', $url);
					else :
					echo JText::sprintf('TPL_IN', $title);
					endif; ?>
				</div>
			</dd>
			<?php endif;

			if ($params->get('show_publish_date')) : ?>
			<dd>
				<time datetime="<?php echo JHtml::_('date', $this->item->publish_up, 'Y-m-d H:i'); ?>" class="item_published">
					<?php echo JText::sprintf('TPL_ON', JHtml::_('date', $this->item->publish_up, JText::_('DATE_FORMAT_LC3'))); ?>
				</time>
			</dd>
			<?php endif;

			if ($info == 0):
			if ($params->get('show_modify_date')) : ?>
			<dd>
				<time datetime="<?php echo JHtml::_('date', $this->item->modified, 'Y-m-d H:i'); ?>" class="item_modified">
					<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $this->item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
				</time>
			</dd>
			<?php endif;
			if ($params->get('show_create_date')) : ?>
			<dd>
				<time datetime="<?php echo JHtml::_('date', $this->item->created, 'Y-m-d H:i'); ?>" class="item_create">
					<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_LC3'))); ?>
				</time>
			</dd>
			<?php endif;

			if ($params->get('show_hits')) : ?>
			<dd>
				<div class="item_hits">
					  <?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
				</div>
			</dd>
			<?php endif;
			endif; ?>
		</dl>
	</div>
	<?php endif;


	if (isset($images->image_intro) and !empty($images->image_intro)) :
	$imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro; ?>
	<figure class="item_img img-intro img-intro__<?php echo htmlspecialchars($imgfloat); ?>">
		<img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>">
		<?php if ($images->image_intro_caption): ?>
		<figcaption><?php echo htmlspecialchars($images->image_intro_caption);	?></figcaption>
		<?php endif; ?>
	</figure>
	<?php endif;

	if (!$params->get('show_intro')) :
	echo $this->item->event->afterDisplayTitle;
	endif;

	echo $this->item->event->beforeDisplayContent; ?> <?php echo $this->item->introtext;
	if ($useDefList AND ($info == 1 OR $info == 2)) : ?>
	<div class="item_info muted">
		<dl class="item_info_dl">
			<dt class="article-info-term"><?php /* echo JText::_('COM_CONTENT_ARTICLE_INFO'); */?></dt>
			<?php if ($info == 1):
			if ($params->get('show_parent_category') AND !empty($this->item->parent_slug)) : ?>
			<dd>
				<div class="item_parent-category-name">
					<?php	$title = $this->escape($this->item->parent_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)).'">'.$title.'</a>';
					if ($params->get('link_parent_category') and $this->item->parent_slug) :
					echo JText::sprintf('COM_CONTENT_PARENT', $url);
					else :
					echo JText::sprintf('COM_CONTENT_PARENT', $title);
					endif; ?>
				</div>
			</dd>
			<?php endif;
			if ($params->get('show_category')) : ?>
			<dd>
				<div class="item_category-name">
					<?php 	$title = $this->escape($this->item->category_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)).'">'.$title.'</a>';
					if ($params->get('link_category') and $this->item->catslug) :
					echo JText::sprintf('COM_CONTENT_CATEGORY', $url);
					else :
					echo JText::sprintf('COM_CONTENT_CATEGORY', $title);
					endif; ?>
				</div>
			</dd>
			<?php endif;
			if ($params->get('show_publish_date')) : ?>
			<dd>
				<time datetime="<?php echo JHtml::_('date', $this->item->publish_up, 'Y-m-d H:i'); ?>" class="item_published">
					<?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHtml::_('date', $this->item->publish_up, JText::_('DATE_FORMAT_LC3'))); ?>
				</time>
			</dd>
			<?php endif;
			endif;

			if ($params->get('show_create_date')) : ?>
			<dd>
				<time datetime="<?php echo JHtml::_('date', $this->item->created, 'Y-m-d H:i'); ?>" class="item_create">
					<?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_LC3'))); ?>
				</time>
			</dd>
			<?php endif;
			if ($params->get('show_modify_date')) : ?>
			<dd>
				<time datetime="<?php echo JHtml::_('date', $this->item->modified, 'Y-m-d H:i'); ?>" class="item_modified">
					<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $this->item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
				</time>
			</dd>
			<?php endif;
			if ($params->get('show_hits')) : ?>
			<dd>
				<div class="item_hits">
			  	<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
				</div>
			</dd>
		<?php endif; ?>
		</dl>
	</div>
	<?php endif;

	if ($params->get('show_readmore') && $this->item->readmore) :
	if ($params->get('access-view')) :
		$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
	else :
		$menu = JFactory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
		$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
		$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
		$link = new JURI($link1);
		$link->setVar('return', base64_encode($returnURL));
	endif;

	?>
	<a class="btn btn-info readmore" href="<?php echo $link; ?>"><span>
		<?php if (!$params->get('access-view')) :
		echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
		elseif ($readmore = $this->item->alternative_readmore) :
		echo $readmore;
		if ($params->get('show_readmore_title', 0) != 0) :
		echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
		endif;
		elseif ($params->get('show_readmore_title', 0) == 0) :
		echo JText::sprintf('TPL_COM_CONTENT_READ_MORE_TITLE');
		else :
		echo JText::_('TPL_COM_CONTENT_READ_MORE');
		echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
		endif; ?>
	</span></a>
	<?php endif;
	if ($this->item->state == 0) : ?>
</div>
<?php endif;
echo $this->item->event->afterDisplayContent; ?>