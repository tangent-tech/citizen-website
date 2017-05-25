<?php
/* Smarty version 3.1.30, created on 2017-04-19 18:09:13
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/product_root_link_real_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7a7c9964e74_58439141',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f361d15e34e8ab62a73f74315e8af053db18b2af' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/product_root_link_real_edit.tpl',
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
function content_58f7a7c9964e74_58439141 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle"><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Root Link - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ObjectLink']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
 &nbsp;
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="product_root_link_real_delete.php?link_id=<?php echo $_REQUEST['link_id'];?>
">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="language_tree.php?id=<?php echo $_smarty_tpl->tpl_vars['ObjectLink']->value['language_id'];?>
">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Language Tree
	</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_root_link_real_edit_act.php">
		<div id="ProductRootLinkTabs">
			<ul>
				<li><a href="#ProductRootLink-ProductRoot"><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Tree Link Details</a></li>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?><li><a href="#ProductRootLink-Permission">Permission</a></li><?php }?>
			</ul>
			<div id="ProductRootLink-ProductRoot">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_common_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<tr>
							<th> <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Tree </th>
							<td>
								<select id="product_root_id" name="product_root_id">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
									    <option value="<?php echo $_smarty_tpl->tpl_vars['R']->value['object_id'];?>
"
											<?php if ($_smarty_tpl->tpl_vars['R']->value['object_id'] == $_smarty_tpl->tpl_vars['ProductRootLink']->value['product_root_id']) {?>selected="selected"<?php }?>
									    ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['R']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
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
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?>
				<div id="ProductRootLink-Permission">
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
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
