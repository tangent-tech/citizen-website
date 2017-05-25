<?php
// parameters:
//	user_id
//	lang_id
//	currency_id
//	cart_content_type - normal / bonus_point 
//	effective_base_price_id - default: 1, MUST SET TO 0 if different product_price_id is in use

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

$cart = new cart_v2(0, 0, $_REQUEST['user_id'], $Site['site_id'], 'normal', $_REQUEST['lang_id']);
$cart->TouchCart();
$cart->getCartDetailsObj()->currency_id = $_REQUEST['currency_id'];
if (!isset($_REQUEST['effective_base_price_id']))
	$_REQUEST['effective_base_price_id'] = 1;
$cart->getCartDetailsObj()->effective_base_price_id = $_REQUEST['effective_base_price_id'];
$cart->UpdateCartDetailsFromObj();

$smarty->assign('Data', $cart->GetCartXML());
$smarty->display('api/api_result.tpl');