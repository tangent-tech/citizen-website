<?php
/* Smarty version 3.1.30, created on 2017-03-23 19:16:21
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/LAYOUT_NEWS.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d410f5d1ff84_62830251',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5c1335f13647785fd8785ea3ab92b707aee97e3e' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/LAYOUT_NEWS.tpl',
      1 => 1441542943,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58d410f5d1ff84_62830251 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
if (!is_callable('smarty_modifier_mytag')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.mytag.php';
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
