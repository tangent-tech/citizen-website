<?php
// parameters:
//	user_id
//	bonus_point_item_id
//	use_bonus_point
//	deliver_to_different_address
//	self_take - Y/N
//	update_user_address
//	email_order_confirm
//	join_mailing_list
//	currency_id
//	freight_cost_ca
//	user_balance_use
//	invoice_country_id
//	invoice_country_other
//	invoice_hk_district_id
//	invoice_first_name
//	invoice_last_name
//	invoice_company_name
//	invoice_city_name
//	invoice_region
//	invoice_postcode
//	invoice_phone_no
//	invoice_tel_country_code
//	invoice_tel_area_code
//	invoice_fax_country_code
//	invoice_fax_area_code
//	invoice_fax_no
//	invoice_shipping_address_1
//	invoice_shipping_address_2
//	invoice_email
//	delivery_country_id
//	delivery_country_other
//	delivery_hk_district_id
//	delivery_first_name
//	delivery_last_name
//	delivery_company_name
//	delivery_city_name
//	delivery_region
//	delivery_postcode
//	delivery_phone_no
//	delivery_tel_country_code
//	delivery_tel_area_code
//	delivery_fax_no
//	delivery_fax_country_code
//	delivery_fax_area_code
//	delivery_shipping_address_1
//	delivery_shipping_address_2
//	delivery_email
//	user_message
//	discount_code
//	myorder_custom_text_1 to myorder_custom_text_20
//	myorder_custom_int_1 to myorder_custom_int_20
//	myorder_custom_double_1 to myorder_custom_double_20
//	myorder_custom_date_1 to myorder_custom_date_20
//	cart_content_type - normal / bonus_point
//	effective_base_price_id
//	cash_paid
//	cash_paid_currency_id;
//	discount_amount_ca
//	want_to_pay_exact_amount_ca - will override discount_amount_ca if applied)

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

