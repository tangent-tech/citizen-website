<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_product.php');

acl::AclBarrier("acl_product_root_link_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'product_root_link_real_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);
acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$ProductRootLink = product::GetProductRootLink($_REQUEST['link_id']);
if ($ProductRootLink == null || $ProductRootLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php', __LINE__);

$ProductRootLink['object_seo_url'] = object::GetSeoURL($ProductRootLink, '', $ProductRootLink['language_id'], $Site);
$smarty->assign('ProductRootLink', $ProductRootLink);
$smarty->assign('TheObject', $ProductRootLink);

$ProductRoots = product::GetProductRootList($Site);
$smarty->assign('ProductRoots', $ProductRoots);

$smarty->assign('TITLE', 'Edit Product Tree Link');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_root_link_real_edit.tpl');