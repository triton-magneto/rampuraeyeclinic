<?php
/**
 * @package		Komento
 * @copyright	Copyright (C) 2012 Stack Ideas Private Limited. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 *
 * Komento is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

$nofollow = $system->config->get( 'links_nofollow' ) ? ' rel="nofollow"' : '';
$config = Komento::getConfig();
?>

<span class="author-kmt"<?php if( $system->konfig->get( 'enable_schema' ) ) echo ' itemprop="creator" itemscope itemtype="http://schema.org/Person"'; ?>>
	<?php if( $row->author->guest ) {
		if( !empty( $row->url ) && $system->config->get( 'enable_guest_link' ) ) { ?>
			<a href="<?php echo $this->escape( $row->url ); ?>"<?php echo $nofollow; ?><?php if( $system->konfig->get( 'enable_schema' ) ) echo ' itemprop="url"'; ?>>
		<?php }
	} else { ?>
		<a href="<?php echo $row->author->getProfileLink( $this->escape( $row->email ) ); ?>"<?php if( $system->konfig->get( 'enable_schema' ) ) echo ' itemprop="url"'; ?>>
	<?php }
	if($config->get( 'guest_label') && strpos($row->name, JText::_( 'COM_KOMENTO_GUEST' )) === 0){
		//$row->name = JText::_( 'COM_KOMENTO_GUEST' ).' <span>('.str_replace(JText::_( 'COM_KOMENTO_GUEST' ).' - ','', $row->name).')</span>';
	}
	?>

	<span<?php if( $system->konfig->get( 'enable_schema' ) ) echo ' itemprop="name"'; ?>><?php echo $row->name; ?></span>

	<?php if( $row->author->guest ) {
		if( !empty( $row->url ) && $system->config->get( 'enable_guest_link' ) ) { ?>
			</a>
		<?php }
	} else { ?>
		</a>
	<?php } ?>
</span>
