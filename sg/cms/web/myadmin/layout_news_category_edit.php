<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_layout_news.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_layout_news_category_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'layout_news_category');
$smarty->assign('MyJS', 'layout_news_category_edit');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$LayoutNewsCategory = layout_news::GetLayoutNewsCategoryInfo($_REQUEST['id']);
if ($LayoutNewsCategory['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news_category_list.php', __LINE__);
$smarty->assign('LayoutNewsCategory', $LayoutNewsCategory);
$smarty->assign('TheObject', $LayoutNewsCategory);

$_REQUEST['language_id'] = $LayoutNewsCategory['language_id'];

$smarty->assign('TITLE', 'Edit Layout News Category');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_news_category_edit.tpl');