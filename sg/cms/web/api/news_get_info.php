<?php
// parameters:
//	news_id
//	page_no
//	media_per_page
//	security_level - default: 999999

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$News = news::GetNewsInfo($_REQUEST['news_id']);
if ($News['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if (!isset($_REQUEST['page_no']))
	$_REQUEST['page_no'] = 1;
if (!isset($_REQUEST['media_per_page']))
	$_REQUEST['media_per_page'] = 999999;
if (!isset($_REQUEST['security_level']))
	$_REQUEST['security_level'] = 999999;
	
$Data = news::GetNewsXML($_REQUEST['news_id'], $_REQUEST['page_no'], $_REQUEST['media_per_page'], $_REQUEST['security_level']);
$smarty->assign('Data', $Data);

$smarty->display('api/api_result.tpl');