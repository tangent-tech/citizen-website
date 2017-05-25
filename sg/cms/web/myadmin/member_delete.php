<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_member.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_member_delete", __FILE__, false);

$smarty->assign('CurrentTab', 'member');

$User = user::GetUserInfo($_REQUEST['id']);
if ($User['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR . $User['site_id'], 'member_list.php', __LINE__);

$UserDatafileHolder = user::GetUserDatafileHolderByUserID($_REQUEST['id']);
acl::ObjPermissionBarrier("delete", $UserDatafileHolder, __FILE__, false);

user::DeleteUser($User['user_id']);

site::EmptyAPICache($_SESSION['site_id']);

$page_id = 1;

if (isset($_REQUEST['page_id']) && $_REQUEST['page_id'] != NULL) {
	$page_id = $_REQUEST['page_id'];
}

header( 'Location: member_list.php?page_id=' . $page_id . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));