<?php
/* Smarty version 3.1.30, created on 2017-04-19 19:24:57
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/api/search.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7b989188af3_00990380',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a0ee270ef0d5068c96143b6cc2d810b61acc6cf3' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/api/search.tpl',
      1 => 1491503858,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f7b989188af3_00990380 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/var/www/apps/citizen/sg/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<search_key><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['SearchKey']->value);?>
</search_key>
<total_no_of_objects><?php echo $_smarty_tpl->tpl_vars['TotalNoOfObjects']->value;?>
</total_no_of_objects>
<page_no><?php echo $_smarty_tpl->tpl_vars['PageNo']->value;?>
</page_no>
<objects><?php echo $_smarty_tpl->tpl_vars['ObjectsXML']->value;?>
</objects>
<?php echo $_smarty_tpl->tpl_vars['ValueRangeValueListXML']->value;
}
}
