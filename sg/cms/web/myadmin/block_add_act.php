<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_article.php');

acl::AclBarrier("acl_sitemap_edit", __FILE__, false);
acl::AclBarrier("acl_page_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'block_add_act');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$Page = page::GetPageInfo($ObjectLink['object_id']);
if ($Page['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $ObjectLink['object_link_id'], __LINE__);

$BlockDef = block::GetBlockDefInfo($_REQUEST['block_def_id']);
if ($BlockDef['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $ObjectLink['object_link_id'], __LINE__);

$BlockHolder = block::GetBlockHolderByPageID($Page['page_id'], $_REQUEST['block_def_id']);
if ($BlockHolder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $ObjectLink['object_link_id'], __LINE__);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];
	
$BlockContentID = 0;
if ($BlockDef['block_definition_type'] == 'text') {
	$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable']);
	block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], 0);
	object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, trim($_REQUEST['object_name']), $ObjectLink['language_id'], 'normal', DEFAULT_ORDER_ID);
}
elseif ($BlockDef['block_definition_type'] == 'textarea') {
	$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable']);
	block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], 0);
	object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, trim($_REQUEST['object_name']), $ObjectLink['language_id'], 'normal', DEFAULT_ORDER_ID);
}
elseif ($BlockDef['block_definition_type'] == 'html') {
	$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable']);
	block::NewBlockContent($BlockContentID, $_REQUEST['ContentEditor'], '', 0);
	object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, trim($_REQUEST['object_name']), $ObjectLink['language_id'], 'normal', DEFAULT_ORDER_ID);
}
elseif ($BlockDef['block_definition_type'] == 'image') {
	$FileID = 0;
	if (isset($_FILES['block_image']))
		$FileID = filebase::AddPhoto($_FILES['block_image'], $BlockDef['block_image_width'], $BlockDef['block_image_height'], $Site, 0, 0);

	if ($FileID !== false) {
		$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable']);
		filebase::UpdateFileParentObjectID($FileID, $BlockContentID);
		block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], $FileID);
		object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, trim($_REQUEST['object_name']), $ObjectLink['language_id'], 'normal', DEFAULT_ORDER_ID);
	}
	else {
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
		header( 'Location: block_add.php?link_id=' . $_REQUEST['link_id'] . '&block_def_id=' . $_REQUEST['block_def_id'] . '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();
	}
}
elseif ($BlockDef['block_definition_type'] == 'file') {
	$FileID = 0;
	if (isset($_FILES['block_file']))		
		$FileID = filebase::AddFile($_FILES['block_file'], $Site, 0);

	if ($FileID !== false) {
		$BlockContentID = object::NewObject('BLOCK_CONTENT', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable']);
		filebase::UpdateFileParentObjectID($FileID, $BlockContentID);
		block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], 0, $FileID);
		object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, '', $ObjectLink['language_id'], 'normal', DEFAULT_ORDER_ID);
	}
	else {
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
		header( 'Location: block_add.php?link_id=' . $_REQUEST['link_id'] . '&block_def_id=' . $_REQUEST['block_def_id'] . '&ErrorMessage=' . urlencode($ErrorMessage));
		exit();
	}
}


object::TidyUpObjectOrder($BlockHolder['block_holder_id']);

block::UpdateTimeStamp($BlockContentID);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: block_edit.php?link_id=' . $_REQUEST['link_id'] . '&id=' . $BlockContentID .  '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));