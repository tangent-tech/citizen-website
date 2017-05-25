<?php
// empty_all_block_content - default: N
// layout_news_id
// security_level
// object_name
// block_def_id
// block_content
// block_link_url
// block_image_url
// block_file_url
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if ($Site['site_module_objman_enable'] != 'Y')
	APIDie(array('desc' => 'Module ObjMan is not enabled'));

$LayoutNews = layout_news::GetLayoutNewsInfo($_REQUEST['layout_news_id']);
if ($LayoutNews['site_id'] != $Site['site_id'])
	APIDie(array('desc' => 'Invalid layout_news_id'));

$Layout = layout::GetLayoutInfo($LayoutNews['layout_id']);

$BlockHolder = block::GetBlockHolderByPageID($LayoutNews['layout_news_id'], $_REQUEST['block_def_id']);
if ($BlockHolder['site_id'] != $Site['site_id'])
	APIDie(array('desc' => 'Invalid block_def_id'));

$BlockDef = block::GetBlockDefInfo($_REQUEST['block_def_id']);
if ($BlockDef['site_id'] != $Site['site_id'])
	APIDie(array('desc' => 'Invalid block_def_id'));

$BlockImageInfo = array();
if (strlen(trim($_REQUEST['block_image_url'])) > 0) {
	$BlockImageInfo = @getimagesize(trim($_REQUEST['block_image_url']));

	if ($BlockImageInfo[0] == 0) {
		APIDie(array('desc' => "block_image_url: cannot load image"), __LINE__);
	}
	elseif ($BlockImageInfo[2] > 3) { // 1 = GIF, 2 = JPG, 3 = PNG
		APIDie(array('desc' => "block_image_url: unsupported image type"), __LINE__);
	}
}

if (strlen(trim($_REQUEST['block_file_url'])) > 0) {
	$fileSize = @filesize(trim($_REQUEST['block_file_url']));
	
	if ($fileSize === false) {
		APIDie(array('desc' => "block_file_url: cannot load file"), __LINE__);
	}
}

// GOOD TO GO FROM HERE

if ($_REQUEST['empty_all_block_content'] == 'Y') {
	$BlockList = block::GetBlockContentListByBlockHolderID($BlockHolder['block_holder_id']);
	foreach ($BlockList as $B) {
		block::DeleteBlockContent($B['block_content_id'], $Site, true);
	}
}

if ($BlockDef['block_definition_type'] == 'text') {
	$BlockContentID = object::NewObject('BLOCK_CONTENT', $Site['site_id'], $_REQUEST['security_level']);
	block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], 0);
	object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, '', $BlockHolder['language_id'], 'normal', DEFAULT_ORDER_ID);
}
elseif ($BlockDef['block_definition_type'] == 'textarea') {
	$BlockContentID = object::NewObject('BLOCK_CONTENT', $Site['site_id'], $_REQUEST['security_level']);
	block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], 0);
	object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, trim($_REQUEST['object_name']), $BlockHolder['language_id'], 'normal', DEFAULT_ORDER_ID);
}
elseif ($BlockDef['block_definition_type'] == 'html') {
	$BlockContentID = object::NewObject('BLOCK_CONTENT', $Site['site_id'], $_REQUEST['security_level']);
	block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], '', 0);
	object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, trim($_REQUEST['object_name']), $BlockHolder['language_id'], 'normal', DEFAULT_ORDER_ID);
}
elseif ($BlockDef['block_definition_type'] == 'image') {
	if (strlen(trim($_REQUEST['block_image_url'])) == 0) {
		APIDie(array('desc' => "block_image_url: cannot load file"), __LINE__);				
	}
	
	$PathInfo = pathinfo(trim($_REQUEST['block_image_url']));
	$blockImageFile = file_get_contents(trim($_REQUEST['block_image_url']));
	
	$TmpFile = tempnam("/tmp", "TmpImportImageFile");
	file_put_contents($TmpFile, $blockImageFile);

	$TheFile = array();
	$TheFile['name'] = $PathInfo['basename'];
	$TheFile['size'] = filesize($TmpFile);
	$TheFile['tmp_name'] = $TmpFile;
	$FileExt = strtolower(substr(strrchr($PathInfo['basename'], '.'), 1));
	
	$FileOK = true;
	if ($BlockImageInfo[2] == 1) {
		$TheFile['type'] = 'image/gif';
		$GenFileExt = 'gif';
	}
	elseif ($BlockImageInfo[2] == 2) {
		$TheFile['type'] = 'image/jpeg';
		$GenFileExt = 'jpg';
	}
	elseif ($BlockImageInfo[2] == 3) {
		$TheFile['type'] = 'image/png';
		$GenFileExt = 'png';
	}
	else
		$FileOK = false; // Should not happen actually. Error checking before
	
	if ($GenFileExt != $FileExt)
		$TheFile['name'] = $TheFile['name'] . "." . $GenFileExt;

	$FileID = false;
	if ($FileOK) {
		$FileID = filebase::AddPhoto($TheFile, $BlockDef['block_image_width'], $BlockDef['block_image_height'], $Site, 0, 0);		
	}
	
	if ($FileID !== false) {
		$BlockContentID = object::NewObject('BLOCK_CONTENT', $Site['site_id'], $_REQUEST['security_level']);
		filebase::UpdateFileParentObjectID($FileID, $BlockContentID);
		block::NewBlockContent($BlockContentID, '', $_REQUEST['block_link_url'], $FileID);
		object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, '', $BlockHolder['language_id'], 'normal', DEFAULT_ORDER_ID);
	}
	else {
		APIDie(array('desc' => "block_image_url: cannot load image"), __LINE__);		
	}
}
elseif ($BlockDef['block_definition_type'] == 'file') {
	if (strlen(trim($_REQUEST['block_file_url'])) == 0) {
		APIDie(array('desc' => "block_file_url: cannot load file"), __LINE__);				
	}	
	
	$PathInfo = pathinfo(trim($_REQUEST['block_file_url']));
	$blockFile = file_get_contents(trim($_REQUEST['block_file_url']));
	
	$TmpFile = tempnam("/tmp", "TmpImportBlockFile");
	file_put_contents($TmpFile, $blockFile);

	$TheFile = array();
	$TheFile['name'] = $PathInfo['basename'];
	$TheFile['size'] = filesize($TmpFile);
	$TheFile['tmp_name'] = $TmpFile;
	$TheFile['type'] = 'application/octet-stream';	
	
	$FileID = filebase::AddFile($TheFile, $Site, 0);

	if ($FileID !== false) {
		$BlockContentID = object::NewObject('BLOCK_CONTENT', $Site['site_id'], $_REQUEST['security_level']);
		filebase::UpdateFileParentObjectID($FileID, $BlockContentID);
		block::NewBlockContent($BlockContentID, $_REQUEST['block_content'], $_REQUEST['block_link_url'], 0, $FileID);
		object::NewObjectLink($BlockHolder['block_holder_id'], $BlockContentID, '', $BlockHolder['language_id'], 'normal', DEFAULT_ORDER_ID);
	}
	else {
		APIDie(array('desc' => "block_file_url: cannot load file"), __LINE__);		
	}
}

object::TidyUpObjectOrder($BlockHolder['block_holder_id']);

block::UpdateTimeStamp($BlockContentID);

site::EmptyAPICache($Site['site_id']);
$smarty->assign('Data', "<block_content_id>" . $BlockContentID . "</block_content_id>");
$smarty->display('api/api_result.tpl');