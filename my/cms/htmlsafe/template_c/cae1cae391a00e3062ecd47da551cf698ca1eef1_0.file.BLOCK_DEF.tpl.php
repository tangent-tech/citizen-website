<?php
/* Smarty version 3.1.30, created on 2017-03-23 19:16:21
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/BLOCK_DEF.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d410f5c65ff6_88871845',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cae1cae391a00e3062ecd47da551cf698ca1eef1' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/BLOCK_DEF.tpl',
      1 => 1441542942,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58d410f5c65ff6_88871845 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<block_def>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<block_def_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['block_definition_id'];?>
</block_def_id>
	<block_def_type><?php echo $_smarty_tpl->tpl_vars['Object']->value['block_definition_type'];?>
</block_def_type>
	<block_def_name><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['object_name']);?>
</block_def_name>
	<block_def_desc><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['block_definition_desc']);?>
</block_def_desc>
	<block_contents><?php echo $_smarty_tpl->tpl_vars['BlockContentsXML']->value;?>
</block_contents>
</block_def><?php }
}
