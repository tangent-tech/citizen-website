<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_member.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_member_balance_list", __FILE__, false);

$smarty->assign('CurrentTab', 'member');
$smarty->assign('CurrentTab2', 'member_balance_list');
$smarty->assign('MyJS', 'member_balance_list');

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

$TotalTransactions = 0;

$UserBalanceList = user::GetAllUserBalanceList($Site['site_id'], $TotalTransactions, $_REQUEST['page_id'], TRANSACTION_PER_PAGE);
$smarty->assign('UserBalanceList', $UserBalanceList);

$NoOfPage = ceil($TotalTransactions / TRANSACTION_PER_PAGE);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);


$smarty->assign('TITLE', 'Member Balance List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/member_balance_list.tpl');