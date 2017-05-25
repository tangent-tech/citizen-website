<?php
/* Smarty version 3.1.30, created on 2017-04-13 09:50:59
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/product_sort.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58ef4a03a8e273_07805030',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8f5e1cb79d52ee0b10244993b228be7b7e80620e' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/product_sort.tpl',
      1 => 1491504958,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58ef4a03a8e273_07805030 (Smarty_Internal_Template $_smarty_tpl) {
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
