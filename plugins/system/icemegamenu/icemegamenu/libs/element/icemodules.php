<?php
/**
 * IceMegaMenu Extension for Joomla 1.6 By IceTheme
 * 
 * 
 * @copyright	Copyright (C) 2008 - 2011 IceTheme.com. All rights reserved.
 * @license		GNU General Public License version 2
 * 
 * @Website 	http://www.icetheme.com/Joomla-Extensions/icemegamenu.html
 * @Support 	http://www.icetheme.com/Forums/IceMegaMenu/
 *
 */
 
 // Ensure this file is being included by a parent file
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.html.html');
jimport('joomla.form.formfield');
class JFormFieldIcemodules extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $_name = 'Icemodules';

	 protected function getInput()
    {
		$db_temp = JFactory::getDBO();
		$db =&$db_temp;
		$attr = '';
        // Initialize some field attributes.
        $attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
        // To avoid user's confusion, readonly="true" should imply disabled="true".
        if ( (string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true') { 
            $attr .= ' disabled="disabled"';
        }
        $attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
        $attr .= $this->multiple ? ' multiple="multiple"' : '';
        // Initialize JavaScript field attributes.
        $attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';
        
		$query = "SELECT * FROM #__modules where client_id=0 AND published=1 ORDER BY id ASC";
		$db->setQuery($query);
		$groups = $db->loadObjectList();	
		$groupHTML = array();
		if ($groups && count ($groups)) {
			foreach ($groups as $tvalue=>$item){
				$groupHTML[] = JHTML::_('select.option', $item->id, $item->title." (id=".$item->id.")");
			}
		}
		if( !empty($value) && !is_array($value) )
			$value = explode("|", $value);
            
		$lists = JHTML::_('select.genericlist', $groupHTML, $this->name,trim($attr), 'value', 'text', $this->value, $this->id);	
				 
		return $lists; 
	}
} 