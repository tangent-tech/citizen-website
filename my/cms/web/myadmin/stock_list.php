<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_inventory.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'inventory');
$smarty->assign('CurrentTab2', 'stock_list');
$smarty->assign('MyJS', 'stock_list');

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

$TotalProducts = 0;

inventory::TouchStockInOutCart($Site['site_id'], $_SESSION['ContentAdminID'], $_SESSION['SystemAdminID']);
$StockInOutCart = inventory::GetStockInOutCartInfo($Site['site_id'], $_SESSION['ContentAdminID'], $_SESSION['SystemAdminID']);

$Products = inventory::GetProductStockListWithStockInOutCartInfo($Site['site_id'], $StockInOutCart['stock_in_out_cart_id'], $Site['site_default_language_id'], $TotalProducts, $_REQUEST['page_id'], NUM_OF_PRODUCTS_PER_PAGE, $_REQUEST['product_stock_level_min'], $_REQUEST['product_stock_level_max'], $_REQUEST['parent_object_id'], $_REQUEST['product_id'], $_REQUEST['product_code'], $_REQUEST['product_ref_name']);
//$Products = inventory::GetProductStockList($Site['site_id'], $LanguageList[0]['language_id'], $TotalProducts, $_REQUEST['page_id'], NUM_OF_PRODUCTS_PER_PAGE);
$smarty->assign('Products', $Products);

$NoOfPage = ceil($TotalProducts / NUM_OF_PRODUCTS_PER_PAGE);

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

$smarty->assign('TITLE', 'Inventory List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/stock_list.tpl');