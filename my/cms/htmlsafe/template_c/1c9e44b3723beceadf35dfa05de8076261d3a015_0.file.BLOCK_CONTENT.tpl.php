<?php
/* Smarty version 3.1.30, created on 2017-04-19 16:34:31
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/BLOCK_CONTENT.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f79197a50ab9_00112477',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1c9e44b3723beceadf35dfa05de8076261d3a015' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/BLOCK_CONTENT.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58f79197a50ab9_00112477 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/var/www/apps/citizen/my/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
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