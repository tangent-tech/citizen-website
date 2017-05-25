<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_news.php');

acl::AclBarrier("acl_sitemap_edit", __FILE__, false);
acl::AclBarrier("acl_news_page_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'news_page_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);
acl::SetIsPublisherFlagForSmarty($ObjectLink);

$NewsPage = news::GetNewsPageInfo($ObjectLink['object_id']);
if ($NewsPage == null)
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$NewsPage['object_seo_url'] = object::GetSeoURL($NewsPage, '', $NewsPage, $Site);
$smarty->assign('NewsPage', $NewsPage);
$smarty->assign('TheObject', $NewsPage);

$NewsCategories = news::GetNewsCategoryList($ObjectLink['language_id'], $_SESSION['site_id']);
$smarty->assign('NewsCategories', $NewsCategories);

$NewsRootList = news::GetNewsRootList($ObjectLink['language_id'], $_SESSION['site_id']);
$smarty->assign('NewsRootList', $NewsRootList);

$smarty->assign('TITLE', 'Edit News Page');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/news_page_edit.tpl');