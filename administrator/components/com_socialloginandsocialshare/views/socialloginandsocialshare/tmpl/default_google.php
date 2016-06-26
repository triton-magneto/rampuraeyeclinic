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
  <tr>
    <td colspan="2" ><span class="lrsubhead"> <?php echo JText::_('COM_SOCIALLOGIN_GOOGLE_SUBHEAD'); ?></span>
	  <br/><br />
      <?php  $enableLogin = "";
           $disableLogin= "";
           $genable = (isset($this->settings['genable'])  ? $this->settings['genable'] : "");
           if ($genable == '0') $disableLogin = "checked='checked'";
           else if ($genable == '1') $enableLogin = "checked='checked'";
           else $enableLogin = "checked='checked'";?>
     <input name="settings[genable]" type="radio" value="1" <?php echo $enableLogin; ?> /> <?php echo JText::_('COM_SOCIALLOGIN_GYES'); ?> 
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <input name="settings[genable]" type="radio" value="0" <?php echo $disableLogin; ?> /> <?php echo JText::_('COM_SOCIALLOGIN_GNO'); ?> 
	</td>
  </tr>
  <tr class="lrrow_white">
    <td colspan="2" ><span class="lrsubhead"> <?php echo JText::_('COM_SOCIALLOGIN_GAPIKEY_SUBHEAD'); ?></span>
	  <br/><br />
      <div class="loginRadiusProviders"><?php echo JText::_('COM_SOCIALLOGIN_GAPIKEY'); ?></div>
      <input size="60" type="text" name="settings[gapikey]" id="gapikey" value="<?php echo (isset ($this->settings ['gapikey']) ? htmlspecialchars ($this->settings['gapikey']) : ''); ?>" />
      <br /><br />
	  <div class="loginRadiusProviders"><?php echo JText::_('COM_SOCIALLOGIN_GAPISECRET'); ?></div><input size="60" type="text" name="settings[gapisecret]" id="gapisecret" value="<?php echo (isset ($this->settings ['gapisecret']) ? htmlspecialchars ($this->settings ['gapisecret']) : ''); ?>" />
	</td>
  </tr>
  <tr>
  <td>
  <div class="loginRadiusProviders"><?php echo JText::_('COM_SOCIALLOGIN_GCALLBACK'); ?></div><span class="lrsubhead"><?php echo JURI::root().'?provider=google';?></span>
  </td>
  </tr>
</table>