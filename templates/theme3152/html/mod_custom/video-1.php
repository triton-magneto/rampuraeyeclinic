<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="mod-custom mod-custom__<?php echo $moduleclass_sfx ?>" id="module_<?php echo $module->id; ?>">
  <div class="video-container" id="video-<?php echo $module->id; ?>"></div>
  <div class="module-content">
    <div class="module-content-inner">
      <?php echo $module->content;?>
    </div>
  </div>
</div>
<script>
jQuery(function($){
	$autoplay = $("#module_<?php echo $module->id; ?> a[data-control]").attr('data-control') == 'play' ? false : true;
	$("#video-<?php echo $module->id; ?>").vide('<?php echo JURI::base(); ?>media/video/video', {
	    autoplay: $autoplay
	});
	var instance = $("#video-<?php echo $module->id; ?>").data("vide");
	if(instance.getVideoObject()){
		$("#module_<?php echo $module->id; ?> a[data-control]").click(function(){
			$(this).attr('data-control') == 'play' ? instance.getVideoObject().play() : instance.getVideoObject().pause();
			$(this).attr('data-control') == 'play' ? $(this).attr('data-control','pause') : $(this).attr('data-control','play');
			return false;
		})
	}
	else{
		$("#module_<?php echo $module->id; ?> a[data-control]").remove();
	}
})
</script>