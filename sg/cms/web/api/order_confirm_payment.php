<?php
// parameters:
//	myorder_id
//	currency_id
//	paid_amount_ca
//	payment_confirm_by - Payment Gateway Name
//	reference_1 - Payment Gateway parameter info
//	reference_2
//	reference_3
//	bonus_point_earned
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$MyOrder = new myorder($_REQUEST['myorder_id']);

if ($MyOrder->getMyOrderDetailsObj()->site_id != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if ($MyOrder->getMyOrderDetailsObj()->currency_id != $_REQUEST['currency_id'])
	APIDie($API_ERROR['API_ERROR_ORDER_CURRENCY_ID_MISMATCH']);

if ($MyOrder->getMyOrderDetailsObj()->pay_amount_ca != $_REQUEST['paid_amount_ca'])
	APIDie($API_ERROR['API_ERROR_ORDER_PAY_AMOUNT_MISMATCH']);

$BonusPointEarned = null;
if (isset($_REQUEST['bonus_point_earned']))
	$BonusPointEarned = intval($_REQUEST['bonus_point_earned']);

$ErrorCode = '';
if (!$MyOrder->ConfirmPayment($ErrorCode, "API: " . $_REQUEST['payment_confirm_by'], $_REQUEST['reference_1'], $_REQUEST['reference_2'], $_REQUEST['reference_3'], $BonusPointEarned) )
	APIDie($API_ERROR[$ErrorCode]);

$smarty->display('api/api_result.tpl');