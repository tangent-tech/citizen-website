<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'order');

$MyOrder = cart::GetMyOrderInfo($_REQUEST['id']);
if ($MyOrder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('MyOrder', $MyOrder);

if ($_REQUEST['bonus_point_item_id'] != 0) {
	$BonusPointItem = bonuspoint::GetBonusPointItemInfo($_REQUEST['bonus_point_item_id'], 0);
	if ($BonusPointItem['site_id'] != $Site['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR);
}

$sql = '';
if ($MyOrder['payment_confirmed'] == 'N') {
	$sql =	",			bonus_point_item_id				=	'" . intval($_REQUEST['bonus_point_item_id']) . "', " .
			"			freight_cost_ca					=	'" . doubleval($_REQUEST['freight_cost_ca']) . "', " .
			"			discount_amount_ca				=	'" . doubleval($_REQUEST['discount_amount_ca']) . "', " .
			"			currency_site_rate_atm			=	'" . floatval($_REQUEST['currency_site_rate_atm']) . "', " .
			"			user_balance_used				=	'" . doubleval($_REQUEST['user_balance_used']) . "'";
}

$sql2 = '';
if (!($Site.site_module_inventory_enable == 'Y' || $Site.site_module_inventory_partial_shipment == 'Y')) {
	$sql2 = ", 			delivery_date					=	'" . aveEscT($_REQUEST['delivery_date']) . "' ";
}

$query  =	" 	UPDATE	myorder " .
			"	SET		is_handled						=	'" . ynval($_REQUEST['is_handled']) . "', " .
			"			user_reference					=	'" . aveEscT($_REQUEST['user_reference']) . "', " .
			"			deliver_to_different_address	=	'" . ynval($_REQUEST['deliver_to_different_address']) . "', " .
			"			invoice_first_name				=	'" . aveEscT($_REQUEST['invoice_first_name']) . "', " .
			"			invoice_last_name				=	'" . aveEscT($_REQUEST['invoice_last_name']) . "', " .
			"			invoice_company_name			=	'" . aveEscT($_REQUEST['invoice_company_name']) . "', " .
			"			invoice_city_name				=	'" . aveEscT($_REQUEST['invoice_city_name']) . "', " .
			"			invoice_region					=	'" . aveEscT($_REQUEST['invoice_region']) . "', " .
			"			invoice_postcode				=	'" . aveEscT($_REQUEST['invoice_postcode']) . "', " .
			"			invoice_shipping_address_1		=	'" . aveEscT($_REQUEST['invoice_shipping_address_1']) . "', " .
			"			invoice_shipping_address_2		=	'" . aveEscT($_REQUEST['invoice_shipping_address_2']) . "', " .
			"			invoice_country_id				=	'" . intval($_REQUEST['invoice_country_id']) . "', " .
			"			invoice_hk_district_id			=	'" . intval($_REQUEST['invoice_hk_district_id']) . "', " .
			"			invoice_tel_country_code		=	'" . aveEscT($_REQUEST['invoice_tel_country_code']) . "', " .
			"			invoice_tel_area_code			=	'" . aveEscT($_REQUEST['invoice_tel_area_code']) . "', " .
			"			invoice_phone_no				=	'" . aveEscT($_REQUEST['invoice_phone_no']) . "', " .
			"			invoice_fax_country_code		=	'" . aveEscT($_REQUEST['invoice_fax_country_code']) . "', " .
			"			invoice_fax_area_code			=	'" . aveEscT($_REQUEST['invoice_fax_area_code']) . "', " .
			"			invoice_fax_no					=	'" . aveEscT($_REQUEST['invoice_fax_no']) . "', " .
			"			invoice_email					=	'" . aveEscT($_REQUEST['invoice_email']) . "', " .
			"			delivery_first_name				=	'" . aveEscT($_REQUEST['delivery_first_name']) . "', " .
			"			delivery_last_name				=	'" . aveEscT($_REQUEST['delivery_last_name']) . "', " .
			"			delivery_company_name			=	'" . aveEscT($_REQUEST['delivery_company_name']) . "', " .
			"			delivery_city_name				=	'" . aveEscT($_REQUEST['delivery_city_name']) . "', " .
			"			delivery_region					=	'" . aveEscT($_REQUEST['delivery_region']) . "', " .
			"			delivery_postcode				=	'" . aveEscT($_REQUEST['delivery_postcode']) . "', " .
			"			delivery_shipping_address_1		=	'" . aveEscT($_REQUEST['delivery_shipping_address_1']) . "', " .
			"			delivery_shipping_address_2		=	'" . aveEscT($_REQUEST['delivery_shipping_address_2']) . "', " .
			"			delivery_country_id				=	'" . intval($_REQUEST['delivery_country_id']) . "', " .
			"			delivery_hk_district_id			=	'" . intval($_REQUEST['delivery_hk_district_id']) . "', " .
			"			delivery_tel_country_code		=	'" . aveEscT($_REQUEST['delivery_tel_country_code']) . "', " .
			"			delivery_tel_area_code			=	'" . aveEscT($_REQUEST['delivery_tel_area_code']) . "', " .
			"			delivery_phone_no				=	'" . aveEscT($_REQUEST['delivery_phone_no']) . "', " .
			"			delivery_fax_country_code		=	'" . aveEscT($_REQUEST['delivery_fax_country_code']) . "', " .
			"			delivery_fax_area_code			=	'" . aveEscT($_REQUEST['delivery_fax_area_code']) . "', " .
			"			delivery_fax_no					=	'" . aveEscT($_REQUEST['delivery_fax_no']) . "', " .
			"			delivery_email					=	'" . aveEscT($_REQUEST['delivery_email']) . "' " . $sql2 . $sql .
			"	WHERE	myorder_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

if ($MyOrder['payment_confirmed'] != 'Y')
	cart::UpdateMyOrderWithNewCurrencyRate($_REQUEST['id']);

header( 'Location: order_details.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));