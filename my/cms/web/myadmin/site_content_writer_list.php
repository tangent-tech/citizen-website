<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');

$smarty->assign('CurrentTab', 'site_content_writer');
$smarty->assign('CurrentTab2', 'site_content_writer_list');
$smarty->assign('MyJS', 'site_content_writer_list');

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

if (isset($_POST['num_of_content_writer_per_page'])) {
	if (intval($_POST['num_of_content_writer_per_page']) < NUM_OF_CONTENT_WRITER_PER_PAGE)
		$_POST['num_of_content_writer_per_page'] = NUM_OF_CONTENT_WRITER_PER_PAGE;
	setcookie('num_of_content_writer_per_page', $_POST['num_of_content_writer_per_page']);
	$_COOKIE['num_of_content_writer_per_page'] = $_POST['num_of_content_writer_per_page'];
}
else {
	if (intval($_COOKIE['num_of_content_writer_per_page']) < NUM_OF_CONTENT_WRITER_PER_PAGE) {
		$_COOKIE['num_of_content_writer_per_page'] = NUM_OF_CONTENT_WRITER_PER_PAGE;
		setcookie('num_of_content_writer_per_page', $_COOKIE['num_of_content_writer_per_page']);
	}
}

$TotalContentWriterNo = 0;

$ContentWriterList = content_admin::GetContentAdminList($_SESSION['site_id'], 'CONTENT_WRITER', $TotalContentWriterNo, $_REQUEST['page_id'], $_COOKIE['num_of_content_writer_per_page']);
$smarty->assign('ContentWriterList', $ContentWriterList);

$NoOfPage = ceil($TotalContentWriterNo / $_COOKIE['num_of_content_writer_per_page']);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);


$smarty->assign('TITLE', 'Content Writer List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/site_content_writer_list.tpl');