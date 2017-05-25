<?php
/* Smarty version 3.1.30, created on 2017-03-25 16:38:04
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/product_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d68edc694184_80456070',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '99a4fdb35a1311da1fbf70d838c7f97c40ce00cf' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/product_list.tpl',
      1 => 1452777356,
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
function content_58d68edc694184_80456070 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle"><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 List &nbsp;
	<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_special_category'] != 'N') {?>
		<a class="ui-state-default ui-corner-all MyButton" href="product_tree_special.php">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Special Category
		</a>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['ProductFieldsShow']->value['product_brand_id'] != 'N') {?>
		<a class="ui-state-default ui-corner-all MyButton" href="product_brand_list.php">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Brand List
		</a>
	<?php }?>
</h1>
<p>
	<strong>View:</strong>
	<a href="product_tree.php?view=product_category_tree" class="ProductTreeViewSelector<?php if ($_COOKIE['product_view'] == 'product_category_tree') {?> ui-state-active<?php }?>">Tree</a> | 
	<a href="product_tree.php?view=product_tree_full" class="ProductTreeViewSelector<?php if ($_COOKIE['product_view'] == 'product_tree_full') {?> ui-state-active<?php }?>">Tree with Products</a> | 
	<a href="product_tree.php?view=product_list" class="ProductTreeViewSelector<?php if ($_COOKIE['product_view'] == 'product_list') {?> ui-state-active<?php }?>">List</a>
</p>

<br />
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form name="FrmSetPageID" id="FrmSetPageID" method="post">
		Page:
		<select id="page_id" name="page_id" onchange="submit()">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['PageNoSelection']->value, 'P');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['P']->value) {
?>
			    <option value="<?php echo $_smarty_tpl->tpl_vars['P']->value;?>
"
					<?php if ($_smarty_tpl->tpl_vars['P']->value == $_REQUEST['page_id']) {?>selected="selected"<?php }?>
			    ><?php echo $_smarty_tpl->tpl_vars['P']->value;?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</select>
		&nbsp; &nbsp; &nbsp;
		<?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Per Page:
		<select id="num_of_products_per_page" name="num_of_products_per_page" onchange="submit()">
		    <option value="10" <?php if ($_COOKIE['num_of_products_per_page'] == 10) {?>selected="selected"<?php }?>>10</option>
		    <option value="20" <?php if ($_COOKIE['num_of_products_per_page'] == 20) {?>selected="selected"<?php }?>>20</option>
		    <option value="30" <?php if ($_COOKIE['num_of_products_per_page'] == 30) {?>selected="selected"<?php }?>>30</option>
		    <option value="40" <?php if ($_COOKIE['num_of_products_per_page'] == 40) {?>selected="selected"<?php }?>>40</option>
		    <option value="50" <?php if ($_COOKIE['num_of_products_per_page'] == 50) {?>selected="selected"<?php }?>>50</option>
		    <option value="9999" <?php if ($_COOKIE['num_of_products_per_page'] == 9999) {?>selected="selected"<?php }?>>All</option>
		</select>
		<input type="hidden" name="parent_object_id" value="<?php echo $_REQUEST['parent_object_id'];?>
" />
		<input type="hidden" name="product_id" value="<?php echo $_REQUEST['product_id'];?>
" />
		<input type="hidden" name="product_code" value="<?php echo $_REQUEST['product_code'];?>
" />
		<input type="hidden" name="product_ref_name" value="<?php echo $_REQUEST['product_ref_name'];?>
" />
	</form>
	<br />
	<a href="product_add.php?link_id=<?php echo $_REQUEST['link_id'];?>
" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
</a>
	<a href="?" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-arrowrefresh-1-s"></span> Reset Filter
	</a>	
	<a id="BtnToggleThumbnails" class="ui-state-default ui-corner-all MyButton" href="#">
		<span class="ui-icon ui-icon-image"></span> Show/Hide Thumbnails
	</a>
	<table class="TopHeaderTable">
		<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post">
			<tr class="AlignCenter">
				<td></td>
				<td>
					<select id="parent_object_id" name="parent_object_id">
						<option value="0" <?php if ($_REQUEST['parent_object_id'] == 0) {?>selected="selected"<?php }?>>Any</option>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductRoots']->value, 'PC');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PC']->value) {
?>
							<option <?php if ($_REQUEST['parent_object_id'] == $_smarty_tpl->tpl_vars['PC']->value['object_id']) {?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['PC']->value['object_id'];?>
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
							<option <?php if ($_REQUEST['parent_object_id'] == $_smarty_tpl->tpl_vars['PC']->value['object_id']) {?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['PC']->value['object_id'];?>
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
				<td><input type="text" name="product_id" size="5" value="<?php echo $_REQUEST['product_id'];?>
" /></td>
				<td><input type="text" name="product_code" size="5" value="<?php echo $_REQUEST['product_code'];?>
" /></td>
				<td><input type="text" name="product_ref_name" value="<?php echo $_REQUEST['product_ref_name'];?>
" /></td>
				<td>
					<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
						<span class="ui-icon ui-icon-search"></span> Filter
					</a>
				</td>
			</tr>
		</form>
		<tr class="ui-state-highlight">
			<th></th>
			<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Category</th>
			<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 ID</th>
			<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Code</th>
			<th><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
</th>
			<th>Product Price 1</th>
			<th>Order</th>
			<th>Action</th>
		</tr>
		<form enctype="multipart/form-data" name="FrmUpdateProductOrder" id="FrmUpdateProductOrder" method="post" action="product_list_act.php">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Products']->value, 'P');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['P']->value) {
?>
				<tr class="<?php if ($_smarty_tpl->tpl_vars['P']->value['object_is_enable'] == 'N') {?>DisabledRow<?php }?>">
					<td class="AlignCenter">
						<?php if ($_smarty_tpl->tpl_vars['P']->value['object_thumbnail_file_id'] != 0) {?>
							<img class="MediaSmallFile" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_media_small_width'] < 80) {?>width="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_media_small_width'];?>
"<?php } else { ?>width="80"<?php }?> src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['P']->value['object_thumbnail_file_id'];?>
" /><br class="MediaSmallFile" />
						<?php }?>
					</td>
					<td class="AlignCenter"><?php echo $_smarty_tpl->tpl_vars['P']->value['parent_object_ref_name'];?>
</td>
					<td class="AlignCenter"><?php echo $_smarty_tpl->tpl_vars['P']->value['product_id'];?>
</td>
					<td class="AlignCenter"><?php echo $_smarty_tpl->tpl_vars['P']->value['product_code'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['P']->value['object_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['P']->value['product_price'];?>
</td>
					<td><input class="AlignCenter" style="width: 50px" type="text" name="object_global_order_id[<?php echo $_smarty_tpl->tpl_vars['P']->value['object_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['P']->value['object_global_order_id'];?>
" /></td>
					<td class="AlignCenter">
						<a href="product_edit.php?link_id=<?php echo $_smarty_tpl->tpl_vars['P']->value['object_link_id'];?>
" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-pencil"></span> Edit
						</a>
					</td>
				</tr>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			<tr>
				<td colspan="8">
					<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton FloatRight" target="FrmUpdateProductOrder">
						<span class="ui-icon ui-icon-circle-plus"></span> Update
					</a>

					<input type="submit" value="Update" class="Hidden" />
				
				</td>
			</tr>
		</form>
	</table>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
