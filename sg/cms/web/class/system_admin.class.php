<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class system_admin {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function Login($Email, $Password) {
		$query =	"	SELECT	* " . 
					"	FROM	system_admin " .
					"	WHERE	email = '" . aveEscT($Email) . "'" .
					"		AND	system_admin_is_enable = 'Y' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();

			$needRehash = false;
			if (strlen($myResult['password']) == 32) {
				// OLD md5 shit...
				$needRehash = true;
				$md5hash = md5(ADMINPASSWORD_MD5_SEED . $Password);

				if ($md5hash != $myResult['password'])
					return false;
			}
			else {
				if (!password_verify($Password, $myResult['password']))
					return false;
				$needRehash = password_needs_rehash($myResult['password'], PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));
			}

			if ($needRehash) {
				$hash = password_hash($Password, PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));

				$query =	"	UPDATE	system_admin " .
							"	SET		password = '" . aveEsc($hash) . "'" .
							"	WHERE	system_admin_id = '" . $myResult['system_admin_id'] .  "'";
				$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}

			$_SESSION['SystemAdminID'] = $myResult['system_admin_id'];
			return true;
		}
		else
			return false;
	}

	public static function CheckOldPassword($SystemAdminID, $Password) {
		$query =	"	SELECT	* " . 
					"	FROM	system_admin " .
					"	WHERE	system_admin_id = '" . intval($SystemAdminID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();

			$needRehash = false;
			if (strlen($myResult['password']) == 32) {
				// OLD md5 shit...
				$needRehash = true;
				$md5hash = md5(ADMINPASSWORD_MD5_SEED . $Password);

				if ($md5hash != $myResult['password'])
					return false;
			}
			else {
				if (!password_verify($Password, $myResult['password']))
					return false;
				$needRehash = password_needs_rehash($myResult['password'], PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));
			}

			if ($needRehash) {
				$hash = password_hash($Password, PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));

				$query =	"	UPDATE	system_admin " .
							"	SET		password = '" . aveEsc($hash) . "'" .
							"	WHERE	system_admin_id = '" . intval($SystemAdminID) .  "'";
				$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}

			return true;
		}
		else
			return false;
	}

	public static function Logout() {
		session_destroy();
	}

	public static function GetSystemAdminInfo($SystemAdminID) {
		$query =	"	SELECT	* " .
					"	FROM	system_admin A " .
					"	WHERE	A.system_admin_id = '" . intval($SystemAdminID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetSystemAdminSiteList($SystemAdminID) {
		$query =	"	SELECT	* " .
					"	FROM	system_admin_site_link L JOIN site S ON (L.site_id = S.site_id) " .
					"	WHERE	L.system_admin_id = '" . intval($SystemAdminID) . "'" .
					"	ORDER BY S.site_name ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$Sites = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($Sites, $myResult);
		}
		return $Sites;
	}

	public static function GetSystemAdminSiteListOption($SystemAdminID) {
		$query =	"	SELECT	L.*, S.* " .
					"	FROM	site S LEFT JOIN system_admin_site_link L ON (L.site_id = S.site_id AND L.system_admin_id = '" . intval($SystemAdminID) . "') " .
					"	ORDER BY S.site_name ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$Sites = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($Sites, $myResult);
		}
		return $Sites;
	}		

	public static function GetSystemAdminList() {
		$query =	"	SELECT	* " . 
					"	FROM	system_admin ";
//						"	WHERE	system_admin_security_level < '" . SUPER_ADMIN_LEVEL . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$SystemAdmins = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($SystemAdmins, $myResult);
		}
		return $SystemAdmins;
	}

	public static function IsSiteAllowedForSystemAdmin($SiteID, $SystemAdminID) {
		$query =	"	SELECT	* " .
					"	FROM	system_admin_site_link L " .
					"	WHERE	L.system_admin_id = '" . intval($SystemAdminID) . "'" .
					"		AND	L.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			return true;
		}
		else
			return false;

	}

	public static function IsSystemAdminEmailAlreadyExist($Email, $SystemAdminID = 0) {
		$query =	"	SELECT	* " . 
					"	FROM	system_admin " .
					"	WHERE	email = '" . aveEscT($Email) . "'" .
					"		AND	system_admin_id != '" . intval($SystemAdminID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return true;
		else
			return false;
	}

}