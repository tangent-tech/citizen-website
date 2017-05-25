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

$ProductList = product::GetAllProductListWithProductOption($Site['site_id'], $Site['site_default_language_id']);
$smarty->assign('ProductList', $ProductList);

$ProductFieldsShow = site::GetProductFieldsShow($_SESSION['site_id']);
$smarty->assign('ProductFieldsShow', $ProductFieldsShow);

$ProductCustomFieldsDef = Site::GetProductCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('ProductCustomFieldsDef', $ProductCustomFieldsDef);

$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);
$smarty->assign('CurrencyList', $CurrencyList);

if (!$_REQUEST['currency_id'])
	$_REQUEST['currency_id'] = $Site['site_default_currency_id'];

$Currency = currency::GetCurrencyInfo($_REQUEST['currency_id'], $Site['site_id']);
$smarty->assign('Currency', $Currency);

$ProductPriceOption = array();
for ($i = 1; $i <= 9; $i++) {
	if ($ProductCustomFieldsDef['product_price' . $i] != '') {
		$ProductPriceOption[$i] = $ProductCustomFieldsDef['product_price' . $i];
	}
}
$smarty->assign('ProductPriceOption', $ProductPriceOption);

$cart = new cart_v2(intval($_SESSION['SystemAdminID']), intval($_SESSION['ContentAdminID']), 0, $Site['site_id'], 'test');
$cart->TouchCart();
$cart->setUserSecurityLevel(intval($_REQUEST['user_security_level']));
$cart->getCartDetailsObj()->bonus_point_earned_supplied_by_client = -1;
$cart->getCartDetailsObj()->effective_base_price_id = 0;
$cart->getCartDetailsObj()->currency_id = $_REQUEST['currency_id'];
$cart->UpdateCartDetailsFromObj();
$cart->processCart();

$CartItemList = $cart->GetCartItemListWithoutCalculation();
$smarty->assign('CartItemList', $CartItemList);

$CartDetailsObj = $cart->getCartDetailsObj(true, 0);
$smarty->assign('CartDetailsObj', $CartDetailsObj);

$smarty->assign('Cart', $cart);

$smarty->assign('TITLE', 'Discount Rule Test');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/discount_rule_test.tpl');