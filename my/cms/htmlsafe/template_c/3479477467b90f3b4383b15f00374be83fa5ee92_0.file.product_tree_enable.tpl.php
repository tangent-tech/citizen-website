<?php
/* Smarty version 3.1.30, created on 2017-04-13 10:56:36
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/product_tree_enable.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58ef59644d3e09_57062937',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3479477467b90f3b4383b15f00374be83fa5ee92' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/product_tree_enable.tpl',
      1 => 1491504958,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58ef59644d3e09_57062937 (Smarty_Internal_Template $_smarty_tpl) {
echo '<?xml ';?>
version="1.0" encoding="utf-8"<?php echo '?>';?>

<root>
	<status><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['status']->value, ENT_QUOTES, 'UTF-8', true);?>
</status>
	<new_status><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['NewStatus']->value, ENT_QUOTES, 'UTF-8', true);?>
</new_status>
	<msg><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['msg']->value, ENT_QUOTES, 'UTF-8', true);?>
</msg>
</root>
<?php }
}
