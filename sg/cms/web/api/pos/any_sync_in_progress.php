<?php
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$SyncLog = new sync_log($Site['site_id'], SHOP_ID);

if (
		$SyncLog->getLatestLogDetails()->sync_log_status == 'finished' ||
		$SyncLog->getLatestLogDetails()->sync_log_status == 'failed'
	) {
	
	$smarty->assign('Data', "<sync_in_progress>N</sync_in_progress>");
	$smarty->display('api/api_result.tpl');
}
else {
	$smarty->assign('Data', "<sync_in_progress>Y</sync_in_progress>");
	$smarty->display('api/api_result.tpl');
}