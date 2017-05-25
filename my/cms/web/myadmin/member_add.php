<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_member.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_member_add", __FILE__, false);

$smarty->assign('CurrentTab', 'member');
$smarty->assign('CurrentTab2', 'member_all');
$smarty->assign('MyJS', 'member_add');

if (!isset($_REQUEST['user_country_id']))
	$_REQUEST['user_country_id'] = '133';

$TheObject = object::GetObjectInfo($Site['site_user_root_id']);
$smarty->assign('TheObject', $TheObject);

$CurrencyList = currency::GetAllSiteCurrencyList($_SESSION['site_id']);
$smarty->assign('CurrencyList', $CurrencyList);

$HongKongDistrictList = country::GetHongKongDistrictList();
$smarty->assign('HongKongDistrictList', $HongKongDistrictList);

$CountryList = country::GetCountryList(1);
$smarty->assign('CountryList', $CountryList);

$LanguageRootList = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
$smarty->assign('LanguageRootList', $LanguageRootList);

$UserCustomFieldsDef = site::GetUserCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('UserCustomFieldsDef', $UserCustomFieldsDef);

$UserFieldsShow = site::GetUserFieldsShow($_SESSION['site_id']);
$smarty->assign('UserFieldsShow', $UserFieldsShow);

$smarty->assign('TITLE', 'Add Member');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/member_add.tpl');