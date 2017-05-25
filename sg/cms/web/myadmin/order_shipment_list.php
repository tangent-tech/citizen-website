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
$smarty->assign('CurrentTab2', 'order_shipment_list');
$smarty->assign('MyJS', 'order_shipment_list');

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

if (!isset($_REQUEST['shop_id']))
	$_REQUEST['shop_id'] = 0;

$PassShopID = false;
if ($_REQUEST['shop_id'] != 'all') {
	$PassShopID = $_REQUEST['shop_id'];
}

$ShopList = shop::GetShopList($_SESSION['site_id']);
$smarty->assign('ShopList', $ShopList);

$TotalTransactions = 0;

$StockTransactionList = inventory::GetStockTransactionList($Site['site_id'], $TotalTransactions, $_REQUEST['page_id'], NUM_OF_TRANSACTIONS_PER_PAGE, 'SHIPMENT', $PassShopID);
$smarty->assign('StockTransactionList', $StockTransactionList);

$NoOfPage = ceil($TotalTransactions / NUM_OF_TRANSACTIONS_PER_PAGE);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$smarty->assign('TITLE', 'Shipment List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/order_shipment_list.tpl');