<?php
/**
 * @package     Joomla.Site
 * @subpackage  Template.system
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if (($this->error->getCode()) == '404') {
	header('Location: ' . JRoute::_("index.php?option=com_content&view=article&id=65&Itemid=204", false));
	exit;
}