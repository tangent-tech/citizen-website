<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_bonus_point.php');

acl::AclBarrier("acl_bonuspoint_add", __FILE__, false);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

$ParentObj = object::GetObjectInfo($Site['bonus_point_root_id']);
acl::ObjPermissionBarrier("add_children", $ParentObj, __FILE__, false);

$BonusPointItemID = object::NewObject('BONUS_POINT_ITEM', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable']);
bonuspoint::NewBonusPointItem($BonusPointItemID, $_REQUEST['bonus_point_item_ref_name'], $_REQUEST['bonus_point_item_type'], $_REQUEST['bonus_point_required'], $_REQUEST['cash']);
$NewObjectLinkID = object::NewObjectLink($Site['bonus_point_root_id'], $BonusPointItemID, trim($_REQUEST['object_name']), 0, 'normal', DEFAULT_ORDER_ID);
object::UpdateObjectSEOData($BonusPointItemID, $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($BonusPointItemID, $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
foreach ($SiteLanguageRoots as $R) {
	$query =	"	INSERT INTO	bonus_point_item_data " .
				"	SET		bonus_point_item_id		= '" . $BonusPointItemID . "', " .
				"			language_id				= '" . $R['language_id'] . "', " .
				"			bonus_point_item_name	= '" . aveEscT($_REQUEST['bonus_point_item_name'][$R['language_id']]) . "', " .
				"			bonus_point_item_desc	= '" . aveEscT($_REQUEST['ContentEditor' . $R['language_id']]) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

if (isset($_FILES['thumbnail_file'])) {
	$Site = site::GetSiteInfo($_SESSION['site_id']);
	$BonusPointItem = bonuspoint::GetBonusPointItemInfo($BonusPointItemID, 0);
	$SmallFileID = bonuspoint::UpdateThumbnail($BonusPointItem, $Site, $_FILES['thumbnail_file']);
}

bonuspoint::UpdateTimeStamp($BonusPointItemID);
object::TidyUpObjectOrder($Site['bonus_point_root_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: bonuspoint_edit.php?id=' . $BonusPointItemID .  '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));