<?php
/* Smarty version 3.1.30, created on 2017-04-24 08:37:03
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/product_sort.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58fdb92f361e99_35918486',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '42931c353ac86d82b0b44fafbd90a16a108c39b6' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/product_sort.tpl',
      1 => 1491504958,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58fdb92f361e99_35918486 (Smarty_Internal_Template $_smarty_tpl) {
echo '<?xml ';?>
version="1.0" encoding="utf-8"<?php echo '?>';?>

<root>
	<status><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['status']->value, ENT_QUOTES, 'UTF-8', true);?>
</status>
	<msg><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['msg']->value, ENT_QUOTES, 'UTF-8', true);?>
</msg>
</root>
<?php }
}
