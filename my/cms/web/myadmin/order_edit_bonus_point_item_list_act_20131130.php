<?php
die();

// Use new convert order function

define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'order');
$smarty->assign('MyJS', 'order_edit_bonus_point_item_list');

$MyOrder = cart::GetMyOrderInfo($_REQUEST['id']);
if ($MyOrder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_ORDER_IS_DELETED, 'order_list.php', __LINE__);
if ($MyOrder['payment_confirmed'] == 'Y')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_details.php?id=' . $_REQUEST['id'], __LINE__);

$User = user::GetUserInfo($MyOrder['user_id']);

$query  =	" 	DELETE	FROM	cart_bonus_point_item " .
			"	WHERE	user_id				= '" . intval($MyOrder['user_id']) . "' " .
			"		AND	system_admin_id		= 0 " .
			"		AND	content_admin_id	= 0 " .
			"		AND	site_id				= '" . intval($Site['site_id']) . "' " .
			"		AND	cart_content_type	= 'temp'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

foreach ($_REQUEST['quantity'] as $key => $value) {
	if ($value > 0) {
		$BonusPointItem = bonuspoint::GetBonusPointItemInfo($key, 0);
		if ($BonusPointItem['site_id'] != $_SESSION['site_id'])
			AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);
		if ($BonusPointItem['object_is_enable'] == 'N')
			AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);

		cart::AddBonusPointItemToCart($key, intval($value), $MyOrder['user_id'], 'temp', $Site['site_id'], 0, 0);
	}
}

$query =	"	DELETE FROM	myorder_bonus_point_item " . 
			"	WHERE	myorder_id	= '" . intval($MyOrder['myorder_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$TotalCash = 0;
$TotalCashCA = 0;
$TotalBonusPointRequired = 0;

$Currency = currency::GetCurrencyInfo($MyOrder['currency_id'], $Site['site_id']);
// Ignoring all security level, archive date and publish date here as this is already an order!!!!
$CartBonusPointItemList = cart::GetCartBonusPointItemList($MyOrder['user_id'], $User['user_language_id'], $Currency, $TotalCash, $TotalCashCA, $TotalBonusPointRequired, 'temp', false, false, $Site['site_id'], 0, 0, 999999);

$MyOrderID = $MyOrder['myorder_id'];
foreach($CartBonusPointItemList as $C) {
	$query  =	" 	INSERT INTO	myorder_bonus_point_item " .
				"	SET		myorder_id						= '" . intval($MyOrderID) . "', " .
				"			bonus_point_item_id				= '" . intval($C['bonus_point_item_id']) . "', " .
				"			currency_id						= '" . intval($C['currency_id']) . "', " .
				"			quantity						= '" . intval($C['quantity']) . "', " .
				"			bonus_point_required			= '" . intval($C['bonus_point_required']) . "', " .
				"			cash							= '" . doubleval($C['cash']) . "', " .
				"			cash_ca							= '" . doubleval($C['cash_ca']) . "', " .
				"			subtotal_cash					= '" . doubleval($C['subtotal_cash']) . "', " .
				"			subtotal_cash_ca				= '" . doubleval($C['subtotal_cash_ca']) . "', " .
				"			subtotal_bonus_point_required	= '" . intval($C['subtotal_bonus_point_required']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
cart::UpdateMyOrderWithNewCurrencyRate($MyOrderID);

// Empty the cart
$query  =	" 	DELETE	FROM	cart_bonus_point_item " .
			"	WHERE	user_id				= '" . $MyOrder['user_id'] . "' " .
			"		AND	system_admin_id		= 0 " .
			"		AND	content_admin_id	= 0 " .
			"		AND	site_id				= '" . $Site['site_id'] . "'" .
			"		AND	cart_content_type	= 'temp'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: order_details.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '#MyOrderTabsPanel-BonusPointDetails');