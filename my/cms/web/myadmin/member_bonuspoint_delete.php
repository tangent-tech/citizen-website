<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_member.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_member_bonuspoint_manage", __FILE__, false);

$smarty->assign('CurrentTab', 'member');
$smarty->assign('MyJS', 'member_bonuspoint_delete');

$query	=	"	SELECT	*	" .
			"	FROM	user_bonus_point " .
			"	WHERE	user_bonus_point_id	=	'" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

if ($result->num_rows > 0) {
	$myResult = $result->fetch_assoc();
	$User = user::GetUserInfo($myResult['user_id']);

	$UserDatafileHolder = user::GetUserDatafileHolderByUserID($myResult['user_id']);
	acl::ObjPermissionBarrier("edit", $UserDatafileHolder, __FILE__, false);
	
	if ($User['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'member_list.php', __LINE__);

	$query	=	"	DELETE FROM	user_bonus_point " .
				"	WHERE	user_bonus_point_id = '" . intval($_REQUEST['id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	site::EmptyAPICache($_SESSION['site_id']);

	header( 'Location: member_edit.php?id=' . $myResult['user_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
}
else
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'member_list.php', __LINE__);