<?php
/* Smarty version 3.1.30, created on 2017-03-25 10:38:34
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d63a9a697211_20211688',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '149f1a27172c0622c06a3677158491b4b197bb6e' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/index.tpl',
      1 => 1490434497,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer.tpl' => 1,
  ),
),false)) {
function content_58d63a9a697211_20211688 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<div id="LoginContainer" class="InnerContainer ui-widget ui-widget-content ui-corner-all">
	<h1 class="InnerHeader ui-widget-header ui-helper-reset ui-corner-top" ><?php echo @constant('CMS_PRODUCT_NAME');?>
 Admin Panel</h1>
	<div id="LoginContainerContent" class="InnerContent ui-widget-content ui-helper-reset ui-corner-bottom">
		<?php if ($_smarty_tpl->tpl_vars['ErrorMsg']->value != '') {?>
			<div class="AdminError ui-state-error ui-corner-all" style="padding: 0pt 0.7em;">
				<p>
					<span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em;"></span>
					<?php echo $_smarty_tpl->tpl_vars['ErrorMsg']->value;?>

				</p>
			</div>
		<?php }?>
		<form action="login.php" method="post">
			<p> <label for="email">Email:</label> <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($_REQUEST['email'], ENT_QUOTES, 'UTF-8', true);?>
" /> </p>
			<p> <label for="password">Password:</label> <input type="password" name="password" id="password" /> </p>
			<input class="ui-state-default ui-corner-all MyInputButton" type="submit" value="LOGIN" />
			<input class="ui-state-default ui-corner-all MyInputButton" type="reset" value="RESET" />
		</form>	
	</div>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
