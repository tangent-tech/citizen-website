<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_article.php');

acl::AclBarrier("acl_sitemap_edit", __FILE__, false);
acl::AclBarrier("acl_folder_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'folder_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$Folder = folder::GetFolderDetails($ObjectLink['object_id']);

$query	=	"	UPDATE	object_link " .
			"	SET		object_name = '". aveEscT($_REQUEST['object_name']) . "'" .
			"	WHERE	object_link_id = '" . intval($ObjectLink['object_link_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::UpdateObjectCommonDataFromRequest($ObjectLink);
object::UpdateObjectSEOData($Folder['folder_id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($Folder['folder_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

$FolderCustomFieldsDef = site::GetFolderCustomFieldsDef($_SESSION['site_id']);

$sql = GetCustomTextSQL("folder", "int") . GetCustomTextSQL("folder", "double") . GetCustomTextSQL("folder", "date") . GetCustomTextSQL("folder", "autotext", 0, null, false, $FolderCustomFieldsDef);
if (strlen($sql) > 0)
	$sql = ", " . substr($sql, 0, -1);

$query	=	"	UPDATE	folder " .
			"	SET		folder_link_url = '". aveEscT($_REQUEST['folder_link_url']) . "'" . $sql .
			"	WHERE	folder_id = '" . intval($Folder['folder_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

// Handle Highlight File
if ($_REQUEST['remove_thumbnail'] == 'Y')
	object::RemoveObjectThumbnail($Folder, $Site);	

if (isset($_FILES['folder_file']) && $_FILES['folder_file']['size'] > 0) {
	$Site = site::GetSiteInfo($_SESSION['site_id']);
	if (object::UpdateObjectThumbnail($Folder, $Site, $_FILES['folder_file'], $Site['site_folder_media_small_width'], $Site['site_folder_media_small_height']) === false)
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
}

folder::UpdateTimeStamp($Folder['folder_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: folder_edit.php?link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));