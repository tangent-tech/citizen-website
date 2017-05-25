<?php
// parameters: object_id
// http://localhost:8888/demo.369cms.com/web/api/block_content_get_info.php?api_login=demo01api&api_key=bf9df6694bb0aea4d0fc678233fd8a34&object_id=13979
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$Object = object::GetObjectInfo($_REQUEST['object_id']);
if ($Object['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$smarty->assign('Data', block::GetBlockContentXML($_REQUEST['object_id']));
$smarty->display('api/api_result.tpl');