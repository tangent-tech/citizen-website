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
$smarty->assign('MyJS', 'stock_in_out_rollback');

$StockTransaction = inventory::GetStockTransactionInfo($_REQUEST['id']);
if ($StockTransaction['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'stock_transaction_list.php', __LINE__);
$StockTransactionProducts = inventory::GetStockTransactionProducts($_REQUEST['id'], 0);

inventory::TouchStockInOutCart($Site['site_id'], $_SESSION['ContentAdminID'], $_SESSION['SystemAdminID']);
$StockInOutCart = inventory::GetStockInOutCartInfo($Site['site_id'], $_SESSION['ContentAdminID'], $_SESSION['SystemAdminID']);
inventory::EmptyStockInOutCart($StockInOutCart['stock_in_out_cart_id']);

$query =	"	UPDATE	stock_in_out_cart_details " .
			"	SET		stock_in_out_type 			= '" . $StockTransaction['stock_in_out_type'] . "', " .
			"			stock_in_out_date			= '" . $StockTransaction['stock_in_out_date'] . "', " .
			"			stock_in_out_vendor_name	= '" . $StockTransaction['stock_in_out_vendor_name'] . "', " .
			"			stock_in_out_subject		= '" . $StockTransaction['stock_in_out_subject'] . "', " .
			"			stock_in_out_note			= '" . $StockTransaction['stock_in_out_note'] . "' " .
			"	WHERE	stock_in_out_cart_id 		= '" . $StockInOutCart['stock_in_out_cart_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

foreach ($StockTransactionProducts as $P) {
	inventory::AddToStockInOutCart($StockInOutCart['stock_in_out_cart_id'], $P['product_id'], $P['product_option_id'], $P['product_quantity']);
}

inventory::DeleteStockTransaction($StockTransaction['stock_transaction_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: stock_in_out_cart_details.php?SystemMessage=' . urlencode(ADMIN_MSG_ROLLBACK_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));