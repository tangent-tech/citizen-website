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
$smarty->assign('MyJS', 'stock_shipment_add_act');

$MyOrder = cart::GetMyOrderInfo($_REQUEST['id']);
if ($MyOrder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
if ($MyOrder['payment_confirmed'] == 'N')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);
$smarty->assign('MyOrder', $MyOrder);

if ($MyOrder['payment_confirmed'] != 'Y' || ($MyOrder['order_status'] != 'payment_confirmed' && $MyOrder['order_status'] != 'partial_shipped'))
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);

$LockName = "369cms.stock_shipment_op";
$myLock = new mylock($LockName);
$myLock->acquireLock(true);

$StockTransaction = inventory::GetStockHoldTransactionInfoForMyOrder($MyOrder['myorder_id']);
$StockTransactionProducts = inventory::GetStockTransactionProducts($StockTransaction['stock_transaction_id'], $Site['site_default_language_id']);

$IsAllRequestZero = true;
$IsAllShipmentCompleted = true;
$OrderStatus = '';

foreach ($StockTransactionProducts as $P) {
	$RequestQuantity = $_REQUEST['product_quantity_' . $P['product_id'] . '_' . $P['product_option_id']];	
	if ($RequestQuantity > abs($P['product_quantity']) || $RequestQuantity < 0)
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'stock_shipment_add.php?id=' . $MyOrder['myorder_id'], __LINE__);
	if ($RequestQuantity > 0)
		$IsAllRequestZero = false;
	if (abs($P['product_quantity']) > $RequestQuantity)
		$IsAllShipmentCompleted = false;
}
if ($IsAllRequestZero)
	AdminDie(ADMIN_ERROR_ALL_PRODUCT_QUANTITY_IS_ZERO, 'stock_shipment_add.php?id=' . $MyOrder['myorder_id'], __LINE__);

$query =	"	INSERT INTO	stock_shipment " .
			"	SET		myorder_id					= '" . $MyOrder['myorder_id'] . "', " .
			"			user_id						= '" . $MyOrder['user_id'] . "', " .
			"			site_id						= '" . $MyOrder['site_id'] . "', " .
			"			shipment_country_id			= '" . intval($_REQUEST['shipment_country_id']) . "', " .
			"			shipment_hk_district_id		= '" . intval($_REQUEST['shipment_hk_district_id']) . "', " .
			"			shipment_first_name			= '" . aveEscT($_REQUEST['shipment_first_name']) . "', " .
			"			shipment_last_name			= '" . aveEscT($_REQUEST['shipment_last_name']) . "', " .
			"			shipment_company_name		= '" . aveEscT($_REQUEST['shipment_company_name']) . "', " .
			"			shipment_city_name			= '" . aveEscT($_REQUEST['shipment_city_name']) . "', " .
			"			shipment_region				= '" . aveEscT($_REQUEST['shipment_region']) . "', " .
			"			shipment_postcode			= '" . aveEscT($_REQUEST['shipment_postcode']) . "', " .
			"			shipment_phone_no			= '" . aveEscT($_REQUEST['shipment_phone_no']) . "', " .
			"			shipment_tel_country_code	= '" . aveEscT($_REQUEST['shipment_tel_country_code']) . "', " .
			"			shipment_tel_area_code		= '" . aveEscT($_REQUEST['shipment_tel_area_code']) . "', " .
			"			shipment_fax_no				= '" . aveEscT($_REQUEST['shipment_fax_no']) . "', " .
			"			shipment_fax_country_code	= '" . aveEscT($_REQUEST['shipment_fax_country_code']) . "', " .
			"			shipment_fax_area_code		= '" . aveEscT($_REQUEST['shipment_fax_area_code']) . "', " .
			"			shipment_shipping_address_1	= '" . aveEscT($_REQUEST['shipment_shipping_address_1']) . "', " .
			"			shipment_shipping_address_2	= '" . aveEscT($_REQUEST['shipment_shipping_address_2']) . "', " .
			"			shipment_email				= '" . aveEscT($_REQUEST['shipment_email']) . "', " .
			"			shipment_delivery_date		= '" . aveEscT($_REQUEST['shipment_delivery_date']) . "', " .
			"			stock_shipment_confirm_by	= '" . aveEscT($AdminInfo['email']) . "', " .
			"			stock_shipment_confirm_date	= NOW(), " .
			"			shipment_user_reference				= '" . aveEscT($_REQUEST['shipment_user_reference']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$StockShipmentID = customdb::mysqli()->insert_id;

$query =	"	INSERT INTO	stock_transaction " .
			"	SET		site_id					= '" . intval($_SESSION['site_id']) . "', " .
			"			stock_transaction_type	= 'SHIPMENT', " .
			"			stock_transaction_date	= NOW(), " .
			"			stock_shipment_id		= '" . intval($StockShipmentID) . "', " .
			"			myorder_id				= '" . intval($MyOrder['myorder_id']) . "', " .
			"			stock_in_out_id			= 0 ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$ShipmentStockTransactionID = customdb::mysqli()->insert_id;

foreach ($StockTransactionProducts as $P) {
	$RequestQuantity = $_REQUEST['product_quantity_' . $P['product_id'] . '_' . $P['product_option_id']];
	
	$NewStockHoldQuantity = $P['product_quantity'] + $RequestQuantity;
	
	if ($NewStockHoldQuantity == 0) {
		$query =	"	DELETE FROM	stock_transaction_product " .
					"	WHERE		stock_transaction_product_id = '" . intval($P['stock_transaction_product_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	elseif ($NewStockHoldQuantity < 0) {
		$query =	"	UPDATE	stock_transaction_product " .
					"	SET		product_quantity = " . intval($NewStockHoldQuantity) .
					"	WHERE	stock_transaction_product_id = '" . intval($P['stock_transaction_product_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	
	$query =	"	INSERT INTO	stock_transaction_product " .
				"	SET		stock_transaction_id	= '" . intval($ShipmentStockTransactionID) . "', " .
				"			product_id				= '" . intval($P['product_id']) . "', " .
				"			product_option_id		= '" . intval($P['product_option_id']) . "', " .
				"			product_quantity		= '-" . intval($RequestQuantity) . "' ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	inventory::UpdateProductStockLevel($P['product_id'], $P['product_option_id']);
}

unset($myLock);

if ($IsAllShipmentCompleted) {
	inventory::DeleteStockTransaction($StockTransaction['stock_transaction_id']);
	$OrderStatus = 'shipped';
}
else
	$OrderStatus = 'partial_shipped';

$query =	"	UPDATE	myorder " .
			"	SET		order_status			= '" . aveEscT($OrderStatus) . "', " .
			"			shipment_confirm_by		= '" . aveEscT($AdminInfo['email']) . "', " .
			"			shipment_confirm_date	= NOW() " .
			"	WHERE	myorder_id = '" . intval($MyOrder['myorder_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

if (trim($Site['site_order_status_change_callback_url']) != '') {
	$URL = trim($Site['site_order_status_change_callback_url']) . '?order_id=' . $_REQUEST['id'] . '&status=' . $OrderStatus . '&shipment_id=' . $StockShipmentID;
	
	$Para = array();
	$Para['id_1'] = $_REQUEST['id'];
	$Para['id_2'] = $StockShipmentID;
	$Para['string_1'] = $OrderStatus;
	
	site::CallbackExec($Site, $URL, $Para);
}

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: order_details.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '#MyOrderTabsPanel-Shipment');