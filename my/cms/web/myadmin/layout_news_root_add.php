<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_layout_news.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'layout_news_root');
$smarty->assign('MyJS', 'layout_news_root_add');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$SiteLanguage = language::GetSiteLanguageRoot($_REQUEST['language_id'], $_SESSION['site_id']);
if ($SiteLanguage == null)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguage', $SiteLanguage);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$smarty->assign('TITLE', 'Add Layout News Root');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_news_root_add.tpl');