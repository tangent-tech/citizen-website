<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_xml_product.php');

header ("Content-Type:text/xml");

$status = 'ok';

$RefObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);

$NewObjectID = 0;
$NewObjectLinkID = 0;

if ($RefObjectLink['site_id'] != $_SESSION['site_id'])
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

if ($_REQUEST['object_type'] == 'PRODUCT_CATEGORY' || $_REQUEST['object_type'] == 'PRODUCT_GROUP') {
	acl::AclBarrier("acl_product_category_duplicate", __FILE__, true);

	$ProductCat = product::GetProductCatInfo($RefObjectLink['object_id'], 0);
	$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);
	product::CloneProductCategoryWithSharedProducts($ProductCat, $Site, $RefObjectLink['parent_object_id'], $NewObjectID, $NewObjectLinkID, 'Y', 'Y', $Site, $CurrencyList);
}
else {
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
}

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('id', $NewObjectID);
$smarty->assign('link_id', $NewObjectLinkID);

$smarty->assign('status', $status);
$smarty->assign('msg', ADMIN_MSG_NEW_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_tree_duplicate.tpl');