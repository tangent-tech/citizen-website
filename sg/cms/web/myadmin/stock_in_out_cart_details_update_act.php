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

$DateText = $_REQUEST['stock_in_out_date'] . " " . $_REQUEST['Time_Hour'] . ":" . $_REQUEST['Time_Minute'];

inventory::TouchStockInOutCart($Site['site_id'], $_SESSION['ContentAdminID'], $_SESSION['SystemAdminID']);
$StockInOutCart = inventory::GetStockInOutCartInfo($Site['site_id'], $_SESSION['ContentAdminID'], $_SESSION['SystemAdminID']);

$query =	"	UPDATE	stock_in_out_cart_details " .
			"	SET		stock_in_out_type 			= '" . aveEscT($_REQUEST['stock_in_out_type']) . "', " .
			"			stock_in_out_date			= '" . aveEscT($DateText) . "', " .
			"			stock_in_out_vendor_name	= '" . aveEscT($_REQUEST['stock_in_out_vendor_name']) . "', " .
			"			stock_in_out_subject		= '" . aveEscT($_REQUEST['stock_in_out_subject']) . "', " .
			"			stock_in_out_note			= '" . aveEscT($_REQUEST['stock_in_out_note']) . "' " .
			"	WHERE	stock_in_out_cart_id 		= '" . intval($StockInOutCart['stock_in_out_cart_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

foreach ($_REQUEST as $key => $value) {
	if (strpos($key, 'product_quantity') !== false) {
		list($dummy, $product_id, $product_option_id) = explode("-", $key);
		
		$Product = product::GetProductInfo($product_id, 0);
		if ($Product['site_id'] != $_SESSION['site_id'])
			AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'stock_in_out_cart_details.php', __LINE__);
		
		if ($product_option_id != 0) {
			$ProductOption = product::GetProductOptionInfo($product_option_id, 0);
			if ($ProductOption['site_id'] != $_SESSION['site_id'])
				AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'stock_in_out_cart_details.php', __LINE__);
		}
		
		inventory::AddToStockInOutCart($StockInOutCart['stock_in_out_cart_id'], $product_id, $product_option_id, $value);
	}
}

if ($_REQUEST['is_confirm_stock_in_out'] == 'Y') {
	require_once('stock_in_out_cart_confirm_act.php');
	exit();
}

header( 'Location: stock_in_out_cart_details.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));