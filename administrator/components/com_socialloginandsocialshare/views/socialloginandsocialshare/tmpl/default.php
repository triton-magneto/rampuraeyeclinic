<?php
/*------------------------------------------------------------------------
# mod_SocialLoginandSocialShare
# ------------------------------------------------------------------------
# author    LoginRadius inc.
# copyright Copyright (C) 2013 loginradius.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.loginradius.com
# Technical Support:  Forum - http://community.loginradius.com/
-------------------------------------------------------------------------*/

// no direct access
defined ('_JEXEC') or die ('Direct Access to this location is not allowed.');

JHtml::_('behavior.tooltip');

jimport ('joomla.plugin.helper');
jimport('joomla.html.pane');
?>
<form action="<?php echo JRoute::_('index.php?option=com_socialloginandsocialshare&view=socialloginandsocialshare&layout=default'); ?>" method="post" name="adminForm" id="adminForm">
<div>
  <div style="float:left; width:70%;">
    <div>
	  <fieldset class="sociallogin_form sociallogin_form_main" style="background:#EAF7FF; border: 1px solid #B3E2FF;">
      <div class="lrrow lrrow_title" style="color: #000000; font-weight:normal;">
        <?php echo JText::_('COM_SOCIALLOGIN_THANK'); ?>
      </div>
      <div class="lrrow" style="line-height:160%;">
        <?php echo JText::_('COM_SOCIALLOGIN_THANK_BLOCK'); ?> 
      </div>
      <div class="lrrow" style="line-height:160%;">
        <?php echo JText::_('COM_SOCIALLOGIN_THANK_BLOCK_TWO'); ?> 
      </div>
      
      </fieldset>
    </div>
<?php	
   if(class_exists('JPane')){
        $pane = JPane::getInstance('tabs', array('startOffset'=>2, 'allowAllClose'=>true, 'opacityTransition'=>true, 'duration'=>600)); 
        echo $pane->startPane( 'pane' );
        echo $pane->startPanel( JText::_('COM_SOCIALLOGIN_PANEL_LOGIN'), 'panel1' );
    }
    else{
        $options = array(
    'onActive' => 'function(title, description){
        description.setStyle("display", "block");
		title.addClass("open").removeClass("closed");
	}',
    'onBackground' => 'function(title, description){
        description.setStyle("display", "none");
        title.addClass("closed").removeClass("open");
    }',

    'startOffset' => 0,  // 0 starts on the first tab, 1 starts the second, etc...
    'useCookie' => true, // this must not be a string. Don't use quotes.
);
 
		echo JHtml::_('tabs.start', 'pane', $options);		
		echo JHtml::_('tabs.panel', JText::_('COM_SOCIALLOGIN_PANEL_LOGIN'), 'panel1');
    }

?>
<!-- social login -->
<div>
	<?php echo $this->loadTemplate('facebook');?>
    <?php echo $this->loadTemplate('google');?>
</div>
<?php if(class_exists('JPane')){echo $pane->endPanel();}?>
<!-- End social login -->

<!-- social share -->
<?php if(class_exists('JPane')){echo $pane->startPanel( JText::_('COM_SOCIALLOGIN_PANEL_SHARE'), 'panel2' );}
else{echo JHtml::_('tabs.panel', JText::_('COM_SOCIALLOGIN_PANEL_SHARE'), 'panel2');}?>
<div>
  <?php echo $this->loadTemplate('share');?>
</div>
<?php if(class_exists('JPane')){echo $pane->endPanel();}?>
<!-- End social share -->

</div>
<div style="float:right; width:29%;">
<div style="background:#EAF7FF; border: 1px solid #B3E2FF; overflow:auto; margin:0 0 10px 0;">
	<h3 style="border-bottom:#000000 1px solid; margin:0px; padding:0 0 6px 0; border-bottom: 1px solid #B3E2FF; color: #000000; margin:10px;"><?php echo JText::_('COM_SOCIALLOGIN_EXTENSION_HELP'); ?></h3>
	<ul class="help_ul">
        <li><a href="http://support.loginradius.com/customer/portal/articles/1299418-joomla-social-login-and-social-share-installation-and-configuration" target="_blank"><?php echo JText::_('COM_SOCIALLOGIN_EXTENSION_HELP_LINK_ONE'); ?></a></li>
        <li><a href="http://community.loginradius.com/" target="_blank"><?php echo JText::_('COM_SOCIALLOGIN_EXTENSION_HELP_LINK_FOUR'); ?></a></li>
        <li><a href="https://www.loginradius.com/loginradius/Team" target="_blank"><?php echo JText::_('COM_SOCIALLOGIN_EXTENSION_HELP_LINK_FIVE'); ?></a></li>
        <li><a href="https://www.loginradius.com/loginradius/product-overview" target="_blank"><?php echo JText::_('COM_SOCIALLOGIN_EXTENSION_HELP_LINK_SIX'); ?></a></li>
</ul>
</div>
<div style="clear:both;"></div>

<div style="background:#EAF7FF; border: 1px solid #B3E2FF;  margin:0 0 10px 0; overflow:auto;">
	<h3 style="border-bottom:#000000 1px solid; margin:0px; padding:0 0 6px 0; border-bottom: 1px solid #B3E2FF; color: #000000; margin:10px;"><?php echo JText::_('COM_SOCIALLOGIN_STAY_UPDATE'); ?></h3>
	<p align="justify" style="line-height: 19px;font-size:12px !important;margin:10px;">
<?php echo JText::_('COM_SOCIALLOGIN_EXTENSION_TECH_SUPPORT_TEXT_ONE'); ?> </p>
	<ul class="stay_ul">
  <li class="first">
    <iframe rel="tooltip" scrolling="no" frameborder="0" allowtransparency="true" style="border: none; overflow: hidden; width: 46px; height: 70px;" src="//www.facebook.com/plugins/like.php?app_id=194112853990900&amp;href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FLoginRadius%2F119745918110130&amp;send=false&amp;layout=box_count&amp;width=90&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=90" data-original-title="Like us on Facebook"></iframe>
  </li>
</ul>
	<div>
</div>
</div>
 </div>
	</div>
	<input type="hidden" name="task" value="" />
</form>