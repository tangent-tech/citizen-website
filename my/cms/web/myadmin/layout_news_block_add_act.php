<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_layout_news.php');

acl::AclBarrier("acl_layout_news_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'layout_news');
$smarty->assign('MyJS', 'layout_news_block_add_act');

$LayoutNews = layout_news::GetLayoutNewsInfo($_REQUEST['layout_news_id']);
if ($LayoutNews['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['layout_news_id'], __LINE__);
$smarty->assign('LayoutNews', $LayoutNews);

acl::ObjPermissionBarrier("edit", $LayoutNews, __FILE__, false);

$BlockDef = block::GetBlockDefInfo($_REQUEST['block_def_id']);
if ($BlockDef['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['layout_news_id'], __LINE__);

$BlockHolder = block::GetBlockHolderByPageID($LayoutNews['layout_news_id'], $_REQUEST['block_def_id']);
if ($BlockHolder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['layout_news_id'], __LINE__);

$BlockContentID = 0;

if ($BlockDef['block_definition_type'] == 'text') {
	$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level']);
	block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], 0);
	object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, '', $BlockHolder['language_id'], 'normal', DEFAULT_ORDER_ID);
}
elseif ($BlockDef['block_definition_type'] == 'textarea') {
	$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level']);
	block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], 0);
	object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, trim($_REQUEST['object_name']), $BlockHolder['language_id'], 'normal', DEFAULT_ORDER_ID);
}
elseif ($BlockDef['block_definition_type'] == 'html') {
	$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level']);
	block::NewBlockContent($BlockContentID, $_REQUEST['ContentEditor'], '', 0);
	object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, trim($_REQUEST['object_name']), $BlockHolder['language_id'], 'normal', DEFAULT_ORDER_ID);
}
elseif ($BlockDef['block_definition_type'] == 'image') {
	$FileID = 0;
	if (isset($_FILES['block_image'])){
		$FileID = filebase::AddPhoto($_FILES['block_image'], $BlockDef['block_image_width'], $BlockDef['block_image_height'], $Site, 0, 0);
	}

	if ($FileID !== false) {

		$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level']);
		filebase::UpdateFileParentObjectID($FileID, $BlockContentID);
		block::NewBlockContent($BlockContentID, '', $_REQUEST['block_link_url'], $FileID);
		object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, '', $BlockHolder['language_id'], 'normal', DEFAULT_ORDER_ID);
	}
	else {
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
		header( 'Location: layout_news_block_add.php?layout_news_id=' . $_REQUEST['layout_news_id'] . '&block_def_id=' . $_REQUEST['block_def_id'] . '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();
	}
}
elseif ($BlockDef['block_definition_type'] == 'file') {
	$FileID = 0;
	if (isset($_FILES['block_file']))		
		$FileID = filebase::AddFile($_FILES['block_file'], $Site, 0);

	if ($FileID !== false) {
		$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level']);
		filebase::UpdateFileParentObjectID($FileID, $BlockContentID);
		block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], 0, $FileID);
		object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, '', $BlockHolder['language_id'], 'normal', DEFAULT_ORDER_ID);
	}
	else {
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
		header( 'Location: layout_news_block_add.php?layout_news_id=' . $_REQUEST['layout_news_id'] . '&block_def_id=' . $_REQUEST['block_def_id'] . '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();
	}
}

object::TidyUpObjectOrder($BlockHolder['block_holder_id']);

block::UpdateTimeStamp($BlockContentID);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: layout_news_block_edit.php?layout_news_id=' . $_REQUEST['layout_news_id'] . '&id=' . $BlockContentID .  '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));