<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_xml_product.php');

//header ("Content-Type:text/xml");
header("Content-type: text/xml");

$Node = null;
$status = 'ERROR';
$Node = object::GetObjectLinkInfo($_REQUEST['link_id']);

if ($Node == null || $Node['site_id'] != $_SESSION['site_id'])
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

if (!in_array($Node['object_type'], array ('PRODUCT','PRODUCT_CATEGORY', 'PRODUCT_SPECIAL_CATEGORY')))
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

if ($Node['object_type'] == 'PRODUCT') {
	acl::AclBarrier("acl_product_edit", __FILE__, true);
}
elseif ($Node['object_type'] == 'PRODUCT_CATEGORY') {
	acl::AclBarrier("acl_product_category_edit", __FILE__, true);
}
elseif ($Node['object_type'] == 'PRODUCT_SPECIAL_CATEGORY') {
	acl::AclBarrier("acl_product_category_special_edit", __FILE__, true);
}
acl::ObjPermissionBarrier("edit", $Node, __FILE__, true);

$query	=	"	UPDATE	object_link " .
			"	SET		object_name = '". aveEscT($_REQUEST['obj_name']) . "'" .
			"	WHERE	object_link_id = '" . intval($Node['object_link_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$status = 'ok';

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', $status);
$smarty->assign('msg', ADMIN_MSG_RENAME_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_tree_rename.tpl');