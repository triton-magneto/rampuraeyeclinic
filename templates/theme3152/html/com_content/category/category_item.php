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
$urls    = json_decode($this->item->urls);

// Create a shortcut for params.
$params = &$this->item->params;
$images = json_decode($this->item->images);
$canEdit = $this->item->params->get('access-edit');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$info = $this->item->params->get('info_block_position', 0);
JHtml::_('behavior.tooltip');
JHtml::_('behavior.framework');
jimport( 'joomla.filter.filteroutput' );

if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
	<?php echo JFilterOutput::ampReplace(html_entity_decode(JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)))); ?>
<?php endif;	

if ($params->get('show_title') || $this->item->state == 0 || ($params->get('show_author') && !empty($this->item->author ))) : ?>
<!--  title/author -->
<header class="item_header">
	<?php if ($params->get('show_title')) :
	echo '<'. $template->params->get('categoryItemHeading', 'h4') .' class="item_title">'; 
		if ($params->get('link_titles') && $params->get('access-view')) : ?>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>"> <?php echo $this->escape($this->item->title); ?></a>
		<?php else :
			echo $this->escape($this->item->title);
		endif;
	echo '</'. $template->params->get('categoryItemHeading', 'h4') .'>';
	endif;

	if ($this->item->state == 0) : ?>
	<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
	<?php endif;

	if ($params->get('show_author') && !empty($this->item->author )) : ?>
	<div class="item_createdby">
	<?php $author = $this->item->author;
	$author = ($this->item->created_by_alias ? $this->item->created_by_alias : $author);
	if (!empty($this->item->contactid ) && $params->get('link_author') == true) :
		echo JText::sprintf('TPL_BY',	JHtml::_('link', JRoute::_('index.php?option=com_contact&view=contact&id=' . $this->item->contactid), $author));
	else :
		echo JText::sprintf('TPL_BY', $author);
	endif; ?>
	</div>
	<?php endif; ?>
</header>
<?php endif;

if (isset($images->image_intro) && !empty($images->image_intro)) :
$imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro; ?>
<!-- Intro image -->
<figure class="item_img img-intro img-intro__<?php echo htmlspecialchars($imgfloat); ?>">
	<?php if ((($params->get('show_title') && $params->get('link_titles')) || $params->get('show_readmore')) && $this->item->readmore && $params->get('access-view')) : ?>
	<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>">
	<?php endif; ?>
		<img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>">
		<?php if ($images->image_intro_caption): ?>
		<figcaption><?php echo htmlspecialchars($images->image_intro_caption); ?></figcaption>
		<?php endif;
	if ((($params->get('show_title') && $params->get('link_titles')) || $params->get('show_readmore')) && $this->item->readmore && $params->get('access-view')) : ?>
	</a>
	<?php endif; ?>
</figure>
<?php endif;

// to do not that elegant would be nice to group the params
$useDefList = (
	$params->get('show_modify_date') || 
	$params->get('show_publish_date')	|| 
	$params->get('show_hits') || 
	$params->get('show_category') || 
	$params->get('show_parent_category')
);
if ($useDefList && ($info == 0 || $info == 2)) : ?>
<!-- info TOP -->
<div class="item_info muted">
	<dl class="item_info_dl">
		<dt class="article-info-term"><?php /*echo JText::_('COM_CONTENT_ARTICLE_INFO');*/ ?></dt>
		<?php if ($params->get('show_parent_category') && !empty($this->item->parent_slug)) : ?>
		<dd>
			<div class="item_parent-category-name">
				<?php $title = $this->escape($this->item->parent_title);
				$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)) . '">' . $title . '</a>';
				if ($params->get('link_parent_category') && !empty($this->item->parent_slug)) :
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
				<?php $title = $this->escape($this->item->category_title);
				$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)) . '">' . $title . '</a>';
				if ($params->get('link_category') && $this->item->catslug) :
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
				<?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_LC3'))); ?>
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


echo $this->item->event->afterDisplayTitle;
echo $this->item->event->beforeDisplayContent;

if ($params->get('show_intro')) : ?>
<!-- Introtext -->
<div class="item_introtext">
	<?php echo $this->item->introtext; ?>
</div>
<?php endif; ?>
<!-- info BOTTOM -->
<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
<div class="item_info muted">
	<dl class="item_info_dl">
		<dt class="article-info-term"><?php /*echo JText::_('COM_CONTENT_ARTICLE_INFO');*/ ?></dt>
		<?php if ($info == 1):
		if ($params->get('show_parent_category') && !empty($this->item->parent_slug)) : ?>
		<dd>
			<div class="item_parent-category-name">
				<?php	$title = $this->escape($this->item->parent_title);
				$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)) . '">' . $title . '</a>';
				if ($params->get('link_parent_category') && $this->item->parent_slug) :
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
				$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)) . '">' . $title . '</a>';
				if ($params->get('link_category') && $this->item->catslug) :
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

if (isset($urls) && (!empty($urls->urla) || !empty($urls->urlb) || !empty($urls->urlc))) :
		$urlarray = array(
		array($urls->urla, $urls->urlatext, $urls->targeta, 'a'),
		array($urls->urlb, $urls->urlbtext, $urls->targetb, 'b'),
		array($urls->urlc, $urls->urlctext, $urls->targetc, 'c')
		); ?>
		<div class="content-links">
			<ul>
				<?php foreach ($urlarray as $url) :
				$link = $url[0];
				$label = $url[1];
				$target = $url[2];
				$id = $url[3];

				if ( ! $link) :
					continue;
				endif;

				// If no label is present, take the link
				$label = ($label) ? $label : $link;

				// If no target is present, use the default
				$target = $target ? $target : $params->get('target'.$id); ?>
				<li class="content-links-<?php echo $id; ?>">
				<?php
					// Compute the correct link

					switch ($target)
					{
						case 1:
							// open in a new window
							echo '<a href="'. htmlspecialchars($link) .'" target="_blank"  rel="nofollow">'.
								htmlspecialchars($label) .'</a>';
							break;

						case 2:
							// open in a popup window
							$attribs = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=600';
							echo "<a href=\"" . htmlspecialchars($link) . "\" onclick=\"window.open(this.href, 'targetWindow', '".$attribs."'); return false;\">".
								htmlspecialchars($label).'</a>';
							break;
						case 3:
							// open in a modal window
							JHtml::_('behavior.modal', 'a.modal');
							echo '<a class="modal" href="'.htmlspecialchars($link).'"  rel="{handler: \'iframe\', size: {x:600, y:600}}">'.
								htmlspecialchars($label) . ' </a>';
							break;

						default:
							// open in parent window
							echo '<a href="'.  htmlspecialchars($link) . '" rel="nofollow">'.
								htmlspecialchars($label) . ' </a>';
							break;
					}
				?>
				</li>
				<?php endforeach; ?>
			</ul>
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
<!-- More -->
<a class="btn btn-info" href="<?php echo $link; ?>"><span>
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

if ($params->get('show_tags', 1) && !empty($this->item->tags)) :
$this->item->tagLayout = new JLayoutFile('joomla.content.tags');

echo $this->item->tagLayout->render($this->item->tags->itemTags);
endif;
	
echo $this->item->event->afterDisplayContent; ?>