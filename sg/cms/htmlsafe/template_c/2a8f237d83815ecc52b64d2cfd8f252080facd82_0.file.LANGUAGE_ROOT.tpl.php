<?php
/* Smarty version 3.1.30, created on 2017-04-06 19:48:40
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/api/object_info/LANGUAGE_ROOT.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58e69b988f91b2_96468747',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2a8f237d83815ecc52b64d2cfd8f252080facd82' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/api/object_info/LANGUAGE_ROOT.tpl',
      1 => 1491504947,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58e69b988f91b2_96468747 (Smarty_Internal_Template $_smarty_tpl) {
?>
<language_root>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<language_root_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['language_root_id'];?>
</language_root_id>
	<index_link_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['index_link_id'];?>
</index_link_id>
	<language_shortname><?php echo $_smarty_tpl->tpl_vars['Object']->value['language_shortname'];?>
</language_shortname>
	<language_longname><?php echo $_smarty_tpl->tpl_vars['Object']->value['language_longname'];?>
</language_longname>
	<language_native><?php echo $_smarty_tpl->tpl_vars['Object']->value['language_native'];?>
</language_native>
</language_root><?php }
}
