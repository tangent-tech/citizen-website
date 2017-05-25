<?php
// parameters:
//	user_id
//	product_id
//	product_qty
//	product_option_id
//	product_price_id
//	cart_content_custom_key
//	cart_content_custom_desc

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

if ( intval($_REQUEST['product_option_id']) == 0 && product::IsProductOptionExist($_REQUEST['product_id']))
	APIDie($API_ERROR['API_ERROR_PRODUCT_IS_DISABLED']);
	
$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

/*
if ($Site['site_module_inventory_enable'] == 'Y') {
	if ($Site['site_product_allow_under_stock'] == 'N' && inventory::IsProductUnderStock($Site, $_REQUEST['product_id'], $_REQUEST['product_option_id'], $_REQUEST['product_qty']))
		APIDie($API_ERROR['API_ERROR_PRODUCT_UNDER_STOCK']);
}
*/	

if (intval($_REQUEST['product_price_id']) <= 0)
	$_REQUEST['product_price_id'] = 1;

$cart = new cart_v2(0, 0, $_REQUEST['user_id'], $Site['site_id'], 'normal');
$cart->TouchCart();
$cart->AddProductToCart($_REQUEST['product_id'], intval($_REQUEST['product_qty']), intval($_REQUEST['product_option_id']), intval($_REQUEST['product_price_id']), trim($_REQUEST['cart_content_custom_key']), trim($_REQUEST['cart_content_custom_desc']));

$smarty->display('api/api_result.tpl');