<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_bonus_point.php');

acl::AclBarrier("acl_bonuspoint_edit", __FILE__, false);

$BonusPointItem = bonuspoint::GetBonusPointItemInfo($_REQUEST['id'], 0);
if ($BonusPointItem['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

acl::ObjPermissionBarrier("edit", $BonusPointItem, __FILE__, false);

object::UpdateObjectCommonDataFromRequest($BonusPointItem);
object::UpdateObjectSEOData($BonusPointItem['object_id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($BonusPointItem['object_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

$query =	"	UPDATE	bonus_point_item " .
			"	SET		bonus_point_item_ref_name	= '" . aveEscT($_REQUEST['bonus_point_item_ref_name']) . "', " .
			"			bonus_point_item_type		= '" . aveEscT($_REQUEST['bonus_point_item_type']) . "', " .
			"			bonus_point_required		= '" . intval($_REQUEST['bonus_point_required']) . "', " .
			"			cash						= '" . doubleval($_REQUEST['cash']) . "'" .
			"	WHERE	bonus_point_item_id			= '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
foreach ($SiteLanguageRoots as $R) {
	bonuspoint::TouchBonusPointItemData($_REQUEST['id'], $R['language_id']);
	
	$query =	"	UPDATE	bonus_point_item_data " .
				"	SET		bonus_point_item_name	= '" . aveEscT($_REQUEST['bonus_point_item_name'][$R['language_id']]) . "', " .
				"			bonus_point_item_desc	= '" . aveEscT($_REQUEST['ContentEditor' . $R['language_id']]) . "'" .
				"	WHERE	bonus_point_item_id		= '" . intval($_REQUEST['id']) . "'" .
				"		AND	language_id				= '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

if ($_REQUEST['remove_thumbnail'] == 'Y')
	object::RemoveObjectThumbnail($BonusPointItem, $Site);

if (isset($_FILES['thumbnail_file'])) {
	$Site = site::GetSiteInfo($_SESSION['site_id']);
	$SmallFileID = bonuspoint::UpdateThumbnail($BonusPointItem, $Site, $_FILES['thumbnail_file']);
}

bonuspoint::UpdateTimeStamp($BonusPointItem['bonus_point_item_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: bonuspoint_edit.php?id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));