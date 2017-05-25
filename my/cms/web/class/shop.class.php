<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class shop {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetShopList($SiteID) {

		$query =	"	SELECT	* " .
					"	FROM	shop " .
					"	WHERE	site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$SiteList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($SiteList, $myResult);
		}
		return $SiteList;
	}

	public static function GetMaxShopID($SiteID) {
		$query =	"	SELECT	MAX(shop_id) as max_shop_id " .
					"	FROM	shop " .
					"	WHERE	site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result->fetch_assoc();

		return $myResult['max_shop_id'];
	}

	public static function CreateShop($SiteID, $ShopName, $ShopID = null ) {
		$LockName = "Lock_CreateShop" . $SiteID;
		$MyLock = new mylock($LockName);
		$MyLock->acquireLock(true);

		if ($ShopID === null) {
			$ShopID = shop::GetMaxShopID($SiteID) + 1;
		}

		$query  =	" 	INSERT INTO shop " .
					"	SET		site_id = '" . intval($SiteID) . "', " .
					"			shop_id = '" . intval($ShopID) . "', " .
					"			shop_name = '" . aveEscT($ShopName) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		unset($MyLock);

		return $ShopID;
	}

}