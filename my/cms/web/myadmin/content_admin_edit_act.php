<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

if (!IsValidEmail(trim($_REQUEST['email']))) {
	header( 'Location: content_admin_edit.php?id=' . urlencode($_REQUEST['id']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_INVALID_EMAIL));
	exit();
}

if (content_admin::IsContentAdminEmailAlreadyExist($_REQUEST['email'], $_REQUEST['id'])) {
	header( 'Location: content_admin_edit.php?id=' . urlencode($_REQUEST['id']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_SYSTEM_ADMIN_EMAIL_EXIST));
	exit();	
}

$PasswordSQL = '';
if (strlen(trim($_REQUEST['password1'])) > 0) {
	$ErrorMessage = '';
	if (!IsValidPassword($ErrorMessage, $_REQUEST['password1'], $_REQUEST['password2'])) {
		header( 'Location: content_admin_edit.php?id=' . urlencode($_REQUEST['id']). '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();	
	}
	
	$hash = password_hash(trim($_REQUEST['password1']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));	
	$PasswordSQL = ", password = '" . aveEscT($hash) . "'";
}

$query	=	"	UPDATE	content_admin " .
			"	SET		content_admin_is_enable = '" . ynval($_REQUEST['content_admin_is_enable']) . "', " .
			"			site_id = '" . intval($_REQUEST['site_id']) . "', " .
			"			email = '" . aveEscT($_REQUEST['email']) . "'" . $PasswordSQL .
			"	WHERE	content_admin_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
header( 'Location: content_admin_edit.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));