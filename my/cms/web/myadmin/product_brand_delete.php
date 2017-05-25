<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_brand_manage", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_brand_delete');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

$ProductBrand = product::GetProductBrandInfo($ObjectLink['object_id'], 0);
if ($ProductBrand['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_brand_list.php', __LINE__);

product::UpdateTimeStampProductBrand($ProductBrand['product_brand_id']);
product::DeleteProductBrand($ProductBrand['product_brand_id'], $Site);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_brand_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));