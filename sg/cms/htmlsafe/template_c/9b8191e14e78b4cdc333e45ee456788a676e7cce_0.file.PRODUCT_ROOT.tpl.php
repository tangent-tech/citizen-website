<?php
/* Smarty version 3.1.30, created on 2017-04-07 03:17:26
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/api/object_info/PRODUCT_ROOT.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58e704c6967b79_94801516',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9b8191e14e78b4cdc333e45ee456788a676e7cce' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/api/object_info/PRODUCT_ROOT.tpl',
      1 => 1491504948,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58e704c6967b79_94801516 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/var/www/apps/citizen/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<product_category>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<product_category_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_id'];?>
</product_category_id>
	<product_category_name><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['object_name']);?>
</product_category_name>
	<total_no_of_products><?php echo $_smarty_tpl->tpl_vars['NoOfProducts']->value;?>
</total_no_of_products>
	<page_no><?php echo $_smarty_tpl->tpl_vars['PageNo']->value;?>
</page_no>
	<products_per_page><?php echo $_smarty_tpl->tpl_vars['ProductsPerPage']->value;?>
</products_per_page>
	<products><?php echo $_smarty_tpl->tpl_vars['ProductsXML']->value;?>
</products>
	<product_categories><?php echo $_smarty_tpl->tpl_vars['ProductCategoriesXML']->value;?>
</product_categories>
	<total_no_of_objects><?php echo $_smarty_tpl->tpl_vars['NoOfObjects']->value;?>
</total_no_of_objects>
	<objects><?php echo $_smarty_tpl->tpl_vars['ObjectsXML']->value;?>
</objects>
	<product_root_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_id'];?>
</product_root_id>
</product_category><?php }
}
