<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_article.php');

acl::AclBarrier("acl_siteblock_list", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'siteblock');
$smarty->assign('MyJS', 'siteblock');

$BlockDefs = block::GetBlockDefListBySiteBlockHolderRootID($Site['site_block_holder_root_id']);
$smarty->assign('BlockDefs', $BlockDefs);

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

$BlockContents = array();
foreach ($BlockDefs as $key => $value) {
	block::TouchBlockHolderList(0, $value['block_definition_id'], $_SESSION['site_id'], $_REQUEST['language_id']);
	$BlockContentList = block::GetSiteBlockContentListBySiteID($_SESSION['site_id'], $value['block_definition_id'], $_REQUEST['language_id'], 'ALL');
	$BlockContents[$value['block_definition_id']] = $BlockContentList;
}
$smarty->assign('BlockContents', $BlockContents);

$smarty->assign('TITLE', 'Site Block');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/siteblock.tpl');