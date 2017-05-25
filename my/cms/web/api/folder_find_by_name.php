<?php
// parameters:
//	folder_name
//	lang_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$Folder = folder::GetLockFolderByName($_REQUEST['folder_name'], $_REQUEST['lang_id'], $Site['site_id']);
if ($Folder['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$FolderXML = folder::GetFolderXML($Folder['object_id']);

$smarty->assign('Data', $FolderXML);
$smarty->display('api/api_result.tpl');