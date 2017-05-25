<?php
// parameters:
//	user_id
//	offset
//	row_count
//	cart_content_type - normal / bonus_point 

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if (!in_array($_REQUEST['cart_content_type'], $ValidApiCartContentType))
	$_REQUEST['cart_content_type'] = 'normal';

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$MyOrderListXML = myorder::GetMyOrderListXML($_REQUEST['user_id'], intval($_REQUEST['offset']), intval($_REQUEST['row_count']), $_REQUEST['cart_content_type']);

$smarty->assign('Data', $MyOrderListXML);
$smarty->display('api/api_result.tpl');