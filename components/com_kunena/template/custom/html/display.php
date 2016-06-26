<?php
/**
 * Kunena Component
 * @package Kunena.Template.Blue_Eagle
 *
 * @copyright (C) 2008 - 2013 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();
?>
<div id="Kunena" class="layout container-fluid">
<?php
if ($this->ktemplate->params->get('displayMenu', 1)) {
	$this->displayMenu ();
} ?>
<div class="kunena_body">
<?php 
$this->displayBreadcrumb ();

// Display current view/layout
$this->displayLayout();
?>
</div>
</div>
