<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');

acl::AclBarrier("acl_product_root_link_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'product_root_link_real_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$ProductRootLink = product::GetProductRootLink($ObjectLink['object_link_id']);
if ($ProductRootLink == null)
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php', __LINE__);

$NewProductRoot = product::GetProductRootInfo($_REQUEST['product_root_id']);
if ($NewProductRoot == null || $NewProductRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php', __LINE__);

object::UpdateObjectSEOData($ObjectLink['object_id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($ObjectLink['object_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

$query =	"	UPDATE	product_root_link " .
			"	SET		product_root_id			=	'" . intval($_REQUEST['product_root_id']) . "'" .
			"	WHERE	product_root_link_id	=	'" . intval($ObjectLink['object_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::UpdateObjectTimeStamp($ObjectLink['object_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_root_link_real_edit.php?link_id=' . $_REQUEST['link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));