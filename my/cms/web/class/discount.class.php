<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class discount {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetPostprocessRuleXML($RuleID, $LanguageID) {
		$smarty = new mySmarty();

		$PostProcessRule = discount::GetPostprocessRuleInfo($RuleID, $LanguageID);

		$smarty->assign('Object', $PostProcessRule);
		$PostProcessRuleXML = $smarty->fetch('api/object_info/DISCOUNT_POSTPROCESS_RULE.tpl');
		return $PostProcessRuleXML;
	}

	public static function GetPreprocessRuleXML($RuleID, $LanguageID) {
		$smarty = new mySmarty();

		$PreProcessRule = discount::GetPreprocessRuleInfo($RuleID, $LanguageID);

		$smarty->assign('Object', $PreProcessRule);
		$PreProcessRuleXML = $smarty->fetch('api/object_info/DISCOUNT_PREPROCESS_RULE.tpl');
		return $PreProcessRuleXML;
	}

	public static function GetBundleRuleXML($RuleID, $LanguageID, $UserSecurityLevel) {
		$smarty = new mySmarty();

		$BundleRule = discount::GetBundleRuleInfo($RuleID, $LanguageID);

		$CostAwareConditionListXML = '';
		$FreeConditionListXML = '';

		$CostAwareConditionList = discount::GetBundleItemCostAwareCondition($RuleID);
		foreach ($CostAwareConditionList as $C) {
			$CostAwareConditionListXML .= discount::GetBundleDiscountConditionXML($C, $RuleID, $UserSecurityLevel, $LanguageID);
		}

		$FreeConditionList = discount::GetBundleItemFreeCondition($RuleID);
		foreach ($FreeConditionList as $C) {
			$FreeConditionListXML .= discount::GetBundleDiscountConditionXML($C, $RuleID, $UserSecurityLevel, $LanguageID);
		}

		$smarty->assign('Object', $BundleRule);
		$smarty->assign('CostAwareConditionListXML', $CostAwareConditionListXML);
		$smarty->assign('FreeConditionListXML', $FreeConditionListXML);

		$BundleRuleXML = $smarty->fetch('api/object_info/DISCOUNT_BUNDLE_RULE.tpl');
		return $BundleRuleXML;
	}		

	public static function IsPostprocessRuleRemovable($RuleID) {
		$query =	"	SELECT	* " .
					"	FROM	myorder " .
					"	WHERE	effective_discount_postprocess_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return false;
		else
			return true;
	}

	public static function IsPreprocessRuleRemovable($RuleID) {
		$query =	"	SELECT	* " .
					"	FROM	myorder_product " .
					"	WHERE	effective_discount_preprocess_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return false;
		else
			return true;
	}

	public static function GetPreprocessRuleList($SiteID, $IsEnabled = 'ALL', $SecurityLevel = 0, $HonorArchiveDate = false, $HonorPublishDate = false, $DiscountCode = null, $IncludeBlankDiscountCodeRule = false, $CurrencyID = null, $LangID = 0) {
		$sql = '';
		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	RO.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	RO.object_publish_date < NOW() ";
		if ($IsEnabled != 'ALL')
			$sql	=	$sql . "	AND RO.object_is_enable = '" . ynval($IsEnabled) . "'";
		if ($DiscountCode !== null && !$IncludeBlankDiscountCodeRule) {
			$sql = $sql . " AND R.discount_preprocess_rule_discount_code LIKE '%, " . aveEscT($DiscountCode) . ",%'";
		}
		if ($DiscountCode !== null && $IncludeBlankDiscountCodeRule) {
			$sql = $sql . " AND (R.discount_preprocess_rule_discount_code LIKE '%, " . aveEscT($DiscountCode) . ",%' OR R.discount_preprocess_rule_discount_code LIKE '%, ,%') ";
		}

		$join_sql = '';
		if ($CurrencyID !== null) {
			$join_sql = " JOIN	discount_preprocess_rule_price P ON (R.discount_preprocess_rule_id = P.discount_preprocess_rule_id AND P.currency_id = '" . intval($intvalCurrencyID) . "') ";
		}

		$query =	"	SELECT	*, R.* " .
					"	FROM	object_link OL	JOIN	object RO					ON (OL.object_id = RO.object_id	AND	RO.object_type = 'DISCOUNT_PREPROCESS_RULE' AND RO.site_id = '" . intval($SiteID) . "') " .
					"							JOIN	discount_preprocess_rule R	ON (R.discount_preprocess_rule_id = RO.object_id) " . $join_sql .
					"						LEFT JOIN	discount_preprocess_rule_data D ON (D.discount_preprocess_rule_id = R.discount_preprocess_rule_id AND D.language_id = '" . intval($LangID) . "') " .
					"	WHERE	RO.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql .
					"	ORDER BY	OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$RuleList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($RuleList, $myResult);
		}
		return $RuleList;
	}

	public static function GetEffectivePostprocessDiscountLevel($Value, $RuleID, $CurrencyID = 0) {
		$query =	"	SELECT	* " .
					"	FROM	discount_postprocess_discount_level L " .
					"	WHERE	L.discount_postprocess_rule_id	= '" . intval($RuleID) . "'" .
					"		AND	L.discount_postprocess_discount_level_min <= '" . intval($Value) . "'" .
					"		AND	L.discount_postprocess_discount_level_max > '" . intval($Value) . "'" .
					"		AND L.currency_id = '" . intval($CurrencyID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetPreprocessRuleQtyUsageForUser($RuleID, $UserID) {
		$query =	"	SELECT	SUM(P.quantity) AS TotalQty " .
					"	FROM	myorder_product P JOIN myorder O ON (O.myorder_id = P.myorder_id) " .
					"	WHERE	P.effective_discount_preprocess_rule_id = '" . intval($RuleID) . "'" . 
					"		AND	O.order_status != 'order_cancelled' " .
					"		AND O.order_status != 'void' " .
					"		AND	O.user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			return $myResult['TotalQty'];
		}
		else {
			return 0;
		}			
	}

	public static function GetPreprocessRuleQtyUsageForGlobal($RuleID) {
		$query =	"	SELECT	SUM(P.quantity) AS TotalQty " .
					"	FROM	myorder_product P JOIN myorder O ON (O.myorder_id = P.myorder_id) " .
					"	WHERE	P.effective_discount_preprocess_rule_id = '" . intval($RuleID) . "'" .
					"		AND	O.order_status != 'order_cancelled' " .
					"		AND O.order_status != 'void' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			return $myResult['TotalQty'];
		}
		else {
			return 0;
		}			
	}

	public static function GetPreprocessRuleUsageForDiscountCode($RuleID, $DiscountCode) {
		$query =	"	SELECT	* " .
					"	FROM	myorder_product P JOIN myorder O ON (O.myorder_id = P.myorder_id) " .
					"	WHERE	P.effective_discount_preprocess_rule_id = '" . intval($RuleID) . "'" . 
					"		AND	P.effective_discount_preprocess_code = '" . aveEscT($DiscountCode) . "'" .
					"		AND	O.order_status != 'order_cancelled' " .
					"		AND O.order_status != 'void' " .
					"	GROUP BY P.myorder_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		return $result->num_rows;
	}

	public static function GetPostprocessRuleUsageForDiscountCode($RuleID, $DiscountCode) {
		$query =	"	SELECT	* " .
					"	FROM	myorder O " .
					"	WHERE	O.effective_discount_postprocess_rule_id = '" . intval($RuleID) . "'" . 
					"		AND	O.effective_discount_postprocess_rule_discount_code = '" . aveEscT($DiscountCode) . "'" .
					"		AND	O.order_status != 'order_cancelled' " .
					"		AND O.order_status != 'void' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		return $result->num_rows;
	}

	public static function GetPostprocessRuleUsageForUser($RuleID, $UserID) {
		$query =	"	SELECT	* " .
					"	FROM	myorder O " .
					"	WHERE	O.effective_discount_postprocess_rule_id = '" . intval($RuleID) . "'" . 
					"		AND	O.user_id = '" . intval($UserID) . "'" .
					"		AND	O.order_status != 'order_cancelled' " .
					"		AND O.order_status != 'void' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		return $result->num_rows;
	}

	public static function GetPostprocessRuleUsageForGlobal($RuleID) {
		$query =	"	SELECT	* " .
					"	FROM	myorder O " .
					"	WHERE	O.effective_discount_postprocess_rule_id = '" . intval($RuleID) . "'" .
					"		AND	O.order_status != 'order_cancelled' " .
					"		AND O.order_status != 'void' ";					
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		return $result->num_rows;
	}		

	public static function GetPostprocessRuleList($SiteID, $IsEnabled = 'ALL', $SecurityLevel = 0, $HonorArchiveDate = false, $HonorPublishDate = false, $DiscountCode = null, $UserID = 0, $CurrencyID = null) {
		$sql = '';
		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	RO.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	RO.object_publish_date < NOW() ";
		if ($IsEnabled != 'ALL')
			$sql	=	$sql . "	AND RO.object_is_enable = '" . ynval($IsEnabled) . "'";

		if ($DiscountCode !== null) {
//				$sql	=	$sql . "	AND	R.discount_postprocess_rule_discount_code = '" . $DiscountCode . "'";
			$sql = $sql . " AND R.discount_postprocess_rule_discount_code LIKE '%, " . aveEscT($DiscountCode) . ",%'";
		}

		$join_sql = '';
		if ($CurrencyID !== null) {
			$join_sql = " JOIN	discount_postprocess_rule_price P ON (R.discount_postprocess_rule_id = P.discount_postprocess_rule_id AND P.currency_id = '" . intval($CurrencyID) . "') ";
		}

		$query =	"	SELECT	* " .
					"	FROM	object_link OL	JOIN	object RO					ON (OL.object_id = RO.object_id	AND	RO.object_type = 'DISCOUNT_POSTPROCESS_RULE' AND RO.site_id = '" . intval($SiteID) . "') " .
					"							JOIN	discount_postprocess_rule R	ON (R.discount_postprocess_rule_id = RO.object_id) " . $join_sql .
					"	WHERE	RO.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql .
					"	ORDER BY	OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$RuleList = array();
		while ($myResult = $result->fetch_assoc()) {
			if ($UserID == -1) {
				array_push($RuleList, $myResult);
				continue;
			}
			else {
				$ValidRule = true;
				if ($myResult['discount_postprocess_rule_quota_user'] > 0 && $UserID != 0) {
					if (discount::GetPostprocessRuleUsageForUser($myResult['discount_postprocess_rule_id'], $UserID) >= $myResult['discount_postprocess_rule_quota_user'])
						$ValidRule = false;
				}
				if ($myResult['discount_postprocess_rule_quota_discount_code'] > 0) {
					if (discount::GetPostprocessRuleUsageForDiscountCode($myResult['discount_postprocess_rule_id'], $DiscountCode) >= $myResult['discount_postprocess_rule_quota_discount_code'])
						$ValidRule = false;
				}
				if ($myResult['discount_postprocess_rule_quota_all'] > 0 && $ValidRule) {
					if (discount::GetPostprocessRuleUsageForGlobal($myResult['discount_postprocess_rule_id']) >= $myResult['discount_postprocess_rule_quota_all'])
						$ValidRule = false;
				}

				if ($ValidRule)
					array_push($RuleList, $myResult);
			}

		}
		return $RuleList;
	}

	public static function NewPreprocessRule($RuleID, $DiscountCode) {
		$query =	"	INSERT INTO discount_preprocess_rule " .
					"	SET			discount_preprocess_rule_id = '" . intval($RuleID) . "', " .
					"				discount_preprocess_rule_discount_code = '" . aveEscT($DiscountCode) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function NewPostprocessRule($RuleID, $DiscountCode) {
		$query =	"	INSERT INTO discount_postprocess_rule " .
					"	SET			discount_postprocess_rule_id = '" . intval($RuleID) . "', " .
					"				discount_postprocess_rule_discount_code = '" . aveEscT($DiscountCode) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetPreprocessRuleInfo($RuleID, $LanguageID) {
		$query =	"	SELECT	*, RO.*, OL.*, R.* " .
					"	FROM	object_link OL	JOIN		object RO							ON (OL.object_id = RO.object_id) " .
					"							JOIN		discount_preprocess_rule R			ON (R.discount_preprocess_rule_id = RO.object_id) " .
					"							LEFT JOIN	discount_preprocess_rule_data RD	ON (R.discount_preprocess_rule_id = RD.discount_preprocess_rule_id AND RD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	RO.object_id	= '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetPostprocessRuleInfo($RuleID, $LanguageID) {
		$query =	"	SELECT	*, RO.*, OL.*, R.* " .
					"	FROM	object_link OL	JOIN		object RO							ON (OL.object_id = RO.object_id) " .
					"							JOIN		discount_postprocess_rule R			ON (R.discount_postprocess_rule_id = RO.object_id) " .
					"							LEFT JOIN	discount_postprocess_rule_data RD	ON (R.discount_postprocess_rule_id = RD.discount_postprocess_rule_id AND RD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	RO.object_id	= '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetPreprocessItemCondition($RuleID) {
		$query =	"	SELECT		* " .
					"	FROM		discount_preprocess_item_condition " .
					"	WHERE		discount_preprocess_rule_id	= '" . intval($RuleID) . "'" .
					"	ORDER BY	discount_preprocess_item_condition_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ItemConditionList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ItemConditionList, $myResult);
		}
		return $ItemConditionList;
	}

	public static function GetPreprocessItemExceptCondition($RuleID) {
		$query =	"	SELECT		* " .
					"	FROM		discount_preprocess_item_except_condition " .
					"	WHERE		discount_preprocess_rule_id	= '" . intval($RuleID) . "'" .
					"	ORDER BY	discount_preprocess_item_except_condition_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ItemConditionList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ItemConditionList, $myResult);
		}
		return $ItemConditionList;
	}

	public static function CleanUpPreprocessRulePriceList($RuleID) {
		$query =	"	DELETE FROM	discount_preprocess_rule_price " .
					"	WHERE	discount_preprocess_rule_id	= '" . intval($RuleID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetPreprocessRulePriceList($RuleID, $Site) {
		$RulePriceList = array();

		if ($Site['site_product_price_indepedent_currency'] == 'Y') {

			$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);

			foreach ($CurrencyList as $C) {
				$RulePriceList[intval($C['currency_id'])] = array();
				$RulePrice = discount::GetPreprocessRulePriceInfo($RuleID, $C['currency_id']);

				$RulePriceList[intval($C['currency_id'])]['price'] = $RulePrice;

				$RulePriceList[intval($C['currency_id'])]['currency_name'] = $C['currency_shortname'];
			}
		}
		else {
			$RulePriceList[0]['price'] = discount::GetPreprocessRulePriceInfo($RuleID, 0);
		}

		return $RulePriceList;
	}

	public static function GetPreprocessRulePriceInfo($RuleID, $CurrencyID) {
		$query =	"	SELECT	* " .
					"	FROM	discount_preprocess_rule_price " .
					"	WHERE	discount_preprocess_rule_id	= '" . intval($RuleID) . "' " .
					"		AND	currency_id = '" . intval($CurrencyID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function UpdateTimeStamp($RuleID) {
		object::UpdateObjectTimeStamp($RuleID);
	}

	public static function NewPreprocessRuleData($RuleID, $LanguageID, $RuleName = '') {
		$query =	"	INSERT INTO discount_preprocess_rule_data " .
					"	SET		discount_preprocess_rule_id	= '" . intval($RuleID) . "', " .
					"			language_id = '" . intval($LanguageID) . "', " .
					"			discount_preprocess_rule_name	= '" . aveEscT($RuleName) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function NewPostprocessRuleData($RuleID, $LanguageID, $RuleName = '') {
		$query =	"	INSERT INTO discount_postprocess_rule_data " .
					"	SET		discount_postprocess_rule_id	= '" . intval($RuleID) . "', " .
					"			language_id = '" . intval($LanguageID) . "', " .
					"			discount_postprocess_rule_name	= '" . aveEscT($RuleName) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function TouchPreprocessRuleData($RuleID, $LanguageID) {
		$query =	"	INSERT INTO discount_preprocess_rule_data " .
					"	SET		discount_preprocess_rule_id	= '" . intval($RuleID) . "', " .
					"			language_id = '" . intval($LanguageID) . "'" .
					"	ON DUPLICATE KEY UPDATE discount_preprocess_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function TouchPostprocessRuleData($RuleID, $LanguageID) {
		$query =	"	INSERT INTO discount_postprocess_rule_data " .
					"	SET		discount_postprocess_rule_id	= '" . intval($RuleID) . "', " .
					"			language_id = '" . intval($LanguageID) . "'" .
					"	ON DUPLICATE KEY UPDATE discount_postprocess_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function DeletePreprocessRule($RuleID) {
		if (!discount::IsPreprocessRuleRemovable($RuleID))
			return false;

		$PreprocessDiscountRule = discount::GetPreprocessRuleInfo($RuleID, 0);

		$query =	"	DELETE FROM	discount_preprocess_rule " .
					"	WHERE		discount_preprocess_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	discount_preprocess_rule_data " .
					"	WHERE		discount_preprocess_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	discount_preprocess_item_condition " .
					"	WHERE		discount_preprocess_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	discount_preprocess_rule_price " .
					"	WHERE		discount_preprocess_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($RuleID);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE		object_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::TidyUpObjectOrder($PreprocessDiscountRule['parent_object_id'], 'DISCOUNT_PREPROCESS_RULE');

		return true;
	}

	public static function GetPostprocessRulePrice($RuleID, $CurrencyID) {
		$query =	"	SELECT	* " .
					"	FROM	discount_postprocess_rule_price " .
					"	WHERE	discount_postprocess_rule_id	= '" . intval($RuleID) . "' " .
					"		AND	currency_id = '" . intval($CurrencyID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;			
	}

	public static function GetPostprocessDiscountLevel($RuleID, $CurrencyID = 0) {
		$query =	"	SELECT		* " .
					"	FROM		discount_postprocess_discount_level " .
					"	WHERE		discount_postprocess_rule_id	= '" . intval($RuleID) . "'" .
					"			AND	currency_id = '" . intval($CurrencyID) . "'" .
					"	ORDER BY	discount_postprocess_discount_level_min ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$DiscountLevelList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($DiscountLevelList, $myResult);
		}
		return $DiscountLevelList;
	}

	public static function GetPostprocessDiscountPriceInfoList($RuleID, $Site) {
		$RuleDiscountPriceInfoList = array();

		if ($Site['site_product_price_indepedent_currency'] == 'Y') {

			$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);

			foreach ($CurrencyList as $C) {
				$RuleDiscountPriceInfoList[intval($C['currency_id'])] = array();
				$RuleDiscountLevel = discount::GetPostprocessDiscountLevel($RuleID, $C['currency_id']);

				$RuleDiscountPriceInfoList[intval($C['currency_id'])]['level'] = $RuleDiscountLevel;
				$RuleDiscountPriceInfoList[intval($C['currency_id'])]['currency_name'] = $C['currency_shortname'];
				$RuleDiscountPriceInfoList[intval($C['currency_id'])]['price'] = discount::GetPostprocessRulePrice($RuleID, $C['currency_id']);
			}
		}
		else {
			$RuleDiscountPriceInfoList[0]['level'] = discount::GetPostprocessDiscountLevel($RuleID, 0);
			$RuleDiscountPriceInfoList[0]['price'] = discount::GetPostprocessRulePrice($RuleID, 0);
		}

		return $RuleDiscountPriceInfoList;			
	}

	public static function CleanUpPostprocessRulePriceList($RuleID) {
		$query =	"	DELETE FROM	discount_postprocess_discount_level " .
					"	WHERE	discount_postprocess_rule_id	= '" . intval($RuleID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	discount_postprocess_rule_price " .
					"	WHERE	discount_postprocess_rule_id	= '" . intval($RuleID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function DeletePostprocessRule($RuleID) {
		if (!discount::IsPostprocessRuleRemovable($RuleID))
			return false;

		$PostprocessDiscountRule = discount::GetPostprocessRuleInfo($RuleID, 0);

		$query =	"	DELETE FROM	discount_postprocess_rule " .
					"	WHERE		discount_postprocess_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	discount_postprocess_rule_price " .
					"	WHERE		discount_postprocess_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	 discount_postprocess_discount_level " .
					"	WHERE		discount_postprocess_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	discount_postprocess_rule_data " .
					"	WHERE		discount_postprocess_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($RuleID);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE		object_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::TidyUpObjectOrder($PostprocessDiscountRule['parent_object_id'], 'DISCOUNT_POSTPROCESS_RULE');

		return true;
	}

	public static function GetBundleRuleList($SiteID, $IsEnabled = 'ALL', $SecurityLevel = 0, $HonorArchiveDate = false, $HonorPublishDate = false, $DiscountCode = null, $IncludeBlankDiscountCodeRule = false, $CurrencyID = null, $LangID = 0) {
		$sql = '';
		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	RO.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	RO.object_publish_date < NOW() ";
		if ($IsEnabled != 'ALL')
			$sql	=	$sql . "	AND RO.object_is_enable = '" . ynval($IsEnabled) . "'";

		if ($DiscountCode !== null && !$IncludeBlankDiscountCodeRule) {
			$sql = $sql . " AND R.discount_bundle_rule_discount_code LIKE '%, " . aveEscT($DiscountCode) . ",%'";
		}
		if ($DiscountCode !== null && $IncludeBlankDiscountCodeRule) {
			$sql = $sql . " AND (R.discount_bundle_rule_discount_code LIKE '%, " . aveEscT($DiscountCode) . ",%' OR R.discount_bundle_rule_discount_code LIKE '%, ,%') ";
		}

		$join_sql = '';
		if ($CurrencyID !== null) {
			$join_sql = " JOIN	discount_bundle_rule_price P ON (R.discount_bundle_rule_id = P.discount_bundle_rule_id AND P.currency_id = '" . intval($CurrencyID) . "') ";
		}

		$query =	"	SELECT	*, R.* " .
					"	FROM	object_link OL	JOIN	object RO				ON (OL.object_id = RO.object_id	AND	RO.object_type = 'DISCOUNT_BUNDLE_RULE' AND RO.site_id = '" . intval($SiteID) . "') " .
					"							JOIN	discount_bundle_rule R	ON (R.discount_bundle_rule_id = RO.object_id) " . $join_sql .
					"						LEFT JOIN	discount_bundle_rule_data D ON (D.discount_bundle_rule_id = R.discount_bundle_rule_id AND D.language_id = '" . intval($LangID) . "') " .
					"	WHERE	RO.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql .
					"	ORDER BY	OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$RuleList = array();
		while ($myResult = $result->fetch_assoc()) {
			if ($UserID == -1) {
				array_push($RuleList, $myResult);
				continue;
			}
			else {
				$ValidRule = true;
				if ($myResult['discount_bundle_rule_quota_user'] > 0 && $UserID != 0) {
					if (discount::GetBundleRuleQtyUsageForUser($myResult['discount_bundle_rule_id'], $UserID) >= $myResult['discount_bundle_rule_quota_user'])
						$ValidRule = false;
				}
				if ($myResult['discount_bundle_rule_quota_discount_code'] > 0) {
					if (discount::GetBundleRuleUsageForDiscountCode($myResult['discount_bundle_rule_id'], $DiscountCode) >= $myResult['discount_bundle_rule_quota_discount_code'])
						$ValidRule = false;
				}
				if ($myResult['discount_bundle_rule_quota_all'] > 0 && $ValidRule) {
					if (discount::GetBundleRuleQtyUsageForGlobal($myResult['discount_bundle_rule_id']) >= $myResult['discount_bundle_rule_quota_all'])
						$ValidRule = false;
				}

				if ($ValidRule)
					array_push($RuleList, $myResult);
			}

		}
		return $RuleList;
	}

	public static function GetBundleRuleQtyUsageForUser($RuleID, $UserID) {
		$query =	"	SELECT	SUM(P.quantity) AS TotalQty " .
					"	FROM	myorder_product P JOIN myorder O ON (O.myorder_id = P.myorder_id) " .
					"	WHERE	P.effective_discount_bundle_rule_id = '" . intval($RuleID) . "'" . 
					"		AND	O.order_status != 'order_cancelled' " .
					"		AND O.order_status != 'void' " .
					"		AND	O.user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			return $myResult['TotalQty'];
		}
		else {
			return 0;
		}
	}

	public static function GetBundleRuleQtyUsageForGlobal($RuleID) {
		$query =	"	SELECT	SUM(P.quantity) AS TotalQty " .
					"	FROM	myorder_product P JOIN myorder O ON (O.myorder_id = P.myorder_id) " .
					"	WHERE	P.effective_discount_bundle_rule_id = '" . intval($RuleID) . "'" .
					"		AND	O.order_status != 'order_cancelled' " .
					"		AND O.order_status != 'void' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			return $myResult['TotalQty'];
		}
		else {
			return 0;
		}			
	}

	public static function GetBundleRuleUsageForDiscountCode($RuleID, $DiscountCode) {
		$query =	"	SELECT	* " .
					"	FROM	myorder_product P JOIN myorder O ON (O.myorder_id = P.myorder_id) " .
					"	WHERE	P.effective_discount_bundle_rule_id = '" . intval($RuleID) . "'" . 
					"		AND	P.effective_discount_bundle_code = '" . aveEscT($DiscountCode) . "'" .
					"		AND	O.order_status != 'order_cancelled' " .
					"		AND O.order_status != 'void' " .
					"	GROUP BY P.myorder_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		return $result->num_rows;
	}

	public static function NewBundleRule($RuleID, $DiscountCode) {
		$query =	"	INSERT INTO discount_bundle_rule " .
					"	SET			discount_bundle_rule_id = '" . intval($RuleID) . "', " .
					"				discount_bundle_rule_discount_code = '" . aveEscT($DiscountCode) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetBundleRuleInfo($RuleID, $LanguageID) {
		$query =	"	SELECT	*, RO.*, OL.*, R.* " .
					"	FROM	object_link OL	JOIN		object RO						ON (OL.object_id = RO.object_id) " .
					"							JOIN		discount_bundle_rule R			ON (R.discount_bundle_rule_id = RO.object_id) " .
					"							LEFT JOIN	discount_bundle_rule_data RD	ON (R.discount_bundle_rule_id = RD.discount_bundle_rule_id AND RD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	RO.object_id	= '" . $RuleID . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function CleanUpBundleRulePriceList($RuleID) {
		$query =	"	DELETE FROM	discount_bundle_rule_price " .
					"	WHERE	discount_bundle_rule_id	= '" . intval($RuleID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetBundleRulePriceList($RuleID, $Site) {
		$RulePriceList = array();

		if ($Site['site_product_price_indepedent_currency'] == 'Y') {

			$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);

			foreach ($CurrencyList as $C) {
				$RulePriceList[intval($C['currency_id'])] = array();
				$RulePrice = discount::GetBundleRulePriceInfo($RuleID, $C['currency_id']);

				$RulePriceList[intval($C['currency_id'])]['price'] = $RulePrice;

				$RulePriceList[intval($C['currency_id'])]['currency_name'] = $C['currency_shortname'];
			}
		}
		else {
			$RulePriceList[0]['price'] = discount::GetBundleRulePriceInfo($RuleID, 0);
		}

		return $RulePriceList;
	}

	public static function GetBundleRulePriceInfo($RuleID, $CurrencyID) {
		$query =	"	SELECT	* " .
					"	FROM	discount_bundle_rule_price " .
					"	WHERE	discount_bundle_rule_id	= '" . intval($RuleID) . "' " .
					"		AND	currency_id = '" . intval($CurrencyID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetBundleItemCostAwareCondition($RuleID) {
		$query =	"	SELECT		* " .
					"	FROM		discount_bundle_item_cost_aware_condition " .
					"	WHERE		discount_bundle_rule_id	= '" . intval($RuleID) . "'" .
					"	ORDER BY	discount_bundle_item_cost_aware_condition_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ItemConditionList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ItemConditionList, $myResult);
		}
		return $ItemConditionList;
	}

	public static function GetBundleItemFreeCondition($RuleID) {
		$query =	"	SELECT		* " .
					"	FROM		discount_bundle_item_free_condition " .
					"	WHERE		discount_bundle_rule_id	= '" . intval($RuleID) . "'" .
					"	ORDER BY	discount_bundle_item_free_condition_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ItemConditionList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ItemConditionList, $myResult);
		}
		return $ItemConditionList;
	}

	public static function NewBundleRuleData($RuleID, $LanguageID, $RuleName = '') {
		$query =	"	INSERT INTO discount_bundle_rule_data " .
					"	SET		discount_bundle_rule_id	= '" . intval($RuleID) . "', " .
					"			language_id = '" . intval($LanguageID) . "', " .
					"			discount_bundle_rule_name	= '" . aveEscT($RuleName) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function TouchBundleRuleData($RuleID, $LanguageID) {
		$query =	"	INSERT INTO discount_bundle_rule_data " .
					"	SET		discount_bundle_rule_id	= '" . intval($RuleID) . "', " .
					"			language_id = '" . intval($LanguageID) . "'" .
					"	ON DUPLICATE KEY UPDATE discount_bundle_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function IsBundleRuleRemovable($RuleID) {
		$query =	"	SELECT	* " .
					"	FROM	myorder_product " .
					"	WHERE	effective_discount_bundle_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return false;
		else
			return true;
	}		

	public static function DeleteBundleRule($RuleID) {
		if (!discount::IsBundleRuleRemovable($RuleID))
			return false;

		$BundleDiscountRule = discount::GetBundleRuleInfo($RuleID, 0);

		$query =	"	DELETE FROM	discount_bundle_rule " .
					"	WHERE		discount_bundle_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	discount_bundle_rule_price " .
					"	WHERE		discount_bundle_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	discount_bundle_rule_data " .
					"	WHERE		discount_bundle_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	discount_bundle_item_cost_aware_condition " .
					"	WHERE		discount_bundle_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	discount_bundle_item_free_condition " .
					"	WHERE		discount_bundle_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	discount_bundle_rule_product_link " .
					"	WHERE		discount_bundle_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($RuleID);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE		object_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::TidyUpObjectOrder($BundleDiscountRule['parent_object_id'], 'DISCOUNT_BUNDLE_RULE');

		return true;
	}

	private static function insertDiscountBundleRuleProductLink($ProductID, $CostAwareConditionID, $FreeConditionID, $RuleID, $SiteID) {
		$update_sql =	"	site_id = '" . intval($SiteID) . "'";

		$query  =	" 	INSERT	INTO	discount_bundle_rule_product_link " .
					"	SET	" . 
					"		discount_bundle_item_cost_aware_condition_id = '" . intval($CostAwareConditionID) . "', " .
					"		discount_bundle_item_free_condition_id = '" . intval($FreeConditionID) . "', " .
					"		product_id = '" . intval($ProductID) . "', " .
					"		discount_bundle_rule_id = '" . intval($RuleID) . "', " . $update_sql .
					"	ON DUPLICATE KEY UPDATE " . $update_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	private static function removeDiscountBundleRuleProductLink($ProductID, $CostAwareConditionID, $FreeConditionID, $RuleID) {
		$query  =	" 	DELETE FROM	discount_bundle_rule_product_link " .
					"	WHERE	" .
					"		discount_bundle_item_cost_aware_condition_id = '" . intval($CostAwareConditionID) . "' " .
					"	AND discount_bundle_item_free_condition_id = '" . intval($FreeConditionID) . "'" .
					"	AND	product_id = '" . intval($ProductID) . "'" .
					"	AND discount_bundle_rule_id = '" . intval($RuleID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function updateDiscountBundleRuleProductLink($SiteID, $Product, $BundleRuleList = null) {
		if ($BundleRuleList === null) {
			$BundleRuleList = discount::GetBundleRuleList($Product['site_id'], 'Y', 999999, false, false, null, true);
		}

		foreach ($BundleRuleList as $BundleRule) {
			$BundleCostAwareConditionList = discount::GetBundleItemCostAwareCondition($BundleRule['discount_bundle_rule_id']);
			$BundleFreeConditionList = discount::GetBundleItemFreeCondition($BundleRule['discount_bundle_rule_id']);
			$IsHit = false;

			foreach ($BundleCostAwareConditionList as $C) {
				if (discount::IsProductMeetBundleItemCondition($C, $Product, 999999, false, false)) {
					self::insertDiscountBundleRuleProductLink ($Product['product_id'], $C['discount_bundle_item_cost_aware_condition_id'], 0, $BundleRule['discount_bundle_rule_id'], $SiteID);
				}
				else {
					self::removeDiscountBundleRuleProductLink($Product['product_id'], $C['discount_bundle_item_cost_aware_condition_id'], 0, $BundleRule['discount_bundle_rule_id']);
				}						
			}

			foreach ($BundleFreeConditionList as $C) {
				if (discount::IsProductMeetBundleItemCondition($C, $Product, 999999, false, false)) {
					self::insertDiscountBundleRuleProductLink ($Product['product_id'], 0, $C['discount_bundle_item_free_condition_id'], $BundleRule['discount_bundle_rule_id'], $SiteID);
				}
				else {
					self::removeDiscountBundleRuleProductLink($Product['product_id'], 0, $C['discount_bundle_item_free_condition_id'], $BundleRule['discount_bundle_rule_id']);
				}
			}
		}
	}

	public static function GetBundleDiscountRuleListByProductID($ProductID, $LangID = 0, $SecurityLevel = 0, $HonorArchiveDate = true, $HonorPublishDate = true, $IsEnable = 'Y', $CurrencyObj = null, $Site = null) {
		if ($Site == null) {
			//This is not what I want to maintain but for safety
			$Product = product::GetProductInfo($ProductID, 0);
			$Site = site::GetSiteInfo($Product['site_id']);
		}

		$EffectiveCurrencyID = 0;
		if ($Site['site_product_price_indepedent_currency'] == 'Y')
			$EffectiveCurrencyID = intval($CurrencyObj->currency_id);

		$sql = '';
		if ($HonorArchiveDate)
			$sql = $sql . "	AND	O.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql = $sql . "	AND	O.object_publish_date < NOW() ";			
		if ($IsEnable !== null)
			$sql = $sql . " AND O.object_is_enable = '" . ynval($IsEnable) . "'";

		$query =	"	SELECT		*, R.* " .
					"	FROM		discount_bundle_rule_product_link L " .
					"		JOIN	discount_bundle_rule R ON (L.discount_bundle_rule_id = R.discount_bundle_rule_id AND product_id = '" . intval($ProductID) . "' ) " .
					"		JOIN	object O ON (R.discount_bundle_rule_id = O.object_id AND O.object_security_level <= '" . intval($SecurityLevel) . "' " . $sql . ") " .
					"		JOIN	discount_bundle_rule_price P ON (R.discount_bundle_rule_id = P.discount_bundle_rule_id AND P.currency_id = '" . intval($EffectiveCurrencyID) . "') " .
					"		LEFT JOIN discount_bundle_rule_data D ON (R.discount_bundle_rule_id = D.discount_bundle_rule_id AND D.language_id = '" . intval($LangID) . "') " .
					"	GROUP BY R.discount_bundle_rule_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$RuleList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($RuleList, $myResult);
		}
		return $RuleList;
	}

	public static function GetBundleDiscountRuleListXMLByProductID($ProductID, $LangID = 0, $SecurityLevel = 0, $CurrencyObj = null, $Site = null) {
		$smarty = new mySmarty();
		$RuleList = discount::GetBundleDiscountRuleListByProductID($ProductID, $LangID, $SecurityLevel, true, true, "Y", $CurrencyObj, $Site);
		$xml = '';

		foreach ($RuleList as $R) {
			$smarty->assign('Object', $R);
			$xml .= $smarty->fetch('api/object_info/DISCOUNT_BUNDLE_RULE.tpl');
		}
		return $xml;
	}

	public static function GetProductListByDiscountBundleRuleIDAndConditionID($DiscountRuleID, $CostAwareConditionID, $FreeConditionID, $SecurityLevel = 0, $HonorArchiveDate = true, $HonorPublishDate = true) {

		$sql = '';
		if ($HonorArchiveDate)
			$sql = $sql . "	AND	O.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql = $sql . "	AND	O.object_publish_date < NOW() ";			

		$query =	"	SELECT	* " .
					"	FROM	discount_bundle_rule_product_link PL JOIN object_link OL ON (PL.product_id = OL.object_id) " .
					"		JOIN object O ON (PL.product_id = O.object_id AND O.object_security_level <= '" . intval($SecurityLevel) . "') " .
					"	WHERE	PL.discount_bundle_rule_id = '" . intval($DiscountRuleID) . "' " .
					"		AND	PL.discount_bundle_item_cost_aware_condition_id = '" . intval($CostAwareConditionID) . "'" .
					"		AND	PL.discount_bundle_item_free_condition_id = '" . intval($FreeConditionID) . "'" . $sql .
					"		AND O.object_is_enable = 'Y' " .
					"		AND OL.object_link_is_enable = 'Y' " .
					"	GROUP BY PL.product_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$List = array();
		while ($myResult = $result->fetch_assoc()) {		
			array_push($List, $myResult);
		}
		return $List;
	}

	public static function GetBundleDiscountConditionXML($Condition, $RuleID, $SecurityLevel, $LangID = 0) {
		$smarty = new mySmarty();
		$ProductListXML = '';
		$ProductList = discount::GetProductListByDiscountBundleRuleIDAndConditionID($RuleID, $Condition['discount_bundle_item_cost_aware_condition_id'], $Condition['discount_bundle_item_free_condition_id'], $SecurityLevel, true, true);
		foreach ($ProductList as $P) {
			$Product = product::GetProductInfo($P['product_id'], $LangID);
			$ProductListXML .= product::GetProductXML($Product['object_link_id'], $LangID, false, 1, 1, $SecurityLevel, false, 1, 1, true);
		}

		$smarty->assign('ProductListXML', $ProductListXML);
		$smarty->assign('Object', $Condition);
		return $smarty->fetch('api/object_info/DISCOUNT_BUNDLE_CONDITION.tpl');
	}

	public static function updateSiteDiscountBundleRuleProductLink($SiteID) {
		$query =
			"	DELETE FROM discount_bundle_rule_product_link " .
			"	WHERE		site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$BundleRuleList = discount::GetBundleRuleList($SiteID, 'ALL', 999999, false, false, null, true);
//			$PreprocessRuleList = discount::GetPreprocessRuleList($SiteID, 'ALL', 999999, false, false, null);

		$query = 
			"	SELECT * " .
			"	FROM product P JOIN object O ON (P.product_id = O.object_id) " .
			"	WHERE O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			discount::updateDiscountBundleRuleProductLink($SiteID, $myResult, $BundleRuleList);
		}			
	}

	public static function IsProductMeetBundleItemCondition($BundleItemCondition, $ProductInfo, $SecurityLevel = 0, $HonorArchiveDate = false, $HonorPublishDate = false) {
		if ($BundleItemCondition['discount_bundle_item_condition_type_id'] == 1) {
			if (product::IsProductUnderProductCategory($ProductInfo['product_id'], $BundleItemCondition['discount_bundle_item_condition_product_category_id'], $BundleItemCondition['discount_bundle_item_condition_include_sub_category'], $SecurityLevel, $HonorArchiveDate, $HonorPublishDate))
				return true;
			else
				return false;
		}
		elseif ($BundleItemCondition['discount_bundle_item_condition_type_id'] == 2) {
			$ProductCatSpecial = product::GetProductCatSpecialInfo($BundleItemCondition['discount_bundle_item_condition_product_category_id'], 0);

			if ($ProductInfo['is_special_cat_' . $ProductCatSpecial['product_category_special_no']] == 'Y')
				return true;
			else
				return false;
		}
		elseif ($BundleItemCondition['discount_bundle_item_condition_type_id'] == 3) {
			if ($ProductInfo['product_id'] == $BundleItemCondition['discount_bundle_item_condition_product_id'])
				return true;
			else
				return false;
		}
		else
			return false;		
	}

}