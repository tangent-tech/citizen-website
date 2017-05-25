<?php
/* Smarty version 3.1.30, created on 2017-03-27 06:02:07
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/search.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d88ebfdd6835_06281110',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '52059a782a6a1ea5f9e5ece0cd71cc4bc4003a44' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/search.tpl',
      1 => 1441542944,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58d88ebfdd6835_06281110 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
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
