<?php
/* Smarty version 3.1.30, created on 2017-04-06 19:48:46
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/api/object_info/OBJECT.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58e69b9ec8ef79_78387958',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3f049f16584d7dc7ad988e5ce0a2bb48fb00967e' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/api/object_info/OBJECT.tpl',
      1 => 1491504948,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58e69b9ec8ef79_78387958 (Smarty_Internal_Template $_smarty_tpl) {
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
