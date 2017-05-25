<?php
/* Smarty version 3.1.30, created on 2017-04-24 06:19:13
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/siteblock.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58fd98e123a1f8_99130329',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9e8565ae3537bc69f8dc97ce6455caaf0653ecff' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/siteblock.tpl',
      1 => 1491504958,
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
function content_58fd98e123a1f8_99130329 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/var/www/apps/citizen/sg/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.truncate.php';
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Site Block List &nbsp;
	<form name="FrmSetLanguageID" id="FrmSetLanguageID" method="post">
		<select id="language_id" name="language_id" onchange="submit()">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguageRoots']->value, 'L');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['L']->value) {
?>
			    <option value="<?php echo $_smarty_tpl->tpl_vars['L']->value['language_id'];?>
"
					<?php if ($_smarty_tpl->tpl_vars['L']->value['language_id'] == $_REQUEST['language_id']) {?>selected="selected"<?php }?>
			    ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['L']->value['language_native'], ENT_QUOTES, 'UTF-8', true);?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</select>
	</form>
</h1>

<div class="PageEditRight">
	<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_block_file_id'] != 0) {?>
		<a href="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_block_file_id'];?>
" target="_preview" class="PreviewImage"><img src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_block_file_id'];?>
" /></a> <br />
	<?php }?>
</div>
<?php if (count($_smarty_tpl->tpl_vars['BlockDefs']->value) == 0) {?>
	<p>No Site Block is defined in your site. You may ignore this tab.</p>
<?php } else { ?>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['BlockDefs']->value, 'D');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['D']->value) {
?>
		<div class="PageEditLeft InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
			<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">
				<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['D']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo $_smarty_tpl->tpl_vars['D']->value['block_definition_id'];?>
)
				
				<?php if ($_smarty_tpl->tpl_vars['IsContentAdmin']->value && $_smarty_tpl->tpl_vars['Site']->value['site_module_workflow_enable'] == 'Y') {?>
					<a class="ui-state-default ui-corner-all MyButton" href="siteblock_holder_permission_edit.php?block_def_id=<?php echo $_smarty_tpl->tpl_vars['D']->value['block_definition_id'];?>
&language_id=<?php echo $_REQUEST['language_id'];?>
">
						<span class="ui-icon ui-icon-locked"></span> Permission
					</a>
				<?php }?>				
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
							<th width="160">Action</th>
						<?php } elseif ($_smarty_tpl->tpl_vars['D']->value['block_definition_type'] == 'image') {?>
							<th width="50" class="AlignCenter">ID </th>
							<th width="220">Image</th>
							<th width="160">Action</th>
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
"<?php } elseif ($_smarty_tpl->tpl_vars['D']->value['block_image_width'] > 0) {?>width="150"<?php }?> src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['C']->value['block_image_id'];?>
" /></a>
									<?php }?>
								<?php }?>
							</td>
							<td>
								<a href="siteblock_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['C']->value['block_content_id'];?>
" class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-pencil"></span> edit
								</a>
								<a href="siteblock_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['C']->value['block_content_id'];?>
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
				<a href="siteblock_add.php?block_def_id=<?php echo $_smarty_tpl->tpl_vars['D']->value['block_definition_id'];?>
&language_id=<?php echo $_REQUEST['language_id'];?>
" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>New Block</a>
			</div>
		</div>
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }?>
<br class="clearfloat" />
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
