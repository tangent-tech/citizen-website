<?php
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$SyncLog = new sync_log($Site['site_id'], $_REQUEST['shop_id']);

if (
		$SyncLog->getLatestLogDetails()->sync_log_status == 'order_sync'
	) {
	
	// Get order from OldOrderID
	$MyOrder = myorder::GetMyOrderByOldMyOrderID($Site['site_id'], $_REQUEST['shop_id'], $_REQUEST['myorder_id']);
	
	if ($MyOrder == null)
		APIDie(array('no' => __LINE__, 'desc' => 'Cannot find myorder'));
	
	if (intval($_REQUEST['myorder_id']) > $SyncLog->getLatestLogDetails()->max_myorder_id) {
		
		$query =	"	INSERT INTO myorder_product " .
					"	SET		" .
					"			myorder_id						= '" . intval($MyOrder['myorder_id']) . "', " .
					"			product_id						= '" . intval($_REQUEST['product_id']) . "', " .
					"			currency_id						= '" . intval($_REQUEST['currency_id']) . "', " .
					"			product_price					= '" . aveEscT($_REQUEST['product_price']) . "', " .
					"			product_price_ca				= '" . aveEscT($_REQUEST['product_price_ca']) . "', " .
					"			product_price2					= '" . aveEscT($_REQUEST['product_price2']) . "', " .
					"			product_price2_ca				= '" . aveEscT($_REQUEST['product_price2_ca']) . "', " .
					"			product_price3					= '" . aveEscT($_REQUEST['product_price3']) . "', " .
					"			product_price3_ca				= '" . aveEscT($_REQUEST['product_price3_ca']) . "', " .
					"			product_base_price				= '" . aveEscT($_REQUEST['product_base_price']) . "', " .
					"			product_base_price_ca			= '" . aveEscT($_REQUEST['product_base_price_ca']) . "', " .
					"			product_bonus_point_amount		= '" . aveEscT($_REQUEST['product_bonus_point_amount']) . "', " .
					"			actual_subtotal_price			= '" . aveEscT($_REQUEST['actual_subtotal_price']) . "', " .
					"			actual_subtotal_price_ca		= '" . aveEscT($_REQUEST['actual_subtotal_price_ca']) . "', " .
					"			actual_unit_price				= '" . aveEscT($_REQUEST['actual_unit_price']) . "', " .
					"			actual_unit_price_ca			= '" . aveEscT($_REQUEST['actual_unit_price_ca']) . "', " .
					"			quantity						= '" . aveEscT($_REQUEST['quantity']) . "', " .
					"			effective_discount_type			= '" . aveEscT($_REQUEST['effective_discount_type']) . "', " .
					"			effective_discount_preprocess_rule_id	= '" . aveEscT($_REQUEST['effective_discount_preprocess_rule_id']) . "', " .
					"			effective_discount_preprocess_code		= '" . aveEscT($_REQUEST['effective_discount_preprocess_code']) . "', " .
					"			effective_discount_bundle_rule_id	= '" . aveEscT($_REQUEST['effective_discount_bundle_rule_id']) . "', " .
					"			effective_discount_bundle_code		= '" . aveEscT($_REQUEST['effective_discount_bundle_code']) . "', " .
					"			discount1_off_p					= '" . aveEscT($_REQUEST['discount1_off_p']) . "', " .
					"			discount2_amount				= '" . aveEscT($_REQUEST['discount2_amount']) . "', " .
					"			discount2_price					= '" . aveEscT($_REQUEST['discount2_price']) . "', " .
					"			discount2_price_ca				= '" . aveEscT($_REQUEST['discount2_price_ca']) . "', " .
					"			discount3_buy_amount			= '" . aveEscT($_REQUEST['discount3_buy_amount']) . "', " .
					"			discount3_free_amount			= '" . aveEscT($_REQUEST['discount3_free_amount']) . "', " .
					"			product_option_id				= '" . aveEscT($_REQUEST['product_option_id']) . "', " .
					"			product_price_id				= '" . aveEscT($_REQUEST['product_price_id']) . "', " .				
					"			cart_content_custom_key			= '" . aveEscT($_REQUEST['cart_content_custom_key']) . "', " .
					"			cart_content_custom_desc		= '" . aveEscT($_REQUEST['cart_content_custom_desc']) . "', " .
					"			product_bonus_point_required	= '" . aveEscT($_REQUEST['product_bonus_point_required']) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$SyncLog->updateLatestSyncStatus('order_sync');
	}
	else {
		APIDie(array('no' => __LINE__, 'desc' => 'myorder_id is less than max_myorder_id'));	
	}
	$smarty->display('api/api_result.tpl');
}
else {
	APIDie(array('no' => __LINE__, 'desc' => 'Unmatched sync status'));	
}