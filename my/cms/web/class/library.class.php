<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class library {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetLibraryRoot($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM 	object O JOIN object_link OL ON (OL.object_id = O.object_id) " .
					"	WHERE	O.object_type = 'LIBRARY_ROOT'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

}