<?php
// parameters:
//	folder_id
//	lang_id
//	security_level
//	page_no
//	page_tag
//	page_objects_per_page
//	media_per_page
//	include_page_details - Default 'N', recommend to turn off cause it costs lots of CPU cycle

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
if (intval($_REQUEST['page_objects_per_page']) <= 0)
	$_REQUEST['page_objects_per_page'] = 20;
if (!isset($_REQUEST['media_per_page']))
	$_REQUEST['media_per_page'] = 999999;
	
$Data = '';
$Data = folder::GetPageListXML($_REQUEST['folder_id'], $_REQUEST['lang_id'], $_REQUEST['security_level'], $_REQUEST['page_no'], $_REQUEST['page_objects_per_page'], $_REQUEST['media_per_page'], ynval($_REQUEST['include_page_details']), $_REQUEST['page_tag']);

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');