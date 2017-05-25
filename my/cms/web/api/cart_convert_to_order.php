<?php
// IMPORTANT!!!!!!!!!!!!!!!!!
// Check price_calculation_change_note.txt if price calculation algorithm is modified!!!!!!!!!!!

// parameters:
//	user_id
//	order_confirmed - Y/N, default = Y
//	cart_content_type - normal / bonus_point
//	bonus_point_earned - leave blank if calculated from product
//	terminal_id - default 0

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

$BonusPointEarnedSuppliedByClient = -1;
if (isset($_REQUEST['bonus_point_earned']))
	$BonusPointEarnedSuppliedByClient = intval($_REQUEST['bonus_point_earned']);
$cart->getCartDetailsObj()->bonus_point_earned_supplied_by_client = $BonusPointEarnedSuppliedByClient;
$cart->UpdateCartDetailsFromObj();
$cart->processCart();

if (!$cart->is_cart_valid_to_convert_order)
	APIDie ($API_ERROR[$cart->error_msg]);

$MyOrderID = 0;

$cart->CartConvertToOrder($_REQUEST['order_confirmed'], 0, $MyOrderID, SHOP_ID, intval($_REQUEST['terminal_id']));

$smarty->assign('MyOrderID', $MyOrderID);
$CartConvertToOrderXML = $smarty->fetch('api/cart_convert_to_order.tpl');

$smarty->assign('Data', $CartConvertToOrderXML);
$smarty->display('api/api_result.tpl');