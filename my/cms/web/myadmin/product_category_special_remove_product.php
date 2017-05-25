<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_category_special_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_category_special_remove_product');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

$Product = product::GetProductInfo($ObjectLink['object_id'], 0);
if ($Product['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

$ProductCatObjectLink = object::GetObjectLinkInfo($_REQUEST['cat_link_id']);
if ($ProductCatObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

$ProductCatSpecial = product::GetProductCatSpecialInfo($ProductCatObjectLink['object_id'], 0);
if ($ProductCatSpecial['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

acl::ObjPermissionBarrier("edit", $ProductCatSpecial, __FILE__, false);

$query =	"	UPDATE	product " .
			"	SET		is_special_cat_" . $ProductCatSpecial['product_category_special_no'] . " = 'N' " .
			"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	DELETE FROM	object_link " .
			"	WHERE		parent_object_id	= '" . intval($ProductCatSpecial['product_category_special_id']) . "'" .
			"			AND	object_id 			= '" . intval($Product['product_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
object::TidyUpObjectOrder($ProductCatSpecial['product_category_special_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_category_special_edit.php?link_id=' . $_REQUEST['cat_link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));