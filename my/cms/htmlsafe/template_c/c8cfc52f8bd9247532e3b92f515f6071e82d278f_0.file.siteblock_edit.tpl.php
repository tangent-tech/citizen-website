<?php
/* Smarty version 3.1.30, created on 2017-04-26 07:00:05
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/siteblock_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59004575764cd4_63121881',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c8cfc52f8bd9247532e3b92f515f6071e82d278f' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/siteblock_edit.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_inner.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_site_content.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/_object_common_edit.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/_object_permission_edit.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_2ndlevel.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_inner.tpl' => 1,
  ),
),false)) {
function content_59004575764cd4_63121881 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Edit Site Block Content - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockDef']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
 &nbsp;
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="siteblock_delete.php?id=<?php echo $_REQUEST['id'];?>
">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="siteblock.php?language_id=<?php echo $_smarty_tpl->tpl_vars['BlockContent']->value['language_id'];?>
">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Site Block List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="siteblock_edit_act.php">
		<div id="SiteBlockTabs">
			<ul>
				<li><a href="#SiteBlockTabs-CommonData">Reference Data</a></li>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?><li><a href="#SiteBlockTabs-Permission">Permission</a></li><?php }?>
			</ul>
			<div id="SiteBlockTabs-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Block Name </th>
							<td> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockDef']->value['block_definition_desc'], ENT_QUOTES, 'UTF-8', true);?>
 </td>
						</tr>
						<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_common_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<?php if ($_smarty_tpl->tpl_vars['BlockDef']->value['block_definition_type'] == 'text') {?>
							<tr>
								<th> Block Reference Name </th>
								<td> <input type="text" name="object_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> Block Content </th>
								<td> <input type="text" name="block_content" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['block_content'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> Block Link </th>
								<td> <input type="text" name="block_link_url" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['block_link_url'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
							</tr>
						<?php } elseif ($_smarty_tpl->tpl_vars['BlockDef']->value['block_definition_type'] == 'textarea') {?>
							<tr>
								<th> Block Reference Name </th>
								<td> <input type="text" name="object_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
							</tr>
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
								<th> Block Link </th>
								<td> <input type="text" name="block_link_url" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['block_link_url'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<td colspan="2"> <?php echo $_smarty_tpl->tpl_vars['EditorHTML']->value;?>
 </td>
							</tr>
						<?php } elseif ($_smarty_tpl->tpl_vars['BlockDef']->value['block_definition_type'] == 'image') {?>
							<tr>
								<th> Image Alt Text </th>
								<td> <input type="text" name="object_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> Image (<?php echo $_smarty_tpl->tpl_vars['BlockDef']->value['block_image_width'];?>
px x <?php echo $_smarty_tpl->tpl_vars['BlockDef']->value['block_image_height'];?>
px) </th>
								<td>
									<?php if ($_smarty_tpl->tpl_vars['BlockContent']->value['block_image_id'] != 0) {?>
										<a href="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['BlockContent']->value['block_image_id'];?>
" target="_preview" ><img <?php if ($_smarty_tpl->tpl_vars['BlockDef']->value['block_image_width'] < 800 && $_smarty_tpl->tpl_vars['BlockDef']->value['block_image_width'] > 0) {?>width="<?php echo $_smarty_tpl->tpl_vars['BlockDef']->value['block_image_width'];?>
"<?php } elseif ($_smarty_tpl->tpl_vars['BlockDef']->value['block_image_width'] > 0) {?>width="800"<?php }?> src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['BlockContent']->value['block_image_id'];?>
" /></a> <br />
									<?php }?>
									<input type="file" name="block_image" />
								</td>
							</tr>
							<tr>
								<th> Image Text Content </th>
								<td> <input type="text" name="block_content" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['block_content'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> Block Link </th>
								<td> <input type="text" name="block_link_url" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['block_link_url'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
							</tr>
						<?php }?>
					</table>
				</div>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?>
				<div id="SiteBlockTabs-Permission">
					<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_permission_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

				</div>
			<?php }?>
			<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>
" />
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> Submit
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</div>
		</div>
	</form>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
