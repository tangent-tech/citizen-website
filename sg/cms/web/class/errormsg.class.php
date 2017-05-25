<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class errormsg {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetAllErrorMsg($SiteID, $LangID) {
		$query =	"	SELECT	* " .
					"	FROM	api_error_msg " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'" . 
					"		AND	language_id = '" . intval($LangID) . "'" . 
					"	ORDER BY api_error_no ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ErrorList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ErrorList, $myResult);
		}
		return $ErrorList;
	}

	public static function EmptyAllErrorMsg($SiteID, $LangID) {
		$query =	"	DELETE " .
					"	FROM	api_error_msg " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'" . 
					"		AND	language_id = '" . intval($LangID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetSiteEffectiveErrorMsg($SiteID, $LangID) {
		$API_ERROR = array();

		$ErrorMsg = errormsg::GetAllErrorMsg(0, $LangID);
		foreach ($ErrorMsg as $E) {
			$API_ERROR[$E['api_error_msg_code']] = array();
			$API_ERROR[$E['api_error_msg_code']]['no'] = $E['api_error_no'];
			$API_ERROR[$E['api_error_msg_code']]['desc'] = $E['api_error_msg_content'];
		}


		$ErrorMsg = errormsg::GetAllErrorMsg($SiteID, $LangID);
		foreach ($ErrorMsg as $E) {			
			if (isset($API_ERROR[$E['api_error_msg_code']])) {
				$API_ERROR[$E['api_error_msg_code']] = array();
				$API_ERROR[$E['api_error_msg_code']]['no'] = $E['api_error_no'];
				$API_ERROR[$E['api_error_msg_code']]['desc'] = $E['api_error_msg_content'];						
			}
		}
		return $API_ERROR;
	}
}