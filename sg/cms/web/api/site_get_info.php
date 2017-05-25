<?php
// parameters: none
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$smarty->assign('Object', $Site);
$xml = $smarty->fetch('api/object_info/SITE.tpl');
$smarty->assign('Data', $xml);
$smarty->display('api/api_result.tpl');
