<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_article.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_siteblock_delete", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'siteblock');

$BlockContent = block::GetBlockContentInfo($_REQUEST['id']);

$BlockHolder = block::GetBlockHolderInfo($BlockContent['parent_object_id']);
if ($BlockHolder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'siteblock.php', __LINE__);

$BlockDef = block::GetBlockDefInfo($BlockHolder['block_definition_id']);
if ($BlockDef['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'siteblock.php', __LINE__);

if ($BlockContent['site_id'] != $_SESSION['site_id'] || $BlockContent['parent_object_id'] != $BlockHolder['block_holder_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'siteblock.php', __LINE__);

acl::ObjPermissionBarrier("edit", $BlockContent, __FILE__, false);

if ($BlockDef['block_definition_type'] == 'text' || $BlockDef['block_definition_type'] == 'textarea') {
	$query =	"	UPDATE	block_content " .
				"	SET		block_content = '" . aveEscT($_REQUEST['block_content']) . "', ".
				"			block_link_url = '" . aveEscT($_REQUEST['block_link_url']) . "'" .
				"	WHERE	block_content_id = '" . intval($_REQUEST['id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$query =	"	UPDATE	object_link " .
				"	SET		object_name = '" . aveEscT($_REQUEST['object_name']) . "'".
				"	WHERE	object_link_id = '" . intval($BlockContent['object_link_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
elseif ($BlockDef['block_definition_type'] == 'html') {
	$query =	"	UPDATE	block_content " .
				"	SET		block_content = '" . aveEscT($_REQUEST['ContentEditor']) . "', ".
				"			block_link_url = '" . aveEscT($_REQUEST['block_link_url']) . "'" .
				"	WHERE	block_content_id = '" . intval($_REQUEST['id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$query =	"	UPDATE	object_link " .
				"	SET		object_name = '" . aveEscT($_REQUEST['object_name']) . "'".
				"	WHERE	object_link_id = '" . intval($BlockContent['object_link_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
elseif ($BlockDef['block_definition_type'] == 'image') {
	$query =	"	UPDATE	block_content " .
				"	SET		block_content = '" . aveEscT($_REQUEST['block_content']) . "', ".
				"			block_link_url = '" . aveEscT($_REQUEST['block_link_url']) . "'" .
				"	WHERE	block_content_id = '" . intval($_REQUEST['id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$query =	"	UPDATE	object_link " .
				"	SET		object_name = '" . aveEscT($_REQUEST['object_name']) . "'".
				"	WHERE	object_link_id = '" . intval($BlockContent['object_link_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	$FileID = 0;
	if (isset($_FILES['block_image']))
		block::UpdateBlockContentImage($BlockContent, $BlockDef, $Site, $_FILES['block_image']);

	if ($FileID === false) {
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
		header( 'Location: siteblock_edit.php?id=' . $_REQUEST['id'] . '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();
	}
}

object::UpdateObjectCommonDataFromRequest($BlockContent);
object::UpdateObjectPermission($BlockContent['object_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

object::UpdateObjectTimeStamp($BlockContent['object_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: siteblock_edit.php?id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));