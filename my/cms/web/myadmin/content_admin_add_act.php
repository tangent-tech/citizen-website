<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

if (!IsValidEmail(trim($_REQUEST['email']))) {
	header( 'Location: content_admin_add.php?site_id=' . urlencode($_REQUEST['site_id']) . '&email=' . urlencode($_REQUEST['email']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_INVALID_EMAIL));
	exit();
}

if (content_admin::IsContentAdminEmailAlreadyExist($_REQUEST['email'])) {
	header( 'Location: content_admin_add.php?site_id=' . urlencode($_REQUEST['site_id']) . '&email=' . urlencode($_REQUEST['email']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_SYSTEM_ADMIN_EMAIL_EXIST));
	exit();	
}

$ErrorMessage = '';
if (!IsValidPassword($ErrorMessage, $_REQUEST['password1'], $_REQUEST['password2'])) {
	header( 'Location: content_admin_add.php?site_id=' . urlencode($_REQUEST['site_id']) . '&email=' . urlencode($_REQUEST['email']). '&ErrorMessage=' . urlencode($ErrorMessage));
	exit();	
}

$hash = password_hash(trim($_REQUEST['password1']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));

$query	=	"	INSERT INTO	content_admin " .
			"	SET		email 			= '" . aveEscT($_REQUEST['email']) . "', " . 
			"			password		= '" . aveEscT($hash) . "', " .
			"			content_admin_type = 'CONTENT_ADMIN', " .
			"			content_admin_is_enable = 'Y', " .
			"			site_id	= '" . intval($_REQUEST['site_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$ContentAdminID = customdb::mysqli()->insert_id;

header( 'Location: content_admin_edit.php?id=' . $ContentAdminID . '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS));