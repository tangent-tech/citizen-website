<?php
/* Smarty version 3.1.30, created on 2017-03-31 05:17:14
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/PRODUCT_BRAND.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58ddca3ac90753_97513370',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8279304fc235d145827189e90a345ff20f0fb559' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/PRODUCT_BRAND.tpl',
      1 => 1441542942,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58ddca3ac90753_97513370 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<product_brand>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<product_brand_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['product_brand_id'];?>
</product_brand_id>
	<product_brand_name><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['product_brand_name']);?>
</product_brand_name>
	<product_brand_desc><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['product_brand_desc']);?>
</product_brand_desc>
	<?php $_smarty_tpl->_assignInScope('object_type', 'product_brand');
?>
	<?php
$__section_foo_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', ((string)$_smarty_tpl->tpl_vars['object_type']->value)."_custom_text_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
		<?php if ($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php }?>
	<?php
}
}
if ($__section_foo_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_0_saved;
}
?>
	<?php
$__section_foo_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', ((string)$_smarty_tpl->tpl_vars['object_type']->value)."_custom_int_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
		<?php if ($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php }?>
	<?php
}
}
if ($__section_foo_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_1_saved;
}
?>
	<?php
$__section_foo_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', ((string)$_smarty_tpl->tpl_vars['object_type']->value)."_custom_double_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
		<?php if ($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php }?>
	<?php
}
}
if ($__section_foo_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_2_saved;
}
?>
	<?php
$__section_foo_3_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', ((string)$_smarty_tpl->tpl_vars['object_type']->value)."_custom_date_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
		<?php if ($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php }?>
	<?php
}
}
if ($__section_foo_3_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_3_saved;
}
?>	
</product_brand><?php }
}
