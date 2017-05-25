<?php
/* Smarty version 3.1.30, created on 2017-04-26 10:51:44
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/product_brand_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59007bc00d1c38_75869505',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '81a9a397e16afe17445036cfacfa81b11db64651' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/product_brand_edit.tpl',
      1 => 1491504957,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_inner.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_site_content.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/_object_common_edit.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/_object_meta_add.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_2ndlevel.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_inner.tpl' => 1,
  ),
),false)) {
function content_59007bc00d1c38_75869505 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/var/www/apps/citizen/sg/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_function_html_select_time')) require_once '/var/www/apps/citizen/sg/cms/htmlsafe/smarty-3.1.30/libs/plugins/function.html_select_time.php';
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Edit Brand (id: <?php echo $_smarty_tpl->tpl_vars['ProductBrand']->value['product_brand_id'];?>
) &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_brand_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Brand List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_brand_edit_act.php">
		<div id="ProductBrandTabs">
			<ul>
				<li><a href="#ProductBrandTabsPanel-CommonData">Common Data</a></li>
				<li><a href="#ProductBrandTabsPanel-SEO">SEO</a></li>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguageRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
				    <li><a href="#ProductBrandTabsPanel-<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['R']->value['language_longname'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			</ul>
			<div id="ProductBrandTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_common_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<tr>
							<th> Reference Name </th>
							<td> <input type="text" name="object_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductBrand']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th>Thumbnail</th>
							<td>
								<?php if ($_smarty_tpl->tpl_vars['ProductBrand']->value['object_thumbnail_file_id'] != 0) {?>
									<img class="MediaSmallFile" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_product_media_small_width'] < 80) {?>width="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_product_media_small_width'];?>
"<?php } else { ?>width="80"<?php }?> src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['ProductBrand']->value['object_thumbnail_file_id'];?>
" /> <br />
									<input type="checkbox" name="remove_thumbnail" value="Y" /> Remove thumbnail <br />									
								<?php }?>
								<input type="file" name="product_brand_file" />
							</td>
						</tr>
						<?php
$__section_foo_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
							<?php $_smarty_tpl->_assignInScope('myfield', "product_brand_custom_int_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
							<?php if ($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
								<tr>
									<th><?php echo $_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
</th>
									<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductBrand']->value[$_smarty_tpl->tpl_vars['myfield']->value], ENT_QUOTES, 'UTF-8', true);?>
" size="80" /></td>
								</tr>							
							<?php }?>
						<?php
}
}
if ($__section_foo_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_0_saved;
}
?>
						<?php
$__section_foo_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
							<?php $_smarty_tpl->_assignInScope('myfield', "product_brand_custom_double_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
							<?php if ($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
								<tr>
									<th><?php echo $_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
</th>
									<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductBrand']->value[$_smarty_tpl->tpl_vars['myfield']->value], ENT_QUOTES, 'UTF-8', true);?>
" size="80" /></td>
								</tr>							
							<?php }?>
						<?php
}
}
if ($__section_foo_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_1_saved;
}
?>
						<?php
$__section_foo_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
							<?php $_smarty_tpl->_assignInScope('myfield', "product_brand_custom_date_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
							<?php if ($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
								<tr>
									<th><?php echo $_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
</th>
									<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
" class="DatePicker" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['ProductBrand']->value[$_smarty_tpl->tpl_vars['myfield']->value],'%Y-%m-%d');?>
" size="10" /> <?php echo smarty_function_html_select_time(array('prefix'=>$_smarty_tpl->tpl_vars['myfield']->value,'use_24_hours'=>true,'display_seconds'=>false,'time'=>$_smarty_tpl->tpl_vars['ProductBrand']->value[$_smarty_tpl->tpl_vars['myfield']->value]),$_smarty_tpl);?>
</td>
								</tr>							
							<?php }?>
						<?php
}
}
if ($__section_foo_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_2_saved;
}
?>
					</table>
				</div>
			</div>
			<div id="ProductBrandTabsPanel-SEO">
				<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_meta_add.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

			</div>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguageRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
				<div id="ProductBrandTabsPanel-<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<?php if ($_smarty_tpl->tpl_vars['ProductBrandFieldsShow']->value['product_brand_name'] != 'N') {?>
								<tr>
									<th>Brand Name</th>
									<td>
										<textarea name="product_brand_name[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" cols="80" rows="3"><?php echo $_smarty_tpl->tpl_vars['ProductBrandData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['product_brand_name'];?>
</textarea>
									</td>
								</tr>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['ProductBrandFieldsShow']->value['product_desc'] != 'N') {?>
								<tr>
									<th>Brand Description</th>
									<td>
										<?php echo $_smarty_tpl->tpl_vars['EditorHTML']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']];?>

									</td>
								</tr>
							<?php }?>
							<?php
$__section_foo_3_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
								<?php $_smarty_tpl->_assignInScope('myfield', "product_brand_custom_text_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
								<?php if ($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
									<?php if (substr($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],0,5) == 'STXT_') {?>
										<tr>
											<th><?php echo substr($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],5);?>
</th>
											<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductBrandData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][$_smarty_tpl->tpl_vars['myfield']->value], ENT_QUOTES, 'UTF-8', true);?>
" size="80" /></td>
										</tr>
									<?php } elseif (substr($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],0,5) == 'MTXT_') {?>
										<tr>
											<th><?php echo substr($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],5);?>
</th>
											<td><textarea name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" cols="80" rows="8"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductBrandData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][$_smarty_tpl->tpl_vars['myfield']->value], ENT_QUOTES, 'UTF-8', true);?>
</textarea></td>
										</tr>
									<?php } elseif (substr($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],0,5) == 'HTML_') {?>
										<tr>
											<th><?php echo substr($_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],5);?>
</th>
											<td><?php echo $_smarty_tpl->tpl_vars['CustomFieldsEditorHTML']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)];?>
</td>
										</tr>
									<?php } else { ?>
										<tr>
											<th><?php echo $_smarty_tpl->tpl_vars['ProductBrandCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
</th>
											<td><?php echo $_smarty_tpl->tpl_vars['CustomFieldsEditorHTML']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)];?>
</td>
										</tr>
									<?php }?>
									
								<?php }?>
							<?php
}
}
if ($__section_foo_3_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_3_saved;
}
?>
						</table>
					</div>
			   </div>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			<input type="hidden" name="link_id" value="<?php echo $_REQUEST['link_id'];?>
" />
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> Submit
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock" EditorInstance="<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguageRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>ContentEditor<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
 <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
">
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
