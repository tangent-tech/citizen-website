<?php
// parameters:
//	block_def_id
//	lang_id
//	security_level - default: 999999

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$Object = object::GetObjectInfo($_REQUEST['block_def_id']);
if ($Object['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if (!isset($_REQUEST['security_level']))
	$_REQUEST['security_level'] = 999999;

$BlockDefXML = block::GetSiteBlockDefXML($Site['site_id'], $_REQUEST['block_def_id'], $_REQUEST['lang_id'], $_REQUEST['security_level']);
$smarty->assign('Data', $BlockDefXML);
$smarty->display('api/api_result.tpl');