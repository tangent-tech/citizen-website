<?php
/* Smarty version 3.1.30, created on 2017-04-19 19:37:48
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/layout_news_block_add.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7bc8cad1c70_81969656',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dac9d3eecff31efc561985af95bca3bad0a866ed' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/layout_news_block_add.tpl',
      1 => 1492617058,
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
function content_58f7bc8cad1c70_81969656 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Add Block Content &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="layout_news_edit.php?id=<?php echo $_REQUEST['layout_news_id'];?>
">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_layout_news']);?>

	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Block Details </h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_block_add_act.php">
		<div class="InnerContent ui-widget-content">
			<p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockDef']->value['block_definition_desc'], ENT_QUOTES, 'UTF-8', true);?>
</p>
			<table class="LeftHeaderTable">
				<tr>
					<th> Security Level </th>
					<td> <input type="text" name="object_security_level" value="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_default_security_level'];?>
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
						<td> <input type="text" name="block_link_url" value="<?php echo $_smarty_tpl->tpl_vars['BlockContent']->value['block_link_url'];?>
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
						<td> <input type="text" name="object_name" value="Untitled" size="90" maxlength="255" /> </td>
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
						<td> <input type="file" name="block_image" /> </td>
					</tr>
					<tr>
						<th> Block Link </th>
						<td> <input type="text" name="block_link_url" value="<?php echo $_smarty_tpl->tpl_vars['BlockContent']->value['block_link_url'];?>
" size="90" maxlength="255" /> </td>
					</tr>
				<?php } elseif ($_smarty_tpl->tpl_vars['BlockDef']->value['block_definition_type'] == 'file') {?>
					<tr>
						<th> File Reference Name </th>
						<td> <input type="text" name="block_content" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BlockContent']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
					</tr>
					<tr>
						<th> File </th>
						<td> <input type="file" name="block_file" /> </td>
					</tr>
				<?php }?>
			</table>
			<input type="hidden" name="layout_news_id" value="<?php echo $_REQUEST['layout_news_id'];?>
" />
			<input type="hidden" name="block_def_id" value="<?php echo $_REQUEST['block_def_id'];?>
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
