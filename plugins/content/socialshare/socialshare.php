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
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
 * plgContentSocialShare
 */  
class plgContentSocialShare  extends JPlugin {
   /**
    * Constructor
    * Loads the plugin settings and assigns them to class variables
    */
    public function __construct(&$subject)
    {
        parent::__construct($subject);
        // Loading plugin parameters
		$lr_settings = $this->sociallogin_getsettings();
		//Properties holding plugin settings
		?>
		<style>
		.lrcounter-horizontal-vertical table {
			background: none repeat scroll 0 0 transparent !important;
			border: medium none !important;
			color: #000000 !important;
			margin: 0 !important;
			padding: 0 !important;
			text-align: left !important;
		}
		
		
		.lrcounter-horizontal-vertical table tr, .lrcounter-horizontal-vertical table td {
			background: none repeat scroll 0 0 transparent !important;
			border: medium none !important;
			color: #000000 !important;
			display: inline-table;
			margin-left: 4px !important;
			padding: 0 2px !important;
			text-align: left !important;
			vertical-align: bottom !important;
		}
		iframe, svg {
			max-width: none !important;
		} 
		</style>
		<?php
		$this->enableshare = (!empty($lr_settings['share']) ? $lr_settings['share'] : "");
		$this->fbapikey = (!empty($lr_settings['fbapikey']) ? $lr_settings['fbapikey'] : "");
		$this->sharetitle = (!empty($lr_settings['sharetitle']) ? $lr_settings['sharetitle'] : "");
		$this->fblike = (!empty($lr_settings['fblike']) ? $lr_settings['fblike'] : "");
		$this->fbsend = (!empty($lr_settings['fbsend']) ? $lr_settings['fbsend'] : "");
		$this->googleplus = (!empty($lr_settings['googleplus']) ? $lr_settings['googleplus'] : "");
		$this->googleshare = (!empty($lr_settings['googleshare']) ? $lr_settings['googleshare'] : "");
		$this->shareontoppos = (!empty($lr_settings['shareontoppos']) ? $lr_settings['shareontoppos'] : "");
		$this->shareonbottompos = (!empty($lr_settings['shareonbottompos']) ? $lr_settings['shareonbottompos'] : "");		
		$this->articles = (!empty($lr_settings['articles']) ? unserialize($lr_settings['articles']) : "");
		
		if($this->enableshare == '1'){
			$document = JFactory::getDocument();
			$document->addScript('https://apis.google.com/js/plusone.js');
		}
    }
	/**
	 * Before display content method
	 */
	public function onContentBeforeDisplay($context, &$article, &$params, $limitstart=0) {
		$beforediv ='';		
		if($this->enableshare == '1'){
			$beforediv .='<div id="fb-root"></div>
						<script>(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId='.$this->fbapikey.'";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, "script", "facebook-jssdk"));</script>';
			if($this->shareontoppos == 'on'){
			$app = JFactory::getApplication();
			if (is_array($this->articles)) {
            foreach ($this->articles as $key=>$value) {
			  if ($article->id == $value) {
				$sharetitle = '<div style="margin:0;"><b>'.$this->sharetitle.'</b></div>';
				if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='Off' && !empty($_SERVER['HTTPS'])):
						$http='https://';
					else:
						$http='http://';
					endif;
						if(!isset($article->language) && empty($article->language)):
							$article->language = 0;
						endif;
						if(!isset($article->catid) && empty($article->catid)):
							$article->catid = 0;
						endif;
				$articlelink = $http.$_SERVER['HTTP_HOST'].JRoute::_(ContentHelperRoute::getArticleRoute($article->id, $article->catid, $article->language));
				$beforediv .= "<div align='left' style='padding-bottom:10px;padding-top:10px;'>".$sharetitle."</div>";
				
				
				$beforediv .= '<div class="lrsharecontainer lrcounter-horizontal-vertical">';
				$beforediv .= '<table style="border:none !important;background:none !important;">
				<tr style="border:none !important;background:none !important;">
				<td style="border:none !important;background:none !important;">';
					if($this->fblike == 'on'){
						$beforediv .= '<div class="fb-like" data-href="'.$articlelink.'" data-layout="box_count"></div>';
					}
					
					$beforediv .= '</td>
					<td style="border:none !important;background:none !important;">';
					if($this->fbsend == 'on'){
						$beforediv .= '<div class="fb-send" data-href="'.$articlelink.'"></div>';
					}
					$beforediv .= '</td>
					<td style="border:none !important;background:none !important;">';
					if($this->googleplus == 'on'){
						$beforediv .= '<g:plus action="share" annotation="vertical-bubble" href="'.$articlelink.'"></g:plus>';
					}
					$beforediv .= '</td>
					<td style="border:none !important;background:none !important;">';
					if($this->googleshare == 'on'){
						$beforediv .= '<g:plusone action="share" annotation="none" href="'.$articlelink.'"></g:plusone>';
					}
					$beforediv .= '</td>
					</tr>
					</table>';
					$beforediv .= '</div>';
					
					
			  }
			}
		  }
		}
		}
	  return $beforediv;	
}
	/**
	 * After display content method
	 */
	public function onContentAfterDisplay($context, &$article, &$params, $limitstart=0) {		
		$afterdiv = '';
		if($this->enableshare == '1'){
			$afterdiv .='<div id="fb-root"></div>
						<script>(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId='.$this->fbapikey.'";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, "script", "facebook-jssdk"));</script>';
			if($this->shareonbottompos == 'on'){
			$app = JFactory::getApplication();
			if (is_array($this->articles)) {
            foreach ($this->articles as $key=>$value) {
			  if ($article->id == $value) {
				$sharetitle = '<div style="margin:0;"><b>'.$this->sharetitle.'</b></div>';
				if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='Off' && !empty($_SERVER['HTTPS'])):
						$http='https://';
					else:
						$http='http://';
					endif;
						if(!isset($article->language) && empty($article->language)):
							$article->language = 0;
						endif;
						if(!isset($article->catid) && empty($article->catid)):
							$article->catid = 0;
						endif;
				$articlelink = $http.$_SERVER['HTTP_HOST'].JRoute::_(ContentHelperRoute::getArticleRoute($article->id, $article->catid, $article->language));
				$afterdiv .= "<div align='left' style='padding-bottom:10px;padding-top:10px;'>".$sharetitle."</div>";
				
				
				$afterdiv .= '<div class="lrsharecontainer lrcounter-horizontal-vertical">';
				$afterdiv .= '<table style="border:none !important;background:none !important;">
				<tr style="border:none !important;background:none !important;">
				<td style="border:none !important;background:none !important;">';
					if($this->fblike == 'on'){
						$afterdiv .= '<div class="fb-like" data-href="'.$articlelink.'" data-layout="box_count"></div>';
					}
					
					$afterdiv .= '</td>
					<td style="border:none !important;background:none !important;">';
					if($this->fbsend == 'on'){
						$afterdiv .= '<div class="fb-send" data-href="'.$articlelink.'"></div>';
					}
					$afterdiv .= '</td>
					<td style="border:none !important;background:none !important;">';
					if($this->googleplus == 'on'){
						$afterdiv .= '<g:plus action="share" annotation="vertical-bubble" href="'.$articlelink.'"></g:plus>';
					}
					$afterdiv .= '</td>
					<td style="border:none !important;background:none !important;">';
					if($this->googleshare == 'on'){
						$afterdiv .= '<g:plusone action="share" annotation="none" href="'.$articlelink.'"></g:plusone>';
					}
					$afterdiv .= '</td>
					</tr>
					</table>';
					$afterdiv .= '</div>';
			  }
			}
		  }
		}
		}
	  return $afterdiv;	
	}
	
/**
 * Get the databse settings.
 */
	private function sociallogin_getsettings () {
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
}  