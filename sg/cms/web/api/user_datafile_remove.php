<?php
#datafile_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$DataFile = datafile::GetDatafileInfo($_REQUEST['datafile_id'], 0);
$DataFileID = $DataFile['datafile_id'];

if ($DataFile['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

datafile::DeleteDatafile($DataFileID, $Site);
site::EmptyAPICache($Site['site_id']);

$smarty->display('api/api_result.tpl');