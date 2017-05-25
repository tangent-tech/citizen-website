<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_layout_news.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_layout_news_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'layout_news');
$smarty->assign('MyJS', 'layout_news_block_edit_act');

$LayoutNews = layout_news::GetLayoutNewsInfo($_REQUEST['layout_news_id']);
if ($LayoutNews['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['layout_news_id'], __LINE__);
$smarty->assign('LayoutNews', $LayoutNews);

acl::ObjPermissionBarrier("edit", $LayoutNews, __FILE__, false);

$BlockContent = block::GetBlockContentInfo($_REQUEST['id']);

$BlockHolder = block::GetBlockHolderInfo($BlockContent['parent_object_id']);
if ($BlockHolder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['layout_news_id'], __LINE__);

$BlockDef = block::GetBlockDefInfo($BlockHolder['block_definition_id']);
if ($BlockDef['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['layout_news_id'], __LINE__);

if ($BlockContent['site_id'] != $_SESSION['site_id'] || $BlockContent['parent_object_id'] != $BlockHolder['block_holder_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

$query =	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['object_is_enable']) . "', ".
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
				"	SET		block_link_url = '" . aveEscT($_REQUEST['block_link_url']) . "'" .
				"	WHERE	block_content_id = '" . intval($_REQUEST['id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$FileID = 0;
	if (isset($_FILES['block_image']))
		block::UpdateBlockContentImage($BlockContent, $BlockDef, $Site, $_FILES['block_image']);

	if ($FileID === false) {
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
		header( 'Location: layout_news_block_edit.php?layout_news_id=' . $_REQUEST['layout_news_id'] . '&id=' . $_REQUEST['id'] . '&ErrorMessage=' . urlencode($ErrorMessage));
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
		header( 'Location: layout_news_block_edit.php?layout_news_id=' . $_REQUEST['layout_news_id'] . '&id=' . $_REQUEST['id'] . '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();
	}
}

block::UpdateTimeStamp($BlockContent['block_content_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: layout_news_block_edit.php?layout_news_id=' . $_REQUEST['layout_news_id'] . '&id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));