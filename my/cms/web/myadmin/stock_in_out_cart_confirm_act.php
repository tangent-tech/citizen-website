<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_inventory.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'inventory');
$smarty->assign('CurrentTab2', 'stock_in_out_cart_confirm_act');
$smarty->assign('MyJS', 'stock_in_out_cart_confirm_act');

$StockInOutCart = inventory::GetStockInOutCartInfo($Site['site_id'], $_SESSION['ContentAdminID'], $_SESSION['SystemAdminID']);

$StockInOutCartProducts = inventory::GetStockInOutCartProducts($StockInOutCart['stock_in_out_cart_id'], 0);

if (count($StockInOutCartProducts) <= 0)
	AdminDie(ADMIN_ERROR_STOCK_IN_OUT_BASKET_CONTAINS_NO_PRODUCTS, 'stock_in_out_cart_details.php', __LINE__);

$query =	"	INSERT INTO	stock_in_out " .
			"	SET		site_id						= '" . $Site['site_id'] . "', " .
			"			stock_in_out_type 			= '" . $StockInOutCart['stock_in_out_type'] . "', " .
			"			stock_in_out_date			= '" . $StockInOutCart['stock_in_out_date'] . "', " .
			"			stock_in_out_confirmed_by	= '" . $AdminInfo['email'] . "', " .
			"			stock_in_out_confirm_date	= NOW(), " .
			"			stock_in_out_vendor_name	= '" . $StockInOutCart['stock_in_out_vendor_name'] . "', " .
			"			stock_in_out_subject		= '" . $StockInOutCart['stock_in_out_subject'] . "', " .
			"			stock_in_out_note			= '" . $StockInOutCart['stock_in_out_note'] . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$StockInOutID = customdb::mysqli()->insert_id;

$query =	"	INSERT INTO	stock_transaction " .
			"	SET		site_id						= '" . $Site['site_id'] . "', " .
			"			stock_transaction_type		= '" . $StockInOutCart['stock_in_out_type'] . "', " .
			"			stock_transaction_date		= NOW(), " .
			"			stock_shipment_id			= 0, " .
			"			myorder_id					= 0, " .
			"			stock_in_out_id				= '" . intval($StockInOutID) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$StockTransactionID = customdb::mysqli()->insert_id;

foreach ($StockInOutCartProducts as $P) {
	$query =	"	INSERT INTO	stock_transaction_product " .
				"	SET		stock_transaction_id	= '" . intval($StockTransactionID) . "', " .
				"			product_id				= '" . intval($P['product_id']) . "', " .
				"			product_option_id		= '" . intval($P['product_option_id']) . "', " .
				"			product_quantity		= '" . intval($P['product_quantity']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	inventory::UpdateProductStockLevel($P['product_id'], $P['product_option_id']);
}

$query =	"	DELETE FROM	stock_in_out_cart_details " .
			"	WHERE		stock_in_out_cart_id = '" . intval($StockInOutCart['stock_in_out_cart_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	DELETE FROM	stock_in_out_cart_content " .
			"	WHERE		stock_in_out_cart_id = '" . intval($StockInOutCart['stock_in_out_cart_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

inventory::TouchStockInOutCart($Site['site_id'], $_SESSION['ContentAdminID'], $_SESSION['SystemAdminID']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: stock_transaction_list.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));