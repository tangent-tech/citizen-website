<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class content_admin {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function Login($Email, $Password) {
		$query =	"	SELECT	* " . 
					"	FROM	content_admin " .
					"	WHERE	email = '" . aveEscT($Email) . "'" .
					"		AND	content_admin_is_enable = 'Y' ";
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

				$query =	"	UPDATE	content_admin " .
							"	SET		password = '" . aveEsc($hash) . "'" .
							"	WHERE	content_admin_id = '" . $myResult['content_admin_id'] .  "'";
				$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}

			$_SESSION['ContentAdminID'] = $myResult['content_admin_id'];							
			return true;
		}
		else
			return false;
	}

	public static function CheckOldPassword($ContentAdminID, $Password) {
		$query =	"	SELECT	* " . 
					"	FROM	content_admin " .
					"	WHERE	content_admin_id = '" . intval($ContentAdminID) .  "'";
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

				$query =	"	UPDATE	content_admin " .
							"	SET		password = '" . aveEsc($hash) . "'" .
							"	WHERE	content_admin_id = '" . intval($ContentAdminID) .  "'";
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

	public static function GetContentWriterGroupInfo($ContentWriterGroupID) {
		$query =	"	SELECT	* " .
					"	FROM	content_admin_group G " .
					"	WHERE	G.content_admin_group_id = '" . intval($ContentWriterGroupID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetContentWriterGroupMemberList($ContentWriterGroupID, $AdminType = 'CONTENT_WRITER') {
		$query =	"	SELECT	* " . 
					"	FROM	content_admin_group_member_link L JOIN content_admin A ON (L.content_admin_id = A.content_admin_id)" .
					"	WHERE	L.content_admin_group_id = '" . intval($ContentWriterGroupID) . "'" .
					"		AND	A.content_admin_type = '" . aveEscT($AdminType) . "' " .
					"	ORDER BY A.content_admin_name ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ContentAdmins = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ContentAdmins, $myResult);
		}
		return $ContentAdmins;
	}

	public static function GetContentWriterGroupNonMemberList($ContentWriterGroupID, $AdminType = 'CONTENT_WRITER') {
		$query =	"	SELECT	A.* " . 
					"	FROM	content_admin_group G	JOIN		content_admin A ON (G.site_id = A.site_id AND G.content_admin_group_id = '" . intval($ContentWriterGroupID) . "') " .
					"									LEFT JOIN	content_admin_group_member_link L	ON	(L.content_admin_id = A.content_admin_id AND L.content_admin_group_id = '" . intval($ContentWriterGroupID) . "')" .
					"	WHERE	L.content_admin_group_id IS NULL " .
					"		AND	A.content_admin_type = '" . aveEscT($AdminType) . "' " .
					"	ORDER BY A.content_admin_name ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ContentAdmins = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ContentAdmins, $myResult);
		}
		return $ContentAdmins;
	}

	public static function GetContentAdminInfo($ContentAdminID) {
		$query =	"	SELECT	* " .
					"	FROM	content_admin A " .
					"	WHERE	A.content_admin_id = '" . intval($ContentAdminID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function IsContentAdminEmailAlreadyExist($Email, $ContentAdminID = 0) {
		$query =	"	SELECT	* " . 
					"	FROM	content_admin " .
					"	WHERE	email = '" . aveEscT($Email) . "'" .
					"		AND	content_admin_id != '" . intval($ContentAdminID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return true;
		else
			return false;
	}

	public static function GetAllContentAdminList() {
		$query =	"	SELECT	* " . 
					"	FROM	content_admin A JOIN site S ON (A.site_id = S.site_id)" .
					"	ORDER BY S.site_name ASC, A.email ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ContentAdmins = array();

		while ($myResult = $result->fetch_assoc()) {
			array_push($ContentAdmins, $myResult);
		}
		return $ContentAdmins;
	}

	public static function GetContentWriterGroupListByContentAdminID($ContentAdminID) {
		$ContentAdmin = content_admin::GetContentAdminInfo($ContentAdminID);

		if ($ContentAdmin['content_admin_type'] == 'CONTENT_ADMIN') {
			$ContentAdminGroupList = content_admin::GetContentWriterGroupList($ContentAdmin['site_id'], $TotalGroupNo, 1, 999999);
			return $ContentAdminGroupList;
		}
		else {
			$query =	"	SELECT	G.* " . 
						"	FROM	content_admin_group G	JOIN	content_admin_group_member_link L	ON	(L.content_admin_group_id = G.content_admin_group_id) " .
						"									JOIN	content_admin A	ON	(L.content_admin_id = A.content_admin_id) " .
						"	WHERE	L.content_admin_id = '" . intval($ContentAdminID) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$ContentAdminGroupList = array();
			while ($myResult = $result->fetch_assoc()) {
				array_push($ContentAdminGroupList, $myResult);
			}
			return $ContentAdminGroupList;
		}

	}

	public static function GetContentAdminList($SiteID, $ContentAdminType = 'CONTENT_ADMIN', &$TotalAdminNo, $PageNo = 1, $AdminPerPage = 20) {
		$Offset = intval(($PageNo -1) * $AdminPerPage);

		$query =	"	SELECT		SQL_CALC_FOUND_ROWS *, A.* " .
					"	FROM		content_admin A JOIN site S ON (A.site_id = S.site_id)" .
					"	WHERE		A.content_admin_type = '" . aveEscT($ContentAdminType) . "' " .
					"			AND	S.site_id = '" . intval($SiteID) . "'" .
					"	ORDER BY	A.content_admin_id ASC " .
					"	LIMIT	" . $Offset . ", " . intval($AdminPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalAdminNo = $myResult[0];

		$ContentAdminList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ContentAdminList, $myResult);
		}
		return $ContentAdminList;
	}

	public static function GetContentAdminOptionList($SiteID, $ContentAdminType = 'CONTENT_WRITER') {
		$query =	"	SELECT		A.* " .
					"	FROM		content_admin A JOIN site S ON (A.site_id = S.site_id)" .
					"	WHERE		A.content_admin_type = '" . aveEscT($ContentAdminType) . "' " .
					"			AND	S.site_id = '" . intval($SiteID) . "'" .
					"	ORDER BY	A.email ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ContentAdminOptionList = array();
		while ($myResult = $result->fetch_assoc()) {
			$ContentAdminOptionList[intval($myResult['content_admin_id'])] = $myResult['email'];
		}
		return $ContentAdminOptionList;
	}

	public static function GetContentWriterGroupList($SiteID, &$TotalGroupNo, $PageNo = 1, $GroupPerPage = 20) {
		$Offset = intval(($PageNo -1) * $GroupPerPage);

		$query =	"	SELECT		SQL_CALC_FOUND_ROWS *, G.* " .
					"	FROM		content_admin_group G JOIN site S ON (G.site_id = S.site_id)" .
					"	WHERE		S.site_id = '" . intval($SiteID) . "'" .
					"	ORDER BY	G.content_admin_group_id ASC " .
					"	LIMIT	" . $Offset . ", " . intval($GroupPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalGroupNo = $myResult[0];

		$ContentWriterGroupList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ContentWriterGroupList, $myResult);
		}
		return $ContentWriterGroupList;
	}

	public static function GetContentWriterGroupOptionList($SiteID) {
		$query =	"	SELECT		* " .
					"	FROM		content_admin_group G" .
					"	WHERE		G.site_id = '" . intval($SiteID) . "'" .
					"	ORDER BY	G.content_admin_group_name ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ContentWriterGroupOptionList = array();
		while ($myResult = $result->fetch_assoc()) {
			$ContentWriterGroupOptionList[intval($myResult['content_admin_group_id'])] = $myResult['content_admin_group_name'];
		}
		return $ContentWriterGroupOptionList;
	}

	public static function GetContentAdminMsgList($ContentAdminID, &$TotalMsgNo, $PageNo = 1, $MsgPerPage = 20, $WorkflowType = 'ANY', $WorkflowResult = 'ANY', $UnreadOnly = 'N') {
		$Offset = intval(($PageNo -1) * $MsgPerPage);

		$WorkflowTypeSQL = '';
		if ($WorkflowType != 'ANY')
			$WorkflowTypeSQL = " AND	W.workflow_type = '" . aveEscT($WorkflowType) . "' ";

		$WorkflowResultSQL = '';
		if ($WorkflowResult != 'ANY')
			$WorkflowResultSQL = " AND	W.workflow_result = '" . aveEscT($WorkflowResult) . "' ";

		$UnreadOnlySQL = '';
		if ($UnreadOnly == 'Y')
			$UnreadOnlySQL = " AND	M.content_admin_msg_read_date IS NULL ";

		$query =	"	SELECT		SQL_CALC_FOUND_ROWS W.*, G.*, MSA.email AS message_sender_content_admin_email, A.email AS result_content_admin_email, WSA.email AS workflow_sender_content_admin_email, M.* " .
					"	FROM		content_admin_msg M		JOIN		content_admin MSA		ON (M.sender_content_admin_id = MSA.content_admin_id) " .
					"										LEFT JOIN	workflow W				ON (W.workflow_id = M.workflow_id) " .
					"										LEFT JOIN	content_admin_group	G	ON (G.content_admin_group_id = W.receiver_content_admin_group_id) " .
					"										LEFT JOIN	content_admin A			ON (A.content_admin_id = W.workflow_result_content_admin_id) " .
					"										LEFT JOIN	content_admin WSA		ON (WSA.content_admin_id = W.sender_content_admin_id) " .
					"	WHERE		M.content_admin_id = '" . intval($ContentAdminID) . "'" .
					"			AND M.content_admin_msg_delete_date IS NULL " . $WorkflowTypeSQL . $WorkflowResultSQL . $UnreadOnlySQL .
					"	ORDER BY	M.content_admin_msg_create_date DESC " .
					"	LIMIT	" . $Offset . ", " . intval($MsgPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalMsgNo = $myResult[0];

		$MsgList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($MsgList, $myResult);
		}
		return $MsgList;
	}

	public static function GetContentAdminWorkflowList($ContentAdminID, &$TotalWorkflowNo, $PageNo = 1, $WorkflowPerPage = 20, $WorkflowType = 'ANY', $WorkflowResult = 'ANY') {
		$Offset = intval(($PageNo -1) * $MsgPerPage);

		$WorkflowTypeSQL = '';
		if ($WorkflowType != 'ANY')
			$WorkflowTypeSQL = " AND	W.workflow_type = '" . aveEscT($WorkflowType) . "' ";			

		$WorkflowResultSQL = '';
		if ($WorkflowResult != 'ANY')
			$WorkflowResultSQL = " AND	W.workflow_result = '" . aveEscT($WorkflowResult) . "' ";

		$WhereSQL = '';
		$WhereInSQL = '';
		$WhereOutSQL = '';

		// IN Workflow
		$ContentAdminGroupList = content_admin::GetContentWriterGroupListByContentAdminID($ContentAdminID);

		if (count($ContentAdminGroupList) > 0) {
			$ContentAdminGroupSQL = '';
			foreach ($ContentAdminGroupList as $G)
				$ContentAdminGroupSQL = $ContentAdminGroupSQL . "W.receiver_content_admin_group_id = '" . intval($G['content_admin_group_id']) . "' OR ";

			$WhereInSQL = substr($ContentAdminGroupSQL, 0, -3);
		}

		// Out Workflow
		$WhereOutSQL = " W.sender_content_admin_id = '" . intval($ContentAdminID) . "'";

		$WhereSQL = "AND ( " . $WhereInSQL . " OR " . $WhereOutSQL . ") ";

		$query =	"	SELECT		SQL_CALC_FOUND_ROWS W.*, A.email AS result_content_admin_email, WSA.email AS workflow_sender_content_admin_email " .
					"	FROM		workflow W				LEFT JOIN	content_admin A			ON (A.content_admin_id = W.workflow_result_content_admin_id) " .
					"										LEFT JOIN	content_admin WSA		ON (WSA.content_admin_id = W.sender_content_admin_id) " .
					"	WHERE		2 > 1 " . $WorkflowTypeSQL . $WorkflowResultSQL . $WhereSQL .
					"	ORDER BY	W.workflow_create_date DESC " .
					"	LIMIT	" . $Offset . ", " . intval($WorkflowPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);			
		$myResult = $result2->fetch_row();
		$TotalWorkflowNo = $myResult[0];

		$WorkflowList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($WorkflowList, $myResult);
		}
		return $WorkflowList;
	}


	public static function GetContentAdminMsgInfo($ContentAdminMsgID) {
		$query =	"	SELECT		W.*, G.*, MSA.email AS message_sender_content_admin_email, A.email AS result_content_admin_email, WSA.email AS workflow_sender_content_admin_email, M.* " .
					"	FROM		content_admin_msg M		JOIN		content_admin MSA		ON (M.sender_content_admin_id = MSA.content_admin_id) " .
					"										LEFT JOIN	workflow W				ON (W.workflow_id = M.workflow_id) " .
					"										LEFT JOIN	content_admin_group	G	ON (G.content_admin_group_id = W.receiver_content_admin_group_id) " .
					"										LEFT JOIN	content_admin A			ON (A.content_admin_id = W.workflow_result_content_admin_id) " .
					"										LEFT JOIN	content_admin WSA		ON (WSA.content_admin_id = W.sender_content_admin_id) " .
					"	WHERE		M.content_admin_msg_id = '" . intval($ContentAdminMsgID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}
	
}