<?php
// parameters:
//	myorder_id
//	confirm_by
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$MyOrder = new myorder($_REQUEST['myorder_id']);
if ($MyOrder->getMyOrderDetailsObj()->site_id != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if (!$MyOrder->ConfirmOrder($ErrorCode, $_REQUEST['confirm_by']))
	APIDie($API_ERROR[$ErrorCode]);

$smarty->display('api/api_result.tpl');