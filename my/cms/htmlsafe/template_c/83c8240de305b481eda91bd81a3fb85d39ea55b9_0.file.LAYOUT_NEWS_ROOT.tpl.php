<?php
/* Smarty version 3.1.30, created on 2017-04-19 16:34:36
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/LAYOUT_NEWS_ROOT.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7919c609c70_64942202',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '83c8240de305b481eda91bd81a3fb85d39ea55b9' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/LAYOUT_NEWS_ROOT.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58f7919c609c70_64942202 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/var/www/apps/citizen/my/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<layout_news_root>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<layout_news_root_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['layout_news_root_id'];?>
</layout_news_root_id>
	<layout_news_root_name><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['layout_news_root_name']);?>
</layout_news_root_name>
</layout_news_root><?php }
}