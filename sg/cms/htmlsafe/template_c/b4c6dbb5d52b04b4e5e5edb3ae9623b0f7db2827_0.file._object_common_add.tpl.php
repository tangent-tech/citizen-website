<?php
/* Smarty version 3.1.30, created on 2017-03-27 11:10:20
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/_object_common_add.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d8d6fc123287_31685590',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b4c6dbb5d52b04b4e5e5edb3ae9623b0f7db2827' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/_object_common_add.tpl',
      1 => 1441542942,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58d8d6fc123287_31685590 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_function_html_select_time')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/function.html_select_time.php';
?>
<tr>
	<th>Status</th>
	<td>
		<input type="radio" name="object_is_enable" value="Y" checked="checked" /> Enable
		<input type="radio" name="object_is_enable" value="N" /> Disable

		<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_security_level'] == 'N') {?>
			<input type="hidden" name="object_security_level" value="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_default_security_level'];?>
" />
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_archive_date'] != 'Y') {?>
			<input type="hidden" name="object_archive_date" 		value="<?php echo smarty_modifier_date_format(@constant('OBJECT_DEFAULT_ARCHIVE_DATE'),'%Y-%m-%d');?>
" />
			<input type="hidden" name="object_archive_date_Hour" 	value="<?php echo smarty_modifier_date_format(@constant('OBJECT_DEFAULT_ARCHIVE_DATE'),'%k');?>
" />
			<input type="hidden" name="object_archive_date_Minute"	value="<?php echo smarty_modifier_date_format(@constant('OBJECT_DEFAULT_ARCHIVE_DATE'),'%M');?>
" />
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_publish_date'] != 'Y') {?>
			<input type="hidden" name="object_publish_date"			value="<?php echo smarty_modifier_date_format(time(),'%Y-%m-%d');?>
" />
			<input type="hidden" name="object_publish_date_Hour" 	value="<?php echo smarty_modifier_date_format(time(),'%k');?>
" />
			<input type="hidden" name="object_publish_date_Minute"	value="<?php echo smarty_modifier_date_format(time(),'%M');?>
" />
		<?php }?>
	</td>
</tr>
<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_security_level'] != 'N') {?>
	<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_workflow_enable'] != 'Y' || $_smarty_tpl->tpl_vars['IsPublisher']->value) {?>
		<tr>
			<th> Security Level </th>
			<td> <input type="text" name="object_security_level" value="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_default_security_level'];?>
" size="6" /> </td>
		</tr>
	<?php }
}
if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_archive_date'] == 'Y') {?>
	<tr>
		<th> Archive Date </th>
		<td> <input type="text" name="object_archive_date" class="DatePicker" value="<?php echo smarty_modifier_date_format(@constant('OBJECT_DEFAULT_ARCHIVE_DATE'),'%Y-%m-%d');?>
" size="11" /> <?php echo smarty_function_html_select_time(array('prefix'=>'object_archive_date_','use_24_hours'=>true,'display_seconds'=>false,'time'=>@constant('OBJECT_DEFAULT_ARCHIVE_DATE')),$_smarty_tpl);?>
</td>
	</tr>
<?php }
if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_publish_date'] == 'Y') {?>
	<tr>
		<th> Publish Date </th>
		<td> <input type="text" name="object_publish_date" class="DatePicker" value="<?php echo smarty_modifier_date_format(time(),'%Y-%m-%d');?>
" size="11" /> <?php echo smarty_function_html_select_time(array('prefix'=>'object_publish_date_','use_24_hours'=>true,'display_seconds'=>false,'time'=>time()),$_smarty_tpl);?>
</td>
	</tr>
<?php }
if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_lang_switch_id'] == 'Y') {?>
	<tr>
		<th> Language Matching ID </th>
		<td> <input type="text" name="object_lang_switch_id" value="" size="60" maxlength="255" /> </td>
	</tr>
<?php }
}
}
