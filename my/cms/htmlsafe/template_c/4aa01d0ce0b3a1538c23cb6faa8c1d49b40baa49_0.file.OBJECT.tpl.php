<?php
/* Smarty version 3.1.30, created on 2017-03-23 19:15:59
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/OBJECT.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d410dfa92740_59703030',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4aa01d0ce0b3a1538c23cb6faa8c1d49b40baa49' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/OBJECT.tpl',
      1 => 1441542942,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58d410dfa92740_59703030 (Smarty_Internal_Template $_smarty_tpl) {
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
