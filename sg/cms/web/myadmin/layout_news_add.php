<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_layout_news.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_layout_news_add", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
//$smarty->assign('CurrentTab2', 'layout_news');
$smarty->assign('MyJS', 'layout_news_add');

$smarty->assign('CurrentLayoutNewsRootID', $_REQUEST['id']);

$LayoutNewsRoot = layout_news::GetLayoutNewsRootInfo($_REQUEST['id']);
if ($LayoutNewsRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news.php', __LINE__);
$smarty->assign('LayoutNewsRoot', $LayoutNewsRoot);

acl::ObjPermissionBarrier("add_children", $LayoutNewsRoot, __FILE__, false);

$NoOfLayoutNews = layout_news::GetNoOfLayoutNews($_SESSION['site_id']);
if ($NoOfLayoutNews >= $Site['site_module_layout_news_quota'])
	AdminDie(ADMIN_ERROR_LAYOUT_NEWS_QUOTA_FULL, 'layout_news.php', __LINE__);

$LayoutNewsCategories = layout_news::GetLayoutNewsCategoryList($LayoutNewsRoot['language_id'], $_SESSION['site_id']);
if (count($LayoutNewsCategories) == 0) {
	AdminDie(ADMIN_ERROR_NO_LAYOUT_NEWS_CATEGORY, 'layout_news_category_list.php?language_id=' . $LayoutNewsRoot['language_id'], __LINE__);
}
$smarty->assign('LayoutNewsCategories', $LayoutNewsCategories);

$Layouts = layout::GetLayoutList($_SESSION['site_id']);
$smarty->assign('Layouts', $Layouts);

$Albums = album::GetAlbumList($Site['album_root_id']);
$smarty->assign('Albums', $Albums);

$smarty->assign('TITLE', 'Add ' . $LayoutNewsRoot['layout_news_root_name']);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_news_add.tpl');