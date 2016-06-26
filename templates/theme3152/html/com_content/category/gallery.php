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
$document = JFactory::getDocument();
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
JHtml::_('behavior.caption');
function special_chars_replace($string){
  $result = preg_replace("/[&%\$#@'\*:\/\"\[\]\{\};\(\)\|\\\=!\^\?`~.,\+-]/", "", $string);
  return $result;
}

function limit_words($string, $word_limit){
  $words = explode (" ",strip_tags($string));
  return implode (" ",array_splice ($words,0,$word_limit));
}
if ($this->params->get('user_hover')){
  $hover_active = 'hover_true';
  switch ($this->params->get('hover_style')) {
    case 'style1':
      $item_hover_style = "style1";
      break;
        case 'style1':
      $item_hover_style = "style1";
      break;
        case 'style2':
      $item_hover_style = "style2";
      break;
        case 'style3':
      $item_hover_style = "style3";
      break;
        case 'style4':
      $item_hover_style = "style4";
      break;
        case 'style5':
      $item_hover_style = "style5";
      break;
        case 'style6':
      $item_hover_style = "style6";
      break;
        case 'style7':
      $item_hover_style = "style7";
      break;
    
    default:
      $item_hover_style = "style1";
      break;
  }
  $document->addStyleSheet('templates/'. $template->template .'/css/hover_styles/'.$item_hover_style.'.css');
} else {
  $item_hover_style = "";
  $hover_active = "hover_false";
}
  $document->addScript('templates/'.$template->template.'/js/jquery.mixitup.min.js');
?>
<div class="note"></div>
<section class="page-gallery page-gallery__<?php echo $this->pageclass_sfx;?>">
  <?php if ($this->params->get('show_page_heading', 1)) : ?>
  <header class="page_header">
    <<?php echo $template->params->get('categoryPageHeading','h3'); ?>><?php echo $this->escape($this->params->get('page_heading')); ?></<?php echo $template->params->get('categoryPageHeading','h3'); ?>>
  </header>
  <?php endif;
  if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
  <header class="category_title">
    <h2> <?php echo $this->escape($this->params->get('page_subheading'));
      if ($this->params->get('show_category_title')) : ?>
      <span class="subheading-category"><?php echo $this->category->title;?></span>
      <?php endif; ?>
    </h2>
  </header>
  <?php endif;
  if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
  <div class="category_desc">
    <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
    <img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
    <?php endif;
    if ($this->params->get('show_description') && $this->category->description) :
    echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category');
    endif; ?>
    <div class="clr"></div>
  </div>
  <?php endif;
  $galleryCategories = array();
  foreach ($this->intro_items as $key => &$item){
      $categoryTitle = $item->category_title;
      $galleryCategories[] = $categoryTitle;
  };
  $galleryCategories = array_unique($galleryCategories);
  if((!empty($this->lead_items) || (!empty($this->intro_items)))): ?>
  <!-- Filter -->
  <?php if($this->params->get('show_layout_mode')): ?>
  <div class="layout-mode">
    <b><?php echo JText::_('TPL_COM_CONTENT_LAYOUT_MODE'); ?></b>
    <ul id="grid-list" class="btn-group">
      <li><a class="btn btn-info toGrid active"><i class="fa fa-th-large"></i></a></li>
      <li><a class="btn btn-info toList"><i class="fa fa-bars"></i></a></li>
    </ul>
  </div>
  <?php endif;
  if($this->params->get('show_filter')): ?>
  <div class="filters">
    <b><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_BY_CATEGORY'); ?></b>
    <ul id="filters" class="btn-group">
      <li><a class="filter active btn btn-info" data-filter="all"><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_SHOW_ALL'); ?></a></li>
      <?php foreach ($galleryCategories as $key => $value) : ?>
      <li><a class="filter" data-filter="<?php echo special_chars_replace(mb_strtolower(str_replace(" ","",$value))); ?>"><?php echo $value; ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif;
  if($this->params->get('show_sort')): ?>
  <div class="sorting">
    <ul id="sort" class="btn-group">
      <li><a class="sort desc" data-sort="data-name" data-order="desc"><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_NAME'); ?></a></li>
      <li><a class="sort desc" data-sort="data-date" data-order="desc"><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_DATE'); ?></a></li>
      <li><a class="sort asc" data-sort="data-popularity" data-order="desc"><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_POPULARITY'); ?></a></li>
      <!-- <li><a class="sort btn btn-info" data-sort="random"><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_RANDOM'); ?></a></li> -->
    </ul>
  </div>
  <?php endif;
  endif;
  $leadingcount = 0;
  if (!empty($this->lead_items)) : ?>
  <div class="items-leading">
    <?php foreach ($this->lead_items as &$item) : ?>
    <article class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
      <?php
      $this->item = &$item;
      echo $this->loadTemplate('item');
      ?>
    </article>
    <div class="clearfix"></div>
    <?php $leadingcount++;
    endforeach; ?>
  </div><!-- end items-leading -->
  <div class="clearfix"></div>
  <?php endif;


    $introcount = (count($this->intro_items));
    $counter = 0;

  if (!empty($this->intro_items)) :
  $row = $counter / $this->columns; ?>
  <div id="isotopeContainer" class="gallery items-row row-fluid cols-<?php echo (int) $this->columns;?> <?php echo $hover_active; ?>">
    <?php foreach ($this->intro_items as $key => &$item) :
    $rowcount = (((int) $key) % (int) $this->columns) + 1;

    if ($rowcount == 1) :  
    endif;
  
    $this->item = &$item; ?>
    <div class="gallery-item mix mix_all gallery-grid span12 <?php echo $item_hover_style; ?> <?php echo special_chars_replace(mb_strtolower(str_replace(" ","",$item->category_title))); ?>" data-date="<?php echo JHtml::_('date', $this->item->publish_up, 'YmdHis'); ?>" data-name="<?php echo $this->item->title; ?>" data-popularity="<?php echo $this->item->hits; ?>">
      <?php
      $this->item = &$item;
      echo $this->loadTemplate('item');
      $counter++; ?>
      <div class="clearfix"></div>
    </div>
    <?php if (($rowcount == $this->columns) or ($counter == $introcount)):    
      
    endif;
  
    endforeach; ?>
    <li class="gap span12"></li>
    <li class="gap span12"></li>
    <li class="gap span12"></li>
  </div>
  <?php endif;
  
  if (!empty($this->link_items)) : ?>
  <div class="items-more">
    <?php echo $this->loadTemplate('links'); ?>
  </div>
  <?php endif;


  if (!empty($this->children[$this->category->id])&& $this->maxLevel != 0) : ?>
  <div class="category_children">
    <div class="row">
      <!-- <h3> <?php /*echo JTEXT::_('JGLOBAL_SUBCATEGORIES');*/ ?> </h3> -->
      <?php echo $this->loadTemplate('children'); ?>
    </div>
  </div>
  <?php endif;

  if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>  
  <div class="pagination">
    <?php  if ($this->params->def('show_pagination_results', 1)) : ?>
    <p class="counter"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
    <?php endif;
    echo $this->pagination->getPagesLinks(); ?> </div>
  <?php  endif; ?>
