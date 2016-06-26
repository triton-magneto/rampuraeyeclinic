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
    <th class="head" colspan="2"><?php echo JText::_('COM_SOCIALSHARE_HEAD'); ?></th>
  </tr>
  <tr>
    <td><span class="lrsubhead"> <?php echo JText::_('COM_SOCIALSHARE_SUBHEAD'); ?></span><br /><br />
      <?php  $enableshare = "";
           $disableshare= "";
           $share = (isset($this->settings['share'])  ? $this->settings['share'] : "");
           if ($share == '0') $disableshare = "checked='checked'";
           else if ($share == '1') $enableshare = "checked='checked'";
           else $enableshare = "checked='checked'";?>
     <input name="settings[share]" type="radio" value="1" <?php echo $enableshare; ?> /> <?php echo JText::_('COM_SOCIALSHARE_SHARE_YES'); ?> 
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <input name="settings[share]" type="radio" value="0" <?php echo $disableshare; ?> /> <?php echo JText::_('COM_SOCIALSHARE_SHARE_NO'); ?> 
	</td>
  </tr>
  <tr class="lrrow_white"><td><span class="lrsubhead"> <?php echo JText::_('COM_SOCIALSHARE_SHARETITLE_SUBHEAD'); ?></span><br /><br />
  <input size="60" type="text" name="settings[sharetitle]" id="sharetitle" value="<?php echo (isset ($this->settings ['sharetitle']) ? htmlspecialchars ($this->settings ['sharetitle']) : ''); ?>" />
  
  </td></tr>
  <tr>
    <td><span class="lrsubhead"> <?php echo JText::_('COM_SOCIALSHARE_INTERFACE_SUBHEAD'); ?></span><br /><br />
      <?php  
			$fblike = "";
			$fbsend= "";
			$googleplus= "";
			$googleshare= "";
			$fblikeenable = (isset($this->settings['fblike']) == 'on'  ? 'on' : 'off');
			$fbsendenable = (isset($this->settings['fbsend']) == 'on'  ? 'on' : 'off');
			$googleplusenable = (isset($this->settings['googleplus']) == 'on'  ? 'on' : 'off');
			$googleshareenable = (isset($this->settings['googleshare']) == 'on'  ? 'on' : 'off');
			if ($fblikeenable == 'on'){ $fblike = "checked='checked'";}
			if ($fbsendenable == 'on'){ $fbsend = "checked='checked'";}
			if ($googleplusenable == 'on'){ $googleplus = "checked='checked'";}
			if ($googleshareenable == 'on'){ $googleshare = "checked='checked'";}
	?>
    <div class="loginRadiusProviders">
     <input name="settings[fblike]" id="fblike" type="checkbox" <?php echo $fblike;?> value="on"  style="float: left !important;margin: 0; padding: 0;"/>
     <label class="socialTitle" for="fblike" style=" float: left;  line-height: 5px;"> <?php echo JText::_('COM_SOCIALSHARE_FACEBOOK_LIKE'); ?></label>
    </div>
    <div class="loginRadiusProviders">
     <input name="settings[fbsend]" id="fbsend" type="checkbox" <?php echo $fbsend;?> value="on" style="float: left !important;margin: 0; padding: 0;"  />
     <label class="socialTitle" for="fbsend" style=" float: left;  line-height: 5px;"> <?php echo JText::_('COM_SOCIALSHARE_FACEBOOK_SEND'); ?></label>
     </div>
     <div class="loginRadiusProviders">
     <input name="settings[googleplus]" id="googleplus" type="checkbox" <?php echo $googleplus;?> value="on"  style="float: left !important;margin: 0; padding: 0;" />
     <label class="socialTitle" for="googleplus" style=" float: left;  line-height: 5px;"> <?php echo JText::_('COM_SOCIALSHARE_GOOGLE_PLUS'); ?></label>
     </div>
     <div class="loginRadiusProviders">
     <input name="settings[googleshare]" id="googleshare" type="checkbox" <?php echo $googleshare;?> value="on" style="float: left !important;margin: 0; padding: 0;" />
     <label class="socialTitle" for="googleshare" style=" float: left;  line-height: 5px;"> <?php echo JText::_('COM_SOCIALSHARE_GOOGLE_SHARE'); ?></label>
     </div>
	</td>
  </tr>
<tr class="lrrow_white">
<td><span class="lrsubhead"> <?php echo JText::_('COM_SOCIALSHARE_POSITION_SUBHEAD'); ?></span><br /><br />
	 <?php 
			$shareontop = "";
			$shareonbottom = "";
			$shareontoppos = (isset($this->settings['shareontoppos']) == 'on'  ? 'on' : 'off');
        	if ($shareontoppos == 'on'){ $shareontop = "checked='checked'";}
			$shareonbottompos = (isset($this->settings['shareonbottompos']) == 'on'  ? 'on' : 'off');
       		if ($shareonbottompos == 'on'){ $shareonbottom = "checked='checked'";}
			?>
            <div class="loginRadiusProviders">
             <input name="settings[shareontoppos]" type="checkbox" id="shareontoppos"  <?php echo $shareontop;?> value="on" style="float: left !important;margin: 0; padding: 0;" />
             <label class="socialTitle" for="shareontoppos" style=" float: left;  line-height: 5px;"><?php echo JText::_('COM_SOCIALSHARE_POSITION_TOP'); ?></label>
             </div>
             <div class="loginRadiusProviders">
             <input name="settings[shareonbottompos]" id="shareonbottompos" type="checkbox"  <?php echo $shareonbottom;?> value="on" style="float: left !important;margin: 0; padding: 0;" />
             <label class="socialTitle" for="shareonbottompos" style=" float: left;  line-height: 5px;"><?php echo JText::_('COM_SOCIALSHARE_POSITION_BOTTOM'); ?></label>
             </div>
</td>
</tr>
<tr>
<td>
<span class="lrsubhead"><?php echo JText::_('COM_SOCIALSHARE_ARTICLES_SUBHEAD'); ?></span><br /><br />
     <?php $db = JFactory::getDBO();
           $query = "SELECT id, title FROM #__content WHERE state = '1' ORDER BY ordering";
           $db->setQuery($query);
           $rows = $db->loadObjectList();
     ?>
     <?php $articles = (isset($this->settings['articles']) ? $this->settings['articles'] : "");
           $articles = unserialize($articles);?>
      <select id="articles[]" name="articles[]" multiple="multiple" style="width:400px;">
      <?php foreach ($rows as $row) {?>
        <option <?php if (!empty($articles)) {
              foreach ($articles as $key=>$value) {
                if ($row->id == $value) { 
                  echo " selected=\"selected\""; 
                } 
              }
            }?>value="<?php echo $row->id;?>" >
            <?php echo $row->title;?>
        </option>
<?php }?>
     </select>
</td>
</tr>
</table>