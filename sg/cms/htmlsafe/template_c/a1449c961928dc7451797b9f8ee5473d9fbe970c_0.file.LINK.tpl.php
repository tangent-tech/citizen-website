<?php
/* Smarty version 3.1.30, created on 2017-05-03 03:57:22
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/api/object_info/LINK.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5909552285d9f2_92785493',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a1449c961928dc7451797b9f8ee5473d9fbe970c' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/api/object_info/LINK.tpl',
      1 => 1491504947,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_5909552285d9f2_92785493 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/var/www/apps/citizen/sg/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<link>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<link_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['link_id'];?>
</link_id>
	<link_url><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['link_url']);?>
</link_url>
</link><?php }
}
