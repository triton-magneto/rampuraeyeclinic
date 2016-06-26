<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$app 		= JFactory::getApplication();
$tmpl 	= $app->getTemplate();
$template 	= $app->getTemplate(true);


// Create shortcuts to some parameters.
$params  = $this->item->params;
$images  = json_decode($this->item->images);
$urls    = json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user    = JFactory::getUser();
$info    = $params->get('info_block_position', 0);
JHtml::_('behavior.caption');
jimport( 'joomla.filter.filteroutput' );

?>
<article class="page-item page-item__gallery page-item__<?php echo $this->pageclass_sfx?>">
	<?php if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative)
	{
	echo $this->item->pagination;
	}
	if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
		<?php echo JFilterOutput::ampReplace(html_entity_decode(JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)))); ?>
	<?php endif;

	if ($params->get('show_title') || $params->get('show_author')) : ?>
	<header class="item_header">
		<?php echo '<'. $template->params->get('itemItemHeading', 'h3') .' class="item_title">';
		if ($this->item->state == 0): ?>
		<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
		<?php endif;
		if ($params->get('show_title')) :
		echo $this->escape($this->item->title);
		endif;
		echo '</'. $template->params->get('itemItemHeading', 'h3') .'>';
		if ($params->get('show_author') && !empty($this->item->author )) : ?>
		<div class="item_createdby">
			<?php $author = $this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author;
			if (!empty($this->item->contactid) && $params->get('link_author') == true) :
			$needle = 'index.php?option=com_contact&view=contact&id=' . $this->item->contactid;
			$menu = JFactory::getApplication()->getMenu();
			$item = $menu->getItems('link', $needle, true);
			$cntlink = !empty($item) ? $needle . '&Itemid=' . $item->id : $needle;
			echo JText::sprintf('TPL_BY', JHtml::_('link', JRoute::_($cntlink), $author));
			else:
			echo JText::sprintf('TPL_BY', $author);
			endif; ?>
		</div>
		<?php endif; ?>
	</header>
	<?php endif;

	$useDefList = ($params->get('show_modify_date') || 
	$params->get('show_publish_date')	|| 
	$params->get('show_hits') || 
	$params->get('show_category') || 
	$params->get('show_parent_category'));
	if ($useDefList && ($info == 0 || $info == 2)) : ?>
	<div class="item_info muted">
		<dl class="item_info_dl">
			<dt class="article-info-term"><?php /*echo JText::_('COM_CONTENT_ARTICLE_INFO');*/ ?></dt>
			<?php if ($params->get('show_parent_category') && !empty($this->item->parent_slug)) : ?>
			<dd>
				<div class="item_parent-category-name">
					<?php $title = $this->escape($this->item->parent_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)).'">'.$title.'</a>';
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

	if (!$params->get('show_intro')) : echo $this->item->event->afterDisplayTitle; endif;
	echo $this->item->event->beforeDisplayContent;

	if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position)))
		|| (empty($urls->urls_position) && (!$params->get('urls_position')))) :
	echo $this->loadTemplate('links');
	endif;

	if ($params->get('access-view')):?>
	<!-- Article Image -->	
	<?php  if (isset($images->image_fulltext) and !empty($images->image_fulltext)) :
	if (isset($images->image_fulltext) and !empty($images->image_fulltext)) :

	$imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
	<div class="page-gallery_img">
		<figure class="item_img img-full img-full__<?php echo htmlspecialchars($imgfloat); ?>">
			<a class="fancybox-thumb zoom articleGalleryZoom" data-fancybox-group="portfolio" data-fancybox-type="image" data-fancybox="fancybox" href="<?php echo htmlspecialchars($images->image_fulltext); ?>">
				<img src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>">
				<?php if ($images->image_fulltext_caption): ?>
				<figcaption><?php echo htmlspecialchars($images->image_fulltext_caption); ?></figcaption>
				<?php endif; ?>
			</a> 
		</figure>
	</div>
	<?php endif;
	endif;	

	if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && !$this->item->paginationrelative):
	echo $this->item->pagination;
	endif;
	if (isset ($this->item->toc)) :
	echo $this->item->toc;
	endif; ?>
	<div class="item_fulltext">
		<?php echo $this->item->text; ?>
	</div>
	<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
	<div class="item_info muted">
		<dl class="item_info_dl">
		  <dt class="article-info-term"><?php/* echo JText::_('COM_CONTENT_ARTICLE_INFO');*/ ?></dt>
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
					<?php echo JText::sprintf('TPL_ON', JHtml::_('date', $this->item->publish_up, JText::_('DATE_FORMAT_LC3'))); ?>
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

	if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative):
	echo $this->item->pagination;
	endif;
	if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($params->get('urls_position') == '1'))):
	echo $this->loadTemplate('links');
	endif;
	//optional teaser intro text for guests
	elseif ($params->get('show_noauth') == true && $user->get('guest')) :
	echo $this->item->introtext;
	//Optional link to let them register to see the whole article.
	if ($params->get('show_readmore') && $this->item->fulltext != null) :
		$link1 = JRoute::_('index.php?option=com_users&view=login');
		$link = new JURI($link1);?>
	<div class="item_readmore">
		<a href="<?php echo $link; ?>" class="btn btn-info readmore">
			<?php $attribs = json_decode($this->item->attribs);
			if ($attribs->alternative_readmore == null) :
			echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
			elseif ($readmore = $this->item->alternative_readmore) :
			echo $readmore;
			if ($params->get('show_readmore_title', 0) != 0) :
			echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
			endif;
			elseif ($params->get('show_readmore_title', 0) == 0) :
			echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
			else :
			echo JText::_('COM_CONTENT_READ_MORE');
			echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
			endif; ?>
		</a>
	</div>
	<?php endif;
	endif;

	if ($params->get('show_tags', 1) && !empty($this->item->tags)) :
	$this->item->tagLayout = new JLayoutFile('joomla.content.tags');

	echo $this->item->tagLayout->render($this->item->tags->itemTags);
	endif;

	echo $this->item->event->afterDisplayContent; 
		
	if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative) :
	echo $this->item->pagination;
	endif; ?>
</article>

<script>
	jQuery(function($){
		$('a[data-fancybox="fancybox"]').fancybox({
	        padding: 0,
	        margin: 0,
	        loop: true,
	        openSpeed:500,
	        closeSpeed:500,
	        nextSpeed:500,
	        prevSpeed:500,
	        afterLoad : function (){
	                    $('.fancybox-inner').click(function(){
	            if(click == true){
	              $('body').toggleClass('fancybox-full');
	            }
	          })
	        },
	        beforeShow: function() {
	          $('body').addClass('fancybox-lock');
	        },
	        afterClose : function() {
	          $('body').removeClass('fancybox-lock');
	                  },
	        tpl : {
	          image    : '<div class="fancybox-image" style="background-image: url(\'{href}\');"/>',
	          iframe: '<span class="iframe-before"/><iframe id="fancybox-frame{rnd}" width="60%" height="60%" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0"' + ($.browser.msie ? ' allowtransparency="true"' : '') + '/>'
	        },
	        helpers: {
	          title : null,
	          thumbs: {
	            height: 50,
	            width: 80
	          },
	          overlay : {
	            css : {
	              'background' : '#191919'
	            }
	          }
	        }
	    });
	})
</script>