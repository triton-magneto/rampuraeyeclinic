<?php defined('_JEXEC') or die('Direct Access to this location is not allowed.');
$app = JFactory::getApplication('site');
$template = $app->getTemplate(true);
require_once JPATH_BASE.'/templates/'. $template->template .'/includes/Mobile_Detect.php';
$detect = new Mobile_Detect;
$document = JFactory::getDocument();
JHtml::_('jquery.framework');
  $document->addScript('templates/'.$template->template.'/js/jquery.mixitup.min.js'); ?>
  <div class="jg_category">
<?php if($this->_config->get('jg_showcathead')): ?>
    <div class="well well-small jg-header">
<?php if($this->params->get('show_feed_icon')): ?>
      <div class="jg_feed_icon">
        <a href="<?php echo $this->params->get('feed_url'); ?>"<?php echo JHTML::_('joomgallery.tip', 'COM_JOOMGALLERY_CATEGORY_FEED_TIPTEXT', 'COM_JOOMGALLERY_CATEGORY_FEED_TIPCAPTION', true); ?>>
          <?php echo JHtml::_('joomgallery.icon', 'feed.png', 'COM_JOOMGALLERY_CATEGORY_FEED_TIPCAPTION'); ?>
        </a>
      </div>
<?php $this->params->set('show_feed_icon', 0);
      endif;
      if($this->params->get('show_headerfavourites_icon')): ?>
      <div class="jg_headerfavourites_icon">
<?php   if($this->params->get('show_headerfavourites_icon') == 1): ?>
        <a href="<?php echo JRoute::_('index.php?task=favourites.addimages&catid='.$this->category->cid); ?>"<?php echo JHTML::_('joomgallery.tip', 'COM_JOOMGALLERY_COMMON_FAVOURITES_ADD_IMAGES_TIPTEXT', 'COM_JOOMGALLERY_COMMON_FAVOURITES_ADD_IMAGES_TIPCAPTION', true); ?>>
          <?php echo JHTML::_('joomgallery.icon', 'star.png', 'COM_JOOMGALLERY_COMMON_FAVOURITES_ADD_IMAGES_TIPCAPTION'); ?></a>
<?php   endif;
        if($this->params->get('show_headerfavourites_icon') == 2): ?>
        <a href="<?php echo JRoute::_('index.php?task=favourites.addimages&catid='.$this->category->cid); ?>"<?php echo JHTML::_('joomgallery.tip', 'COM_JOOMGALLERY_COMMON_DOWNLOADZIP_ADD_IMAGES_TIPTEXT', 'COM_JOOMGALLERY_COMMON_DOWNLOADZIP_ADD_IMAGES_TIPCAPTION', true); ?>>
          <?php echo JHTML::_('joomgallery.icon', 'basket_put.png', 'COM_JOOMGALLERY_COMMON_DOWNLOADZIP_ADD_IMAGES_TIPCAPTION'); ?></a>
<?php   endif;
        if($this->params->get('show_headerfavourites_icon') == -1): ?>
        <span<?php echo JHTML::_('joomgallery.tip', 'COM_JOOMGALLERY_COMMON_FAVOURITES_ADD_IMAGES_NOT_ALLOWED_TIPTEXT', 'COM_JOOMGALLERY_COMMON_FAVOURITES_ADD_IMAGES_TIPCAPTION', true); ?>>
          <?php echo JHTML::_('joomgallery.icon', 'star_gr.png', 'COM_JOOMGALLERY_COMMON_FAVOURITES_ADD_IMAGES_TIPCAPTION'); ?>
        </span>
<?php   endif;
        if($this->params->get('show_headerfavourites_icon') == -2): ?>
        <span<?php echo JHTML::_('joomgallery.tip', 'COM_JOOMGALLERY_COMMON_DOWNLOADZIP_ADD_IMAGES_NOT_ALLOWED_TIPTEXT', 'COM_JOOMGALLERY_COMMON_DOWNLOADZIP_ADD_IMAGES_TIPCAPTION', true); ?>>
          <?php echo JHTML::_('joomgallery.icon', 'basket_put_gr.png', 'COM_JOOMGALLERY_COMMON_DOWNLOADZIP_ADD_IMAGES_TIPCAPTION'); ?>
        </span>
<?php   endif; ?>
      </div>
