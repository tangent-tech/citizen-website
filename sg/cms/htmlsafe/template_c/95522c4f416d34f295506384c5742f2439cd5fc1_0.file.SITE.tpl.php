<?php
/* Smarty version 3.1.30, created on 2017-04-19 19:18:43
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/api/object_info/SITE.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7b813924840_33348404',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '95522c4f416d34f295506384c5742f2439cd5fc1' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/api/object_info/SITE.tpl',
      1 => 1491504948,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58f7b813924840_33348404 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/var/www/apps/citizen/sg/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<site>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<site_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['site_id'];?>
</site_id>
	<site_name><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['site_name']);?>
</site_name>
	<site_address><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['site_address']);?>
</site_address>
	<site_counter_alltime><?php echo $_smarty_tpl->tpl_vars['Object']->value['site_counter_alltime'];?>
</site_counter_alltime>
	<site_use_bonus_point_at_once><?php echo $_smarty_tpl->tpl_vars['Object']->value['site_use_bonus_point_at_once'];?>
</site_use_bonus_point_at_once>
	<site_default_currency_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['site_default_currency_id'];?>
</site_default_currency_id>
	<site_default_language_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['site_default_language_id'];?>
</site_default_language_id>
	<currency_paypal><?php echo $_smarty_tpl->tpl_vars['Object']->value['currency_paypal'];?>
</currency_paypal>
	<currency_paydollar_currCode><?php echo $_smarty_tpl->tpl_vars['Object']->value['currency_paydollar_currCode'];?>
</currency_paydollar_currCode>
	<currency_shortname><?php echo $_smarty_tpl->tpl_vars['Object']->value['currency_shortname'];?>
</currency_shortname>
	<currency_longname><?php echo $_smarty_tpl->tpl_vars['Object']->value['currency_longname'];?>
</currency_longname>
	<currency_site_rate><?php echo $_smarty_tpl->tpl_vars['Object']->value['currency_site_rate'];?>
</currency_site_rate>
	<currency_precision><?php echo $_smarty_tpl->tpl_vars['Object']->value['currency_precision'];?>
</currency_precision>
	<site_http_friendly_link_path><?php echo $_smarty_tpl->tpl_vars['Object']->value['site_http_friendly_link_path'];?>
</site_http_friendly_link_path>
	<site_product_allow_under_stock><?php echo $_smarty_tpl->tpl_vars['Object']->value['site_product_allow_under_stock'];?>
</site_product_allow_under_stock>
</site>
<?php }
}
