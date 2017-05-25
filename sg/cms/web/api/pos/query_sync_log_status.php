<?php
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$SyncLog = new sync_log($Site['site_id'], $_REQUEST['shop_id']);

$Data = "<sync_log_status>" . $SyncLog->getLatestLogDetails()->sync_log_status . "</sync_log_status>";

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');