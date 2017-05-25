<?php
/* Smarty version 3.1.30, created on 2017-03-27 11:21:52
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/product_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d8d9b00f2ef2_79597237',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c84cd0833bfc71635a3c7177055f9c6cb1323f52' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/product_edit.tpl',
      1 => 1490606460,
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
function content_58d8d9b00f2ef2_79597237 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_function_html_select_time')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/function.html_select_time.php';
if (!is_callable('smarty_function_math')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/function.math.php';
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Edit <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 (id: <?php echo $_smarty_tpl->tpl_vars['Product']->value['product_id'];?>
)&nbsp;
<?php if ($_smarty_tpl->tpl_vars['IsProductRemovable']->value == true) {?>
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="product_delete.php?link_id=<?php echo $_REQUEST['link_id'];?>
">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
<?php } else { ?>
	<a href="#" class="ui-state-disabled ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
<?php }?>
	<a class="ui-state-default ui-corner-all MyButton" href="product_tree.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Tree
	</a>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductParentCatAndRootList']->value, 'C');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['C']->value) {
?>
		<?php if ($_smarty_tpl->tpl_vars['C']->value['object_type'] == 'PRODUCT_CATEGORY') {?>
			<a class="ui-state-default ui-corner-all MyButton" href="product_category_edit.php?link_id=<?php echo $_smarty_tpl->tpl_vars['C']->value['object_link_id'];?>
">
				<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> <?php echo $_smarty_tpl->tpl_vars['C']->value['object_name'];?>

			</a>
		<?php }?>		
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_edit_act.php">
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

				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_order_enable'] == 'Y') {?>
				    <li><a href="#ProductTabsPanel-OrderList">Order List</a></li>
				<?php }?>
			</ul>
			<div id="ProductTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_common_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

						<tr class="ProductCatRow">
							<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Categories</th>
							<td>
								<div id="ProductCatInputContainer">
									<table class="TopHeaderTable AlignLeft">
										<tr>
											<th class="AlignLeft"><a id="AddMoreProductCatLink" class="ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-plus"></span></a></th>
											<td></td>
										</tr>
										<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductParentCatAndRootList']->value, 'L');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['L']->value) {
?>
											<tr class="ProductCatInput">
												<td class="AlignLeft"><a class="RemoveProductCatLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
												<td class="AlignLeft">
													<select name="product_category_id[]">
														<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductRoots']->value, 'PC');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PC']->value) {
?>
															<option <?php if ($_smarty_tpl->tpl_vars['L']->value['object_id'] == $_smarty_tpl->tpl_vars['PC']->value['object_id']) {?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['PC']->value['object_id'];?>
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
															<option <?php if ($_smarty_tpl->tpl_vars['L']->value['object_id'] == $_smarty_tpl->tpl_vars['PC']->value['object_id']) {?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['PC']->value['object_id'];?>
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
										<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

										<tr class="ProductCatInput Hidden">
											<td class="AlignLeft"><a class="RemoveProductCatLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
											<td class="AlignLeft">
												<select name="product_category_id[-1]">
													<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductRoots']->value, 'PC');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PC']->value) {
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['PC']->value['object_id'];?>
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
														<option value="<?php echo $_smarty_tpl->tpl_vars['PC']->value['object_id'];?>
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
									</table>
								</div>								
							</td>
						</tr>
						<tr class="ProductGroupRow Hidden">
							<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Group</th>
							<td>
								<select name="product_category_group_id">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductGroupList']->value, 'PC');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PC']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['PC']->value['object_id'];?>
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
" /> <br />
									<input type="checkbox" name="remove_thumbnail" value="Y" /> Remove thumbnail <br />
								<?php }?>
								<input type="file" name="product_file" />
							</td>
						</tr>
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
								<th>Special Item </th>
								<td>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductCatSpecialList']->value, 'PCS');
$_smarty_tpl->tpl_vars['PCS']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PCS']->value) {
$_smarty_tpl->tpl_vars['PCS']->index++;
$__foreach_PCS_9_saved = $_smarty_tpl->tpl_vars['PCS'];
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
$_smarty_tpl->tpl_vars['PCS'] = $__foreach_PCS_9_saved;
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
$__section_foo_0_loop = (is_array(@$_loop=@constant('NO_OF_CUSTOM_RGB_FIELDS')) ? count($_loop) : max(0, (int) $_loop));
$__section_foo_0_start = min(0, $__section_foo_0_loop);
$__section_foo_0_total = min(($__section_foo_0_loop - $__section_foo_0_start), $__section_foo_0_loop);
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if ($__section_foo_0_total != 0) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = $__section_foo_0_start; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= $__section_foo_0_total; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
							<?php $_smarty_tpl->_assignInScope('myfield', "product_custom_rgb_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
							<?php $_smarty_tpl->_assignInScope('myobjfield', "object_custom_rgb_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
							<?php if ($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
								<tr>
									<th><?php echo $_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
</th>
									<td><input name="<?php echo $_smarty_tpl->tpl_vars['myobjfield']->value;?>
" type="color" value="#<?php echo $_smarty_tpl->tpl_vars['ObjectLink']->value[$_smarty_tpl->tpl_vars['myobjfield']->value];?>
" data-hex="true" /></td>
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
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductPriceList']->value, 'PL', false, 'PPLIndex');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PPLIndex']->value => $_smarty_tpl->tpl_vars['PL']->value) {
?>
							<?php
$__section_foo_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= 9; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
								<?php $_smarty_tpl->_assignInScope('PriceID', (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null));
?>
								<?php $_smarty_tpl->_assignInScope('myfield', "product_price".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)));
?>
								<?php if ($_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value] != '') {?>
									<tr class="ProductPriceTr<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
">
										<th colspan="2"><hr /></th>
									</tr>
									<?php if ($_smarty_tpl->tpl_vars['PPLIndex']->value != 0) {?>
										<tr>
											<th colspan="2" class="AlignLeft"><?php echo $_smarty_tpl->tpl_vars['PL']->value['currency_name'];?>
 Price <?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
</th>
										</tr>
									<?php }?>
									<?php $_smarty_tpl->_assignInScope('ProductPriceRow', $_smarty_tpl->tpl_vars['PL']->value['product_price_list'][$_smarty_tpl->tpl_vars['PriceID']->value]);
?>
									
									<tr class="ProductPriceTr<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
">
										<th>Enable </th>
										<td>
											<input type="radio" name="product_price_enable_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="Y" <?php if ($_smarty_tpl->tpl_vars['ProductPriceRow']->value != null) {?>checked="checked"<?php }?>/> Enable
											<input type="radio" name="product_price_enable_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="N" <?php if ($_smarty_tpl->tpl_vars['ProductPriceRow']->value == null) {?>checked="checked"<?php }?>/> Disable
										</td>
									</tr>									
									<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_bonus_point_enable'] == 'Y') {?>
										<tr>
											<th> Bonus Point </th>
											<td> <input type="text" name="product_bonus_point_amount_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['product_bonus_point_amount'];?>
" size="90" maxlength="255" /> </td>
										</tr>
									<?php }?>
									<tr class="ProductPriceTr<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
">
										<th> <?php echo $_smarty_tpl->tpl_vars['ProductCustomFieldsDef']->value[$_smarty_tpl->tpl_vars['myfield']->value];?>
 </th>
										<td>
											$<input type="text" name="product_price_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['product_price'];?>
" />
											<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_product_price_version'] >= 2) {?>
												Bonus Point Required <input type="text" name="product_bonus_point_required_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['product_bonus_point_required'];?>
" />
											<?php }?>
										</td>
									</tr>
									<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_discount'] != 'N') {?>
										<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null) == 1 || $_smarty_tpl->tpl_vars['Site']->value['site_product_price_version'] >= 2) {?>
											<tr class="ProductPriceTr<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
">
												<th>Discount</th>
												<td>
													<table>
														<tr>
															<td>
																<input type="radio" class="discount_type" name="discount_type_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="0" <?php if ($_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount_type'] == 0) {?>checked="checked"<?php }?> /> No Discount <br />
																<input type="radio" class="discount_type" name="discount_type_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="1" <?php if ($_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount_type'] == 1) {?>checked="checked"<?php }?> /> <input type="text" name="discount1_off_p_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount1_off_p'];?>
" maxlength="2" size="2" />% Off <br />
																<input type="radio" class="discount_type" name="discount_type_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="2" <?php if ($_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount_type'] == 2) {?>checked="checked"<?php }?> /> $<input type="text" name="discount2_price_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount2_price'];?>
"  maxlength="5" size="5" /> for <input type="text" name="discount2_amount_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount2_amount'];?>
" maxlength="2" size="2" /> <br />
																<input type="radio" class="discount_type" name="discount_type_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="3" <?php if ($_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount_type'] == 3) {?>checked="checked"<?php }?> /> Buy <input type="text" name="discount3_buy_amount_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount3_buy_amount'];?>
" maxlength="2" size="2" /> Get <input type="text" name="discount3_free_amount_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount3_free_amount'];?>
" maxlength="2" size="2" /> Free <br />
															</td>
															<td>
																<input type="radio" class="discount_type" name="discount_type_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
" value="4" <?php if ($_smarty_tpl->tpl_vars['ProductPriceRow']->value['discount_type'] == 4) {?>checked="checked"<?php }?> /> Price Level
																<div class="ProductPriceLevelContainer">
																	<table class="TopHeaderTable AlignLeft">
																		<tr class="ui-state-highlight">
																			<th class="AlignLeft"><a class="AddMoreProductPriceLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-plus"></span></a></th>
																			<th class="AlignLeft">Min Quantity</th>
																			<th class="AlignLeft">Price</th>
																		</tr>
																		<tr>
																			<td class="AlignLeft"></td>
																			<td>0<input type="hidden" name="product_price_level_min_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
[]" value="0" /></td>
																			<td><input type="text" name="product_price_level_price_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
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
																					<td><input type="text" name="product_price_level_min_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
[]" value="<?php echo $_smarty_tpl->tpl_vars['L']->value['product_price_level_min'];?>
" /></td>
																					<td><input type="text" name="product_price_level_price_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
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
																			<td><input type="text" name="product_price_level_min_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
[]" /></td>
																			<td><input type="text" name="product_price_level_price_<?php echo $_smarty_tpl->tpl_vars['PPLIndex']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['PriceID']->value;?>
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
if ($__section_foo_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_1_saved;
}
?>
							
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

						<tr>
							<th colspan="2"><hr /></th>
						</tr>							
						
						<?php
$__section_foo_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
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
if ($__section_foo_3_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_3_saved;
}
?>
						<?php
$__section_foo_4_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
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
if ($__section_foo_4_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_4_saved;
}
?>
					</table>
				</div>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y' && $_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?>
				<div id="ProductTabsPanel-Permission">
					<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_permission_edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
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
							<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_name'] != 'N') {?>
								<tr>
									<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Name</th>
									<td>
										<textarea name="product_name[<?php echo $_smarty_tpl->tpl_vars['R']->value['language_id'];?>
]" cols="87" rows="4"><?php echo $_smarty_tpl->tpl_vars['ProductData']->value[$_smarty_tpl->tpl_vars['R']->value['language_id']]['product_name'];?>
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
$__section_foo_5_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
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
if ($__section_foo_5_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_5_saved;
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

			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_order_enable'] == 'Y') {?>
				<div id="ProductTabsPanel-OrderList">
					<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_group_buy_enable'] == 'Y') {?>
						<a href="product_group_buy_report.php?link_id=<?php echo $_REQUEST['link_id'];?>
" class="ui-state-default ui-corner-all MyButton" target="GroupBuyReport">
							<span class="ui-icon ui-icon-clipboard"></span> Group Buy Report
						</a>
					<?php }?>
					<table id="OrderListTable" class="TopHeaderTable">
						<tr class="ui-state-highlight">
							<th width="50">Ref ID</th>
							<th width="50">Order No</th>
							<th width="120">User</th>
							<th width="120">Status</th>
				
							<th width="120">Amount</th>
							<th width="120">Note</th>
							<th width="220">Action</th>
						</tr>
						<?php if (count($_smarty_tpl->tpl_vars['OrderList']->value) == 0) {?>
							<tr>
								<td colspan="7">No order has been made with this product.</td>
							</tr>
						<?php }?>

						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['OrderList']->value, 'O');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['O']->value) {
?>
							<tr class="AlignCenter">
								<td><?php echo $_smarty_tpl->tpl_vars['O']->value['myorder_id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['O']->value['order_no'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['O']->value['user_username'];?>
</td>
								<td>
									<?php if ($_smarty_tpl->tpl_vars['O']->value['order_status'] == 'awaiting_freight_quote') {?>
										Awaiting Freight Quote
									<?php } elseif ($_smarty_tpl->tpl_vars['O']->value['order_status'] == 'awaiting_order_confirmation') {?>
										Awaiting Order Confirmation
									<?php } elseif ($_smarty_tpl->tpl_vars['O']->value['order_status'] == 'order_cancelled') {?>
										Order Cancelled
									<?php } elseif ($_smarty_tpl->tpl_vars['O']->value['order_status'] == 'payment_pending') {?>
										Payment Pending
									<?php } elseif ($_smarty_tpl->tpl_vars['O']->value['order_status'] == 'payment_confirmed') {?>
										Payment Confirmed
									<?php } elseif ($_smarty_tpl->tpl_vars['O']->value['order_status'] == 'partial_shipped') {?>
										Partial Shipped
									<?php } elseif ($_smarty_tpl->tpl_vars['O']->value['order_status'] == 'shipped') {?>
										Shipped
									<?php }?>
								</td>
				
								<td><?php echo $_smarty_tpl->tpl_vars['O']->value['currency_shortname'];?>
 <?php echo $_smarty_tpl->tpl_vars['O']->value['pay_amount_ca'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['O']->value['user_reference'];?>
 </td>
								<td>
									<a href="order_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['O']->value['myorder_id'];?>
" onclick="return DoubleConfirm('WARNING!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
										<span class="ui-icon ui-icon-trash"></span> delete
									</a>
									<a href="order_details.php?id=<?php echo $_smarty_tpl->tpl_vars['O']->value['myorder_id'];?>
" class="ui-state-default ui-corner-all MyButton">
										<span class="ui-icon ui-icon-calculator"></span> details
									</a>
								</td>
							</tr>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					</table>
				</div>
			<?php }?>
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
echo $_smarty_tpl->tpl_vars['CustomFieldsEditorInstance']->value;?>
">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</div>
		</div>
	</form>
</div>

<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_option'] != 'N') {?>
	<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
		<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader"><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Option</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table id="ProductOptionTable-<?php echo $_smarty_tpl->tpl_vars['Product']->value['product_id'];?>
" class="TopHeaderTable ui-helper-reset AlignCenter SortTable ProductOptionTable">
				<tr class="ui-state-highlight nodrop nodrag">
					<th width="120">Option Code</th>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguageRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
					    <th width="80"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['R']->value['language_longname'], ENT_QUOTES, 'UTF-8', true);?>
</th>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					<th>Action</th>
				</tr>
				<?php if (count($_smarty_tpl->tpl_vars['ProductOptionList']->value) == 0) {?>
					<tr class="nodrop nodrag">
						<td colspan="<?php echo smarty_function_math(array('equation'=>'x + y','x'=>2,'y'=>count($_smarty_tpl->tpl_vars['SiteLanguageRoots']->value)),$_smarty_tpl);?>
">You may add product option here.</td>
					</tr>
				<?php }?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductOptionList']->value, 'O', false, 'K');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['K']->value => $_smarty_tpl->tpl_vars['O']->value) {
?>
					<tr id="ProductOption-<?php echo $_smarty_tpl->tpl_vars['K']->value;?>
" class="<?php if ($_smarty_tpl->tpl_vars['O']->value['object_is_enable'] == 'N') {?>DisabledRow<?php }?>">
						<td class="AlignCenter"><?php echo $_smarty_tpl->tpl_vars['O']->value['product_option_code'];?>
</td>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguageRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
						    <td width="80">
								<?php
$__section_foo_6_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$__section_foo_6_loop = (is_array(@$_loop=intval($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_option_show_no'])) ? count($_loop) : max(0, (int) $_loop));
$__section_foo_6_start = min(0, $__section_foo_6_loop);
$__section_foo_6_total = min(($__section_foo_6_loop - $__section_foo_6_start), $__section_foo_6_loop);
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if ($__section_foo_6_total != 0) {
for ($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = $__section_foo_6_start; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] <= $__section_foo_6_total; $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
									<?php echo $_smarty_tpl->tpl_vars['ProductOptionList']->value[$_smarty_tpl->tpl_vars['K']->value][$_smarty_tpl->tpl_vars['R']->value['language_id']][(isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['iteration'] : null)];?>
 <br />
								<?php
}
}
if ($__section_foo_6_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_6_saved;
}
?>
						    </td>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

						<td class="AlignCenter">
							<a href="product_option_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['K']->value;?>
&link_id=<?php echo $_REQUEST['link_id'];?>
" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> edit
							</a>
							<a href="product_option_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['K']->value;?>
&link_id=<?php echo $_REQUEST['link_id'];?>
" onclick="return confirm('WARNING!\n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton">
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
			<a href="product_option_add.php?link_id=<?php echo $_REQUEST['link_id'];?>
" class="ui-state-default ui-corner-all MyButton">
				<span class="ui-icon ui-icon-circle-plus"></span> Add Option
			</a>
		</div>
	</div>
<?php }?>


<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader"><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Media</h2>
	<div class="InnerContent ui-widget-content ui-corner-bottom">
		<table id="MediaListTable-<?php echo $_smarty_tpl->tpl_vars['Product']->value['product_id'];?>
" class="TopHeaderTable ui-helper-reset AlignCenter SortTable MediaListTable">
			<tr class="ui-state-highlight nodrop nodrag">
				<th width="50">ID</th>
				<th width="250">Media</th>
				<th>Action</th>
			</tr>
			<?php if (count($_smarty_tpl->tpl_vars['ProductMediaList']->value) == 0) {?>
				<tr class="nodrop nodrag">
					<td colspan="3">You may upload photos and video here.</td>
				</tr>
			<?php }?>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductMediaList']->value, 'M');
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
						<a href="product_media_set_highlight.php?link_id=<?php echo $_REQUEST['link_id'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['M']->value['media_id'];?>
" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-image"></span> product thumbnail
						</a>
						<a href="media_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['M']->value['media_id'];?>
&link_id=<?php echo $_REQUEST['link_id'];?>
&refer=product_edit" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-pencil"></span> edit
						</a>
						<a href="media_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['M']->value['media_id'];?>
&link_id=<?php echo $_REQUEST['link_id'];?>
&refer=product_edit" onclick="return confirm('WARNING!\n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton">
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
			<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['Product']->value['product_id'];?>
" />
			<input type="hidden" name="refer" value="product_edit" />
			<br />
			<input type="checkbox" name="UpdateThumbnailOnly" value="Y" /> Update Thumbnail <br />
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

<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_datafile'] == 'Y') {?>
	<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
		<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader"><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Datafile </h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table id="DatafileListTable-<?php echo $_smarty_tpl->tpl_vars['Product']->value['product_id'];?>
" class="TopHeaderTable ui-helper-reset AlignCenter SortTable DatafileListTable">
				<tr class="ui-state-highlight nodrop nodrag">
					<th width="50">ID</th>
					<th width="250">Datafile</th>
					<th width="80">Filesize</th>
					<th width="30">Security Level</th>					
					<th>Action</th>
				</tr>
				<?php if (count($_smarty_tpl->tpl_vars['ProductDatafileList']->value) == 0) {?>
					<tr class="nodrop nodrag">
						<td colspan="3">You may upload any files here.</td>
					</tr>
				<?php }?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductDatafileList']->value, 'D');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['D']->value) {
?>
					<tr id="Datafile-<?php echo $_smarty_tpl->tpl_vars['D']->value['datafile_id'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['D']->value['object_is_enable'] == 'N') {?>DisabledRow<?php }?>">
						<td class="AlignCenter"><?php echo $_smarty_tpl->tpl_vars['D']->value['datafile_id'];?>
</td>
						<td><a href="<?php echo @constant('BASEURL');?>
getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['D']->value['datafile_file_id'];?>
" target="_preview"><?php echo $_smarty_tpl->tpl_vars['D']->value['filename'];?>
</a></td>
						<td><?php echo sprintf("%.2f",($_smarty_tpl->tpl_vars['D']->value['size']/1024));?>
kb</td>
						<td><?php echo $_smarty_tpl->tpl_vars['D']->value['object_security_level'];?>
</td>
						<td class="AlignCenter">
							<a href="datafile_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['D']->value['datafile_id'];?>
&link_id=<?php echo $_REQUEST['link_id'];?>
&refer=product_edit" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> edit
							</a>
							<a href="datafile_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['D']->value['datafile_id'];?>
&link_id=<?php echo $_REQUEST['link_id'];?>
&refer=product_edit" onclick="return confirm('WARNING!\n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton">
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
			<form enctype="multipart/form-data" name="FrmAddDatafile" id="FrmAddDatafile" method="post" action="datafile_add_act.php">
				<input type="file" name="datafile[]" multiple="true" />
				<input type="file" name="datafile[]" multiple="true" />
				<input type="file" name="datafile[]" multiple="true" /> <br />
				<br />
				Datafile Security Level: <input type="text" name="datafile_security_level" value="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_default_security_level'];?>
" />
				<br />
				<input type="hidden" name="link_id" value="<?php echo $_REQUEST['link_id'];?>
" />
				<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['Product']->value['product_id'];?>
" />
				<input type="hidden" name="refer" value="product_edit" />
				<br />
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmAddDatafile">
					<span class="ui-icon ui-icon-circle-plus"></span> Add Datafile
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmAddDatafile">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</form>
		</div>
	</div>

<?php }?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
