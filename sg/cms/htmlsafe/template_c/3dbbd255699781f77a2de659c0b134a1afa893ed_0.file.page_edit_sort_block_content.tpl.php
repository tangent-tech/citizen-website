<?php
/* Smarty version 3.1.30, created on 2017-04-24 08:20:36
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/page_edit_sort_block_content.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58fdb554a185c4_35192054',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3dbbd255699781f77a2de659c0b134a1afa893ed' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/page_edit_sort_block_content.tpl',
      1 => 1491504957,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58fdb554a185c4_35192054 (Smarty_Internal_Template $_smarty_tpl) {
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
