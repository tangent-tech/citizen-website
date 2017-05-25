<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'order');
$smarty->assign('MyJS', 'order_details');

$MyOrder = cart::GetMyOrderInfo($_REQUEST['id']);
if ($MyOrder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_ORDER_IS_DELETED, 'order_list.php', __LINE__);
$smarty->assign('MyOrder', $MyOrder);


$CountryList = country::GetCountryList(1);
$smarty->assign('CountryList', $CountryList);

$HKDistrictList = country::GetHongKongDistrictList();
$smarty->assign('HKDistrictList', $HKDistrictList);

$User = user::GetUserInfo($MyOrder['user_id']);
$smarty->assign('User', $User);

$UserLanguage = language::GetLanguageInfo($User['user_language_id']);
$smarty->assign('UserLanguage', $UserLanguage);

$BonusPointItemList = bonuspoint::GetBonusPointItemList($_SESSION['site_id'], $Site['site_default_language_id'], 0, 'ALL');
$smarty->assign('BonusPointItemList', $BonusPointItemList);

$TotalPrice = 0;
$TotalPriceCA = 0;
$TotalCash = 0;
$TotalCashCA = 0;
$TotalBonusPoint = 0;
$TotalBonusPointRequired = 0;
$MyOrderItemList = cart::GetMyOrderItemList($_REQUEST['id'], $Site['site_default_language_id'], $TotalPrice, $TotalPriceCA, $TotalBonusPoint);
$MyOrderBonusPointItemList = cart::GetMyOrderBonusPointItemList($_REQUEST['id'], $Site['site_default_language_id'], $TotalCash, $TotalCashCA, $TotalBonusPointRequired);
$smarty->assign('MyOrderItemList', $MyOrderItemList);
$smarty->assign('MyOrderBonusPointItemList', $MyOrderBonusPointItemList);
$smarty->assign('TotalPrice', $TotalPrice);
$smarty->assign('TotalPriceCA', $TotalPriceCA);
$smarty->assign('TotalBonusPoint', $TotalBonusPoint);

if ($Site['site_module_inventory_enable'] == 'Y' || $Site['site_module_inventory_partial_shipment'] == 'Y') {
	$ShipmentList = inventory::GetMyOrderShipmentList($_REQUEST['id']);
	$smarty->assign('ShipmentList', $ShipmentList);

	$LanguageList = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');
	
	$StockTransaction = inventory::GetStockHoldTransactionInfoForMyOrder($_REQUEST['id']);
	$StockTransactionProducts = inventory::GetStockTransactionProducts($StockTransaction['stock_transaction_id'], $LanguageList[0]['language_id']);
	$smarty->assign('StockTransactionProducts', $StockTransactionProducts);
}

if ($MyOrder['is_handled'] == 'Y')
	$smarty->assign('CurrentTab2', 'order_handled');
elseif ($MyOrder['is_handled'] == 'N')
	$smarty->assign('CurrentTab2', 'order_not_handled');

$ProductFieldsShow = site::GetProductFieldsShow($_SESSION['site_id']);
$smarty->assign('ProductFieldsShow', $ProductFieldsShow);

$MyorderCustomFieldsDef = Site::GetMyorderCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('MyorderCustomFieldsDef', $MyorderCustomFieldsDef);

$MyorderFieldsShow = Site::GetMyorderFieldsShow($_SESSION['site_id']);
$smarty->assign('MyorderFieldsShow', $MyorderFieldsShow);

$UserFieldsShow = site::GetUserFieldsShow($_SESSION['site_id']);
$smarty->assign('UserFieldsShow', $UserFieldsShow);

$smarty->assign('TITLE', 'Order Details');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/order_details.tpl');