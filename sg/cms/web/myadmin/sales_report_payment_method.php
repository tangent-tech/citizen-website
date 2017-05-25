<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'sales_report');
$smarty->assign('CurrentTab2', 'sales_report_payment_method');

$smarty->assign('MyJS', 'sales_report_payment_method');

if (!isset($_REQUEST['order_start_date']))
	$_REQUEST['order_start_date'] = date ('Y-m-d');
if (!isset($_REQUEST['order_end_date']))
	$_REQUEST['order_end_date'] = date ('Y-m-d');

if (!isset($_REQUEST['shop_id']))
	$_REQUEST['shop_id'] = 0;

$PassShopID = false;
$GroupByShop = false;
if ($_REQUEST['shop_id'] != 'all') {
	$PassShopID = $_REQUEST['shop_id'];
	$GroupByShop = true;
}

$ShopList = shop::GetShopList($_SESSION['site_id']);
$smarty->assign('ShopList', $ShopList);

$NormalReport = myorder::GetSalesReportPerOrderConfirmBy($_SESSION['site_id'], $_REQUEST['order_start_date'], $_REQUEST['order_end_date'], true, $PassShopID, $GroupByShop, true);
$NormalReportTotal = myorder::GetSalesReportPerOrderConfirmBy($_SESSION['site_id'], $_REQUEST['order_start_date'], $_REQUEST['order_end_date'], true, $PassShopID, false, false);

$VoidReport = myorder::GetSalesReportPerOrderConfirmBy($_SESSION['site_id'], $_REQUEST['order_start_date'], $_REQUEST['order_end_date'], false, $PassShopID, $GroupByShop, true);
$VoidReportTotal = myorder::GetSalesReportPerOrderConfirmBy($_SESSION['site_id'], $_REQUEST['order_start_date'], $_REQUEST['order_end_date'], false, $PassShopID, false, false);

$smarty->assign('NormalReport', $NormalReport);
$smarty->assign('NormalReportTotal', $NormalReportTotal);
$smarty->assign('VoidReport', $VoidReport);
$smarty->assign('VoidReportTotal', $VoidReportTotal);

$ProductReport = myorder::GetSalesReportPerProductandOrderConfirmDate($_SESSION['site_id'], $_REQUEST['order_start_date'], $_REQUEST['order_end_date'], $PassShopID, true, $Site['site_default_language_id']);
$smarty->assign('ProductReport', $ProductReport);

$smarty->assign('TITLE', 'Sales Report (Payment Method)');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/sales_report_payment_method.tpl');