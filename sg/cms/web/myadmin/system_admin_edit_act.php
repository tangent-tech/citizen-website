<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

if (!IsValidEmail(trim($_REQUEST['email']))) {
	header( 'Location: system_admin_edit.php?id=' . urlencode($_REQUEST['id']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_INVALID_EMAIL));
	exit();
}

if (system_admin::IsSystemAdminEmailAlreadyExist($_REQUEST['email'], $_REQUEST['id'])) {
	header( 'Location: system_admin_edit.php?id=' . urlencode($_REQUEST['id']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_SYSTEM_ADMIN_EMAIL_EXIST));
	exit();	
}

$PasswordSQL = '';
if (strlen(trim($_REQUEST['password1'])) > 0) {
	$ErrorMessage = '';
	if (!IsValidPassword($ErrorMessage, $_REQUEST['password1'], $_REQUEST['password2'])) {
		header( 'Location: system_admin_edit.php?id=' . urlencode($_REQUEST['id']). '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();	
	}
	
	$hash = password_hash(trim($_REQUEST['password1']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));
	
	$PasswordSQL = ", password = '" . aveEscT($hash) . "'";
}

// Just make sure this is one line only
$_REQUEST['ssh_public_key'] = preg_replace('/[\n\r]/', '', $_REQUEST['ssh_public_key']);

$query	=	"	UPDATE	system_admin " .
			"	SET		system_admin_security_level	= '" . intval($_REQUEST['system_admin_security_level']) . "', " . 
			"			email = '" . aveEscT($_REQUEST['email']) . "', " . 
			"			ssh_public_key = '" . aveEscT($_REQUEST['ssh_public_key']) . "', " . 
			"			system_admin_is_enable = '" . ynval($_REQUEST['system_admin_is_enable']) . "'" . $PasswordSQL .
			"	WHERE	system_admin_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

// NOW UPDATE THE SITE LINK
if (isset($_REQUEST['SiteAdminAllowedOption'])) {
	foreach ($_REQUEST['SiteAdminAllowedOption'] as $key => $value) {
		if ($value == 'ON') {
			if (site::IsValidSiteID($key)) {
				$query	=	"	INSERT INTO	system_admin_site_link " .
							"	SET		system_admin_id	= '" . intval($_REQUEST['id']) . "', " . 
							"			site_id = '" . aveEscT($key) . "'" .
							"	ON DUPLICATE KEY UPDATE  " .
							"			site_id = '" . aveEscT($key) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}		
		}
		elseif ($value == 'OFF') {
			$query	=	"	DELETE FROM	system_admin_site_link " .
						"	WHERE	system_admin_id	= '" . intval($_REQUEST['id']) . "'" . 
						"		AND	site_id = '" . aveEscT($key) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}
}

// NOW UPDATE THE SITE LINK
if (isset($_REQUEST['GitAdminAllowedOption'])) {
	foreach ($_REQUEST['GitAdminAllowedOption'] as $key => $value) {
		$GitRepoInfo = git::GetGitRepoInfo($key);
		if ($GitRepoInfo != null) {
			if ($value == 'ON') {

					$query	=	"	INSERT INTO	 system_admin_git_repo " .
								"	SET		system_admin_id	= '" . intval($_REQUEST['id']) . "', " . 
								"			git_repo_id = '" . intval($key) . "'" .
								"	ON DUPLICATE KEY UPDATE  " .
								"			git_repo_id = '" . intval($key) . "'";
					$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
			elseif ($value == 'OFF') {
				$query	=	"	DELETE FROM	system_admin_git_repo " .
							"	WHERE	system_admin_id	= '" . intval($_REQUEST['id']) . "'" . 
							"		AND	git_repo_id = '" . intval($key) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}

			git::AddActionQueue('ssh_access_update', $key, 0, $_SESSION['SystemAdminID']);
		}		
	}
}

header( 'Location: system_admin_edit.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));