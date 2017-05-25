<?php
/* Smarty version 3.1.30, created on 2017-03-25 10:31:39
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/product_root_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d638fb5bf607_75433461',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '981887ca0f3bd1e7a3c12ba8f9ececc51c442a5e' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/product_root_edit.tpl',
      1 => 1462439956,
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
function content_58d638fb5bf607_75433461 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Edit <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Root &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_tree.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Tree
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_root_edit_act.php">
		<div id="ProductRootTabs">
			<ul>
				<li><a href="#ProductRootTabsPanel-CommonData">Common Data</a></li>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguageRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
				    <li><a href="#ProductRootTabsPanel-<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['R']->value['language_longname'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			</ul>
			<div id="ProductRootTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Root Name </th>
							<td> <input type="text" name="product_root_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ObjectLink']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
						</tr>
					</table>
					<input type="hidden" name="link_id" value="<?php echo $_REQUEST['link_id'];?>
" />
					<input class="HiddenSubmit" type="submit" value="Submit" />
				</div>
			</div>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguageRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
				<div id="ProductRootTabsPanel-<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_seo_tab'] == 'Y') {?>
								<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_friendly_link_enable'] == 'Y') {?>
									<tr>
										<th> Friendly URL </th>
										<td> <input type="text" name="object_friendly_url[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductRootData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['object_friendly_url'], ENT_QUOTES, 'UTF-8', true);?>
" maxlength="255" /> </td>
									</tr>
								<?php }?>
								<tr>
									<th> Meta Title </th>
									<td> <input type="text" name="object_meta_title[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductRootData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['object_meta_title'], ENT_QUOTES, 'UTF-8', true);?>
" size="50" maxlength="255" /> </td>
								</tr>
								<tr>
									<th> Meta Description </th>
									<td> <textarea name="object_meta_description[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" cols="48" rows="4"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductRootData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['object_meta_description'], ENT_QUOTES, 'UTF-8', true);?>
</textarea> </td>
								</tr>
								<tr>
									<th> Meta Keywords </th>
									<td> <textarea name="object_meta_keywords[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" cols="48" rows="4"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductRootData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['object_meta_keywords'], ENT_QUOTES, 'UTF-8', true);?>
</textarea> </td>
								</tr>								
							<?php }?>
						</table>
					</div>
			   </div>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

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
