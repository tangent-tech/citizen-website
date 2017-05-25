<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_album.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_album_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');

$Album = album::GetAlbumInfo($_REQUEST['album_id'], 0);
if ($Album['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);
$smarty->assign('Album', $Album);

acl::ObjPermissionBarrier("edit", $Album, __FILE__, false);

$Media = media::GetMediaInfo($_REQUEST['id'], 0);
if ($Media['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);

$NewFileID = filebase::CloneFile($Media['media_small_file_id'], $Site, $_REQUEST['album_id']);

if ($NewFileID != false) {
	if ($Album['object_thumbnail_file_id'] != 0)
		filebase::DeleteFile($Album['object_thumbnail_file_id'], $Site);

	$query =	"	UPDATE	object " .
				"	SET		object_thumbnail_file_id	= '" . intval($NewFileID) . "'" .
				"	WHERE	object_id = '" . intval($_REQUEST['album_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
album::UpdateTimeStamp($_REQUEST['album_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: media_list.php?id=' . $_REQUEST['album_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));