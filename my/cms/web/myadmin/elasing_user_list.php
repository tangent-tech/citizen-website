<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_elasing.php');
require_once('../common/header_elasing_multi_level.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_user_list');
$smarty->assign('MyJS', 'elasing_user_list');

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

if (isset($_POST['num_of_elasing_user_per_page'])) {
	if (intval($_POST['num_of_elasing_user_per_page']) < NUM_OF_ELASING_USER_PER_PAGE)
		$_POST['num_of_elasing_user_per_page'] = NUM_OF_ELASING_USER_PER_PAGE;
	setcookie('num_of_elasing_user_per_page', $_POST['num_of_elasing_user_per_page']);
	$_COOKIE['num_of_elasing_user_per_page'] = $_POST['num_of_elasing_user_per_page'];
}
else {
	if (intval($_COOKIE['num_of_elasing_user_per_page']) < NUM_OF_ELASING_USER_PER_PAGE) {
		$_COOKIE['num_of_elasing_user_per_page'] = NUM_OF_ELASING_USER_PER_PAGE;
		setcookie('num_of_elasing_user_per_page', $_COOKIE['num_of_elasing_user_per_page']);
	}
}

$TotalUserNo = 0;

$ElasingUserList = content_admin::GetContentAdminList($_SESSION['site_id'], 'ELASING_USER', $TotalUserNo, $_REQUEST['page_id'], $_COOKIE['num_of_elasing_user_per_page']);
$smarty->assign('ElasingUserList', $ElasingUserList);

$NoOfPage = ceil($TotalUserNo / $_COOKIE['num_of_elasing_user_per_page']);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$smarty->assign('TITLE', 'User List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/elasing_user_list.tpl');