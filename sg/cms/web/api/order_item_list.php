<?php
// parameters:
//	user_id
//	page_no
//	items_per_page
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$UserMyOrderItemListXML = myorder::GetUserMyOrderItemListXML($_REQUEST['user_id'], intval($_REQUEST['page_no']), intval($_REQUEST['items_per_page']));

$smarty->assign('Data', $UserMyOrderItemListXML);
$smarty->display('api/api_result.tpl');