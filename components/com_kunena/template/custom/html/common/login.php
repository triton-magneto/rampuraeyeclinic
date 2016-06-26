<?php
/**
 * Kunena Component
 * @package Kunena.Template.Blue_Eagle
 * @subpackage Common
 *
 * @copyright (C) 2008 - 2013 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();
?>
	<span class="ktoggler fltrt"><a class="ktoggler close" title="<?php echo JText::_('COM_KUNENA_TOGGLER_COLLAPSE') ?>" rel="kprofilebox"></a></span>
<div class="kblock kpbox">
	<div class="kcontainer" id="kprofilebox">
		<div class="kbody">
<table class="kprofilebox">
	<tbody>
		<tr class="krow1">
			<td valign="top" class="kprofileboxcnt">
				<div class="k_guest">
					<?php echo JText::_('COM_KUNENA_PROFILEBOX_WELCOME'); ?>,
					<b><?php echo JText::_('COM_KUNENA_PROFILEBOX_GUEST'); ?></b>
				</div>
				<?php if ($this->login->enabled()) : ?>
				<form action="<?php echo KunenaRoute::_('index.php?option=com_kunena') ?>" method="post" name="login">
					<input type="hidden" name="view" value="user" />
					<input type="hidden" name="task" value="login" />
					[K=TOKEN]

					<div class="input">				
						<input type="text" name="username" class="inputbox ks" alt="username" size="18" placeholder="<?php echo JText::_('COM_KUNENA_LOGIN_USERNAME') ?>" required>
						<input type="password" name="password" class="inputbox ks" size="18" alt="password" placeholder="<?php echo JText::_('COM_KUNENA_LOGIN_PASSWORD'); ?>" required>
						<span>
							<button type="submit" name="submit" class="btn btn-primary" value="<?php echo JText::_('COM_KUNENA_PROFILEBOX_LOGIN'); ?>"><?php echo JText::_('COM_KUNENA_PROFILEBOX_LOGIN'); ?></button>
							<?php if($this->remember) : ?>
							<label for="remember"><input type="checkbox" name="remember" id="remember" alt="" value="1" /><?php echo JText::_('COM_KUNENA_LOGIN_REMEMBER_ME'); ?></label>
							<?php endif; ?>
						</span>
					</div>
					<div class="klink-block">
						<span class="kprofilebox-pass">
							<a href="<?php echo $this->lostPasswordUrl ?>" rel="nofollow"><?php echo JText::_('COM_KUNENA_PROFILEBOX_FORGOT_PASSWORD') ?></a>
						</span>
						<span class="kprofilebox-user">
							<a href="<?php echo $this->lostUsernameUrl ?>" rel="nofollow"><?php echo JText::_('COM_KUNENA_PROFILEBOX_FORGOT_USERNAME') ?></a>
						</span>
						<?php
						if ($this->registerUrl) : ?>
						<span class="kprofilebox-register">
							<a href="<?php echo $this->registerUrl ?>" rel="nofollow"><?php echo JText::_('COM_KUNENA_PROFILEBOX_CREATE_ACCOUNT') ?></a>
						</span>
						<?php endif; ?>
					</div>
				</form>
				<?php endif; ?>
			</td>
			<!-- Module position -->
			<?php if ($this->moduleHtml) : ?>
			<td class = "kprofilebox-right">
				<div class="kprofilebox-modul">
					<?php echo $this->moduleHtml; ?>
				</div>
			</td>
			<?php endif; ?>
		</tr>
	</tbody>
</table>
		</div>
	</div>
</div>
