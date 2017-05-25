<?php
// parameters:
//	user_id
//	product_id
//	product_qty
//	product_option_id
//	product_price_id - default = 1
//	cart_content_custom_key
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$Product = product::GetProductInfo($_REQUEST['product_id'], 0);
if ($Product['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);
if ($Product['object_is_enable'] == 'N')
	APIDie($API_ERROR['API_ERROR_PRODUCT_IS_DISABLED']);

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if (intval($_REQUEST['product_price_id']) <= 0)
	$_REQUEST['product_price_id'] = 1;

$cart = new cart_v2(0, 0, $_REQUEST['user_id'], $Site['site_id'], 'normal');
$cart->RemoveProductFromCart($_REQUEST['product_id'], intval($_REQUEST['product_qty']), intval($_REQUEST['product_option_id']), $_REQUEST['product_price_id'], $_REQUEST['cart_content_custom_key']);

$smarty->display('api/api_result.tpl');