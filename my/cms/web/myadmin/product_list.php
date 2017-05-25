<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_product.php');

acl::AclBarrier("acl_product_tree_list", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_list');

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

if (isset($_POST['num_of_products_per_page'])) {
	if (intval($_POST['num_of_products_per_page']) < NUM_OF_PRODUCTS_PER_PAGE)
		$_POST['num_of_products_per_page'] = NUM_OF_PRODUCTS_PER_PAGE;
	setcookie('num_of_products_per_page', $_POST['num_of_products_per_page']);
	$_COOKIE['num_of_products_per_page'] = $_POST['num_of_products_per_page'];
}
else {
	if (intval($_COOKIE['num_of_products_per_page']) < NUM_OF_PRODUCTS_PER_PAGE) {
		$_COOKIE['num_of_products_per_page'] = NUM_OF_PRODUCTS_PER_PAGE;
		setcookie('num_of_products_per_page', $_COOKIE['num_of_products_per_page']);
	}
}	
	
$TotalProducts = 0;

$Products = product::GetAllProductList($Site['site_id'], $Site['site_default_language_id'], $TotalProducts, $_REQUEST['page_id'], $_COOKIE['num_of_products_per_page'], $_REQUEST['parent_object_id'], $_REQUEST['product_id'], $_REQUEST['product_code'], $_REQUEST['product_ref_name']);
$smarty->assign('Products', $Products);

$NoOfPage = ceil($TotalProducts / $_COOKIE['num_of_products_per_page']);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$ProductRoots = product::GetProductRootList($Site);
$smarty->assign('ProductRoots', $ProductRoots);

$ProductCatList = product::GetProductCatList($_SESSION['site_id'], 0);
$smarty->assign('ProductCatList', $ProductCatList);

$ProductFieldsShow = site::GetProductFieldsShow($_SESSION['site_id']);
$smarty->assign('ProductFieldsShow', $ProductFieldsShow);

$smarty->assign('TITLE', 'Product List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_list.tpl');