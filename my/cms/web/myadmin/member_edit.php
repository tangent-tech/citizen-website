<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_member.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_member_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'member');
$smarty->assign('MyJS', 'member_edit');

$User = user::GetUserInfo($_REQUEST['id']);

if ($User['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'member_list.php', __LINE__);
$smarty->assign('User', $User);

$UserDatafileHolder = user::GetUserDatafileHolderByUserID($_REQUEST['id']);
acl::ObjPermissionBarrier("edit", $UserDatafileHolder, __FILE__, false);
$smarty->assign('TheObject', $UserDatafileHolder);

if ($User['user_is_enable'] == 'Y')
	$smarty->assign('CurrentTab2', 'member_enable');
elseif ($_REQUEST['user_is_enable'] == 'N')
	$smarty->assign('CurrentTab2', 'member_disable');
else {
	$smarty->assign('CurrentTab2', 'member_all');
}

$UserBonusPointDetails = user::GetUserBonusPointDetails($_REQUEST['id']);
$smarty->assign('UserBonusPointDetails', $UserBonusPointDetails);

$HongKongDistrictList = country::GetHongKongDistrictList();
$smarty->assign('HongKongDistrictList', $HongKongDistrictList);

$CountryList = country::GetCountryList(1);
$smarty->assign('CountryList', $CountryList);

$SiteCurrencyList = currency::GetAllSiteCurrencyList($_SESSION['site_id']);
$smarty->assign('SiteCurrencyList', $SiteCurrencyList);

$LanguageRootList = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
$smarty->assign('LanguageRootList', $LanguageRootList);

$DefaultExpiryDate = mktime(0, 0, 0, date("m")  , date("d")+$Site['site_bonus_point_valid_days'], date("Y"));
$smarty->assign('DefaultExpiryDate', date('Y-m-d', $DefaultExpiryDate));

if ($UserFieldsShow['user_datafile'] == 'Y') {
	user::TouchUserDatafileHolder($User['user_id'], $Site['site_id']);
	$UserDatafileHolder = user::GetUserDatafileHolderByUserID($User['user_id']);
	$smarty->assign('UserDatafileHolder', $UserDatafileHolder);
	
	$TotalDatafile = 0;
	$UserDatafileList = datafile::GetDatafileList($UserDatafileHolder['user_datafile_holder_id'], 0, $TotalDatafile, 1, 999999);
	$smarty->assign('UserDatafileList', $UserDatafileList);	
}

$UserBalanceList = user::GetUserBalanceList($_REQUEST['id']);
$smarty->assign('UserBalanceList', $UserBalanceList);

$smarty->assign('TITLE', 'Edit Member');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/member_edit.tpl');