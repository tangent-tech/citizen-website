<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class currency {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetCurrencyByPaydollar($PayDollarCurrencyID) {
		$query =	"	SELECT	* " .
					"	FROM	currency " .
					"	WHERE	currency_paydollar_currCode  = '" . intval($PayDollarCurrencyID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result->fetch_assoc();
		return $myResult;
	}

	public static function GetAllCurrencyList() {
		$query =	"	SELECT	* " .
					"	FROM 	currency " .
					"	ORDER BY currency_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$Currency = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($Currency, $myResult);
		}
		return $Currency;
	}

	public static function GetAllCurrencyOption() {
		$query =	"	SELECT	* " .
					"	FROM 	currency " .
					"	ORDER BY currency_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$Currency = array();
		while ($myResult = $result->fetch_assoc()) {
			$Currency[$myResult['currency_id']] = $myResult['currency_shortname'];
		}
		return $Currency;
	}

	public static function GetCurrencyInfo($CurrencyID, $SiteID) {
		$query =	"	SELECT	*, C.* " .
					"	FROM	currency C LEFT JOIN currency_site_enable S ON (C.currency_id = S.currency_id AND S.site_id = '" . intval($SiteID) . "') " .
					"	WHERE	C.currency_id  = '" . intval($CurrencyID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetAllSiteCurrencyList($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	currency C JOIN currency_site_enable S ON (C.currency_id = S.currency_id) " .
					"	WHERE	S.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$SiteCurrencyList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($SiteCurrencyList, $myResult);
		}
		return $SiteCurrencyList;
	}

	public static function GetAllSiteCurrencyList_NotEnabled($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM 	currency C " .
					"	WHERE	C.currency_id NOT IN ( " .
					"		SELECT 	S.currency_id " .
					"		FROM 	currency_site_enable S " .
					"		WHERE	S.site_id = '" . intval($SiteID) . "'" .
					"	)" .
					"	ORDER BY C.currency_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$SiteCurrencyList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($SiteCurrencyList, $myResult);
		}
		return $SiteCurrencyList;
	}

	public static function IsValidCurrencyID($CurrencyID) {
		$query =	"	SELECT	* " .
					"	FROM	currency " .
					"	WHERE	currency_id  = '" . intval($CurrencyID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		return ($result->num_rows > 0);
	}

	public static function IsCurrencyRemovable($CurrencyID, $SiteID) {
		$TheSite = site::GetSiteInfo($SiteID);
		if ($TheSite['site_default_currency_id'] == $CurrencyID)
			return false;

		$query =	"	SELECT	* " .
					"	FROM	currency_site_enable " .
					"	WHERE	currency_id  != '" . intval($CurrencyID) . "'" .
					"		AND	site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		return ($result->num_rows > 0);
	}

	public static function GetCurrencyXML($CurrencyID, $SiteID) {
		$smarty = new mySmarty();
		
		$Currency = currency::GetCurrencyInfo($CurrencyID, $SiteID);
		if ($Currency != null) {
			$smarty->assign('Object', $Currency);
			$CurrencyXML = $smarty->fetch('api/object_info/CURRENCY.tpl');
			return $CurrencyXML;
		}
		else
			return '';
	}

	public static function GetAllSiteCurrencyListXML($SiteID) {
		$smarty = new mySmarty();
		
		$AllSiteCurrencyList = currency::GetAllSiteCurrencyList($SiteID);
		$SiteCurrencyListXML = '';
		foreach ($AllSiteCurrencyList as $C) {
			$smarty->assign('Object', $C);
			$SiteCurrencyListXML = $SiteCurrencyListXML . $smarty->fetch('api/object_info/CURRENCY.tpl');
		}
		return "<SiteCurrencyList>" . $SiteCurrencyListXML . "</SiteCurrencyList>";
	}

	public static function RemoveSiteCurrency($CurrencyID, $SiteID) {
		$query	=	"	DELETE FROM	currency_site_enable " .
					"	WHERE	currency_id = '" . intval($CurrencyID) . "'" .
					"		AND	site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}