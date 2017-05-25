<?php
// parameters:
//	user_id

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$cart = new cart_v2(0, 0, $_REQUEST['user_id'], $Site['site_id'], 'normal');
$cart->EmptyProductCart();

$smarty->display('api/api_result.tpl');