<?php
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$SyncLog = new sync_log($Site['site_id'], $_REQUEST['shop_id']);

if (
		$SyncLog->getLatestLogDetails()->sync_log_status == 'user_sync' ||
		$SyncLog->getLatestLogDetails()->sync_log_status == 'order_sync' ||		
		$SyncLog->getLatestLogDetails()->sync_log_status == 'start_sync'
	) {
	
//		APIDie(array('no' => __LINE__, 'desc' => 'we should only sync payment_confirmed order'));	

	$MyOldOrder = myorder::GetMyOrderByOldMyOrderID($Site['site_id'], $_REQUEST['shop_id'], $_REQUEST['myorder_id']);
	myorder::DeleteOrder($MyOldOrder['myorder_id']);
	
	if (intval($_REQUEST['myorder_id']) > $SyncLog->getLatestLogDetails()->max_myorder_id) {

		$sql = '';
		$FieldType = array('text', 'int', 'double', 'date');
		foreach ($FieldType as $F) {
			for ($i = 1; $i <= 20; $i++) {
				if (isset($_REQUEST['myorder_custom_' . $F . '_' . $i]))
					$sql = $sql . " myorder_custom_" . $F . "_" . $i . " = '" . aveEscT($_REQUEST['myorder_custom_' . $F . '_' . $i]) . "', ";
			}
		}

		$User = user::GetUserByOldUserID($Site['site_id'], $_REQUEST['shop_id'], intval($_REQUEST['user_id']));
		$NewUserID = intval($_REQUEST['user_id']);
		if ($User != null)
			$NewUserID = intval($User['user_id']);

		$query =	"	INSERT INTO myorder " .
					"	SET		" .
					"			user_id							= '" . intval($NewUserID) . "', " .
					"			old_user_id						= '" . intval($_REQUEST['user_id']) . "', " .
					"			old_myorder_id					= '" . intval($_REQUEST['myorder_id']) . "', " .
					"			order_no						= '" . aveEscT($_REQUEST['order_no']) . "', " .
					"			order_status					= '" . aveEscT($_REQUEST['order_status']) . "', " .
					"			order_content_type				= '" . aveEscT($_REQUEST['order_content_type']) . "', " .
					"			self_take						= '" . aveEscT($_REQUEST['self_take']) . "', " .
					"			site_id							= '" . intval($Site['site_id']) . "', " .
					"			shop_id							= '" . aveEscT($_REQUEST['shop_id']) . "', " .
					"			terminal_id						= '" . aveEscT($_REQUEST['terminal_id']) . "', " .
					"			effective_base_price_id			= '" . aveEscT($_REQUEST['effective_base_price_id']) . "', " .
					"			bonus_point_item_id				= '" . aveEscT($_REQUEST['bonus_point_item_id']) . "', " .
					"			deliver_to_different_address	= '" . aveEscT($_REQUEST['deliver_to_different_address']) . "', " .
					"			email_order_confirm				= '" . aveEscT($_REQUEST['email_order_confirm']) . "', " .
					"			invoice_country_id				= '" . aveEscT($_REQUEST['invoice_country_id']) . "', " .
					"			invoice_country_other			= '" . aveEscT($_REQUEST['invoice_country_other']) . "', " .
					"			invoice_hk_district_id			= '" . aveEscT($_REQUEST['invoice_hk_district_id']) . "', " .
					"			invoice_first_name				= '" . aveEscT($_REQUEST['invoice_first_name']) . "', " .
					"			invoice_last_name				= '" . aveEscT($_REQUEST['invoice_last_name']) . "', " .
					"			invoice_company_name			= '" . aveEscT($_REQUEST['invoice_company_name']) . "', " .
					"			invoice_city_name				= '" . aveEscT($_REQUEST['invoice_city_name']) . "', " .
					"			invoice_region					= '" . aveEscT($_REQUEST['invoice_region']) . "', " .
					"			invoice_postcode				= '" . aveEscT($_REQUEST['invoice_postcode']) . "', " .
					"			invoice_phone_no				= '" . aveEscT($_REQUEST['invoice_phone_no']) . "', " .
					"			invoice_tel_country_code		= '" . aveEscT($_REQUEST['invoice_tel_country_code']) . "', " .
					"			invoice_tel_area_code			= '" . aveEscT($_REQUEST['invoice_tel_area_code']) . "', " .
					"			invoice_fax_country_code		= '" . aveEscT($_REQUEST['invoice_fax_country_code']) . "', " .
					"			invoice_fax_area_code			= '" . aveEscT($_REQUEST['invoice_fax_area_code']) . "', " .
					"			invoice_fax_no					= '" . aveEscT($_REQUEST['invoice_fax_no']) . "', " .
					"			invoice_shipping_address_1		= '" . aveEscT($_REQUEST['invoice_shipping_address_1']) . "', " .
					"			invoice_shipping_address_2		= '" . aveEscT($_REQUEST['invoice_shipping_address_2']) . "', " .
					"			invoice_email					= '" . aveEscT($_REQUEST['invoice_email']) . "', " .
					"			delivery_country_id				= '" . aveEscT($_REQUEST['delivery_country_id']) . "', " .
					"			delivery_country_other			= '" . aveEscT($_REQUEST['delivery_country_other']) . "', " .
					"			delivery_hk_district_id			= '" . aveEscT($_REQUEST['delivery_hk_district_id']) . "', " .
					"			delivery_first_name				= '" . aveEscT($_REQUEST['delivery_first_name']) . "', " .
					"			delivery_last_name				= '" . aveEscT($_REQUEST['delivery_last_name']) . "', " .
					"			delivery_company_name			= '" . aveEscT($_REQUEST['delivery_company_name']) . "', " .
					"			delivery_city_name				= '" . aveEscT($_REQUEST['delivery_city_name']) . "', " .
					"			delivery_region					= '" . aveEscT($_REQUEST['delivery_region']) . "', " .
					"			delivery_postcode				= '" . aveEscT($_REQUEST['delivery_postcode']) . "', " .
					"			delivery_phone_no				= '" . aveEscT($_REQUEST['delivery_phone_no']) . "', " .
					"			delivery_tel_country_code		= '" . aveEscT($_REQUEST['delivery_tel_country_code']) . "', " .
					"			delivery_tel_area_code			= '" . aveEscT($_REQUEST['delivery_tel_area_code']) . "', " .
					"			delivery_fax_no					= '" . aveEscT($_REQUEST['delivery_fax_no']) . "', " .
					"			delivery_fax_country_code		= '" . aveEscT($_REQUEST['delivery_fax_country_code']) . "', " .
					"			delivery_fax_area_code			= '" . aveEscT($_REQUEST['delivery_fax_area_code']) . "', " .
					"			delivery_shipping_address_1		= '" . aveEscT($_REQUEST['delivery_shipping_address_1']) . "', " .
					"			delivery_shipping_address_2		= '" . aveEscT($_REQUEST['delivery_shipping_address_2']) . "', " .
					"			delivery_email					= '" . aveEscT($_REQUEST['delivery_email']) . "', " .
					"			delivery_date					= '" . aveEscT($_REQUEST['delivery_date']) . "', " .
					"			user_message					= '" . aveEscT($_REQUEST['user_message']) . "', " .
					"			bonus_point_previous			= '" . aveEscT($_REQUEST['bonus_point_previous']) . "', " .
					"			bonus_point_earned				= '" . aveEscT($_REQUEST['bonus_point_earned']) . "', " .
					"			bonus_point_earned_supplied_by_client	= '" . aveEscT($_REQUEST['bonus_point_earned_supplied_by_client']) . "', " .
					"			bonus_point_canbeused			= '" . aveEscT($_REQUEST['bonus_point_canbeused']) . "', " .
					"			bonus_point_redeemed			= '" . aveEscT($_REQUEST['bonus_point_redeemed']) . "', " .
					"			bonus_point_balance				= '" . aveEscT($_REQUEST['bonus_point_balance']) . "', " .
					"			bonus_point_redeemed_cash		= '" . aveEscT($_REQUEST['bonus_point_redeemed_cash']) . "', " .
					"			bonus_point_redeemed_cash_ca	= '" . aveEscT($_REQUEST['bonus_point_redeemed_cash_ca']) . "', " .
					"			payment_confirmed				= '" . aveEscT($_REQUEST['payment_confirmed']) . "', " .
					"			order_confirmed					= '" . aveEscT($_REQUEST['order_confirmed']) . "', " .
					"			currency_id						= '" . aveEscT($_REQUEST['currency_id']) . "', " .
					"			currency_site_rate_atm			= '" . aveEscT($_REQUEST['currency_site_rate_atm']) . "', " .
					"			user_balance_previous			= '" . aveEscT($_REQUEST['user_balance_previous']) . "', " .
					"			user_balance_used				= '" . aveEscT($_REQUEST['user_balance_used']) . "', " .
					"			user_balance_used_ca			= '" . aveEscT($_REQUEST['user_balance_used_ca']) . "', " .
					"			user_balance_after				= '" . aveEscT($_REQUEST['user_balance_after']) . "', " .
					"			total_price						= '" . aveEscT($_REQUEST['total_price']) . "', " .
					"			total_price_ca					= '" . aveEscT($_REQUEST['total_price_ca']) . "', " .
					"			discount_amount_ca				= '" . aveEscT($_REQUEST['discount_amount_ca']) . "', " .
					"			cash_paid_ca					= '" . aveEscT($_REQUEST['cash_paid_ca']) . "', " .
					"			cash_paid						= '" . aveEscT($_REQUEST['cash_paid']) . "', " .
					"			cash_paid_currency_id			= '" . aveEscT($_REQUEST['cash_paid_currency_id']) . "', " .
					"			cash_change_ca					= '" . aveEscT($_REQUEST['cash_change_ca']) . "', " .
					"			user_input_discount_code		= '" . aveEscT($_REQUEST['user_input_discount_code']) . "', " .
					"			continue_process_postprocess_discount_rule	= '" . aveEscT($_REQUEST['continue_process_postprocess_discount_rule']) . "', " .
					"			effective_discount_postprocess_rule_id		= '" . aveEscT($_REQUEST['effective_discount_postprocess_rule_id']) . "', " .
					"			effective_discount_postprocess_rule_discount_code	= '" . aveEscT($_REQUEST['effective_discount_postprocess_rule_discount_code']) . "', " .
					"			postprocess_rule_discount_amount	= '" . aveEscT($_REQUEST['postprocess_rule_discount_amount']) . "', " .
					"			postprocess_rule_discount_amount_ca	= '" . aveEscT($_REQUEST['postprocess_rule_discount_amount_ca']) . "', " .
					"			freight_cost_ca					= '" . aveEscT($_REQUEST['freight_cost_ca']) . "', " .
					"			pay_amount_ca					= '" . aveEscT($_REQUEST['pay_amount_ca']) . "', " .
					"			order_confirm_by				= '" . aveEscT($_REQUEST['order_confirm_by']) . "', " .
					"			order_confirm_date				= '" . aveEscT($_REQUEST['order_confirm_date']) . "', " .
					"			payment_confirm_by				= '" . aveEscT($_REQUEST['payment_confirm_by']) . "', " .
					"			payment_confirm_date			= '" . aveEscT($_REQUEST['payment_confirm_date']) . "', " .
					"			shipment_confirm_by				= '" . aveEscT($_REQUEST['shipment_confirm_by']) . "', " .
					"			shipment_confirm_date			= '" . aveEscT($_REQUEST['shipment_confirm_date']) . "', " .
					"			create_date						= '" . aveEscT($_REQUEST['create_date']) . "', " .
					"			reference_1						= '" . aveEscT($_REQUEST['reference_1']) . "', " .
					"			reference_2						= '" . aveEscT($_REQUEST['reference_2']) . "', " .
					"			reference_3						= '" . aveEscT($_REQUEST['reference_3']) . "', " .
					"			is_handled						= '" . aveEscT($_REQUEST['is_handled']) . "', " . $sql .
					"			user_reference					= '" . aveEscT($_REQUEST['user_reference']) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$NewMyOrderID = customdb::mysqli()->insert_id;

		// handle bonus point and balance
		$MyOrder = new myorder($NewMyOrderID);
		if ($_REQUEST['order_status'] != 'void' && $_REQUEST['payment_confirmed'] == 'Y')
			$MyOrder->ConfirmPayment($ErrorCode, $_REQUEST['payment_confirm_by'], $_REQUEST['reference_1'], $_REQUEST['reference_2'], $_REQUEST['reference_3'], null, true);

		$Data = "<myorder_sync_result>imported</myorder_sync_result><new_myorder_id>" . $NewMyOrderID . "</new_myorder_id>";
		
		$SyncLog->incrementLatestSyncNoOfMyorderImported();
		$SyncLog->updateLatestSyncStatus('order_sync');			
	}
	else {
		APIDie(array('no' => __LINE__, 'desc' => 'myorder_id is less than max_myorder_id'));
	}
	$smarty->assign('Data', $Data);
	$smarty->display('api/api_result.tpl');
}
else {
	APIDie(array('no' => __LINE__, 'desc' => 'Unmatched sync status'));	
}