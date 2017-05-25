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
$smarty->assign('MyJS', 'album_edit_act');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$Object = object::GetObjectLinkInfo($_REQUEST['link_id']);
$Album = album::GetAlbumInfo($Object['object_id'], 0);
if ($Album['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);

acl::ObjPermissionBarrier("edit", $Object, __FILE__, false);

$query	=	"	UPDATE	object_link " .
			"	SET		object_name = '" . aveEscT($_REQUEST['object_name']) . "'" .
			"	WHERE	object_link_id = '" . intval($Object['object_link_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

object::UpdateObjectCommonDataFromRequest($Object);
object::UpdateObjectSEOData($Album['album_id'], null, null, null, null, $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($Album['album_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

$sql = GetCustomTextSQL("album", "int") . GetCustomTextSQL("album", "double") . GetCustomTextSQL("album", "date");
if (strlen($sql) > 0) {
	$query =	"	UPDATE	album " .
				"	SET		" . substr($sql, 0, -1) .
				"	WHERE	album_id = '" . intval($Album['album_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$AlbumCustomFieldsDef = site::GetAlbumCustomFieldsDef($_SESSION['site_id']);

foreach ($SiteLanguageRoots as $R) {
	album::TouchAlbumData($Album['album_id'], $R['language_id']);

	$sql = GetCustomTextSQL("album", "autotext", $R['language_id'], null, false, $AlbumCustomFieldsDef);
	if (strlen($sql) > 0)
		$sql = ", " . substr($sql, 0, -1);
	
	$query	=	"	UPDATE	album_data " .
				"	SET		album_desc = '" . aveEscT($_REQUEST['album_desc'][$R['language_id']]) . "'" . $sql .
				"	WHERE	album_id = '" . intval($Album['album_id']) . "'" .
				"		AND	language_id = '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	$query =	"	UPDATE	album_data " .
				"	SET		object_meta_title	= '" . aveEscT($_REQUEST['object_meta_title'][$R['language_id']]) . "', " .
				"			object_meta_description		= '" . aveEscT($_REQUEST['object_meta_description'][$R['language_id']]) . "', " .
				"			object_meta_keywords	= '" . aveEscT($_REQUEST['object_meta_keywords'][$R['language_id']]) . "', " .
				"			object_friendly_url		= '" . aveEscT($_REQUEST['object_friendly_url'][$R['language_id']]) . "' " .
				"	WHERE	album_id	= '" . intval($Album['album_id']) . "'" .
				"		AND	language_id	= '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

if (isset($_FILES['album_file']))
	$SmallFileID = object::UpdateObjectThumbnail($Album, $Site, $_FILES['album_file'], $Site['site_media_small_width'], $Site['site_media_small_height']);

for ($i = 1; $i <= 20; $i++) {
	if (isset($_FILES['album_custom_file_' . $i]) && $_FILES['album_custom_file_' . $i]['size'] > 0)
		$CustomFileID = album::UpdateAlbumCustomFile($Album, $i, $Site, $_FILES['album_custom_file_' . $i]);
	elseif ($_REQUEST['delete_album_custom_file_' . $i] == 'Y')
		album::DeleteAlbumCustomFile($Album, $i, $Site);
}

album::UpdateTimeStamp($Album['album_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: album_edit.php?link_id=' . $_REQUEST['link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));