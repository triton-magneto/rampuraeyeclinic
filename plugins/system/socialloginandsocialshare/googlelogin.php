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
 * SocialLogin Google Login class.
 */
class googlelogin {
	public static function acsses_token($code, $lr_settings){
		$redirect = JURI::root();
		$scope = urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email');
		$params = array(
						
                'client_id=' . $lr_settings['gapikey'],
                'client_secret=' . $lr_settings['gapisecret'],
                'grant_type=authorization_code',
                'code=' . $code,
                'redirect_uri=' . ($redirect.'?provider=google'),
                'scope=' . $scope

            );
		$params = implode('&', $params);
		$url = 'https://accounts.google.com/o/oauth2/token';
        $request = json_decode(plgSystemSocialLoginTools::open_http($url, true, $params));
		
		if(empty($request)){
			echo 'Error - empty user data';
			exit;
		}		
		$url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$request->access_token;
		$request = json_decode(plgSystemSocialLoginTools::open_http($url));

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
		$lrdata['id'] = (!empty($userprofile->id) ? $userprofile->id : "");
		$lrdata['FullName'] = (!empty($userprofile->name) ? $userprofile->name : "");
		$lrdata['ProfileName'] = (!empty( $userprofile->name) ? $userprofile->name : "");
		$lrdata['fname'] = (!empty( $userprofile->given_name) ? $userprofile->given_name : "");
		$lrdata['lname'] = (!empty($userprofile->family_name) ? $userprofile->family_name : "");
		$lrdata['gender'] = (!empty($userprofile->gender) ? $userprofile->gender : '');     
		$lrdata['Provider'] = 'google';
		$lrdata['email'] = (!empty($userprofile->email) ? $userprofile->email : "");		
		$lrdata['ProfileUrl'] = (!empty($userprofile->link) ? $userprofile->link : '');
		$lrdata['dob'] = (!empty($userprofile->birthday) ? $userprofile->birthday : '');
		$lrdata['thumbnail'] = '';
	return $lrdata;
	}
}
?>