<?php
// parameters:
//	file_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$File = filebase::GetFileInfo($_REQUEST['file_id']);
if ($File['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$FileXML = filebase::GetFileXML($File['file_id']);

$smarty->assign('Data', $FileXML);
$smarty->display('api/api_result.tpl');