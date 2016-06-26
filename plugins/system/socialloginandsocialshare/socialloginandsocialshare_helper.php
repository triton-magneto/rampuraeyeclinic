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

/**
 * SocialLogin plugin helper class.
 */
class plgSystemSocialLoginTools {
	/*
	* get user profile data from given url
	*/
	public static function open_http($url, $method = false, $params = null)
    {

        if (!function_exists('curl_init')) {
            die('ERROR: CURL library not found!');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $method);
        if ($method == true && isset($params)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        curl_setopt($ch,  CURLOPT_HTTPHEADER, array(
            'Content-Length: '.strlen($params),
            'Cache-Control: no-store, no-cache, must-revalidate',
            "Expires: " . date("r")
        ));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

// 		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
/**
 * Get the databse settings.
 */
	public static function sociallogin_getsettings () {
      $lr_settings = array ();
      $db = JFactory::getDBO ();
	  $sql = "SELECT * FROM #__loginradius_settings";
      $db->setQuery ($sql);
      $rows = $db->LoadAssocList ();
      if (is_array ($rows)) {
		  foreach ($rows AS $key => $data) {
			  $lr_settings [$data ['setting']] = $data ['value'];
      	}
	  }
      return $lr_settings;
    }
		
/*
 * Function that remove unescaped char from string.
 */
	public static function remove_unescapedChar($str) {
	   $in_str = str_replace(array('<', '>', '&', '{', '}', '*', '/', '(', '[', ']' , '@', '!', ')', '&', '*', '#', '$', '%', '^', '|','?', '+', '=','"',','), array(''), $str);
	   $cur_encoding = mb_detect_encoding($in_str) ;
       if($cur_encoding == "UTF-8" && mb_check_encoding($in_str,"UTF-8"))
         return $in_str;
       else
         return utf8_encode($in_str);
    }
	
/*
 * Function that checking username exist then adding index to it.
 */
   public static function get_exist_username($username) {
     $nameexists = true;
        $index = 0;
        $userName = $username;
        while ($nameexists == true) {
          if(JUserHelper::getUserId($userName) != 0) {
            $index++;
            $userName = $username.$index;
          } 
		  else{
            $nameexists = false;
          }
        }
		return $userName;
   }
   
 
/*
 * Function filter the username.
 */  
   public static function get_filter_username($lrdata) {
     if (!empty($lrdata['FullName'])) {
	    $username = $lrdata['FullName'];
	  }
	  elseif (!empty($lrdata['ProfileName'])) {
	    $username = $lrdata['ProfileName'];
	  }
	  elseif (!empty($lrdata['NickName'])) {
	    $username = $lrdata['NickName'];
	  }
	  elseif (!empty($lrdata['email'])) {
	    $user_name = explode('@',$lrdata['email']);
	    $username = $user_name[0];
	  }
	  else {
	    $username = $lrdata['id'];
	  }
	  return $username;
   }
}
