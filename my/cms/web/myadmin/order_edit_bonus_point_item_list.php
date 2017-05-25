<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'order');
$smarty->assign('MyJS', 'order_edit_bonus_point_item');

$MyOrder = cart::GetMyOrderInfo($_REQUEST['id']);
if ($MyOrder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_ORDER_IS_DELETED, 'order_list.php', __LINE__);
if ($MyOrder['payment_confirmed'] == 'Y')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_details.php?id=' . $_REQUEST['id'], __LINE__);
$smarty->assign('MyOrder', $MyOrder);

$BonusPointItemList = cart::GetBonusPointItemListWithOrderQuantity($Site['site_id'], $MyOrder['myorder_id'], $Site['site_default_language_id'], 99999, 'Y');
$smarty->assign('BonusPointItemList', $BonusPointItemList);

if ($MyOrder['is_handled'] == 'Y')
	$smarty->assign('CurrentTab2', 'order_handled');
elseif ($MyOrder['is_handled'] == 'N')
	$smarty->assign('CurrentTab2', 'order_not_handled');

$smarty->assign('TITLE', 'Order Details');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/order_edit_bonus_point_item_list.tpl');