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
$smarty->assign('MyJS', 'product_brand_product_list');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

$ProductBrand = product::GetProductBrandInfo($ObjectLink['object_id'], 0);
if ($ProductBrand['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_brand_list.php', __LINE__);

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

$Products = product::GetProductListByBrandID($ProductBrand['product_brand_id'], $Site['site_default_language_id'], $TotalProducts, $_REQUEST['page_id'], $_COOKIE['num_of_products_per_page']);
$smarty->assign('Products', $Products);

$NoOfPage = ceil($TotalProducts / $_COOKIE['num_of_products_per_page']);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$smarty->assign('TITLE', 'Brand Product List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_brand_product_list.tpl');