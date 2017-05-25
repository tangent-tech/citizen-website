<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_delete", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

$Product = product::GetProductInfo($ObjectLink['object_id'], 0);
if ($Product['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

if (!product::IsProductRemovable($ObjectLink['object_id']))
	AdminDie(ADMIN_ERROR_PRODUCT_IS_NOT_REMOVABLE, 'product_tree.php', __LINE__);

acl::ObjPermissionBarrier("delete", $Product, __FILE__, false);

$Site = site::GetSiteInfo($_SESSION['site_id']);
$smarty->assign('Site', $Site);

product::UpdateTimeStamp($Product['product_id']);
product::DeleteProduct($Product['object_id'], $Site);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_tree.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));