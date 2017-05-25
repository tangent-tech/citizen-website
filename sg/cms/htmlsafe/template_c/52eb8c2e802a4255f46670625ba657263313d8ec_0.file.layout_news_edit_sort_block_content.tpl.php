<?php
/* Smarty version 3.1.30, created on 2017-04-21 16:44:15
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/layout_news_edit_sort_block_content.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58fa36df11b799_21297451',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '52eb8c2e802a4255f46670625ba657263313d8ec' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/layout_news_edit_sort_block_content.tpl',
      1 => 1491504955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58fa36df11b799_21297451 (Smarty_Internal_Template $_smarty_tpl) {
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
