<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_users/helpers/route.php';

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
?>
<div class="mod-login mod-login__<?php echo $moduleclass_sfx ?>">
	<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form-<?php echo $module->id; ?>" class="form-inline">
		<?php if ($params->get('pretext')): ?>
		<div class="mod-login_pretext">
			<p><?php echo $params->get('pretext'); ?></p>
		</div>
		<?php endif; ?>
		<div class="mod-login_userdata">
		<div id="form-login-username-<?php echo $module->id; ?>" class="control-group">
			<div class="controls">
				<?php if (!$params->get('usetext')) : ?>
					<div class="input-prepend">
						<span class="add-on">
							<span class="fa fa-user hasTooltip" title="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>"></span>
							<label for="modlgn-username-<?php echo $module->id; ?>" class="element-invisible"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME'); ?></label>
						</span>
						<input id="modlgn-username-<?php echo $module->id; ?>" type="text" name="username" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
					</div>
				<?php else: ?>
				<input id="mod-login_username-<?php echo $module->id; ?>" class="inputbox mod-login_username" type="text" name="username" tabindex="1" size="18" placeholder="<?php echo JText::_('TPL_MOD_LOGIN_VALUE_USERNAME') ?>" required>
				<?php endif; ?>
			</div>
		</div>
		<div id="form-login-password-<?php echo $module->id; ?>" class="control-group">
			<div class="controls">
				<?php if (!$params->get('usetext')) : ?>
					<div class="input-prepend">
						<span class="add-on">
							<span class="fa fa-lock hasTooltip" title="<?php echo JText::_('JGLOBAL_PASSWORD') ?>">
							</span>
								<label for="modlgn-passwd-<?php echo $module->id; ?>" class="element-invisible"><?php echo JText::_('JGLOBAL_PASSWORD'); ?>
							</label>
						</span>
						<input id="modlgn-passwd-<?php echo $module->id; ?>" type="password" name="password" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
					</div>
				<?php else: ?>
				<input id="mod-login_passwd-<?php echo $module->id; ?>" class="inputbox mod-login_passwd" type="password" name="password" tabindex="2" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>"  required>
				<?php endif; ?>
			</div>
		</div>		
		<?php if (count($twofactormethods) > 1): ?>
		<div id="form-login-secretkey-<?php echo $module->id; ?>" class="control-group">
			<div class="controls">
				<?php if (!$params->get('usetext')) : ?>
					<div class="input-prepend input-append">
						<span class="add-on">
							<span class="fa fa-star hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>">
							</span>
								<label for="modlgn-secretkey-<?php echo $module->id; ?>" class="element-invisible"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?>
							</label>
						</span>
						<input id="modlgn-secretkey-<?php echo $module->id; ?>" autocomplete="off" type="text" name="secretkey" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
						<span class="btn width-auto hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
							<span class="fa fa-question-circle"></span>
						</span>
				</div>
				<?php else: ?>
					<label for="modlgn-secretkey-<?php echo $module->id; ?>"><?php echo JText::_('JGLOBAL_SECRETKEY') ?></label>
					<input id="modlgn-secretkey-<?php echo $module->id; ?>" autocomplete="off" type="text" name="secretkey" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
					<span class="btn width-auto hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
						<span class="icon-help"></span>
					</span>
				<?php endif; ?>

			</div>
		</div>
		<?php endif; ?>
			<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
			<label for="mod-login_remember-<?php echo $module->id; ?>" class="checkbox">
				<input id="mod-login_remember-<?php echo $module->id; ?>" class="mod-login_remember" type="checkbox" name="remember" value="yes">
				<?php echo JText::_('TPL_MOD_LOGIN_REMEMBER_ME') ?>
			</label> 
			<?php endif; ?>
			<div class="mod-login_submit">
				<button type="submit" tabindex="3" name="Submit" class="btn btn-primary"><?php echo JText::_('JLOGIN') ?></button>
			</div>
			<?php	$usersConfig = JComponentHelper::getParams('com_users'); ?>					
			<ul class="unstyled">
				<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>" class="" title="<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?>"><?php echo JText::_('TPL_REMIND'); ?></a></li>
				<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" class="" title="<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?>"><?php echo JText::_('TPL_RESET'); ?></a></li>
				<?php if ($usersConfig->get('allowUserRegistration')) : ?>
				<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>"><?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a></li>
				<?php endif; ?>
			</ul>
			<input type="hidden" name="option" value="com_users">
			<input type="hidden" name="task" value="user.login">
			<input type="hidden" name="return" value="<?php echo $return; ?>">
			<?php echo JHtml::_('form.token'); ?>
		</div>
		<?php if ($params->get('posttext')): ?>
		<div class="mod-login_posttext">
			<p><?php echo $params->get('posttext'); ?></p>
		</div>
		<?php endif; ?>
	</form>
</div>