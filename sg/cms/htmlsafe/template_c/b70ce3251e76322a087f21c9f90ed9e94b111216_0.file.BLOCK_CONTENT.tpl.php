<?php
/* Smarty version 3.1.30, created on 2017-03-23 19:16:21
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/BLOCK_CONTENT.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d410f5c59594_44917201',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b70ce3251e76322a087f21c9f90ed9e94b111216' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/BLOCK_CONTENT.tpl',
      1 => 1441542944,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58d410f5c59594_44917201 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<block>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<block_content_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['block_definition_id'];?>
</block_content_id>
	<block_content><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['block_content']);?>
</block_content>
	<block_link_url><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['block_link_url']);?>
</block_link_url>
	<block_image_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['block_image_id'];?>
</block_image_id>
	<block_file_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['block_file_id'];?>
</block_file_id>
</block><?php }
}
