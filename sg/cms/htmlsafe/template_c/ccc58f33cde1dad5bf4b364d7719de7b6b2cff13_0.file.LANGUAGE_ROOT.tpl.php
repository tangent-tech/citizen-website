<?php
/* Smarty version 3.1.30, created on 2017-03-24 17:04:57
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/LANGUAGE_ROOT.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d543a94ad384_29626112',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ccc58f33cde1dad5bf4b364d7719de7b6b2cff13' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/LANGUAGE_ROOT.tpl',
      1 => 1441542944,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58d543a94ad384_29626112 (Smarty_Internal_Template $_smarty_tpl) {
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
