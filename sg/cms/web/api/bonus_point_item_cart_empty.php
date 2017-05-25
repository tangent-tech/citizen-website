<?php
// parameters:
//	user_id
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

$cart = new cart_v2(0, 0, $_REQUEST['user_id'], $Site['site_id'], $_REQUEST['cart_content_type']);
$cart->EmptyBonusPointItemCart();

$smarty->display('api/api_result.tpl');