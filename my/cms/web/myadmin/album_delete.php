<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_album.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");
acl::AclBarrier("acl_album_delete", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');

$Album = album::GetAlbumInfo($_REQUEST['id'], 0);
if ($Album['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);
$smarty->assign('Album', $Album);

acl::ObjPermissionBarrier("delete", $Album, __FILE__, false);

album::UpdateTimeStamp($_REQUEST['id']);

album::DeleteAlbum($_REQUEST['id'], $Site);
site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: album_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));