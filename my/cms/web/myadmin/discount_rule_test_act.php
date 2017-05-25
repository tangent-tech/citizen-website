<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_rule_test');
$smarty->assign('MyJS', 'discount_rule_test');

$cart = new cart_v2(intval($_SESSION['SystemAdminID']), intval($_SESSION['ContentAdminID']), 0, $Site['site_id'], 'test');
$cart->TouchCart();
$cart->getCartDetailsObj()->discount_code = $_REQUEST['cart_content_rule_test_discount_code'];
$cart->UpdateCartDetailsFromObj();

$cart->EmptyProductCart();

foreach ($_REQUEST['quantity'] as $key => $value) {
	$ProductIDProductOptionID = $_REQUEST['product_id_product_option_id'][$key];
	list($ProductID, $ProductOptionID) = explode("_", $ProductIDProductOptionID);

	if ($value > 0) {
		$Product = product::GetProductInfo($ProductID, $Site['site_default_language_id']);
		if ($Product['site_id'] != $_SESSION['site_id'])
			AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'discount_rule_test.php', __LINE__);
		if ($Product['object_is_enable'] == 'N')
			AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'discount_rule_test.php', __LINE__);
		if ( $ProductOptionID == 0 && product::IsProductOptionExist($ProductID) )
			AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'discount_rule_test.php', __LINE__);

		$cart->AddProductToCart($ProductID, intval($value), $ProductOptionID, $_REQUEST['product_price_id'][$key], $_REQUEST['cart_content_custom_key'][$key]);
	}
}

header( 'Location: discount_rule_test.php?user_security_level=' . $_REQUEST['user_security_level'] . '&currency_id=' . $_REQUEST['currency_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));