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

JHtml::addIncludePath(JPATH_COMPONENT . DS . 'helpers');
$params = $this->params;
?>
<div id="page-archive_items">
	<?php foreach ($this->items as $i => $item) :
	$info = $item->params->get('info_block_position', 0); ?>
	<div class="row<?php echo $i % 2; ?>">
		<article class="item">
			
			<?php $images = json_decode($item->images);
			if (isset($images->image_intro) && !empty($images->image_intro)) :
			$imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro; ?>
			<!-- Intro image -->
			<figure class="item_img img-intro img-intro__<?php echo htmlspecialchars($imgfloat); ?>">
				<?php if ($params->get('link_titles')) : ?>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug)); ?>">
				<?php endif; ?>
					<img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/>
					<?php if ($images->image_intro_caption): ?>
					<figcaption><?php echo htmlspecialchars($images->image_intro_caption); ?></figcaption>
					<?php endif; ?>
				<?php if ($params->get('link_titles')) : ?>
				</a>
				<?php endif; ?>
			</figure>
			<?php endif; ?>

			<header class="item_header">
				<?php echo '<'. $template->params->get('categoryItemHeading', 'h4') .' class="item_title">';
				if ($params->get('link_titles')) : ?>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug)); ?>"> <?php echo $this->escape($item->title); ?></a>
				<?php else:
				echo $this->escape($item->title);
				endif;
				echo '</'. $template->params->get('categoryItemHeading', 'h4') .'>'; ?>
			</header>
			<?php if ($params->get('show_tags', 1) && !empty($item->tags)) :
			$item->tagLayout = new JLayoutFile('joomla.content.tags');
			echo $item->tagLayout->render($item->tags->itemTags);
			endif; ?>
			<?php $useDefList = (($params->get('show_author') && !empty($item->author )) || $params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_create_date'));
			if ($useDefList && ($info == 0 || $info == 2)) : ?>
			<div class="item_info">
				<dl class="item_info_dl">
					<dt class="article-info-term"><?php /*echo JText::_('COM_CONTENT_ARTICLE_INFO');*/ ?></dt>
					<?php if ($params->get('show_publish_date')) : ?>
					<dd>
						<time datetime="<?php echo JHtml::_('date', $item->publish_up, 'Y-m-d H:i'); ?>" class="item_published">
							<?php echo JText::sprintf(JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC3'))); ?>
						</time>
					</dd>
					<?php endif;

					if ($params->get('show_author') && !empty($item->author )) : ?>
					<dd>
						<address class="item_createdby">
							<?php $author = $item->author;
							$author = ($item->created_by_alias ? $item->created_by_alias : $author);
							if (!empty($item->contactid ) && $params->get('link_author') == true) :
							echo JText::sprintf('TPL_BY',	JHtml::_('link', JRoute::_('index.php?option=com_contact&view=contact&id='.$item->contactid), $author));
							else :
							echo JText::sprintf('TPL_BY', $author);
							endif; ?>
						</address>
					</dd>
					<?php endif;
					if ($params->get('show_parent_category') && !empty($item->parent_slug)) : ?>
					<dd>
						<div class="item_parent-category-name">
							<?php	$title = $this->escape($item->parent_title);
							$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($item->parent_slug)).'">' . $title . '</a>';
							if ($params->get('link_parent_category') && !empty($item->parent_slug)) :
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
							<?php $title = $this->escape($item->category_title);
							$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug)).'">' . $title . '</a>';
							if ($params->get('link_category') && $item->catslug) :
							echo JText::sprintf('TPL_IN', $url);
							else :
							echo JText::sprintf('TPL_IN', $title);
							endif; ?>
						</div>
					</dd>
					<?php endif;
					if ($info == 0):
					if ($params->get('show_modify_date')) : ?>
					<dd>
						<time datetime="<?php echo JHtml::_('date', $this->item->publish_up, 'Y-m-d H:i'); ?>" class="item_modified">
							<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
						</time>
					</dd>
					<?php endif;
					if ($params->get('show_create_date')) : ?>
					<dd>
						<time datetime="<?php echo JHtml::_('date', $this->item->publish_up, 'Y-m-d H:i'); ?>" class="item_create">
							<?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC3'))); ?>
						</time>
					</dd>
					<?php endif;
					if ($params->get('show_hits')) : ?>
					<dd>
						<div class="item_hits">
							<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $item->hits); ?>
						</div>
					</dd>
					<?php endif;
					endif; ?>
				</dl>
			</div>
			<?php endif;

			if ($params->get('show_intro')) :?>
			<div class="intro">
				<?php echo JHtml::_('string.truncate', $item->introtext, $params->get('introtext_limit')); ?>
			</div>
			<?php endif;

			if ($useDefList && ($info == 1 || $info == 2)) : ?>
			<footer class="item_info muted">
				<dl class="item_info_dl">
					<dt class="article-info-term"><?php /*echo JText::_('COM_CONTENT_ARTICLE_INFO');*/ ?></dt>
					<?php if ($info == 1):
					if ($params->get('show_parent_category') && !empty($item->parent_slug)) : ?>
					<dd>
						<div class="item_parent-category-name">
							<?php	$title = $this->escape($item->parent_title);
							$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($item->parent_slug)) . '">' . $title . '</a>';
						  if ($params->get('link_parent_category') && $item->parent_slug) :
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
							<?php $title = $this->escape($item->category_title);
							$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug)) . '">' . $title . '</a>';
							if ($params->get('link_category') && $item->catslug) :
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
							<?php echo JText::sprintf('TPL_ON', JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC3'))); ?>
						</time>
					</dd>
					<?php endif;
					endif;
					if ($params->get('show_create_date')) : ?>
					<dd>
						<time datetime="<?php echo JHtml::_('date', $this->item->publish_up, 'Y-m-d H:i'); ?>" class="create">
							<?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
						</time>
					</dd>
					<?php endif;
					if ($params->get('show_modify_date')) : ?>
					<dd>
						<time datetime="<?php echo JHtml::_('date', $this->item->publish_up, 'Y-m-d H:i'); ?>" class="item_modified">
							<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
						</time>
					</dd>
					<?php endif;
					if ($params->get('show_hits')) : ?>
					<dd>
						<div class="item_hits">
							<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $item->hits); ?>
						</div>
					</dd>
					<?php endif;
					if (Komento::loadApplication( 'com_content')) : ?>
					<dd class="komento">
						<?php echo Komento::commentify( 'com_content', $item) ?>
					</dd>
					<?php endif; ?>
				</dl>
			</footer>
			<?php endif; ?>
		</article>
	</div>
	<?php endforeach; ?>
</div>
<?php if($this->pagination->getPagesLinks()) : ?>
<footer class="pagination">
	<p class="counter"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
	<?php echo $this->pagination->getPagesLinks(); ?>
</footer>
<?php endif; ?>