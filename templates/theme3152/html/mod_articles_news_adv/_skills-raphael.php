<?php
/**
 * Articles Newsflash Advanced
 *
 * @author    TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2013 Jetimpex, Inc.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
 * Parts of this software are based on Articles Newsflash standard module
 * 
*/
defined('_JEXEC') or die;
$item_heading = $params->get('item_heading', 'h4');
$item_images = json_decode($item->images);
$urls    = json_decode($item->urls); ?>
<span class="text" style="background: <?php echo $item_images->image_intro_alt; ?>"><?php echo $item->title; ?></span>
<input type="hidden" class="percent" value="<?php echo $item_images->image_intro_caption; ?>" />
<input type="hidden" class="color" value="<?php echo $item_images->image_intro_alt; ?>" />