<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_bonus_point.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_bonuspoint_edit", __FILE__, false);

$BonusPointItem = bonuspoint::GetBonusPointItemInfo($_REQUEST['parent_id'], 0);
if ($BonusPointItem['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

acl::ObjPermissionBarrier("edit", $BonusPointItem, __FILE__, false);

$Media = media::GetMediaInfo($_REQUEST['id'], 0);
if ($Media['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'bonuspoint_list.php', __LINE__);

$NewFileID = filebase::CloneFile($Media['media_small_file_id'], $Site, $_REQUEST['parent_id']);

if ($NewFileID != false) {
	if ($BonusPointItem['object_thumbnail_file_id'] != 0)
		filebase::DeleteFile($BonusPointItem['object_thumbnail_file_id'], $Site);
	
	$query =	"	UPDATE	object " .
				"	SET		object_thumbnail_file_id	= '" . intval($NewFileID) . "'" .
				"	WHERE	object_id = '" . intval($BonusPointItem['bonus_point_item_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

bonuspoint::UpdateTimeStamp($BonusPointItem['bonus_point_item_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: bonuspoint_edit.php?id=' . $_REQUEST['parent_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));