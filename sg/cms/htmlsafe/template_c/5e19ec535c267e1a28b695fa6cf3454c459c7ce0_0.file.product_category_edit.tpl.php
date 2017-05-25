<?php
/* Smarty version 3.1.30, created on 2017-03-25 04:26:05
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/product_category_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d5e34d68b1b2_69021324',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5e19ec535c267e1a28b695fa6cf3454c459c7ce0' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/product_category_edit.tpl',
      1 => 1480412489,
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
function content_58d5e34d68b1b2_69021324 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_function_html_select_time')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/function.html_select_time.php';
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Edit <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Category (id: <?php echo $_smarty_tpl->tpl_vars['ProductCat']->value['object_id'];?>
)&nbsp;
<?php if ($_smarty_tpl->tpl_vars['IsProductCatRemovable']->value) {?>
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="product_category_delete.php?link_id=<?php echo $_REQUEST['link_id'];?>
">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
<?php } else { ?>
	<a onclick="return DoubleConfirm('WARNING!\n All corresponding product categories, products and other related objects will also be deleted!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton" href="product_category_delete_recursive.php?link_id=<?php echo $_REQUEST['link_id'];?>
">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
<?php }?>
	<a class="ui-state-default ui-corner-all MyButton" href="product_tree.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Tree
	</a>

	<a id="BtnToggleThumbnails" class="ui-state-default ui-corner-all MyButton" href="#">
		<span class="ui-icon ui-icon-image"></span> Show/Hide Thumbnails
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_category_edit_act.php">
		<div id="ProductCatTabs">
			<ul>
				<li><a href="#ProductCatTabsPanel-CommonData">Common Data</a></li>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?><li><a href="#ProductCatTabsPanel-Permission">Permission</a></li><?php }?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguageRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
				    <li><a href="#ProductCatTabsPanel-<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['R']->value['language_longname'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			</ul>
			<div id="ProductCatTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? 9+1 - (1) : 1-(9)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
							<?php if ($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value["product_price".((string)$_smarty_tpl->tpl_vars['i']->value)] != '') {?>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductCatPriceRangeList']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
									<tr>
										<th> <?php echo $_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value["product_price".((string)$_smarty_tpl->tpl_vars['i']->value)];?>
 Range </th>
										<td><?php echo $_smarty_tpl->tpl_vars['R']->value['currency_shortname'];?>
 <?php echo number_format($_smarty_tpl->tpl_vars['R']->value["product_category_price".((string)$_smarty_tpl->tpl_vars['i']->value)."_range_min"],$_smarty_tpl->tpl_vars['R']->value['currency_precision']);?>
 - <?php echo $_smarty_tpl->tpl_vars['R']->value['currency_shortname'];?>
 <?php echo number_format($_smarty_tpl->tpl_vars['R']->value["product_category_price".((string)$_smarty_tpl->tpl_vars['i']->value)."_range_max"],$_smarty_tpl->tpl_vars['R']->value['currency_precision']);?>
</td>
									</tr>							
								<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
						
							<?php }?>
						<?php }
}
?>

						<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_common_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<tr>
							<th> Reference Name </th>
							<td> <input type="text" name="object_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductCat']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th>Thumbnail</th>
							<td>
								<?php if ($_smarty_tpl->tpl_vars['ProductCat']->value['object_thumbnail_file_id'] != 0) {?>
									<img class="MediaSmallFile" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_product_media_small_width'] < 80) {?>width="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_product_media_small_width'];?>
"<?php } else { ?>width="80"<?php }?> src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['ProductCat']->value['object_thumbnail_file_id'];?>
" />
									<br />
								<?php }?>
								<input type="file" name="thumbnail_file" />
							</td>
						</tr>
						<?php
$__section_foo_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
							<?php $_smarty_tpl->_assignInScope('myfield', "product_category_custom_int_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
							<?php if ($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
								<tr>
									<th><?php echo $_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
</th>
									<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductCat']->value[$_smarty_tpl->tpl_vars['myfield']->value], ENT_QUOTES, 'UTF-8', true);?>
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
							<?php $_smarty_tpl->_assignInScope('myfield', "product_category_custom_double_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
							<?php if ($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
								<tr>
									<th><?php echo $_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
</th>
									<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductCat']->value[$_smarty_tpl->tpl_vars['myfield']->value], ENT_QUOTES, 'UTF-8', true);?>
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
							<?php $_smarty_tpl->_assignInScope('myfield', "product_category_custom_date_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
							<?php if ($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
								<tr>
									<th><?php echo $_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
</th>
									<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
" class="DatePicker" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['ProductCat']->value[$_smarty_tpl->tpl_vars['myfield']->value],'%Y-%m-%d');?>
" size="10" /> <?php echo smarty_function_html_select_time(array('prefix'=>$_smarty_tpl->tpl_vars['myfield']->value,'use_24_hours'=>true,'display_seconds'=>false,'time'=>$_smarty_tpl->tpl_vars['ProductCat']->value[$_smarty_tpl->tpl_vars['myfield']->value]),$_smarty_tpl);?>
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
						<?php if ($_smarty_tpl->tpl_vars['ProductCatFieldsShow']->value['product_category_group_fields'] == 'Y' && $_smarty_tpl->tpl_vars['NoOfSubCat']->value == 0) {?>
							<?php
$__section_foo_3_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 9; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
								<?php $_smarty_tpl->_assignInScope('myfield', "product_category_group_field_name_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
								<tr>
									<th>Grouping Field <?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
</th>
									<td>
										<select name="product_category_group_field_name[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]">
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductCategoryGroupValidFields']->value, 'value', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
												<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['ProductCat']->value[$_smarty_tpl->tpl_vars['myfield']->value] == $_smarty_tpl->tpl_vars['key']->value) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</option>
											<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

										</select>
									</td>
								</tr>							
							<?php
}
}
if ($__section_foo_3_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_3_saved;
}
?>							
						<?php }?>
					</table>
				</div>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?>
				<div id="ProductCatTabsPanel-Permission">
					<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_permission_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

				</div>
			<?php }?>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguageRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
				<div id="ProductCatTabsPanel-<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_seo_tab'] == 'Y') {?>
								<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_friendly_link_enable'] == 'Y') {?>
									<tr>
										<th> Friendly URL </th>
										<td> <input type="text" name="object_friendly_url[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductCatData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['object_friendly_url'], ENT_QUOTES, 'UTF-8', true);?>
" maxlength="255" /> </td>
									</tr>
								<?php }?>
								<tr>
									<th> Meta Title </th>
									<td> <input type="text" name="object_meta_title[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductCatData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['object_meta_title'], ENT_QUOTES, 'UTF-8', true);?>
" size="50" maxlength="255" /> </td>
								</tr>
								<tr>
									<th> Meta Description </th>
									<td> <textarea name="object_meta_description[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" cols="48" rows="4"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductCatData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['object_meta_description'], ENT_QUOTES, 'UTF-8', true);?>
</textarea> </td>
								</tr>
								<tr>
									<th> Meta Keywords </th>
									<td> <textarea name="object_meta_keywords[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" cols="48" rows="4"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductCatData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['object_meta_keywords'], ENT_QUOTES, 'UTF-8', true);?>
</textarea> </td>
								</tr>								
							<?php }?>
							<tr>
								<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Category Name</th>
								<td> <input type="text" name="product_category_name[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['ProductCatData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['product_category_name'];?>
" size="90" maxlength="255" /> </td>
							</tr>
							<?php
$__section_foo_4_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
								<?php $_smarty_tpl->_assignInScope('myfield', "product_category_custom_text_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
								<?php if ($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
									<?php if (substr($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],0,5) == 'STXT_') {?>
										<tr>
											<th><?php echo substr($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],5);?>
</th>
											<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductCatData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][$_smarty_tpl->tpl_vars['myfield']->value], ENT_QUOTES, 'UTF-8', true);?>
" size="80" /></td>
										</tr>
									<?php } elseif (substr($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],0,5) == 'MTXT_') {?>
										<tr>
											<th><?php echo substr($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],5);?>
</th>
											<td><textarea name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" cols="80" rows="8"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductCatData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][$_smarty_tpl->tpl_vars['myfield']->value], ENT_QUOTES, 'UTF-8', true);?>
</textarea></td>
										</tr>
									<?php } elseif (substr($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],0,5) == 'HTML_') {?>
										<tr>
											<th><?php echo substr($_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],5);?>
</th>
											<td><?php echo $_smarty_tpl->tpl_vars['CustomFieldsEditorHTML']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)];?>
</td>
										</tr>
									<?php } else { ?>
										<tr>
											<th><?php echo $_smarty_tpl->tpl_vars['ProductCategoryCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
</th>
											<td><?php echo $_smarty_tpl->tpl_vars['CustomFieldsEditorHTML']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)];?>
</td>
										</tr>
									<?php }?>
								<?php }?>
							<?php
}
}
if ($__section_foo_4_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_4_saved;
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

<?php if ($_smarty_tpl->tpl_vars['ProductCatFieldsShow']->value['product_category_media_list'] == 'Y') {?>
	<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
		<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">Product Category Media</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table id="MediaListTable-<?php echo $_smarty_tpl->tpl_vars['ProductCat']->value['product_category_id'];?>
" class="TopHeaderTable ui-helper-reset AlignCenter SortTable MediaListTable">
				<tr class="ui-state-highlight nodrop nodrag">
					<th width="50">ID</th>
					<th width="250">Media</th>
					<th>Action</th>
				</tr>
				<?php if (count($_smarty_tpl->tpl_vars['ProductCatMediaList']->value) == 0) {?>
					<tr class="nodrop nodrag">
						<td colspan="3">You may upload photos and video here.</td>
					</tr>
				<?php }?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductCatMediaList']->value, 'M');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['M']->value) {
?>
					<tr id="Media-<?php echo $_smarty_tpl->tpl_vars['M']->value['media_id'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['M']->value['object_is_enable'] == 'N') {?>DisabledRow<?php }?>">
						<td class="AlignCenter"><?php echo $_smarty_tpl->tpl_vars['M']->value['media_id'];?>
</td>
						<td>
							<?php if ($_smarty_tpl->tpl_vars['M']->value['media_small_file_id'] != 0) {?>
								<a href="<?php echo @constant('BASEURL');?>
getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['M']->value['media_big_file_id'];?>
" target="_preview"><img class="MediaSmallFile" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_media_small_width'] < 80) {?>width="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_media_small_width'];?>
"<?php } else { ?>width="80"<?php }?> src="<?php echo @constant('BASEURL');?>
getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['M']->value['media_small_file_id'];?>
" /><br class="MediaSmallFile" /><?php echo $_smarty_tpl->tpl_vars['M']->value['filename'];?>
</a>
							<?php } else { ?>
								<a href="<?php echo @constant('BASEURL');?>
getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['M']->value['media_big_file_id'];?>
" target="_preview"><?php echo $_smarty_tpl->tpl_vars['M']->value['filename'];?>
</a>
							<?php }?>
						</td>
						<td class="AlignCenter">
							<a href="product_cat_media_set_highlight.php?link_id=<?php echo $_REQUEST['link_id'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['M']->value['media_id'];?>
" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-image"></span> thumbnail
							</a>
							<a href="media_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['M']->value['media_id'];?>
&link_id=<?php echo $_REQUEST['link_id'];?>
&refer=product_category_edit" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> edit
							</a>
							<a href="media_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['M']->value['media_id'];?>
&link_id=<?php echo $_REQUEST['link_id'];?>
&refer=product_category_edit" onclick="return confirm('WARNING!\n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton">
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
			<br />
			<form enctype="multipart/form-data" name="FrmAddPhoto" id="FrmAddPhoto" method="post" action="media_add_act.php">
				<input type="file" name="media[]" multiple="true" />
				<input type="file" name="media[]" multiple="true" />
				<input type="file" name="media[]" multiple="true" /> <br />
				<br />
				Media Security Level: <input type="text" name="media_security_level" value="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_default_security_level'];?>
" />
				<br />
				<input type="hidden" name="link_id" value="<?php echo $_REQUEST['link_id'];?>
" />
				<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['ProductCat']->value['product_category_id'];?>
" />
				<input type="hidden" name="refer" value="product_category_edit" />
				<br />
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_product_media_watermark_big_file_id'] != 0 || $_smarty_tpl->tpl_vars['Site']->value['site_product_media_watermark_small_file_id'] != 0) {?>
					<input type="checkbox" name="AddWatermark" checked="checked" value="Y" /> Add watermark
					<br />
				<?php }?>
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmAddPhoto">
					<span class="ui-icon ui-icon-circle-plus"></span> Add Media
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmAddPhoto">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</form>		
		</div>
	</div>
<?php }?>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">Product and Product Category List</h2>
	<div class="InnerContent ui-widget-content ui-corner-bottom">
		<table id="ObjectListTable" class="TopHeaderTable ui-helper-reset SortTable">
			<tr class="ui-state-highlight nodrop nodrag">
				<th></th>
				<th width="50">ID</th>
				<th width="150">Type</th>
				<th width="200">Reference Name</th>
				<th width="100">Action</th>
			</tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ChildObjects']->value, 'O');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['O']->value) {
?>
				<tr id="Object-<?php echo $_smarty_tpl->tpl_vars['O']->value['object_link_id'];?>
" class="AlignCenter <?php if ($_smarty_tpl->tpl_vars['O']->value['object_is_enable'] == 'N') {?>DisabledRow<?php }?>">
					<td>
						<?php if ($_smarty_tpl->tpl_vars['O']->value['object_thumbnail_file_id'] != 0) {?>
							<img class="MediaSmallFile" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_media_small_width'] < 80) {?>width="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_media_small_width'];?>
"<?php } else { ?>width="80"<?php }?> src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['O']->value['object_thumbnail_file_id'];?>
" /><br class="MediaSmallFile" />
						<?php }?>
					</td>
					<td><?php echo $_smarty_tpl->tpl_vars['O']->value['object_id'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['O']->value['object_type'] == 'PRODUCT') {?>Product<?php } elseif ($_smarty_tpl->tpl_vars['O']->value['object_type'] == 'PRODUCT_CATEGORY') {?>Category<?php }?></td>
					<td>
					
						<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['O']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>

					</td>
					<td>
						<?php if ($_smarty_tpl->tpl_vars['O']->value['object_type'] == 'PRODUCT') {?>
							<a href="product_edit.php?link_id=<?php echo $_smarty_tpl->tpl_vars['O']->value['object_link_id'];?>
" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> edit
							</a>
						<?php } elseif ($_smarty_tpl->tpl_vars['O']->value['object_type'] == 'PRODUCT_CATEGORY') {?>
							<a href="product_category_edit.php?link_id=<?php echo $_smarty_tpl->tpl_vars['O']->value['object_link_id'];?>
" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> edit
							</a>
						<?php }?>
					</td>
				</tr>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</table>
		<a href="product_add.php?link_id=<?php echo $_REQUEST['link_id'];?>
" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add Product</a>
	</div>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
