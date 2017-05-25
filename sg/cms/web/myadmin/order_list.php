<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

if ($_REQUEST['myaction'] == 'export') {
	$Output = cart::ExportMyOrderXLSBySiteID($_SESSION['site_id'], $_REQUEST['handled'], $_REQUEST['order_type'], $_REQUEST['order_no'], $_REQUEST['order_status'], $_REQUEST['user_username'], $_REQUEST['user_email'], $_REQUEST['invoice_tel_no'], $_REQUEST['pay_amount_ca_min'], $_REQUEST['pay_amount_ca_max'], $_REQUEST['payment_confirm_by'], $_REQUEST['user_reference'], $_REQUEST['order_confirm_date_min'], $_REQUEST['order_confirm_date_max']);
	exit;
}

if ($_REQUEST['order_type'] == 'order')
	$smarty->assign('CurrentTab', 'order');
elseif ($_REQUEST['order_type'] == 'redeem')
	$smarty->assign('CurrentTab', 'redeem');
else {
	$_REQUEST['order_type'] = 'order';
	$smarty->assign('CurrentTab', 'order');
}
$smarty->assign('MyJS', 'order_list');

$CustomizeOrderList_Cell = array('order_no', 'order_status', 'user_username', 'user_email', 'invoice_phone_no', 'pay_amount_ca', 'payment_confirm_by', 'user_reference', 'order_confirm_date', 'void');
$AllOff = true;
// Check if all cookie is not set
foreach ($CustomizeOrderList_Cell as $C) {
	if ($_COOKIE['CustomizeOrderList_Cell_' . $C] == 'Y') {
		$AllOff = false;
		break;
	}
}
if ($AllOff) {
	$_COOKIE['CustomizeOrderList_Cell_order_no'] = 'Y';
	$_COOKIE['CustomizeOrderList_Cell_order_status'] = 'Y';
	$_COOKIE['CustomizeOrderList_Cell_user_username'] = 'Y';
	$_COOKIE['CustomizeOrderList_Cell_pay_amount_ca'] = 'Y';
	$_COOKIE['CustomizeOrderList_Cell_order_confirm_date'] = 'Y';	
}

if ($_REQUEST['handled'] == 'Y')
	$smarty->assign('CurrentTab2', 'order_handled');
elseif ($_REQUEST['handled'] == 'N')
	$smarty->assign('CurrentTab2', 'order_not_handled');
else {
	$_REQUEST['handled'] = 'ALL';
	$smarty->assign('CurrentTab2', 'order_all');
}

if (!isset($_REQUEST['shop_id']))
	$_REQUEST['shop_id'] = '0';

$PassShopID = false;
if ($_REQUEST['shop_id'] != 'all') {
	$PassShopID = $_REQUEST['shop_id'];
}

$ShopList = shop::GetShopList($_SESSION['site_id']);
$smarty->assign('ShopList', $ShopList);

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

$TotalOrders = 0;

$OrderList = cart::GetMyOrderListBySiteID($_SESSION['site_id'], $TotalOrders, $_REQUEST['page_id'], NUM_OF_ORDERS_PER_PAGE, $_REQUEST['handled'], $_REQUEST['order_type'], $_REQUEST['order_no'], $_REQUEST['order_status'], $_REQUEST['user_username'], $_REQUEST['user_email'], $_REQUEST['invoice_phone_no'], $_REQUEST['pay_amount_ca_min'], $_REQUEST['pay_amount_ca_max'], $_REQUEST['payment_confirm_by'], $_REQUEST['user_reference'], $_REQUEST['order_confirm_date_min'], $_REQUEST['order_confirm_date_max'], $PassShopID);
$smarty->assign('OrderList', $OrderList);

$NoOfPage = ceil($TotalOrders / NUM_OF_ORDERS_PER_PAGE);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);


$smarty->assign('OrderStatusList', $OrderStatusList);
$smarty->assign('TITLE', 'Order List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/order_list.tpl');