<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_bundle_rule_list');
$smarty->assign('MyJS', 'discount_bundle_rule_edit_act');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$BundleRule = discount::GetBundleRuleInfo($_REQUEST['id'], 0);
if ($BundleRule['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'discount_bundle_rule_list.php', __LINE__);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

$query	=	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['object_is_enable']) . "', " .
			"			object_archive_date		= '" . aveEscT($ObjectArchiveDateText) . "', " .
			"			object_publish_date		= '" . aveEscT($ObjectPublishDateText) . "', " .
			"			object_security_level	= '" . intval($_REQUEST['object_security_level']) . "' " .
			"	WHERE	object_id = '" . intval($BundleRule['discount_bundle_rule_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	UPDATE	object_link " .
			"	SET		object_name	= '" . aveEscT($_REQUEST['object_name']) . "' " .
			"	WHERE	object_id = '" . intval($BundleRule['discount_bundle_rule_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$DiscountCode = explode(",", $_REQUEST['discount_bundle_rule_discount_code']);
$DiscountCodeText = ', ';
foreach ($DiscountCode as $T) {
	if (strlen(trim($T)) > 0)
		$DiscountCodeText = $DiscountCodeText . trim($T) . ", ";
}
if ($DiscountCodeText == ', ')
	$DiscountCodeText = ', , ';

$query =	"	UPDATE	discount_bundle_rule " .
			"	SET		discount_bundle_rule_discount_code				= '" . aveEscT($DiscountCodeText) . "', " .
			"			discount_bundle_rule_quota_user					= '" . intval($_REQUEST['discount_bundle_rule_quota_user']) . "', " .
			"			discount_bundle_rule_quota_all					= '" . intval($_REQUEST['discount_bundle_rule_quota_all']) . "', " .
			"			discount_bundle_rule_apply_to_bonus_point_payment_products = '" . ynval($_REQUEST['discount_bundle_rule_apply_to_bonus_point_payment_products']) . "', " .
			"			discount_bundle_rule_quota_discount_code		= '" . intval($_REQUEST['discount_bundle_rule_quota_discount_code']) . "', " .
			"			discount_bundle_rule_stop_process_below_rules	= '" . ynval($_REQUEST['discount_bundle_rule_stop_process_below_rules']) . "', " .
			"			discount_bundle_rule_stop_process_prepostprocess_rules	= '" . ynval($_REQUEST['discount_bundle_rule_stop_process_prepostprocess_rules']) . "' " .
			"	WHERE	discount_bundle_rule_id = '" . $BundleRule['discount_bundle_rule_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

foreach ($SiteLanguageRoots as $R) {
	discount::TouchBundleRuleData($BundleRule['discount_bundle_rule_id'], $R['language_id']);
	
	$query =	"	UPDATE	discount_bundle_rule_data " .
				"	SET		discount_bundle_rule_name = '" . aveEscT($_REQUEST['discount_bundle_rule_name'][$R['language_id']]) . "', " .
				"			discount_bundle_rule_desc = '" . aveEscT($_REQUEST['ContentEditor' . $R['language_id']]) . "'" .			
				"	WHERE	discount_bundle_rule_id = '" . intval($BundleRule['discount_bundle_rule_id']) . "'" .
				"		AND	language_id	= '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

// Now Handle Item Cost Filter
$query =	"	DELETE FROM	discount_bundle_item_cost_aware_condition " .
			"	WHERE	discount_bundle_rule_id = '" . intval($BundleRule['discount_bundle_rule_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

foreach ($_REQUEST['discount_bundle_item_cost_condition_type_id'] as $key => $value) {
	if (intval($_REQUEST['cost_quantity'][$key]) <= 0)
		$_REQUEST['cost_quantity'][$key] = 1;
	
	if ($value == 1) {
		$ProductCat = product::GetProductCatInfo($_REQUEST['cost_product_category_id'][$key], 0);
		if ($ProductCat['site_id'] != $_SESSION['site_id'])
			continue;

		$query =	"	INSERT INTO discount_bundle_item_cost_aware_condition " .
					"	SET		discount_bundle_item_condition_type_id	= 1, " .
					"			discount_bundle_item_condition_product_category_id = '" . aveEscT($_REQUEST['cost_product_category_id'][$key]) . "', " .
					"			discount_bundle_item_condition_include_sub_category = '" . aveEscT($_REQUEST['cost_include_sub_product_cat'][$key]) . "', " .
					"			discount_bundle_item_condition_quantity = '" . aveEscT($_REQUEST['cost_quantity'][$key]) . "', " .
					"			discount_bundle_rule_id = '" . $BundleRule['discount_bundle_rule_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	elseif ($value == 2) {
		$ProductSpecialCat = product::GetProductCatSpecialInfo($_REQUEST['cost_product_category_special_id'][$key], 0);
		if ($ProductSpecialCat['site_id'] != $_SESSION['site_id'])
			continue;
		
		$query =	"	INSERT INTO discount_bundle_item_cost_aware_condition " .
					"	SET		discount_bundle_item_condition_type_id	= 2, " .
					"			discount_bundle_item_condition_product_category_id = '" . aveEscT($_REQUEST['cost_product_category_special_id'][$key]) . "', " .
					"			discount_bundle_item_condition_quantity = '" . aveEscT($_REQUEST['cost_quantity'][$key]) . "', " .
					"			discount_bundle_rule_id = '" . $BundleRule['discount_bundle_rule_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	elseif ($value == 3) {
		$Product = product::GetProductInfo($_REQUEST['cost_product_id'][$key], 0);

		if ($Product['site_id'] != $_SESSION['site_id'])
			continue;
		
		$query =	"	INSERT INTO discount_bundle_item_cost_aware_condition " .
					"	SET		discount_bundle_item_condition_type_id	= 3, " .
					"			discount_bundle_item_condition_product_id = '" . aveEscT($_REQUEST['cost_product_id'][$key]) . "', " .
					"			discount_bundle_item_condition_quantity = '" . aveEscT($_REQUEST['cost_quantity'][$key]) . "', " .
					"			discount_bundle_rule_id = '" . $BundleRule['discount_bundle_rule_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
	}
}

// Now Handle Item Free Filter
$query =	"	DELETE FROM	discount_bundle_item_free_condition " .
			"	WHERE	discount_bundle_rule_id = '" . $BundleRule['discount_bundle_rule_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

foreach ($_REQUEST['discount_bundle_item_free_condition_type_id'] as $key => $value) {
	if (intval($_REQUEST['free_quantity'][$key]) <= 0)
		$_REQUEST['free_quantity'][$key] = 1;
	
	if ($value == 1) {
		$ProductCat = product::GetProductCatInfo($_REQUEST['free_product_category_id'][$key], 0);
		if ($ProductCat['site_id'] != $_SESSION['site_id'])
			continue;

		$query =	"	INSERT INTO discount_bundle_item_free_condition " .
					"	SET		discount_bundle_item_condition_type_id	= 1, " .
					"			discount_bundle_item_condition_product_category_id = '" . aveEscT($_REQUEST['free_product_category_id'][$key]) . "', " .
					"			discount_bundle_item_condition_include_sub_category = '" . aveEscT($_REQUEST['free_include_sub_product_cat'][$key]) . "', " .
					"			discount_bundle_item_condition_quantity = '" . aveEscT($_REQUEST['free_quantity'][$key]) . "', " .
					"			discount_bundle_rule_id = '" . $BundleRule['discount_bundle_rule_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	elseif ($value == 2) {
		$ProductSpecialCat = product::GetProductCatSpecialInfo($_REQUEST['free_product_category_special_id'][$key], 0);
		if ($ProductSpecialCat['site_id'] != $_SESSION['site_id'])
			continue;
		
		$query =	"	INSERT INTO discount_bundle_item_free_condition " .
					"	SET		discount_bundle_item_condition_type_id	= 2, " .
					"			discount_bundle_item_condition_product_category_id = '" . aveEscT($_REQUEST['free_product_category_special_id'][$key]) . "', " .
					"			discount_bundle_item_condition_quantity = '" . aveEscT($_REQUEST['free_quantity'][$key]) . "', " .
					"			discount_bundle_rule_id = '" . $BundleRule['discount_bundle_rule_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	elseif ($value == 3) {
		$Product = product::GetProductInfo($_REQUEST['free_product_id'][$key], 0);

		if ($Product['site_id'] != $_SESSION['site_id'])
			continue;
		
		$query =	"	INSERT INTO discount_bundle_item_free_condition " .
					"	SET		discount_bundle_item_condition_type_id	= 3, " .
					"			discount_bundle_item_condition_product_id = '" . aveEscT($_REQUEST['free_product_id'][$key]) . "', " .
					"			discount_bundle_item_condition_quantity = '" . aveEscT($_REQUEST['free_quantity'][$key]) . "', " .
					"			discount_bundle_rule_id = '" . $BundleRule['discount_bundle_rule_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

// Now Handle Discount 
$CurrencyList = array();

if ($Site['site_product_price_indepedent_currency'] == 'Y') {
	$CurrencyList = currency::GetAllSiteCurrencyList($_SESSION['site_id']);			
}
else {
	array_push($CurrencyList, array('currency_id' => 0));
}

discount::CleanUpBundleRulePriceList($BundleRule['discount_bundle_rule_id']);

foreach ($CurrencyList as $C) {
	$i = intval($C['currency_id']);
	
	if ($_REQUEST['discount_bundle_discount_type_id'][$i] < 0)
		continue;
	
	if (intval($_REQUEST['discount_bundle_discount1_off_p'][$i]) < 0 || intval($_REQUEST['discount_bundle_discount1_off_p'][$i]) > 100)
		$_REQUEST['discount_bundle_discount1_off_p'][$i] = 0;
	if (doubleval($_REQUEST['discount_bundle_discount2_at_price'][$i]) < 0)
		$_REQUEST['discount_bundle_discount2_at_price'][$i] = 0;
	if (doubleval($_REQUEST['discount_bundle_discount3_add_price'][$i]) < 0)
		$_REQUEST['discount_bundle_discount3_add_price'][$i] = 0;

	$sql_update = 				
				"			discount_bundle_discount_type_id	= '" . aveEscT($_REQUEST['discount_bundle_discount_type_id'][$i]) . "', " .
				"			discount_bundle_discount1_off_p		= '" . aveEscT($_REQUEST['discount_bundle_discount1_off_p'][$i]) . "', " .
				"			discount_bundle_discount2_at_price	= '" . aveEscT($_REQUEST['discount_bundle_discount2_at_price'][$i]) . "', " .
				"			discount_bundle_discount3_add_price	= '" . aveEscT($_REQUEST['discount_bundle_discount3_add_price'][$i]) . "' ";
	
	$query =	"	INSERT INTO	discount_bundle_rule_price " .
				"	SET		" . 
				"			discount_bundle_rule_id				= '" . $BundleRule['discount_bundle_rule_id'] . "', " .
				"			currency_id = '" . $i . "', " .
				$sql_update .
				"	ON DUPLICATE KEY UPDATE " . $sql_update;
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

discount::UpdateTimeStamp($_REQUEST['id']);

header( 'Location: discount_bundle_rule_edit.php?id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));