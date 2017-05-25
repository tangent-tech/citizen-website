<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');

if (!IsValidEmail(trim($_REQUEST['email']))) {
	header( 'Location: site_content_writer_add.php?email=' . urlencode($_REQUEST['email']). '&content_admin_name=' . urlencode($_REQUEST['content_admin_name']) . '&ErrorMessage=' . urlencode(ADMIN_ERROR_INVALID_EMAIL));
	exit();
}

if (content_admin::IsContentAdminEmailAlreadyExist($_REQUEST['email'])) {
	header( 'Location: site_content_writer_add.php?email=' . urlencode($_REQUEST['email']). '&content_admin_name=' . urlencode($_REQUEST['content_admin_name']) . '&ErrorMessage=' . urlencode(ADMIN_ERROR_SYSTEM_ADMIN_EMAIL_EXIST));
	exit();	
}

$ErrorMessage = '';
if (!IsValidPassword($ErrorMessage, $_REQUEST['password1'], $_REQUEST['password2'])) {
	header( 'Location: site_content_writer_add.php?email=' . urlencode($_REQUEST['email']). '&content_admin_name=' . urlencode($_REQUEST['content_admin_name']) . '&ErrorMessage=' . urlencode($ErrorMessage));
	exit();	
}

$hash = password_hash(trim($_REQUEST['password1']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));

$query	=	"	INSERT INTO	content_admin " .
			"	SET		email 			= '" . aveEscT($_REQUEST['email']) . "', " . 
			"			password		= '" . aveEscT($hash) . "', " .
			"			content_admin_type = 'CONTENT_WRITER', " .
			"			content_admin_is_enable = 'Y', " .
			"			content_admin_name = '" . aveEscT($_REQUEST['content_admin_name']) . "', " .
			"			site_id	= '" . intval($_SESSION['site_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$ContentWriterID = customdb::mysqli()->insert_id;

header( 'Location: site_content_writer_edit.php?id=' . $ContentWriterID . '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS));