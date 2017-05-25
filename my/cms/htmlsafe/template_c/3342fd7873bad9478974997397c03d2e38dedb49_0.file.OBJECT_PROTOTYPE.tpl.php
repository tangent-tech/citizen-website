<?php
/* Smarty version 3.1.30, created on 2017-03-23 19:15:59
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/OBJECT_PROTOTYPE.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d410dfb5c657_17334974',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3342fd7873bad9478974997397c03d2e38dedb49' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/api/object_info/OBJECT_PROTOTYPE.tpl',
      1 => 1476788188,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58d410dfb5c657_17334974 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_myxml')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.myxml.php';
?>
	<object_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_id'];?>
</object_id>
	<object_link_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_link_id'];?>
</object_link_id>
	<object_is_enable><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_is_enable'];?>
</object_is_enable>
	<object_link_is_enable><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_link_is_enable'];?>
</object_link_is_enable>
	<object_type><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_type'];?>
</object_type>
	<object_security_level><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_security_level'];?>
</object_security_level>
	<object_archive_date><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_archive_date'];?>
</object_archive_date>
	<object_publish_date><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_publish_date'];?>
</object_publish_date>
	<parent_object_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['parent_object_id'];?>
</parent_object_id>
	<language_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['language_id'];?>
</language_id>
	<object_name><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['object_name']);?>
</object_name>
	<object_thumbnail_file_id><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_thumbnail_file_id'];?>
</object_thumbnail_file_id>
	<object_meta_title><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['object_meta_title']);?>
</object_meta_title>
	<object_meta_description><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['object_meta_description']);?>
</object_meta_description>
	<object_meta_keywords><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['object_meta_keywords']);?>
</object_meta_keywords>
	<?php if ($_smarty_tpl->tpl_vars['Object']->value['object_type'] != 'LINK') {?>
		<object_friendly_url><?php echo smarty_modifier_myxml(ConvertToHyphen($_smarty_tpl->tpl_vars['Object']->value['object_friendly_url']));?>
</object_friendly_url>
	<?php } else { ?>
		<object_friendly_url><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['object_friendly_url']);?>
</object_friendly_url>
	<?php }?>
	<object_seo_url><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['object_seo_url']);?>
</object_seo_url>
	<object_lang_switch_id><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['object_lang_switch_id']);?>
</object_lang_switch_id>
	<modify_date><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['modify_date']);?>
</modify_date>
	<create_date><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value['create_date']);?>
</create_date>
	<counter_alltime><?php echo $_smarty_tpl->tpl_vars['Object']->value['counter_alltime'];?>
</counter_alltime>
	<object_vote_sum_1><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_sum_1'];?>
</object_vote_sum_1>
	<object_vote_count_1><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_count_1'];?>
</object_vote_count_1>
	<object_vote_average_1><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_average_1'];?>
</object_vote_average_1>
	<object_vote_sum_2><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_sum_2'];?>
</object_vote_sum_2>
	<object_vote_count_2><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_count_2'];?>
</object_vote_count_2>
	<object_vote_average_2><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_average_2'];?>
</object_vote_average_2>
	<object_vote_sum_3><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_sum_3'];?>
</object_vote_sum_3>
	<object_vote_count_3><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_count_3'];?>
</object_vote_count_3>
	<object_vote_average_3><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_average_3'];?>
</object_vote_average_3>
	<object_vote_sum_4><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_sum_4'];?>
</object_vote_sum_4>
	<object_vote_count_4><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_count_4'];?>
</object_vote_count_4>
	<object_vote_average_4><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_average_4'];?>
</object_vote_average_4>
	<object_vote_sum_5><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_sum_5'];?>
</object_vote_sum_5>
	<object_vote_count_5><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_count_5'];?>
</object_vote_count_5>
	<object_vote_average_5><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_average_5'];?>
</object_vote_average_5>
	<object_vote_sum_6><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_sum_6'];?>
</object_vote_sum_6>
	<object_vote_count_6><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_count_6'];?>
</object_vote_count_6>
	<object_vote_average_6><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_average_6'];?>
</object_vote_average_6>
	<object_vote_sum_7><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_sum_7'];?>
</object_vote_sum_7>
	<object_vote_count_7><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_count_7'];?>
</object_vote_count_7>
	<object_vote_average_7><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_average_7'];?>
</object_vote_average_7>
	<object_vote_sum_8><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_sum_8'];?>
</object_vote_sum_8>
	<object_vote_count_8><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_count_8'];?>
</object_vote_count_8>
	<object_vote_average_8><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_average_8'];?>
</object_vote_average_8>
	<object_vote_sum_9><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_sum_9'];?>
</object_vote_sum_9>
	<object_vote_count_9><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_count_9'];?>
</object_vote_count_9>
	<object_vote_average_9><?php echo $_smarty_tpl->tpl_vars['Object']->value['object_vote_average_9'];?>
</object_vote_average_9>
	<?php
$__section_foo_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 9; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
		<?php $_smarty_tpl->_assignInScope('myfield', "object_custom_rgb_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
		<?php if ($_smarty_tpl->tpl_vars['Object']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?><<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php echo smarty_modifier_myxml($_smarty_tpl->tpl_vars['Object']->value[$_smarty_tpl->tpl_vars['myfield']->value]);?>
</<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
><?php }?>
	<?php
}
}
if ($__section_foo_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_0_saved;
}
}
}
