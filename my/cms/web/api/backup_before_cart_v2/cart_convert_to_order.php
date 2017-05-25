<?php
// IMPORTANT!!!!!!!!!!!!!!!!!
// Check price_calculation_change_note.txt if price calculation algorithm is modified!!!!!!!!!!!

// parameters:
//	user_id
//	order_confirmed - Y/N, default = Y
//	cart_content_type - normal / bonus_point
//	bonus_point_earned - leave blank if calculated from product

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

if (!in_array($_REQUEST['cart_content_type'], $ValidApiCartContentType))
	$_REQUEST['cart_content_type'] = 'normal';

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$BonusPointEarnedSuppliedByClient = -1;
if (isset($_REQUEST['bonus_point_earned']))
	$BonusPointEarnedSuppliedByClient = intval($_REQUEST['bonus_point_earned']);
	
$query  =	" 	UPDATE	cart_details " .
			"	SET		bonus_point_earned_supplied_by_client = '" . $BonusPointEarnedSuppliedByClient . "' " .
			"	WHERE	system_admin_id = 0 " .
			"		AND	content_admin_id = 0 " .
			"		AND	user_id = '" . $_REQUEST['user_id'] . "' " .
			"		AND	site_id = 0 " .
			"		AND	cart_content_type = '" . $_REQUEST['cart_content_type'] . "'";
$result = ave_mysql_query($query) or err_die(1, $query, mysql_error(), realpath(__FILE__), __LINE__);			

$Error = null;
if (!cart::ValidateCart($_REQUEST['user_id'], $Error, $_REQUEST['cart_content_type']))
	APIDie ($Error);

$MyOrderID = 0;

cart::CartConvertToOrder($_REQUEST['user_id'], $_REQUEST['cart_content_type'], $_REQUEST['order_confirmed'], 0, $MyOrderID);

$smarty->assign('MyOrderID', $MyOrderID);
$CartConvertToOrderXML = $smarty->fetch('api/cart_convert_to_order.tpl');

$smarty->assign('Data', $CartConvertToOrderXML);
$smarty->display('api/api_result.tpl');
?>