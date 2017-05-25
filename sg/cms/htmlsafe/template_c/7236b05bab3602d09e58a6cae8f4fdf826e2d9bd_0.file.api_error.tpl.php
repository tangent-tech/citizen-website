<?php
/* Smarty version 3.1.30, created on 2017-03-26 08:50:16
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/api_error.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d764a84116f4_19742674',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7236b05bab3602d09e58a6cae8f4fdf826e2d9bd' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/api_error.tpl',
      1 => 1479814328,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58d764a84116f4_19742674 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
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
