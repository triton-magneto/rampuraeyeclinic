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
?>
<table class="form-table sociallogin_table">
  <tr>
    <th class="head" colspan="2"><?php echo JText::_('COM_SOCIALLOGIN_APP_HEAD_SETTING'); ?></small></th>
  </tr>
  <tr >
    <td colspan="2" ><span class="lrsubhead"> <?php echo JText::_('COM_SOCIALLOGIN_FACEBOOK_SUBHEAD'); ?></span>
	  <br/><br />
      <?php 
			$fbenableLogin = "";
           $fbdisableLogin= "";
           $fbenable = (isset($this->settings['fbenable'])  ? $this->settings['fbenable'] : "");
           if ($fbenable == '0') $fbdisableLogin = "checked='checked'";
           else if ($fbenable == '1') $fbenableLogin = "checked='checked'";
           else $fbenableLogin = "checked='checked'";?>
     <input name="settings[fbenable]" type="radio" value="1" <?php echo $fbenableLogin; ?> /> <?php echo JText::_('COM_SOCIALLOGIN_FBYES'); ?> 
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <input name="settings[fbenable]" type="radio" value="0" <?php echo $fbdisableLogin; ?> /> <?php echo JText::_('COM_SOCIALLOGIN_FBNO'); ?> 
	</td>
  </tr>
  <tr class="lrrow_white"><td><span class="lrsubhead"> <?php echo JText::_('COM_SOCIALLOGIN_TITLE_SUBHEAD'); ?></span><br /><br />
  <input size="60" type="text" name="settings[logintitle]" id="logintitle" value="<?php echo (isset ($this->settings ['logintitle']) ? htmlspecialchars ($this->settings ['logintitle']) : ''); ?>" />
  
  </td></tr>
  <tr>
    <td colspan="2" ><span class="lrsubhead"> <?php echo JText::_('COM_SOCIALLOGIN_FBAPIKEY_SUBHEAD'); ?></span>
	  <br/><br />
      <div class="loginRadiusProviders"><?php echo JText::_('COM_SOCIALLOGIN_FBAPIKEY'); ?></div><input size="60" type="text" name="settings[fbapikey]" id="fbapikey" value="<?php echo (isset ($this->settings ['fbapikey']) ? htmlspecialchars ($this->settings ['fbapikey']) : ''); ?>" />
      <br /><br />
	  <div class="loginRadiusProviders"><?php echo JText::_('COM_SOCIALLOGIN_FBAPISECRET'); ?></div><input size="60" type="text" name="settings[fbapisecret]" id="fbapisecret" value="<?php echo (isset ($this->settings ['fbapisecret']) ? htmlspecialchars ($this->settings ['fbapisecret']) : ''); ?>" />
	</td>
  </tr>
  <tr class="lrrow_white">
  <td>
  <div class="loginRadiusProviders"><?php echo JText::_('COM_SOCIALLOGIN_FBCALLBACK'); ?></div><span class="lrsubhead"><?php echo JURI::root().'?provider=facebook';?></span>
  </td>
  </tr>
