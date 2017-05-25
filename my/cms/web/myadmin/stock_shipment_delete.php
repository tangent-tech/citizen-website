<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_inventory.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'inventory');
$smarty->assign('CurrentTab2', 'stock_transaction_list');
$smarty->assign('MyJS', 'stock_transaction_delete');

$StockTransaction = inventory::GetStockTransactionInfo($_REQUEST['id']);
if ($StockTransaction['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'stock_transaction_list.php', __LINE__);

if ($StockTransaction['stock_transaction_type'] != 'SHIPMENT')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'stock_transaction_list.php', __LINE__);

$LockName = "369cms.stock_shipment_op";
$myLock = new mylock($LockName);
$myLock->acquireLock(true);

$MyOrder = cart::GetMyOrderInfo($StockTransaction['myorder_id']);
if ($MyOrder != null) {
	$StockHoldTransaction = inventory::GetStockHoldTransactionInfoForMyOrder($StockTransaction['myorder_id']);
	
	if ($StockHoldTransaction == null) {
		$query =	"	INSERT INTO	stock_transaction" .
					"	SET		site_id					= '" . intval($_SESSION['site_id']) . "', " .
					"			stock_transaction_type	= 'STOCK_HOLD', " .
					"			stock_transaction_date	= NOW(), " .
					"			stock_shipment_id 		= 0, " .
					"			myorder_id 				= '" . intval($StockTransaction['myorder_id']) . "', " .
					"			stock_in_out_id 			= 0 " .
					"	ON DUPLICATE KEY UPDATE site_id = '" . intval($_SESSION['site_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$StockHoldTransaction = inventory::GetStockHoldTransactionInfoForMyOrder($StockTransaction['myorder_id']);
	}
	
	$StockTransactionProducts = inventory::GetStockTransactionProducts($StockTransaction['stock_transaction_id'], $Site['site_default_language_id']);
	
	foreach ($StockTransactionProducts as $P) {
		$query =	"	INSERT INTO	stock_transaction_product " .
					"	SET		stock_transaction_id	= '" . $StockHoldTransaction['stock_transaction_id'] . "', " .
					"			product_id				= '" . $P['product_id'] . "', " .
					"			product_option_id 		= '" . $P['product_option_id'] . "', " .
					"			product_quantity		= '" . $P['product_quantity'] . "'" .
					"	ON DUPLICATE KEY UPDATE product_quantity = product_quantity + '" . $P['product_quantity'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}
inventory::DeleteStockTransaction($_REQUEST['id']);

$TotalTransactions = 0;
$StockShipmentList = inventory::GetStockTransactionList($_SESSION['site_id'], $TotalTransactions, 1, 1, 'SHIPMENT');

if ($TotalTransactions == 0) {
	$query =	"	UPDATE		myorder " .
				"	SET			order_status =	'payment_confirmed' " .
				"	WHERE		myorder_id = '" . intval($StockTransaction['myorder_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
else {
	$query =	"	UPDATE		myorder " .
				"	SET			order_status =	'partial_shipped' " .
				"	WHERE		myorder_id = '" . intval($StockTransaction['myorder_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

unset($myLock);

site::EmptyAPICache($_SESSION['site_id']);
header( 'Location: order_details.php?id=' . $StockTransaction['myorder_id'] . 'SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage) . '#MyOrderTabsPanel-Shipment');