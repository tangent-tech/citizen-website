<?php
/* Smarty version 3.1.30, created on 2017-04-19 16:34:36
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/LAYOUT_NEWS_PAGE.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7919c61ea28_56852523',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a0f9113cfc27c92617810130f645bfc437c15e0f' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/LAYOUT_NEWS_PAGE.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58f7919c61ea28_56852523 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<layout_news_root_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['layout_news_root_id'];?>
</layout_news_root_id>
<layout_news_category_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['layout_news_category_id'];?>
</layout_news_category_id>
<total_no_of_layout_news><?php echo $_smarty_tpl->tpl_vars['TotalNoOfLayoutNews']->value;?>
</total_no_of_layout_news>
<page_no><?php echo $_smarty_tpl->tpl_vars['PageNo']->value;?>
</page_no>
<?php echo $_smarty_tpl->tpl_vars['LayoutNewsRootXML']->value;?>

<?php echo $_smarty_tpl->tpl_vars['LayoutNewsCategoryXML']->value;?>

<layout_news_list><?php echo $_smarty_tpl->tpl_vars['LayoutNewsListXML']->value;?>
</layout_news_list><?php }
}
