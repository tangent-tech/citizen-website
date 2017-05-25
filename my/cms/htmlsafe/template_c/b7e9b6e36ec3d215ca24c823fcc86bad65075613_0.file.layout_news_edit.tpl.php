<?php
/* Smarty version 3.1.30, created on 2017-04-19 19:37:44
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/layout_news_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7bc88312162_17119620',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b7e9b6e36ec3d215ca24c823fcc86bad65075613' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/layout_news_edit.tpl',
      1 => 1492617058,
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
function content_58f7bc88312162_17119620 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/var/www/apps/citizen/my/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_function_html_select_time')) require_once '/var/www/apps/citizen/my/cms/htmlsafe/smarty-3.1.30/libs/plugins/function.html_select_time.php';
if (!is_callable('smarty_modifier_truncate')) require_once '/var/www/apps/citizen/my/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.truncate.php';
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Edit <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['LayoutNews']->value['layout_news_root_name'], ENT_QUOTES, 'UTF-8', true);?>
 &nbsp;
	<a href="layout_news_list.php?id=<?php echo $_smarty_tpl->tpl_vars['LayoutNews']->value['layout_news_root_id'];?>
" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['LayoutNews']->value['layout_news_root_name'], ENT_QUOTES, 'UTF-8', true);?>
</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_edit_act.php">
		<div id="LayoutNewsTabs">
			<ul>
				<li><a href="#LayoutNewsTabsPanel-News">Details</a></li>
				<li><a href="#LayoutNewsTabsPanel-SEO">SEO</a></li>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?><li><a href="#LayoutNewsTabsPanel-Permission">Permission</a></li><?php }?>
			</ul>
			<div id="LayoutNewsTabsPanel-News">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_common_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<tr>
							<th>Date</th>
							<td><input type="text" name="layout_news_date" class="DatePicker" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['LayoutNews']->value['layout_news_date'],'%Y-%m-%d');?>
" size="10" /> <?php echo smarty_function_html_select_time(array('use_24_hours'=>true,'display_seconds'=>false,'time'=>$_smarty_tpl->tpl_vars['LayoutNews']->value['layout_news_date']),$_smarty_tpl);?>
</td>
						</tr>
						<tr>
							<th>Category</th>
							<td>
								<select name="layout_news_category_id">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LayoutNewsCategories']->value, 'C');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['C']->value) {
?>
									    <option value="<?php echo $_smarty_tpl->tpl_vars['C']->value['layout_news_category_id'];?>
"
											<?php if ($_smarty_tpl->tpl_vars['C']->value['layout_news_category_id'] == $_smarty_tpl->tpl_vars['LayoutNews']->value['layout_news_category_id']) {?>selected="selected"<?php }?>
									    ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['layout_news_category_name'], ENT_QUOTES, 'UTF-8', true);?>
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
							<th>Title</th>
							<td><input type="text" name="layout_news_title" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['LayoutNews']->value['layout_news_title'], ENT_QUOTES, 'UTF-8', true);?>
" size="80" /></td>
						</tr>
						<tr>
							<th>Tag</th>
							<td><input type="text" name="layout_news_tag" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['LayoutNewsTagText']->value, ENT_QUOTES, 'UTF-8', true);?>
" size="80" /></td>
						</tr>
						<tr>
							<th> Layout </th>
							<td>
								<select name="layout_id">
									<option value="0" <?php if ($_smarty_tpl->tpl_vars['LayoutNews']->value['layout_id'] == 0) {?>selected="selected"<?php }?>> - </option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Layouts']->value, 'L');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['L']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['L']->value['layout_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['L']->value['layout_id'] == $_smarty_tpl->tpl_vars['LayoutNews']->value['layout_id']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['L']->value['layout_name'], ENT_QUOTES, 'UTF-8', true);?>
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
									<option value="0" <?php if ($_smarty_tpl->tpl_vars['LayoutNews']->value['album_id'] == 0) {?>selected="selected"<?php }?>> - </option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Albums']->value, 'A');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['A']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['A']->value['album_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['A']->value['album_id'] == $_smarty_tpl->tpl_vars['LayoutNews']->value['album_id']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['A']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
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
			<div id="LayoutNewsTabsPanel-SEO">
				<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_meta_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

			</div>
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?>
				<div id="LayoutNewsTabsPanel-Permission">
					<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_permission_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

				</div>
			<?php }?>
			<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>
" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
			<div class="ui-widget-header ui-corner-bottom InnerHeader">
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

							<?php } elseif ($_smarty_tpl->tpl_vars['D']->value['block_definition_type'] == 'html') {?>
								<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>

							<?php } elseif ($_smarty_tpl->tpl_vars['D']->value['block_definition_type'] == 'image') {?>
								<?php if ($_smarty_tpl->tpl_vars['C']->value['block_image_id'] != 0) {?>
									<a href="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['C']->value['block_image_id'];?>
" target="_preview" class="PagePreviewImage"><img <?php if ($_smarty_tpl->tpl_vars['D']->value['block_image_width'] > 0 && $_smarty_tpl->tpl_vars['D']->value['block_image_width'] < 150) {?>width="<?php echo $_smarty_tpl->tpl_vars['D']->value['block_image_width'];?>
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
							<a href="layout_news_block_edit.php?layout_news_id=<?php echo $_REQUEST['id'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['C']->value['block_content_id'];?>
" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> edit
							</a>
							<a href="layout_news_block_delete.php?layout_news_id=<?php echo $_REQUEST['id'];?>
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
			<a href="layout_news_block_add.php?layout_news_id=<?php echo $_REQUEST['id'];?>
&block_def_id=<?php echo $_smarty_tpl->tpl_vars['D']->value['block_definition_id'];?>
" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>New Block</a>
		</div>
	</div>
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
