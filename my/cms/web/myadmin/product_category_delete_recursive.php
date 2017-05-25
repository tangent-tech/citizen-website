<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');

acl::AclBarrier("acl_product_category_delete", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'folder_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php');
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("delete", $ObjectLink, __FILE__, false);

product::DeleteProductCatRecursive($ObjectLink['object_id'], $Site);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_tree.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));