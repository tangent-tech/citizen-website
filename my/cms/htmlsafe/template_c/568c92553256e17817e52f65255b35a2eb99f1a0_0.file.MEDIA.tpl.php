<?php
/* Smarty version 3.1.30, created on 2017-04-19 16:34:32
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/MEDIA.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f791982ec083_86431414',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '568c92553256e17817e52f65255b35a2eb99f1a0' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/MEDIA.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58f791982ec083_86431414 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/var/www/apps/citizen/my/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
<media>
	<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<media_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['media_id'];?>
</media_id>
	<media_type><?php echo $_smarty_tpl->tpl_vars['Object']->value['media_type'];?>
</media_type>
	<media_desc><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['media_desc']);?>
</media_desc>
	<media_filename><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['filename']);?>
</media_filename>
	<media_small_file_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['media_small_file_id'];?>
</media_small_file_id>
	<media_big_file_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['media_big_file_id'];?>
</media_big_file_id>
	<?php $_smarty_tpl->_assignInScope('object_type', 'media');
?>
	<?php
$__section_foo_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', ((string)$_smarty_tpl->tpl_vars['object_type']->value)."_custom_text_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
		<?php if ($_smarty_tpl->tpl_vars['MediaCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
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
		<?php if ($_smarty_tpl->tpl_vars['MediaCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
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
		<?php if ($_smarty_tpl->tpl_vars['MediaCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
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
		<?php if ($_smarty_tpl->tpl_vars['MediaCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
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
</media><?php }
}