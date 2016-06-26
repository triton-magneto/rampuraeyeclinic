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
jimport('joomla.filesystem.folder');
jimport('joomla.installer.installer');
/**
 * Script file of socialloginandsocialshare component
 */
class Com_SocialLoginAndSocialShareInstallerScript {
    public function postflight($type, $parent) {		
    if (!defined('DS')){
      define('DS',DIRECTORY_SEPARATOR);
    }
  }
  	function install($parent){
		if (!defined('DS')){
      define('DS',DIRECTORY_SEPARATOR);
    }
	  	$status = new stdClass;
    $status->modules = array();
    $status->plugins = array();
    $db = JFactory::getDBO ();
	$src = $parent->getParent()->getPath('source');
    $manifest = $parent->getParent()->manifest;
	$isUpdate = JFile::exists(JPATH_SITE.DS.'modules'.DS.'mod_socialloginandsocialshare'.DS.'mod_socialloginandsocialshare.php');
    // create a folder inside your images folder
    JFolder::create(JPATH_ROOT.DS.'images'.DS.'sociallogin');

    // Load sociallogin language file
    $lang = JFactory::getLanguage();
    $lang->load('com_socialloginandsocialshare', JPATH_SITE);
	
	// Installing modules.
	$modules = $manifest->xpath('modules/module');
	foreach ($modules AS $module) {
      $mod_data = array ();
      foreach ($module->attributes () as $key => $value) {
        $mod_data [$key] = strval ($value);
      }
	  $mod_data ['client'] = JApplicationHelper::getClientInfo ($mod_data ['client'], true);
      if (is_null($mod_data ['client']->name)) $client = 'site';
      $path = $src.DS.$mod_data ['module'];
      $installer = new JInstaller;
      $result = $installer->install($path);
      if ($result) {
        $status->modules[] = array('name'=>$mod_data ['module'],'client'=>$mod_data ['client']->name, 'result'=>$result);
      }
	}
	if (!$isUpdate) {
	  $query = "UPDATE #__modules SET title = '".$mod_data ['title']."', position='".$mod_data ['position']."', ordering='".$mod_data ['order']."', published = 1, access=1 WHERE module='".$mod_data ['module']."'";
      $db->setQuery($query);
      $db->execute();
    }
	$query = 'SELECT `id` FROM `#__modules` WHERE module = ' . $db->Quote ($mod_data ['module']);
    $db->setQuery ($query);
    if (!$db->execute()) {
      $parent->getParent()->abort (JText::_ ('Module') . ' ' . JText::_ ('Install') . ': ' . $db->stderr (true));
      return false;
    }
    $mod_id = $db->loadResult ();
    if ((int) $mod_data ['client']->id == 0) {
      $query = 'REPLACE INTO `#__modules_menu` (moduleid,menuid) values (' . $db->Quote ($mod_id) . ',0)';
      $db->setQuery ($query);
      if (!$db->execute()) {
        // Install failed, roll back changes
        $parent->getParent()->abort (JText::_ ('Module') . ' ' . JText::_ ('Install') . ': ' . $db->stderr (true));
        return false;
      }
	}
  
    // Installing plugins.
	$plugins = $manifest->xpath('plugins/plugin');
    foreach ($plugins AS $plugin) {
      $plg_data = array ();
      foreach ($plugin->attributes() as $key => $value) {
        $plg_data [$key] = strval ($value);
      }
	  $path = $src . DS . 'plg_'.$plg_data['plugin'];
	  $installer = new JInstaller;
      $result = $installer->install($path);
	  if ($result) {
	    $query = "UPDATE #__extensions SET enabled=1 WHERE type='plugin' AND element=".$db->Quote($plg_data ['plugin'])." AND folder=".$db->Quote($plg_data ['group']);
        $db->setQuery($query);
        $db->execute();
	  }      
      // Plugin Installed
      $status->plugins[] = array('name'=>$plg_data ['plugin'], 'group'=>$plg_data ['group']);      
    }
    $this->installationResults($status);
	  }
  	public function uninstall($parent)
    {$db = JFactory::getDBO();
        $status = new stdClass;
        $status->modules = array();
        $status->plugins = array();
        $manifest = $parent->getParent()->manifest;
        $plugins = $manifest->xpath('plugins/plugin');
        foreach ($plugins as $plugin)
        {
            $name = (string)$plugin->attributes()->plugin;
            $group = (string)$plugin->attributes()->group;
            $query = "SELECT `extension_id` FROM #__extensions WHERE `type`='plugin' AND element = ".$db->Quote($name)." AND folder = ".$db->Quote($group);
            $db->setQuery($query);
            $extensions = $db->loadColumn();
            if (count($extensions))
            {
                foreach ($extensions as $id)
                {
                    $installer = new JInstaller;
                    $result = $installer->uninstall('plugin', $id);
                }
                $status->plugins[] = array('name' => $name, 'group' => $group, 'result' => $result);
            }
            
        }
        $modules = $manifest->xpath('modules/module');
        foreach ($modules as $module)
        {
            $name = (string)$module->attributes()->module;
            $client = (string)$module->attributes()->client;
            $db = JFactory::getDBO();
            $query = "SELECT `extension_id` FROM `#__extensions` WHERE `type`='module' AND element = ".$db->Quote($name)."";
            $db->setQuery($query);
            $extensions = $db->loadColumn();
            if (count($extensions))
            {
                foreach ($extensions as $id)
                {
                    $installer = new JInstaller;
                    $result = $installer->uninstall('module', $id);
                }
                $status->modules[] = array('name' => $name, 'client' => $client, 'result' => $result);
            }
            
        }
		//$this->uninstallationResults($status);
	  }  
    public function update($parent)
    {
		if (!defined('DS')){
      define('DS',DIRECTORY_SEPARATOR);
    }
	  	$status = new stdClass;
    $status->modules = array();
    $status->plugins = array();
    $db = JFactory::getDBO ();
	$src = $parent->getParent()->getPath('source');
    $manifest = $parent->getParent()->manifest;
	$isUpdate = JFile::exists(JPATH_SITE.DS.'modules'.DS.'mod_socialloginandsocialshare'.DS.'mod_socialloginandsocialshare.php');
    // create a folder inside your images folder
    JFolder::create(JPATH_ROOT.DS.'images'.DS.'sociallogin');

    // Load sociallogin language file
    $lang = JFactory::getLanguage();
    $lang->load('com_socialloginandsocialshare', JPATH_SITE);
	
	// Installing modules.
	$modules = $manifest->xpath('modules/module');
	foreach ($modules AS $module) {
      $mod_data = array ();
      foreach ($module->attributes () as $key => $value) {
        $mod_data [$key] = strval ($value);
      }
	  $mod_data ['client'] = JApplicationHelper::getClientInfo ($mod_data ['client'], true);
      if (is_null($mod_data ['client']->name)) $client = 'site';
      $path = $src.DS.$mod_data ['module'];
      $installer = new JInstaller;
      $result = $installer->update($path);
      if ($result) {
        $status->modules[] = array('name'=>$mod_data ['module'],'client'=>$mod_data ['client']->name, 'result'=>$result);
      }
	}
	if (!$isUpdate) {
	  $query = "UPDATE #__modules SET title = '".$mod_data ['title']."', position='".$mod_data ['position']."', ordering='".$mod_data ['order']."', published = 1, access=1 WHERE module='".$mod_data ['module']."'";
      $db->setQuery($query);
      $db->execute();
    }
	$query = 'SELECT `id` FROM `#__modules` WHERE module = ' . $db->Quote ($mod_data ['module']);
    $db->setQuery ($query);
    if (!$db->execute()) {
      $parent->getParent()->abort (JText::_ ('Module') . ' ' . JText::_ ('Install') . ': ' . $db->stderr (true));
      return false;
    }
    $mod_id = $db->loadResult ();
    if ((int) $mod_data ['client']->id == 0) {
      $query = 'REPLACE INTO `#__modules_menu` (moduleid,menuid) values (' . $db->Quote ($mod_id) . ',0)';
      $db->setQuery ($query);
      if (!$db->execute()) {
        // Install failed, roll back changes
        $parent->getParent()->abort (JText::_ ('Module') . ' ' . JText::_ ('Install') . ': ' . $db->stderr (true));
        return false;
      }
	}
  
    // Installing plugins.
	$plugins = $manifest->xpath('plugins/plugin');
    foreach ($plugins AS $plugin) {
      $plg_data = array ();
      foreach ($plugin->attributes() as $key => $value) {
        $plg_data [$key] = strval ($value);
      }
	  $path = $src . DS . 'plg_'.$plg_data['plugin'];
	  $installer = new JInstaller;
      $result = $installer->update($path);
	  if ($result) {
	    $query = "UPDATE #__extensions SET enabled=1 WHERE type='plugin' AND element=".$db->Quote($plg_data ['plugin'])." AND folder=".$db->Quote($plg_data ['group']);
        $db->setQuery($query);
        $db->execute();
	  }      
      // Plugin Installed
      $status->plugins[] = array('name'=>$plg_data ['plugin'], 'group'=>$plg_data ['group']);
	  $query = "SELECT `extension_id` FROM `#__extensions` WHERE type='plugin' AND element=".$db->Quote($plg_data ['plugin'])." AND folder=".$db->Quote($plg_data ['group']);
	  $db->setQuery ($query);
		if (!$db->execute()) {
		  $parent->getParent()->abort (JText::_ ('Plugin') . ' ' . JText::_ ('Update') . ': ' . $db->stderr (true));
		  return false;
		}
    }
		$this->installationResults($status);
	}
	private function installationResults($status)
    {
        $rows = 0; 
        if (count($status->modules) AND count($status->plugins)) {?>
  <h2>Social Login And Social Share Installation</h2>
<table class="adminlist table table-striped">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
			<th><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
	    <tr>
			<th><?php echo JText::_('Component'); ?></th>
			<th></th>
			<th></th>
		</tr>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo 'Social Login And Social Share '.JText::_('Component'); ?></td>
			<td style="color:#6c9c31;"><strong><?php echo JText::_('Installed'); ?></strong></td>
		</tr>

<?php if (count($status->modules)) : ?>
		<tr>
			<th><?php echo JText::_('Module'); ?></th>
			<th><?php echo JText::_('Client'); ?></th>
			<th></th>
		</tr>
	<?php foreach ($status->modules as $module) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $module['name']; ?></td>
			<td class="key"><?php echo ucfirst($module['client']); ?></td>
			<td style="color:#6c9c31;"><strong><?php echo JText::_('Installed'); ?></strong></td>
		</tr>
	<?php endforeach;
	endif;
if (count($status->plugins)) : ?>
		<tr>
			<th><?php echo JText::_('Plugin'); ?></th>
			<th><?php echo JText::_('Group'); ?></th>
			<th></th>
		</tr>
	<?php foreach ($status->plugins as $plugin) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo ucfirst($plugin['name']); ?></td>
			<td class="key"><?php echo ucfirst($plugin['group']); ?></td>
			<td style="color:#6c9c31;"><strong><?php echo JText::_('Installed'); ?></strong></td>
		</tr>
	<?php endforeach;
endif; ?>
	</tbody>
</table>

	<h2><?php echo JText::_ ('COM_SOCIALLOGIN_INSTALLATION_STATUS'); ?></h2>
	<p class="nowarning">
		<?php echo JText::_ ('COM_SOCIALLOGIN_INSTALLATION_THANK'); ?> <strong>Social Login and Social Share</strong>!
		<?php echo JText::_ ('COM_SOCIALLOGIN_INSTALLATION_CONFIG'); ?> <a href="index.php?option=com_socialloginandsocialshare">Social Login <?php echo JText::_ ('COM_SOCIALLOGIN_INSTALLATION_COM'); ?></a>
		<?php echo JText::_ ('COM_SOCIALLOGIN_INSTALLATION_FREE'); ?> <a href=" http://community.loginradius.com" target="_blank"><?php echo JText::_ ('COM_SOCIALLOGIN_INSTALLATION_CONTACT'); ?></a> <?php echo JText::_ ('COM_SOCIALLOGIN_INSTALLATION_ASSIST'); ?>
		<strong><?php echo JText::_ ('COM_SOCIALLOGIN_INSTALLATION_THANKYOU'); ?></strong>
		</p>
<?php }
    }
 }