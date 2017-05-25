<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_any_header.php');

if (strlen($_REQUEST['old_password']) > 0) {
	if (!IsValidPassword($ErrorMessage, $_REQUEST['user_password'], $_REQUEST['user_password2'])) {
		header( 'Location: password_change.php?ErrorMessage=' . urlencode($ErrorMessage));
		exit();
	}
	
	$hash = password_hash(trim($_REQUEST['user_password']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));

	if (isset($_SESSION['SystemAdminID'])) {
		$query =	"	SELECT	* " .
					"	FROM	system_admin " .
					"	WHERE	system_admin_id = '" . $_SESSION['SystemAdminID'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			
			if (strlen($myResult['password']) == 32) {
				// OLD md5 shit...
				$md5hash = md5(ADMINPASSWORD_MD5_SEED . $_REQUEST['old_password']);

				if ($md5hash != $myResult['password'])
					AdminDie(ADMIN_ERROR_WRONG_PASSWORD, 'content_admin_setting.php', __LINE__);
			}
			else {
				if (!password_verify(trim($_REQUEST['old_password']), $myResult['password']))
					AdminDie(ADMIN_ERROR_WRONG_PASSWORD, 'content_admin_setting.php', __LINE__);				
			}
			
			$query =	"	UPDATE	system_admin " .
						"	SET		password = '" . aveEscT($hash) . "'" .
						"	WHERE	system_admin_id = '" . $_SESSION['SystemAdminID'] . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else
			AdminDie(ADMIN_ERROR_WRONG_PASSWORD, 'content_admin_setting.php', __LINE__);
	}
	else {
		$query =	"	SELECT	* " .
					"	FROM	content_admin " .
					"	WHERE	content_admin_id = '" . $_SESSION['ContentAdminID'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			
			if (strlen($myResult['password']) == 32) {
				// OLD md5 shit...
				$md5hash = md5(ADMINPASSWORD_MD5_SEED . $_REQUEST['old_password']);

				if ($md5hash != $myResult['password'])
					AdminDie(ADMIN_ERROR_WRONG_PASSWORD, 'content_admin_setting.php', __LINE__);
			}
			else {
				if (!password_verify(trim($_REQUEST['old_password']), $myResult['password']))
					AdminDie(ADMIN_ERROR_WRONG_PASSWORD, 'content_admin_setting.php', __LINE__);				
			}
			
			$query =	"	UPDATE	content_admin " .
						"	SET		password = '" . aveEscT($hash) . "'" .
						"	WHERE	content_admin_id = '" . $_SESSION['ContentAdminID'] . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else
			AdminDie(ADMIN_ERROR_WRONG_PASSWORD, 'content_admin_setting.php', __LINE__);
	}
}

if (isset($_SESSION['SystemAdminID'])) {
	$query =	"	UPDATE	system_admin " .
				"	SET		email_notification = '" . ynval($_REQUEST['email_notification']) . "'" .
				"	WHERE	system_admin_id = '" . $_SESSION['SystemAdminID'] . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
else {
	$query =	"	UPDATE	content_admin " .
				"	SET		email_notification = '" . ynval($_REQUEST['email_notification']) . "'" .
				"	WHERE	content_admin_id = '" . $_SESSION['ContentAdminID'] . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}	

header( 'Location: content_admin_setting.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));