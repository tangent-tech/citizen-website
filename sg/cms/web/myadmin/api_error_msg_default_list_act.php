<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'site_management');
$smarty->assign('MyJS', 'api_error_msg_default_list');

$LanguageList = language::GetAllLanguageList();
$smarty->assign('LanguageList', $LanguageList);

$ErrorMsgList = array();

foreach ($LanguageList as $L) {
	errormsg::EmptyAllErrorMsg(0, $L['language_id']);	
}

// copy Eng to all lang first!
foreach ($LanguageList as $L) {
	
	foreach ($_REQUEST['api_error_msg_code'][1] as $index => $value) {
		
		if ( trim($_REQUEST['api_error_msg_code'][1][$index]) != '' && trim($_REQUEST['api_error_no'][1][$index]) != '') {

			$query =	"	INSERT INTO	api_error_msg " .
						"	SET		api_error_msg_code		= '" . aveEscT($_REQUEST['api_error_msg_code'][1][$index]) . "', " .
						"			api_error_no			= '" . aveEscT($_REQUEST['api_error_no'][1][$index]) . "', " .
						"			api_error_msg_content	= '" . aveEscT($_REQUEST['api_error_msg_content'][1][$index]) . "', " .
						"			site_id	= 0, " .
						"			language_id				= '" . intval($L['language_id']) . "'" .
						"	ON DUPLICATE KEY UPDATE api_error_msg_content	= '" . aveEscT($_REQUEST['api_error_msg_content'][$L['language_id']][$index]) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}
}

// now others...
foreach ($LanguageList as $L) {
	
	if ($L['language_id'] == 1)
		continue;
	
	foreach ($_REQUEST['api_error_msg_code'][$L['language_id']] as $index => $value) {
		
		if ( trim($_REQUEST['api_error_msg_code'][$L['language_id']][$index]) != '' && trim($_REQUEST['api_error_no'][$L['language_id']][$index]) != '') {

			$query =	"	INSERT INTO	api_error_msg " .
						"	SET		api_error_msg_code		= '" . aveEscT($_REQUEST['api_error_msg_code'][$L['language_id']][$index]) . "', " .
						"			api_error_no			= '" . aveEscT($_REQUEST['api_error_no'][$L['language_id']][$index]) . "', " .
						"			api_error_msg_content	= '" . aveEscT($_REQUEST['api_error_msg_content'][$L['language_id']][$index]) . "', " .
						"			site_id	= 0, " .
						"			language_id				= '" . intval($L['language_id']) . "'" .
						"	ON DUPLICATE KEY UPDATE api_error_msg_content	= '" . aveEscT($_REQUEST['api_error_msg_content'][$L['language_id']][$index]) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}
}


header( 'Location: api_error_msg_default_list.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));