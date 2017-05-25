<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_layout_news.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

die("Should be outdated");

acl::AclBarrier("acl_layout_news_list", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'layout_news');
$smarty->assign('MyJS', 'layout_news');

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

$LayoutNewsRoots = layout_news::GetLayoutNewsRootList($_REQUEST['language_id'], $_SESSION['site_id']);
$smarty->assign('LayoutNewsRoots', $LayoutNewsRoots);

$smarty->assign('TITLE', 'Layout News Group List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_news.tpl');
?>
