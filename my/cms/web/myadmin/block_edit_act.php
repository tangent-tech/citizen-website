<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_article.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_sitemap_edit", __FILE__, false);
acl::AclBarrier("acl_page_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'block_add');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$Page = page::GetPageInfo($ObjectLink['object_id']);
if ($Page['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $ObjectLink['object_link_id'], __LINE__);

$BlockContent = block::GetBlockContentInfo($_REQUEST['id']);

$BlockHolder = block::GetBlockHolderInfo($BlockContent['parent_object_id']);
if ($BlockHolder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $ObjectLink['object_link_id'], __LINE__);

$BlockDef = block::GetBlockDefInfo($BlockHolder['block_definition_id']);
if ($BlockDef['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $ObjectLink['object_link_id'], __LINE__);

if ($BlockContent['site_id'] != $_SESSION['site_id'] || $BlockContent['parent_object_id'] != $BlockHolder['block_holder_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

$query	=	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['object_is_enable']) . "', " .
			"			object_archive_date		= '" . aveEscT($ObjectArchiveDateText) . "', " .
			"			object_publish_date		= '" . aveEscT($ObjectPublishDateText) . "', " .
			"			object_security_level	= '" . intval($_REQUEST['object_security_level']) . "' " .
			"	WHERE	object_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
if ($BlockDef['block_definition_type'] == 'text') {
	$query =	"	UPDATE	block_content " .
				"	SET		block_content = '" . aveEscT($_REQUEST['block_content']) . "', ".
				"			block_link_url = '" . aveEscT($_REQUEST['block_link_url']) . "'" .
				"	WHERE	block_content_id = '" . intval($_REQUEST['id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
elseif ($BlockDef['block_definition_type'] == 'textarea') {
	$query =	"	UPDATE	block_content " .
				"	SET		block_content = '" . aveEscT($_REQUEST['block_content']) . "', ".
				"			block_link_url = '" . aveEscT($_REQUEST['block_link_url']) . "'" .
				"	WHERE	block_content_id = '" . intval($_REQUEST['id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
elseif ($BlockDef['block_definition_type'] == 'html') {
	$query =	"	UPDATE	block_content " .
				"	SET		block_content = '" . aveEscT($_REQUEST['ContentEditor']) . "'".
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
		header( 'Location: block_edit.php?link_id=' . $_REQUEST['link_id'] . '&id=' . $_REQUEST['id'] . '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();
	}
}
elseif ($BlockDef['block_definition_type'] == 'file') {
	$query =	"	UPDATE	block_content " .
				"	SET		block_content = '" . aveEscT($_REQUEST['block_content']) . "', ".
				"			block_link_url = '" . aveEscT($_REQUEST['block_link_url']) . "'" .
				"	WHERE	block_content_id = '" . intval($_REQUEST['id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$FileID = 0;
	if (isset($_FILES['block_file']))
		block::UpdateBlockContentFile($BlockContent, $BlockDef, $Site, $_FILES['block_file']);

	if ($FileID === false) {
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
		header( 'Location: block_edit.php?link_id=' . $_REQUEST['link_id'] . '&id=' . $_REQUEST['id'] . '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();
	}
}

block::UpdateTimeStamp($BlockContent['block_content_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: block_edit.php?link_id=' . $_REQUEST['link_id'] . '&id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));