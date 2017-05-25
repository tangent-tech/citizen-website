<?php
/* Smarty version 3.1.30, created on 2017-04-07 05:18:34
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/page_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58e7212a4cbf14_87682655',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '214dbbee3a9f7050f7a480f07595ddb6a2fdc728' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/page_edit.tpl',
      1 => 1491504957,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_inner.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_site_content.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/_object_common_edit.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/_object_meta_edit.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/_object_permission_edit.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_2ndlevel.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_inner.tpl' => 1,
  ),
),false)) {
function content_58e7212a4cbf14_87682655 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/var/www/apps/citizen/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.truncate.php';
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Page - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ObjectLink']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
 (id: <?php echo $_smarty_tpl->tpl_vars['ObjectLink']->value['object_id'];?>
) &nbsp;
	<a onclick="return DoubleConfirm('WARNING!\n All corresponding block content will also be deleted!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton" href="page_delete.php?link_id=<?php echo $_REQUEST['link_id'];?>
">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="language_tree.php?id=<?php echo $_smarty_tpl->tpl_vars['ObjectLink']->value['language_id'];?>
">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Language Tree
	</a>
</h1>

<div class="PageEditRight">
	<?php if ($_smarty_tpl->tpl_vars['Page']->value['layout_file_id'] != 0) {?>
		<a href="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['Page']->value['layout_file_id'];?>
" target="_preview" class="PreviewImage"><img src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['Page']->value['layout_file_id'];?>
" /></a> <br />
	<?php }?>
</div>

<div class="PageEditLeft InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="page_edit_act.php">
		<div id="PageTabs">
			<ul>
				<li><a href="#PageTabs-Page">Page Info</a></li>
				<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_seo_tab'] == 'Y') {?><li><a href="#PageTabs-SEO">SEO</a></li><?php }?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?><li><a href="#PageTabs-Permission">Permission</a></li><?php }?>
			</ul>
			<div id="PageTabs-Page">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_common_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<tr>
							<th> Page Title </th>
							<td> <input type="text" name="page_title" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Page']->value['page_title'], ENT_QUOTES, 'UTF-8', true);?>
" size="50" /> </td>
						</tr>
						<tr>
							<th>Tag</th>
							<td>
								<p>Please seperate the tag by comma(,)</p>
								<input type="text" name="page_tag" value="<?php echo substr($_smarty_tpl->tpl_vars['Page']->value['page_tag'],2,-htmlspecialchars(2, ENT_QUOTES, 'UTF-8', true));?>
" size="50" maxlength="255" />
							</td>
						</tr>
						<tr>
							<th> Page Layout </th>
							<td>
								<select name="layout_id">
									<option value="0" <?php if ($_smarty_tpl->tpl_vars['Page']->value['layout_id'] == 0) {?>selected="selected"<?php }?>> - </option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Layouts']->value, 'L');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['L']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['L']->value['layout_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['L']->value['layout_id'] == $_smarty_tpl->tpl_vars['Page']->value['layout_id']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['L']->value['layout_name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
							</td>
						</tr>
						<tr>
							<th> Album </th>
							<td>
								<select name="album_id">
									<option value="0" <?php if ($_smarty_tpl->tpl_vars['Page']->value['album_id'] == 0) {?>selected="selected"<?php }?>> - </option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Albums']->value, 'A');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['A']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['A']->value['album_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['A']->value['album_id'] == $_smarty_tpl->tpl_vars['Page']->value['album_id']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['A']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_seo_tab'] == 'Y') {?>
				<div id="PageTabs-SEO">
					<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_meta_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?>
				<div id="PageTabs-Permission">
					<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_permission_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

				</div>
			<?php }?>
			
			<input type="hidden" name="link_id" value="<?php echo $_REQUEST['link_id'];?>
" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
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
<br class="clearfloat" />
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['BlockDefs']->value, 'D');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['D']->value) {
?>
	<div class="PageEditLeft InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
		<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['D']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['D']->value['block_definition_desc'], ENT_QUOTES, 'UTF-8', true);?>
</p>
			<table id="BlockDefTable-<?php echo $_smarty_tpl->tpl_vars['D']->value['block_definition_id'];?>
" class="TopHeaderTable ui-helper-reset SortTable">
				<tr class="ui-state-highlight nodrop nodrag">
					<?php if ($_smarty_tpl->tpl_vars['D']->value['block_definition_type'] == 'text' || $_smarty_tpl->tpl_vars['D']->value['block_definition_type'] == 'html') {?>
						<th width="50" class="AlignCenter">ID</th>
						<th width="220">Content Name</th>
						<th width="150">Action</th>
					<?php } elseif ($_smarty_tpl->tpl_vars['D']->value['block_definition_type'] == 'image') {?>
						<th width="50" class="AlignCenter">ID</th>
						<th width="220">Image</th>
						<th width="150">Action</th>
					<?php }?>
				</tr>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['BlockContents']->value[$_smarty_tpl->tpl_vars['D']->value['block_definition_id']], 'C');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['C']->value) {
?>
					<tr id="BC-<?php echo $_smarty_tpl->tpl_vars['C']->value['block_content_id'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['C']->value['object_is_enable'] == 'N') {?>DisabledRow<?php }?>">
						<td class="AlignCenter"><?php echo $_smarty_tpl->tpl_vars['C']->value['block_content_id'];?>
</td>
						<td>
							<?php if ($_smarty_tpl->tpl_vars['D']->value['block_definition_type'] == 'text') {?>
								<?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['block_content'], ENT_QUOTES, 'UTF-8', true),30,"...");?>

							<?php } elseif ($_smarty_tpl->tpl_vars['D']->value['block_definition_type'] == 'textarea') {?>
								<?php echo nl2br(smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['block_content'], ENT_QUOTES, 'UTF-8', true),30,"..."));?>

							<?php } elseif ($_smarty_tpl->tpl_vars['D']->value['block_definition_type'] == 'html') {?>
								<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>

							<?php } elseif ($_smarty_tpl->tpl_vars['D']->value['block_definition_type'] == 'image') {?>
								<?php if ($_smarty_tpl->tpl_vars['C']->value['block_image_id'] != 0) {?>
									<a href="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['C']->value['block_image_id'];?>
" target="_preview" class="PagePreviewImage"><img <?php if ($_smarty_tpl->tpl_vars['D']->value['block_image_width'] < 150 && $_smarty_tpl->tpl_vars['D']->value['block_image_width'] > 0) {?>width="<?php echo $_smarty_tpl->tpl_vars['D']->value['block_image_width'];?>
"<?php } else { ?>width="150"<?php }?> src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['C']->value['block_image_id'];?>
" /></a>
								<?php }?>
							<?php } elseif ($_smarty_tpl->tpl_vars['D']->value['block_definition_type'] == 'file') {?>
								<?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['block_content'], ENT_QUOTES, 'UTF-8', true),30,"...");?>
 <br />
								<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['filename'], ENT_QUOTES, 'UTF-8', true);?>
 <br />
								Filesize: <?php echo $_smarty_tpl->tpl_vars['C']->value['size']/sprintf("%.2f",1024);?>
kb
							<?php }?>
						</td>
						<td>
							<a href="block_edit.php?link_id=<?php echo $_REQUEST['link_id'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['C']->value['block_content_id'];?>
" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> edit
							</a>
							<a href="block_delete.php?link_id=<?php echo $_REQUEST['link_id'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['C']->value['block_content_id'];?>
" onclick='return confirm("WARNING! \n Are you sure you want to delete?")' class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-trash"></span> delete
							</a>
						</td>
					</tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			</table>
			<a href="block_add.php?link_id=<?php echo $_REQUEST['link_id'];?>
&block_def_id=<?php echo $_smarty_tpl->tpl_vars['D']->value['block_definition_id'];?>
" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>New Block</a>
		</div>
	</div>
	<br class="clearfloat" />
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<br class="clearfloat" />
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
