<?php
/* Smarty version 3.1.30, created on 2017-04-21 09:19:55
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/api/api_error.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f9cebb504879_80059911',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '872b38bdba98ec9020774785415de91599ffc620' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/api/api_error.tpl',
      1 => 1491503857,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f9cebb504879_80059911 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/var/www/apps/citizen/sg/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<data>
	<result>Fail</result>
	<error_code><?php echo $_smarty_tpl->tpl_vars['API_ERROR']->value['no'];?>
</error_code>
	<error_string><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['API_ERROR']->value['desc']);?>
</error_string>
	<remarks><?php echo $_smarty_tpl->tpl_vars['AdditionalXML']->value;?>
</remarks>
</data><?php }
}
