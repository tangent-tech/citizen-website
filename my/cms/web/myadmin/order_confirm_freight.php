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

if ($MyOrder['order_status'] != 'awaiting_freight_quote')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);

$query =	"	UPDATE		myorder " .
			"	SET			order_status	=	'awaiting_order_confirmation' " .
			"	WHERE		myorder_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

if (trim($Site['site_order_status_change_callback_url']) != '') {
	$OrderStatus = 'freight_quoted';
	$URL = trim($Site['site_order_status_change_callback_url']) . '?order_id=' . $_REQUEST['id'] . '&status=' . $OrderStatus;
	
	$Para = array();
	$Para['id_1'] = $_REQUEST['id'];
	$Para['string_1'] = $OrderStatus;
	
	site::CallbackExec($Site, $URL, $Para);
}

header( 'Location: order_details.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));