<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_layout_news.php');

acl::AclBarrier("acl_sitemap_edit", __FILE__, false);
acl::AclBarrier("acl_layout_news_page_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'layout_news_page_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$smarty->assign('ObjectLink', $ObjectLink);
$smarty->assign('TheObject', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);
acl::SetIsPublisherFlagForSmarty($ObjectLink);

$LayoutNewsPage = layout_news::GetLayoutNewsPageInfo($ObjectLink['object_id']);
if ($LayoutNewsPage == null)
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$smarty->assign('LayoutNewsPage', $LayoutNewsPage);
$smarty->assign('TheObject', $LayoutNewsPage);

$LayoutNewsCategories = layout_news::GetLayoutNewsCategoryList($ObjectLink['language_id'], $_SESSION['site_id']);
$smarty->assign('LayoutNewsCategories', $LayoutNewsCategories);

$LayoutNewsRootList = layout_news::GetLayoutNewsRootList($ObjectLink['language_id'], $_SESSION['site_id']);
$smarty->assign('LayoutNewsRootList', $LayoutNewsRootList);

$smarty->assign('TITLE', 'Edit Layout News Page');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_news_page_edit.tpl');