<?php endif;
      if($this->params->get('show_upload_icon')): ?>
      <div class="jg_upload_icon">
        <a href="<?php echo JRoute::_('index.php?view=mini&format=raw&upload_category='.$this->category->cid); ?>" class="modal<?php echo JHtml::_('joomgallery.tip', 'COM_JOOMGALLERY_COMMON_UPLOAD_ICON_TIPTEXT', 'COM_JOOMGALLERY_COMMON_UPLOAD_ICON_TIPCAPTION'); ?>" rel="{handler: 'iframe', size: {x: 620, y: 550}}">
          <?php echo JHtml::_('joomgallery.icon', 'add.png', 'COM_JOOMGALLERY_COMMON_UPLOAD_ICON_TIPCAPTION'); ?>
        </a>
      </div>
<?php $this->params->set('show_upload_icon', 0);
      endif; ?>
      <?php echo $this->category->name; ?>
    </div>
<?php endif;
      if($this->_config->get('jg_showcatdescriptionincat') == 1): ?>
    <div class="jg_catdescr">
      <?php echo JHTML::_('joomgallery.text', $this->category->description); ?>
    </div>
<?php endif;
      if($this->_config->get('jg_usercatorder')): ?>
    <div class="jg_catorderlist">
      <ul id="sort" class="btn-group">
        <li><a class="sort btn btn-info" data-sort="data-date" data-order="desc"><?php echo JText::_('COM_JOOMGALLERY_CATEGORY_OPTION_USER_ORDERBY_DATE'); ?></a></li>
        <?php if($this->_config->get('jg_showtitle')) : ?><li><a class="sort btn btn-info" data-sort="data-name" data-order="desc"><?php echo JText::_('COM_JOOMGALLERY_CATEGORY_OPTION_USER_ORDERBY_TITLE'); ?></a></li><?php endif; ?>
        <?php if($this->_config->get('jg_showhits')): ?><li><a class="sort btn btn-info" data-sort="data-popularity" data-order="desc"><?php echo JText::_('COM_JOOMGALLERY_CATEGORY_OPTION_USER_ORDERBY_HITS'); ?></a></li><?php endif; ?>
        <?php if($this->_config->get('jg_showcatrate')): ?><li><a class="sort btn btn-info" data-sort="data-rating" data-order="desc"><?php echo JText::_('COM_JOOMGALLERY_CATEGORY_OPTION_USER_ORDERBY_RATING'); ?></a></li><?php endif; ?>
        <?php if($this->_config->get('jg_showauthor')): ?><li><a class="sort btn btn-info" data-sort="data-author" data-order="desc"><?php echo str_replace(':','',JText::sprintf('COM_JOOMGALLERY_COMMON_AUTHOR_VAR', ''));?></a></li><?php endif; ?>
        <?php if($this->_config->get('jg_showdownloads')): ?><li><a class="sort btn btn-info" data-sort="data-downloads" data-order="desc"><?php echo str_replace(':','',JText::sprintf('COM_JOOMGALLERY_COMMON_DOWNLOADS_VAR', ''));?></a></li><?php endif; ?>
        <?php if($this->_config->get('jg_showcatcom')): ?><li><a class="sort btn btn-info" data-sort="data-comments" data-order="desc"><?php echo str_replace(':','',JText::sprintf('COM_JOOMGALLERY_COMMON_COMMENTS_VAR', ''));?></a></li><?php endif; ?>
      </ul>
    </div>
<?php endif; ?>
  </div>
<script>
  jQuery(document).ready(function($) {
    $(window).load(function(){

      var $container = $('#jg_gallery');

      $container.mixitup({
        targetSelector: '.gallery-item',
        filterSelector: '.filter',
        sortSelector: '.sort',
        buttonEvent: 'click',
        effects: ['fade','scale','rotateZ'],
        listEffects: null,
        easing: 'smooth',
        layoutMode: 'grid',
        targetDisplayGrid: 'inline-block',
        targetDisplayList: 'block',
        gridClass: 'grid',
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
        }
      });
      var click = true;
      $('a[data-fancybox="fancybox"]').fancybox({
        padding: 0,
        margin: 0,
        loop: true,
        openSpeed:500,
        closeSpeed:500,
        nextSpeed:500,
        prevSpeed:500,
        afterLoad : function (){
          <?php if( $detect->isMobile() || $detect->isTablet() ){ ?>
          $('body').swipe({
            swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
              click = false;
              if(direction == 'left'){
                $.fancybox.next()
              }
              if(direction == 'right'){
                $.fancybox.prev()
              }
              setTimeout(function(){
                click = true;
              },100)
            }
          })*
          <?php } ?>
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
          <?php if( $detect->isMobile() || $detect->isTablet() ){ ?>
          $('body').swipe('destroy')
          <?php } ?>
        },
        tpl : {
          image    : '<div class="fancybox-image" style="background-image: url(\'{href}\');"></div>'
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