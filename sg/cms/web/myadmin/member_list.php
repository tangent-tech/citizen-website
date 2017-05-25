<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_member.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_member_list", __FILE__, false);

$smarty->assign('CurrentTab', 'member');
if ($_REQUEST['enable'] == 'Y')
	$smarty->assign('CurrentTab2', 'member_enable');
elseif ($_REQUEST['enable'] == 'N')
	$smarty->assign('CurrentTab2', 'member_disable');
else {
	$_REQUEST['enable'] = 'ALL';
	$smarty->assign('CurrentTab2', 'member_all');
}
$smarty->assign('MyJS', 'member_list');

$NoOfUsers = user::GetTotalNoOfUser($_SESSION['site_id'], $_REQUEST['enable'], $_REQUEST['SearchKey']);

if (!isset($_REQUEST['page_id']) || $_REQUEST['page_id'] == NULL)
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

$Offset = ($_REQUEST['page_id']-1) * NUM_OF_USERS_PER_PAGE;
$NoOfPage = ceil($NoOfUsers / NUM_OF_USERS_PER_PAGE);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);
$Users = user::GetUserList($_SESSION['site_id'], $_REQUEST['enable'], $_REQUEST['SearchKey'], $Offset, NUM_OF_USERS_PER_PAGE);
$smarty->assign('Users', $Users);

$smarty->assign('TITLE', 'Member List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/member_list.tpl');