<?php
/* Smarty version 3.1.30, created on 2017-04-19 18:04:11
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/api/product_brand_get_product_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7a69b496273_40840098',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '43d61107674fa9678a13b4eeba7fc8dcaa76b60a' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/api/product_brand_get_product_list.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f7a69b496273_40840098 (Smarty_Internal_Template $_smarty_tpl) {
?>
<total_no_of_products><?php echo $_smarty_tpl->tpl_vars['TotalNoOfProducts']->value;?>
</total_no_of_products>
<product_page_no><?php echo $_REQUEST['product_page_no'];?>
</product_page_no>
<products_per_page><?php echo $_REQUEST['products_per_page'];?>
</products_per_page>
<product_brand_id><?php echo $_REQUEST['product_brand_id'];?>
</product_brand_id>
<product_category_id><?php echo $_REQUEST['product_category_id'];?>
</product_category_id>
<product_list><?php echo $_smarty_tpl->tpl_vars['ProductListXML']->value;?>
</product_list><?php }
}
