<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'callback_log');
$smarty->assign('MyJS', 'callback_log');

if (intval($_REQUEST['page_id']) == 0)
	$_REQUEST['page_id'] = 1;

define('NUM_OF_LOG_PER_PAGE', 50);

if (isset($_POST['num_of_log_per_page'])) {
	if (intval($_POST['num_of_log_per_page']) < NUM_OF_LOG_PER_PAGE)
		$_POST['num_of_log_per_page'] = NUM_OF_LOG_PER_PAGE;
	setcookie('num_of_log_per_page', $_POST['num_of_log_per_page']);
	$_COOKIE['num_of_log_per_page'] = $_POST['num_of_log_per_page'];
}
else {
	if (intval($_COOKIE['num_of_log_per_page']) < NUM_OF_LOG_PER_PAGE) {
		$_COOKIE['num_of_log_per_page'] = NUM_OF_LOG_PER_PAGE;
		setcookie('num_of_log_per_page', $_COOKIE['num_of_log_per_page']);
	}
}

$validStatus = array('hard_fail', 'not_ok_only', 'all');
if (!in_array($_REQUEST['status'], $validStatus))
	$_REQUEST['status'] = 'hard_fail';

if (!isset($_REQUEST['exclude_empty_cache']))
	$_REQUEST['exclude_empty_cache'] = 'Y';

$TotalLog = 0;
$CallbackLog = site::GetCallbackLog(intval($_REQUEST['log_site_id']), $TotalLog, $_REQUEST['page_id'], $_COOKIE['num_of_log_per_page'], $_REQUEST['status'], $_REQUEST['exclude_empty_cache']);
$smarty->assign('CallbackLog', $CallbackLog);

$NoOfPage = ceil($TotalLog / 50);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);


$smarty->assign('TITLE', 'Callback Log');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/callback_log.tpl');