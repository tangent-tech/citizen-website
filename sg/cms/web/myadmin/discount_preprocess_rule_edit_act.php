<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_preprocess_rule_list');
$smarty->assign('MyJS', 'discount_preprocess_rule_edit_act');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$PreprocessRule = discount::GetPreprocessRuleInfo($_REQUEST['id'], 0);
if ($PreprocessRule['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'discount_preprocess_rule_list.php', __LINE__);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

$query	=	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['object_is_enable']) . "', " .
			"			object_archive_date		= '" . aveEscT($ObjectArchiveDateText) . "', " .
			"			object_publish_date		= '" . aveEscT($ObjectPublishDateText) . "', " .
			"			object_security_level	= '" . intval($_REQUEST['object_security_level']) . "' " .
			"	WHERE	object_id = '" . $PreprocessRule['discount_preprocess_rule_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	UPDATE	object_link " .
			"	SET		object_name	= '" . aveEscT($_REQUEST['object_name']) . "' " .
			"	WHERE	object_id = '" . $PreprocessRule['discount_preprocess_rule_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$DiscountCode = explode(",", $_REQUEST['discount_preprocess_rule_discount_code']);
$DiscountCodeText = ', ';
foreach ($DiscountCode as $T) {
	if (strlen(trim($T)) > 0)
		$DiscountCodeText = $DiscountCodeText . trim($T) . ", ";
}
if ($DiscountCodeText == ', ')
	$DiscountCodeText = ', , ';

$query =	"	UPDATE	discount_preprocess_rule " .
			"	SET		discount_preprocess_rule_discount_code				= '" . aveEsc($DiscountCodeText) . "', " .
			"			discount_preprocess_rule_quota_user					= '" . intval($_REQUEST['discount_preprocess_rule_quota_user']) . "', " .
			"			discount_preprocess_rule_quota_all					= '" . intval($_REQUEST['discount_preprocess_rule_quota_all']) . "', " .
			"			discount_preprocess_rule_apply_to_bonus_point_payment_products = '" . ynval($_REQUEST['discount_preprocess_rule_apply_to_bonus_point_payment_products']) . "', " .
			"			discount_preprocess_rule_quota_discount_code		= '" . intval($_REQUEST['discount_preprocess_rule_quota_discount_code']) . "', " .
			"			discount_preprocess_rule_stop_process_below_rules	= '" . ynval($_REQUEST['discount_preprocess_rule_stop_process_below_rules']) . "', " .
			"			discount_preprocess_rule_stop_process_postprocess_rules	= '" . ynval($_REQUEST['discount_preprocess_rule_stop_process_postprocess_rules']) . "' " .
			"	WHERE	discount_preprocess_rule_id = '" . $PreprocessRule['discount_preprocess_rule_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

foreach ($SiteLanguageRoots as $R) {
	discount::TouchPreprocessRuleData($PreprocessRule['discount_preprocess_rule_id'], $R['language_id']);
	
	$query =	"	UPDATE	discount_preprocess_rule_data " .
				"	SET		discount_preprocess_rule_name = '" . aveEscT($_REQUEST['discount_preprocess_rule_name'][$R['language_id']]) . "', " .
				"			discount_preprocess_rule_desc = '" . aveEscT($_REQUEST['ContentEditor' . $R['language_id']]) . "'" .
				"	WHERE	discount_preprocess_rule_id = '" . $PreprocessRule['discount_preprocess_rule_id'] . "'" .
				"		AND	language_id	= '" . $R['language_id'] . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

// Now Handle Item Filter
$query =	"	DELETE FROM	discount_preprocess_item_condition " .
			"	WHERE	discount_preprocess_rule_id = '" . $PreprocessRule['discount_preprocess_rule_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

foreach ($_REQUEST['discount_preprocess_item_condition_type_id'] as $key => $value) {
	if ($value == 1) {
		$ProductCat = product::GetProductCatInfo($_REQUEST['product_category_id'][$key], 0);
		if ($ProductCat['site_id'] != $_SESSION['site_id'])
			continue;

		$query =	"	INSERT INTO discount_preprocess_item_condition " .
					"	SET		discount_preprocess_item_condition_type_id	= 1, " .
					"			discount_preprocess_item_condition_para_int_1 = '" . aveEscT($_REQUEST['product_category_id'][$key]) . "', " .
					"			discount_preprocess_item_condition_para_int_2 = '" . aveEscT($_REQUEST['include_sub_product_cat'][$key]) . "', " .
					"			discount_preprocess_rule_id = '" . $PreprocessRule['discount_preprocess_rule_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	elseif ($value == 2) {
		$ProductBrand = product::GetProductBrandInfo($_REQUEST['product_brand_id'][$key], 0);

		if ($ProductBrand['site_id'] != $_SESSION['site_id'])
			continue;
		
		$query =	"	INSERT INTO discount_preprocess_item_condition " .
					"	SET		discount_preprocess_item_condition_type_id	= 2, " .
					"			discount_preprocess_item_condition_para_int_1 = '" . aveEscT($_REQUEST['product_brand_id'][$key]) . "', " .
					"			discount_preprocess_rule_id = '" . $PreprocessRule['discount_preprocess_rule_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);		
	}
	elseif ($value == 3) {
		$ProductSpecialCat = product::GetProductCatSpecialInfo($_REQUEST['product_category_special_id'][$key], 0);
		if ($ProductSpecialCat['site_id'] != $_SESSION['site_id'])
			continue;
		
		$query =	"	INSERT INTO discount_preprocess_item_condition " .
					"	SET		discount_preprocess_item_condition_type_id	= 3, " .
					"			discount_preprocess_item_condition_para_int_1 = '" . aveEscT($_REQUEST['product_category_special_id'][$key]) . "', " .
					"			discount_preprocess_rule_id = '" . $PreprocessRule['discount_preprocess_rule_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}


// Now Handle Item Except Filter
$query =	"	DELETE FROM	discount_preprocess_item_except_condition " .
			"	WHERE	discount_preprocess_rule_id = '" . $PreprocessRule['discount_preprocess_rule_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

foreach ($_REQUEST['discount_preprocess_item_except_condition_type_id'] as $key => $value) {
	if ($value == 1) {
		$ProductCat = product::GetProductCatInfo($_REQUEST['except_product_category_id'][$key], 0);
		if ($ProductCat['site_id'] != $_SESSION['site_id'])
			continue;

		$query =	"	INSERT INTO discount_preprocess_item_except_condition " .
					"	SET		discount_preprocess_item_except_condition_type_id	= 1, " .
					"			discount_preprocess_item_except_condition_para_int_1 = '" . aveEscT($_REQUEST['except_product_category_id'][$key]) . "', " .
					"			discount_preprocess_item_except_condition_para_int_2 = '" . aveEscT($_REQUEST['except_include_sub_product_cat'][$key]) . "', " .
					"			discount_preprocess_rule_id = '" . $PreprocessRule['discount_preprocess_rule_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	elseif ($value == 2) {
		$ProductBrand = product::GetProductBrandInfo($_REQUEST['product_brand_id'][$key], 0);

		if ($ProductBrand['site_id'] != $_SESSION['site_id'])
			continue;
		
		$query =	"	INSERT INTO discount_preprocess_item_except_condition " .
					"	SET		discount_preprocess_item_except_condition_type_id	= 2, " .
					"			discount_preprocess_item_except_condition_para_int_1 = '" . aveEscT($_REQUEST['product_brand_id'][$key]) . "', " .
					"			discount_preprocess_rule_id = '" . $PreprocessRule['discount_preprocess_rule_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
	}
	elseif ($value == 3) {
		$ProductSpecialCat = product::GetProductCatSpecialInfo($_REQUEST['product_category_special_id'][$key], 0);
		if ($ProductSpecialCat['site_id'] != $_SESSION['site_id'])
			continue;
		
		$query =	"	INSERT INTO discount_preprocess_item_except_condition " .
					"	SET		discount_preprocess_item_except_condition_type_id	= 3, " .
					"			discount_preprocess_item_except_condition_para_int_1 = '" . aveEscT($_REQUEST['product_category_special_id'][$key]) . "', " .
					"			discount_preprocess_rule_id = '" . $PreprocessRule['discount_preprocess_rule_id'] . "'";
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

discount::CleanUpPreprocessRulePriceList($PreprocessRule['discount_preprocess_rule_id']);

foreach ($CurrencyList as $C) {
	$i = intval($C['currency_id']);
	
	if ($_REQUEST['discount_preprocess_discount_type_id'][$i] < 0)
		continue;
	
	if (intval($_REQUEST['discount_preprocess_discount1_min_quantity'][$i]) <= 0)
		$_REQUEST['discount_preprocess_discount1_min_quantity'][$i] = 0;

	if (intval($_REQUEST['discount_preprocess_discount1_off_p'][$i]) < 0 || intval($_REQUEST['discount_preprocess_discount1_off_p'][$i]) > 100)
		$_REQUEST['discount_preprocess_discount1_off_p'][$i] = 0;


	if (intval($_REQUEST['discount_preprocess_discount2_price'][$i]) < 0) {
		$_REQUEST['discount_preprocess_discount2_price'][$i] = 0;
		$_REQUEST['discount_preprocess_discount2_amount'][$i] = 0;
	}
	elseif (doubleval($_REQUEST['discount_preprocess_discount2_amount'][$i]) <= 0) {
		$_REQUEST['discount_preprocess_discount2_amount'][$i] = 1;
	}

	$sql_update =
				"			discount_preprocess_discount_type_id		= '" . aveEscT($_REQUEST['discount_preprocess_discount_type_id'][$i]) . "', " .
				"			discount_preprocess_discount1_min_quantity	= '" . aveEscT($_REQUEST['discount_preprocess_discount1_min_quantity'][$i]) . "', " .
				"			discount_preprocess_discount1_off_p			= '" . aveEscT($_REQUEST['discount_preprocess_discount1_off_p'][$i]) . "', " .
				"			discount_preprocess_discount2_amount		= '" . aveEscT($_REQUEST['discount_preprocess_discount2_amount'][$i]) . "', " .
				"			discount_preprocess_discount2_price			= '" . aveEscT($_REQUEST['discount_preprocess_discount2_price'][$i]) . "' ";
	
	$query =	"	INSERT INTO	discount_preprocess_rule_price " . 
				"	SET		" . 
				"			discount_preprocess_rule_id					= '" . $PreprocessRule['discount_preprocess_rule_id'] . "', " .
				"			currency_id = '" . $i . "', " .
				$sql_update .
				"	ON DUPLICATE KEY UPDATE " . $sql_update;
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

discount::UpdateTimeStamp($_REQUEST['id']);

header( 'Location: discount_preprocess_rule_edit.php?id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));