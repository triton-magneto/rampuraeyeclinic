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
defined ('_JEXEC') or die ('Restricted access');
jimport ('joomla.plugin.plugin');
jimport ('joomla.filesystem.file');
jimport ('joomla.user.helper');
jimport ('joomla.mail.helper' );
jimport ('joomla.application.component.helper');
jimport ('joomla.application.component.modelform');
jimport ('joomla.application.component.controller' );
jimport ('joomla.event.dispatcher');
jimport ('joomla.plugin.helper');
jimport ('joomla.utilities.date');
if (!defined('DS')) {
  define('DS',DIRECTORY_SEPARATOR);
}


// Includes plugins required files.
require_once(dirname (__FILE__) . DS . 'socialloginandsocialshare_helper.php');
require_once(dirname (__FILE__) . DS . 'googlelogin.php');
require_once(dirname (__FILE__) . DS . 'facebooklogin.php');

/*
 * Class that indicates the plugin.
 */
class plgSystemSocialLoginAndSocialShare extends JPlugin {

/*
 * Class constructor.
 */
  function plgSystemSocialLoginAndSocialShare(&$subject, $config) {
    parent::__construct($subject,$config);
  }

/*
 * Plugin class function that calls on after plugin intialise.
 */
  function onAfterInitialise() {
    $lrdata = array(); $user_id = ''; $id = ''; $email = ''; $msg = ''; $defaultUserGroups = ''; $lr_settings = array();
    $lr_settings = plgSystemSocialLoginTools::sociallogin_getsettings ();

	// Get module configration option value
	$mainframe = JFactory::getApplication();
	$db = JFactory::getDBO();
    $config = JFactory::getConfig();
    $language = JFactory::getLanguage();
	$session = JFactory::getSession();
	$language->load('com_users');
	$language->load('com_socialloginandsocialshare', JPATH_ADMINISTRATOR);
	$authorize = JFactory::getACL();
	$input = JFactory::getApplication()->input;
	$code = $input->get('code', null, 'STRING');
	$provider = $input->get('provider', null, 'STRING');
	// Checking user is logged in.
	if (isset($code) && !empty($code)) {
		if($provider=='google'){
			$userprofile = googlelogin::acsses_token($code, $lr_settings);
			$lrdata = googlelogin::userprofile_data($userprofile);
		}elseif($provider=='facebook'){
			$userprofile = facebooklogin::acsses_token($code, $lr_settings);
			$lrdata = facebooklogin::userprofile_data($userprofile);
		}
	}

	// User is not logged in trying to make log in user.
	if (isset($lrdata) && !empty($lrdata) && !JFactory::getUser()->id) {

	  // Remove the session if any.
	  if ($session->get('tmpuser')) {
	    $session->clear('tmpuser');
	  }
	  //$lrdata = plgSystemSocialLoginTools::facebook_userprofile_data($userprofile);
	  // Find the not activate user.
	   $query = "SELECT u.id FROM #__users AS u INNER JOIN #__LoginRadius_users AS lu ON lu.id = u.id WHERE lu.LoginRadius_id = '".$lrdata['id']."' AND u.activation != '' AND u.activation != 0";
	   $db->setQuery($query);
	   $block_id = $db->loadResult();
	   if (!empty($block_id) || $block_id) {
	     JError::raiseWarning ('', JText::_ ('COM_SOCIALLOGIN_USER_NOTACTIVATE'));
		 return false;
	   }  

	  // Find the block user.
	   $query = "SELECT u.id FROM #__users AS u INNER JOIN #__LoginRadius_users AS lu ON lu.id = u.id WHERE lu.LoginRadius_id = '".$lrdata['id']."' AND u.block = 1";
	   $db->setQuery($query);
	   $block_id = $db->loadResult();
	   if (!empty($block_id) || $block_id) {
	     JError::raiseWarning ('', JText::_ ('COM_SOCIALLOGIN_USER_BLOCK'));
		 return false;
	   }
	 }

	// Checking user click on popup cancel button.
	if (isset($lrdata['id']) && !empty($lrdata['id']) && !empty($lrdata['email'])) {
	  // Filter username form data.
	  if (!empty($lrdata['fname']) && !empty($lrdata['lname'])) {
	    $username = $lrdata['fname'].$lrdata['lname'];
	    $name = $lrdata['fname'];

	  }
	  else {
	    $username = plgSystemSocialLoginTools::get_filter_username($lrdata);
	    $name = plgSystemSocialLoginTools::get_filter_username($lrdata);
	  }
	 $query="SELECT u.id FROM #__users AS u INNER JOIN #__LoginRadius_users AS lu ON lu.id = u.id WHERE lu.LoginRadius_id = '".$lrdata['id']."'";
	 $db->setQuery($query);
	 $user_id = $db->loadResult();      

	  // If not then check for email exist.
	  if (empty($user_id)) {
        $query = "SELECT id FROM #__users WHERE email='".$lrdata['email']."'";
        $db->setQuery($query);
        $user_id = $db->loadResult(); 
		if (!empty($user_id)) {
		  $query = "SELECT LoginRadius_id from #__LoginRadius_users WHERE LoginRadius_id=".$db->Quote ($lrdata['id'])." AND id = " . $user_id;
          $db->setQuery($query);
          $check_id = $db->loadResult();
	      if (empty($check_id)) {

		    // Add new id to db.
		    $userImage = $lrdata['thumbnail'];
		    $sql = "INSERT INTO #__LoginRadius_users SET id = " . $user_id . ", LoginRadius_id = " . $db->Quote ($lrdata['id']).", provider = " . $db->Quote ($lrdata['Provider']) . ", lr_picture = " . $db->Quote ($userImage);
            $db->setQuery ($sql);
	        $db->execute();
		  }
		}
	  }
	  $newuser = true;
      if (isset($user_id)) {
	    $user = JFactory::getUser($user_id);
        if ($user->id == $user_id) {
          $newuser = false;
        }
	  }
	  if ($newuser == true) {
	  $user = new JUser;
	  $need_verification = false;
	  
		// If user registration is not allowed, show 403 not authorized.
	    $usersConfig = JComponentHelper::getParams( 'com_users' );
        if ($usersConfig->get('allowUserRegistration') == '0') {
          JError::raiseWarning( '', JText::_( 'COM_SOCIALLOGIN_REGISTER_DISABLED'));
          return false;
        }

		// Default to Registered.
        $defaultUserGroups = $usersConfig->get('new_usertype', 2);
	    if (empty($defaultUserGroups)) {
          $defaultUserGroups = 'Registered';
        }

		// if username already exists
        $username = plgSystemSocialLoginTools::get_exist_username($username);

		// Remove special char if have.
		$username = plgSystemSocialLoginTools::remove_unescapedChar($username);
	    $name = plgSystemSocialLoginTools::remove_unescapedChar($name);

		//Insert data 
		jimport ('joomla.user.helper');
	    $userdata = array ();
	    $userdata ['name'] = $db->escape($name);
        $userdata ['username'] = $db->escape($username);
        $userdata ['email'] = $lrdata['email'];
        $userdata ['usertype'] = 'deprecated';
        $userdata ['groups'] = array($defaultUserGroups);
        $userdata ['registerDate'] = JFactory::getDate ()->toSql ();
        $userdata ['password'] = JUserHelper::genRandomPassword ();
        $userdata ['password2'] = $userdata ['password'];
		$useractivation = $usersConfig->get( 'useractivation' );
		if (isset($_POST['sociallogin_emailclick']) AND $useractivation != '2') {
            $need_verification = true;
		}
		if ($useractivation == '2' OR $need_verification == true) {
		  $userdata ['activation'] = JApplication::getHash(JUserHelper::genRandomPassword());
		  $userdata ['block'] = 1;
		}
		else {
		  $userdata ['activation'] = '';
		  $userdata ['block'] = 0;
		}
		if (!$user->bind ($userdata)) {
          JError::raiseWarning ('', JText::_ ('COM_USERS_REGISTRATION_BIND_FAILED'));
          return false;
        }

		//Save the user
        if (!$user->save()) {
          JError::raiseWarning ('', JText::_ ('COM_SOCIALLOGIN_REGISTER_FAILED'));
          return false;
        }
        $user_id = $user->get ('id');

		// Saving user extra profile.
       //plgSystemSocialLoginTools::save_userprofile_data($user_id, $lrdata);
	  // Trying to insert image.
		$userImage = $lrdata['thumbnail'];
		
        // Remove.
        $sql = "DELETE FROM #__LoginRadius_users WHERE LoginRadius_id = " . $db->Quote ($lrdata['id']);
        $db->setQuery ($sql);
        if ($db->execute()) {

		  //Add new id to db
          $sql = "INSERT INTO #__LoginRadius_users SET id = " . $db->quote ($user_id) . ",  LoginRadius_id = " . $db->Quote ($lrdata['id']).", provider = " . $db->Quote ($lrdata['Provider']).", lr_picture = " . $db->Quote ($userImage);
          $db->setQuery ($sql);
          $db->execute();
	    }   
		
		
		 // Handle account activation/confirmation emails.
		 if ($useractivation == '2' OR $need_verification == true) {
           if ($need_verification == true) {
		     $usermessgae = 3;
             $this->_sendMail($user, $usermessgae);
             $mainframe->enqueueMessage(JText::_ ('COM_USERS_REGISTRATION_COMPLETE_ACTIVATE'));
			 $session->clear('tmpuser');
             return false;
		   }
           else {
		   $usermessgae = 1;
		   $this->_sendMail($user, $usermessgae);
		   $mainframe->enqueueMessage(JText::_ ('COM_USERS_REGISTRATION_COMPLETE_VERIFY'));
           $session->clear('tmpuser');
		   return false;
		 }
	   }
	   else {
 	     $usermessgae = 2;
		 $this->_sendMail($user, $usermessgae);
       }
	   
     }
}
   if ($user_id) {
     $user = JUser::getInstance((int)$user_id);	 
	 
	  //Register session variables
	  $session = JFactory::getSession();
	  $query = "SELECT lr_picture from #__LoginRadius_users WHERE LoginRadius_id=".$db->Quote ($lrdata['id'])." AND id = " . $user->get('id');
	  $db->setQuery($query);
	  $check_picture = $db->loadResult();
	  $session->set('user_picture',$check_picture);
	  $session->set('user_lrid',$lrdata['id']);
	  $session->set('user',$user);
	  
	  // Getting the session object
	  $table =  JTable::getInstance('session');
	  $table->load( $session->getId());
	  $table->guest = '0';
	  $table->username = $user->get('username');
	  $table->userid = intval($user->get('id'));
	  $table->usertype = $user->get('usertype');
	  $table->gid  = $user->get('gid');
	  $table->update();
	  $user->setLastVisit();
	  $user = JFactory::getUser();
	  
	  //Redirect after Login
	  $session->clear('tmpuser');	 
	  ?>
      <script>
	  if (window.opener) {
		  window.opener.location.href='<?php echo JURI::root(); ?>';
		  window.close();
	  }
      </script>
      
      <?php
	 
	  
	}
  }

/*

 * Function that sends a verification link to exist user.

 */	
	
	
   function _sendMail(&$user, $usermessgae) {

	 // Compile the notification mail values.
     $lr_settings = plgSystemSocialLoginTools::sociallogin_getsettings ();
	 $config = JFactory::getConfig();
	 $data = $user->getProperties();
	 $data['fromname'] = $config->get('fromname');
	 $data['mailfrom'] = $config->get('mailfrom');
	 $data['sitename'] = $config->get('sitename');
	 $data['siteurl'] = JUri::base();
	 $uri = JURI::getInstance();
	 $base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
	 $data['activate'] = $base.JRoute::_('index.php?option=com_users&task=registration.activate&token='.$data['activation'], false);
	 $emailSubject	= JText::sprintf('COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']);
	 if($usermessgae == 1) {
	   $emailBody = JText::sprintf('COM_SOCIALLOGIN_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY', $data['name'], $data['sitename'],	$data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'], $data['siteurl'], $data['username'], $data['password_clear']);
	 }
	 else if ($usermessgae == 2) {
	   $emailBody = JText::sprintf('COM_SOCIALLOGIN_SEND_MSG', $data['name'], $data['sitename'], $data['siteurl'].'index.php', $data['username'],$data['password_clear']);
	 }
	 else if ($usermessgae == 3) {
	   $emailBody = JText::sprintf('COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY', $data['name'], $data['sitename'], $data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'], $data['siteurl'], $data['username'], $data['password_clear']);
	 }
	 
	 // Send the registration email.
	 $return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);

	// Check for an error.
	if ($return !== true) {
	  $this->setError(JText::_('COM_USERS_REGISTRATION_SEND_MAIL_FAILED'));
	  // Send a system message to administrators receiving system mails
	  $db = JFactory::getDBO();
	  $q = "SELECT id FROM #__users WHERE block = 0 AND sendEmail = 1";
	  $db->setQuery($q);
	  $sendEmail = $db->loadColumn();
	  if (count($sendEmail) > 0) {
	    $jdate = new JDate();
	  
	    // Build the query to add the messages
	    $q = "INSERT INTO `#__messages` (`user_id_from`, `user_id_to`, `date_time`, `subject`, `message`)	VALUES ";
	    $messages = array();
	    foreach ($sendEmail as $userid) {
	    $messages[] = "(".$userid.", ".$userid.", '".$jdate->toSql()."', '".JText::_('COM_USERS_MAIL_SEND_FAILURE_SUBJECT')."', '".JText::sprintf('COM_USERS_MAIL_SEND_FAILURE_BODY', $return, $data['username'])."')";
	    }
	    $q .= implode(',', $messages);
	    $db->setQuery($q);
	    $db->execute();
	  }
	  return false;
    }
    elseif ($usermessgae == 2) {
      $db = JFactory::getDBO();
	
	  // get all admin users
      $query = 'SELECT name, email, sendEmail' . ' FROM #__users' . ' WHERE sendEmail=1';
	  $db->setQuery( $query );
	  $rows = $db->loadObjectList();
	  // Send mail to all superadministrators id
	  foreach ( $rows as $row ) {
	     JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $row->email, $emailSubject, JText::sprintf('COM_SOCIALLOGIN_SEND_MSG_ADMIN', $row->name, $data['sitename'], $data['siteurl'], $data['email'], $data['username'], $data['password_clear']));
	    }
      }
	  return false;
    }
  }