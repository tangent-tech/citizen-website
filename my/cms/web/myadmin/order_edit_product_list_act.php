<?php
// IMPORTANT!!!!!!!!!!!!!!!!!
// Check price_calculation_change_note.txt if price calculation algorithm is modified!!!!!!!!!!!

define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'order');
$smarty->assign('MyJS', 'order_edit_product_list');

$MyOrder = cart::GetMyOrderInfo($_REQUEST['id']);
if ($MyOrder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_ORDER_IS_DELETED, 'order_list.php', __LINE__);
if ($MyOrder['payment_confirmed'] == 'Y')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_details.php?id=' . $_REQUEST['id'], __LINE__);

cart::ConvertOrderToTempCart($_REQUEST['id']);

$TotalQuantity = array();
if (count($_REQUEST['quantity']) > 0) {
	cart::EmptyProductCart($MyOrder['user_id'], 'temp', $MyOrder['site_id'], 0, 0);

	foreach ($_REQUEST['quantity'] as $key => $value) {
		$TotalQuantity[ $_REQUEST['product_id'][$key] . "_" . $_REQUEST['product_option_id'][$key] ] =
			intval($TotalQuantity[ $_REQUEST['product_id'][$key] . "_" . $_REQUEST['product_option_id'][$key] ]) + intval($value);
	}

	foreach ($TotalQuantity as $key => $value) {
		list($ProductID, $ProductOptionID) = explode("_", $key);

		if ($value > 0) {
			$Product = product::GetProductInfo($ProductID, $Site['site_default_language_id']);
			if ($Product['site_id'] != $_SESSION['site_id'])
				AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);
			if ($Product['object_is_enable'] == 'N')
				AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);
			if ( $ProductOptionID == 0 && product::IsProductOptionExist($ProductID) )
				AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);

			cart::AddProductToCart($ProductID, intval($value), $MyOrder['user_id'], $ProductOptionID, 'temp', $Site['site_id'], 0, 0);
		}
	}
}

$NewOrderID = null;
cart::CartConvertToOrder($MyOrder['user_id'], 'temp', $MyOrder['order_confirmed'], $MyOrder['myorder_id'], $NewOrderID);

header( 'Location: order_details.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '#MyOrderTabsPanel-Pricing');