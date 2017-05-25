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
	$ErrorMsgList[$L['language_id']] = errormsg::GetSiteEffectiveErrorMsg($_SESSION['site_id'], $L['language_id']);
}
$smarty->assign('ErrorMsgList', $ErrorMsgList);

$smarty->assign('TITLE', 'API Error Msg List (Client)');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/api_error_msg_list_client.tpl');