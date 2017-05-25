<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_news.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_news_category_add", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'news');
$smarty->assign('MyJS', 'news_category_add');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$SiteLanguage = language::GetSiteLanguageRoot($_REQUEST['language_id'], $_SESSION['site_id']);
if ($SiteLanguage == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);
$smarty->assign('SiteLanguage', $SiteLanguage);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$NewsCategoryID = object::NewObject('NEWS_CATEGORY', $_SESSION['site_id'], 0);
news::NewNewsCategory($NewsCategoryID, $_REQUEST['news_category_name'], $_REQUEST['language_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: news_category_edit.php?id=' . $NewsCategoryID .  '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));