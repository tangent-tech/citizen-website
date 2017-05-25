<?php
// parameters:
//	user_id
//	product_id
//	product_qty
//	product_option_id

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

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

cart::UpdateProductCart($_REQUEST['product_id'], intval($_REQUEST['product_qty']), $_REQUEST['user_id'], $_REQUEST['product_option_id'], 'normal', $Site['site_id'], 0, 0);

$smarty->display('api/api_result.tpl');
?>