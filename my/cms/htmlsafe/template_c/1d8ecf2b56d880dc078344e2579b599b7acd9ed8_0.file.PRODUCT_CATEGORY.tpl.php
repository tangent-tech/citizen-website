<?php
/* Smarty version 3.1.30, created on 2017-03-23 19:17:19
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/PRODUCT_CATEGORY.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d4112f6dcd79_20140586',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1d8ecf2b56d880dc078344e2579b599b7acd9ed8' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/PRODUCT_CATEGORY.tpl',
      1 => 1467212472,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58d4112f6dcd79_20140586 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<product_category>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<product_category_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['product_category_id'];?>
</product_category_id>
	<product_category_name><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['product_category_name']);?>
</product_category_name>
	<?php
$__section_foo_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 9; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', "product_category_price".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null))."_range_min");
?>
		<<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['ProductCatPriceRange']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
>
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
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 9; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', "product_category_price".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null))."_range_max");
?>
		<<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['ProductCatPriceRange']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
>
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
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 9; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', "product_category_price".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null))."_ca_range_min");
?>
		<<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['ProductCatPriceRange']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
>
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
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 9; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', "product_category_price".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null))."_ca_range_max");
?>
		<<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['ProductCatPriceRange']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
>
	<?php
}
}
if ($__section_foo_3_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_3_saved;
}
?>
	<total_no_of_products><?php echo $_smarty_tpl->tpl_vars['NoOfProducts']->value;?>
</total_no_of_products>
	<page_no><?php echo $_smarty_tpl->tpl_vars['PageNo']->value;?>
</page_no>
	<products_per_page><?php echo $_smarty_tpl->tpl_vars['ProductsPerPage']->value;?>
</products_per_page>
	<products><?php echo $_smarty_tpl->tpl_vars['ProductsXML']->value;?>
</products>
	<product_categories><?php echo $_smarty_tpl->tpl_vars['ProductCategoriesXML']->value;?>
</product_categories>
	<total_no_of_objects><?php echo $_smarty_tpl->tpl_vars['NoOfObjects']->value;?>
</total_no_of_objects>
	<objects><?php echo $_smarty_tpl->tpl_vars['ObjectsXML']->value;?>
</objects>
	<media_page_no><?php echo $_smarty_tpl->tpl_vars['MediaPageNo']->value;?>
</media_page_no>
	<total_no_of_media><?php echo $_smarty_tpl->tpl_vars['TotalNoOfMedia']->value;?>
</total_no_of_media>
	<media_list><?php echo $_smarty_tpl->tpl_vars['MediaListXML']->value;?>
</media_list>
	<?php $_smarty_tpl->_assignInScope('object_type', 'product_category');
?>
	<?php
$__section_foo_4_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', ((string)$_smarty_tpl->tpl_vars['object_type']->value)."_custom_text_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
		<?php if ($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php }?>
	<?php
}
}
if ($__section_foo_4_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_4_saved;
}
?>
	<?php
$__section_foo_5_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', ((string)$_smarty_tpl->tpl_vars['object_type']->value)."_custom_int_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
		<?php if ($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php }?>
	<?php
}
}
if ($__section_foo_5_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_5_saved;
}
?>
	<?php
$__section_foo_6_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', ((string)$_smarty_tpl->tpl_vars['object_type']->value)."_custom_double_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
		<?php if ($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php }?>
	<?php
}
}
if ($__section_foo_6_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_6_saved;
}
?>
	<?php
$__section_foo_7_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', ((string)$_smarty_tpl->tpl_vars['object_type']->value)."_custom_date_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
		<?php if ($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php }?>
	<?php
}
}
if ($__section_foo_7_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_7_saved;
}
?>
	<product_group_fields>
	<?php
$__section_foo_8_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 9; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', "product_category_group_field_name_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
		<?php if ($_smarty_tpl->tpl_vars['Object']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><product_group_field><?php echo smarty_modifier_myxml(substr($_smarty_tpl->tpl_vars['Object']->value[$_smarty_tpl->tpl_vars['myfield']->value],2));?>
</product_group_field><?php }?>
	<?php
}
}
if ($__section_foo_8_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_8_saved;
}
?>
	</product_group_fields>
	<product_category_group_json_cache><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['product_category_group_json_cache']);?>
</product_category_group_json_cache>
	<product_category_is_product_group><?php echo $_smarty_tpl->tpl_vars['Object']->value['product_category_is_product_group'];?>
</product_category_is_product_group>
</product_category><?php }
}
