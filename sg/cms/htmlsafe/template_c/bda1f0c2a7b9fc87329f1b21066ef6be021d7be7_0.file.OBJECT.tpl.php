<?php
/* Smarty version 3.1.30, created on 2017-04-19 19:18:43
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/api/object_info/OBJECT.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7b813cacc60_06982870',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bda1f0c2a7b9fc87329f1b21066ef6be021d7be7' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/api/object_info/OBJECT.tpl',
      1 => 1491504948,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58f7b813cacc60_06982870 (Smarty_Internal_Template $_smarty_tpl) {
?>
<object>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<objects><?php echo $_smarty_tpl->tpl_vars['ObjectsXML']->value;?>
</objects>
	<object_details><?php echo $_smarty_tpl->tpl_vars['ObjectDetailXML']->value;?>
</object_details>
</object><?php }
}
