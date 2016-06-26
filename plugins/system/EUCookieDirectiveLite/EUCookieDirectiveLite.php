<?php
/*
Plugin Name:    EUCookieDirectiveLite
Edition:        Lite Edition with basic options
Plugin URI:     http://www.channelcomputing.co.uk
Description:    A plugin to display a notification to the user about the usage of cookies on the site. It allows the site admin to easily conform with the 
                <a href='http://www.ico.gov.uk/news/latest_news/2011/must-try-harder-on-cookies-compliance-says-ico-13122011.aspx'>EU Cookie Directive</a>.
Version:        1.0.5
Author:         Channel Computing
Author URI:     http://www.channelcomputing.co.uk

Copyright (C) 2011-2012, Channel Computing
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, 
THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE 
LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Joomla! EU Cookie Directive plugin
 *
 * @package        Joomla
 * @subpackage    System
 */
class  plgSystemEUCookieDirectiveLite extends JPlugin
{
    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @access    protected
     * @param    object $subject The object to observe
     * @param     array  $config  An array that holds the plugin configuration
     * @since    1.0
     */
    function plgSystemEUCookieDirectiveLite(& $subject, $config)
    {
        parent::__construct($subject, $config);
    
    }

    /**
    * Start the output
    *
    */
    function onAfterRender()
    {
        
        global $mainframe, $database;
        
        //get Params
        $message = $this->params->get('warningMessage', '');
        $privacyLink = $this->params->get('detailsUrl', 'index.php');
        $width = $this->params->get('width', '0');
        
        //deal with the width options
        if ($width == "0") {
            $width = "100%";
        } else {
            $width = $width . "px";
        }

        $document    = JFactory::getDocument();
        $doctype    = $document->getType();
        $app = JFactory::getApplication();
		
        $ICON_FOLDER = JURI::root() . 'plugins/system/EUCookieDirectiveLite/EUCookieDirectiveLite/images/';        
        
        if ( $app->getClientId() === 0 ) {
            
            $strOutputHTML = "";
            $style = '<style>
                div#cookieMessageContainer {
                    font: normal 12px/16px Arial,Verdana,sans-serif;
                    position:fixed;
                    z-index:9999;
                    top:0px;
					right:0px;
                    margin:0px auto;
					color: #fff;
					padding: 5px;
                }
                table, tr, td {border:0px !important}
				#cookieMessageText p,.accept{font:normal 12px/16px Arial,Verdana,sans-serif;margin:0;padding:0 0 6px;text-align:left;vertical-align:middle}
				#cookieMessageContainer table,#cookieMessageContainer td{margin:0;padding:0;vertical-align:middle}
                #cookieMessageText, .accept  {font-family:arial,verdana;
                    font-size:12px;}
                #cookieMessageContainer .cookie_button{background: url('. $ICON_FOLDER . 'continue_button.png);text-shadow: #fff 0.1em 0.1em 0.2em; color: #000; padding: 5px 12px;height: 14px;float: left;}
                #cookieMessageAgreementForm {margin-left:10px;}
                #cookieMessageInformationIcon {margin-right:10px;height:29px;}
				#continue_button{vertical-align:middle;cursor:pointer;margin:0 0 0 10px}
                #info_icon {vertical-align:middle;margin-top:5px;}
                #buttonbarContainer {height:29px;margin-bottom:-10px;}
                #cookietable {border:none;cellpadding:0px;}
                #cookietable td {border:none;}
                #outer table, #outer tr, #outer td {border:none;}
                #outer{padding:2px;}
				.accept {float: left;padding: 5px 6px 4px 15px; color: #fff;}
				a#cookieMessageDetailsLink {color:#fff!important; text-decoration: underline;}
            </style>';
        
            $hide = "\n".'<style type="text/css">
                    div#cookieMessageContainer{display:none}
                </style>'."\n";
                
            //Define paths for portability
            //$SCRIPTS_FOLDER = JURI::root() . 'plugins/system/EUCookieDirective/';
            $SCRIPTS_FOLDER = JURI::root() . 'plugins/system/EUCookieDirectiveLite/EUCookieDirectiveLite/';
            $cookiescript = '<script type="text/javascript" src="' . $SCRIPTS_FOLDER . 'EUCookieDirective.js"></script>'."\n";
            
            $strOutputHTML = "";
            $strOutputHTML .= '<div id="outer" style="width:100%">';
            $strOutputHTML .= '<div id="cookieMessageContainer" style="margin-top:-10px;width:' . $width . ';background-color:#1D1D1D;">';
            $strOutputHTML .= '<table width="100%">';
            $strOutputHTML .= '<tr>';
            $strOutputHTML .= '<td colspan="2">';
            $strOutputHTML .= '<div id="cookieMessageText" style="padding:15px 10px 0 15px;">';
            $strOutputHTML .= '<p style="color:#fff;">' . $message . ' To find out more about the cookies we use and how to delete them, see our <a id="cookieMessageDetailsLink" title="View our privacy policy page" href="' . $privacyLink . '">privacy policy</a>.</p>';
            $strOutputHTML .= '</div>';
            $strOutputHTML .= '</td>';
            $strOutputHTML .= '</tr>';
            $strOutputHTML .= '<tr>';
            $strOutputHTML .= '<td align="left">&nbsp;&nbsp;';
            $strOutputHTML .= '<span class="accept"><span class="cookieMessageText">I accept cookies from this site.</span></span></label> ';			
            $strOutputHTML .= '<div border="0" class="cookie_button" id="continue_button" onclick="SetCookie(\'cookieAcceptanceCookie\',\'accepted\',9999);">Agree</div>';
            $strOutputHTML .= '</td>';
            $strOutputHTML .= '<td align="right">';
            $strOutputHTML .= '<div id="cookieMessageInformationIcon" style="float:right;"><a href="http://www.channeldigital.co.uk/developer-resources/eu-cookie-directive-module.html" target="_blank"><img id="info_icon" src="' . $ICON_FOLDER . 'info_icon.png" alt="EU Cookie Directive Module Information" title="EU Cookie Directive Module Information" border="0" ></a></div>';
            $strOutputHTML .= '</td>';
            $strOutputHTML .= '</tr>';
            $strOutputHTML .= '</table>';
            $strOutputHTML .= '</div>';
            $strOutputHTML .= '</div>';

            //Only write the HTML Output if the cookie has not been set as "accepted"
            if(!isset($_COOKIE['cookieAcceptanceCookie']) || $_COOKIE['cookieAcceptanceCookie'] != "accepted")
            { 
                
                $body = JResponse::getBody();
                $body = str_replace('</head>', $style.'</head>', $body);
                $body = str_replace('</body>', $strOutputHTML.$cookiescript.'</body>', $body);
                JResponse::setBody($body);
            }
            elseif($_COOKIE['cookieAcceptanceCookie'] == "accepted") {
                $body = JResponse::getBody();
                $body = str_replace('</head>', $hide.'</head>', $body);
                JResponse::setBody($body);
            }
        }
    }
}