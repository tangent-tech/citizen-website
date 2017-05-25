<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE
if (!defined('IN_CMS'))
	die("huh?");

class country{
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetCountryList($LangID = 1) {

		$CountrySuffix = 'en';
		$sql = '';

		if ($LangID == 1) {
			$CountrySuffix = 'en';
			$sql = "	ORDER BY	country_name_en ASC ";
		}
		elseif ($LangID == 2) {
			$CountrySuffix = 'tc';
			$sql = "	ORDER BY	country_name_en ASC ";
		}
		elseif ($LangID == 3) {
			$CountrySuffix = 'sc';
			$sql = "	ORDER BY	country_name_en ASC ";
		}
		elseif ($LangID == 4) {
			$CountrySuffix = 'jp';
			$sql = "	ORDER BY	country_code ASC ";
		}
		elseif ($LangID == 5) {
			$CountrySuffix = 'kr';
			$sql = "	ORDER BY	country_code ASC ";
		}
		else {
			$CountrySuffix = 'en';
			$sql = "	ORDER BY	country_name_en ASC ";
		}

		$query  =	" 	SELECT * " .
					"	FROM	country " . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Country = array();

		while ($myResult = $result->fetch_assoc())
			array_push($Country, $myResult);

		return $Country;

	}

	public static function GetCountryInfo($CountryID) {
		$query  =	" 	SELECT * " .
					"	FROM	country " .
					"	WHERE	country_id = '" . intval($CountryID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetCountryListXML($LangID, $ShowOtherCountry = false) {
		$smarty = new mySmarty();
		
		$CountryList = country::GetCountryList($LangID);
		$CountryXML = '';
		foreach ($CountryList as $C) {

			if (!$ShowOtherCountry && $C['country_id'] == COUNTRY_ID_OTHER)
				continue;

			$smarty->assign('Object', $C);
			$CountryXML = $CountryXML . $smarty->fetch('api/object_info/COUNTRY.tpl');
		}
		return '<country_list>' . $CountryXML . '</country_list>';
	}

	public static function GetHongKongDistrictList() {
		$query  =	" 	SELECT		* " .
					"	FROM		hk_district " .
					"	ORDER BY	hk_district_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$HongKongDistrictList = array();

		while ($myResult = $result->fetch_assoc())
			array_push($HongKongDistrictList, $myResult);

		return $HongKongDistrictList;
	}

	public static function GetHongKongDistrictListXML() {
		$smarty = new mySmarty();
		
		$HongKongDistrictList = country::GetHongKongDistrictList();
		$HKDistrictXML = '';
		foreach ($HongKongDistrictList as $D) {
			$smarty->assign('Object', $D);
			$HKDistrictXML = $HKDistrictXML . $smarty->fetch('api/object_info/HK_DISTRICT.tpl');
		}
		return '<hk_district_list>' . $HKDistrictXML . '</hk_district_list>';
	}

	public static function GetHongKongDistrictInfo($DistrictID) {
		$query  =	" 	SELECT	* " .
					"	FROM	hk_district " .
					"	WHERE	hk_district_id = '" . intval($DistrictID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}
}