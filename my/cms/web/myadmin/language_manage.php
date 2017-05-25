<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_article.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'language');
$smarty->assign('MyJS', 'language_root_list');

$LanguageRootList = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'ALL', 'ALL');
$smarty->assign('LanguageRootList', $LanguageRootList);

$LanguageWithNoRootList = language::GetAllLanguageWithNoSiteLanguageRootList($_SESSION['site_id']);
$smarty->assign('LanguageWithNoRootList', $LanguageWithNoRootList);

$smarty->assign('TITLE', 'Langauge Manage');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/language_manage.tpl');