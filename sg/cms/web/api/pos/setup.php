<?php
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$SyncLog = new sync_log($Site['site_id'], $_REQUEST['shop_id']);

// KO all existing rubbish sync
$query =	"	UPDATE	sync_log " .
			"	SET		sync_log_status = 'finished' " .
			"	WHERE	site_id = '" . intval($Site['site_id']) . "'" .
			"		AND	shop_id = '" . intval($_REQUEST['shop_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$SyncLog->createNewSyncLog(0, false);
$SyncLog->endLatestMyorderProductSync();

$smarty->display('api/api_result.tpl');