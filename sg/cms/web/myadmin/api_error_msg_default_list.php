<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'api_error_msg_default_list');
$smarty->assign('MyJS', 'api_error_msg_default_list');

$LanguageList = language::GetAllLanguageList();
$smarty->assign('LanguageList', $LanguageList);

$ErrorMsgList = array();

foreach ($LanguageList as $L) {
	$ErrorMsgList[$L['language_id']] = errormsg::GetAllErrorMsg(0, $L['language_id']);
}
$smarty->assign('ErrorMsgList', $ErrorMsgList);

$smarty->assign('TITLE', 'API Error Msg Default List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/api_error_msg_default_list.tpl');
