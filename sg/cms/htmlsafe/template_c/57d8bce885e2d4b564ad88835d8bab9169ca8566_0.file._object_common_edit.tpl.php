<?php
/* Smarty version 3.1.30, created on 2017-03-27 11:25:40
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/_object_common_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d8da94ec8378_30276595',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '57d8bce885e2d4b564ad88835d8bab9169ca8566' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/_object_common_edit.tpl',
      1 => 1490606593,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58d8da94ec8378_30276595 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_object_preview_key')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.object_preview_key.php';
if (!is_callable('smarty_modifier_date_format')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_function_html_select_time')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/function.html_select_time.php';
?>
<tr>
	<th>Last Modify Date</th>
	<td><?php echo $_smarty_tpl->tpl_vars['TheObject']->value['modify_date'];?>
</td>
</tr>
<tr>
	<th>Link</th>
	<td>
		<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_friendly_link_enable'] == 'Y') {?>
			<a href="http://<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_address'];
echo $_smarty_tpl->tpl_vars['TheObject']->value['object_seo_url'];?>
?preview_key=<?php echo smarty_modifier_object_preview_key($_smarty_tpl->tpl_vars['TheObject']->value['object_id'],$_smarty_tpl->tpl_vars['Site']->value['site_api_key']);?>
" target="_blank">http://<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_address'];
echo $_smarty_tpl->tpl_vars['TheObject']->value['object_seo_url'];?>
?&preview_key=<?php echo smarty_modifier_object_preview_key($_smarty_tpl->tpl_vars['TheObject']->value['object_id'],$_smarty_tpl->tpl_vars['Site']->value['site_api_key']);?>
</a>
		<?php } else { ?>
			<?php if (intval($_smarty_tpl->tpl_vars['TheObject']->value['object_link_id']) > 0) {?>
				<a href="http://<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_address'];?>
/load.php?link_id=<?php echo $_smarty_tpl->tpl_vars['TheObject']->value['object_link_id'];?>
&preview_key=<?php echo smarty_modifier_object_preview_key($_smarty_tpl->tpl_vars['TheObject']->value['object_id'],$_smarty_tpl->tpl_vars['Site']->value['site_api_key']);?>
" target="_blank">http://<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_address'];?>
/load.php?link_id=<?php echo $_smarty_tpl->tpl_vars['TheObject']->value['object_link_id'];?>
&preview_key=<?php echo smarty_modifier_object_preview_key($_smarty_tpl->tpl_vars['TheObject']->value['object_id'],$_smarty_tpl->tpl_vars['Site']->value['site_api_key']);?>
</a>
			<?php } else { ?>			
				<a href="http://<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_address'];?>
/load.php?id=<?php echo $_smarty_tpl->tpl_vars['TheObject']->value['object_id'];?>
&preview_key=<?php echo smarty_modifier_object_preview_key($_smarty_tpl->tpl_vars['TheObject']->value['object_id'],$_smarty_tpl->tpl_vars['Site']->value['site_api_key']);?>
" target="_blank">http://<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_address'];?>
/load.php?id=<?php echo $_smarty_tpl->tpl_vars['TheObject']->value['object_id'];?>
&preview_key=<?php echo smarty_modifier_object_preview_key($_smarty_tpl->tpl_vars['TheObject']->value['object_id'],$_smarty_tpl->tpl_vars['Site']->value['site_api_key']);?>
</a>
			<?php }?>
		<?php }?>
	</td>
</tr>
<tr>
	<th>Status</th>
	<td>
		<input type="radio" name="object_is_enable" value="Y" <?php if ($_smarty_tpl->tpl_vars['TheObject']->value['object_is_enable'] == 'Y') {?>checked="checked"<?php }?>/> Enable
		<input type="radio" name="object_is_enable" value="N" <?php if ($_smarty_tpl->tpl_vars['TheObject']->value['object_is_enable'] == 'N') {?>checked="checked"<?php }?>/> Disable

		<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_security_level'] == 'N') {?>
			<input type="hidden" name="object_security_level" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['TheObject']->value['object_security_level'], ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_archive_date'] != 'Y') {?>
			<input type="hidden" name="object_archive_date" 		value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['TheObject']->value['object_archive_date'],'%Y-%m-%d');?>
" />
			<input type="hidden" name="object_archive_date_Hour" 	value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['TheObject']->value['object_archive_date'],'%k');?>
" />
			<input type="hidden" name="object_archive_date_Minute"	value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['TheObject']->value['object_archive_date'],'%M');?>
" />
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_publish_date'] != 'Y') {?>
			<input type="hidden" name="object_publish_date"			value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['TheObject']->value['object_publish_date'],'%Y-%m-%d');?>
" />
			<input type="hidden" name="object_publish_date_Hour" 	value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['TheObject']->value['object_publish_date'],'%k');?>
" />
			<input type="hidden" name="object_publish_date_Minute"	value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['TheObject']->value['object_publish_date'],'%M');?>
" />
		<?php }?>
	</td>
</tr>
<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_security_level'] != 'N') {?>
	<tr>
		<th> Security Level </th>
		<td> <input class="object_security_level" data-original_object_security_level="<?php echo $_smarty_tpl->tpl_vars['TheObject']->value['object_security_level'];?>
" type="text" name="object_security_level" value="<?php echo $_smarty_tpl->tpl_vars['TheObject']->value['object_security_level'];?>
" size="6" data-IsPublisher="<?php if ($_smarty_tpl->tpl_vars['IsPublisher']->value) {?>1<?php } else { ?>0<?php }?>" /> </td>
	</tr>	
<?php }
if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_archive_date'] == 'Y') {?>
	<tr>
		<th> Archive Date </th>
		<td> <input type="text" name="object_archive_date" class="DatePicker" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['TheObject']->value['object_archive_date'],'%Y-%m-%d');?>
" size="11" /> <?php echo smarty_function_html_select_time(array('prefix'=>'object_archive_date_','use_24_hours'=>true,'display_seconds'=>false,'time'=>$_smarty_tpl->tpl_vars['TheObject']->value['object_archive_date']),$_smarty_tpl);?>
</td>
	</tr>
<?php }
if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_publish_date'] == 'Y') {?>
	<tr>
		<th> Publish Date </th>
		<td> <input type="text" name="object_publish_date" class="DatePicker" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['TheObject']->value['object_publish_date'],'%Y-%m-%d');?>
" size="11" /> <?php echo smarty_function_html_select_time(array('prefix'=>'object_publish_date_','use_24_hours'=>true,'display_seconds'=>false,'time'=>$_smarty_tpl->tpl_vars['TheObject']->value['object_publish_date']),$_smarty_tpl);?>
</td>
	</tr>
<?php }
if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_lang_switch_id'] == 'Y') {?>
	<tr>
		<th> Language Matching ID </th>
		<td> <input type="text" name="object_lang_switch_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['TheObject']->value['object_lang_switch_id'], ENT_QUOTES, 'UTF-8', true);?>
" size="50" maxlength="255" /> </td>
	</tr>
<?php }
}
}
