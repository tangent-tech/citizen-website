<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'api_error_msg_list_client');
$smarty->assign('MyJS', 'api_error_msg_default_list');

$LanguageRootList = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'ALL', 'ALL');
$smarty->assign('LanguageRootList', $LanguageRootList);

$ErrorMsgList = array();

foreach ($LanguageRootList as $L) {
	errormsg::EmptyAllErrorMsg($_SESSION['site_id'], $L['language_id']);
}

// now others...
foreach ($LanguageRootList as $L) {
	
	foreach ($_REQUEST['api_error_msg_code'][$L['language_id']] as $index => $value) {
		
		if ( trim($_REQUEST['api_error_msg_code'][$L['language_id']][$index]) != '' && trim($_REQUEST['api_error_no'][$L['language_id']][$index]) != '') {

			$query =	"	INSERT INTO	api_error_msg " .
						"	SET		api_error_msg_code		= '" . aveEscT($_REQUEST['api_error_msg_code'][$L['language_id']][$index]) . "', " .
						"			api_error_no			= '" . aveEscT($_REQUEST['api_error_no'][$L['language_id']][$index]) . "', " .
						"			api_error_msg_content	= '" . aveEscT($_REQUEST['api_error_msg_content'][$L['language_id']][$index]) . "', " .
						"			site_id	= '" . $_SESSION['site_id'] . "', " .
						"			language_id				= '" . intval($L['language_id']) . "'" .
						"	ON DUPLICATE KEY UPDATE api_error_msg_content	= '" . aveEscT($_REQUEST['api_error_msg_content'][$L['language_id']][$index]) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}
}


header( 'Location: api_error_msg_list_client.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));