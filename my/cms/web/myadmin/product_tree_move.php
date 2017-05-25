<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_xml_product.php');

header ("Content-Type:text/xml");

acl::AclBarrier("acl_product_tree_move", __FILE__, true);

$status = 'ok';
$id = 0;
$link_id = 0;

$RefObjectLink = object::GetObjectLinkInfo($_REQUEST['ref_link_id']);
$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);

$AllowedObjectParent = array();

if ($ObjectLink['object_type'] == 'PRODUCT_CATEGORY') {
	$AllowedObjectParent = array('PRODUCT_ROOT', 'PRODUCT_CATEGORY');
	acl::AclBarrier("acl_product_category_move", __FILE__, true);
}
elseif ($ObjectLink['object_type'] == 'PRODUCT') {
	$AllowedObjectParent = array('PRODUCT_ROOT', 'PRODUCT_CATEGORY');
	acl::AclBarrier("acl_product_move", __FILE__, true);
}
elseif ($ObjectLink['object_type'] == 'PRODUCT_SPECIAL_CATEGORY') {
	$AllowedObjectParent = array('PRODUCT_ROOT_SPECIAL');
	acl::AclBarrier("acl_product_category_special_move", __FILE__, true);
}
else if ($ObjectLink['object_type'] == 'PRODUCT_ROOT') {
	$AllowedObjectParent = array('LIBRARY_ROOT');
	acl::AclBarrier("acl_product_category_move", __FILE__, true);
}
else
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

object::ValidateMoveObjectInTree($AllowedObjectParent, $ObjectLink, $RefObjectLink, $_REQUEST['move_type'], $_SESSION['site_id']);

//if ($ObjectLink['object_type'] == 'PRODUCT') {
//	$AllOldParentProductCats = product::GetAllProductCategoriesByProductID($ObjectLink['object_id'], 0);
//}

object::MoveObject($ObjectLink, $RefObjectLink, $_REQUEST['move_type']);
$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);
if ($ObjectLink['object_type'] == 'PRODUCT') {
	$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
	product::UpdateProductCategoryPreCalData($ObjectLink['parent_object_id'], $SiteLanguageRoots, $Site, $CurrencyList);
	product::UpdateAllProductCategoryPreCalDataByProductID($ObjectLink['object_id'], $SiteLanguageRoots, $Site, $CurrencyList);
}
else if ($ObjectLink['object_type'] == 'PRODUCT_CATEGORY') {
	$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
	product::UpdateProductCategoryPreCalData($ObjectLink['object_id'], $SiteLanguageRoots, $Site, $CurrencyList);
}

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', $status);
$smarty->assign('id', $id);
$smarty->assign('link_id', $link_id);
$smarty->assign('msg', ADMIN_MSG_UPDATE_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_tree_move.tpl');