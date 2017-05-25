<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

if (!($Site['site_module_inventory_enable'] == 'Y' || $Site['site_module_inventory_partial_shipment'] == 'Y'))
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);

$smarty->assign('CurrentTab', 'order');
$smarty->assign('MyJS', 'stock_shipment_add');

$MyOrder = cart::GetMyOrderInfo($_REQUEST['id']);
if ($MyOrder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
if ($MyOrder['payment_confirmed'] == 'N')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);
$smarty->assign('MyOrder', $MyOrder);


$CountryList = country::GetCountryList(1);
$smarty->assign('CountryList', $CountryList);

$HKDistrictList = country::GetHongKongDistrictList();
$smarty->assign('HKDistrictList', $HKDistrictList);

$StockTransaction = inventory::GetStockHoldTransactionInfoForMyOrder($_REQUEST['id']);
$StockTransactionProducts = inventory::GetStockTransactionProducts($StockTransaction['stock_transaction_id'], $Site['site_default_language_id']);
$smarty->assign('StockTransactionProducts', $StockTransactionProducts);

if ($MyOrder['is_handled'] == 'Y')
	$smarty->assign('CurrentTab2', 'order_handled');
elseif ($MyOrder['is_handled'] == 'N')
	$smarty->assign('CurrentTab2', 'order_not_handled');

$smarty->assign('TITLE', 'Make Shipment');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/stock_shipment_add.tpl');