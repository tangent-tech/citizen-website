<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_any_header.php');
require_once('../common/header_site_content.php');
//require_once('../common/header_article.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

//acl::AclBarrier("acl_sitemap_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'content_admin_msg');
$smarty->assign('CurrentTab2', 'content_admin_workflow');
$smarty->assign('MyJS', 'content_admin_workflow_list');

$TotalWorkflowNo = 0;

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

if (!isset($_REQUEST['workflow_result']))
	$_REQUEST['workflow_result'] = 'ANY';

$UnreadFlag = 'N';
if ($_REQUEST['content_admin_msg_status'] == 'Unread')
	$UnreadFlag = 'Y';


if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

$ContentAdminWorkflowList = content_admin::GetContentAdminWorkflowList($_SESSION['ContentAdminID'], $TotalWorkflowNo, $_REQUEST['page_id'], NUM_OF_ADMIN_MSGS_PER_PAGE, 'ANY', $_REQUEST['workflow_result']);

$smarty->assign('ContentAdminWorkflowList', $ContentAdminWorkflowList);

$NoOfPage = ceil($TotalMsgNo / NUM_OF_ADMIN_MSGS_PER_PAGE);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);


$smarty->assign('TITLE', 'Workflow List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/content_admin_workflow_list.tpl');