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

$smarty->assign('TITLE', 'Langauge Tree Copy');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/language_tree_copy.tpl');