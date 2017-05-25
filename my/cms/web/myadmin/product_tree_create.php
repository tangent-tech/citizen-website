<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_xml_product.php');

header ("Content-Type:text/xml");

$status = 'ok';
$id = 0;
$link_id = 0;

$RefObjectLink = object::GetObjectLinkInfo($_REQUEST['ref_link_id']);

// var_dump($RefObjectLink);
// die();

if ($_REQUEST['new_object_type'] == 'PRODUCT_CATEGORY') {
	acl::AclBarrier("acl_product_category_add", __FILE__, true);
	
	object::ValidateCreateObjectInTree(array('PRODUCT_ROOT', 'PRODUCT_CATEGORY'), $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id'], true, $_REQUEST['new_object_type']);
	
	object::CreateObjectInTree($_REQUEST['new_object_type'], $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id'], $id, $link_id);
	product::NewProductCat($id, '');
}
elseif ($_REQUEST['new_object_type'] == 'PRODUCT') {
	acl::AclBarrier("acl_product_add", __FILE__, true);	
	
	$NoOfProducts = product::GetNoOfProduct($_SESSION['site_id']);
	if ($NoOfProducts >= $Site['site_module_product_quota'])
		XMLDie(__LINE__, ADMIN_ERROR_PRODUCT_QUOTA_FULL);	
	
	object::ValidateCreateObjectInTree(array('PRODUCT_ROOT', 'PRODUCT_CATEGORY'), $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id'], true, $_REQUEST['new_object_type']);
	object::CreateObjectInTree($_REQUEST['new_object_type'], $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id'], $id, $link_id);
	
	product::NewProduct($id);
}
else {
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
}

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', $status);
$smarty->assign('id', $id);
$smarty->assign('link_id', $link_id);
$smarty->assign('msg', ADMIN_MSG_NEW_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_tree_create.tpl');