<?php
/* Smarty version 3.1.30, created on 2017-03-24 13:30:26
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/PAGE.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d511622fe1f4_25601685',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f32510c926a1778342044dbf1cca968eed31f17b' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/PAGE.tpl',
      1 => 1441542942,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58d511622fe1f4_25601685 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<page>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<page_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_id'];?>
</page_id>
	<page_title><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['page_title']);?>
</page_title>
	<search_block_content><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['block_content']);?>
</search_block_content>
	<?php echo $_smarty_tpl->tpl_vars['LayoutXML']->value;?>

	<?php echo $_smarty_tpl->tpl_vars['AlbumXML']->value;?>

</page><?php }
}