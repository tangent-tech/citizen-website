<?php
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$SyncLog = new sync_log($Site['site_id'], $_REQUEST['shop_id']);

if (
	$SyncLog->getLatestLogDetails()->sync_log_status == 'user_sync' ||
	$SyncLog->getLatestLogDetails()->sync_log_status == 'order_sync' ||		
	$SyncLog->getLatestLogDetails()->sync_log_status == 'start_sync'
) {	
	$SyncLog->endLatestMyorderProductSync();
	$smarty->display('api/api_result.tpl');
}
else {
	APIDie(array('no' => __LINE__, 'desc' => 'Unmatched sync status'));	
}