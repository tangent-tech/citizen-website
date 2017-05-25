<?php
// parameters:
//	user_id
//	lang_id
//	currency_id
//	cart_content_type - normal / bonus_point 
//	effective_base_price_id

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

$CartQuantityAdjusted = false;

$QuantityAdjustedCartContentIDArray = array();

if ($Site['site_module_inventory_enable'] == 'Y') {
	if ($Site['site_product_allow_under_stock'] == 'N')
		$CartQuantityAdjusted = inventory::FixCartWithInventoryLevel($Site, $_REQUEST['user_id'], $QuantityAdjustedCartContentIDArray);
}
$smarty->assign('CartQuantityAdjusted', $CartQuantityAdjusted);

cart::TouchCart($User['user_id'], $Site['site_id'], $_REQUEST['cart_content_type']);

if (intval($_REQUEST['effective_base_price_id']) >=1 && intval($_REQUEST['effective_base_price_id']) <= 3) {
	$query  =	" 	UPDATE	cart_details " .
				"	SET		effective_base_price_id = '" . intval($_REQUEST['effective_base_price_id']) . "' " .
				"	WHERE	user_id				= '" . $_REQUEST['user_id'] . "'" .
				"		AND	site_id				= '" . $Site['site_id'] . "'" .
				"		AND	cart_content_type	= '" . $_REQUEST['cart_content_type'] . "' ";
	$result = ave_mysql_query($query) or err_die(1, $query, mysql_error(), realpath(__FILE__), __LINE__);			
}

$CartXML = cart::GetCartXML($_REQUEST['user_id'], $_REQUEST['lang_id'], $_REQUEST['currency_id'], $Site['site_id'], $_REQUEST['cart_content_type']);

$CartQuantityAdjustedXML = "<cart_quantity_adjusted>" . ynval($CartQuantityAdjusted) . "</cart_quantity_adjusted>";

$QuantityAdjustedCartContentIDXML = '';
foreach ($QuantityAdjustedCartContentIDArray as $Q) {
	$QuantityAdjustedCartContentIDXML = $QuantityAdjustedCartContentIDXML . "<cart_content_id>" . $Q . "</cart_content_id>";
}
$QuantityAdjustedCartContentIDXML = "<cart_quantity_adjusted_cart_content_id_list>" . $QuantityAdjustedCartContentIDXML . "</cart_quantity_adjusted_cart_content_id_list>";

$smarty->assign('Data', $CartXML . $CartQuantityAdjustedXML . $QuantityAdjustedCartContentIDXML);
$smarty->display('api/api_result.tpl');
?>