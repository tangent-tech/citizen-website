<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_layout_news.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'layout_news_category');
$smarty->assign('MyJS', 'layout_news_category_list');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$SiteLanguage = language::GetSiteLanguageRoot($_REQUEST['language_id'], $_SESSION['site_id']);
if ($SiteLanguage == null) {
	$_REQUEST['language_id'] = $SiteLanguageRoots[0]['language_id'];
	$SiteLanguage = $SiteLanguageRoots[0];
}
$smarty->assign('SiteLanguage', $SiteLanguage);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$LayoutNewsCategories = layout_news::GetLayoutNewsCategoryList($_REQUEST['language_id'], $_SESSION['site_id']);
$smarty->assign('LayoutNewsCategories', $LayoutNewsCategories);

$smarty->assign('TITLE', 'Layout News Category List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_news_category_list.tpl');