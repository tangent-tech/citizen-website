<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');

$smarty->assign('CurrentTab', 'site_content_writer');
$smarty->assign('CurrentTab2', 'site_content_writer_list');
$smarty->assign('MyJS', 'site_content_writer_edit');

$ContentWriter = content_admin::GetContentAdminInfo($_REQUEST['id']);
if ($ContentWriter['site_id'] != $_SESSION['site_id'] || $ContentWriter['content_admin_type'] != 'CONTENT_WRITER')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'site_content_writer_list.php', __LINE__);
$smarty->assign('ContentWriter', $ContentWriter);

if (!IsValidEmail(trim($_REQUEST['email']))) {
	header( 'Location: site_content_writer_edit.php?id=' . urlencode($_REQUEST['id']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_INVALID_EMAIL));
	exit();
}

if (content_admin::IsContentAdminEmailAlreadyExist($_REQUEST['email'], $_REQUEST['id'])) {
	header( 'Location: site_content_writer_edit.php?id=' . urlencode($_REQUEST['id']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_SYSTEM_ADMIN_EMAIL_EXIST));
	exit();	
}

$PasswordSQL = '';
if (strlen(trim($_REQUEST['password1'])) > 0) {
	$ErrorMessage = '';
	if (!IsValidPassword($ErrorMessage, $_REQUEST['password1'], $_REQUEST['password2'])) {
		header( 'Location: site_content_writer_edit.php?id=' . urlencode($_REQUEST['id']). '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();	
	}
	
	$hash = password_hash(trim($_REQUEST['password1']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));
	
	$PasswordSQL = ", password = '" . aveEscT($hash) . "'";
}

$query	=	"	UPDATE	content_admin " .
			"	SET		content_admin_is_enable = '" . ynval($_REQUEST['content_admin_is_enable']) . "', " .
			"			content_admin_name = '" . aveEscT($_REQUEST['content_admin_name']) . "', " .		
			"			email = '" . aveEscT($_REQUEST['email']) . "'" . $PasswordSQL .
			"	WHERE	content_admin_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
$AllAclOption = acl::GetAllAclOption();

$query =	"	DELETE FROM	content_admin_acl " .
			"	WHERE	content_admin_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

foreach ($_REQUEST['content_admin_acl_option'] as $AclOption) {
	if (in_array($AclOption, $AllAclOption)) {
		$query =	"	INSERT INTO	content_admin_acl " .
					"	SET			content_admin_acl_option	= '" . aveEscT($AclOption) . "', " .
					"				content_admin_id			= '" . intval($_REQUEST['id']) . "'" .
					"	ON DUPLICATE KEY UPDATE content_admin_acl_id = content_admin_acl_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

header( 'Location: site_content_writer_edit.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));