<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_mailing_list');
$smarty->assign('MyJS', 'elasing_mailing_list');

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);
if (isset($_POST['num_of_elasing_list_per_page'])) {
	if (intval($_POST['num_of_elasing_list_per_page']) < NUM_OF_ELASING_LIST_PER_PAGE)
		$_POST['num_of_elasing_list_per_page'] = NUM_OF_ELASING_LIST_PER_PAGE;
	setcookie('num_of_elasing_list_per_page', $_POST['num_of_elasing_list_per_page']);
	$_COOKIE['num_of_elasing_list_per_page'] = $_POST['num_of_elasing_list_per_page'];
}
else {
	if (intval($_COOKIE['num_of_elasing_list_per_page']) < NUM_OF_ELASING_LIST_PER_PAGE) {
		$_COOKIE['num_of_elasing_list_per_page'] = NUM_OF_ELASING_LIST_PER_PAGE;
		setcookie('num_of_elasing_list_per_page', $_COOKIE['num_of_elasing_list_per_page']);
	}
}

$TotalEmailList = 0;

$EmailList = null;
if ($IsContentAdmin)
	$EmailList = emaillist::GetEmailListBySiteID($_SESSION['site_id'], $TotalEmailList, $_REQUEST['page_id'], $_COOKIE['num_of_elasing_list_per_page'], $_REQUEST['content_admin_id'], 'N');
elseif ($IsElasingUser)
	$EmailList = emaillist::GetEmailListBySiteID($_SESSION['site_id'], $TotalEmailList, $_REQUEST['page_id'], $_COOKIE['num_of_elasing_list_per_page'], $_SESSION['ContentAdminID'], 'N');
$smarty->assign('EmailList', $EmailList);

$NoOfPage = ceil($TotalEmailList / $_COOKIE['num_of_elasing_list_per_page']);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$smarty->assign('TITLE', 'Mailing List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/elasing_mailing_list.tpl');