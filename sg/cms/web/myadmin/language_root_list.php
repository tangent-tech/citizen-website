<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_article.php');

// Disable this to have a default 2nd level tab to click for "Site Content" tab
// acl::AclBarrier("acl_module_sitemap_show", __FILE__);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'language_root_list');

$LanguageRootList = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'ALL', 'ALL');
$smarty->assign('LanguageRootList', $LanguageRootList);

$LanguageWithNoRootList = language::GetAllLanguageWithNoSiteLanguageRootList($_SESSION['site_id']);
$smarty->assign('LanguageWithNoRootList', $LanguageWithNoRootList);

$smarty->assign('TITLE', 'Langauge List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/language_root_list.tpl');