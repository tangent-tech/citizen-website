<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class user{
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function CleanUpNormalUser($SiteID) {			

		$query  =	" 	SELECT * " .
					"	FROM	user U " .
					"	WHERE	U.site_id = '" . intval($SiteID) . "'" ;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			user::DeleteUser($myResult['user_id']);				
		}			

		return $result->num_rows;
	}

	public static function CleanUpTempUser() {			
		$DeleteTime = 60 * 60 * 24 * 3;
		$query  =	" 	SELECT * " .
					"	FROM	user U " .
					"	WHERE	U.user_is_temp = 'Y'" .
					"		AND	U.user_create_date < '" . date('Y-m-d H:i:s', time() - $DeleteTime) . "'" .
					"		AND U.user_id NOT IN (SELECT user_id FROM myorder) ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			user::DeleteUser($myResult['user_id']);				
		}
	}

	public static function IsDuplicateEmail($Email, $ExistUserID = 0, $SiteID) {
		$query  =	" 	SELECT	* " .
					"	FROM	user " .
					"	WHERE	user_email = '" . aveEscT($Email) . "'" .
					"		AND	site_id = '" . intval($SiteID) . "'" .
					"		AND	user_id != '" . intval($ExistUserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		return ($result->num_rows > 0);
	}

	public static function IsDuplicateUsername($Username, $ExistUserID, $SiteID) {
		$query  =	" 	SELECT	* " .
					"	FROM	user " .
					"	WHERE	user_username = '" . aveEscT($Username) . "'" .
					"		AND	site_id = '" . intval($SiteID) . "'" .
					"		AND	user_id != '" . intval($ExistUserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		return ($result->num_rows > 0);
	}

	public static function LoginByUsernameWithHashPass($Username, $HashPass, $SiteID) {
		$query  =	" 	SELECT * " .
					"	FROM	user U LEFT JOIN country C ON (U.user_country_id = C.country_id) " .
					"	WHERE	U.user_username = '" . aveEscT($Username) . "'" .
					"		AND	U.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$User = $result->fetch_assoc();
			
			if ($HashPass == $User['user_password']) {
				$User['user_bonus_point'] = user::GetUserBonusPoint($UserID);

				$User['user_balance'] = user::GetUserBalance($UserID);
				return $User;
			}
			else
				return null;
		}
		else
			return null;
	}		

	public static function LoginByUsername($Username, $Password, $SiteID) {
		$query  =	" 	SELECT * " .
					"	FROM	user U LEFT JOIN country C ON (U.user_country_id = C.country_id) " .
					"	WHERE	U.user_username = '" . aveEscT($Username) . "'" .
//					"		AND	U.user_password = '" . md5(CLIENTPASSWORD_MD5_SEED . $Password) . "'" .
					"		AND	U.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$User = $result->fetch_assoc();

			$needRehash = false;
			if (strlen($User['user_password']) == 32) {
				// OLD md5 shit...
				$needRehash = true;
				$md5hash = md5(CLIENTPASSWORD_MD5_SEED . $Password);

				if ($md5hash != $User['user_password'])
					return null;					
			}
			else {
				if (!password_verify($Password, $User['user_password']))
					return null;
				$needRehash = password_needs_rehash($User['user_password'], PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));
			}

			if ($needRehash) {
				$hash = password_hash($Password, PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));

				$query =	"	UPDATE	user " .
							"	SET		user_password = '" . aveEsc($hash) . "'" .
							"	WHERE	user_id = '" . $User['user_id'] .  "'";
				$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
			
			$User['user_bonus_point'] = user::GetUserBonusPoint($User['user_id']);

			$User['user_balance'] = user::GetUserBalance($User['user_id']);
			return $User;			
		}
		else
			return null;
	}

	public static function GetUserInfoByUsername($Username, $SiteID) {
		$query  =	" 	SELECT * " .
					"	FROM	user U LEFT JOIN country C ON (U.user_country_id = C.country_id) " .
					"	WHERE	U.user_username = '" . aveEscT($Username) . "'" .
					"		AND	U.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$User = $result->fetch_assoc();
			$User['user_bonus_point'] = user::GetUserBonusPoint($UserID);

			$User['user_balance'] = user::GetUserBalance($UserID);				
			return $User;
		}
		else
			return null;

	}

	public static function GetUserInfoByEmail($Email, $SiteID) {
		$query  =	" 	SELECT * " .
					"	FROM	user U LEFT JOIN country C ON (U.user_country_id = C.country_id) " .
					"	WHERE	U.user_email = '" . aveEscT($Email) . "'" .
					"		AND	U.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$User = $result->fetch_assoc();
			$User['user_bonus_point'] = user::GetUserBonusPoint($UserID);

			$User['user_balance'] = user::GetUserBalance($UserID);
			return $User;
		}
		else
			return null;
	}

	public static function GetUserInfo($UserID) {
		$query  =	" 	SELECT *, U.* " .
					"	FROM	user U	LEFT JOIN country C ON (U.user_country_id = C.country_id) " .
					"					LEFT JOIN hk_district D ON (U.user_hk_district_id = D.hk_district_id) " .
					"					LEFT JOIN currency R ON (R.currency_id = U.user_currency_id) " .
					"					LEFT JOIN currency_site_enable E ON (E.currency_id = U.user_currency_id AND E.site_id = U.site_id) " .
					"	WHERE	U.user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$User = $result->fetch_assoc();
			$User['user_bonus_point'] = user::GetUserBonusPoint($UserID);

			$User['user_balance'] = user::GetUserBalance($UserID);				
			return $User;
		}
		else
			return null;
	}

	public static function GetUserByRichSession($UserID, $SessionID) {
		$query  =	" 	SELECT *, U.* " .
					"	FROM	user U	LEFT JOIN country C ON (U.user_country_id = C.country_id) " .
					"					LEFT JOIN currency R ON (R.currency_id = U.user_currency_id) " .
					"					LEFT JOIN currency_site_enable E	ON (E.currency_id = U.user_currency_id AND E.site_id = U.site_id) " .
					"					JOIN	user_rich_session URS		ON (U.user_id = URS.user_id) " .
					"	WHERE	U.user_id = '" . intval($UserID) . "'" .
					"		AND	URS.user_session = '" . aveEsc($SessionID) . "'" .
					"		AND	URS.user_expiry_date < NOW() ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$User = $result->fetch_assoc();
			$User['user_bonus_point'] = user::GetUserBonusPoint($UserID);

			$User['user_balance'] = user::GetUserBalance($UserID);				
			return $User;
		}
		else
			return null;

	}

	public static function GetUserList($SiteID, $IsEnable = 'ALL', $SearchKey = '', $Offset = 0, $RowCount = 20) {
		$sql = '';
		if ($IsEnable != 'ALL')
			$sql = "	AND	user_is_enable = '" . ynval($IsEnable) . "'";

		if (trim($SearchKey) != '') {
			$sql = $sql . "	AND	(user_username LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_email LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_tel_no LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_address_1 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_address_2 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_note LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_1 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_2 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_3 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_4 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_5 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_6 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_7 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_8 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_9 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_10 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_11 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_12 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_13 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_14 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_15 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_16 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_17 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_18 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_19 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_custom_text_20 LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR	user_first_name LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . " OR	user_last_name LIKE '%" . aveEscT($SearchKey) . "%')";


		}

		$query  =	" 	SELECT	* " .
					"	FROM	user U	LEFT JOIN	currency C		ON	(U.user_currency_id 	=	C.currency_id) " .
					"					LEFT JOIN	country Y		ON	(U.user_country_id		=	Y.country_id) " .
					"					LEFT JOIN	hk_district D	ON	(U.user_hk_district_id	=	D.hk_district_id) " .
					"					LEFT JOIN	language L		ON	(U.user_language_id		=	L.language_id) " .
					"	WHERE	site_id = '" . intval($SiteID) . "'" . $sql .
					"	ORDER BY user_id ASC " .
					"	LIMIT	" . $Offset . ", " . intval($RowCount);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$UserList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($UserList, $myResult);
		}
		return $UserList;
	}

	public static function GetUserSubscriberList($SiteID, $IsEnable = 'ALL') {
		$sql = '';
		if ($IsEnable != 'ALL')
			$sql = "	AND	user_is_enable = '" . ynval($IsEnable) . "'";

		$query  =	" 	SELECT	* " .
					"	FROM	user " .
					"	WHERE	site_id = '" . intval($SiteID) . "'" .
					"		AND	user_join_mailinglist = 'Y' " . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$UserList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($UserList, $myResult);
		}
		return $UserList;
	}

	public static function GetTotalNoOfUser($SiteID, $IsEnable = 'ALL', $SearchKey = '') {
		$sql = '';
		if ($IsEnable != 'ALL')
			$sql = "	AND	user_is_enable = '" . ynval($IsEnable) . "'";

		if (trim($SearchKey) != '') {
			$sql = $sql . "	AND	(user_username LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR 	user_email LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . "	OR	user_first_name LIKE '%" . aveEscT($SearchKey) . "%'";
			$sql = $sql . " OR	user_last_name LIKE '%" . aveEscT($SearchKey) . "%')";
		}

		$query  =	" 	SELECT	COUNT(*) AS no_of_users " .
					"	FROM	user " .
					"	WHERE	site_id = '" . intval($SiteID) . "'" . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result->fetch_assoc();
		return $myResult['no_of_users'];
	}

	private static function ExpireUserBonusPoint($UserID, $NowStr = null) {
		$LockName	=	'ExpireUserBonusPointLock' . $UserID;
		$MyLock = new mylock($LockName);
		$MyLock->acquireLock(true);

		if ($NowStr == null) {
			$NowStr = date("Y-m-d H:i:s");
			$TodayStr = date("Y-m-d");
		}
		else {
			$NowTs = datetime::createFromFormat("Y-m-d H:i:s", $NowStr);
			$TodayStr = $NowTs->format('Y-m-d');
		}

		$BonusPointPrevious = 0;

		$query  =	" 	SELECT	SUM(bonus_point_earned) AS TotalBonusPoint, SUM(bonus_point_spent) AS TotalBonusPointSpent " .
					"	FROM	user_bonus_point " .
					"	WHERE	user_id = '" . intval($UserID) . "'" .
					"		AND create_date < '" . aveEsc($NowStr) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			$BonusPointPrevious = $myResult['TotalBonusPoint'] - $myResult['TotalBonusPointSpent'];
		}

		$query  =	" 	SELECT	* " .
					"	FROM	user_bonus_point " .
					"	WHERE	expiry_date < '" . aveEsc($TodayStr) . "'" .
					"		AND	user_id = '" . intval($UserID) . "'" .
					"		AND bonus_point_earned > bonus_point_used " .
					"	ORDER BY create_date ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$TotalExpiredBonusPoint = 0;

		while ($myResult = $result->fetch_assoc()) {
			$BonusPointSpent = intval($myResult['bonus_point_earned'] - $myResult['bonus_point_used']);
			$BonusPointAfter = $BonusPointPrevious - $BonusPointSpent;

			$TotalExpiredBonusPoint += $BonusPointSpent;

			$ExpiryCreateDate = DateTime::createFromFormat('Y-m-d', $myResult['expiry_date']);
			$ExpiryCreateDate->add(new DateInterval('P1D'));

			$query  =	" 	INSERT INTO	user_bonus_point " .
						"	SET			myorder_id	= '" . intval($myResult['myorder_id']) . "', " .
						"				user_id		= '" . intval($UserID) . "', " .
						"				bonus_point_amount_previous	=	'" . intval($BonusPointPrevious) . "', " .
						"				bonus_point_amount_after	=	'" . intval($BonusPointAfter) . "', " .
						"				bonus_point_earned = 0, " .
						"				bonus_point_used = 0, " .
						"				bonus_point_spent = '" . intval($BonusPointSpent) . "', " .
						"				earn_type = '" . aveEscT($myResult['earn_type']) . "', " .
						"				is_auto_expire_transaction = 'Y', " .
						"				create_date = '" . $ExpiryCreateDate->format('Y-m-d') . "' ";
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query  =	" 	UPDATE	user_bonus_point " .
						"	SET		bonus_point_used = bonus_point_earned " .
						"	WHERE	user_bonus_point_id = '" . intval($myResult['user_bonus_point_id']) . "'";
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
			$BonusPointPrevious = $BonusPointAfter;
		}

		unset($MyLock);

		return $TotalExpiredBonusPoint;
	}

	public static function GetUserBonusPoint($UserID) {
		user::ExpireUserBonusPoint($UserID);

		$query  =	" 	SELECT	SUM(bonus_point_earned) AS TotalBonusPoint, SUM(bonus_point_spent) AS TotalBonusPointSpent " .
					"	FROM	user_bonus_point " .
					"	WHERE	user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			$BonusPoint = $myResult['TotalBonusPoint'] - $myResult['TotalBonusPointSpent'];
			return $BonusPoint;
		}
		else
			return 0;
	}

	public static function GetAllUserBonusPointList($SiteID, &$TotalTransactions, $PageNo = 1, $TransactionPerPage = 50) {
		$Offset = intval(($PageNo -1) * $TransactionPerPage);

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, UB.* " .
					"	FROM	user_bonus_point UB	JOIN	user U			ON (UB.user_id = U.user_id) " .
					"							LEFT JOIN	content_admin A ON (UB.content_admin_id = A.content_admin_id)" .
					"							LEFT JOIN	myorder MO		ON (UB.myorder_id = MO.myorder_id) " .
					"	WHERE	U.site_id = '" . intval($SiteID) . "'" .
					"	ORDER BY UB.create_date DESC " .
					"	LIMIT	" . $Offset . ", " . intval($TransactionPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalTransactions = $myResult[0];

		$UserBonusPointList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($UserBonusPointList, $myResult);
		}

		return $UserBonusPointList;
	}		


	public static function GetUserBonusPointDetails($UserID) {
		$query  =	" 	SELECT	*, P.* " .
					"	FROM	user_bonus_point P LEFT JOIN myorder O ON (P.myorder_id = O.myorder_id) " .
					"	WHERE	P.user_id = '" . intval($UserID) . "'" .
					"	ORDER BY	P.create_date ASC,	P.user_bonus_point_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$UserBonusPointList = array();
		while ($myResult = $result->fetch_assoc()) {
			if (strtotime($myResult['expiry_date']) < time()) {
				$myResult['is_expired'] = 'Y';
				$myResult['effective_bonus_point'] = 0;
			}
			else {
				$myResult['is_expired'] = 'N';
				$myResult['effective_bonus_point'] = $myResult['bonus_point_earned'] - $myResult['bonus_point_used'];
			}
			$myResult['display_bonus_point'] = $myResult['bonus_point_earned'] - $myResult['bonus_point_spent'];
			array_push($UserBonusPointList, $myResult);
		}

		return $UserBonusPointList;
	}

	public static function DeduceUserBonusPoint($UserID, $BonusPointAmount, $MyOrderID, $EarnType, $Reason = '', $SystemAdminID = 0, $ContentAdminID = 0, $CustomRefNo = '') {

		$Lock = new mylock('DeduceUserBonusPointLock' . $UserID);
		$Lock->acquireLock();

		$User = user::GetUserInfo($UserID);

//	Allow negative balance due to herocross pos sync
//			if ($BonusPointAmount > $User['user_bonus_point'])
//				$BonusPointAmount = $User['user_bonus_point'];

		if ($BonusPointAmount > 0) {				

			$query  =	" 	INSERT INTO	user_bonus_point " .
						"	SET			myorder_id	= '" . intval($MyOrderID) . "', " .
						"				user_id		= '" . intval($UserID) . "', " .
						"				system_admin_id		=	'" . intval($SystemAdminID) . "', " .
						"				content_admin_id	=	'" . intval($ContentAdminID) . "', " .
						"				bonus_point_amount_previous	=	'" . intval($User['user_bonus_point']) . "', " .
						"				bonus_point_amount_after	=	'" . intval($User['user_bonus_point'] - $BonusPointAmount) . "', " .
						"				bonus_point_earned = 0, " .
						"				bonus_point_used = 0, " .
						"				bonus_point_spent = '" . intval($BonusPointAmount) . "', " .
						"				bonus_point_reason = '" . aveEscT($Reason) . "', " .
						"				earn_type = '" . $EarnType . "', " .
						"				custom_reference_no	= '" . aveEscT($CustomRefNo) . "', " .
						"				create_date = NOW() ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else {
			unset($Lock);
			return;
		}

		$query  =	" 	SELECT	* " .
					"	FROM	user_bonus_point " .
					"	WHERE	expiry_date >= '" . date("Y-m-d") . "'" .
					"		AND	bonus_point_used != bonus_point_earned " .
					"		AND	user_id = '" . intval($UserID) . "'" .
					"	ORDER BY user_bonus_point_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);


		$DeducedBonusPoint = 0;

		while ($DeducedBonusPoint < $BonusPointAmount) {
			if ($myResult = $result->fetch_assoc()) {

				$UsedBonusPoint = min($BonusPointAmount - $DeducedBonusPoint, $myResult['bonus_point_earned'] - $myResult['bonus_point_used']);

				$query =	"	UPDATE	user_bonus_point " .
							"	SET		bonus_point_used = bonus_point_used + " . intval($UsedBonusPoint) .
							"	WHERE	user_bonus_point_id = '" . intval($myResult['user_bonus_point_id']) . "'";
				$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);

				$DeducedBonusPoint = $DeducedBonusPoint + $UsedBonusPoint;
			}
			else
				break;
		}

		unset($Lock);
	}

	public static function GetUserXML($UserID) {
		$smarty = new mySmarty();

		$User = user::GetUserInfo($UserID);
		if ($User != null) {
			$smarty->assign('Object', $User);
			$UserXML = $smarty->fetch('api/object_info/USER.tpl');
			return $UserXML;
		}
		else
			return '';
	}

	public static function GetUserXMLByUserObj($User, $ReturnDatafileListXML = false, $DatafilePageNo = 1, $DatafilePerPage = 999999, $LanguageID) {
		$smarty = new mySmarty();

		if ($User != null) {		
			if ($ReturnDatafileListXML) {
				$TotalNoOfDatafile = 0;

				$UserDatafileHolder = user::GetUserDatafileHolderByUserID($User['user_id']);

				$DatafileListXML = datafile::GetDatafileListXML($UserDatafileHolder['user_datafile_holder_id'], $LanguageID, $TotalNoOfDatafile, $DatafilePageNo, $DatafilePerPage, intval($User['user_security_level']));
				$smarty->assign('DatafileListXML', $DatafileListXML);
				$smarty->assign('TotalNoOfDatafile', $TotalNoOfDatafile);
				$smarty->assign('DatafilePageNo', $DatafilePageNo);
			}

			$smarty->assign('Object', $User);
			$UserXML = $smarty->fetch('api/object_info/USER.tpl');
			return $UserXML;
		}
		else
			return '';			
	}

	public static function GetUserBonusPointDetailsXML($UserID) {
		$smarty = new mySmarty();
		$UserBonusPointDetails = user::GetUserBonusPointDetails($UserID);
		$UserBonusPointDetailsXML = '';
		foreach ($UserBonusPointDetails as $B) {
			$smarty->assign('Object', $B);
			$UserBonusPointDetailsXML = $UserBonusPointDetailsXML . $smarty->fetch('api/object_info/USER_BONUS_POINT.tpl');
		}
		return "<user_bonus_point_details>" . $UserBonusPointDetailsXML . "</user_bonus_point_details>";
	}

	public static function RemoveUserThumbnail($User, $Site) {
		if ($User['user_thumbnail_file_id'] != 0) {
			filebase::DeleteFile($User['user_thumbnail_file_id'], $Site);

			$query =	"	UPDATE	user " .
						"	SET		user_thumbnail_file_id = 0 " .
						"	WHERE	user_id =  '" . $User['user_id'] . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			site::EmptyAPICache($Site['site_id']);
		}
	}

	public static function UpdateUserThumbnail($User, $Site, $File, $Width, $Height) {
		if ($File['size'] > 0) {
			if(!file_exists($File['tmp_name']))
				err_die(1, "Error: File Upload Problem.", $File['tmp_name'], realpath(__FILE__), __LINE__);

			$FileExt = strtolower(substr(strrchr($File['name'], '.'), 1));

			if (!media::IsValidMediaType($FileExt))
				return false;

			$FileID = 0;

			if ($FileExt == 'gif' || $FileExt == 'jpg' || $FileExt == 'png') {
				$SiteRoot = site::GetSiteInfo($SiteID);

				// Notice 2012-11-19:
				//	Jeff: I pass $Site['site_root_id'] here because user is not an object... I should have created everything as object, but this is history and can't change now!
				$FileID	= filebase::AddPhoto($File, $Width, $Height, $Site, 0, $Site['site_root_id']);
			}
			else
				return false;

			if ($FileID !== false) {
				if ($User['user_thumbnail_file_id'] != 0)
					filebase::DeleteFile($User['user_thumbnail_file_id'], $Site);

				$query =	"	UPDATE	user " .
							"	SET		user_thumbnail_file_id = '" . intval($FileID) . "'" .
							"	WHERE	user_id =  '" . intval($User['user_id']) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
				return $FileID;
			}
			return false;
		}
		return false;
	}


	public static function DeleteUser($UserID) {
		$MyOrders = cart::GetMyOrderListByUserID($UserID, 'ALL', 0, 99999);

		foreach ($MyOrders as $O)
			cart::DeleteOrder($O['myorder_id']);

		$query =	"	DELETE FROM	cart_content " .
					"	WHERE		user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	cart_details " .
					"	WHERE		user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	user_bonus_point " .
					"	WHERE		user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	cart_bonus_point_item " .
					"	WHERE		user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	user_balance " .
					"	WHERE		user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	wishlist " .
					"	WHERE		user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$User = user::GetUserInfo($UserID);
		$Site = site::GetSiteInfo($User['site_id']);
		if ($User['user_thumbnail_file_id'] != 0) {
			filebase::DeleteFile($User['user_thumbnail_file_id'], $Site);
		}

		user::DeleteUserDatafileHolder($UserID, $Site);

		$query =	"	DELETE FROM	vote_table " .
					"	WHERE		user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	user " .
					"	WHERE		user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function TouchUserDatafileHolder($UserID, $SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	user_datafile_holder H " .
					"	WHERE	H.user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows == 0) {
			$UserDatafileHolderID = object::NewObject('USER_DATAFILE_HOLDER', $SiteID, 0);

			user::NewUserDatafileHolder($UserDatafileHolderID, $UserID);
		}
	}

	public static function NewUserDatafileHolder($UserDatafileHolderID, $UserID) {
		$query =	"	INSERT INTO user_datafile_holder " .
					"	SET		user_datafile_holder_id	= '" . intval($UserDatafileHolderID) . "', " .
					"			user_id					= '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetUserDatafileHolder($UserDatafileHolderID) {
		$query =	"	SELECT	* " .
					"	FROM	object OH	JOIN	user_datafile_holder H ON	(OH.object_id = H.user_datafile_holder_id)" .
					"	WHERE	H.user_datafile_holder_id = '" . intval($UserDatafileHolderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;			
	}

	public static function GetUserDatafileHolderByUserID($UserID) {
		$query =	"	SELECT	* " .
					"	FROM	object OH	JOIN	user_datafile_holder H ON	(OH.object_id = H.user_datafile_holder_id)" .
					"	WHERE	H.user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	private static function DeleteUserDatafileHolder($UserID, $Site) {
		$UserDatafileHolder = user::GetUserDatafileHolderByUserID($UserID);

		$TotalDatafile = 0;
		$DataFileList = datafile::GetDatafileList($UserDatafileHolder['user_datafile_holder_id'], 0, $TotalDatafile, 1, 999999, 999999, false, false);

		foreach ($DataFileList as $D) {
			datafile::DeleteDatafile($D['datafile_id'], $Site);
		}

		$query =	"	DELETE FROM	user_datafile_holder " .
					"	WHERE		user_datafile_holder_id = '" . $UserDatafileHolder['user_datafile_holder_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($UserDatafileHolder['user_datafile_holder_id']);

	}

	public static function GetUserBalanceLock($UserID) {
		$LockName	=	'UserBalanceLock' . $UserID;
		$MyLock = new mylock($LockName);
		return $MyLock;
	}

	public static function GetUserBalance($UserID) {

		$query =	"	SELECT	SUM(user_balance_transaction_amount) AS user_balance" .
					"	FROM	user_balance " .
					"	WHERE	user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result->fetch_assoc();
		return $myResult['user_balance'] + 0.0;			
	}

	public static function GetUserBalanceList($UserID) {
		$query =	"	SELECT	*, UB.* " .
					"	FROM	user_balance UB LEFT JOIN content_admin A ON (UB.content_admin_id = A.content_admin_id)" .
					"							LEFT JOIN myorder MO ON (UB.myorder_id = MO.myorder_id) " .
					"	WHERE	UB.user_id = '" . intval($UserID) . "'" .
					"	ORDER BY UB.create_date ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$UserBalanceList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($UserBalanceList, $myResult);
		}

		return $UserBalanceList;			
	}

	public static function GetAllUserBalanceList($SiteID, &$TotalTransactions, $PageNo = 1, $TransactionPerPage = 50) {
		$Offset = intval(($PageNo -1) * $TransactionPerPage);

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, UB.* " .
					"	FROM	user_balance UB JOIN		user U			ON (UB.user_id = U.user_id) " .
					"							LEFT JOIN	content_admin A ON (UB.content_admin_id = A.content_admin_id)" .
					"							LEFT JOIN	myorder MO		ON (UB.myorder_id = MO.myorder_id) " .
					"	WHERE	U.site_id = '" . intval($SiteID) . "'" .
					"	ORDER BY UB.create_date DESC " .
					"	LIMIT	" . $Offset . ", " . intval($TransactionPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalTransactions = $myResult[0];

		$UserBalanceList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($UserBalanceList, $myResult);
		}

		return $UserBalanceList;			
	}		

	public static function GetUserBalanceListXML($UserID) {
		$smarty = new mySmarty();
		$UserBalanceList = user::GetUserBalanceList($UserID);
		$UserBalanceListXML = '';
		foreach ($UserBalanceList as $B) {
			$smarty->assign('Object', $B);
			$UserBalanceListXML = $UserBalanceListXML . $smarty->fetch('api/object_info/USER_BALANCE.tpl');
		}
		return "<user_balance_details>" . $UserBalanceListXML . "</user_balance_details>";
	}

	public static function RecalculateBonusPointAndBalanceBeforeAfter($UserID) {
		$query  =	" 	SELECT	* " .
					"	FROM	user_bonus_point " .
					"	WHERE	user_id = '" . intval($UserID) . "'" .
					"	ORDER BY create_date ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Previous = 0;
		$After = 0;

		while ($myResult = $result->fetch_assoc()) {
			$After = $Previous + $myResult['bonus_point_earned'] - $myResult['bonus_point_spent']; 

			$query	=	"	UPDATE	user_bonus_point " .
						"	SET		bonus_point_amount_previous	=	'" . intval($Previous) . "', " .
						"			bonus_point_amount_after	=	'" . intval($After) . "' " .
						"	WHERE	user_bonus_point_id =	'" . intval($myResult['user_bonus_point_id']) . "'";
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$Previous = $After;
		}

		$query  =	" 	SELECT	* " .
					"	FROM	user_balance " .
					"	WHERE	user_id = '" . intval($UserID) . "'" .
					"	ORDER BY create_date ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Previous = 0;
		$After = 0;

		while ($myResult = $result->fetch_assoc()) {
			$After = $Previous + $myResult['user_balance_transaction_amount']; 

			$query	=	"	UPDATE	user_balance " .
						"	SET		user_balance_previous	=	'" . doubleval($Previous) . "', " .
						"			user_balance_after	=	'" . doubleval($After) . "' " .
						"	WHERE	user_balance_id =	'" . intval($myResult['user_balance_id']) . "'";
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$Previous = $After;
		}			
	}

	public static function RerunBonusPointTransactionForSimulation($UserID) {
		// Remove all auto expire transaction first
		$query  =	" 	DELETE FROM	user_bonus_point " .
					"	WHERE	user_id = '" . intval($UserID) . "'" .
					"		AND is_auto_expire_transaction = 'Y' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Reset bonus_point_used = 0
		$query  =	" 	UPDATE	user_bonus_point " .
					"	SET		bonus_point_used = 0 " .
					"	WHERE	user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query  =	" 	SELECT	* " .
					"	FROM	user_bonus_point " .
					"	WHERE	user_id = '" . intval($UserID) . "'" .
					"	ORDER BY create_date ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Previous = 0;
		$After = 0;

		while ($myResult = $result->fetch_assoc()) {
			// Call expire against next create date one by one				
			$ExpiredPoint = user::ExpireUserBonusPoint($UserID, $myResult['create_date']);

			$Previous -= $ExpiredPoint;

			// Deduce bonus point if needed
			if ($myResult['bonus_point_spent'] > 0) {
				$query  =	" 	SELECT	* " .
							"	FROM	user_bonus_point " .
							"	WHERE	expiry_date >= '" . $myResult['create_date'] . "'" .
							"		AND	bonus_point_used != bonus_point_earned " .
							"		AND	user_id = '" . intval($UserID) . "'" .
							"	ORDER BY create_date ASC ";
				$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);

				$DeducedBonusPoint = 0;

				$TotalBonusPointAmountToBeDeduced = $myResult['bonus_point_spent'];

				while ($DeducedBonusPoint < $TotalBonusPointAmountToBeDeduced) {
					if ($myResult2 = $result2->fetch_assoc()) {

						$UsedBonusPoint = min($TotalBonusPointAmountToBeDeduced - $DeducedBonusPoint, $myResult2['bonus_point_earned'] - $myResult2['bonus_point_used']);

						$query =	"	UPDATE	user_bonus_point " .
									"	SET		bonus_point_used = bonus_point_used + " . intval($UsedBonusPoint) .
									"	WHERE	user_bonus_point_id = '" . intval($myResult2['user_bonus_point_id']) . "'";
						$result3 = ave_mysqli_query($query, __FILE__, __LINE__, true);

						$DeducedBonusPoint = $DeducedBonusPoint + $UsedBonusPoint;
					}
					else
						break;
				}					
			}

			// Re-Calculate that row
			$After = $Previous + $myResult['bonus_point_earned'] - $myResult['bonus_point_spent']; 

			$query	=	"	UPDATE	user_bonus_point " .
						"	SET		bonus_point_amount_previous	=	'" . intval($Previous) . "', " .
						"			bonus_point_amount_after	=	'" . intval($After) . "' " .
						"	WHERE	user_bonus_point_id =	'" . intval($myResult['user_bonus_point_id']) . "'";
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$Previous = $After;
		}
	}

	public static function GetUserByOldUserID($SiteID, $ShopID, $OldUserID) {
		$query  =	" 	SELECT * " .
					"	FROM	user " .
					"	WHERE	old_user_id = '" . intval($OldUserID) . "'" .
					"		AND	site_id = '" . intval($SiteID) . "'" .
					"		AND shop_id = '" . intval($ShopID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			return $result->fetch_assoc();
		}
		else
			return null;
	}

	public static function GetMaxUserID($SiteID) {
		$query  =	" 	SELECT	MAX(user_id) as max_user_id " .
					"	FROM	user " .
					"	WHERE	site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result->fetch_assoc();

		return $myResult['max_user_id'];
	}
}