<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_tm_templates
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$module_vars = get_object_vars(JModuleHelper::getModule('mod_tm_templates'));

  $db = JFactory::getDbo();

  $query = $db->getQuery(true);

  //Build the query
  $query->update("#__modules");
  $query->set('published = '.$db->quote(0));
  $query->where('module = '. $db->quote('mod_tm_templates'));
  $db->setQuery($query);

  if (isset($_POST['recent_close'])){
    $result = $db->execute();    
  }  

  echo $module->content;
?>

<style type="text/css">
  iframe{min-height: 490px !important;}
  form{margin: 0;}
  .recent-templates{position: relative; padding-top: 10px; border-top: 1px solid #ddd; margin-top: 8px;}
  .recent-templates .close {position: absolute; right: 10px; top: -33px;}
</style>

<script src="<?php echo JURI::base(); ?>/modules/mod_tm_templates/js/jquery.form.js"></script>

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function(){
    var message = "<?php echo JText::_('MOD_TM_DISABLE_MESSAGE');?>"
    jQuery('.recent-templates').parent().addClass('parent-container');
    jQuery('#close').click(function(){
      jQuery('.parent-container').hide('slow');
      jQuery('.parent-container').before('<div class="alert alert-block">' + message +  '</div>');
    });
    jQuery('#mod_disable').ajaxForm(function() {});
  });
</script>

<div class="recent-templates">
  <form id="mod_disable" method="POST" action="">
    <input class="close" id="close" name="recent_close" type="submit" value="×"/>
  </form>

  <!-- Templates list code start. -->
  <script 
    type="text/javascript" 
    src="http://www.templatehelp.com/codes/pr_interface.php?cols=5&amp;rows=2&amp;sadult=1&amp;sp=0&amp;bgcolor=%23f5f5f5&amp;type=24&amp;category=0&amp;pr_code=hiyOCf46qfOK7FAA1B2HOFawIZNB87 
    <http://www.templatehelp.com/codes/pr_interface.php?cols=5&amp;rows=2&amp;sadult=1&amp;sp=0&amp;bgcolor=%23f5f5f5&amp;type=24&amp;category=0&amp;pr_code=hiyOCf46qfOK7FAA1B2HOFawIZNB87>">
  </script>
  <!-- Templates list code end. -->
</div>
