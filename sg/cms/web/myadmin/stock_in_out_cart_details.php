<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_inventory.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'inventory');
$smarty->assign('CurrentTab2', 'stock_in_out_cart_details');
$smarty->assign('MyJS', 'stock_in_out_cart_details');

inventory::TouchStockInOutCart($Site['site_id'], $_SESSION['ContentAdminID'], $_SESSION['SystemAdminID']);
$StockInOutCart = inventory::GetStockInOutCartInfo($Site['site_id'], $_SESSION['ContentAdminID'], $_SESSION['SystemAdminID']);
$smarty->assign('StockInOutCart', $StockInOutCart);

$StockInOutCartProducts = inventory::GetStockInOutCartProducts($StockInOutCart['stock_in_out_cart_id'], $Site['site_default_language_id']);
$smarty->assign('StockInOutCartProducts', $StockInOutCartProducts);

$ProductFieldsShow = site::GetProductFieldsShow($_SESSION['site_id']);
$smarty->assign('ProductFieldsShow', $ProductFieldsShow);

$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/stock_in_out_cart_details.tpl');