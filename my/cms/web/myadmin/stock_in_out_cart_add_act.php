<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_inventory.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'inventory');
$smarty->assign('CurrentTab2', 'stock_in_out_cart_add');
$smarty->assign('MyJS', 'stock_in_out_cart_add');

header('Content-type: text/xml');

inventory::TouchStockInOutCart($Site['site_id'], $_SESSION['ContentAdminID'], $_SESSION['SystemAdminID']);
$StockInOutCart = inventory::GetStockInOutCartInfo($Site['site_id'], $_SESSION['ContentAdminID'], $_SESSION['SystemAdminID']);

$Product = product::GetProductInfo($_REQUEST['product_id'], 0);
if ($Product['site_id'] != $_SESSION['site_id'])
	XMLDie(__LINE__, ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR);

if ($_REQUEST['product_option_id'] != 0) {
	$ProductOption = product::GetProductOptionInfo($_REQUEST['product_option_id'], 0);
	if ($ProductOption['site_id'] != $_SESSION['site_id'])
		XMLDie(__LINE__, ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR);
}

$Msg = '';
if ($_REQUEST['product_quantity'] != 0)
	$Msg = 'Product has been ADDED to Stock In/Out Basket successfully.';
else
	$Msg = 'Product has been REMOVED from Stock In/Out Basket successfully.';
$smarty->assign('Msg', $Msg);

inventory::AddToStockInOutCart($StockInOutCart['stock_in_out_cart_id'], $_REQUEST['product_id'], $_REQUEST['product_option_id'], $_REQUEST['product_quantity']);

$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/stock_in_out_cart_add_act.tpl');