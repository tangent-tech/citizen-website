<?php
/* Smarty version 3.1.30, created on 2017-04-19 16:32:32
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/LANGUAGE_ROOT.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7912002a039_97134402',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5bfbc5c2246a48bb2e5b3956f396212f5562e5e3' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/LANGUAGE_ROOT.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58f7912002a039_97134402 (Smarty_Internal_Template $_smarty_tpl) {
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
