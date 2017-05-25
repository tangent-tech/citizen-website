<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_product.php');

acl::AclBarrier("acl_product_brand_manage", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_brand_list');

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

if (isset($_POST['num_of_product_brand_per_page'])) {
	if (intval($_POST['num_of_product_brand_per_page']) < NUM_OF_PRODUCT_BRANDS_PER_PAGE)
		$_POST['num_of_product_brand_per_page'] = NUM_OF_PRODUCT_BRANDS_PER_PAGE;
	setcookie('num_of_product_brand_per_page', $_POST['num_of_product_brand_per_page']);
	$_COOKIE['num_of_product_brand_per_page'] = $_POST['num_of_product_brand_per_page'];
}
else {
	if (intval($_COOKIE['num_of_product_brand_per_page']) < NUM_OF_PRODUCT_BRANDS_PER_PAGE) {
		$_COOKIE['num_of_product_brand_per_page'] = NUM_OF_PRODUCT_BRANDS_PER_PAGE;
		setcookie('num_of_product_brand_per_page', $_COOKIE['num_of_product_brand_per_page']);
	}
}
$TotalProductBrand = 0;

$ProductBrandList = product::GetAllBrandList($Site['site_id'], $Site['site_default_language_id'], $TotalProductBrand, $_REQUEST['page_id'], $_COOKIE['num_of_product_brand_per_page'], $_REQUEST['product_brand_ref_name']);
$smarty->assign('ProductBrandList', $ProductBrandList);

$NoOfPage = ceil($TotalProductBrand / $_COOKIE['num_of_product_brand_per_page']);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$smarty->assign('TITLE', 'Product Brand List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_brand_list.tpl');