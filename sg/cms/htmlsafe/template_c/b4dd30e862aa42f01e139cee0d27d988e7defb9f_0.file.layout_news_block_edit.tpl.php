<?php
/* Smarty version 3.1.30, created on 2017-04-19 19:30:25
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/layout_news_block_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7bad1461fa0_61298159',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b4dd30e862aa42f01e139cee0d27d988e7defb9f' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/layout_news_block_edit.tpl',
      1 => 1491504955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_inner.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_site_content.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_2ndlevel.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_inner.tpl' => 1,
  ),
),false)) {
function content_58f7bad1461fa0_61298159 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Edit Block Content - <?php echo $_smarty_tpl->tpl_vars['BlockDef']->value['object_name'];?>
 &nbsp;
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="layout_news_block_delete.php?layout_news_id=<?php echo $_REQUEST['layout_news_id'];?>
&id=<?php echo $_REQUEST['id'];?>
">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="layout_news_edit.php?id=<?php echo $_REQUEST['layout_news_id'];?>
">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_layout_news']);?>

	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Block Details</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_block_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockDef']->value['block_definition_desc'], ENT_QUOTES, 'UTF-8', true);?>
</p>
			<table class="LeftHeaderTable">
				<tr>
					<th>Last Modify Date</th>
					<td><?php echo $_smarty_tpl->tpl_vars['BlockContent']->value['modify_date'];?>
</td>
				</tr>
				<tr>
					<th>Status</th>
					<td>
						<input type="radio" name="object_is_enable" value="Y" <?php if ($_smarty_tpl->tpl_vars['BlockContent']->value['object_is_enable'] == 'Y') {?>checked="checked"<?php }?>/> Enable
						<input type="radio" name="object_is_enable" value="N" <?php if ($_smarty_tpl->tpl_vars['BlockContent']->value['object_is_enable'] == 'N') {?>checked="checked"<?php }?>/> Disable
					</td>
				</tr>
				<tr>
					<th> Security Level </th>
					<td> <input type="text" name="object_security_level" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['object_security_level'], ENT_QUOTES, 'UTF-8', true);?>
" size="6" /> </td>
				</tr>
			<?php if ($_smarty_tpl->tpl_vars['BlockDef']->value['block_definition_type'] == 'text') {?>
				<tr>
					<th> Block Content </th>
					<td> <textarea name="block_content" cols="50" rows="5"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['block_content'], ENT_QUOTES, 'UTF-8', true);?>
</textarea> </td>
					
				</tr>
				<tr>
					<th> Block Link </th>
					<td> <input type="text" name="block_link_url" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['block_link_url'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
				</tr>
			<?php } elseif ($_smarty_tpl->tpl_vars['BlockDef']->value['block_definition_type'] == 'textarea') {?>
				<tr>
					<th> Block Content </th>
					<td> <textarea name="block_content" cols="87" rows="5"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['block_content'], ENT_QUOTES, 'UTF-8', true);?>
</textarea> </td>
				</tr>
				<tr>
					<th> Block Link </th>
					<td> <input type="text" name="block_link_url" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['block_link_url'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
				</tr>
			<?php } elseif ($_smarty_tpl->tpl_vars['BlockDef']->value['block_definition_type'] == 'html') {?>
				<tr>
					<th> Block Reference Name </th>
					<td> <input type="text" name="object_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
				</tr>
				<tr>
					<td colspan="2"> <?php echo $_smarty_tpl->tpl_vars['EditorHTML']->value;?>
 </td>
				</tr>
			<?php } elseif ($_smarty_tpl->tpl_vars['BlockDef']->value['block_definition_type'] == 'image') {?>
				<tr>
					<th> Image (<?php echo $_smarty_tpl->tpl_vars['BlockDef']->value['block_image_width'];?>
px x <?php echo $_smarty_tpl->tpl_vars['BlockDef']->value['block_image_height'];?>
px) </th>
					<td>
						<?php if ($_smarty_tpl->tpl_vars['BlockContent']->value['block_image_id'] != 0) {?>
							<a href="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['BlockContent']->value['block_image_id'];?>
" target="_preview" ><img <?php if ($_smarty_tpl->tpl_vars['BlockDef']->value['block_image_width'] == 0) {
} elseif ($_smarty_tpl->tpl_vars['BlockDef']->value['block_image_width'] < 800) {?>width="<?php echo $_smarty_tpl->tpl_vars['BlockDef']->value['block_image_width'];?>
"<?php } else { ?>width="800"<?php }?> src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['BlockContent']->value['block_image_id'];?>
" /></a> <br />
						<?php }?>
						<input type="file" name="block_image" />
					</td>
				</tr>
				<tr>
					<th> Block Link </th>
					<td> <input type="text" name="block_link_url" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['block_link_url'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
				</tr>
			<?php } elseif ($_smarty_tpl->tpl_vars['BlockDef']->value['block_definition_type'] == 'file') {?>
				<tr>
					<th> File Reference Name </th>
					<td> <input type="text" name="block_content" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['block_content'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
				</tr>
				<tr>
					<th> File </th>
					<td>
						<a href="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['BlockContent']->value['block_file_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['BlockContent']->value['filename'];?>
</a> <br />
						Filesize: <?php echo $_smarty_tpl->tpl_vars['BlockContent']->value['size']/sprintf("%.2f",1024);?>
kb <br />
						<br />
						<input type="file" name="block_file" />
					</td>
				</tr>
			<?php }?>
			</table>
			<input type="hidden" name="layout_news_id" value="<?php echo $_REQUEST['layout_news_id'];?>
" />
			<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>
" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> Submit
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> Reset
			</a>
		</div>
	</form>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
