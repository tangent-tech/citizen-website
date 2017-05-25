<?php
/* Smarty version 3.1.30, created on 2017-04-19 19:18:45
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/api/object_info/LAYOUT.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7b8153ae628_34737895',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '96a01fa80df6ebe5456e54331f9724a0e4a8a41a' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/api/object_info/LAYOUT.tpl',
      1 => 1491504947,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58f7b8153ae628_34737895 (Smarty_Internal_Template $_smarty_tpl) {
?>
<layout>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<layout_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_id'];?>
</layout_id>
	<layout_name><?php echo $_smarty_tpl->tpl_vars['Object']->value['layout_name'];?>
</layout_name>
	<block_defs><?php echo $_smarty_tpl->tpl_vars['BlockDefXML']->value;?>
</block_defs>
</layout><?php }
}
