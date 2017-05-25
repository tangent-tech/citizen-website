<?php
// parameters:
//	folder_id
//	lang_id
//	security_level
//	page_no
//	album_per_page
//	include_album_details - Default 'N', recommend to turn off cause it costs lots of CPU cycle
//	media_per_page

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$Folder = object::GetObjectInfo($_REQUEST['folder_id']);
if ($Folder['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);
	
if (intval($_REQUEST['page_no']) <= 1)
	$_REQUEST['page_no'] = 1;
if (intval($_REQUEST['album_per_page']) <= 0)
	$_REQUEST['album_per_page'] = 20;
if (intval($_REQUEST['media_per_page']) <= 0)
	$_REQUEST['media_per_page'] = 20;

$OrderByOrderValid = array("DESC", "ASC");

if (!in_array(strtoupper($_REQUEST['orderby_order']), $OrderByOrderValid))
	$_REQUEST['orderby_order'] = "ASC";

$Data = '';
$Data = folder::GetAlbumListXML($_REQUEST['folder_id'], $_REQUEST['lang_id'], $_REQUEST['security_level'], $_REQUEST['page_no'], $_REQUEST['album_per_page'], $_REQUEST['media_per_page'], ynval($_REQUEST['include_album_details']), strtoupper($_REQUEST['orderby_order']));

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');