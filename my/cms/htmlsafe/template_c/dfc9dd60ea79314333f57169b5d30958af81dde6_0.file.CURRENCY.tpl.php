<?php
/* Smarty version 3.1.30, created on 2017-04-19 16:32:31
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/CURRENCY.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7911fe24150_71425798',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dfc9dd60ea79314333f57169b5d30958af81dde6' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/CURRENCY.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f7911fe24150_71425798 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/var/www/apps/citizen/my/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<currency>
	<currency_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['currency_id'];?>
</currency_id>
	<currency_paypal><?php echo $_smarty_tpl->tpl_vars['Object']->value['currency_paypal'];?>
</currency_paypal>
	<currency_paydollar_currCode><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['currency_paydollar_currCode']);?>
</currency_paydollar_currCode>
	<currency_shortname><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['currency_shortname']);?>
</currency_shortname>
	<currency_longname><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['currency_longname']);?>
</currency_longname>
	<currency_symbol><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['currency_symbol']);?>
</currency_symbol>
	<currency_precision><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['currency_precision']);?>
</currency_precision>
	<currency_site_rate><?php echo $_smarty_tpl->tpl_vars['Object']->value['currency_site_rate'];?>
</currency_site_rate>
</currency><?php }
}
