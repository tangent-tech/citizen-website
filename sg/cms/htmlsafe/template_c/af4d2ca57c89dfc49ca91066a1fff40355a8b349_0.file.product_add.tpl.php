<?php
/* Smarty version 3.1.30, created on 2017-04-24 10:32:46
  from "/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/product_add.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58fdd44e1c52d3_20829966',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'af4d2ca57c89dfc49ca91066a1fff40355a8b349' => 
    array (
      0 => '/var/www/apps/citizen/sg/cms/htmlsafe/template/myadmin/1/product_add.tpl',
      1 => 1491504957,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_inner.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_site_content.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/_object_common_add.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/_object_permission_add.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_2ndlevel.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_inner.tpl' => 1,
  ),
),false)) {
function content_58fdd44e1c52d3_20829966 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/var/www/apps/citizen/sg/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_function_html_select_time')) require_once '/var/www/apps/citizen/sg/cms/htmlsafe/smarty-3.1.30/libs/plugins/function.html_select_time.php';
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Add <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_tree.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Tree
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_add_act.php">
		<div id="ProductTabs">
			<ul>
				<li><a href="#ProductTabsPanel-CommonData">Common Data</a></li>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?><li><a href="#ProductTabsPanel-Permission">Permission</a></li><?php }?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguageRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
				    <li><a href="#ProductTabsPanel-<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['R']->value['language_longname'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			</ul>
			<div id="ProductTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Category</th>
							<td>
								<select name="parent_object_id">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductRoots']->value, 'PC');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PC']->value) {
?>
										<option <?php if ($_smarty_tpl->tpl_vars['Product']->value['parent_object_id'] == $_smarty_tpl->tpl_vars['PC']->value['object_id']) {?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['PC']->value['object_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['PC']->value['object_name'];?>
 (id: <?php echo $_smarty_tpl->tpl_vars['PC']->value['object_id'];?>
)</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
								
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductCatList']->value, 'PC');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PC']->value) {
?>
										<option <?php if ($_smarty_tpl->tpl_vars['ObjectLink']->value['object_id'] == $_smarty_tpl->tpl_vars['PC']->value['object_id']) {?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['PC']->value['object_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['PC']->value['object_name'];?>
 (id: <?php echo $_smarty_tpl->tpl_vars['PC']->value['object_id'];?>
)</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
							</td>
						</tr>
						<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_common_add.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<tr>
							<th> Reference Name </th>
							<td> <input type="text" name="object_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Product']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th>Thumbnail</th>
							<td>
								<?php if ($_smarty_tpl->tpl_vars['Product']->value['object_thumbnail_file_id'] != 0) {?>
									<img class="MediaSmallFile" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_product_media_small_width'] < 80) {?>width="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_product_media_small_width'];?>
"<?php } else { ?>width="80"<?php }?> src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['Product']->value['object_thumbnail_file_id'];?>
" />
									<br />
								<?php }?>
								<input type="file" name="product_file" />
							</td>
						</tr>
						<?php if ($_smarty_tpl->tpl_vars['ProductCatFieldsShow']->value['product_category_no_of_group_media_fields'] == 'Y') {?>
							<?php if ($_smarty_tpl->tpl_vars['ProductCat']->value['product_category_no_of_group_media_fields'] > 0) {?>
								<?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['ProductCat']->value['product_category_no_of_group_media_fields']+1 - (1) : 1-($_smarty_tpl->tpl_vars['ProductCat']->value['product_category_no_of_group_media_fields'])+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
									<?php $_smarty_tpl->_assignInScope('product_group_media_def_field', "product_category_group_media_field_name_".((string)$_smarty_tpl->tpl_vars['i']->value));
?>
									<?php $_smarty_tpl->_assignInScope('product_group_media_file_field', "product_group_media_file_".((string)$_smarty_tpl->tpl_vars['i']->value));
?>
									<tr>
										<th><?php echo $_smarty_tpl->tpl_vars['ProductCatData']->value[$_smarty_tpl->tpl_vars['SiteLanguageRoots']->value[0]['language_id']][$_smarty_tpl->tpl_vars['product_group_media_def_field']->value];?>
</th>
										<td>
											<?php if ($_smarty_tpl->tpl_vars['Product']->value[$_smarty_tpl->tpl_vars['product_group_media_file_field']->value] != 0) {?>
												<img class="MediaSmallFile" src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['Product']->value[$_smarty_tpl->tpl_vars['product_group_media_file_field']->value];?>
" /> <br />
												<input type="checkbox" name="remove_<?php echo $_smarty_tpl->tpl_vars['product_group_media_file_field']->value;?>
" value="Y" /> Remove <br />
											<?php }?>
											<input type="file" name="<?php echo $_smarty_tpl->tpl_vars['product_group_media_file_field']->value;?>
" />
										</td>
									</tr>
								<?php }
}
?>

							<?php }?>
						<?php }?>						
						<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_product_stock_level_enable'] == 'Y') {?>
							<tr>
								<th>Stock Level </th>
								<td><input type="text" size="90" name="product_stock_level" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Product']->value['product_stock_level'], ENT_QUOTES, 'UTF-8', true);?>
" /></td>
							</tr>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_code'] != 'N') {?>
							<tr>
								<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Code </th>
								<td><input type="text" size="90" name="product_code" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Product']->value['product_code'], ENT_QUOTES, 'UTF-8', true);?>
" /></td>
							</tr>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['factory_code'] != 'N') {?>
							<tr>
								<th>Factory Code </th>
								<td><input type="text" size="90" name="factory_code" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Product']->value['factory_code'], ENT_QUOTES, 'UTF-8', true);?>
" /></td>
							</tr>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_size'] != 'N') {?>
							<tr>
								<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Size </th>
								<td><input type="text" size="10" name="product_size" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Product']->value['product_size'], ENT_QUOTES, 'UTF-8', true);?>
" /></td>
							</tr>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_weight'] != 'N') {?>
							<tr>
								<th>Weight </th>
								<td><input type="text" size="10" name="product_weight" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Product']->value['product_weight'], ENT_QUOTES, 'UTF-8', true);?>
" />(g)</td>
							</tr>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_brand_id'] != 'N') {?>
							<tr>
								<th>Brand </th>
								<td>
									<select name="product_brand_id">
										<option value="0"></option>
										<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductBrandList']->value, 'B');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['B']->value) {
?>
											<option <?php if ($_smarty_tpl->tpl_vars['Product']->value['product_brand_id'] == $_smarty_tpl->tpl_vars['B']->value['product_brand_id']) {?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['B']->value['product_brand_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['B']->value['object_name'];?>
</option>
										<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

									</select>
								</td>
							</tr>
						<?php }?>						
						<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_special_category'] != 'N') {?>
							<tr>
								<th>Special Item</th>
								<td>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductCatSpecialList']->value, 'PCS');
$_smarty_tpl->tpl_vars['PCS']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PCS']->value) {
$_smarty_tpl->tpl_vars['PCS']->index++;
$__foreach_PCS_4_saved = $_smarty_tpl->tpl_vars['PCS'];
?>
										<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_product_category_special_max_no'] == $_smarty_tpl->tpl_vars['PCS']->index) {?>
											<?php break 1;?>
										<?php }?>								
										<input type="checkbox" value="Y" name="is_special_cat_<?php echo $_smarty_tpl->tpl_vars['PCS']->value['product_category_special_no'];?>
"
											<?php if ($_smarty_tpl->tpl_vars['PCS']->value['is_product_below'] == 'Y') {?>
												checked="checked"
											<?php }?>
										/> <?php echo $_smarty_tpl->tpl_vars['PCS']->value['object_name'];?>
 &nbsp; &nbsp; &nbsp;
									<?php
$_smarty_tpl->tpl_vars['PCS'] = $__foreach_PCS_4_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</td>
							</tr>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_LWD'] != 'N') {?>
							<tr>
								<th>Dimension</th>
								<td>
									<input type="text" name="product_L" value="<?php echo $_smarty_tpl->tpl_vars['Product']->value['product_L'];?>
" size="3" />cm x <input type="text" name="product_W" value="<?php echo $_smarty_tpl->tpl_vars['Product']->value['product_W'];?>
" size="3" />cm x <input type="text" name="product_D" value="<?php echo $_smarty_tpl->tpl_vars['Product']->value['product_D'];?>
" size="3" />cm
								</td>
							</tr>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_color_id'] != 'N' && 1 > 2) {?>
							<tr>
								<th>Color </th>
								<td>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Colors']->value, 'C', false, NULL, 'ColorLoop', array (
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['C']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_ColorLoop']->value['index']++;
?>
										<span class="AdminColorBlock">
											<input type="radio" name="product_color_id" value="<?php echo $_smarty_tpl->tpl_vars['C']->value['color_id'];?>
"
												<?php if ($_smarty_tpl->tpl_vars['C']->value['color_id'] == $_smarty_tpl->tpl_vars['Product']->value['product_color_id']) {?>
													checked="checked"
												<?php }?>
											/>
											<img src="<?php echo @constant('BASEURL');?>
../images/color_icons/<?php echo $_smarty_tpl->tpl_vars['C']->value['color_image_url'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['C']->value['color_name'];?>

										</span>
										<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_ColorLoop']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_ColorLoop']->value['index'] : null)%5 == 0) {?>
											<br />
										<?php }?>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</td>
							</tr>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_color_id'] != 'N') {?>
							<tr>
								<th>Color </th>
								<td>
									<input name="product_rgb" type="color" value="#<?php echo sprintf("%02x",$_smarty_tpl->tpl_vars['Product']->value['product_rgb_r']);
echo sprintf("%02x",$_smarty_tpl->tpl_vars['Product']->value['product_rgb_g']);
echo sprintf("%02x",$_smarty_tpl->tpl_vars['Product']->value['product_rgb_b']);?>
" data-hex="true" />
								</td>
							</tr>
						<?php }?>
						<?php
$__section_foo_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 9; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
							<?php $_smarty_tpl->_assignInScope('myfield', "product_price".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
							<?php if ($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
								<tr>
									<th colspan="2"><hr /></th>
								</tr>
								<?php $_smarty_tpl->_assignInScope('ProductPriceRow', $_smarty_tpl->tpl_vars['ProductPriceList']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)]);
?>
								<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_bonus_point_enable'] == 'Y') {?>
									<tr>
										<th> Bonus Point </th>
										<td> <input type="text" name="product_bonus_point_amount[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['product_bonus_point_amount'];?>
" size="90" maxlength="255" /> </td>
									</tr>
								<?php }?>
								<tr>
									<th> <?php echo $_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
 </th>
									<td>
										$<input type="text" name="product_price[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['product_price'];?>
" />
										<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_product_price_version'] >= 2) {?>
											Bonus Point Required <input type="text" name="product_bonus_point_required[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['product_bonus_point_required'];?>
" />
										<?php }?>
									</td>
								</tr>
								<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_discount'] != 'N') {?>
									<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null) == 1 || $_smarty_tpl->tpl_vars['Site']->value['site_product_price_version'] >= 2) {?>
										<tr>
											<th>Discount</th>
											<td>
												<table>
													<tr>
														<td>
															<input type="radio" class="discount_type" name="discount_type[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="0" <?php if ($_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount_type'] == 0) {?>checked="checked"<?php }?> /> No Discount <br />
															<input type="radio" class="discount_type" name="discount_type[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="1" <?php if ($_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount_type'] == 1) {?>checked="checked"<?php }?> /> <input type="text" name="discount1_off_p[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount1_off_p'];?>
" maxlength="2" size="2" />% Off <br />
															<input type="radio" class="discount_type" name="discount_type[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="2" <?php if ($_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount_type'] == 2) {?>checked="checked"<?php }?> /> $<input type="text" name="discount2_price[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount2_price'];?>
"  maxlength="5" size="5" /> for <input type="text" name="discount2_amount[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount2_amount'];?>
" maxlength="2" size="2" /> <br />
															<input type="radio" class="discount_type" name="discount_type[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="3" <?php if ($_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount_type'] == 3) {?>checked="checked"<?php }?> /> Buy <input type="text" name="discount3_buy_amount[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount3_buy_amount'];?>
" maxlength="2" size="2" /> Get <input type="text" name="discount3_free_amount[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount3_free_amount'];?>
" maxlength="2" size="2" /> Free <br />
														</td>
														<td>
															<input type="radio" class="discount_type" name="discount_type[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
]" value="4" <?php if ($_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount_type'] == 4) {?>checked="checked"<?php }?> /> Price Level
															<div class="ProductPriceLevelContainer">
																<table class="TopHeaderTable AlignLeft">
																	<tr class="ui-state-highlight">
																		<th class="AlignLeft"><a class="AddMoreProductPriceLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-plus"></span></a></th>
																		<th class="AlignLeft">Min Quantity</th>
																		<th class="AlignLeft">Price</th>
																	</tr>
																	<tr>
																		<td class="AlignLeft"></td>
																		<td>0<input type="hidden" name="product_price_level_min<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
[]" value="0" /></td>
																		<td><input type="text" name="product_price_level_price<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
[]" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['ProductPriceLevel'][0]['product_price_level_price'];?>
" /></td>
																	</tr>
																	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductPriceRow']->value['ProductPriceLevel'], 'L');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['L']->value) {
?>
																		<?php if ($_smarty_tpl->tpl_vars['L']->value['product_price_level_min'] != 0) {?>
																			<tr>
																				<td class="AlignLeft"><a class="RemoveProductPriceLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
																				<td><input type="text" name="product_price_level_min<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
[]" value="<?php echo $_smarty_tpl->tpl_vars['L']->value['product_price_level_min'];?>
" /></td>
																				<td><input type="text" name="product_price_level_price<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
[]" value="<?php echo $_smarty_tpl->tpl_vars['L']->value['product_price_level_price'];?>
" /></td>
																			</tr>
																		<?php }?>
																	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

																	<tr class="ProductPriceLevelInput Hidden">
																		<td class="AlignLeft"><a class="RemoveProductPriceLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
																		<td><input type="text" name="product_price_level_min<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
[]" /></td>
																		<td><input type="text" name="product_price_level_price<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null);?>
[]" /></td>
																	</tr>
																</table>
															</div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									<?php }?>
								<?php }?>
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
							<?php $_smarty_tpl->_assignInScope('myfield', "product_custom_int_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
							<?php if ($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
								<tr>
									<th><?php echo $_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
</th>
									<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Product']->value[$_smarty_tpl->tpl_vars['myfield']->value], ENT_QUOTES, 'UTF-8', true);?>
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
							<?php $_smarty_tpl->_assignInScope('myfield', "product_custom_double_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
							<?php if ($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
								<tr>
									<th><?php echo $_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
</th>
									<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Product']->value[$_smarty_tpl->tpl_vars['myfield']->value], ENT_QUOTES, 'UTF-8', true);?>
" size="80" /></td>
								</tr>							
							<?php }?>
						<?php
}
}
if ($__section_foo_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_2_saved;
}
?>
						<?php
$__section_foo_3_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
							<?php $_smarty_tpl->_assignInScope('myfield', "product_custom_date_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
							<?php if ($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
								<tr>
									<th><?php echo $_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
</th>
									<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
" class="DatePicker" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['Product']->value[$_smarty_tpl->tpl_vars['myfield']->value],'%Y-%m-%d');?>
" size="10" /> <?php echo smarty_function_html_select_time(array('prefix'=>$_smarty_tpl->tpl_vars['myfield']->value,'use_24_hours'=>true,'display_seconds'=>false,'time'=>$_smarty_tpl->tpl_vars['Product']->value[$_smarty_tpl->tpl_vars['myfield']->value]),$_smarty_tpl);?>
</td>
								</tr>							
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
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?>
				<div id="ProductTabsPanel-Permission">
					<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_permission_add.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

				</div>
			<?php }?>			
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguageRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
				<div id="ProductTabsPanel-<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<?php if ($_smarty_tpl->tpl_vars['ObjectFieldsShow']->value['object_seo_tab'] == 'Y') {?>
								<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_friendly_link_enable'] == 'Y') {?>
									<tr>
										<th> Friendly URL </th>
										<td> <input type="text" name="object_friendly_url[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['object_friendly_url'], ENT_QUOTES, 'UTF-8', true);?>
" maxlength="255" /> </td>
									</tr>
								<?php }?>
								<tr>
									<th> Meta Title </th>
									<td> <input type="text" name="object_meta_title[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['object_meta_title'], ENT_QUOTES, 'UTF-8', true);?>
" size="50" maxlength="255" /> </td>
								</tr>
								<tr>
									<th> Meta Description </th>
									<td> <textarea name="object_meta_description[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" cols="48" rows="4"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['object_meta_description'], ENT_QUOTES, 'UTF-8', true);?>
</textarea> </td>
								</tr>
								<tr>
									<th> Meta Keywords </th>
									<td> <textarea name="object_meta_keywords[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" cols="48" rows="4"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['object_meta_keywords'], ENT_QUOTES, 'UTF-8', true);?>
</textarea> </td>
								</tr>								
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['ProductCatFieldsShow']->value['product_category_no_of_group_text_fields'] == 'Y') {?>
								<?php if ($_smarty_tpl->tpl_vars['ProductCat']->value['product_category_no_of_group_text_fields'] > 0) {?>
									<?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['ProductCat']->value['product_category_no_of_group_text_fields']+1 - (1) : 1-($_smarty_tpl->tpl_vars['ProductCat']->value['product_category_no_of_group_text_fields'])+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
										<?php $_smarty_tpl->_assignInScope('productgrouptextfield', "product_category_group_text_field_name_".((string)$_smarty_tpl->tpl_vars['i']->value));
?>
										<?php $_smarty_tpl->_assignInScope('producttextfield', "product_group_text_field_".((string)$_smarty_tpl->tpl_vars['i']->value));
?>
										<tr>
											<th><?php echo $_smarty_tpl->tpl_vars['ProductCatData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][$_smarty_tpl->tpl_vars['productgrouptextfield']->value];?>
</th>
											<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['producttextfield']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['ProductData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][$_smarty_tpl->tpl_vars['producttextfield']->value];?>
" size="90" maxlength="255" />
											</td>
										</tr>
									<?php }
}
?>

								<?php }?>
							<?php }?>							
							<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_name'] != 'N') {?>
								<tr>
									<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Name</th>
									<td>
										<textarea name="product_name[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" cols="80" rows="3"><?php echo $_smarty_tpl->tpl_vars['ProductData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['product_name'];?>
</textarea>
									</td>
								</tr>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_color'] != 'N') {?>
								<tr>
									<th>Color</th>
									<td>
										<input type="text" class="ProductColor" name="product_color[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['ProductData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['product_color'];?>
" size="90" maxlength="255" />
									</td>
								</tr>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_packaging'] != 'N') {?>
								<tr>
									<th>Packaging</th>
									<td>
										<input type="text" name="product_packaging[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['ProductData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['product_packaging'];?>
" size="90" maxlength="255" />
									</td>
								</tr>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_desc'] != 'N') {?>
								<tr>
									<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Description</th>
									<td>
										<?php echo $_smarty_tpl->tpl_vars['EditorHTML']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']];?>

									</td>
								</tr>
							<?php }?>
							<?php
$__section_foo_4_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 20; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
								<?php $_smarty_tpl->_assignInScope('myfield', "product_custom_text_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
								<?php if ($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
									<?php if (substr($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],0,5) == 'STXT_') {?>
										<tr>
											<th><?php echo substr($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],5);?>
</th>
											<td><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][$_smarty_tpl->tpl_vars['myfield']->value], ENT_QUOTES, 'UTF-8', true);?>
" size="80" /></td>
										</tr>
									<?php } elseif (substr($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],0,5) == 'MTXT_') {?>
										<tr>
											<th><?php echo substr($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],5);?>
</th>
											<td><textarea name="<?php echo $_smarty_tpl->tpl_vars['myfield']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" cols="80" rows="8"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ProductData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][$_smarty_tpl->tpl_vars['myfield']->value], ENT_QUOTES, 'UTF-8', true);?>
</textarea></td>
										</tr>
									<?php } elseif (substr($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],0,5) == 'HTML_') {?>
										<tr>
											<th><?php echo substr($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value],5);?>
</th>
											<td><?php echo $_smarty_tpl->tpl_vars['CustomFieldsEditorHTML']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']][(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)];?>
</td>
										</tr>
									<?php } else { ?>
										<tr>
											<th><?php echo $_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
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
							<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_tag'] != 'N') {?>
								<tr>
									<th>Tag</th>
									<td>
										<p>Please seperate the tag by comma(,)</p>
										<input type="text" name="product_tag[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" value="<?php echo substr($_smarty_tpl->tpl_vars['ProductData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['product_tag'],2,-htmlspecialchars(2, ENT_QUOTES, 'UTF-8', true));?>
" size="90" maxlength="255" />
									</td>
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
