<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_root_edit');

acl::AclBarrier("acl_product_root_edit", __FILE__, false);

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_root_list.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

foreach ($SiteLanguageRoots as $R) {
	$ProductRootData[$R['language_id']] = product::GetProductRootInfo($ObjectLink['object_id'], $R['language_id']);
}
$smarty->assign('ProductRootData', $ProductRootData);

$smarty->assign('TITLE', 'Edit Product Root');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_root_edit.tpl');