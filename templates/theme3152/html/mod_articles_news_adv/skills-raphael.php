<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

  JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

  $n = count($list);

  if($n<$columns){
    $columns = $n;
  }

        $spanClass = 'span'.floor($params->get('bootstrap_size')/$columns);
        $rows = ceil($n/$columns);

$app    = JFactory::getApplication(); 
$doc = JFactory::getDocument();
$document =& $doc;
$template = $app->getTemplate();

$document->addScript('templates/'.$template.'/html/mod_articles_news_adv/js/raphael.js');

?>
<div class="mod-newsflash-adv mod-newsflash-adv__<?php echo $moduleclass_sfx; ?> cols-<?php echo $columns; ?>" id="module_<?php echo $module->id; ?>">
  <?php if ($params->get('pretext')): ?>
  <div class="pretext">
    <?php echo $params->get('pretext') ?>
  </div>
  <?php endif; ?>
  <div id="diagram_<?php echo $module->id; ?>" class="skills_diagram"></div>
  <div class="get">
  <?php for ($i = 0, $n; $i < $n; $i ++) :
    $item = $list[$i];
  ?>
  <div class="arc">
    <?php require JModuleHelper::getLayoutPath('mod_articles_news_adv', '_skills-raphael'); ?>
  </div>
  <?php endfor; ?>
  </div>

  <?php if($params->get('mod_button') == 1): ?>   
  <div class="mod-newsflash-adv_custom-link">
    <?php 
      $menuLink = $menu->getItem($params->get('custom_link_menu'));

        switch ($params->get('custom_link_route')) 
        {
          case 0:
            $link_url = $params->get('custom_link_url');
            break;
          case 1:
            $link_url = JRoute::_($menuLink->link.'&Itemid='.$menuLink->id);
            break;            
          default:
            $link_url = "#";
            break;
        }
        echo '<a class="btn btn-info" href="'. $link_url .'">'. $params->get('custom_link_title') .'</a>';
    ?>
  </div>
  <?php endif; ?>
</div>
<script>
  jQuery(document).ready(function() {
    (function($){ 
  var o = {
  random: function(l, u){
    return Math.floor(((u-l+1))+l);
  },
  diagram: function(){

    //

    var stroke_width = 26,
    stroke_width_hover = 50,
    stroke_space = 4,
    core_radius = 85,
    core_bg = '#193340',
    font = '13px Arial',
    font_color = '#fff',

    //

    defaultText = '<?php echo $module->title; ?>',
    speed = 250,
    window_width = window.document.documentElement.clientWidth - 40,
    width = (<?php echo $n - 1; ?>*(stroke_width + stroke_space) + core_radius + stroke_width_hover)*2;
    if (width > window_width) {
      stroke_width = window_width*stroke_width/width;
      stroke_width_hover = window_width*stroke_width_hover/width;
      stroke_space = window_width*stroke_space/width;
      core_radius = window_width*core_radius/width;
      width = window_width;
    }
    var rad = core_radius - stroke_width/2;
    if($('#diagram_<?php echo $module->id; ?> svg').length){
      $('#diagram_<?php echo $module->id; ?> svg').remove()
    }
    var r = Raphael('diagram_<?php echo $module->id; ?>', width, width);
    
    r.circle(width/2, width/2, core_radius).attr({ stroke: 'none', fill: core_bg });
    
    var title = r.text(width/2, width/2, defaultText).attr({
      font: font,
      fill: font_color
    }).toFront();
    
    r.customAttributes.arc = function(value, color, rad){
      var v = 3.6*value,
        alpha = v == 360 ? 359.99 : v,
        random = o.random(91, 240),
        a = (random-alpha) * Math.PI/180,
        b = random * Math.PI/180,
        sx = width/2 + rad * Math.cos(b),
        sy = width/2 - rad * Math.sin(b),
        x = width/2 + rad * Math.cos(a),
        y = width/2 - rad * Math.sin(a),
        path = [['M', sx, sy], ['A', rad, rad, 0, +(alpha > 180), 1, x, y]];
      return { path: path, stroke: color }
    }
    
    jQuery('#module_<?php echo $module->id; ?> .get').find('.arc').each(function(i){
      var t = $(this), 
        color = t.find('.color').val(),
        value = t.find('.percent').val(),
        text = t.find('.text').text();
      
      rad += stroke_width + stroke_space;  
      var z = r.path().attr({ arc: [value, color, rad], 'stroke-width': stroke_width });
      
      z.mouseover(function(){
        this.animate({ 'stroke-width': stroke_width_hover, opacity: .75 }, speed*4, 'elastic');
        if(Raphael.type != 'VML') //solves IE problem
        this.toFront();
        title.stop().animate({ opacity: 0 }, speed, '>', function(){
          this.attr({ text: text + '\n' + value + '%' }).animate({ opacity: 1 }, speed, '<');
        });
            }).mouseout(function(){
        this.stop().animate({ 'stroke-width': stroke_width, opacity: 1 }, speed*4, 'elastic');
        title.stop().animate({ opacity: 0 }, speed, '>', function(){
          title.attr({ text: defaultText }).animate({ opacity: 1 }, speed, '<');
        }); 
      });
    });
  }
}
jQuery(window).resize(function(){
  o.diagram();
})
o.diagram();
  })(jQuery);
}); 
</script>