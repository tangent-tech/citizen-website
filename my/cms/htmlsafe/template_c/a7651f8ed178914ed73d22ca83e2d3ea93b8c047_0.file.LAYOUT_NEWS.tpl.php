<?php
/* Smarty version 3.1.30, created on 2017-04-19 19:37:36
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/LAYOUT_NEWS.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7bc800a6572_84117654',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a7651f8ed178914ed73d22ca83e2d3ea93b8c047' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/LAYOUT_NEWS.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58f7bc800a6572_84117654 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/var/www/apps/citizen/my/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
if (!is_callable('smarty_modifier_mytag')) require_once '/var/www/apps/citizen/my/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.mytag.php';
?>
<layout_news>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<layout_news_root_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['layout_news_root_id'];?>
</layout_news_root_id>
	<layout_news_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['layout_news_id'];?>
</layout_news_id>
	<layout_news_title><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['layout_news_title']);?>
</layout_news_title>
	<layout_news_date><?php echo $_smarty_tpl->tpl_vars['Object']->value['layout_news_date'];?>
</layout_news_date>
	<layout_news_tag><?php echo smarty_modifier_myxml(smarty_modifier_mytag($_smarty_tpl->tpl_vars['Object']->value['layout_news_tag']));?>
</layout_news_tag>
	<layout_news_category_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['layout_news_category_id'];?>
</layout_news_category_id>
	<layout_news_category_name><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['layout_news_category_name']);?>
</layout_news_category_name>
	<?php echo $_smarty_tpl->tpl_vars['LayoutXML']->value;?>

	<?php echo $_smarty_tpl->tpl_vars['AlbumXML']->value;?>

</layout_news><?php }
}
