<?php 
defined('_JEXEC') or die;
include_once('functions.php');

$app 		= JFactory::getApplication();
$doc 		= JFactory::getDocument();
$user 	= JFactory::getUser();		// Add current user information

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->getCfg('sitename');
$template = $app->getTemplate();
$menu = JMenu::getInstance('site');
$db = JFactory::getDBO();
$query = "SELECT template FROM #__template_styles WHERE client_id = 1 AND home = 1";
$db->setQuery($query);
$adminTemplate = $db->loadResult();

$contentParams = $app->getParams('com_content');
$pageClass = $contentParams->get('pageclass_sfx');

// Logo file
if ($this->params->get('logoFile')){
	$logo = $this->params->get('logoFile');
}

//Footer logo file
if ($this->params->get('footerLogoFile')){
	$footerLogo = $this->params->get('footerLogoFile');
}

// Footer

// If Right-to-Left
if ($this->direction == 'rtl'){
	$doc->addStyleSheet('media/jui/css/bootstrap-rtl.css');
}

//Hide module positions 
//By View (article, login, registration, search, profile, reset, remind etc)
$hideByView = false;
switch($view){
	case 'article':
	case 'login':
	case 'search':
	case 'profile':
	case 'registration':
	case 'reset':
	case 'remind':
	case 'form':
		$hideByView = true;
		break;
}

//By Component
$hideByOption = false;
switch($option){
	case 'com_users':
	case 'com_search':
		$hideByOption = true;
		break;
}

//By Component
$hideByEdit = false;
if(($option == 'com_content' && $layout == 'edit')/* || ($option == 'com_config')*/){
	//$hideByEdit = true;
}

//Get main content width

//Get Left column grid width
if($this->countModules('aside-left') && $hideByOption == false && $view !== 'form'){ 
	$asideLeftWidth = $this->params->get('asideLeftWidth');
} else {
	$asideLeftWidth = "";
}

//Get Right column grid width
if($this->countModules('aside-right') && $hideByOption == false && $view !== 'form'){ 
	$asideRightWidth = $this->params->get('asideRightWidth');
} else {
	$asideRightWidth = "";
}

$mainContentWidth = 12 - ($asideLeftWidth + $asideRightWidth);


// Typography variables
$this->params->get('categoryPageHeading') ? $categoryPageHeading = $this->params->get('categoryPageHeading') : $categoryPageHeading = "";


// Theme Layouts 
$themeLayout = $this->params->get('themeLayout');

switch ($themeLayout) {
	case '0':
		$containerClass = 'container';
		$rowClass = 'row';
		break;

	case '1':
		$containerClass = 'container-fluid';
		$rowClass = 'row-fluid';
		break;
	
	default:
		$containerClass = 'container';
		$rowClass = 'row';
		break;
}

// Year

// Privacy Link
$privacyMenuLink = $menu->getItem($this->params->get('privacy_link_menu'));

$privacy_link_url =  JRoute::_($privacyMenuLink->link.'&Itemid='.$privacyMenuLink->id);
	
// Terms Link	
$termsMenuLink = $menu->getItem($this->params->get('terms_link_menu'));

$terms_link_url =  JRoute::_($termsMenuLink->link.'&Itemid='.$termsMenuLink->id);