</section>

<script>
  jQuery(document).ready(function($) {
    $(window).load(function(){

      var $cols = <?php echo $this->columns; ?>;
      var $container = $('#isotopeContainer');

      $item = $('.gallery-item')

      $container.mixitup({
        targetSelector: '.gallery-item',
        filterSelector: '.filter',
        sortSelector: '.sort',
        buttonEvent: 'click',
        effects: [<?php echo  $this->params->get('sort_effects');?>],
        listEffects: null,
        easing: 'smooth',
        layoutMode: 'grid',
        targetDisplayGrid: 'inline-block',
        targetDisplayList: 'block',
        gridClass: 'grid',
        listClass: 'list',
        transitionSpeed: 600,
        showOnLoad: 'all',
        sortOnLoad: false,
        multiFilter: false,
        filterLogic: 'or',
        resizeContainer: true,
        minHeight: 0,
        failClass: 'fail',
        perspectiveDistance: '3000',
        perspectiveOrigin: '50% 50%',
        animateGridList: true,
        onMixLoad: function(){
          $container.addClass('loaded');
        },
        onMixStart: function(config){
          if(config.layoutMode == 'list'){
            config.effects = ['fade','scale']
          }
          else{
            config.effects = [<?php echo  $this->params->get('sort_effects');?>]
            $container.find('.mix').removeClass('gallery-list').addClass('gallery-grid');
          }
        },
        onMixEnd: function(config){
          if(config.layoutMode == 'list'){
            $container.find('.mix').addClass('gallery-list').removeClass('gallery-grid');
          }
        }
      });

      $('.toGrid').click(function(){
        $('.layout-mode a').removeClass('active');
        $(this).addClass('active');
        $container.mixitup('toGrid')
      })

      $('.toList').click(function(){
        $('.layout-mode a').removeClass('active');
        $(this).addClass('active');
        $container.mixitup('toList');

      })

      $('ul#isotopeContainer a[data-fancybox="fancybox"]').fancybox({
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
            width: 80,
            source  : function(current) {
                return $(current.element).data('thumbnail');
            }
          },
          overlay : {
            css : {
              'background' : '#191919'
            }
          }
        }
      });
      $('#sort .sort').click(function(){
        $('#sort .sort').removeClass('selected').removeClass('active');
        $(this).addClass('selected');
        if($(this).attr('data-order')=='desc'){
          $(this).attr('data-order', 'asc')
        }
        else{
          $(this).attr('data-order', 'desc')
        }
      })
   });
}); 
</script>