<?php
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if (sync_log::isOtherShopSyncInProgress($Site['site_id'], $_REQUEST['shop_id'])) {
	APIDie(array('no' => __LINE__, 'desc' => 'other shop sync in progress'));	
}

$SyncLog = new sync_log($Site['site_id'], $_REQUEST['shop_id']);

if (
		$SyncLog->getLatestLogDetails()->sync_log_status == 'finished' ||
		$SyncLog->getLatestLogDetails()->sync_log_status == 'failed'
	) {
	
	$SyncLogID = $SyncLog->createNewSyncLog();
	$smarty->assign('Data', "<sync_log_id>$SyncLogID</sync_log_id>");
	$SyncLog->updateLatestSyncStatus('start_sync');
	$smarty->display('api/api_result.tpl');
}
else {
	APIDie(array('no' => __LINE__, 'desc' => 'existing sync in progress'));
}