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
 * SocialLogin Facebook Login class.
 */
class facebooklogin {
	public static function acsses_token($code, $lr_settings){
		$redirect = JURI::root().'?provider=facebook';
		$params = array(
			'client_id=' . $lr_settings['fbapikey'],
			'client_secret=' . $lr_settings['fbapisecret'],
			'code=' . $code,
			'redirect_uri='. $redirect
		);
		$params = implode('&', $params);
		$url = 'https://graph.facebook.com/oauth/access_token?' . $params;
		$data = plgSystemSocialLoginTools::open_http($url);
		parse_str($data, $data_array);

		if(empty($data_array['access_token'])){
			echo 'Error - empty access tocken';
			exit;
		}

		$ResponseUrl = 'https://graph.facebook.com/me?access_token='.$data_array['access_token'];
		$request = json_decode(plgSystemSocialLoginTools::open_http($ResponseUrl));

		if(empty($request)){
			echo 'Error - empty user data';
			exit;
		}
		else if(!empty($request->error)){
			echo 'Error - '. $request->error;
			exit;
		}
		return $request;   
	}	
	
	/*
	* Function getting user data from loginradius.
	*/
    public static function userprofile_data($userprofile) {
	  $lrdata['session'] = uniqid('LoginRadius_', true);
	  $lrdata['id'] = (!empty($userprofile->id) ? $userprofile->id : "");
      $lrdata['FullName'] = (!empty($userprofile->name) ? $userprofile->name : "");
      $lrdata['ProfileName'] = (!empty( $userprofile->username) ? $userprofile->username : "");
      $lrdata['fname'] = (!empty( $userprofile->first_name) ? $userprofile->first_name : "");
      $lrdata['lname'] = (!empty($userprofile->last_name) ? $userprofile->last_name : "");
	  $lrdata['gender'] = (!empty($userprofile->gender) ? $userprofile->gender : '');     
      $lrdata['Provider'] = 'facebook';
      $lrdata['email'] = (!empty($userprofile->email) ? $userprofile->email : "");
      $lrdata['thumbnail'] = (!empty ($userprofile->ThumbnailImageUrl) ? trim($userprofile->ThumbnailImageUrl) : "");
      $lrdata['ProfileUrl'] = (!empty($userprofile->link) ? $userprofile->link : '');
      $lrdata['thumbnail'] = "http://graph.facebook.com/".$lrdata['id']."/picture?type=square";
      $lrdata['address1'] = (!empty($userprofile->location->name) ? $userprofile->location->name :"");
      $lrdata['address2'] = $lrdata['address1'];
      $lrdata['city'] = (!empty($userprofile->hometown) ? $userprofile->hometown : "");
	return $lrdata;
	
	}
}
?>