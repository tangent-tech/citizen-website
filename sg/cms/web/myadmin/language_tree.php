<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_article.php');

acl::AclBarrier("acl_module_sitemap_show", __FILE__);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'language_tree');

$SiteLanguageRoot = language::GetSiteLanguageRoot($_REQUEST['id'], $Site['site_id']);
$smarty->assign('SiteLanguageRoot', $SiteLanguageRoot);

$ProductRoots = product::GetProductRootList($Site);
$smarty->assign('ProductRoots', $ProductRoots);

$Albums = album::GetAlbumList($Site['album_root_id']);
$smarty->assign('Albums', $Albums);

$NewsRoots = news::GetNewsRootList($_REQUEST['id'], $_SESSION['site_id']);
$smarty->assign('NewsRoots', $NewsRoots);

$LayoutNewsRoots = layout_news::GetLayoutNewsRootList($_REQUEST['id'], $_SESSION['site_id']);
$smarty->assign('LayoutNewsRoots', $LayoutNewsRoots);

$LanguageRootHTML = '';
site::GetSiteTreeForMyAdmin($LanguageRootHTML, $LanguageTreeObjectTypeList, $SiteLanguageRoot['language_root_id'], 999999, 'ALL', 'N');
$smarty->assign('LanguageRootHTML', $LanguageRootHTML);

$smarty->assign('TITLE', 'Language Tree');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/language_tree.tpl' );
