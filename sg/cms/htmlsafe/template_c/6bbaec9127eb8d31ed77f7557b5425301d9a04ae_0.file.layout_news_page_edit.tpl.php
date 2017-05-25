<?php
/* Smarty version 3.1.30, created on 2017-04-24 08:46:53
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/layout_news_page_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58fdbb7dcfefe1_73584786',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6bbaec9127eb8d31ed77f7557b5425301d9a04ae' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/layout_news_page_edit.tpl',
      1 => 1491504955,
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
function content_58fdbb7dcfefe1_73584786 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle"><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_layout_news']);?>
 Page - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ObjectLink']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
 &nbsp;
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="layout_news_page_delete.php?link_id=<?php echo $_REQUEST['link_id'];?>
">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="language_tree.php?id=<?php echo $_smarty_tpl->tpl_vars['ObjectLink']->value['language_id'];?>
">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Language Tree
	</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_page_edit_act.php">
		<div id="LayoutNewsPageTabs">
			<ul>
				<li><a href="#LayoutNewsPageTabs-LayoutNewsPage"><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_layout_news']);?>
 Page Details</a></li>
				<li><a href="#LayoutNewsPageTabs-SEO">SEO</a></li>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?><li><a href="#LayoutNewsPageTabs-Permission">Permission</a></li><?php }?>
			</ul>
			<div id="LayoutNewsPageTabs-LayoutNewsPage">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_common_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<tr>
							<th> <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_layout_news']);?>
 Root </th>
							<td>
								<select id="layout_news_root_id" name="layout_news_root_id">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LayoutNewsRootList']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
									    <option value="<?php echo $_smarty_tpl->tpl_vars['R']->value['layout_news_root_id'];?>
"
											<?php if ($_smarty_tpl->tpl_vars['R']->value['layout_news_root_id'] == $_smarty_tpl->tpl_vars['LayoutNewsPage']->value['layout_news_root_id']) {?>selected="selected"<?php }?>
									    ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['R']->value['layout_news_root_name'], ENT_QUOTES, 'UTF-8', true);?>
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
							<th> <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_layout_news']);?>
 Category </th>
							<td>
								<select id="layout_news_category_id" name="layout_news_category_id">
									<option value="0" <?php if ($_smarty_tpl->tpl_vars['LayoutNewsPage']->value['layout_news_category_id'] == 0) {?>selected="selected"<?php }?>>All</option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LayoutNewsCategories']->value, 'C');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['C']->value) {
?>
									    <option value="<?php echo $_smarty_tpl->tpl_vars['C']->value['layout_news_category_id'];?>
"
											<?php if ($_smarty_tpl->tpl_vars['C']->value['layout_news_category_id'] == $_smarty_tpl->tpl_vars['LayoutNewsPage']->value['layout_news_category_id']) {?>selected="selected"<?php }?>
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
					</table>
				</div>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_seo_tab'] == 'Y') {?>
				<div id="LayoutNewsPageTabs-SEO">
					<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_meta_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?>
				<div id="LayoutNewsPageTabs-Permission">
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
