<?php
/* Smarty version 3.1.30, created on 2017-04-13 04:42:15
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/product_brand_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58ef01a761b698_83539436',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bcebb1d0bc912f77398a075c491be6e2181331f5' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/product_brand_list.tpl',
      1 => 1491504957,
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
function content_58ef01a761b698_83539436 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Brand List &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_tree.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> <?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Tree
	</a>
</h1>
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
		Brands Per Page:
		<select id="num_of_product_brand_per_page" name="num_of_product_brand_per_page" onchange="submit()">
		    <option value="10" <?php if ($_COOKIE['num_of_product_brand_per_page'] == 10) {?>selected="selected"<?php }?>>10</option>
		    <option value="20" <?php if ($_COOKIE['num_of_product_brand_per_page'] == 20) {?>selected="selected"<?php }?>>20</option>
		    <option value="30" <?php if ($_COOKIE['num_of_product_brand_per_page'] == 30) {?>selected="selected"<?php }?>>30</option>
		    <option value="40" <?php if ($_COOKIE['num_of_product_brand_per_page'] == 40) {?>selected="selected"<?php }?>>40</option>
		    <option value="50" <?php if ($_COOKIE['num_of_product_brand_per_page'] == 50) {?>selected="selected"<?php }?>>50</option>
		    <option value="9999" <?php if ($_COOKIE['num_of_product_brand_per_page'] == 9999) {?>selected="selected"<?php }?>>All</option>
		</select>
		<input type="hidden" name="product_brand_ref_name" value="<?php echo $_REQUEST['product_brand_ref_name'];?>
" />
	</form>
	<br />
	<a href="product_brand_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add Brand</a>
	<a id="BtnToggleThumbnails" class="ui-state-default ui-corner-all MyButton" href="#">
		<span class="ui-icon ui-icon-image"></span> Show/Hide Thumbnails
	</a>
	<table id="ProductBrandListTable" data-num_of_product_brand_per_page="<?php echo $_COOKIE['num_of_product_brand_per_page'];?>
" data-page_id="<?php echo $_REQUEST['page_id'];?>
" class="TopHeaderTable ui-helper-reset AlignCenter SortTable">
		<tr class="ui-state-highlight nodrop nodrag">
			<th></th>
			<th>Brand Name</th>
			<th>Action</th>
		</tr>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductBrandList']->value, 'P');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['P']->value) {
?>
			<tr id="ProductBrand-<?php echo $_smarty_tpl->tpl_vars['P']->value['object_link_id'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['P']->value['object_is_enable'] == 'N') {?>DisabledRow<?php }?>">
				<td class="AlignCenter">
					<?php if ($_smarty_tpl->tpl_vars['P']->value['object_thumbnail_file_id'] != 0) {?>
						<img class="MediaSmallFile" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_media_small_width'] < 80) {?>width="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_media_small_width'];?>
"<?php } else { ?>width="80"<?php }?> src="<?php echo @constant('BASEURL');?>
/getfile.php?id=<?php echo $_smarty_tpl->tpl_vars['P']->value['object_thumbnail_file_id'];?>
" /><br class="MediaSmallFile" />
					<?php }?>
				</td>
				<td><?php echo $_smarty_tpl->tpl_vars['P']->value['object_name'];?>
</td>
				<td class="AlignCenter">
					<a href="product_brand_edit.php?link_id=<?php echo $_smarty_tpl->tpl_vars['P']->value['object_link_id'];?>
" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> Edit
					</a>
					<a href="product_brand_delete.php?link_id=<?php echo $_smarty_tpl->tpl_vars['P']->value['object_link_id'];?>
" onclick="return confirm('WARNING!\n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> delete
					</a>
					<a href="product_brand_product_list.php?link_id=<?php echo $_smarty_tpl->tpl_vars['P']->value['object_link_id'];?>
" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> Product List
					</a>
				</td>
			</tr>
		<?php
}
} else {
?>

			<tr class="nodrop nodrag">
				<td colspan="3" class="AlignCenter">No brand defined.</td>
			</tr>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

	</table>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
