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
$smarty->assign('MyJS', 'layout_news_root_add_act');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$SiteLanguage = language::GetSiteLanguageRoot($_REQUEST['language_id'], $_SESSION['site_id']);
if ($SiteLanguage == null)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$LayoutNewsRootID = object::NewObject('LAYOUT_NEWS_ROOT', $_SESSION['site_id'], 0);
layout_news::NewLayoutNewsRoot($LayoutNewsRootID, $_REQUEST['layout_news_root_name'], $_REQUEST['language_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: layout_news_root_edit.php?id=' . $LayoutNewsRootID .  '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));