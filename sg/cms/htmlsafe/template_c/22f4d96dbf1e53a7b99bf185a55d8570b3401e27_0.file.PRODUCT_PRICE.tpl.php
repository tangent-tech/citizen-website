<?php
/* Smarty version 3.1.30, created on 2017-04-19 19:18:45
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/api/object_info/PRODUCT_PRICE.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7b8159f9ee5_84567645',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '22f4d96dbf1e53a7b99bf185a55d8570b3401e27' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/api/object_info/PRODUCT_PRICE.tpl',
      1 => 1491504948,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f7b8159f9ee5_84567645 (Smarty_Internal_Template $_smarty_tpl) {
?>
<product_price>
	<product_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['product_id'];?>
</product_id>
	<product_price_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['product_price_id'];?>
</product_price_id>
	<product_price><?php echo $_smarty_tpl->tpl_vars['Object']->value['product_price'];?>
</product_price>
	<product_price_ca><?php echo $_smarty_tpl->tpl_vars['Object']->value['product_price_ca'];?>
</product_price_ca>
	<product_bonus_point_required><?php echo $_smarty_tpl->tpl_vars['Object']->value['product_bonus_point_required'];?>
</product_bonus_point_required>
	<product_bonus_point_amount><?php echo $_smarty_tpl->tpl_vars['Object']->value['product_bonus_point_amount'];?>
</product_bonus_point_amount>
	<discount_type><?php echo $_smarty_tpl->tpl_vars['Object']->value['discount_type'];?>
</discount_type>
	<discount1_off_p><?php echo $_smarty_tpl->tpl_vars['Object']->value['discount1_off_p'];?>
</discount1_off_p>
	<discount2_amount><?php echo $_smarty_tpl->tpl_vars['Object']->value['discount2_amount'];?>
</discount2_amount>
	<discount2_price><?php echo $_smarty_tpl->tpl_vars['Object']->value['discount2_price'];?>
</discount2_price>
	<discount2_price_ca><?php echo $_smarty_tpl->tpl_vars['Object']->value['discount2_price_ca'];?>
</discount2_price_ca>
	<discount3_buy_amount><?php echo $_smarty_tpl->tpl_vars['Object']->value['discount3_buy_amount'];?>
</discount3_buy_amount>
	<discount3_free_amount><?php echo $_smarty_tpl->tpl_vars['Object']->value['discount3_free_amount'];?>
</discount3_free_amount>
	<product_price_level_list><?php echo $_smarty_tpl->tpl_vars['ProductPriceLevelListXML']->value;?>
</product_price_level_list>
</product_price><?php }
}
