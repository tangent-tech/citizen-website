<?php
/* Smarty version 3.1.30, created on 2017-04-26 10:54:30
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/content_admin_setting.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59007c6622f381_73268350',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5dc5a95d96d3f3d1f9ee14ba658e5f3f1a1a34f2' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/content_admin_setting.tpl',
      1 => 1491504951,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_inner.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_2ndlevel.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_inner.tpl' => 1,
  ),
),false)) {
function content_59007c6622f381_73268350 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle"> Admin Setting &nbsp;</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="content_admin_setting_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="LeftHeaderTable">
				<tr>
					<th>Email Address</th>
					<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['AdminInfo']->value['email'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				</tr>
				<tr>
					<th>Old Password</th>
					<td><input type="password" name="old_password" size="80" /></td>
				</tr>
				<tr>
					<th>New Password</th>
					<td><input type="password" name="user_password" value="" size="80" /></td>
				</tr>
				<tr>
					<th>Re-Type New Password</th>
					<td><input type="password" name="user_password2" value="" size="80" /></td>
				</tr>
				<tr>
					<th>Email Notification</th>
					<td>
						<input type="radio" name="email_notification" value="Y" <?php if ($_smarty_tpl->tpl_vars['AdminInfo']->value['email_notification'] != 'N') {?>checked=checked<?php }?> /> Yes
						<input type="radio" name="email_notification" value="N" <?php if ($_smarty_tpl->tpl_vars['AdminInfo']->value['email_notification'] == 'N') {?>checked=checked<?php }?> /> No
					</td>
				</tr>
			</table>
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom InnerHeader">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> Submit
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> Reset
			</a>
		</div>
	</form>
</div>

<br class="clearfloat" />
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
