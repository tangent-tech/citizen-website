<?php
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

cart::ConvertOrderToTempCart($_REQUEST['id']);

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

$NewOrderID = null;
cart::CartConvertToOrder($MyOrder['user_id'], 'temp', $MyOrder['order_confirmed'], $MyOrder['myorder_id'], $NewOrderID);

header( 'Location: order_details.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '#MyOrderTabsPanel-BonusPointDetails');