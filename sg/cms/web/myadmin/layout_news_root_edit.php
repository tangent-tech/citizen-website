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
$smarty->assign('MyJS', 'layout_news_root_edit');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$LayoutNewsRoot = layout_news::GetLayoutNewsRootInfo($_REQUEST['id']);
if ($LayoutNewsRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);
$smarty->assign('LayoutNewsRoot', $LayoutNewsRoot);
$smarty->assign('TheObject', $LayoutNewsRoot);

$smarty->assign('TITLE', 'Edit Layout News Root');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_news_root_edit.tpl');