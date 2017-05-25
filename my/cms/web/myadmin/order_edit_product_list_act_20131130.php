<?php
die();

// Use convert_to_order function to recalculate now

// IMPORTANT!!!!!!!!!!!!!!!!!
// Check price_calculation_change_note.txt if price calculation algorithm is modified!!!!!!!!!!!

define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'order');
$smarty->assign('MyJS', 'order_edit_product_list');

$MyOrder = cart::GetMyOrderInfo($_REQUEST['id']);
if ($MyOrder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_ORDER_IS_DELETED, 'order_list.php', __LINE__);
if ($MyOrder['payment_confirmed'] == 'Y')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_details.php?id=' . $_REQUEST['id'], __LINE__);

$User = user::GetUserInfo($MyOrder['user_id']);

$query =	"	INSERT INTO	cart_details " .
			"	SET		effective_base_price_id = '" . $MyOrder['effective_base_price_id']. "', " .
			"			discount_code = '" . $MyOrder['discount_code'] . "', " .
			"			system_admin_id = 0, " .
			"			content_admin_id = 0, " .
			"			user_id = '" . $MyOrder['user_id'] . "'" .
			"	ON DUPLICATE KEY UPDATE effective_base_price_id = '" . $MyOrder['effective_base_price_id']. "', " .
			"							discount_code = '" . $MyOrder['discount_code'] . "' ";
$result = ave_mysql_query($query) or err_die(1, $query, mysql_error(), realpath(__FILE__), __LINE__);


$TotalQuantity = array();
if (count($_REQUEST['quantity']) > 0) {
	cart::EmptyProductCart($MyOrder['user_id'], 'temp', 0, 0, 0);

	foreach ($_REQUEST['quantity'] as $key => $value) {
		$TotalQuantity[ $_REQUEST['product_id'][$key] . "_" . $_REQUEST['product_option_id'][$key] ] =
			intval($TotalQuantity[ $_REQUEST['product_id'][$key] . "_" . $_REQUEST['product_option_id'][$key] ]) + intval($value);
	}

	foreach ($TotalQuantity as $key => $value) {
		list($ProductID, $ProductOptionID) = explode("_", $key);

		if ($value > 0) {
			$Product = product::GetProductInfo($ProductID, $Site['site_default_language_id']);
			if ($Product['site_id'] != $_SESSION['site_id'])
				AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);
			if ($Product['object_is_enable'] == 'N')
				AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);
			if ( $ProductOptionID == 0 && product::IsProductOptionExist($ProductID) )
				AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);

			cart::AddProductToCart($ProductID, intval($value), $MyOrder['user_id'], $ProductOptionID, 'temp', $Site['site_id'], 0, 0);
		}
	}
}

inventory::UnholdStockForMyOrder($_REQUEST['id']);

$query =	"	DELETE FROM	myorder_product " .
			"	WHERE	myorder_id	= '" . $MyOrder['myorder_id'] . "'";
$result = ave_mysql_query($query) or err_die(1, $query, mysql_error(), realpath(__FILE__), __LINE__);

$TotalPrice = 0;
$TotalPriceCA = 0;
$TotalListedPrice = 0;
$TotalListedPriceCA = 0;
$TotalBonusPoint = 0;
$ContinueProcessPostRule = true;

$OrderStatus = $MyOrder['order_status'];

$Currency = currency::GetCurrencyInfo($MyOrder['currency_id'], $Site['site_id']);

// Ignoring all security level, archive date and publish date here as this is already an order!!!!
$CartItemList = cart::GetCartItemList($MyOrder['user_id'], $User['user_language_id'], $Currency, $TotalListedPrice, $TotalListedPriceCA, $TotalPrice, $TotalPriceCA, $TotalBonusPoint, $ContinueProcessPostRule, 'temp', false, false, $Site['site_id'], 0, 0, 999999);

$MyOrderID = $MyOrder['myorder_id'];
foreach($CartItemList as $C) {
	$query  =	" 	INSERT INTO	myorder_product " .
				"	SET		myorder_id								= '" . $MyOrderID . "', " .
				"			product_id								= '" . intval($C['product_id']) . "', " .
				"			currency_id								= '" . intval($MyOrder['currency_id']) . "', " .
				"			product_base_price						= '" . doubleval($C['product_base_price']) . "', " .
				"			product_base_price_ca					= '" . doubleval($C['product_base_price_ca']) . "', " .
				"			product_price							= '" . doubleval($C['product_price']) . "', " .
				"			product_price_ca						= '" . doubleval($C['product_price_ca']) . "', " .
				"			product_price2							= '" . doubleval($C['product_price2']) . "', " .
				"			product_price2_ca						= '" . doubleval($C['product_price2_ca']) . "', " .
				"			product_price3							= '" . doubleval($C['product_price3']) . "', " .
				"			product_price3_ca						= '" . doubleval($C['product_price3_ca']) . "', " .
				"			product_bonus_point_amount				= '" . intval($C['product_bonus_point_amount']) . "', " .
				"			actual_subtotal_price					= '" . doubleval($C['actual_subtotal_price']) . "', " .
				"			actual_subtotal_price_ca				= '" . doubleval($C['actual_subtotal_price_ca']) . "', " .
				"			actual_unit_price						= '" . doubleval($C['actual_unit_price']) . "', " .
				"			actual_unit_price_ca					= '" . doubleval($C['actual_unit_price_ca']) . "', " .
				"			quantity								= '" . intval($C['quantity']) . "', " .
				"			effective_discount_type					= '" . intval($C['effective_discount_type']) . "', " .
				"			effective_discount_preprocess_rule_id	= '" . intval($C['effective_discount_preprocess_rule_id']) . "', " .
				"			discount1_off_p							= '" . intval($C['discount1_off_p']) . "', " .
				"			discount2_amount						= '" . intval($C['discount2_amount']) . "', " .
				"			discount2_price							= '" . doubleval($C['discount2_price']) . "', " .
				"			discount2_price_ca						= '" . doubleval($C['discount2_price_ca']) . "', " .
				"			discount3_buy_amount					= '" . intval($C['discount3_buy_amount']) . "', " .
				"			discount3_free_amount					= '" . intval($C['discount3_free_amount']) . "', " .
				"			product_option_id						= '" . intval($C['product_option_id']) . "' ";
	$result = ave_mysql_query($query) or die($query . " " . mysql_error() . " " . realpath(__FILE__) . " " . __LINE__);
}

// This will update the postprocess rule!
cart::UpdateMyOrderWithNewCurrencyRate($MyOrderID, $ContinueProcessPostRule);

// Empty the cart
cart::EmptyProductCart($MyOrder['user_id'], 'temp', $Site['site_id'], 0, 0);

if ($Site['site_module_inventory_enable'] == 'Y' && $OrderStatus == 'payment_pending') {
	if ($Site['site_auto_hold_stock_status'] == 'payment_pending') {
		inventory::HoldStockForMyOrder($Site['site_id'], $MyOrderID);

		site::EmptyAPICache($Site['site_id']);
	}
}

header( 'Location: order_details.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '#MyOrderTabsPanel-Pricing');
?>
