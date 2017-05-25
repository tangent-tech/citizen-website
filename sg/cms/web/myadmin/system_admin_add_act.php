<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

if (!IsValidEmail(trim($_REQUEST['email']))) {
	header( 'Location: system_admin_add.php?system_admin_security_level=' . urlencode($_REQUEST['system_admin_security_level']) . '&email=' . urlencode($_REQUEST['email']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_INVALID_EMAIL));
	exit();
}

if (system_admin::IsSystemAdminEmailAlreadyExist($_REQUEST['email'])) {
	header( 'Location: system_admin_add.php?system_admin_security_level=' . urlencode($_REQUEST['system_admin_security_level']) . '&email=' . urlencode($_REQUEST['email']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_SYSTEM_ADMIN_EMAIL_EXIST));
	exit();	
}

$ErrorMessage = '';
if (!IsValidPassword($ErrorMessage, $_REQUEST['password1'], $_REQUEST['password2'])) {
	header( 'Location: system_admin_add.php?system_admin_security_level=' . urlencode($_REQUEST['system_admin_security_level']) . '&email=' . urlencode($_REQUEST['email']). '&ErrorMessage=' . urlencode($ErrorMessage));
	exit();	
}

$hash = password_hash(trim($_REQUEST['password1']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));

$query	=	"	INSERT INTO	system_admin " .
			"	SET		email 			= '" . aveEscT($_REQUEST['email']) . "', " . 
			"			password		= '" . aveEscT($hash) . "', " .
			"			system_admin_is_enable = 'Y', " .
			"			system_admin_security_level	= '" . intval($_REQUEST['system_admin_security_level']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$SystemAdminID = customdb::mysqli()->insert_id;

header( 'Location: system_admin_edit.php?id=' . $SystemAdminID . '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS));