<?php
/* Smarty version 3.1.30, created on 2017-03-25 16:39:12
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/product_tree_enable.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d68f2094f767_53441610',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dba8250b775686da739d29e52aff306ec5ae0fff' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/product_tree_enable.tpl',
      1 => 1441542942,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58d68f2094f767_53441610 (Smarty_Internal_Template $_smarty_tpl) {
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
