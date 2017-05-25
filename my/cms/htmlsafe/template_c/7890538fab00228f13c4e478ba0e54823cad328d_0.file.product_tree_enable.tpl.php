<?php
/* Smarty version 3.1.30, created on 2017-04-19 16:56:08
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/product_tree_enable.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f796a8a0efb5_40855021',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7890538fab00228f13c4e478ba0e54823cad328d' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/product_tree_enable.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f796a8a0efb5_40855021 (Smarty_Internal_Template $_smarty_tpl) {
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
