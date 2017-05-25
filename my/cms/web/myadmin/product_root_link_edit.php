<?php

die('This script has been phased out');

define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_product.php');

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'product_root_link_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$smarty->assign('ObjectLink', $ObjectLink);

$ProductRoot = product::GetProductRootByObjLinkID($_REQUEST['link_id']);
if ($ProductRoot == null || $ProductRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$ProductRoot['object_seo_url'] = object::GetSeoURL($ProductRoot, '', $ProductRoot['language_id'], $Site);
$smarty->assign('ProductRoot', $ProductRoot);
$smarty->assign('TheObject', $ProductRoot);

$ProductRoots = product::GetProductRootList($Site);
$smarty->assign('ProductRoots', $ProductRoots);

$smarty->assign('TITLE', 'Edit Product Tree Link');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_root_link_edit.tpl');