<?php
/* Smarty version 3.1.30, created on 2017-04-25 01:13:17
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/api/search.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58fea2ad000022_88471773',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e7dd6c1038ab5d3f5ae1654bbbc81524c659489d' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/api/search.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58fea2ad000022_88471773 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/var/www/apps/citizen/my/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
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
