<?php
/* Smarty version 3.1.30, created on 2017-04-13 12:04:22
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/page_edit_sort_block_content.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58ef6946d3fa30_22498200',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '79bde7926261c72413812f3e8f736be5e536f499' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/page_edit_sort_block_content.tpl',
      1 => 1491504957,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58ef6946d3fa30_22498200 (Smarty_Internal_Template $_smarty_tpl) {
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
