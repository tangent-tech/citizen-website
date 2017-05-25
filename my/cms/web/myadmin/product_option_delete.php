<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');

acl::AclBarrier("acl_product_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_option_edit_act');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);

if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$Product = product::GetProductInfo($ObjectLink['object_id'], 0);
if ($Product['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);
$smarty->assign('Product', $Product);

$ProductOption = product::GetProductOptionInfo($_REQUEST['id'], 0);
if ($ProductOption['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

if (!product::IsProductOptionRemovable($_REQUEST['id']))
	AdminDie(ADMIN_ERROR_PRODUCT_OPTION_IS_NOT_REMOVABLE, 'product_tree.php', __LINE__);

$Site = site::GetSiteInfo($_SESSION['site_id']);
$smarty->assign('Site', $Site);

product::UpdateTimeStamp($Product['product_id']);
product::DeleteProductOption($_REQUEST['id']);

header( 'Location: product_edit.php?link_id=' . $_REQUEST['link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));