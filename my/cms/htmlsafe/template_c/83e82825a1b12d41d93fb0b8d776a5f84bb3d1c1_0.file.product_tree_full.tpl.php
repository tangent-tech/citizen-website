<?php
/* Smarty version 3.1.30, created on 2017-03-25 16:38:14
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/product_tree_full.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d68ee614d724_23787937',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '83e82825a1b12d41d93fb0b8d776a5f84bb3d1c1' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/product_tree_full.tpl',
      1 => 1441542944,
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
function content_58d68ee614d724_23787937 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle"><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
 Tree &nbsp;
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
	<a class="ui-state-default ui-corner-all MyButton" href="product_category_import_thumbnail.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Update blank product category thumbnail
	</a>		
</h1>
<p>
	<strong>View:</strong>
	<a href="product_tree.php?view=product_category_tree" class="ProductTreeViewSelector<?php if ($_COOKIE['product_view'] == 'product_category_tree') {?> ui-state-active<?php }?>">Tree</a> | 
	<a href="product_tree.php?view=product_tree_full" class="ProductTreeViewSelector<?php if ($_COOKIE['product_view'] == 'product_tree_full') {?> ui-state-active<?php }?>">Tree with Products</a> | 
	<a href="product_tree.php?view=product_list" class="ProductTreeViewSelector<?php if ($_COOKIE['product_view'] == 'product_list') {?> ui-state-active<?php }?>">List</a>
</p>

<br />
<div class="InnerContainer ui-widget ui-corner-all">
	<div id="PRODUCT_TREE">
		<ul>
			<li rel="SITE_ROOT" id="OL_0" data-object_type="SITE_ROOT" data-object_link_id="0" data-object_id="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_root_id'];?>
" data-object_system_flag="system"><a href="#"><ins>&nbsp;</ins></a>
				<?php echo $_smarty_tpl->tpl_vars['ProductTree']->value;?>

			</li>
		</ul>
	</div>
	<br class="clearfloat" />
</div>
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
