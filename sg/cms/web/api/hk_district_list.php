<?php
// parameters:
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$HKDistrictListXML = country::GetHongKongDistrictListXML();
$smarty->assign('Data', $HKDistrictListXML);

$smarty->display('api/api_result.tpl');