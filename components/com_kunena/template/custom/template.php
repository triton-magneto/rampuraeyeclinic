<?php
/**
* Kunena Component
* @package Kunena.Template.Custom
*
* @copyright Copyright (C) 2012 - 2013 Jetimpex, Inc.
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
* @link http://www.templatemonster.com
**/
defined( '_JEXEC' ) or die();

class KunenaTemplateCustom extends KunenaTemplate {
	// Try to find missing files from the following parent templates:
	protected $default = array('custom');
	protected $css_compile = false;
	protected $userClasses = array(
		'kwho-',
		'admin'=>'kwho-admin',
		'globalmod'=>'kwho-globalmoderator',
		'moderator'=>'kwho-moderator',
		'user'=>'kwho-user',
		'guest'=>'kwho-guest',
		'banned'=>'kwho-banned',
		'blocked'=>'kwho-blocked'
	);
	public $categoryIcons = array('kreadforum', 'kunreadforum');

	public function initialize() {
		KunenaFactory::loadLanguage('com_kunena.tpl_custom');

		// Enable legacy mode
		KunenaTemplateLegacy::load();

		require_once JPATH_SITE. '/' . $this->getFile('initialize.php');
		$this->addStyleSheet ( 'css/kunena.20.css' );

		// Toggler language strings
		JFactory::getDocument()->addScriptDeclaration('// <![CDATA[
var kunena_toggler_close = "'.JText::_('COM_KUNENA_TOGGLER_COLLAPSE', true).'";
var kunena_toggler_open = "'.JText::_('COM_KUNENA_TOGGLER_EXPAND', true).'";
// ]]>');

	}

	public function getButton($link, $name, $scope, $type, $id = null) {
		$types = array('communication'=>'comm', 'user'=>'user', 'moderation'=>'mod', 'permanent'=>'mod');
		$names = array('unsubscribe'=>'subscribe', 'unfavorite'=>'favorite', 'unsticky'=>'sticky', 'unlock'=>'lock', 'create'=>'newtopic',
				'quickreply'=>'reply', 'quote'=>'quote', 'edit'=>'edit', 'permdelete'=>'delete',
				'flat'=>'layout-flat', 'threaded'=>'layout-threaded', 'indented'=>'layout-indented',
				'list'=>'reply');

		$text = JText::_("COM_KUNENA_BUTTON_{$scope}_{$name}");
		$title = JText::_("COM_KUNENA_BUTTON_{$scope}_{$name}_LONG");
		if ($title == "COM_KUNENA_BUTTON_{$scope}_{$name}_LONG") $title = '';
		if ($id) $id = 'id="'.$id.'"';

		if (isset($types[$type])) $type = $types[$type];
		if ($name == 'quickreply') $type .= ' kqreply';
		if (isset($names[$name])) $name = $names[$name];

		return <<<HTML
<a $id class="btn btn-info" href="{$link}" rel="nofollow" title="{$title}">
	{$text}
</a>
HTML;
	}

	public function getIcon($name, $title='') {
		return '<span class="kicon '.$name.'" title="'.$title.'"></span>';
	}

	public function getImage($image, $alt='') {
		return '<img src="'.$this->getImagePath($image).'" alt="'.$alt.'" />';
	}
}
