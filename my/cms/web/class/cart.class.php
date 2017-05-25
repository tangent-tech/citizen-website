<?php
/*
Please do NOT think this as an OOP object, I just use the class to group the related functions...
*/

if (!defined('IN_CMS'))
	die("huh?");

class cart {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function EmptyBonusPointItemCart($UserID, $CartType = 'normal', $SiteID = 0, $SystemAdminID = 0, $ContentAdminID = 0) {
		cart::FixCartTypeParameter($CartType);

		$query =	"	DELETE FROM cart_bonus_point_item " .
					"	WHERE	user_id					= '" . intval($UserID) . "' " .
					"		AND	system_admin_id			= '" . intval($SystemAdminID) . "' " .
					"		AND	content_admin_id		= '" . intval($ContentAdminID) . "' " .
					"		AND	site_id					= '" . intval($SiteID) . "' " .
					"		AND	cart_content_type		= '" . aveEscT($CartType) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function AddBonusPointItemToCart($BonusPointItemID, $Qty, $UserID, $CartType = 'normal', $SiteID = 0, $SystemAdminID = 0, $ContentAdminID = 0) {
		cart::FixCartTypeParameter($CartType);

		$query =	"	INSERT INTO cart_bonus_point_item " .
					"	SET		bonus_point_item_id		= '" . intval($BonusPointItemID) . "', " .
					"			quantity				= '" . intval($Qty) . "', " .
					"			user_id					= '" . intval($UserID) . "', " .
					"			system_admin_id			= '" . intval($SystemAdminID) . "', " .
					"			content_admin_id		= '" . intval($ContentAdminID) . "', " .
					"			site_id					= '" . intval($SiteID) . "', " .
					"			cart_content_type		= '" . aveEscT($CartType) . "'" .
					"	ON DUPLICATE KEY UPDATE	quantity = quantity + '" . intval($Qty) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function RemoveBonusPointItemFromCart($BonusPointItemID, $Qty, $UserID, $CartType = 'normal', $SiteID = 0, $SystemAdminID = 0, $ContentAdminID = 0) {
		cart::FixCartTypeParameter($CartType);

		$query =	"	UPDATE	cart_bonus_point_item " .
					"	SET		quantity				= quantity - '" . intval($Qty) . "' " .
					"	WHERE	bonus_point_item_id		= '" . intval($BonusPointItemID) . "' " .
					"		AND	user_id					= '" . intval($UserID) . "' " .
					"		AND	system_admin_id			= '" . intval($SystemAdminID) . "' " .
					"		AND	content_admin_id		= '" . intval($ContentAdminID) . "' " .
					"		AND	site_id					= '" . intval($SiteID) . "' " .
					"		AND	cart_content_type		= '" . aveEscT($CartType) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM cart_bonus_point_item " .
					"	WHERE	quantity <= 0 " .
					"		AND	bonus_point_item_id		= '" . intval($BonusPointItemID) . "' " .
					"		AND	user_id					= '" . intval($UserID) . "' " .
					"		AND	system_admin_id			= '" . intval($SystemAdminID) . "' " .
					"		AND	content_admin_id		= '" . intval($ContentAdminID) . "' " .
					"		AND	site_id					= '" . intval($SiteID) . "' " .
					"		AND	cart_content_type		= '" . aveEscT($CartType) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function UpdateBonusPointCart($BonusPointItemID, $Qty, $UserID, $CartType = 'normal', $SiteID = 0, $SystemAdminID = 0, $ContentAdminID = 0) {
		cart::FixCartTypeParameter($CartType);

		if ($Qty <= 0) {
			$query =	"	DELETE FROM cart_bonus_point_item " .
						"	WHERE	bonus_point_item_id	= '" . intval($BonusPointItemID) . "' " .
						"		AND	user_id				= '" . intval($UserID) . "' " .
						"		AND	system_admin_id		= '" . intval($SystemAdminID) . "' " .
						"		AND	content_admin_id	= '" . intval($ContentAdminID) . "' " .
						"		AND	site_id				= '" . intval($SiteID) . "' " .
						"		AND	cart_content_type	= '" . aveEscT($CartType) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else {
			$query =	"	INSERT INTO cart_bonus_point_item " .
						"	SET		bonus_point_item_id		= '" . intval($BonusPointItemID) . "', " .
						"			quantity				= '" . intval($Qty) . "', " .
						"			user_id					= '" . intval($UserID) . "', " .
						"			system_admin_id			= '" . intval($SystemAdminID) . "', " .
						"			content_admin_id		= '" . intval($ContentAdminID) . "', " .
						"			site_id					= '" . intval($SiteID) . "', " .
						"			cart_content_type		= '" . aveEscT($CartType) . "'" .
						"	ON DUPLICATE KEY UPDATE	quantity = '" . $Qty . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function GetCartBonusPointItemList($UserID, $LanguageID, $Currency, &$TotalCashValue, &$TotalCashValueCA, &$TotalBonusPointRequired, $CartType = 'normal', $HonorArchiveDate = false, $HonorPublishDate = false, $SiteID = 0, $SystemAdminID = 0, $ContentAdminID = 0, $SecurityLevel = 0) {
		cart::FixCartTypeParameter($CartType);

		$sql = '';

		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	O.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	O.object_publish_date < NOW() ";

		$query =	"	SELECT		*, W.*, B.*, O.*, L.* " .
					"	FROM		language L	JOIN cart_bonus_point_item W			ON	(L.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN bonus_point_item B					ON	(B.bonus_point_item_id = W.bonus_point_item_id) " .
					"							JOIN object O							ON	(O.object_id = B.bonus_point_item_id) " .
					"							LEFT JOIN bonus_point_item_data BD		ON	(BD.language_id = L.language_id AND BD.bonus_point_item_id = B.bonus_point_item_id) " .
					"	WHERE		O.object_is_enable = 'Y' " .
					"			AND	O.object_security_level <= '" . intval($SecurityLevel) . "'" .
					"			AND	W.user_id				= '" . intval($UserID) . "' " .
					"			AND	W.system_admin_id		= '" . intval($SystemAdminID) . "' " .
					"			AND	W.content_admin_id		= '" . intval($ContentAdminID) . "' " .
					"			AND	W.site_id				= '" . intval($SiteID) . "' " .
					"			AND	W.cart_content_type		= '" . aveEscT($CartType) . "'" .
					"			AND	W.quantity > 0 " . $sql .
					"	ORDER BY	O.object_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$TotalCashValue = 0;
		$TotalCashValueCA = 0;
		$TotalBonusPointRequired = 0;

		$CartBonusPointItemList = array();
		while ($myResult = $result->fetch_assoc()) {
			$myResult['currency_id'] = $Currency['currency_id'];
			$myResult['cash_ca'] = round($myResult['cash'] * $Currency['currency_site_rate'], $Currency['currency_precision']);
			$myResult['subtotal_cash'] = $myResult['cash'] * $myResult['quantity'];
			$myResult['subtotal_cash_ca'] = $myResult['cash_ca'] * $myResult['quantity'];
			$myResult['subtotal_bonus_point_required'] = $myResult['bonus_point_required'] * $myResult['quantity'];

			$TotalCashValue += $myResult['subtotal_cash'];
			$TotalCashValueCA += $myResult['subtotal_cash_ca'];
			$TotalBonusPointRequired += $myResult['subtotal_bonus_point_required'];

			array_push($CartBonusPointItemList, $myResult);
		}

		return $CartBonusPointItemList;
	}

	public static function GetBonusPointItemListWithOrderQuantity($SiteID, $MyOrderID, $LanguageID, $SecurityLevel, $IsEnable = 'ALL') {
		$sql = '';
		if ($IsEnable == 'Y')
			$sql =	"	AND	O.object_is_enable = 'Y' ";
		elseif ($IsEnable == 'N')
			$sql =	"	AND	O.object_is_enable = 'N' ";

		$query =	"	SELECT		*, W.*, B.*, O.*, C.*, L.* " .
					"	FROM		language L	JOIN bonus_point_item B					ON	(L.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN object O							ON	(O.object_id = B.bonus_point_item_id) " .
					"							LEFT JOIN myorder_bonus_point_item W	ON	(B.bonus_point_item_id = W.bonus_point_item_id AND W.myorder_id = '" . $MyOrderID . "')" .
					"							LEFT JOIN bonus_point_item_data BD		ON	(BD.language_id = L.language_id AND BD.bonus_point_item_id = B.bonus_point_item_id) " .
					"							LEFT JOIN currency C 					ON	(C.currency_id = W.currency_id) " .
					"	WHERE		O.site_id = '" . $SiteID . "'" .
					"		AND		O.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql;
					"	ORDER BY	O.object_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$BonusPointItemList = array();
		while ($myResult = $result->fetch_assoc()) {
			$myResult['cash_ca'] = round($myResult['cash'] * $myResult['currency_site_rate'], $myResult['currency_precision']);
			$myResult['subtotal_cash'] = $myResult['cash'] * $myResult['quantity'];
			$myResult['subtotal_cash_ca'] = $myResult['cash_ca'] * $myResult['quantity'];
			$myResult['subtotal_bonus_point_required'] = $myResult['bonus_point_required'] * $myResult['quantity'];
			array_push($BonusPointItemList, $myResult);
		}
		return $BonusPointItemList;
	}

	public static function GetBonusPointItemListWithCartQuantity($SiteID, $UserID, $Currency, $LanguageID, $SecurityLevel, $IsEnable = 'ALL', $BonusPointRequired = 999999, $OrderBy = 'ASC', $HonorArchiveDate = false, $HonorPublishDate = false) {
		if (strtoupper($OrderBy) != 'ASC' && strtoupper($OrderBy) != 'DESC' )
			$OrderBy = 'ASC';

		$sql = '';
		if ($IsEnable == 'Y')
			$sql =	$sql . "	AND	O.object_is_enable = 'Y' ";
		elseif ($IsEnable == 'N')
			$sql =	$sql . "	AND	O.object_is_enable = 'N' ";

		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	O.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	O.object_publish_date < NOW() ";

		$query =	"	SELECT		*, W.*, B.*, O.*, L.* " .
					"	FROM		language L	JOIN bonus_point_item B					ON	(L.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN object O							ON	(O.object_id = B.bonus_point_item_id) " .
					"							LEFT JOIN cart_bonus_point_item W		ON	(B.bonus_point_item_id = W.bonus_point_item_id AND W.user_id = '" . $UserID . "' AND W.cart_content_type = 'normal')" .
					"							LEFT JOIN bonus_point_item_data BD		ON	(BD.language_id = L.language_id AND BD.bonus_point_item_id = B.bonus_point_item_id) " .
					"	WHERE		O.site_id = '" . intval($SiteID) . "'" .
					"		AND		B.bonus_point_required <= '" . intval($BonusPointRequired) . "'" .
					"		AND		O.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql .
					"	ORDER BY	B.bonus_point_required " . $OrderBy;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$BonusPointItemList = array();
		while ($myResult = $result->fetch_assoc()) {
			$myResult['currency_id'] = $Currency['currency_id'];
			$myResult['cash_ca'] = round($myResult['cash'] * $Currency['currency_site_rate'], $Currency['currency_precision']);
			$myResult['subtotal_cash'] = $myResult['cash'] * $myResult['quantity'];
			$myResult['subtotal_cash_ca'] = $myResult['cash_ca'] * $myResult['quantity'];
			$myResult['subtotal_bonus_point_required'] = $myResult['bonus_point_required'] * $myResult['quantity'];
			array_push($BonusPointItemList, $myResult);
		}
		return $BonusPointItemList;
	}

	public static function GetBonusPointItemListWithCartQuantityXML($SiteID, $UserID, $CurrencyID, $LanguageID, $SecurityLevel, $IsEnable = 'ALL', $BonusPointRequired = 999999, $OrderBy = 'ASC') {
		$smarty = new mySmarty();
		$Currency = currency::GetCurrencyInfo($CurrencyID, $SiteID);

		$BonusPointItemList = cart::GetBonusPointItemListWithCartQuantity($SiteID, $UserID, $Currency, $LanguageID, $SecurityLevel, $IsEnable, $BonusPointRequired, $OrderBy, true, true);

		$Site = site::GetSiteInfo($SiteID);

		$BonusPointItemListXML = '';
		foreach ($BonusPointItemList as $B) {
			$B['object_seo_url'] = object::GetSeoURL($B, '', $LanguageID, $Site);
			$smarty->assign('Object', $B);
			$BonusPointItemListXML = $BonusPointItemListXML . $smarty->fetch('api/object_info/CART_BONUS_POINT_ITEM.tpl');
		}
		return "<bonus_point_item_list>" . $BonusPointItemListXML . "</bonus_point_item_list>";
	}

	private static function FixCartTypeParameter(&$CartType) {
		$CartType = strtolower($CartType);
		if ($CartType == 'n' || $CartType == 'normal') {
			// For historical purpose, SiteID is 0 for normal type, UserID should be enough - @2012/04/10
			$CartType = 'normal';
		}
		elseif ($CartType == 'y' || $CartType == 'temp')
			$CartType = 'temp';
		elseif ($CartType == 'test')
			$CartType = 'test';
		elseif ($CartType == 'bonus_point')
			$CartType = 'bonus_point';
		else
			$CartType = 'normal';
	}

	public static function EmptyProductCart($UserID, $CartType = 'normal', $SiteID = 0, $SystemAdminID = 0, $ContentAdminID = 0) {
		cart::FixCartTypeParameter($CartType);

		$query =	"	DELETE FROM cart_content " .
					"	WHERE	user_id					= '" . intval($UserID) . "' " .
					"		AND	system_admin_id			= '" . intval($SystemAdminID) . "' " .
					"		AND	content_admin_id		= '" . intval($ContentAdminID) . "' " .
					"		AND	site_id					= '" . intval($SiteID) . "' " .
					"		AND	cart_content_type		= '" . aveEscT($CartType) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function AddProductToCart($ProductID, $Qty, $UserID, $ProductOptionID = 0, $CartType = 'normal', $SiteID = 0, $SystemAdminID = 0, $ContentAdminID = 0) {
		cart::FixCartTypeParameter($CartType);

		$query =	"	INSERT INTO cart_content " .
					"	SET		product_id				= '" . intval($ProductID) . "', " .
					"			quantity				= '" . intval($Qty) . "', " .
					"			user_id					= '" . intval($UserID) . "', " .
					"			product_option_id		= '" . intval($ProductOptionID) . "', " .
					"			system_admin_id			= '" . intval($SystemAdminID) . "', " .
					"			content_admin_id		= '" . intval($ContentAdminID) . "', " .
					"			site_id					= '" . intval($SiteID) . "', " .
					"			cart_content_type		= '" . aveEscT($CartType) . "'" .
					"	ON DUPLICATE KEY UPDATE	quantity = quantity + '" . intval($Qty) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function RemoveProductFromCart($ProductID, $Qty, $UserID, $ProductOptionID = 0, $CartType = 'normal', $SiteID = 0, $SystemAdminID = 0, $ContentAdminID = 0) {
		cart::FixCartTypeParameter($CartType);

		$query =	"	UPDATE	cart_content " .
					"	SET		quantity	= quantity - '" . intval($Qty) . "' " .
					"	WHERE	product_id			= '" . intval($ProductID) . "' " .
					"		AND	user_id				= '" . intval($UserID) . "' " .
					"		AND	product_option_id	= '" . intval($ProductOptionID) . "' " .
					"		AND	system_admin_id		= '" . intval($SystemAdminID) . "' " .
					"		AND	content_admin_id	= '" . intval($ContentAdminID) . "' " .
					"		AND	site_id				= '" . intval($SiteID) . "' " .
					"		AND	cart_content_type	= '" . aveEscT($CartType) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM cart_content " .
					"	WHERE	user_id					= '" . intval($UserID) . "' " .
					"		AND	system_admin_id			= '" . intval($SystemAdminID) . "' " .
					"		AND	content_admin_id		= '" . intval($ContentAdminID) . "' " .
					"		AND	site_id					= '" . intval($SiteID) . "' " .
					"		AND	cart_content_type		= '" . aveEscT($CartType) . "'" .
					"		AND product_id				= '" . intval($ProductID) . "' " .
					"		AND	product_option_id		= '" . intval($ProductOptionID) . "'" .
					"		AND	quantity <= 0 ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function UpdateProductCart($ProductID, $Qty, $UserID, $ProductOptionID = 0, $CartType = 'normal', $SiteID = 0, $SystemAdminID = 0, $ContentAdminID = 0) {
		cart::FixCartTypeParameter($CartType);

		if ($Qty <= 0) {
			$query =	"	DELETE FROM	cart_content " .
						"	WHERE	product_id			= '" . intval($ProductID) . "'" .
						"		AND product_option_id	= '" . intval($ProductOptionID) . "'" .
						"		AND	user_id				= '" . intval($UserID) . "' " .
						"		AND	system_admin_id		= '" . intval($SystemAdminID) . "' " .
						"		AND	content_admin_id	= '" . intval($ContentAdminID) . "' " .
						"		AND	site_id				= '" . intval($SiteID) . "' " .
						"		AND	cart_content_type	= '" . aveEscT($CartType) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else {
			$query =	"	INSERT INTO cart_content " .
						"	SET		product_id			= '" . intval($ProductID) . "', " .
						"			product_option_id	= '" . intval($ProductOptionID) . "', " .
						"			quantity			= '" . intval($Qty) . "', " .
						"			user_id				= '" . intval($UserID) . "', " .
						"			system_admin_id		= '" . intval($SystemAdminID) . "', " .
						"			content_admin_id	= '" . intval($ContentAdminID) . "', " .
						"			site_id				= '" . intval($SiteID) . "', " .
						"			cart_content_type	= '" . aveEscT($CartType) . "'" .
						"	ON DUPLICATE KEY UPDATE	quantity = '" . intval($Qty) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function GetCartDetailsInfo($UserID, $CartType = 'normal', $SiteID = 0, $SystemAdminID = 0, $ContentAdminID = 0) {
		cart::FixCartTypeParameter($CartType);

		$query =	"	DELETE FROM cart_content WHERE quantity <= 0 ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT		* " .
					"	FROM		cart_details " .
					"	WHERE		user_id				= '" . intval($UserID) . "' " .
					"			AND	system_admin_id		= '" . intval($SystemAdminID) . "' " .
					"			AND	content_admin_id	= '" . intval($ContentAdminID) . "' " .
					"			AND	site_id				= '" . intval($SiteID) . "' " .
					"			AND	cart_content_type	= '" . aveEscT($CartType) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetCartXML($UserID, $LanguageID, $CurrencyID, $SiteID, $CartContentType = 'normal') {
		$smarty = new mySmarty();

		$Site = site::GetSiteInfo($SiteID);

		$Currency = currency::GetCurrencyInfo($CurrencyID, $SiteID);
		if ($Currency == null || $Currency['currency_site_enable_id'] == null) {
			$Site = site::GetSiteInfo($SiteID);
			$Currency = currency::GetCurrencyInfo($Site['site_default_currency_id'], $SiteID);
		}

		$CartItemListXML = '';
		$CartBonusPointItemListXML = '';
		$TotalPrice = 0;
		$TotalPriceCA = 0;
		$TotalListedPrice = 0;
		$TotalListedPriceCA = 0;
		$TotalCashValue = 0;
		$TotalCashValueCA = 0;
		$TotalBonusPoint = 0;
		$TotalBonusPointRequired = 0;
		$TotalCartQuantity = 0;
		$ContinueProcessPostRule = true;

		$User = user::GetUserInfo($UserID);

		$CartDetails = cart::GetCartDetailsInfo($UserID, $CartContentType, $SiteID, 0, 0);			

		$PossibleRuleNo = 0;
		$AppliedRuleNo = 0;
		$PreprocessRuleList = discount::GetPreprocessRuleList($SiteID, 'Y', $User['user_security_level'], true, true, $CartDetails['discount_code']);
		$PreprocessRuleIDList = array();
		foreach($PreprocessRuleList as $R)
			array_push($PreprocessRuleIDList, $R['discount_preprocess_rule_id']);
		$PossibleRuleNo += count($PreprocessRuleIDList);

		$CartItemList = cart::GetCartItemList($UserID, $LanguageID, $Currency, $TotalListedPrice, $TotalListedPriceCA, $TotalPrice, $TotalPriceCA, $TotalBonusPoint, $ContinueProcessPostRule, $CartContentType, true, true, $SiteID, 0, 0, $User['user_security_level']);
		foreach ($CartItemList as $C) {
			$C['object_seo_url'] = object::GetSeoURL($C, '', $LanguageID, $Site);
			$smarty->assign('Object', $C);
			$smarty->assign('Currency', $Currency);
			$CartItemListXML .= $smarty->fetch('api/object_info/CART.tpl');
			$TotalCartQuantity += $C['quantity'];

			if (in_array($C['effective_discount_preprocess_rule_id'], $PreprocessRuleIDList))
				$AppliedRuleNo++;
		}
		$smarty->assign('CartItemListXML', $CartItemListXML);

		$CartBonusPointItemList = cart::GetCartBonusPointItemList($UserID, $LanguageID, $Currency, $TotalCashValue, $TotalCashValueCA, $TotalBonusPointRequired, $CartContentType, true, true, $SiteID, 0, 0, $User['user_security_level']);
		foreach ($CartBonusPointItemList as $C) {
			$C['object_seo_url'] = object::GetSeoURL($C, '', $LanguageID, $Site);
			$smarty->assign('Object', $C);
			$smarty->assign('Currency', $Currency);
			$CartBonusPointItemListXML .= $smarty->fetch('api/object_info/CART_BONUS_POINT_ITEM.tpl');
		}
		$smarty->assign('CartBonusPointItemListXML', $CartBonusPointItemListXML);

		$PostprocessDiscount = 0;
		$PostprocessDiscountCA = 0;
		$PostprocessDiscountRuleID = 0;
		if ($CartContentType != 'bonus_point' && $ContinueProcessPostRule == true)
			cart::ApplyPostProcessRule($UserID, 0, $Currency, $TotalPrice, intval($User['user_security_level']), $PostprocessDiscount, $PostprocessDiscountCA, $PostprocessDiscountRuleID, $CartContentType, true, true, $SiteID, 0, 0, 'N');
		$smarty->assign('PostprocessDiscount', $PostprocessDiscount);
		$smarty->assign('PostprocessDiscountCA', $PostprocessDiscountCA);
		$smarty->assign('PostprocessDiscountRuleID', $PostprocessDiscountRuleID);

		$PostprocessDiscountRule = discount::GetPostprocessRuleInfo($PostprocessDiscountRuleID, 0);
//			if ($PostprocessDiscountRule != null)
//				$smarty->assign('EffectivePostprocessDiscountCode', $PostprocessDiscountRule['discount_postprocess_rule_discount_code']);

		$PostprocessRuleList = discount::GetPostprocessRuleList($SiteID, 'Y', $User['user_security_level'], true, true, $CartDetails['discount_code'], $UserID);
		$PostprocessRuleIDList = array();
		foreach($PostprocessRuleList as $R)
			array_push($PostprocessRuleIDList, $R['discount_postprocess_rule_id']);
		$PossibleRuleNo += count($PostprocessRuleIDList);

		if (in_array($PostprocessDiscountRuleID, $PostprocessRuleIDList)) {
			$AppliedRuleNo++;
			$smarty->assign('EffectivePostprocessDiscountCode', $CartDetails['discount_code']);
		}

		$smarty->assign('PossibleRuleNo', $PossibleRuleNo);
		$smarty->assign('AppliedRuleNo', $AppliedRuleNo);

		$Site = site::GetSiteInfo($SiteID);			
		$CalculatedFreightCostCA = 0;
		if ($CartContentType != 'bonus_point')
			cart::CartAdjustFreight($CartDetails, $Site, $Currency, $CalculatedFreightCostCA, $TotalListedPrice, $TotalListedPriceCA, $TotalPrice, $TotalPriceCA, $TotalCashValue, $TotalCashValueCA, $PostprocessDiscount, $PostprocessDiscountCA);		

		$PayAmountCA = $TotalPriceCA + $CalculatedFreightCostCA - doubleval($TotalCashValueCA) - doubleval($CartDetails['discount_amount_ca']) - $PostprocessDiscountCA;
		$PayAmountCA = $PayAmountCA - $CartDetails['user_balance_use'] * $Currency['currency_site_rate'];
		if ($PayAmountCA < 0)
			$PayAmountCA = 0;



		$smarty->assign('Object', $CartDetails);
		$smarty->assign('PayAmountCA', $PayAmountCA);
		$smarty->assign('TotalPrice', $TotalPrice);
		$smarty->assign('TotalPriceCA', $TotalPriceCA);
		$smarty->assign('TotalBonusPoint', $TotalBonusPoint);
		$smarty->assign('TotalCashValue', $TotalCashValue);
		$smarty->assign('TotalCashValueCA', $TotalCashValueCA);
		$smarty->assign('TotalBonusPointRequired', $TotalBonusPointRequired);
		$smarty->assign('TotalCartQuantity', $TotalCartQuantity);
		$smarty->assign('FreightCostCA', $CalculatedFreightCostCA);

		$CartXML = $smarty->fetch('api/object_info/CART_DETAILS.tpl');

		return $CartXML;
	}

	public static function CartAdjustFreight(&$CartDetails, $Site, $Currency, &$CalculatedFreightCostCA, $TotalListedPrice, $TotalListedPriceCA, $TotalPrice, $TotalPriceCA, $TotalCashValue, $TotalCashValueCA, $PostprocessDiscount, $PostprocessDiscountCA ) {
		if ($Site['site_freight_cost_calculation_id'] == 1) {
			$FreightPriceAmountToCalFor = 0;
			if ($Site['site_freight_1_free_min_total_price_def'] == 0)
				$FreightPriceAmountToCalFor = $TotalPrice - (doubleval($CartDetails['discount_amount_ca']) / $Currency['currency_site_rate']) - $PostprocessDiscount;
			elseif ($Site['site_freight_1_free_min_total_price_def'] == 1)
				$FreightPriceAmountToCalFor = $TotalPrice - $TotalCashValue - (doubleval($CartDetails['discount_amount_ca']) / $Currency['currency_site_rate']) - $PostprocessDiscount;
			elseif ($Site['site_freight_1_free_min_total_price_def'] == 2)
				$FreightPriceAmountToCalFor = $TotalListedPrice;

			$CalculatedFreightCostCA = 0;
			if ($FreightPriceAmountToCalFor < $Site['site_freight_1_free_min_total_price'])
				$CalculatedFreightCostCA = $Site['site_freight_1_cost'] * $Currency['currency_site_rate'];

			if ($CartDetails['self_take'] == 'Y')
				$CalculatedFreightCostCA = 0;

			if ($TotalListedPrice == 0) // No Product!
				$CalculatedFreightCostCA = 0;

			$query =	"	UPDATE	cart_details " .
						"	SET		freight_cost_ca	= '" . $CalculatedFreightCostCA . "' " .
						"	WHERE	cart_details_id		= '" . $CartDetails['cart_details_id'] . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else if ($Site['site_freight_cost_calculation_id'] == 2) {
			$MinTotalPrice = 0;
			if ($Site['site_freight_2_free_min_total_price_def'] == 0)
				$MinTotalPrice = $TotalPrice - (doubleval($CartDetails['discount_amount_ca']) / $Currency['currency_site_rate']) - $PostprocessDiscount;
			elseif ($Site['site_freight_2_free_min_total_price_def'] == 1)
				$MinTotalPrice = $TotalPrice - $TotalCashValue - (doubleval($CartDetails['discount_amount_ca']) / $Currency['currency_site_rate']) - $PostprocessDiscount;
			elseif ($Site['site_freight_2_free_min_total_price_def'] == 2)
				$MinTotalPrice = $TotalListedPrice;

			$TotalBasePrice = 0;
			if ($Site['site_freight_2_total_base_price_def'] == 0)
				$TotalBasePrice = $TotalPrice - (doubleval($CartDetails['discount_amount_ca']) / $Currency['currency_site_rate']) - $PostprocessDiscount;
			elseif ($Site['site_freight_2_total_base_price_def'] == 1)
				$TotalBasePrice = $TotalPrice - $TotalCashValue - (doubleval($CartDetails['discount_amount_ca']) / $Currency['currency_site_rate']) - $PostprocessDiscount;
			elseif ($Site['site_freight_2_total_base_price_def'] == 2)
				$TotalBasePrice = $TotalListedPrice;
			$CalculatedFreightCostCA = 0;

			if (doubleval($Site['site_freight_2_free_min_total_price']) < 0 || $MinTotalPrice < $Site['site_freight_2_free_min_total_price'])
				$CalculatedFreightCostCA = $TotalBasePrice * $Site['site_freight_2_cost_percent'] / 100;

			if ($CartDetails['self_take'] == 'Y')
				$CalculatedFreightCostCA = 0;

			if ($TotalListedPrice == 0) // No Product!
				$CalculatedFreightCostCA = 0;				

			$query =	"	UPDATE	cart_details " .
						"	SET		freight_cost_ca	= '" . doubleval($CalculatedFreightCostCA) . "' " .
						"	WHERE	cart_details_id		= '" . intval($CartDetails['cart_details_id']) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else {
			$CalculatedFreightCostCA = doubleval($CartDetails['freight_cost_ca']);
		}
	}

	public static function GetCartItemListWithoutCalculation($SiteID, $UserID, $SystemAdminID, $ContentAdminID, $CartType = 'normal', $HonorArchiveDate = false, $HonorPublishDate = false) {
		$sql = '';

		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	O.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	O.object_publish_date < NOW() ";

		$query =	"	SELECT		* " .
					"	FROM		cart_content W		JOIN object O		ON	(O.object_id = W.product_id) " .
					"									JOIN object_link OL	ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"	WHERE		O.object_is_enable = 'Y' " .
					"			AND	W.cart_content_type = '" . aveEscT($CartType) . "'" .
					"			AND	W.user_id = '" . intval($UserID) . "'" .
					"			AND	W.site_id = '" . intval($SiteID) . "'" .
					"			AND	W.system_admin_id = '" . intval($SystemAdminID) . "'" .
					"			AND	W.content_admin_id = '" . intval($ContentAdminID) . "'" . $sql .
					"	GROUP BY	W.product_id, W.product_option_id " .
					"	ORDER BY	W.product_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$CartItemList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($CartItemList, $myResult);
		}
		return $CartItemList;
	}

	private static function ProcessDiscountPreprocessRule($PreprocessRule, $CartItemList, $DiscountCode, $Currency, &$HitItemList, &$NonHitItemList, $UserSecurityLevel = 0, $HonorArchiveDate = false, $HonorPublishDate = false, $UserID = 0, $EffectiveBasePriceID = 1) {
		if (trim($PreprocessRule['discount_preprocess_rule_discount_code']) != '' && trim($DiscountCode) != trim($PreprocessRule['discount_preprocess_rule_discount_code'])) {
			$HitQuantity = 0;
			$HitItemList = array();
			$NonHitItemList = $CartItemList;
			return $HitQuantity;
		}

		$BasePriceField = 'product_price';
		if (intval($EffectiveBasePriceID) >= 2 && intval($EffectiveBasePriceID) <=3 )
			$BasePriceField = 'product_price' . $EffectiveBasePriceID;

		$HitQuantity = 0;

		$MyNonHitItemList = array();
		$MyHitItemList = array();

		$PreprocessItemConditionList = discount::GetPreprocessItemCondition($PreprocessRule['discount_preprocess_rule_id']);

		foreach ($CartItemList as $I) {
			$IsHit = true;

			foreach ($PreprocessItemConditionList as $Cond) {
				$IsHit = cart::ProcessDiscountPreprocessItemCondition($Cond, $I, $UserSecurityLevel, $HonorArchiveDate, $HonorPublishDate);
				if (!$IsHit)
					break;
			}

			if ($IsHit) {
				array_push($MyHitItemList, $I);
				$HitQuantity += $I['quantity'];
			}
			else
				array_push($MyNonHitItemList, $I);
		}

		if ($HitQuantity == 0) {
			$HitItemList = array();
			$NonHitItemList = $CartItemList;
			return $HitQuantity;
		}

		// Now apply the rule to the item
		if ($PreprocessRule['discount_preprocess_discount_type_id'] == 1) {
			// Quantity X(discount1_min_quantity) or above, Y%(discount1_off_p) Off
			if ($PreprocessRule['discount_preprocess_discount1_min_quantity'] > $HitQuantity) {
				// Not enough qty to qualify					
				$HitQuantity = 0;
				$HitItemList = array();
				$NonHitItemList = $CartItemList;
				return $HitQuantity;
			}
			else {
				// Now check for maximum allowed 
				$AllowedUserQtyLeft		= 999999;
				$AllowedGlobalQtyLeft	= 999999;
				if ($PreprocessRule['discount_preprocess_rule_quota_user'] > 0) {
					$AllowedUserQtyLeft = $PreprocessRule['discount_preprocess_rule_quota_user'] - discount::GetPreprocessRuleQtyUsageForUser($PreprocessRule['discount_preprocess_rule_id'], $UserID);
					if ($AllowedUserQtyLeft < 0)
						$AllowedUserQtyLeft = 0;
				}
				if ($PreprocessRule['discount_preprocess_rule_quota_all'] > 0) {
					$AllowedGlobalQtyLeft = $PreprocessRule['discount_preprocess_rule_quota_all'] - discount::GetPreprocessRuleQtyUsageForGlobal($PreprocessRule['discount_preprocess_rule_id']);
					if ($AllowedGlobalQtyLeft < 0)
						$AllowedGlobalQtyLeft = 0;
				}
				$EffectiveDiscountQuantity = min($AllowedGlobalQtyLeft, $AllowedUserQtyLeft);

				$TargetQuantity = $EffectiveDiscountQuantity;

				foreach ($MyHitItemList as $Key => $I) {
					if ($I[$BasePriceField] != NULL)
						$I['product_base_price'] = $I[$BasePriceField];
					else
						$I['product_base_price'] = $I['product_price'];

					$I['product_base_price_ca'] = round($I['product_base_price'] * $Currency['currency_site_rate'], $Currency['currency_precision']);

					$I['product_price_ca'] = round($I['product_price'] * $Currency['currency_site_rate'], $Currency['currency_precision']);
					$I['product_price2_ca'] = round($I['product_price2'] * $Currency['currency_site_rate'], $Currency['currency_precision']);
					$I['product_price3_ca'] = round($I['product_price3'] * $Currency['currency_site_rate'], $Currency['currency_precision']);

					if ($TargetQuantity >= $I['quantity']) {
						$TargetQuantity = $TargetQuantity - $I['quantity'];

						$I['product_base_price_ca'] 			= round($I['product_base_price'] * $Currency['currency_site_rate'], $Currency['currency_precision']);
						$I['actual_unit_price']			= round($I['product_base_price'] * (100 - $PreprocessRule['discount_preprocess_discount1_off_p']) / 100, $Currency['currency_precision']);
						$I['actual_unit_price_ca']		= round($I['product_base_price_ca'] * (100 - $PreprocessRule['discount_preprocess_discount1_off_p']) / 100, $Currency['currency_precision']);
						$I['actual_subtotal_price']		= round($I['actual_unit_price'] * $I['quantity'], $Currency['currency_precision']);
						$I['actual_subtotal_price_ca']	= round($I['actual_unit_price_ca'] * $I['quantity'], $Currency['currency_precision']);
						$I['discount_desc'] = $PreprocessRule['discount_preprocess_discount1_off_p'] . "% OFF";
						$I['effective_discount_type'] = 5;
						$I['effective_discount_preprocess_rule_id'] = $PreprocessRule['discount_preprocess_rule_id'];
						$I['product_bonus_point_amount'] = intval($I['product_bonus_point_amount'] * $I['quantity']);

						array_push($HitItemList, $I);
					}
					else {
						if ($TargetQuantity > 0) {
							$MyRow = $I;
							$MyRow['quantity'] = $TargetQuantity;
							$MyRow['product_base_price_ca'] 	= round($MyRow['product_base_price'] * $Currency['currency_site_rate'], $Currency['currency_precision']);
							$MyRow['actual_unit_price']			= round($MyRow['product_base_price'] * (100 - $PreprocessRule['discount_preprocess_discount1_off_p']) / 100, $Currency['currency_precision']);
							$MyRow['actual_unit_price_ca']		= round($MyRow['product_base_price_ca'] * (100 - $PreprocessRule['discount_preprocess_discount1_off_p']) / 100, $Currency['currency_precision']);
							$MyRow['actual_subtotal_price']		= round($MyRow['actual_unit_price'] * $MyRow['quantity'], $Currency['currency_precision']);
							$MyRow['actual_subtotal_price_ca']	= round($MyRow['actual_unit_price_ca'] * $MyRow['quantity'], $Currency['currency_precision']);
							$MyRow['discount_desc'] = $PreprocessRule['discount_preprocess_discount1_off_p'] . "% OFF";
							$MyRow['effective_discount_type'] = 5;
							$MyRow['effective_discount_preprocess_rule_id'] = $PreprocessRule['discount_preprocess_rule_id'];
							$MyRow['product_bonus_point_amount'] = intval($MyRow['product_bonus_point_amount'] * $MyRow['quantity']);
							array_push($HitItemList, $MyRow);
						}

						$I['quantity'] = $I['quantity'] - $TargetQuantity;
						array_push($MyNonHitItemList, $I);
						$TargetQuantity = 0;
					}
				}
				$NonHitItemList = $MyNonHitItemList;

				$HitQuantity = $EffectiveDiscountQuantity;
				return $HitQuantity;
			}
		}
		elseif ($PreprocessRule['discount_preprocess_discount_type_id'] == 2) {
			//	$X for Y
//				if ($PreprocessRule['discount_preprocess_discount2_amount'] > $HitQuantity || $PreprocessRule['discount_preprocess_discount2_amount'] <= 1) {
//				Update: 2012/05/30 discoun2_amount = 1 should be valid here! $100 for 1
			if ($PreprocessRule['discount_preprocess_discount2_amount'] > $HitQuantity || $PreprocessRule['discount_preprocess_discount2_amount'] <= 0) {
				$HitItemList = array();
				$NonHitItemList = $CartItemList;
				return 0;
			}
			else {
				$PreprocessRule['discount_preprocess_discount2_price_ca'] = round($PreprocessRule['discount_preprocess_discount2_price'] * $Currency['currency_site_rate'], $Currency['currency_precision']);

				$AllowedUserQtyLeft		= 999999;
				$AllowedGlobalQtyLeft	= 999999;
				if ($PreprocessRule['discount_preprocess_rule_quota_user'] > 0) {
					$AllowedUserQtyLeft = $PreprocessRule['discount_preprocess_rule_quota_user'] - discount::GetPreprocessRuleQtyUsageForUser($PreprocessRule['discount_preprocess_rule_id'], $UserID);
					if ($AllowedUserQtyLeft < 0)
						$AllowedUserQtyLeft = 0;
				}
				if ($PreprocessRule['discount_preprocess_rule_quota_all'] > 0) {
					$AllowedGlobalQtyLeft = $PreprocessRule['discount_preprocess_rule_quota_all'] - discount::GetPreprocessRuleQtyUsageForGlobal($PreprocessRule['discount_preprocess_rule_id']);
					if ($AllowedGlobalQtyLeft < 0)
						$AllowedGlobalQtyLeft = 0;
				}
				$QtyToCal = min($AllowedGlobalQtyLeft, $AllowedUserQtyLeft, $HitQuantity);

				$EffectiveDiscountQuantity	= floor($QtyToCal / $PreprocessRule['discount_preprocess_discount2_amount']) * $PreprocessRule['discount_preprocess_discount2_amount'];

				$EffectiveNormalQuantity	= $HitQuantity - $EffectiveDiscountQuantity;

				$TargetQuantity = $EffectiveDiscountQuantity;

				foreach ($MyHitItemList as $Key => $I) {
					if ($I[$BasePriceField] != NULL)
						$I['product_base_price'] = $I[$BasePriceField];
					else
						$I['product_base_price'] = $I['product_price'];

					$I['product_base_price_ca'] = round($I['product_base_price'] * $Currency['currency_site_rate'], $Currency['currency_precision']);
					$I['product_price_ca'] = round($I['product_price'] * $Currency['currency_site_rate'], $Currency['currency_precision']);
					$I['product_price2_ca'] = round($I['product_price2'] * $Currency['currency_site_rate'], $Currency['currency_precision']);
					$I['product_price3_ca'] = round($I['product_price3'] * $Currency['currency_site_rate'], $Currency['currency_precision']);

					if ($TargetQuantity >= $I['quantity']) {
						$TargetQuantity = $TargetQuantity - $I['quantity'];

						if ($Key > 0) {
							if ($PreprocessRule['discount_preprocess_discount2_amount'] == 1) {
								$I['actual_subtotal_price']		= $PreprocessRule['discount_preprocess_discount2_price'] * $I['quantity'];
								$I['actual_subtotal_price_ca']	= $PreprocessRule['discount_preprocess_discount2_price_ca'] * $I['quantity'];
								$I['actual_unit_price']			= $PreprocessRule['discount_preprocess_discount2_price'];
								$I['actual_unit_price_ca']		= $PreprocessRule['discount_preprocess_discount2_price_ca'];
							}
							else {
								$I['actual_subtotal_price']		= null;
								$I['actual_subtotal_price_ca']	= null;
								$I['actual_unit_price']			= null;
								$I['actual_unit_price_ca']		= null;
							}
						}
						else {
							if ($PreprocessRule['discount_preprocess_discount2_amount'] == 1) {
								$I['actual_subtotal_price']		= $PreprocessRule['discount_preprocess_discount2_price'] * $I['quantity'];
								$I['actual_subtotal_price_ca']	= $PreprocessRule['discount_preprocess_discount2_price_ca'] * $I['quantity'];
								$I['actual_unit_price']			= $PreprocessRule['discount_preprocess_discount2_price'];
								$I['actual_unit_price_ca']		= $PreprocessRule['discount_preprocess_discount2_price_ca'];
							}
							else {
								$I['actual_subtotal_price']		= floor($EffectiveDiscountQuantity / $PreprocessRule['discount_preprocess_discount2_amount']) * $PreprocessRule['discount_preprocess_discount2_price'];
								$I['actual_subtotal_price_ca']	= floor($EffectiveDiscountQuantity / $PreprocessRule['discount_preprocess_discount2_amount']) * $PreprocessRule['discount_preprocess_discount2_price_ca'];
								$I['actual_unit_price']			= null;
								$I['actual_unit_price_ca']		= null;
							}
						}

						if ($PreprocessRule['discount_preprocess_discount2_amount'] > 1)
						$I['discount_desc'] = $PreprocessRule['discount_preprocess_discount2_price_ca'] . " FOR " . $PreprocessRule['discount_preprocess_discount2_amount'];
						$I['effective_discount_type'] = 5;
						$I['effective_discount_preprocess_rule_id'] = $PreprocessRule['discount_preprocess_rule_id'];
						$I['product_bonus_point_amount'] = intval($I['product_bonus_point_amount'] * $I['quantity']);
						array_push($HitItemList, $I);
					}
					else {
						if ($TargetQuantity > 0) {
							$MyRow = $I;
							$MyRow['quantity'] = $TargetQuantity;

							if ($PreprocessRule['discount_preprocess_discount2_amount'] > 1)
							$MyRow['discount_desc'] = $PreprocessRule['discount_preprocess_discount2_price_ca'] . " FOR " . $PreprocessRule['discount_preprocess_discount2_amount'];
							$MyRow['effective_discount_type'] = 5;
							$MyRow['effective_discount_preprocess_rule_id'] = $PreprocessRule['discount_preprocess_rule_id'];
							$MyRow['product_bonus_point_amount'] = intval($MyRow['product_bonus_point_amount'] * $MyRow['quantity']);

							if ($Key > 0) {
								if ($PreprocessRule['discount_preprocess_discount2_amount'] == 1) {
									$MyRow['actual_subtotal_price']		= $PreprocessRule['discount_preprocess_discount2_price'] * $MyRow['quantity'];
									$MyRow['actual_subtotal_price_ca']	= $PreprocessRule['discount_preprocess_discount2_price_ca'] * $MyRow['quantity'];
									$MyRow['actual_unit_price']			= $PreprocessRule['discount_preprocess_discount2_price'];
									$MyRow['actual_unit_price_ca']		= $PreprocessRule['discount_preprocess_discount2_price_ca'];
								}
								else {
								$MyRow['actual_subtotal_price']		= null;
								$MyRow['actual_subtotal_price_ca']	= null;
								$MyRow['actual_unit_price']		= null;
								$MyRow['actual_unit_price_ca']	= null;
							}
							}
							else {
								if ($PreprocessRule['discount_preprocess_discount2_amount'] == 1) {
									$MyRow['actual_subtotal_price']		= $PreprocessRule['discount_preprocess_discount2_price'] * $MyRow['quantity'];
									$MyRow['actual_subtotal_price_ca']	= $PreprocessRule['discount_preprocess_discount2_price_ca'] * $MyRow['quantity'];
									$MyRow['actual_unit_price']			= $PreprocessRule['discount_preprocess_discount2_price'];
									$MyRow['actual_unit_price_ca']		= $PreprocessRule['discount_preprocess_discount2_price_ca'];
								}
								else {
									$MyRow['actual_subtotal_price']		= floor($EffectiveDiscountQuantity / $PreprocessRule['discount_preprocess_discount2_amount']) * $PreprocessRule['discount_preprocess_discount2_price'];
									$MyRow['actual_subtotal_price_ca']	= floor($EffectiveDiscountQuantity / $PreprocessRule['discount_preprocess_discount2_amount']) * $PreprocessRule['discount_preprocess_discount2_price_ca'];
									$MyRow['actual_unit_price']			= null;
									$MyRow['actual_unit_price_ca']		= null;
								}
							}
							array_push($HitItemList, $MyRow);
						}

						$I['quantity'] = $I['quantity'] - $TargetQuantity;
						array_push($MyNonHitItemList, $I);
						$TargetQuantity = 0;
					}
				}
				$NonHitItemList = $MyNonHitItemList;

				$HitQuantity = $EffectiveDiscountQuantity;
				return $HitQuantity;
			}
		}
		else {
			$HitItemList = array();
			$NonHitItemList = $CartItemList;
			return $HitQuantity;
		}
	}

	private static function ProcessDiscountPreprocessItemCondition($PreprocessItemCondition, $ItemRow, $SecurityLevel = 0, $HonorArchiveDate = false, $HonorPublishDate = false) {
		if ($PreprocessItemCondition['discount_preprocess_item_condition_type_id'] == 1) {
			$IncludeSubCat = 'N';
			if ($PreprocessItemCondition['discount_preprocess_item_condition_para_int_2'] == 1)
				$IncludeSubCat = 'Y';

			if (product::IsProductUnderProductCategory($ItemRow['product_id'], $PreprocessItemCondition['discount_preprocess_item_condition_para_int_1'], $IncludeSubCat, $SecurityLevel, $HonorArchiveDate, $HonorPublishDate))
				return true;
			else
				return false;
		}
		elseif ($PreprocessItemCondition['discount_preprocess_item_condition_type_id'] == 2) {
			if ($ItemRow['product_brand_id'] == $PreprocessItemCondition['discount_preprocess_item_condition_para_int_1'])
				return true;
			else
				return false;
		}
		elseif ($PreprocessItemCondition['discount_preprocess_item_condition_type_id'] == 3) {
			$ProductCatSpecial = product::GetProductCatSpecialInfo($PreprocessItemCondition['discount_preprocess_item_condition_para_int_1'], 0);

			if ($ItemRow['is_special_cat_' . $ProductCatSpecial['product_category_special_no']] == 'Y')
				return true;
			else
				return false;
		}
		else
			return false;
	}

	public static function ApplyPostProcessRule($UserID, $LanguageID, $Currency, $TotalPrice, $UserSecurityLevel, &$NewDiscount, &$NewDiscountCA, &$HitRuleID, $CartType = 'normal', $HonorArchiveDate = false, $HonorPublishDate = false, $SiteID = 0, $SystemAdminID = 0, $ContentAdminID = 0, $ApplyDisabledRules = 'N') {
		$IsEnabled = 'Y';
		if ($ApplyDisabledRules == 'Y')
			$IsEnabled = 'ALL';

		$CartDetails = cart::GetCartDetailsInfo($UserID, $CartType, $SiteID, $SystemAdminID, $ContentAdminID);
		$DiscountCode = $CartDetails['discount_code'];
		if ($DiscountCode == null)
			$DiscountCode = '';				

		// Check if any discount code match first
		$Rules = discount::GetPostprocessRuleList($SiteID, $IsEnabled, $UserSecurityLevel, $HonorArchiveDate, $HonorPublishDate, $DiscountCode, $UserID);
		$Rules2 = discount::GetPostprocessRuleList($SiteID, $IsEnabled, $UserSecurityLevel, $HonorArchiveDate, $HonorPublishDate, '', $UserID);
		$DiscountRuleList = array_merge($Rules, $Rules2);

		$IsHit = false;

		foreach ($DiscountRuleList as $R) {
			if ($IsHit)
				break;

			$Level = null;
			if ($R['discount_postprocess_discount_type_id'] == 1)
				$Level = discount::GetEffectivePostprocessDiscountLevel($UserSecurityLevel , $R['discount_postprocess_rule_id']);
			elseif ($R['discount_postprocess_discount_type_id'] == 2)
				$Level = discount::GetEffectivePostprocessDiscountLevel($TotalPrice , $R['discount_postprocess_rule_id']);

			if ($Level['discount_postprocess_discount_level_type_id'] == 1 && $Level['discount_postprocess_discount1_off_p'] > 0) {
				$IsHit = true;
				$HitRuleID = $R['discount_postprocess_rule_id'];
				$NewDiscount = $TotalPrice * $Level['discount_postprocess_discount1_off_p'] / 100;
				$NewDiscountCA = round($NewDiscount * $Currency['currency_site_rate'], $Currency['currency_precision']);
			}
			elseif ($Level['discount_postprocess_discount_level_type_id'] == 2 && $Level['discount_postprocess_discount2_minus_amount'] > 0) {
				$IsHit = true;
				$HitRuleID = $R['discount_postprocess_rule_id'];
				$NewDiscount = min($TotalPrice, $Level['discount_postprocess_discount2_minus_amount']);
				$NewDiscountCA = round($NewDiscount * $Currency['currency_site_rate'], $Currency['currency_precision']);
			}
		}
	}

	public static function GetCartItemList($UserID, $LanguageID, $Currency, &$TotalListedPrice, &$TotalListedPriceCA, &$TotalPrice, &$TotalPriceCA, &$TotalBonusPoint, &$ContinuePostProcessRule, $CartType = 'normal', $HonorArchiveDate = false, $HonorPublishDate = false, $SiteID = 0, $SystemAdminID = 0, $ContentAdminID = 0, $UserSecurityLevel = 0) {

		cart::FixCartTypeParameter($CartType);

		$CartDetails = cart::GetCartDetailsInfo($UserID, $CartType, $SiteID, $SystemAdminID, $ContentAdminID);

		$inventory_sql = '';

		if ($SiteID != 0) {
			$Site = site::GetSiteInfo($SiteID);

			if ($Site['site_module_inventory_enable'] == 'Y') {
				if ($Site['site_product_allow_under_stock'] == 'N') {
					$inventory_sql =	"			AND	(		(W.product_option_id = 0	AND P.product_stock_level >= W.quantity ) " .
										"					OR	(W.product_option_id != 0	AND POO.product_option_stock_level >= W.quantity ) " .
										"				)";
				}
			}				
		}

		$sql = '';
		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	O.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	O.object_publish_date < NOW() ";

		$EffectiveBasePriceID = $CartDetails['effective_base_price_id'];
		$BasePriceField = 'product_price';			
		if (intval($EffectiveBasePriceID) == 1)
			$BasePriceField = 'product_price';
		else if (intval($EffectiveBasePriceID) >= 2 && intval($EffectiveBasePriceID) <=3 )
			$BasePriceField = 'product_price' . $EffectiveBasePriceID;
		else {
			$BasePriceField = 'product_price';
			$EffectiveBasePriceID = 1;
		}

		$query =	"	SELECT		*, W.*, P.*, OL.*, O.*, L.* " .
					"	FROM		language L	JOIN product P						ON	(L.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN cart_content W					ON	(P.product_id = W.product_id) " .
					"							JOIN object O						ON	(O.object_id = P.product_id) " .
					"							JOIN object_link OL 				ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"							JOIN object PO 						ON	(OL.parent_object_id = PO.object_id) " .
					"							LEFT JOIN product_data D			ON	(D.language_id = L.language_id AND P.product_id = D.product_id) " .
					"							LEFT JOIN product_option POO		ON	(W.product_option_id = POO.product_option_id AND W.product_id = POO.product_id) " .
					"							LEFT JOIN product_option_data POD	ON	(POD.language_id = L.language_id AND W.product_option_id = POD.product_option_id) " .
					"	WHERE		O.object_is_enable = 'Y' " .
					"			AND	OL.object_link_is_enable = 'Y' " .
					"			AND O.object_security_level <= '" . intval($UserSecurityLevel) . "'" . $sql .
					"			AND	W.cart_content_type = '" . aveEscT($CartType) . "'" .
					"			AND	W.user_id = '" . intval($UserID) . "'" .
					"			AND	W.site_id = '" . intval($SiteID) . "'" .
					"			AND	W.system_admin_id = '" . intval($SystemAdminID) . "'" .
					"			AND	W.content_admin_id = '" . intval($ContentAdminID) . "'" .
					"			AND	( PO.object_type = 'PRODUCT_ROOT' OR PO.object_type = 'PRODUCT_CATEGORY' ) " . $inventory_sql . 
					"	GROUP BY	P.product_id, W.product_option_id " .
					"	ORDER BY	P." . $BasePriceField . " DESC, P.product_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$AllCartItemList = array();
		$ProductTotalQuantity = array();

		while ($myResult = $result->fetch_assoc()) {
			$ProductTotalQuantity[$myResult['product_id']] = intval($ProductTotalQuantity[$myResult['product_id']]) + $myResult['quantity'];
			array_push($AllCartItemList, $myResult);
		}

		$DiscountRuleList = discount::GetPreprocessRuleList($SiteID, 'Y', $UserSecurityLevel, $HonorArchiveDate, $HonorPublishDate);
		$HitItemList = array();
		$NonHitItemList = $AllCartItemList;

		$ContinuePostProcessRule = true;

		foreach ($DiscountRuleList as $R) {
			$MyHitItemList = array();
			$MyNonHitItemList = array();
			$HitQuantity = cart::ProcessDiscountPreprocessRule($R, $NonHitItemList, $CartDetails['discount_code'], $Currency, $MyHitItemList, $MyNonHitItemList, $UserSecurityLevel, $HonorArchiveDate, $HonorPublishDate, 0, $EffectiveBasePriceID);
			$HitItemList = array_merge($HitItemList, $MyHitItemList);
			$NonHitItemList = $MyNonHitItemList;

			if ($HitQuantity > 0 && $R['discount_preprocess_rule_stop_process_postprocess_rules'] == 'Y')
				$ContinuePostProcessRule = false;

			if ($HitQuantity > 0 && $R['discount_preprocess_rule_stop_process_below_rules'] == 'Y')
				break;
		}

		$LastProductID = -999;
		$EffectiveDiscountQuantity	= 0;
		$EffectiveFreeQuantity		= 0;
		$EffectiveNormalQuantity	= 0;
		$TargetQuantity = 0;

		$CartItemList = $HitItemList;
		foreach ($NonHitItemList as $myResult) {
			if ($myResult[$BasePriceField] != NULL)
				$myResult['product_base_price'] = $myResult[$BasePriceField];
			else
				$myResult['product_base_price'] = $myResult['product_price'];

			$myResult['product_base_price_ca'] = round($myResult['product_base_price'] * $Currency['currency_site_rate'], $Currency['currency_precision']);

			$myResult['product_price_ca'] = round($myResult['product_price'] * $Currency['currency_site_rate'], $Currency['currency_precision']);
			$myResult['product_price2_ca'] = round($myResult['product_price2'] * $Currency['currency_site_rate'], $Currency['currency_precision']);
			$myResult['product_price3_ca'] = round($myResult['product_price3'] * $Currency['currency_site_rate'], $Currency['currency_precision']);

			$myResult['discount2_price_ca'] = round($myResult['discount2_price'] * $Currency['currency_site_rate'], $Currency['currency_precision']);
			if ($myResult['product_id'] != $LastProductID) {
				if ($myResult['discount_type'] == 0) {
					$myResult['effective_discount_type'] = 0;
					$myResult['actual_subtotal_price']		= $myResult['product_base_price'] * $myResult['quantity'];
					$myResult['actual_subtotal_price_ca']	= $myResult['product_base_price_ca'] * $myResult['quantity'];

					$myResult['actual_unit_price']		= $myResult['product_base_price'];
					$myResult['actual_unit_price_ca']	= $myResult['product_base_price_ca'];

					$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
					$LastProductID = -999;
					array_push($CartItemList, $myResult);
				}
				elseif ($myResult['discount_type'] == 1) {
					$myResult['actual_unit_price']		= round($myResult['product_base_price'] * (100 - $myResult['discount1_off_p']) / 100, $Currency['currency_precision']);
					$myResult['actual_unit_price_ca']	= round($myResult['product_base_price_ca'] * (100 - $myResult['discount1_off_p']) / 100, $Currency['currency_precision']);

					$myResult['actual_subtotal_price']		= round($myResult['actual_unit_price'] * $myResult['quantity'], $Currency['currency_precision']);
					$myResult['actual_subtotal_price_ca']	= round($myResult['actual_unit_price_ca'] * $myResult['quantity'], $Currency['currency_precision']);

					$myResult['discount_desc'] = $myResult['discount1_off_p'] . "% OFF";
					$myResult['effective_discount_type'] = 1;
					$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
					$LastProductID = -999;
					array_push($CartItemList, $myResult);
				}
				elseif ($myResult['discount_type'] == 2 ) {
					if ($myResult['discount2_amount'] <= 1) {
						// $100 for 1? Must be something wrong, so no discount
						$myResult['effective_discount_type'] = 0;
						$myResult['actual_subtotal_price']		= $myResult['product_base_price'] * $myResult['quantity'];
						$myResult['actual_subtotal_price_ca']	= $myResult['product_base_price_ca'] * $myResult['quantity'];
						$myResult['actual_unit_price']		= $myResult['product_base_price'];
						$myResult['actual_unit_price_ca']	= $myResult['product_base_price_ca'];
						$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
						$LastProductID = -999;
						array_push($CartItemList, $myResult);
					}
					else {
						$EffectiveDiscountQuantity = floor($ProductTotalQuantity[$myResult['product_id']] / $myResult['discount2_amount']) * $myResult['discount2_amount'];
						$EffectiveNormalQuantity = $myResult['quantity'] - $EffectiveDiscountQuantity;
						$TargetQuantity = $EffectiveDiscountQuantity;
						$LastProductID = $myResult['product_id'];

						if ($TargetQuantity >= $myResult['quantity']) {
							$TargetQuantity = $TargetQuantity - $myResult['quantity'];
							$myResult['actual_subtotal_price']		= floor($ProductTotalQuantity[$myResult['product_id']] / $myResult['discount2_amount']) * $myResult['discount2_price'];
							$myResult['actual_subtotal_price_ca']	= floor($ProductTotalQuantity[$myResult['product_id']] / $myResult['discount2_amount']) * $myResult['discount2_price_ca'];
							$myResult['actual_unit_price']		= null;
							$myResult['actual_unit_price_ca']	= null;

							$myResult['discount_desc'] = $myResult['discount2_price_ca'] . " FOR " . $myResult['discount2_amount'];
							$myResult['effective_discount_type'] = 2;
							$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
							array_push($CartItemList, $myResult);
						}
						else {
							if ($TargetQuantity > 0) {
								$MyRow = $myResult;
								$MyRow['actual_subtotal_price']		= floor($myResult['quantity'] / $myResult['discount2_amount']) * $myResult['discount2_price'];
								$MyRow['actual_subtotal_price_ca']	= floor($myResult['quantity'] / $myResult['discount2_amount']) * $myResult['discount2_price_ca'];
								$MyRow['actual_unit_price']		= null;
								$MyRow['actual_unit_price_ca']	= null;
								$MyRow['quantity'] = $TargetQuantity;
								$MyRow['discount_desc'] = $myResult['discount2_price_ca'] . " FOR " . $myResult['discount2_amount'];
								$MyRow['effective_discount_type'] = 2;
								$MyRow['product_bonus_point_amount'] = intval($MyRow['product_bonus_point_amount'] * $MyRow['quantity']);
								array_push($CartItemList, $MyRow);
							}

							$myResult['quantity'] = $myResult['quantity'] - $TargetQuantity;
							$myResult['actual_subtotal_price']		= $myResult['product_base_price'] * $myResult['quantity'];
							$myResult['actual_subtotal_price_ca']	= $myResult['product_base_price_ca'] * $myResult['quantity'];
							$myResult['actual_unit_price']		= $myResult['product_base_price'];
							$myResult['actual_unit_price_ca']	= $myResult['product_base_price_ca'];
							$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
							$myResult['effective_discount_type'] = 0;
							array_push($CartItemList, $myResult);

							$TargetQuantity = 0;
						}
					}
				}
				elseif ($myResult['discount_type'] == 3) {
					if ($myResult['discount3_buy_amount'] < 1 || $myResult['discount3_free_amount'] < 1) {
						// Buy 0 Get 1 Free??? Must be something wrong, so no discount
						$myResult['actual_subtotal_price']		= $myResult['product_base_price'] * $myResult['quantity'];
						$myResult['actual_subtotal_price_ca']	= $myResult['product_base_price_ca'] * $myResult['quantity'];
						$myResult['actual_unit_price']		= $myResult['product_base_price'];
						$myResult['actual_unit_price_ca']	= $myResult['product_base_price_ca'];
						$myResult['effective_discount_type'] = 0;
						$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
						$LastRemainingRow == -999;
						array_push($CartItemList, $myResult);
					}
					else {
//							$EffectiveFreeQuantity		= floor($myResult['quantity'] / ($myResult['discount3_buy_amount'] + $myResult['discount3_free_amount'])) * $myResult['discount3_free_amount'];
						$EffectiveFreeQuantity		= floor($ProductTotalQuantity[$myResult['product_id']] / ($myResult['discount3_buy_amount'] + $myResult['discount3_free_amount'])) * $myResult['discount3_free_amount'];
						$EffectiveNormalQuantity	= $ProductTotalQuantity[$myResult['product_id']] - $EffectiveFreeQuantity;
						$TargetQuantity = $EffectiveNormalQuantity;
						$LastProductID = $myResult['product_id'];

						if ($TargetQuantity >= $myResult['quantity']) {
							$TargetQuantity = $TargetQuantity - $myResult['quantity'];
							$myResult['actual_subtotal_price']		= $myResult['product_base_price'] * $myResult['quantity'];
							$myResult['actual_subtotal_price_ca']	= $myResult['product_base_price_ca'] * $myResult['quantity'];
							$myResult['actual_unit_price']		= $myResult['product_base_price'];
							$myResult['actual_unit_price_ca']	= $myResult['product_base_price_ca'];
							$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
							$myResult['effective_discount_type'] = 0;
							array_push($CartItemList, $myResult);
						}
						else {
							if ($TargetQuantity > 0) {
								$MyRow = $myResult;
								$MyRow['quantity'] = $TargetQuantity;
								$MyRow['actual_subtotal_price']		= $MyRow['product_base_price'] * $MyRow['quantity'];
								$MyRow['actual_subtotal_price_ca']	= $MyRow['product_base_price_ca'] * $MyRow['quantity'];
								$MyRow['actual_unit_price']		= $MyRow['product_base_price'];
								$MyRow['actual_unit_price_ca']	= $MyRow['product_base_price_ca'];
								$MyRow['product_bonus_point_amount'] = intval($MyRow['product_bonus_point_amount'] * $MyRow['quantity']);
								$myResult['effective_discount_type'] = 0;
								array_push($CartItemList, $MyRow);
							}

							$myResult['quantity'] = $myResult['quantity'] - $TargetQuantity;
							$myResult['actual_subtotal_price']		= 0;
							$myResult['actual_subtotal_price_ca']	= 0;
							$myResult['actual_unit_price']		= 0;
							$myResult['actual_unit_price_ca']	= 0;
							$myResult['discount_desc'] = "BUY " . $myResult['discount3_buy_amount'] . " GET " . $myResult['discount3_free_amount'] . " FREE";
							$myResult['effective_discount_type'] = 3;
							$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
							array_push($CartItemList, $myResult);

							$TargetQuantity = 0;
						}
					}
				}
				elseif ($myResult['discount_type'] == 4) {
					$EffectiveProductPriceLevel = product::GetEffectiveProductPriceLevel($myResult['product_id'], $ProductTotalQuantity[$myResult['product_id']]);

					$myResult['product_base_price_ca'] = round($EffectiveProductPriceLevel['product_price_level_price'] * $Currency['currency_site_rate'], $Currency['currency_precision']);

					$myResult['effective_discount_type'] = 4;
					$myResult['actual_subtotal_price']		= $EffectiveProductPriceLevel['product_price_level_price'] * $myResult['quantity'];
					$myResult['actual_subtotal_price_ca']	= $myResult['product_base_price_ca'] * $myResult['quantity'];

					$myResult['actual_unit_price']		= $EffectiveProductPriceLevel['product_price_level_price'];
					$myResult['actual_unit_price_ca']	= $myResult['product_base_price_ca'];

					$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
					$LastProductID = -999;
					array_push($CartItemList, $myResult);
				}
			}
			else {
				if ($myResult['discount_type'] == 2 ) {
					if ($TargetQuantity >= $myResult['quantity']) {
						$TargetQuantity = $TargetQuantity - $myResult['quantity'];
						$myResult['actual_subtotal_price']		= null;
						$myResult['actual_subtotal_price_ca']	= null;
						$myResult['actual_unit_price']		= null;
						$myResult['actual_unit_price_ca']	= null;
						$myResult['discount_desc'] = $myResult['discount2_price_ca'] . " FOR " . $myResult['discount2_amount'];
						$myResult['effective_discount_type'] = 2;
						$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
						array_push($CartItemList, $myResult);
					}
					else {
						if ($TargetQuantity > 0) {
							$MyRow = $myResult;
							$MyRow['actual_subtotal_price']		= 0;
							$MyRow['actual_subtotal_price_ca']	= 0;
							$MyRow['actual_unit_price']		= null;
							$MyRow['actual_unit_price_ca']	= null;
							$MyRow['quantity'] = $TargetQuantity;
							$MyRow['discount_desc'] = $myResult['discount2_price_ca'] . " FOR " . $myResult['discount2_amount'];
							$MyRow['effective_discount_type'] = 2;
							$MyRow['product_bonus_point_amount'] = intval($MyRow['product_bonus_point_amount'] * $MyRow['quantity']);
							array_push($CartItemList, $MyRow);
						}

						$myResult['quantity'] = $myResult['quantity'] - $TargetQuantity;
						$myResult['actual_subtotal_price']		= $myResult['product_base_price'] * $myResult['quantity'];
						$myResult['actual_subtotal_price_ca']	= $myResult['product_base_price_ca'] * $myResult['quantity'];
						$myResult['actual_unit_price']		= $myResult['product_base_price'];
						$myResult['actual_unit_price_ca']	= $myResult['product_base_price_ca'];
						$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
						$myResult['effective_discount_type'] = 0;
						array_push($CartItemList, $myResult);

						$TargetQuantity = 0;
					}
				}
				elseif ($myResult['discount_type'] == 3 ) {
					if ($TargetQuantity >= $myResult['quantity']) {
						$TargetQuantity = $TargetQuantity - $myResult['quantity'];
						$myResult['actual_subtotal_price']		= $myResult['product_base_price'] * $myResult['quantity'];
						$myResult['actual_subtotal_price_ca']	= $myResult['product_base_price_ca'] * $myResult['quantity'];
						$myResult['actual_unit_price']		= $myResult['product_base_price'];
						$myResult['actual_unit_price_ca']	= $myResult['product_base_price_ca'];
						$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
						$myResult['effective_discount_type'] = 0;
						array_push($CartItemList, $myResult);
					}
					else {
						if ($TargetQuantity > 0) {
							$MyRow = $myResult;
							$MyRow['quantity'] = $TargetQuantity;
							$MyRow['actual_subtotal_price']		= $MyRow['product_base_price'] * $MyRow['quantity'];
							$MyRow['actual_subtotal_price_ca']	= $MyRow['product_base_price_ca'] * $MyRow['quantity'];
							$MyRow['actual_unit_price']		= $MyRow['product_base_price'];
							$MyRow['actual_unit_price_ca']	= $MyRow['product_base_price_ca'];
							$MyRow['product_bonus_point_amount'] = intval($MyRow['product_bonus_point_amount'] * $MyRow['quantity']);
							$MyRow['effective_discount_type'] = 0;
							array_push($CartItemList, $MyRow);
						}

						$myResult['quantity'] = $myResult['quantity'] - $TargetQuantity;
						$myResult['actual_subtotal_price']		= 0;
						$myResult['actual_subtotal_price_ca']	= 0;
						$myResult['actual_unit_price']		= 0;
						$myResult['actual_unit_price_ca']	= 0;
						$myResult['discount_desc'] = "BUY " . $myResult['discount3_buy_amount'] . " GET " . $myResult['discount3_free_amount'] . " FREE";
						$myResult['effective_discount_type'] = 3;
						$myResult['product_bonus_point_amount'] = intval($myResult['product_bonus_point_amount'] * $myResult['quantity']);
						array_push($CartItemList, $myResult);

						$TargetQuantity = 0;
					}
				}
			}
		}

		$TotalPrice = 0;
		$TotalPriceCA = 0;
		$TotalListedPrice = 0;
		$TotalListedPriceCA = 0;
		$TotalBonusPoint = 0;
		foreach($CartItemList as $Item) {
			$TotalBonusPoint = $TotalBonusPoint + $Item['product_bonus_point_amount'];
			$TotalPrice = $TotalPrice + $Item['actual_subtotal_price'];
			$TotalPriceCA = $TotalPriceCA + $Item['actual_subtotal_price_ca'];
			$TotalListedPrice = $TotalListedPrice + $Item['product_price'] * $Item['quantity'];
			$TotalListedPriceCA = $TotalListedPriceCA + $Item['product_price_ca'] * $Item['quantity'];
		}
		return $CartItemList;
	}

	public static function ExportMyOrderXLSBySiteID($SiteID, $IsHandled = 'ALL', $OrderType = 'ALL', $OrderNo = '', $OrderStatus = '', $Username = '', $UserEmail = '', $InvoiceTelNo = '', $PayAmountCaMin = '', $PayAmountCaMax = '', $PaymentConfirmBy = '', $UserReference = '', $OrderDateFrom = '', $OrderDateTo = '') {
		$sql = '';
		if ($IsHandled == 'Y')
			$sql = $sql . "	AND	O.is_handled = 'Y' ";
		elseif ($IsHandled == 'N')
			$sql = $sql . "	AND	O.is_handled = 'N' ";
		if (trim($OrderNo) != '')
			$sql = $sql . "	AND O.order_no = '" . aveEscT($OrderNo) . "' ";
		if (trim($OrderStatus) != '' && trim($OrderStatus) != 'any')
			$sql = $sql . "	AND O.order_status LIKE '%" . aveEscT($OrderStatus) . "%' ";
		if (trim($Username) != '')
			$sql = $sql . "	AND U.user_username LIKE '%" . aveEscT($Username) . "%' ";
		if (trim($UserEmail) != '')
			$sql = $sql . "	AND U.user_email LIKE '%" . aveEscT($UserEmail) . "%' ";
		if (trim($InvoiceTelNo) != '')
			$sql = $sql . "	AND O.user_tel_no LIKE '%" . aveEscT($InvoiceTelNo) . "%' ";
		if (trim($PayAmountCaMin) != '')
			$sql = $sql . "	AND O.pay_amount_ca >= '" . aveEscT($PayAmountCaMin) . "' ";
		if (trim($PayAmountCaMax) != '')
			$sql = $sql . "	AND O.pay_amount_ca <= '" . aveEscT($PayAmountCaMax) . "' ";
		if (trim($PaymentConfirmBy) != '')
			$sql = $sql . "	AND O.payment_confirm_by LIKE '%" . aveEscT($PaymentConfirmBy) . "%' ";
		if (trim($UserReference) != '')
			$sql = $sql . "	AND O.user_reference LIKE '%" . aveEscT($UserReference) . "%' ";
		if (trim($OrderDateFrom) != '')
			$sql = $sql . "	AND O.order_confirm_date >= '" . aveEscT($OrderDateFrom) . "' ";
		if (trim($OrderDateTo) != '')
			$sql = $sql . "	AND O.order_confirm_date <= '" . aveEscT($OrderDateTo) . " 23:59:59' ";

		if ($OrderType == 'order')
			$sql = $sql . "	AND O.order_content_type = 'normal' ";
		elseif ($OrderType == 'redeem')
			$sql = $sql . "	AND O.order_content_type = 'bonus_point' ";

		$query =	"	SELECT		* " .
					"	FROM		myorder O	JOIN	user U				ON	(O.user_id		=	U.user_id) " .
					"							JOIN	currency C			ON	(C.currency_id	=	O.currency_id) " .
					"							JOIN	myorder_product MP	ON	(MP.myorder_id	=	O.myorder_id) "	.
					"							JOIN	product P			ON	(P.product_id	=	MP.product_id) " .
					"	WHERE		O.site_id = '" . $SiteID . "'" . $sql .
					"	ORDER BY	O.myorder_id DESC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		// header("Content-Length: " . strlen($Output));
		// Output to browser with appropriate mime type, you choose ;)
		//header("Content-type: text/x-csv");
		header("Content-type: application/vnd.ms-excel");
		//header("Content-type: text/csv");
		//header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=order_export_csv.xls");			

		$smarty = new mySmarty();

		$MyOrderCustomFieldsDef = site::GetMyorderCustomFieldsDef($SiteID);
		$smarty->assign('MyOrderCustomFieldsDef', $MyOrderCustomFieldsDef);

		$ProductCustomFieldsDef = site::GetProductCustomFieldsDef($SiteID);
		$smarty->assign('ProductCustomFieldsDef', $ProductCustomFieldsDef);

		$smarty->display('myadmin/order_export_xls_header.tpl');
		while ($myResult = $result->fetch_assoc()) {
			$smarty->assign('MyOrderRow', $myResult);
			$smarty->display('myadmin/order_export_xls_body.tpl');				
		}			
		$smarty->display('myadmin/order_export_xls_footer.tpl');
	}

	public static function GetMyOrderListBySiteID($SiteID, &$TotalOrders, $PageNo = 1, $OrdersPerPage = 20, $IsHandled = 'ALL', $OrderType = 'ALL', $OrderNo = '', $OrderStatus = '', $Username = '', $UserEmail = '', $InvoicePhoneNo = '', $PayAmountCaMin = '', $PayAmountCaMax = '', $PaymentConfirmBy = '', $UserReference = '', $OrderDateFrom = '', $OrderDateTo = '', $ShopID = false) {
		$Offset = intval(($PageNo -1) * $OrdersPerPage);

		$sql = '';
		if ($IsHandled == 'Y')
			$sql = $sql . "	AND	O.is_handled = 'Y' ";
		elseif ($IsHandled == 'N')
			$sql = $sql . "	AND	O.is_handled = 'N' ";
		if (trim($OrderNo) != '')
			$sql = $sql . "	AND O.order_no = '" . aveEscT($OrderNo) . "' ";
		if (trim($OrderStatus) != '' && trim($OrderStatus) != 'any')
			$sql = $sql . "	AND O.order_status LIKE '%" . aveEscT($OrderStatus) . "%' ";
		if (trim($Username) != '') {
			//$sql = $sql . "	AND U.user_username LIKE '%" . trim($Username) . "%' ";
			$sql = $sql . "	AND	( " ; 
			$sql = $sql . "     U.user_username LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_email LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_tel_no LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_address_1 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_address_2 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_note LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_1 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_2 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_3 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_4 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_5 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_6 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_7 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_8 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_9 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_10 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_11 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_12 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_13 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_14 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_15 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_16 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_17 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_18 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_19 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR 	U.user_custom_text_20 LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . "	OR	U.user_first_name LIKE '%" . aveEscT($Username) . "%' ";
			$sql = $sql . " OR	U.user_last_name LIKE '%" . aveEscT($Username) . "%' " ; 
			$sql .= " ) " ;

		}
		if (trim($UserEmail) != '')
			$sql = $sql . "	AND U.user_email LIKE '%" . aveEscT($UserEmail) . "%' ";
		if (trim($InvoicePhoneNo) != '') {
			$sql .= "	AND ( ";
			$sql .= "			O.invoice_phone_no LIKE '%" . aveEscT($InvoicePhoneNo) . "%' ";
			$sql .= "	OR		O.delivery_phone_no LIKE '%" . aveEscT($InvoicePhoneNo) . "%' ";
			$sql .= "	OR		U.user_tel_no LIKE '%" . aveEscT($InvoicePhoneNo) . "%' ";
			$sql .= "		) " ;
		}
		if (trim($PayAmountCaMin) != '')
			$sql = $sql . "	AND O.pay_amount_ca >= '" . aveEscT($PayAmountCaMin) . "' ";
		if (trim($PayAmountCaMax) != '')
			$sql = $sql . "	AND O.pay_amount_ca <= '" . aveEscT($PayAmountCaMax) . "' ";
		if (trim($PaymentConfirmBy) != '')
			$sql = $sql . "	AND O.payment_confirm_by LIKE '%" . aveEscT($PaymentConfirmBy) . "%' ";
		if (trim($UserReference) != '')
			$sql = $sql . "	AND O.user_reference LIKE '%" . aveEscT($UserReference) . "%' ";
		if (trim($OrderDateFrom) != '')
			$sql = $sql . "	AND O.order_confirm_date >= '" . aveEscT($OrderDateFrom) . "' ";
		if (trim($OrderDateTo) != '')
			$sql = $sql . "	AND O.order_confirm_date <= '" . aveEscT($OrderDateTo) . " 23:59:59' ";

		if ($OrderType == 'order')
			$sql = $sql . "	AND O.order_content_type = 'normal' ";
		elseif ($OrderType == 'redeem')
			$sql = $sql . "	AND O.order_content_type = 'bonus_point' ";

		if ($ShopID !== false)
			$sql = $sql . "	AND O.shop_id = '" . intval($ShopID) . "' ";

		$query =	"	SELECT		SQL_CALC_FOUND_ROWS * " .
					"	FROM		myorder O	JOIN	user U		ON (O.user_id = U.user_id) " .
					"							JOIN	currency C	ON (C.currency_id = O.currency_id) " .
					"	WHERE		O.site_id = '" . $SiteID . "'" . $sql .
					"	ORDER BY	O.myorder_id DESC " .
					"	LIMIT	" . $Offset . ", " . intval($OrdersPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalOrders = $myResult[0];

		$MyOrderList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($MyOrderList, $myResult);
		}
		return $MyOrderList;
	}

	public static function GetNoOfOrdersBySiteID($SiteID, $IsHandled = 'ALL') {
		$sql = '';
		if ($IsHandled == 'Y')
			$sql = "	AND	O.is_handled = 'Y' ";
		elseif ($IsHandled == 'N')
			$sql = "	AND	O.is_handled = 'N' ";

		$query =	"	SELECT		COUNT(*) as no_of_orders " .
					"	FROM		myorder O	JOIN	user U		ON (O.user_id = U.user_id) " .
					"	WHERE		O.site_id = '" . $SiteID . "'" . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result->fetch_assoc();
		return $myResult['no_of_orders'];
	}

	public static function GetMyOrderListByUserID($UserID, $IsHandled = 'ALL', $Offset = 0, $RowCount = 20, $CartContentType = 'normal') {			
		$query =	"	SELECT		* " .
					"	FROM		myorder O	JOIN	user U ON (O.user_id = U.user_id) " .
					"							JOIN	currency C	ON (C.currency_id = O.currency_id) " .
					"	WHERE		O.user_id = '" . intval($UserID) . "'" . 
					"			AND	O.order_content_type = '" . aveEscT($CartContentType) . "'" .
					"	ORDER BY	O.myorder_id DESC " .
					"	LIMIT	" . $Offset . ", " . intval($RowCount);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$MyOrderList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($MyOrderList, $myResult);
		}
		return $MyOrderList;
	}

	public static function GetNoOfOrdersByUserID($UserID, $CartContentType = 'normal') {
		$query =	"	SELECT		COUNT(*) as no_of_orders " .
					"	FROM		myorder O	JOIN	user U ON (O.user_id = U.user_id) " .
					"	WHERE		O.user_id = '" . intval($UserID) . "'" .
					"			AND	O.order_content_type = '" . aveEscT($CartContentType) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result->fetch_assoc();
		return $myResult['no_of_orders'];
	}

	public static function GetMyOrderBonusPointItemList($MyOrderID, $LanguageID, &$TotalCashValue, &$TotalCashValueCA, &$TotalBonusPointRequired) {
		$query =	"	SELECT		*, L.*, B.*, O.*, C.*, M.* " .
					"	FROM		language L	JOIN myorder_bonus_point_item M		ON (M.myorder_id = '" . intval($MyOrderID) . "')" .
					"							JOIN currency C 					ON (C.currency_id = M.currency_id) " .
					"							JOIN bonus_point_item B 			ON (B.bonus_point_item_id = M.bonus_point_item_id AND L.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN object O						ON (O.object_id = B.bonus_point_item_id) " .
					"							LEFT JOIN bonus_point_item_data D	ON (D.language_id = L.language_id AND B.bonus_point_item_id = D.bonus_point_item_id) " .
					"	ORDER BY	B.bonus_point_item_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$MyOrderBonusPointItemList = array();

		$TotalCashValue = 0;
		$TotalCashValueCA = 0;
		$TotalBonusPointRequired = 0;
		while ($myResult = $result->fetch_assoc()) {
			$TotalBonusPointRequired = $TotalBonusPointRequired + $myResult['subtotal_bonus_point_required'];
			$TotalCashValue = $TotalCashValue + $myResult['subtotal_cash'];
			$TotalCashValueCA = $TotalCashValueCA + $myResult['subtotal_cash_ca'];
			array_push($MyOrderBonusPointItemList, $myResult);
		}
		return $MyOrderBonusPointItemList;
	}

	public static function GetMyOrderItemList($MyOrderID, $LanguageID, &$TotalPrice, &$TotalPriceCA, &$TotalBonusPoint) {
		$ParentObjTypeToIgnore = array('PRODUCT_BRAND');
		$sql_to_ignore = '';
		foreach ($ParentObjTypeToIgnore as $T)
			$sql_to_ignore = $sql_to_ignore . " AND TPO.object_type != '" . aveEscT($T) . "'";

		$query =	"	SELECT		*, L.*, P.*, OL.*, O.*, C.*, M.* " .
					"	FROM		language L	JOIN myorder_product M	ON ( M.myorder_id = '" . intval($MyOrderID) . "')" .
					"							JOIN currency C ON (C.currency_id = M.currency_id) " .
					"							JOIN product P	ON (P.product_id = M.product_id AND L.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN object O	ON (O.object_id = P.product_id) " .
					"							JOIN object_link OL ON (O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"							JOIN object PO ON (OL.parent_object_id = PO.object_id) " .
					"							LEFT JOIN product_data D ON (D.language_id = L.language_id AND P.product_id = D.product_id) " .
					"							LEFT JOIN product_option_data POD ON (POD.language_id = L.language_id AND POD.product_option_id = M.product_option_id) " .
					"	WHERE		PO.object_type = 'PRODUCT_ROOT' OR PO.object_type = 'PRODUCT_CATEGORY' " .
					"	ORDER BY	P.product_id ASC ";

		$query =	"	SELECT		*, L.*, P.*, OL.*, O.*, C.*, M.* " .
					"	FROM		language L	JOIN myorder_product M	ON ( M.myorder_id = '" . intval($MyOrderID) . "')" .
					"							JOIN currency C ON (C.currency_id = M.currency_id) " .
					"							JOIN product P	ON (P.product_id = M.product_id AND L.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN object O	ON (O.object_id = P.product_id) " .
//						"							JOIN ( SELECT * FROM object_link WHERE object_link_is_shadow = 'N' GROUP BY object_id) OL ON (O.object_id = OL.object_id) " .
					"							JOIN ( SELECT TOL.* FROM object_link TOL JOIN object TPO ON (TOL.parent_object_id = TPO.object_id " . $sql_to_ignore . ") WHERE TOL.object_link_is_shadow = 'N' GROUP BY TOL.object_id) OL ON (O.object_id = OL.object_id) " .
					"							LEFT JOIN product_data D ON (D.language_id = L.language_id AND P.product_id = D.product_id) " .
					"							LEFT JOIN product_option_data POD ON (POD.language_id = L.language_id AND POD.product_option_id = M.product_option_id) " .
					"	ORDER BY	P.product_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$MyOrderItemList = array();

		$TotalPrice = 0;
		$TotalPriceCA = 0;
		$TotalBonusPoint = 0;
		while ($myResult = $result->fetch_assoc()) {
			array_push($MyOrderItemList, $myResult);
			$TotalBonusPoint = $TotalBonusPoint + $myResult['product_bonus_point_amount'];
			$TotalPrice = $TotalPrice + $myResult['actual_subtotal_price'];
			$TotalPriceCA = $TotalPriceCA + $myResult['actual_subtotal_price_ca'];
		}
		return $MyOrderItemList;
	}

	public static function GetMyOrderItemQuantityList($MyOrderID, $LanguageID) {
		$query =	"	SELECT		*, L.*, P.*, OL.*, O.*, M.*, SUM(M.quantity) AS quantity " .
					"	FROM		language L	JOIN myorder_product M	ON ( M.myorder_id = '" . intval($MyOrderID) . "')" .
					"							JOIN product P	ON (P.product_id = M.product_id AND L.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN object O	ON (O.object_id = P.product_id) " .
					"							JOIN object_link OL ON (O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"							JOIN object PO ON (OL.parent_object_id = PO.object_id) " .
					"							LEFT JOIN product_data D ON (D.language_id = L.language_id AND P.product_id = D.product_id) " .
					"							LEFT JOIN product_option_data POD ON (POD.language_id = L.language_id AND POD.product_option_id = M.product_option_id) " .
					"	WHERE		PO.object_type = 'PRODUCT_ROOT' OR PO.object_type = 'PRODUCT_CATEGORY' " .
					"	GROUP BY	M.product_id, M.product_option_id " .
					"	ORDER BY	P.product_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$MyOrderItemList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($MyOrderItemList, $myResult);
		}
		return $MyOrderItemList;
	}

	public static function UpdateMyOrderWithNewCurrencyRate($MyOrderID) {
		$MyOrder	= cart::GetMyOrderInfo($MyOrderID);
		$User		= user::GetUserInfo($MyOrder['user_id']);
		$Currency	= currency::GetCurrencyInfo($MyOrder['currency_id'], $MyOrder['site_id']);			

		$query =	"	UPDATE		myorder_product " .
					"	SET			product_price_ca			=	product_price * '" . $MyOrder['currency_site_rate_atm'] . "', " .
					"				product_price2_ca			=	product_price2 * '" . $MyOrder['currency_site_rate_atm'] . "', " .
					"				product_price3_ca			=	product_price3 * '" . $MyOrder['currency_site_rate_atm'] . "', " .
					"				product_base_price_ca		=	product_base_price * '" . $MyOrder['currency_site_rate_atm'] . "', " .
					"				actual_subtotal_price_ca	=	actual_subtotal_price * '" . $MyOrder['currency_site_rate_atm'] . "', " .
					"				actual_unit_price_ca		=	actual_unit_price * '" . $MyOrder['currency_site_rate_atm'] . "', " .
					"				discount2_price_ca			=	discount2_price * '" . $MyOrder['currency_site_rate_atm'] . "'" .
					"	WHERE		myorder_id = '" . intval($MyOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query 	=	"	SELECT SUM(actual_subtotal_price) AS TotalPrice, SUM(actual_subtotal_price_ca) AS TotalPriceCA, SUM(product_bonus_point_amount) AS TotalBonusPoint " .
					"	FROM	myorder_product " .
					"	WHERE		myorder_id = '" . intval($MyOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result->fetch_assoc();
		$TotalPrice = $myResult['TotalPrice'];
		$TotalPriceCA = $myResult['TotalPriceCA'];
		$TotalBonusPoint = $myResult['TotalBonusPoint'];

		$query =	"	UPDATE		myorder_bonus_point_item " .
					"	SET			cash_ca				=	cash * '" . $MyOrder['currency_site_rate_atm'] . "', " .
					"				subtotal_cash_ca	=	subtotal_cash * '" . $MyOrder['currency_site_rate_atm'] . "'" .
					"	WHERE		myorder_id = '" . $MyOrderID . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$BonusPointCanBeUsed = 0;
		if ($Site['site_use_bonus_point_at_once'] == 'Y')
			$BonusPointCanBeUsed = $User['user_bonus_point'] + $TotalBonusPoint;
		else
			$BonusPointCanBeUsed = $User['user_bonus_point'];

		$RedeemedCashCA = 0;
		$RedeemedCash = 0;
		$BonusPointRequired = 0;
		$BonusPointItemList = cart::GetMyOrderBonusPointItemList($MyOrderID, 1, $RedeemedCash, $RedeemedCashCA, $BonusPointRequired);

		$PostprocessDiscount	= $MyOrder['postprocess_rule_discount_amount'];
		$PostprocessDiscountCA	= $MyOrder['postprocess_rule_discount_amount'] * $MyOrder['currency_site_rate_atm'];
		$PostDiscountRuleID		= $MyOrder['effective_discount_postprocess_rule_id'];
		if ($ContinueProcessPostRule == true)
			cart::ApplyPostProcessRule($MyOrder['user_id'], $User['user_language_id'], $Currency, $TotalPrice, intval($User['user_security_level']), $PostprocessDiscount, $PostprocessDiscountCA, $PostDiscountRuleID, 'normal', true, true, $MyOrder['site_id'], 0, 0, 'N');

		$PayAmountCA = $TotalPriceCA + doubleval($MyOrder['freight_cost_ca']) - doubleval($RedeemedCashCA) - doubleval($MyOrder['discount_amount_ca']) - $PostprocessDiscountCA;
		$UserBalanceUsedCA = $MyOrder['user_balance_used'] * $MyOrder['currency_site_rate_atm'];

		$PayAmountCA = $PayAmountCA - $UserBalanceUsedCA;

		$UserBalanceAfter = $User['user_balance'] - $MyOrder['user_balance_used'];
		if ($PayAmountCA < 0)
			$PayAmountCA = 0;

		$query =	"	UPDATE		myorder " .
					"	SET			bonus_point_previous						=	'" . $User['user_bonus_point'] . "', " .
					"				bonus_point_earned							=	'" . $TotalBonusPoint . "', " .
					"				bonus_point_canbeused						=	'" . $BonusPointCanBeUsed . "', " .
					"				bonus_point_redeemed						=	'" . $BonusPointRequired . "', " .
					"				bonus_point_balance							=	'" . ($User['user_bonus_point'] + $TotalBonusPoint - $BonusPointRequired) . "', " .
					"				bonus_point_redeemed_cash					=	'" . $RedeemedCash . "', " .
					"				bonus_point_redeemed_cash_ca				=	'" . $RedeemedCashCA . "', " .
					"				user_balance_previous						=	'" . $User['user_balance'] . "', " .
					"				user_balance_used							=	'" . $MyOrder['user_balance_used'] . "', " .
					"				user_balance_used_ca						=	'" . $UserBalanceUsedCA . "', " .
					"				user_balance_after							=	'" . $UserBalanceAfter . "', " .
					"				total_price									=	'" . $TotalPrice . "', " .
					"				total_price_ca								=	'" . $TotalPriceCA . "', " .
					"				discount_amount_ca							=	'" . doubleval($MyOrder['discount_amount_ca']) . "', " .
					"				effective_discount_postprocess_rule_id		=	'" . $PostDiscountRuleID . "', " .
					"				postprocess_rule_discount_amount			=	'" . doubleval($PostprocessDiscount) . "', " .
					"				postprocess_rule_discount_amount_ca			=	'" . doubleval($PostprocessDiscountCA) . "', " .
					"				pay_amount_ca								=	'" . $PayAmountCA . "'" .
					"	WHERE		myorder_id = '" . $MyOrderID . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}		

	public static function LockTempCartAcquire($UserID, $SiteID, $SystemAdminID, $ContentAdminID) {
		$LockName	=	'LockTempCart ' . "u" . intval($UserID) . "s" . intval($SiteID) . "sa" . intval($SystemAdminID) . "ca" . intval($ContentAdminID);
		$query		=	"	SELECT GET_LOCK('" . $LockName . "', 180) ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result->fetch_row();

		if (intval($myResult[0]) == 1)
			return true;
		else
			return false;
	}

	public static function LockTempCartRelease($UserID, $SiteID, $SystemAdminID, $ContentAdminID) {
		$LockName	=	'LockTempCart ' . "u" . intval($UserID) . "s" . intval($SiteID) . "sa" . intval($SystemAdminID) . "ca" . intval($ContentAdminID);
		$query		=	"	SELECT RELEASE_LOCK('" . $LockName . "') ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	private static function GetConvertToOrderCustomTextSQL($Type, $InputArray) {
		$sql = '';
		for ($i = 1; $i <= 20; $i++) {
			if ($InputArray['myorder_custom_' . $Type . '_' . $i] != '')
				$sql = $sql . " myorder_custom_" . $Type . '_' . $i . " = '" . aveEscT($InputArray['myorder_custom_' . $Type . '_' . $i]) . "',";
		}
		return $sql;
	}

	public static function ConvertOrderToTempCart($MyOrderID) {
		$MyOrder = cart::GetMyOrderInfo($MyOrderID);

		$sql = cart::GetConvertToOrderCustomTextSQL('text', $MyOrder) . cart::GetConvertToOrderCustomTextSQL('int', $MyOrder) . cart::GetConvertToOrderCustomTextSQL('double', $MyOrder) . cart::GetConvertToOrderCustomTextSQL('date', $MyOrder);

		$sql = $sql . 
					"			discount_code					= '" . aveEscT($MyOrder['discount_code']) . "', " .
					"			effective_base_price_id			= '" . aveEscT($MyOrder['effective_base_price_id']) . "', " .
					"			use_bonus_point					= 'Y', " .
					"			bonus_point_earned_supplied_by_client = '" . aveEscT($MyOrder['bonus_point_earned_supplied_by_client']) . "', " .
					"			deliver_to_different_address	= '" . aveEscT($MyOrder['deliver_to_different_address']) . "', " .
					"			self_take						= '" . aveEscT($MyOrder['self_take']) . "', " .
					"			update_user_address				= 'N', " .
					"			email_order_confirm				= '" . aveEscT($MyOrder['email_order_confirm']) . "', " .
					"			currency_id						= '" . aveEscT($MyOrder['currency_id']) . "', " .
					"			freight_cost_ca					= '" . aveEscT($MyOrder['freight_cost_ca']) . "', " .
					"			discount_amount_ca				= '" . aveEscT($MyOrder['discount_amount_ca']) . "', " .
					"			user_balance_use				= '" . aveEscT($MyOrder['user_balance_used']) . "', " .
					"			invoice_country_id				= '" . aveEscT($MyOrder['invoice_country_id']) . "', " .
					"			invoice_country_other			= '" . aveEscT($MyOrder['invoice_country_other']) . "', " .
					"			invoice_hk_district_id			= '" . aveEscT($MyOrder['invoice_hk_district_id']) . "', " .
					"			invoice_first_name				= '" . aveEscT($MyOrder['invoice_first_name']) . "', " .
					"			invoice_last_name				= '" . aveEscT($MyOrder['invoice_last_name']) . "', " .
					"			invoice_company_name			= '" . aveEscT($MyOrder['invoice_company_name']) . "', " .
					"			invoice_city_name				= '" . aveEscT($MyOrder['invoice_city_name']) . "', " .
					"			invoice_region					= '" . aveEscT($MyOrder['invoice_region']) . "', " .
					"			invoice_postcode				= '" . aveEscT($MyOrder['invoice_postcode']) . "', " .
					"			invoice_phone_no				= '" . aveEscT($MyOrder['invoice_phone_no']) . "', " .
					"			invoice_tel_country_code		= '" . aveEscT($MyOrder['invoice_tel_country_code']) . "', " .
					"			invoice_tel_area_code			= '" . aveEscT($MyOrder['invoice_tel_area_code']) . "', " .
					"			invoice_fax_country_code		= '" . aveEscT($MyOrder['invoice_fax_country_code']) . "', " .
					"			invoice_fax_area_code			= '" . aveEscT($MyOrder['invoice_fax_area_code']) . "', " .
					"			invoice_fax_no					= '" . aveEscT($MyOrder['invoice_fax_no']) . "', " .
					"			invoice_shipping_address_1		= '" . aveEscT($MyOrder['invoice_shipping_address_1']) . "', " .
					"			invoice_shipping_address_2		= '" . aveEscT($MyOrder['invoice_shipping_address_2']) . "', " .
					"			invoice_email					= '" . aveEscT($MyOrder['invoice_email']) . "', " .
					"			delivery_country_id				= '" . aveEscT($MyOrder['delivery_country_id']) . "', " .
					"			delivery_country_other			= '" . aveEscT($MyOrder['delivery_country_other']) . "', " .
					"			delivery_hk_district_id			= '" . aveEscT($MyOrder['delivery_hk_district_id']) . "', " .
					"			delivery_first_name				= '" . aveEscT($MyOrder['delivery_first_name']) . "', " .
					"			delivery_last_name				= '" . aveEscT($MyOrder['delivery_last_name']) . "', " .
					"			delivery_company_name			= '" . aveEscT($MyOrder['delivery_company_name']) . "', " .
					"			delivery_city_name				= '" . aveEscT($MyOrder['delivery_city_name']) . "', " .
					"			delivery_region					= '" . aveEscT($MyOrder['delivery_region']) . "', " .
					"			delivery_postcode				= '" . aveEscT($MyOrder['delivery_postcode']) . "', " .
					"			delivery_phone_no				= '" . aveEscT($MyOrder['delivery_phone_no']) . "', " .
					"			delivery_tel_country_code		= '" . aveEscT($MyOrder['delivery_tel_country_code']) . "', " .
					"			delivery_tel_area_code			= '" . aveEscT($MyOrder['delivery_tel_area_code']) . "', " .
					"			delivery_fax_no					= '" . aveEscT($MyOrder['delivery_fax_no']) . "', " .
					"			delivery_fax_country_code		= '" . aveEscT($MyOrder['delivery_fax_country_code']) . "', " .
					"			delivery_fax_area_code			= '" . aveEscT($MyOrder['delivery_fax_area_code']) . "', " .
					"			delivery_shipping_address_1		= '" . aveEscT($MyOrder['delivery_shipping_address_1']) . "', " .
					"			delivery_shipping_address_2		= '" . aveEscT($MyOrder['delivery_shipping_address_2']) . "', " .
					"			delivery_email					= '" . aveEscT($MyOrder['delivery_email']) . "', " .
					"			user_message					= '" . aveEscT($MyOrder['user_message']) . "' ";

		$query =	"	INSERT INTO	cart_details " .
					"	SET		system_admin_id = 0, " .
					"			content_admin_id = 0, " .
					"			user_id = '" . $MyOrder['user_id'] . "', " .
					"			site_id = '" . $MyOrder['site_id'] . "', " .
					"			cart_content_type = 'temp', " . $sql .
					"	ON DUPLICATE KEY UPDATE " . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		cart::EmptyProductCart($MyOrder['user_id'], 'temp', $MyOrder['site_id'], 0, 0);
		cart::EmptyBonusPointItemCart($MyOrder['user_id'], 'temp', $MyOrder['site_id'], 0, 0);

		$TotalPrice = 0;
		$TotalPriceCA = 0;
		$TotalBonusPoint = 0;
		$RedeemedCash = 0;
		$RedeemedCashCA = 0;
		$TotalBonusPointRequired = 0;

		// Insert all product to temp cart now!
		$MyOrderProduct = cart::GetMyOrderItemList($MyOrderID, 1, $TotalPrice, $TotalPriceCA, $TotalBonusPoint);
		foreach($MyOrderProduct as $P) {
			cart::AddProductToCart($P['product_id'], $P['quantity'], $MyOrder['user_id'], $P['product_option_id'], 'temp', $MyOrder['site_id'], 0, 0);
		}

		// Insert all bonus point item to temp cart now!
		$MyOrderBonusPointItem = cart::GetMyOrderBonusPointItemList($MyOrderID, 1, $RedeemedCash, $RedeemedCashCA, $TotalBonusPointRequired);
		foreach($MyOrderBonusPointItem as $I) {
			cart::AddBonusPointItemToCart($I['bonus_point_item_id'], $I['quantity'], $MyOrder['user_id'], 'temp', $MyOrder['site_id'], 0, 0);
		}
	}

	public static function ValidateCart($UserID, &$ErrorMsg, $CartType = 'normal' ) {
		global $API_ERROR;

		cart::FixCartTypeParameter($CartType);

		$User = user::GetUserInfo($UserID);
		$Site = site::GetSiteInfo($User['site_id']);

		if ($Site['site_module_inventory_enable'] == 'Y') {
			if ($Site['site_product_allow_under_stock'] == 'N')
				inventory::FixCartWithInventoryLevel($Site, $UserID);
		}			

		$TotalPrice = 0;
		$TotalPriceCA = 0;
		$TotalListedPrice = 0;
		$TotalListedPriceCA = 0;
		$TotalBonusPoint = 0;
		$TotalBonusPointRequired = 0;
		$RedeemedCashCA = 0;
		$RedeemedCash = 0;
		$ContinueProcessPostRule = true;
		$BonusPointCanBeUsed = 0;

		$Cart = cart::GetCartDetailsInfo($UserID, $CartType, $Site['site_id'], 0, 0);

		if ($Cart['bonus_point_item_id'] != 0) {
			$BonusPointItem = bonuspoint::GetBonusPointItemInfo($Cart['bonus_point_item_id'], 0);
			if ($BonusPointItem['site_id'] != $Site['site_id'] || $BonusPointItem['object_is_enable'] != 'Y') {
				$ErrorMsg = $API_ERROR['API_ERROR_INVALID_BONUS_POINT_ITEM_ID'];
				return false;
			}

			// Add this for backward compatibility
			cart::AddBonusPointItemToCart($Cart['bonus_point_item_id'], 1, $UserID, $CartType);
		}

		$Currency = currency::GetCurrencyInfo($Cart['currency_id'], $Site['site_id']);

		if ($Currency['site_id'] != $Site['site_id']) {
			$ErrorMsg = $API_ERROR['API_ERROR_INVALID_CURRENCY_ID'];
			return false;
		}

		$CartBonusPointItemList = cart::GetCartBonusPointItemList($UserID, $User['user_language_id'], $Currency, $RedeemedCash, $RedeemedCashCA, $TotalBonusPointRequired, $CartType, true, true, $Site['site_id'], 0, 0, $User['user_security_level']);

		if ($Site['site_use_bonus_point_at_once'] == 'N') {
			$BonusPointCanBeUsed = $User['user_bonus_point'];				
		}
		else {
			if ($Cart['bonus_point_earned_supplied_by_client'] >= 0)
				$TotalBonusPoint = $Cart['bonus_point_earned_supplied_by_client'];
			else {
				if ($CartType != 'bonus_point')
					$CartItemList = cart::GetCartItemList($UserID, $User['user_language_id'], $Currency, $TotalListedPrice, $TotalListedPriceCA, $TotalPrice, $TotalPriceCA, $TotalBonusPoint, $ContinueProcessPostRule, $CartType, true, true, $Site['site_id'], 0, 0, $User['user_security_level']);
			}

			$BonusPointCanBeUsed = $User['user_bonus_point'] + $TotalBonusPoint;
		}

		if ($TotalBonusPointRequired > $BonusPointCanBeUsed) {
			$ErrorMsg = $API_ERROR['API_ERROR_NOT_ENOUGH_BONUS_POINT'];
			return false;
		}

		if ($User['user_balance'] < $Cart['user_balance_use']) {
			$ErrorMsg = $API_ERROR['API_ERROR_NOT_ENOUGH_BALANCE'];
			return false;
		}

		return true;			
	}

	public static function CartConvertToOrder($UserID, $CartType = 'normal', $OrderConfirmed = 'Y', $OldOrderID = 0, &$NewOrderID) {
		$User = user::GetUserInfo($UserID);
		$Site = site::GetSiteInfo($User['site_id']);
		$OldOrder = cart::GetMyOrderInfo($OldOrderID);

		if ($OldOrderID != 0)
			inventory::UnholdStockForMyOrder($OldOrderID);

		if ($Site['site_module_inventory_enable'] == 'Y') {
			if ($Site['site_product_allow_under_stock'] == 'N')
				inventory::FixCartWithInventoryLevel($Site, $UserID);
		}

		$TotalPrice = 0;
		$TotalPriceCA = 0;
		$TotalListedPrice = 0;
		$TotalListedPriceCA = 0;
		$TotalBonusPoint = 0;
		$TotalBonusPointRequired = 0;
		$RedeemedCashCA = 0;
		$RedeemedCash = 0;
		$ContinueProcessPostRule = true;

		$Cart = cart::GetCartDetailsInfo($UserID, $CartType, $Site['site_id'], 0, 0);
		$Currency = currency::GetCurrencyInfo($Cart['currency_id'], $Site['site_id']);

		$CartItemList = array();
		if ($CartType != 'bonus_point')
			$CartItemList = cart::GetCartItemList($UserID, $User['user_language_id'], $Currency, $TotalListedPrice, $TotalListedPriceCA, $TotalPrice, $TotalPriceCA, $TotalBonusPoint, $ContinueProcessPostRule, $CartType, true, true, $Site['site_id'], 0, 0, $User['user_security_level']);

		$CartBonusPointItemList = cart::GetCartBonusPointItemList($UserID, $User['user_language_id'], $Currency, $RedeemedCash, $RedeemedCashCA, $TotalBonusPointRequired, $CartType, true, true, $Site['site_id'], 0, 0, $User['user_security_level']);

		if ($Cart['bonus_point_earned_supplied_by_client'] >= 0)
			$TotalBonusPoint = $Cart['bonus_point_earned_supplied_by_client'];

		$BonusPointCanBeUsed = 0;
		if ($Site['site_use_bonus_point_at_once'] == 'Y')
			$BonusPointCanBeUsed = $User['user_bonus_point'] + $TotalBonusPoint;
		else
			$BonusPointCanBeUsed = $User['user_bonus_point'];

		$PostprocessDiscount	= 0;
		$PostprocessDiscountCA	= 0;
		$PostDiscountRuleID		= 0;

		if ($CartType != 'bonus_point' && $ContinueProcessPostRule == true )
			cart::ApplyPostProcessRule($User['user_id'], $User['user_language_id'], $Currency, $TotalPrice, intval($User['user_security_level']), $PostprocessDiscount, $PostprocessDiscountCA, $PostDiscountRuleID, $CartType, true, true, $Site['site_id'], 0, 0, 'N');

		$PostprocessDiscountRule = discount::GetPostprocessRuleInfo($PostDiscountRuleID, 0);

		$EffectivePostprocessDiscountCode = '';
		if ($PostprocessDiscountRule != null)
			$EffectivePostprocessDiscountCode = trim($Cart['discount_code']);

		$CalculatedFreightCostCA = 0;
		if ($CartType != 'bonus_point') {
			cart::CartAdjustFreight($Cart, $Site, $Currency, $CalculatedFreightCostCA, $TotalListedPrice, $TotalListedPriceCA, $TotalPrice, $TotalPriceCA, $TotalCashValue, $TotalCashValueCA, $PostprocessDiscount, $PostprocessDiscountCA);
		}

		$PayAmountCA = $TotalPriceCA + $CalculatedFreightCostCA - doubleval($RedeemedCashCA) - doubleval($Cart['discount_amount_ca']) - $PostprocessDiscountCA;

		$PayAmountCA = $PayAmountCA - $Cart['user_balance_use'] * $Currency['currency_site_rate'];
		if ($PayAmountCA < 0)
			$PayAmountCA = 0;
		$UserBalanceAfter = $User['user_balance'] - $Cart['user_balance_use'];

		if ($OldOrderID != 0) {
			$OrderStatus = $OldOrder['order_status'];
			$OrderConfirmBy			= aveEscT($OldOrder['order_confirm_by']);
			$OrderConfirmDate		= "'" . aveEscT($OldOrder['order_confirm_date']) . "'";
			$OrderConfirmed			= aveEscT($OldOrder['order_confirmed']);
			$OrderCreateDate		= "'" . aveEscT($OldOrder['create_date']) . "'";
			$OrderCartType			= aveEscT($OldOrder['order_content_type']);
		}
		else {
			$OrderCreateDate	= 'NOW()';
			$OrderCartType		= $CartType;
			if ($OrderConfirmed == 'N') {
				$OrderStatus		= 'awaiting_freight_quote';
				$OrderConfirmBy		= 'null';
				$OrderConfirmDate	= 'null';
				$OrderConfirmed		= 'N';
			}
			else {
				$OrderStatus		= 'payment_pending';
				$OrderConfirmBy		= $User['user_username'];
				$OrderConfirmDate	= 'NOW()';
				$OrderConfirmed		= 'Y';
			}
		}

		$sql = cart::GetConvertToOrderCustomTextSQL('text', $Cart) . cart::GetConvertToOrderCustomTextSQL('int', $Cart) . cart::GetConvertToOrderCustomTextSQL('double', $Cart) . cart::GetConvertToOrderCustomTextSQL('date', $Cart);

		$query = '';
		if ($OldOrderID != 0)
			$query = "	UPDATE myorder ";
		else
			$query = " 	INSERT	INTO	myorder ";

		$query = $query . 
					"	SET		order_status								= '" . $OrderStatus . "', " .
					"			user_id										= '" . $UserID . "', " .
					"			site_id										= '" . $Site['site_id'] . "', " .
					"			bonus_point_item_id							= '" . intval($Cart['bonus_point_item_id']) . "', " .
					"			deliver_to_different_address				= '" . ynval($Cart['deliver_to_different_address']) . "', " .
					"			email_order_confirm							= '" . ynval($Cart['email_order_confirm']) . "', " .
					"			invoice_country_id							= '" . intval($Cart['invoice_country_id']) . "', " .
					"			invoice_country_other						= '" . aveEscT($Cart['invoice_country_other']) . "', " .
					"			invoice_hk_district_id						= '" . intval($Cart['invoice_hk_district_id']) . "', " .
					"			invoice_first_name							= '" . aveEscT($Cart['invoice_first_name']) . "', " .
					"			invoice_last_name							= '" . aveEscT($Cart['invoice_last_name']) . "', " .
					"			invoice_company_name						= '" . aveEscT($Cart['invoice_company_name']) . "', " .
					"			invoice_city_name							= '" . aveEscT($Cart['invoice_city_name']) . "', " .
					"			invoice_region								= '" . aveEscT($Cart['invoice_region']) . "', " .
					"			invoice_postcode							= '" . aveEscT($Cart['invoice_postcode']) . "', " .
					"			invoice_phone_no							= '" . aveEscT($Cart['invoice_phone_no']) . "', " .
					"			invoice_tel_country_code					= '" . aveEscT($Cart['invoice_tel_country_code']) . "', " .
					"			invoice_tel_area_code						= '" . aveEscT($Cart['invoice_tel_area_code']) . "', " .
					"			invoice_fax_country_code					= '" . aveEscT($Cart['invoice_fax_country_code']) . "', " .
					"			invoice_fax_area_code						= '" . aveEscT($Cart['invoice_fax_area_code']) . "', " .
					"			invoice_fax_no								= '" . aveEscT($Cart['invoice_fax_no']) . "', " .
					"			invoice_shipping_address_1					= '" . aveEscT($Cart['invoice_shipping_address_1']) . "', " .
					"			invoice_shipping_address_2					= '" . aveEscT($Cart['invoice_shipping_address_2']) . "', " .
					"			invoice_email								= '" . aveEscT($Cart['invoice_email']) . "', " .
					"			delivery_country_id							= '" . intval($Cart['delivery_country_id']) . "', " .
					"			delivery_country_other						= '" . aveEscT($Cart['delivery_country_other']) . "', " .
					"			delivery_hk_district_id						= '" . intval($Cart['delivery_hk_district_id']) . "', " .
					"			delivery_first_name							= '" . aveEscT($Cart['delivery_first_name']) . "', " .
					"			delivery_last_name							= '" . aveEscT($Cart['delivery_last_name']) . "', " .
					"			delivery_company_name						= '" . aveEscT($Cart['delivery_company_name']) . "', " .
					"			delivery_city_name							= '" . aveEscT($Cart['delivery_city_name']) . "', " .
					"			delivery_region								= '" . aveEscT($Cart['delivery_region']) . "', " .
					"			delivery_postcode							= '" . aveEscT($Cart['delivery_postcode']) . "', " .
					"			delivery_phone_no							= '" . aveEscT($Cart['delivery_phone_no']) . "', " .
					"			delivery_tel_country_code					= '" . aveEscT($Cart['delivery_tel_country_code']) . "', " .
					"			delivery_tel_area_code						= '" . aveEscT($Cart['delivery_tel_area_code']) . "', " .
					"			delivery_fax_no								= '" . aveEscT($Cart['delivery_fax_no']) . "', " .
					"			delivery_fax_country_code					= '" . aveEscT($Cart['delivery_fax_country_code']) . "', " .
					"			delivery_fax_area_code						= '" . aveEscT($Cart['delivery_fax_area_code']) . "', " .
					"			delivery_shipping_address_1					= '" . aveEscT($Cart['delivery_shipping_address_1']) . "', " .
					"			delivery_shipping_address_2					= '" . aveEscT($Cart['delivery_shipping_address_2']) . "', " .
					"			delivery_email								= '" . aveEscT($Cart['delivery_email']) . "', " .
					"			delivery_date								= null, " .
					"			user_message								= '" . aveEscT($Cart['user_message']) . "', " .
					"			bonus_point_earned_supplied_by_client		= '" . intval($Cart['bonus_point_earned_supplied_by_client']) . "', " .
					"			bonus_point_previous						= '" . intval($User['user_bonus_point']) . "', " .
					"			bonus_point_earned							= '" . intval($TotalBonusPoint) . "', " .
					"			bonus_point_canbeused						= '" . intval($BonusPointCanBeUsed) . "', " .
					"			bonus_point_redeemed						= '" . intval($TotalBonusPointRequired) . "', " .
					"			bonus_point_balance							= '" . intval($User['user_bonus_point'] + $TotalBonusPoint - $TotalBonusPointRequired)  . "', " .
					"			bonus_point_redeemed_cash					= '" . doubleval($RedeemedCash) . "', " .
					"			bonus_point_redeemed_cash_ca				= '" . doubleval($RedeemedCashCA) . "', " .
					"			payment_confirmed							= 'N', " .
					"			order_confirmed								= '" . aveEscT($OrderConfirmed) . "', " .
					"			currency_id									= '" . intval($Cart['currency_id']) . "', " .
					"			currency_site_rate_atm						= '" . $Currency['currency_site_rate'] . "', " .
					"			user_balance_previous						= '" . doubleval($User['user_balance']) . "', " .
					"			user_balance_used							= '" . doubleval($Cart['user_balance_use']) . "', " .
					"			user_balance_used_ca						= '" . doubleval($Cart['user_balance_use'] * $Currency['currency_site_rate']) . "', " .
					"			user_balance_after							= '" . doubleval($UserBalanceAfter) . "', " .
					"			effective_base_price_id						= '" . intval($Cart['effective_base_price_id']) . "', " .
					"			total_price									= '" . doubleval($TotalPrice) . "', " .
					"			total_price_ca								= '" . doubleval($TotalPriceCA) . "', " .
					"			discount_amount_ca							= '" . doubleval($Cart['discount_amount_ca']) . "', " .
					"			effective_discount_postprocess_rule_id		= '" . $PostDiscountRuleID . "', " .
					"			effective_discount_postprocess_rule_discount_code		= '" . aveEscT($EffectivePostprocessDiscountCode) . "', " .
					"			postprocess_rule_discount_amount			= '" . doubleval($PostprocessDiscount) . "', " .
					"			postprocess_rule_discount_amount_ca			= '" . doubleval($PostprocessDiscountCA) . "', " .
					"			continue_process_postprocess_discount_rule	= '" . ynval($ContinueProcessPostRule) . "', " .
					"			freight_cost_ca								= '" . doubleval($CalculatedFreightCostCA) . "', " .
					"			pay_amount_ca								= '" . doubleval($PayAmountCA) . "', " .
					"			payment_confirm_by							= null, " .
					"			payment_confirm_date						= null, " .
					"			order_confirm_by							= '" . aveEscT($OrderConfirmBy) . "', " .
					"			order_confirm_date							= " . aveEscT($OrderConfirmDate) . ", " .
					"			create_date									= " . aveEscT($OrderCreateDate) . ", " .
					"			reference_1									= '', " .
					"			reference_2									= '', " .
					"			reference_3									= '', " .
					"			is_handled									= 'N', " . $sql .
					"			user_reference								= '', " .
					"			order_content_type							= '" . aveEscT($OrderCartType) . "', " .
					"			self_take									= '" . ynval($Cart['self_take']) . "' ";
		if ($OldOrderID != 0)
			$query = $query . "	WHERE myorder_id = '" . intval($OldOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($OldOrderID == 0)
			$NewOrderID = customdb::mysqli()->insert_id;
		else
			$NewOrderID = $OldOrderID;

		if ($OldOrderID != 0) {
			$query  =	" 	DELETE FROM	myorder_product " .
						"	WHERE		myorder_id = '" . intval($OldOrderID) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query  =	" 	DELETE FROM	myorder_bonus_point_item " .
						"	WHERE		myorder_id = '" . intval($OldOrderID) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		if ($CartType != 'bonus_point') {
			foreach($CartItemList as $C) {
				$query  =	" 	INSERT INTO	myorder_product " .
							"	SET		myorder_id								= '" . intval($NewOrderID) . "', " .
							"			product_id								= '" . intval($C['product_id']) . "', " .
							"			currency_id								= '" . intval($Cart['currency_id']) . "', " .
							"			product_base_price						= '" . doubleval($C['product_base_price']) . "', " .
							"			product_base_price_ca					= '" . doubleval($C['product_base_price_ca']) . "', " .
							"			product_price							= '" . doubleval($C['product_price']) . "', " .
							"			product_price_ca						= '" . doubleval($C['product_price_ca']) . "', " .
							"			product_price2							= '" . doubleval($C['product_price2']) . "', " .
							"			product_price2_ca						= '" . doubleval($C['product_price2_ca']) . "', " .
							"			product_price3							= '" . doubleval($C['product_price3']) . "', " .
							"			product_price3_ca						= '" . doubleval($C['product_price3_ca']) . "', " .
							"			product_bonus_point_amount				= '" . intval($C['product_bonus_point_amount']) . "', " .
							"			actual_subtotal_price					= '" . doubleval($C['actual_subtotal_price']) . "', " .
							"			actual_subtotal_price_ca				= '" . doubleval($C['actual_subtotal_price_ca']) . "', " .
							"			actual_unit_price						= '" . doubleval($C['actual_unit_price']) . "', " .
							"			actual_unit_price_ca					= '" . doubleval($C['actual_unit_price_ca']) . "', " .
							"			quantity								= '" . intval($C['quantity']) . "', " .
							"			effective_discount_type					= '" . intval($C['effective_discount_type']) . "', " .
							"			effective_discount_preprocess_rule_id	= '" . intval($C['effective_discount_preprocess_rule_id']) . "', " .
							"			discount1_off_p							= '" . intval($C['discount1_off_p']) . "', " .
							"			discount2_amount						= '" . intval($C['discount2_amount']) . "', " .
							"			discount2_price							= '" . doubleval($C['discount2_price']) . "', " .
							"			discount2_price_ca						= '" . doubleval($C['discount2_price_ca']) . "', " .
							"			discount3_buy_amount					= '" . intval($C['discount3_buy_amount']) . "', " .
							"			discount3_free_amount					= '" . intval($C['discount3_free_amount']) . "', " .
							"			product_option_id						= '" . intval($C['product_option_id']) . "' ";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
		}

		foreach($CartBonusPointItemList as $C) {
			$query  =	" 	INSERT INTO	myorder_bonus_point_item " .
						"	SET		myorder_id						= '" . $NewOrderID . "', " .
						"			bonus_point_item_id				= '" . intval($C['bonus_point_item_id']) . "', " .
						"			currency_id						= '" . intval($Cart['currency_id']) . "', " .
						"			quantity						= '" . intval($C['quantity']) . "', " .
						"			bonus_point_required			= '" . intval($C['bonus_point_required']) . "', " .
						"			cash							= '" . doubleval($C['cash']) . "', " .
						"			cash_ca							= '" . doubleval($C['cash_ca']) . "', " .
						"			subtotal_cash					= '" . doubleval($C['subtotal_cash']) . "', " .
						"			subtotal_cash_ca				= '" . doubleval($C['subtotal_cash_ca']) . "', " .
						"			subtotal_bonus_point_required	= '" . intval($C['subtotal_bonus_point_required']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		if ($OldOrderID == 0)
			cart::UpdateOrderNo($NewOrderID, $Site['site_id'], $CartType);

		$query  =	" 	DELETE	FROM	cart_content " .
					"	WHERE	user_id			= '" . intval($UserID) . "' " .
					"		AND	cart_content_type	= '" . aveEscT($CartType) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query  =	" 	DELETE	FROM	cart_bonus_point_item " .
					"	WHERE	user_id				= '" . intval($UserID) . "' " .
					"		AND	cart_content_type	= '" . aveEscT($CartType) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query  =	" 	DELETE	FROM	cart_details " .
					"	WHERE	user_id				= '" . intval($UserID) . "' " .
					"		AND	cart_content_type	= '" . aveEscT($CartType) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($CartType != 'temp')
			cart::TouchCart($UserID, $Site['site_id'], $CartType);

		if ($CartType != 'bonus_point') {
			if ($Site['site_module_inventory_enable'] == 'Y' && $OrderStatus == 'payment_pending') {
				if ($Site['site_auto_hold_stock_status'] == 'payment_pending') {
					inventory::HoldStockForMyOrder($Site['site_id'], $NewOrderID);
					site::EmptyAPICache($Site['site_id']);
				}
			}
		}
	}

	public static function GetMyOrderInfo($MyOrderID) {
		$query =	"	SELECT		* " .
					"	FROM		myorder	M 	JOIN currency C ON (C.currency_id = M.currency_id) " .
					"	WHERE		M.myorder_id = '" . intval($MyOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			$myResult['order_can_delete'] = cart::IsMyOrderDeletable($myResult['order_status']);
			$myResult['order_can_void'] = cart::IsMyOrderVoidable($myResult['order_status']);
			return $myResult;
		}
		else
			return null;
	}

	public static function IsMyOrderDeletable($OrderStatus) {
		$DeletableStatus = array('awaiting_freight_quote', 'awaiting_order_confirmation', 'order_cancelled', 'payment_pending');
		if (in_array($OrderStatus , $DeletableStatus))
			return 'Y';
		else
			return 'N';
	} 
	public static function IsMyOrderVoidable($OrderStatus) {
		$VoidableStatus = array('payment_confirmed', 'partial_shipped', 'shipped', 'payment_pending');
		if (in_array($OrderStatus , $VoidableStatus))
			return 'Y';
		else
			return 'N';
	} 

	public static function GetMyOrderXML($MyOrderID, $LanguageID, $IncludeProductDetails = 'N') {
		$smarty = new mySmarty();

		$MyOrder = cart::GetMyOrderInfo($MyOrderID);

		$Site = site::GetSiteInfo($MyOrder['site_id']);

		$MyOrderProductsXML = '';
		$MyOrderBonusPointItemsXML = '';
		$TotalPrice = 0;
		$TotalPriceCA = 0;
		$TotalCash = 0;
		$TotalCashCA = 0;
		$TotalBonusPoint = 0;
		$TotalBonusPointRequired = 0;

		$MyOrderItemList = cart::GetMyOrderItemList($MyOrderID, $LanguageID, $TotalPrice, $TotalPriceCA, $TotalBonusPoint);
		foreach ($MyOrderItemList as $O) {
			if ($IncludeProductDetails == 'Y') {
				$TotalNoOfMedia = 0;

				$MediaListXML = media::GetMediaListXML($O['product_id'], $LanguageID, $TotalNoOfMedia, 1, NUM_OF_PHOTOS_PER_PAGE);
				$smarty->assign('MediaListXML', $MediaListXML);
				$smarty->assign('TotalNoOfMedia', $TotalNoOfMedia);
				$smarty->assign('MediaPageNo', 1);
			}

			$O['object_seo_url'] = object::GetSeoURL($O, '', $LanguageID, $Site);
			$smarty->assign('Object', $O);

			$MyOrderProductsXML .= $smarty->fetch('api/object_info/MYORDER_PRODUCT.tpl');
		}
		$smarty->assign('MyOrderProductsXML', $MyOrderProductsXML);

		$MyOrderBonusPointItemList = cart::GetMyOrderBonusPointItemList($MyOrderID, $LanguageID, $TotalCash, $TotalCashCA, $TotalBonusPointRequired);
		foreach ($MyOrderBonusPointItemList as $O) {
			$O['object_seo_url'] = object::GetSeoURL($O, '', $LanguageID, $Site);
			$smarty->assign('Object', $O);
			$MyOrderBonusPointItemsXML .= $smarty->fetch('api/object_info/MYORDER_BONUS_POINT_ITEM.tpl');
		}
		$smarty->assign('MyOrderBonusPointItemsXML', $MyOrderBonusPointItemsXML);

		$smarty->assign('Object', $MyOrder);
		$MyOrderXML = $smarty->fetch('api/object_info/MYORDER.tpl');

		return $MyOrderXML;
	}

	public static function GetMyOrderListXML($UserID, $Offset = 0, $RowCount = 20, $CartContentType = 'normal') {
		$smarty = new mySmarty();
		$NoOfOrders = cart::GetNoOfOrdersByUserID($UserID, $CartContentType);
		$smarty->assign('NoOfOrders', $NoOfOrders);

		$MyOrderList = cart::GetMyOrderListByUserID($UserID, 'ALL', $Offset, $RowCount, $CartContentType);
		$MyOrderListXML = '';
		foreach ($MyOrderList as $M) {
			$smarty->assign('Object', $M);
			$MyOrderListXML = $MyOrderListXML . $smarty->fetch('api/object_info/MYORDER.tpl');
		}
		return "<total_no_of_orders>" . $NoOfOrders . "</total_no_of_orders><myorder_list>" . $MyOrderListXML . "</myorder_list>";

	}

	public static function DeleteOrder($MyOrderID) {
		inventory::UnholdStockForMyOrder($MyOrderID);

		$query =	"	DELETE FROM	myorder " .
					"	WHERE		myorder_id = '" . intval($MyOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	myorder_product " .
					"	WHERE		myorder_id = '" . intval($MyOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	myorder_bonus_point_item " .
					"	WHERE		myorder_id = '" . intval($MyOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function UpdateNextSerial($SiteID) {
		$query	=	"	LOCK TABLES site WRITE, errorlog WRITE ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query  =	" 	SELECT	* " .
					"	FROM	site " .
					"	WHERE	site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$Site = $result->fetch_assoc();

		if (cart::ShouldResetSerialNo($Site['site_order_serial_reset_type'], $Site['site_order_serial_next_reset_date'])) {
			$NextResetDate = cart::GenerateNextResetDate($Site['site_order_serial_reset_type'], $Site['site_order_serial_next_reset_date']);
			$query  =	" 	UPDATE	site " .
						"	SET		site_order_serial_next_reset_date = '" . aveEscT($NextResetDate) . "', " .
						"			site_next_order_serial = 1 " .
						"	WHERE	site_id = '" . intval($SiteID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		if (cart::ShouldResetSerialNo($Site['site_redeem_serial_reset_type'], $Site['site_redeem_serial_next_reset_date'])) {
			$NextResetDate = cart::GenerateNextResetDate($Site['site_redeem_serial_reset_type'], $Site['site_redeem_serial_next_reset_date']);

			$query  =	" 	UPDATE	site " .
						"	SET		site_redeem_serial_next_reset_date = '" . aveEscT($NextResetDate) . "', " .
						"			site_next_redeem_serial = 1 " .
						"	WHERE	site_id = '" . intval($SiteID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		$query	=	"	UNLOCK TABLES ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

//		public static function UpdateOrderNo($MyOrderID, $SiteID, $IgnoreProducts = 'N', $IgnoreBonusPointItems = 'N') {
	public static function UpdateOrderNo($MyOrderID, $SiteID, $CartContentType = 'normal') {

		cart::UpdateNextSerial($SiteID);

		// Update order_no
		$query	=	"	LOCK TABLES site WRITE, myorder WRITE, errorlog WRITE ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query  =	" 	SELECT	* " .
					"	FROM	site " .
					"	WHERE	site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result->fetch_assoc();

		$OrderSerial = $myResult['site_next_order_serial'];
		$RedeemSerial = $myResult['site_next_redeem_serial'];			

		if ($CartContentType == 'normal') {
			$OrderNo = cart::GetNextFormatNo($myResult['site_order_no_format'], $OrderSerial);

			$query  =	" 	UPDATE	myorder " .
						"	SET		order_no = '" . aveEscT($OrderNo) . "'" .
						"	WHERE	myorder_id = '" . intval($MyOrderID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query  =	" 	UPDATE	site " .
						"	SET		site_next_order_serial = '" . ++$OrderSerial . "'" .
						"	WHERE	site_id = '" . intval($SiteID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		elseif ($CartContentType == 'bonus_point') {
			$RedeemNo = cart::GetNextFormatNo($myResult['site_redeem_no_format'], $RedeemSerial);

			$query  =	" 	UPDATE	myorder " .
						"	SET		order_no = '" . aveEscT($RedeemNo) . "'" .
						"	WHERE	myorder_id = '" . intval($MyOrderID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query  =	" 	UPDATE	site " .
						"	SET		site_next_redeem_serial = '" . ++$RedeemSerial . "'" .
						"	WHERE	site_id = '" . intval($SiteID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		$query	=	"	UNLOCK TABLES ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetNextFormatNo($FormatText = "{SN0}", $NextNo = 1, $TimestampNow = NULL) {
		if ($TimestampNow == NULL)
			$TimestampNow = time();

		$FormatText = str_replace("{SN0}", $NextNo, $FormatText);
		$FormatText = str_replace("{SN1}", str_pad($NextNo, 1, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN2}", str_pad($NextNo, 2, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN3}", str_pad($NextNo, 3, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN4}", str_pad($NextNo, 4, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN5}", str_pad($NextNo, 5, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN6}", str_pad($NextNo, 6, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN7}", str_pad($NextNo, 7, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN8}", str_pad($NextNo, 8, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN9}", str_pad($NextNo, 9, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN10}", str_pad($NextNo, 10, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{Y}", date('Y', $TimestampNow), $FormatText);
		$FormatText = str_replace("{y}", date('y', $TimestampNow), $FormatText);
		$FormatText = str_replace("{n}", date('n', $TimestampNow), $FormatText);
		$FormatText = str_replace("{m}", date('m', $TimestampNow), $FormatText);
		$FormatText = str_replace("{d}", date('d', $TimestampNow), $FormatText);
		$FormatText = str_replace("{j}", date('j', $TimestampNow), $FormatText);

		return $FormatText;
	}

	public static function GenerateNextResetDate($SiteSerialResetType, $LastResetDate = '', $TimestampNow = NULL) {
		if ($TimestampNow == NULL)
			$TimestampNow = time();

		if ($SiteSerialResetType == 'no_reset')
			return '0000-00-00';
		else if ($SiteSerialResetType == 'monthly') {
			$Year = date("Y", $TimestampNow);
			$Month = date("m", $TimestampNow);				
			$NextMonthTS = mktime(0, 0, 0, $Month + 1, 1, $Year);

			return date("Y-m-d", $NextMonthTS);
		}
		else if ($SiteSerialResetType == 'yearly') {
			$Year = date("Y", $TimestampNow);
			$NextYearTS = mktime(0, 0, 0, 1, 1, $Year + 1);
			return date("Y-m-d", $NextYearTS);
		}
		else if ($SiteSerialResetType == 'absolute_year') {
			if ($LastResetDate == '0000-00-00')
				$LastResetDate = '1980-01-01';

			$Year = date("Y", $TimestampNow);
			$Month = date("m", strtotime($LastResetDate));
			$Day = date("d", strtotime($LastResetDate));

			if ($Month == 2 && $Day == 29)
				$Day = 28;

			$NextYearTS = mktime(0, 0, 0, $Month, $Day, $Year + 1);
			return date("Y-m-d", $NextYearTS);
		}			
	}

	public static function ShouldResetSerialNo($SiteSerialResetType, $SiteNextResetDate, $TimestampNow = NULL) {
		if ($SiteSerialResetType == 'no_reset')
			return false;

		if ($TimestampNow == NULL)
			$TimestampNow = time();

		$NextResetTS = strtotime($SiteNextResetDate);

		if ($TimestampNow > $NextResetTS)
			return true;
	}

	public static function UpdateOrderNoEX($MyOrderID, $SiteID, $CartContentType = 'normal') {
		// Update order_no
		$query	=	"	LOCK TABLES site WRITE, myorder WRITE, errorlog WRITE ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query  =	" 	SELECT	* " .
					"	FROM	site " .
					"	WHERE	site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result->fetch_assoc();

		$OrderNo = $myResult['site_next_order_no'];
		$RedeemNo = $myResult['site_next_redeem_no'];

		if (intval($myResult['site_next_order_no']) <= 0) {
			$query  =	" 	SELECT	max(order_no) as max_order_no " .
						"	FROM	myorder " .
						"	WHERE	site_id = '" . intval($SiteID) . "'" .
						"		AND	order_content_type = 'normal' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			$myResult = $result->fetch_assoc();

			$OrderNo = intval($myResult['max_order_no']) + 1;
		}
		if (intval($myResult['site_next_redeem_no']) <= 0) {
			$query  =	" 	SELECT	max(order_no) as max_order_no " .
						"	FROM	myorder " .
						"	WHERE	site_id = '" . intval($SiteID) . "'" .
						"		AND	order_content_type = 'bonus_point' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			$myResult = $result->fetch_assoc();

			$RedeemNo = intval($myResult['max_order_no']) + 1;
		}

		if ($CartContentType == 'normal') {
			$query  =	" 	UPDATE	myorder " .
						"	SET		order_no = '" . aveEscT($OrderNo) . "'" .
						"	WHERE	myorder_id = '" . intval($MyOrderID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query  =	" 	UPDATE	site " .
						"	SET		site_next_order_no = '" . ++$OrderNo . "'" .
						"	WHERE	site_id = '" . intval($SiteID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		elseif ($CartContentType == 'bonus_point') {
			$query  =	" 	UPDATE	myorder " .
						"	SET		order_no = '" . $RedeemNo . "'" .
						"	WHERE	myorder_id = '" . intval($MyOrderID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query  =	" 	UPDATE	site " .
						"	SET		site_next_redeem_no = '" . ++$RedeemNo . "'" .
						"	WHERE	site_id = '" . intval($SiteID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		$query	=	"	UNLOCK TABLES ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	}

	public static function GetMyOrderListByProductID($ProductID, &$TotalOrders, $PageNo = 1, $OrdersPerPage = 20) {
		$Offset = intval(($PageNo -1) * $OrdersPerPage);

		$query =	"	SELECT		SQL_CALC_FOUND_ROWS * " .
					"	FROM		myorder O	JOIN	user U				ON (O.user_id = U.user_id) " .
					"							JOIN	currency C			ON (C.currency_id = O.currency_id) " .
					"	WHERE		O.myorder_id IN (
														SELECT	myorder_id " .
					"									FROM	myorder_product " .
					"									WHERE	product_id = '" . intval($ProductID) . "'" .
					"								)" .
					"	ORDER BY	O.myorder_id DESC " .
					"	LIMIT	" . $Offset . ", " . intval($OrdersPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);		
		$myResult = $result2->fetch_row();
		$TotalOrders = $myResult[0];

		$MyOrderList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($MyOrderList, $myResult);
		}
		return $MyOrderList;
	}

	public static function GetMyOrderItemListByProductID($ProductID) {
		$query =	"	SELECT		* " .
					"	FROM		myorder O	JOIN	user U				ON	(O.user_id = U.user_id) " .
					"							JOIN	currency C			ON	(C.currency_id = O.currency_id) " .
					"							JOIN	myorder_product	MP	ON	(MP.myorder_id = O.myorder_id) " .
					"							JOIN	product P			ON	(MP.product_id = P.product_id) " .
					"							JOIN	object	OBJ			ON	(P.product_id = OBJ.object_id) " .
					"							JOIN	object_link L		ON	(OBJ.object_id = L.object_id AND OL.object_link_is_shadow = 'N') " .
					"	WHERE		P.product_id = '" . intval($ProductID) . "'" .
					"			AND	O.payment_confirmed = 'Y' " .
					"	ORDER BY	O.create_date DESC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductMyOrderItemList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ProductMyOrderItemList, $myResult);
		}
		return $ProductMyOrderItemList;
	}

	public static function GetUserMyOrderItemList($UserID, &$TotalItems, $PageNo = 1, $ItemsPerPage = 20) {
		$Offset = intval(($PageNo -1) * $ItemsPerPage);

		$query =	"	SELECT		SQL_CALC_FOUND_ROWS * " .
					"	FROM		myorder O	JOIN	user U				ON	(O.user_id = U.user_id) " .
					"							JOIN	currency C			ON	(C.currency_id = O.currency_id) " .
					"							JOIN	myorder_product	MP	ON	(MP.myorder_id = O.myorder_id) " .
					"							JOIN	product P			ON	(MP.product_id = P.product_id) " .
					"							JOIN	object	OBJ			ON	(P.product_id = OBJ.object_id) " .
					"							JOIN	object_link OL		ON	(OBJ.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"	WHERE		O.user_id = '" . intval($UserID) . "'" .
					"	ORDER BY	O.create_date DESC " .
					"	LIMIT	" . $Offset . ", " . intval($ItemsPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalItems = $myResult[0];

		$UserMyOrderItemList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($UserMyOrderItemList, $myResult);
		}
		return $UserMyOrderItemList;
	}

	public static function GetUserMyOrderItemListXML($UserID, $PageNo = 1, $ItemsPerPage = 20) {
		$smarty = new mySmarty();

		$User = user::GetUserInfo($UserID);
		$Site = site::GetSiteInfo($User['site_id']);

		$NoOfOrderItems = 0;

		$UserMyOrderItemList = cart::GetUserMyOrderItemList($UserID, $NoOfOrderItems, $PageNo, $ItemsPerPage);

		$smarty->assign('NoOfOrderItems', $NoOfOrderItems);

		$UserMyOrderItemListXML = '';
		foreach ($UserMyOrderItemList as $M) {
			$M['object_seo_url'] = object::GetSeoURL($M, '', $Site['site_default_language_id'], $Site);
			$smarty->assign('Object', $M);
			$UserMyOrderItemListXML = $UserMyOrderItemListXML . $smarty->fetch('api/object_info/MYORDER_PRODUCT_WITH_MYORDER_DETAILS.tpl');
		}
		return "<total_no_of_order_items>" . $NoOfOrderItems . "</total_no_of_order_items><myorder_item_list>" . $UserMyOrderItemListXML . "</myorder_item_list>";

	}

	public static function UpdateMyOrderProductQuantitySold($MyOrderID) {
		$query =	"	SELECT		* " .
					"	FROM		myorder_product " .
					"	WHERE		myorder_id = '" . intval($MyOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			product::UpdateProductQuantitySold($myResult['product_id'], $myResult['product_option_id']);
		}
	}

	public static function TouchCart($UserID, $SiteID, $CartContentType = 'normal') {
		$User = user::GetUserInfo($UserID);
		$Site = site::GetSiteInfo($SiteID);

		$query  =	" 	INSERT	INTO	cart_details " .
					"	SET		user_id				= '" . intval($UserID) . "', " .
					"			system_admin_id		= 0, " .
					"			content_admin_id	= 0, " .
					"			site_id				= '" . intval($SiteID) . "', " .
					"			cart_content_type	= '" . aveEscT($CartContentType) . "', " .
					"			deliver_to_different_address	= 'N', " .
					"			self_take			= 'N', " .
					"			update_user_address	= 'Y', " .
					"			email_order_confirm	= 'Y', " .
					"			join_mailing_list	= 'Y', " .
					"			currency_id					= '" . intval($User['user_currency_id']) . "', " .
					"			invoice_country_id			= '" . intval($User['user_country_id']) . "', " .
					"			invoice_country_other		= '" . aveEscT($User['user_country_other']) . "', " .
					"			invoice_hk_district_id		= '" . intval($User['user_hk_district_id']) . "', " .
					"			invoice_first_name			= '" . aveEscT($User['user_first_name']) . "', " .
					"			invoice_last_name			= '" . aveEscT($User['user_last_name']) . "', " .
					"			invoice_company_name		= '" . aveEscT($User['user_company_name']) . "', " .
					"			invoice_city_name			= '" . aveEscT($User['user_city_name']) . "', " .
					"			invoice_region				= '" . aveEscT($User['user_region']) . "', " .
					"			invoice_postcode			= '" . aveEscT($User['user_postcode']) . "', " .
					"			invoice_phone_no			= '" . aveEscT($User['user_tel_no']) . "', " .
					"			invoice_tel_country_code	= '" . aveEscT($User['user_tel_country_code']) . "', " .
					"			invoice_tel_area_code		= '" . aveEscT($User['user_tel_area_code']) . "', " .
					"			invoice_fax_country_code	= '" . aveEscT($User['user_fax_country_code']) . "', " .
					"			invoice_fax_area_code		= '" . aveEscT($User['user_fax_area_code']) . "', " .
					"			invoice_fax_no				= '" . aveEscT($User['user_fax_no']) . "', " .
					"			invoice_shipping_address_1	= '" . aveEscT($User['user_address_1']) . "', " .
					"			invoice_shipping_address_2	= '" . aveEscT($User['user_address_2']) . "', " .
					"			invoice_email				= '" . aveEscT($User['user_email']) . "' " .
					"	ON DUPLICATE KEY UPDATE user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}