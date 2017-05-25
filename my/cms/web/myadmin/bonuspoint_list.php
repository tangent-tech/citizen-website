<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_bonus_point.php');

acl::AclBarrier("acl_bonuspoint_list", __FILE__, false);

$smarty->assign('CurrentTab', 'bonuspoint');
$smarty->assign('MyJS', 'bonuspoint_list');

if ($_REQUEST['enable'] == 'Y')
	$smarty->assign('CurrentTab2', 'bonuspoint_list_enable');
elseif ($_REQUEST['enable'] == 'N')
	$smarty->assign('CurrentTab2', 'bonuspoint_list_disable');
else {
	$_REQUEST['enable'] = 'ALL';
	$smarty->assign('CurrentTab2', 'bonuspoint_list_all');
}

$BonusPointItemList = bonuspoint::GetBonusPointItemList($_SESSION['site_id'], 1, 0, $_REQUEST['enable']);
$smarty->assign('BonusPointItemList', $BonusPointItemList);

$smarty->assign('TITLE', 'Bonus Point Item List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/bonuspoint_list.tpl');