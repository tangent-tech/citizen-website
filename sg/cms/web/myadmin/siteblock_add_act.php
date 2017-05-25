<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_article.php');

acl::AclBarrier("acl_siteblock_add", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'siteblock');
$smarty->assign('MyJS', 'siteblock_add_act');

$SiteLanguage = language::GetSiteLanguageRoot($_REQUEST['language_id'], $_SESSION['site_id']);
if ($SiteLanguage == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'siteblock.php', __LINE__);

$BlockDef = block::GetBlockDefInfo($_REQUEST['block_def_id']);
if ($BlockDef['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'siteblock.php', __LINE__);

$BlockHolder = block::GetBlockHolderBySiteID($_SESSION['site_id'], $_REQUEST['block_def_id'], $_REQUEST['language_id']);
if ($BlockHolder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'siteblock.php', __LINE__);

acl::ObjPermissionBarrier("add_children", $BlockHolder, __FILE__, false);

$BlockContentID = 0;

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

if ($BlockDef['block_definition_type'] == 'text') {
	$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable'], 'Y', $BlockHolder);
	block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], 0);
	object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, trim($_REQUEST['object_name']), $_REQUEST['language_id'], 'normal', DEFAULT_ORDER_ID);
}
elseif ($BlockDef['block_definition_type'] == 'textarea') {
	$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable'], 'Y', $BlockHolder);
	block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], 0);
	object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, trim($_REQUEST['object_name']), $_REQUEST['language_id'], 'normal', DEFAULT_ORDER_ID);
}
elseif ($BlockDef['block_definition_type'] == 'html') {
	$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable'], 'Y', $BlockHolder);
	block::NewBlockContent($BlockContentID, $_REQUEST['ContentEditor'], $_REQUEST['block_link_url'], 0);
	object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, trim($_REQUEST['object_name']), $_REQUEST['language_id'], 'normal', DEFAULT_ORDER_ID);
}
elseif ($BlockDef['block_definition_type'] == 'image') {
	$FileID = 0;
	if (isset($_FILES['block_image']))
		$FileID = filebase::AddPhoto($_FILES['block_image'], $BlockDef['block_image_width'], $BlockDef['block_image_height'], $Site, 0, 0);

	if ($FileID !== false) {
		$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable'], 'Y', $BlockHolder);
		filebase::UpdateFileParentObjectID($FileID, $BlockContentID);
		block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], $FileID);
		object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, trim($_REQUEST['object_name']), $_REQUEST['language_id'], 'normal', DEFAULT_ORDER_ID);
	}
	else {
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
		header( 'Location: siteblock_add.php?block_def_id=' . $_REQUEST['block_def_id'] . '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();
	}
}

object::UpdateObjectPermission($BlockContentID, $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

object::TidyUpObjectOrder($BlockHolder['block_holder_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: siteblock_edit.php?id=' . $BlockContentID .  '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));