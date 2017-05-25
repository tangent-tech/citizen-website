<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'order');
$smarty->assign('MyJS', 'order_void');

$MyOrder = new myorder($_REQUEST['id']);

if ($MyOrder->getMyOrderDetailsObj()->site_id != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);

if (!$MyOrder->VoidOrder($ErrorMsg, $_SESSION['SystemAdminID'], $_SESSION['ContentAdminID'])) {
	AdminDie($ErrorMsg, 'order_list.php', __LINE__);
}

if (trim($Site['site_order_status_change_callback_url']) != '') {
	$OrderStatus = 'void';
	$URL = trim($Site['site_order_status_change_callback_url']) . '?order_id=' . $_REQUEST['id'] . '&status=' . $OrderStatus;
	
	$Para = array();
	$Para['id_1'] = $_REQUEST['id'];
	$Para['string_1'] = $OrderStatus;
	
	site::CallbackExec($Site, $URL, $Para);
}

header( 'Location: order_list.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));