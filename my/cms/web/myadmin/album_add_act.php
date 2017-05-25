<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_album.php');

acl::AclBarrier("acl_album_add", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');
$smarty->assign('MyJS', 'album_add_act');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

$ParentObj = object::GetObjectInfo($Site['album_root_id']);
acl::ObjPermissionBarrier("add_children", $ParentObj, __FILE__, false);

$AlbumID = object::NewObject('ALBUM', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable'], 'Y', $ParentObj);
album::NewAlbum($AlbumID);
$NewObjectLinkID = object::NewObjectLink($Site['album_root_id'], $AlbumID, trim($_REQUEST['object_name']), 0, 'normal', DEFAULT_ORDER_ID);
object::UpdateObjectSEOData($AlbumID, null, null, null, null, $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($AlbumID, $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

album::UpdateTimeStamp($AlbumID);
object::TidyUpObjectOrder($Site['album_root_id']);

foreach ($SiteLanguageRoots as $R) {
	album::NewAlbumData($AlbumID, $R['language_id'], $_REQUEST['album_desc'][$R['language_id']]);
	
	$query =	"	UPDATE	album_data " .
				"	SET		object_meta_title	= '" . aveEscT($_REQUEST['object_meta_title'][$R['language_id']]) . "', " .
				"			object_meta_description		= '" . aveEscT($_REQUEST['object_meta_description'][$R['language_id']]) . "', " .
				"			object_meta_keywords	= '" . aveEscT($_REQUEST['object_meta_keywords'][$R['language_id']]) . "', " .
				"			object_friendly_url		= '" . aveEscT($_REQUEST['object_friendly_url'][$R['language_id']]) . "' " .
				"	WHERE	album_id	= '" . intval($AlbumID) . "'" .
				"		AND	language_id	= '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}	

header( 'Location: album_edit.php?link_id=' . $NewObjectLinkID .  '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));