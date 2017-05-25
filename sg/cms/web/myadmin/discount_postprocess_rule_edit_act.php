<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_preprocess_rule_list');
$smarty->assign('MyJS', 'discount_postprocess_rule_edit_act');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$PostprocessRule = discount::GetPostprocessRuleInfo($_REQUEST['id'], 0);
if ($PostprocessRule['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'discount_postprocess_rule_list.php', __LINE__);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

$query	=	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['object_is_enable']) . "', " .
			"			object_archive_date		= '" . aveEscT($ObjectArchiveDateText) . "', " .
			"			object_publish_date		= '" . aveEscT($ObjectPublishDateText) . "', " .
			"			object_security_level	= '" . intval($_REQUEST['object_security_level']) . "' " .
			"	WHERE	object_id = '" . $PostprocessRule['discount_postprocess_rule_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	UPDATE	object_link " .
			"	SET		object_name	= '" . aveEscT($_REQUEST['object_name']) . "' " .
			"	WHERE	object_id = '" . $PostprocessRule['discount_postprocess_rule_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$DiscountCode = explode(",", $_REQUEST['discount_postprocess_rule_discount_code']);
$DiscountCodeText = ', ';
foreach ($DiscountCode as $T) {
	if (strlen(trim($T)) > 0)
		$DiscountCodeText = $DiscountCodeText . trim($T) . ", ";
}
if ($DiscountCodeText == ', ')
	$DiscountCodeText = ', , ';

$query =	"	UPDATE	discount_postprocess_rule " .
			"	SET		discount_postprocess_rule_discount_code			= '" . aveEsc($DiscountCodeText) . "', " .
			"			discount_postprocess_rule_quota_discount_code	= '" . intval($_REQUEST['discount_postprocess_rule_quota_discount_code']) . "', " .
			"			discount_postprocess_rule_quota_user			= '" . intval($_REQUEST['discount_postprocess_rule_quota_user']) . "', " .
			"			discount_postprocess_rule_quota_all				= '" . intval($_REQUEST['discount_postprocess_rule_quota_all']) . "' " .
			"	WHERE	discount_postprocess_rule_id = '" . $PostprocessRule['discount_postprocess_rule_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

foreach ($SiteLanguageRoots as $R) {
	discount::TouchPostprocessRuleData($PostprocessRule['discount_postprocess_rule_id'], $R['language_id']);
	
	$query =	"	UPDATE	discount_postprocess_rule_data " .
				"	SET		discount_postprocess_rule_name	= '" . aveEscT($_REQUEST['discount_postprocess_rule_name'][$R['language_id']]) . "' " .
				"	WHERE	discount_postprocess_rule_id	= '" . $PostprocessRule['discount_postprocess_rule_id'] . "'" .
				"		AND	language_id	= '" . $R['language_id'] . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

// Now Handle Discount Level
$CurrencyList = array();

if ($Site['site_product_price_indepedent_currency'] == 'Y') {
	$CurrencyList = currency::GetAllSiteCurrencyList($_SESSION['site_id']);			
}
else {
	array_push($CurrencyList, array('currency_id' => 0));
}

discount::CleanUpPostprocessRulePriceList($PostprocessRule['discount_postprocess_rule_id']);

foreach ($CurrencyList as $C) {
	$i = intval($C['currency_id']);
	
	if ($_REQUEST['discount_postprocess_discount_type_id_' . $i] <= 0)
		continue;
	
	$DiscountLevelList = array();
	$DiscountLevelList[0] = array();
	$DiscountLevelList[0]['discount_postprocess_discount_level_type_id'] = intval($_REQUEST['discount_postprocess_discount_level_type_id_' . $i][0]);
	$DiscountLevelList[0]['discount_postprocess_discount1_off_p'] = intval($_REQUEST['discount_postprocess_discount1_off_p_' . $i][0]);
	$DiscountLevelList[0]['discount_postprocess_discount2_minus_amount'] = doubleval($_REQUEST['discount_postprocess_discount2_minus_amount_' . $i][0]);

	foreach($_REQUEST['discount_postprocess_discount_level_min_' . $i] as $key => $value) {
		if (intval($value) > 0 && intval($_REQUEST['discount_postprocess_discount_level_type_id_' . $i][$key]) > 0) {
			$DiscountLevelList[intval($value)] = array();
			$DiscountLevelList[intval($value)]['discount_postprocess_discount_level_type_id'] = intval($_REQUEST['discount_postprocess_discount_level_type_id_' . $i][$key]);
			$DiscountLevelList[intval($value)]['discount_postprocess_discount1_off_p'] = intval($_REQUEST['discount_postprocess_discount1_off_p_' . $i][$key]);
			$DiscountLevelList[intval($value)]['discount_postprocess_discount2_minus_amount'] = doubleval($_REQUEST['discount_postprocess_discount2_minus_amount_' . $i][$key]);
		}
	}

	krsort($DiscountLevelList);
	$LastMin = 99999999;
	foreach($DiscountLevelList as $key => $value) {
		$query =	"	INSERT INTO	discount_postprocess_discount_level " .
					"	SET		discount_postprocess_discount_level_min		= '" . aveEscT($key) . "', " .
					"			discount_postprocess_discount_level_max		= '" . aveEscT($LastMin) . "', " .
					"			discount_postprocess_discount_level_type_id	= '" . aveEscT($value['discount_postprocess_discount_level_type_id']) . "', " .
					"			discount_postprocess_discount1_off_p		= '" . aveEscT($value['discount_postprocess_discount1_off_p']) . "', " .
					"			discount_postprocess_discount2_minus_amount	= '" . aveEscT($value['discount_postprocess_discount2_minus_amount']) . "', " .
					"			discount_postprocess_rule_id				= '" . $PostprocessRule['discount_postprocess_rule_id'] . "', " .
					"			currency_id									= '" . $i . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$LastMin = $key;
	}
	
	$sql_update = "	discount_postprocess_discount_type_id = '" . aveEscT($_REQUEST['discount_postprocess_discount_type_id_' . $i]) . "'";
			
	$query =	"	INSERT INTO	discount_postprocess_rule_price " .
				"	SET		" .
				"			discount_postprocess_rule_id				= '" . $PostprocessRule['discount_postprocess_rule_id'] . "', " .
				"			currency_id									= '" . $i . "', " .
				$sql_update .
				"	ON DUPLICATE KEY UPDATE " . $sql_update;
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

discount::UpdateTimeStamp($_REQUEST['id']);

header( 'Location: discount_postprocess_rule_edit.php?id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));