<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'order');

$MyOrder = cart::GetMyOrderInfo($_REQUEST['id']);
if ($MyOrder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);
$smarty->assign('MyOrder', $MyOrder);

if ($MyOrder['payment_confirmed'] == 'Y' || $MyOrder['order_status'] != 'payment_pending')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);

$UserBalanceLock = user::GetUserBalanceLock($MyOrder['user_id']);
$UserBalanceLock->acquireLock(true);

$User = user::GetUserInfo($MyOrder['user_id']);

$BonusPointCanBeUsed = 0;
if ($Site['site_use_bonus_point_at_once'] == 'Y')
	$BonusPointCanBeUsed = $User['user_bonus_point'] + $MyOrder['bonus_point_earned'];
else
	$BonusPointCanBeUsed = $User['user_bonus_point'];

if ($MyOrder['bonus_point_redeemed'] > $BonusPointCanBeUsed)
	AdminDie(ADMIN_ERROR_NOT_ENOUGH_BONUS_POINT_TO_PROCEED_ORDER, 'order_details.php?id=' . $_REQUEST['id'], __LINE__);

if ($MyOrder['user_balance_used'] > $User['user_balance'])
	AdminDie(ADMIN_ERROR_NOT_ENOUGH_BALANCE_TO_PROCEED_ORDER, 'order_details.php?id=' . $_REQUEST['id'], __LINE__);

if ($Site['site_module_inventory_enable'] == 'Y') {
	if ($Site['site_product_allow_under_stock'] == 'N' && inventory::IsMyOrderUnderStock($Site, $_REQUEST['id']))
		AdminDie(ADMIN_ERROR_MYORDER_UNDER_STOCK, 'order_details.php?id=' . $_REQUEST['id'], __LINE__);
	
	if ($Site['site_auto_hold_stock_status'] == 'payment_confirmed' || $Site['site_auto_hold_stock_status'] == 'payment_pending') {
		inventory::HoldStockForMyOrder($Site['site_id'], $_REQUEST['id']);

		site::EmptyAPICache($Site['site_id']);
	}
}
elseif ($Site['site_module_inventory_partial_shipment'] == 'Y') {
	inventory::HoldStockForMyOrder($Site['site_id'], $_REQUEST['id']);
	site::EmptyAPICache($Site['site_id']);
}

$UserBalancePrevious = $User['user_balance'];
$UserBalanceAfter = $User['user_balance'] - $MyOrder['user_balance_used'];

// Deduce user_balance here!
if (doubleval($MyOrder['user_balance_used']) > 0) {
	
	$query  =	" 	INSERT INTO	 user_balance " .
				"	SET		myorder_id				=	'" . intval($MyOrder['myorder_id']) . "', " .
				"			user_id					=	'" . intval($User['user_id']) . "', " .
				"			user_balance_previous	=	'" . doubleval($UserBalancePrevious) . "', " .
				"			user_balance_after		=	'" . doubleval($UserBalanceAfter) . "', " .
				"			user_balance_transaction_amount = '" . (doubleval($MyOrder['user_balance_used']) * -1) . "', " .
				"			user_balance_transaction_type	= 'uorder', " .
				"			create_date 		= NOW()";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
unset($UserBalanceLock);

$query =	"	UPDATE		myorder " .
			"	SET			bonus_point_previous	=	'" . intval($User['user_bonus_point']) . "', " .
			"				bonus_point_canbeused	=	'" . intval($BonusPointCanBeUsed) . "', " .
			"				bonus_point_balance		=	'" . intval($User['user_bonus_point'] + $MyOrder['bonus_point_earned'] - $MyOrder['bonus_point_redeemed']) . "', " .
			"				user_balance_previous	=	'" . doubleval($UserBalancePrevious) . "', " .
			"				user_balance_after		=	'" . doubleval($UserBalanceAfter) . "', " .
			"				payment_confirmed		=	'Y', " .
			"				order_status			=	'payment_confirmed', " .
			"				payment_confirm_by		=	'" . aveEscT($AdminInfo['email']) . "', " .
			"				payment_confirm_date	=	NOW() " .
			"	WHERE		myorder_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

if ($MyOrder['bonus_point_earned'] > 0) {
	$query  =	" 	INSERT INTO	user_bonus_point " .
				"	SET		myorder_id			=	'" . intval($_REQUEST['id']) . "', " .
				"			user_id				=	'" . intval($User['user_id']) . "', " .
				"			bonus_point_amount_previous	=	'" . intval($User['user_bonus_point']) . "', " .
				"			bonus_point_amount_after	=	'" . intval($User['user_bonus_point'] + $MyOrder['bonus_point_earned']) . "', " .
				"			bonus_point_earned	=	'" . intval($MyOrder['bonus_point_earned']) . "', " .
				"			bonus_point_used	= 0, " .
				"			earn_type			= 'uorder', " .
				"			create_date 		= NOW(), " .
				"			expiry_date			= '" . aveEscT(custom::GetBonusPointExpiryDate($Site, time())) . "', " . 			
//				"			expiry_date			= DATE_ADD(NOW(), INTERVAL ". $Site['site_bonus_point_valid_days'] ." DAY), " .
				"			bonus_point_reason	= 'uorder' ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

user::DeduceUserBonusPoint($User['user_id'], $MyOrder['bonus_point_redeemed'], $_REQUEST['id'], 'uorder', '', 0, 0);

cart::UpdateMyOrderProductQuantitySold($_REQUEST['id']);
site::EmptyAPICache($Site['site_id']);

if (trim($Site['site_order_status_change_callback_url']) != '') {
	$OrderStatus = 'payment_confirmed';
	$URL = trim($Site['site_order_status_change_callback_url']) . '?order_id=' . $_REQUEST['id'] . '&status=' . $OrderStatus;
	
	$Para = array();
	$Para['id_1'] = $_REQUEST['id'];
	$Para['string_1'] = $OrderStatus;
	
	site::CallbackExec($Site, $URL, $Para);
}

header( 'Location: order_details.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));