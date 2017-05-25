<?php
// parameters:
//	lang_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$NewsCategoryListXML = news::GetNewsCategoryListXML($_REQUEST['lang_id'], $Site['site_id']);

$smarty->assign('Data', $NewsCategoryListXML);
$smarty->display('api/api_result.tpl');