$query  =	" 	INSERT	INTO	cart_details " .
			"	SET		user_id				= '" . intval($_REQUEST['user_id']) . "', " .
			"			system_admin_id		= 0, " .
			"			content_admin_id	= 0, " .
			"			site_id				= '" . intval($Site['site_id']) . "', " .
			"			cart_content_type	= '" . aveEscT($_REQUEST['cart_content_type']) . "' " .
			"	ON DUPLICATE KEY UPDATE user_id = '" . intval($_REQUEST['user_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

if (isset($_REQUEST['bonus_point_item_id'])) {
	if ($_REQUEST['bonus_point_item_id'] != 0) {
		$BonusPointItem = bonuspoint::GetBonusPointItemInfo($_REQUEST['bonus_point_item_id'], 1);
		if ($BonusPointItem['site_id'] != $Site['site_id'])
			APIDie($API_ERROR['API_ERROR_INVALID_BONUS_POINT_ITEM_ID']);

		$cart = new cart_v2(0, 0, intval($_REQUEST['user_id']), $Site['site_id'], $_REQUEST['cart_content_type'], 1);
		$cart->EmptyBonusPointItemCart();
		$cart->AddBonusPointItemToCart($_REQUEST['bonus_point_item_id'], 1);
	}
}

if (isset($_REQUEST['currency_id'])) {
	$Currency = currency::GetCurrencyInfo($_REQUEST['currency_id'], $Site['site_id']);
	if ($Currency['site_id'] != $Site['site_id'])
		APIDie($API_ERROR['API_ERROR_INVALID_CURRENCY_ID']);
}

$sql = GetCustomTextSQL("myorder", "int") . GetCustomTextSQL("myorder", "double") . GetCustomTextSQL("myorder", "date") . GetCustomTextSQL("myorder", "text");

if (isset($_REQUEST['cash_paid']))
	$sql = $sql . "	cash_paid = '" . doubleval($_REQUEST['cash_paid']) . "', ";
if (isset($_REQUEST['cash_paid_currency_id']))
	$sql = $sql . "	cash_paid_currency_id = '" . intval($_REQUEST['cash_paid_currency_id']) . "', ";
if (isset($_REQUEST['bonus_point_item_id']))
	$sql = $sql . "	bonus_point_item_id = '" . intval($_REQUEST['bonus_point_item_id']) . "', ";
if (isset($_REQUEST['use_bonus_point']))
	$sql = $sql . "	use_bonus_point = '" . ynval($_REQUEST['use_bonus_point']) . "', ";
if (isset($_REQUEST['deliver_to_different_address']))
	$sql = $sql . "	deliver_to_different_address = '" . ynval($_REQUEST['deliver_to_different_address']) . "', ";
if (isset($_REQUEST['update_user_address']))
	$sql = $sql . "	update_user_address = '" . ynval($_REQUEST['update_user_address']) . "', ";
if (isset($_REQUEST['user_balance_use']))
	$sql = $sql . "	user_balance_use = '" . doubleval($_REQUEST['user_balance_use']) . "', ";
if (isset($_REQUEST['email_order_confirm']))
	$sql = $sql . "	email_order_confirm = '" . ynval($_REQUEST['email_order_confirm']) . "', ";
if (isset($_REQUEST['join_mailing_list']))
	$sql = $sql . "	join_mailing_list = '" . ynval($_REQUEST['join_mailing_list']) . "', ";
if (isset($_REQUEST['currency_id']))
	$sql = $sql . "	currency_id = '" . intval($_REQUEST['currency_id']) . "', ";
if (isset($_REQUEST['freight_cost_ca']))
	$sql = $sql . "	freight_cost_ca = '" . doubleval($_REQUEST['freight_cost_ca']) . "', ";
if (isset($_REQUEST['invoice_country_id']))
	$sql = $sql . "	invoice_country_id = '" . intval($_REQUEST['invoice_country_id']) . "', ";
if (isset($_REQUEST['invoice_country_other']))
	$sql = $sql . "	invoice_country_other = '" . trim($_REQUEST['invoice_country_other']) . "', ";
if (isset($_REQUEST['invoice_hk_district_id']))
	$sql = $sql . "	invoice_hk_district_id = '" . intval($_REQUEST['invoice_hk_district_id']) . "', ";
if (isset($_REQUEST['invoice_first_name']))
	$sql = $sql . "	invoice_first_name = '" . aveEscT($_REQUEST['invoice_first_name']) . "', ";
if (isset($_REQUEST['invoice_last_name']))
	$sql = $sql . "	invoice_last_name = '" . aveEscT($_REQUEST['invoice_last_name']) . "', ";
if (isset($_REQUEST['invoice_company_name']))
	$sql = $sql . "	invoice_company_name = '" . aveEscT($_REQUEST['invoice_company_name']) . "', ";
if (isset($_REQUEST['invoice_city_name']))
	$sql = $sql . "	invoice_city_name = '" . aveEscT($_REQUEST['invoice_city_name']) . "', ";
if (isset($_REQUEST['invoice_region']))
	$sql = $sql . "	invoice_region = '" . aveEscT($_REQUEST['invoice_region']) . "', ";
if (isset($_REQUEST['invoice_postcode']))
	$sql = $sql . "	invoice_postcode = '" . aveEscT($_REQUEST['invoice_postcode']) . "', ";
if (isset($_REQUEST['invoice_phone_no']))
	$sql = $sql . "	invoice_phone_no = '" . aveEscT($_REQUEST['invoice_phone_no']) . "', ";
if (isset($_REQUEST['invoice_tel_country_code']))
	$sql = $sql . "	invoice_tel_country_code = '" . aveEscT($_REQUEST['invoice_tel_country_code']) . "', ";
if (isset($_REQUEST['invoice_tel_area_code']))
	$sql = $sql . "	invoice_tel_area_code = '" . aveEscT($_REQUEST['invoice_tel_area_code']) . "', ";
if (isset($_REQUEST['invoice_fax_country_code']))
	$sql = $sql . "	invoice_fax_country_code = '" . aveEscT($_REQUEST['invoice_fax_country_code']) . "', ";
if (isset($_REQUEST['invoice_fax_area_code']))
	$sql = $sql . "	invoice_fax_area_code = '" . aveEscT($_REQUEST['invoice_fax_area_code']) . "', ";
if (isset($_REQUEST['invoice_fax_no']))
	$sql = $sql . "	invoice_fax_no = '" . aveEscT($_REQUEST['invoice_fax_no']) . "', ";
if (isset($_REQUEST['invoice_shipping_address_1']))
	$sql = $sql . "	invoice_shipping_address_1 = '" . aveEscT($_REQUEST['invoice_shipping_address_1']) . "', ";
if (isset($_REQUEST['invoice_shipping_address_2']))
	$sql = $sql . "	invoice_shipping_address_2 = '" . aveEscT($_REQUEST['invoice_shipping_address_2']) . "', ";
if (isset($_REQUEST['invoice_email']))
	$sql = $sql . "	invoice_email = '" . aveEscT($_REQUEST['invoice_email']) . "', ";
if (isset($_REQUEST['delivery_country_id']))
	$sql = $sql . "	delivery_country_id = '" . intval($_REQUEST['delivery_country_id']) . "', ";
if (isset($_REQUEST['delivery_country_other']))
	$sql = $sql . "	delivery_country_other = '" . aveEscT($_REQUEST['delivery_country_other']) . "', ";
if (isset($_REQUEST['delivery_hk_district_id']))
	$sql = $sql . "	delivery_hk_district_id = '" . intval($_REQUEST['delivery_hk_district_id']) . "', ";
if (isset($_REQUEST['delivery_first_name']))
	$sql = $sql . "	delivery_first_name = '" . aveEscT($_REQUEST['delivery_first_name']) . "', ";
if (isset($_REQUEST['delivery_last_name']))
	$sql = $sql . "	delivery_last_name = '" . aveEscT($_REQUEST['delivery_last_name']) . "', ";
if (isset($_REQUEST['delivery_company_name']))
	$sql = $sql . "	delivery_company_name = '" . aveEscT($_REQUEST['delivery_company_name']) . "', ";
if (isset($_REQUEST['delivery_city_name']))
	$sql = $sql . "	delivery_city_name = '" . aveEscT($_REQUEST['delivery_city_name']) . "', ";
if (isset($_REQUEST['delivery_region']))
	$sql = $sql . "	delivery_region = '" . aveEscT($_REQUEST['delivery_region']) . "', ";
if (isset($_REQUEST['delivery_postcode']))
	$sql = $sql . "	delivery_postcode = '" . aveEscT($_REQUEST['delivery_postcode']) . "', ";
if (isset($_REQUEST['delivery_phone_no']))
	$sql = $sql . "	delivery_phone_no = '" . aveEscT($_REQUEST['delivery_phone_no']) . "', ";
if (isset($_REQUEST['delivery_tel_country_code']))
	$sql = $sql . "	delivery_tel_country_code = '" . aveEscT($_REQUEST['delivery_tel_country_code']) . "', ";
if (isset($_REQUEST['delivery_tel_area_code']))
	$sql = $sql . "	delivery_tel_area_code = '" . aveEscT($_REQUEST['delivery_tel_area_code']) . "', ";
if (isset($_REQUEST['delivery_fax_no']))
	$sql = $sql . "	delivery_fax_no = '" . aveEscT($_REQUEST['delivery_fax_no']) . "', ";
if (isset($_REQUEST['delivery_fax_country_code']))
	$sql = $sql . "	delivery_fax_country_code = '" . aveEscT($_REQUEST['delivery_fax_country_code']) . "', ";
if (isset($_REQUEST['delivery_fax_area_code']))
	$sql = $sql . "	delivery_fax_area_code = '" . aveEscT($_REQUEST['delivery_fax_area_code']) . "', ";
if (isset($_REQUEST['delivery_shipping_address_1']))
	$sql = $sql . "	delivery_shipping_address_1 = '" . aveEscT($_REQUEST['delivery_shipping_address_1']) . "', ";
if (isset($_REQUEST['delivery_shipping_address_2']))
	$sql = $sql . "	delivery_shipping_address_2 = '" . aveEscT($_REQUEST['delivery_shipping_address_2']) . "', ";
if (isset($_REQUEST['delivery_email']))
	$sql = $sql . "	delivery_email = '" . aveEscT($_REQUEST['delivery_email']) . "', ";
if (isset($_REQUEST['user_message']))
	$sql = $sql . "	user_message = '" . aveEscT($_REQUEST['user_message']) . "', ";

if (isset($_REQUEST['discount_code']))
	$sql = $sql . "	discount_code = '" . aveEscT($_REQUEST['discount_code']) . "', ";
if (isset($_REQUEST['self_take']))
	$sql = $sql . "	self_take = '" . ynval($_REQUEST['self_take']) . "', ";

if (intval($_REQUEST['effective_base_price_id']) >=1 && intval($_REQUEST['effective_base_price_id']) <= 3)
	$sql = $sql . "	effective_base_price_id = '" . intval($_REQUEST['effective_base_price_id']) . "', ";

if (isset($_REQUEST['want_to_pay_exact_amount_ca']))
	$sql = $sql . "	discount_amount_ca = 0, ";
else if (isset($_REQUEST['discount_amount_ca']))
	$sql = $sql . "	discount_amount_ca = '" . doubleval ($_REQUEST['discount_amount_ca']) . "', ";

$query  =	" 	UPDATE	cart_details " .
			"	SET		" . $sql .
			"			create_date			= NOW() " .
			"	WHERE	user_id				= '" . intval($_REQUEST['user_id']) . "'" .
			"		AND	system_admin_id		= 0 " .
			"		AND	content_admin_id	= 0 " .
			"		AND	site_id				= '" . intval($Site['site_id']) . "'" .
			"		AND	cart_content_type	= '" . aveEscT($_REQUEST['cart_content_type']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);


if (isset($_REQUEST['want_to_pay_exact_amount_ca'])) {
	$cart = new cart_v2(0, 0, $_REQUEST['user_id'], $Site['site_id'], $_REQUEST['cart_content_type']);
	$cart->processCart();

	$query  =	" 	UPDATE	cart_details " .
				"	SET		discount_amount_ca = '" . doubleval($cart->pay_amount_ca - doubleval($_REQUEST['want_to_pay_exact_amount_ca'])) . "'" .
				"	WHERE	user_id				= '" . intval($_REQUEST['user_id']) . "'" .
				"		AND	system_admin_id		= 0 " .
				"		AND	content_admin_id	= 0 " .
				"		AND	site_id				= '" . intval($Site['site_id']) . "'" .
				"		AND	cart_content_type	= '" . aveEscT($_REQUEST['cart_content_type']) . "' ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$smarty->display('api/api_result.tpl');