<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_elasing.php');
require_once('../common/header_elasing_multi_level.php');

$TheContentAdmin = content_admin::GetContentAdminInfo($_REQUEST['id']);
$smarty->assign('TheContentAdmin', $TheContentAdmin);

if ($TheContentAdmin['site_id'] != $_SESSION['site_id'] || !$IsContentAdmin || $TheContentAdmin['content_admin_type'] != 'ELASING_USER')
	AdminDie('Sorry, you are not allowed to edit this user.', 'elasing_user_list.php', __LINE__);

if (!IsValidEmail(trim($_REQUEST['email']))) {
	header( 'Location: elasing_user_edit.php?id=' . urlencode($_REQUEST['id']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_INVALID_EMAIL));
	exit();
}

if (content_admin::IsContentAdminEmailAlreadyExist($_REQUEST['email'], $_REQUEST['id'])) {
	header( 'Location: elasing_user_edit.php?id=' . urlencode($_REQUEST['id']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_SYSTEM_ADMIN_EMAIL_EXIST));
	exit();	
}

$ErrorMessage = '';
if (trim($_REQUEST['password1']) != '') {
	if (IsValidPassword($ErrorMessage, $_REQUEST['password1'], $_REQUEST['password2'])) {
		
		$hash = password_hash(trim($_REQUEST['password1']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));
		
		$query  =	" 	UPDATE	content_admin " .
					"	SET		password = '" . $hash . "'" .
					"	WHERE	content_admin_id = '" . intval($_REQUEST['id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	else {
		header( 'Location: elasing_user_edit.php?id=' . urlencode($_REQUEST['id']). '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();	
	}
}

$query	=	"	UPDATE	content_admin " .
			"	SET		email 					= '" . aveEscT($_REQUEST['email']) . "', " . 
			"			content_admin_name		= '" . aveEscT($_REQUEST['content_admin_name']) . "', " . 	
			"			content_admin_is_enable	= '" . ynval($_REQUEST['content_admin_is_enable']) . "' " .
			"	WHERE	content_admin_id		= '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: elasing_user_edit.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));