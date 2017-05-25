<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_product.php');

acl::AclBarrier("acl_product_tree_list", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_tree_special');

//$ValidObjectList = array('PRODUCT', 'PRODUCT_CATEGORY', 'PRODUCT_SPECIAL_CATEGORY', 'PRODUCT_ROOT', 'PRODUCT_ROOT_SPECIAL');
$ValidObjectList = array('PRODUCT_SPECIAL_CATEGORY', 'PRODUCT_ROOT_SPECIAL');

$ProductTree = '';
site::GetSiteTreeForMyAdmin($ProductTree, $ValidObjectList, $Site['library_root_id'], 0, 'ALL', 'ALL');
$smarty->assign('ProductTree', $ProductTree);

$smarty->assign('TITLE', 'Special Category');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_tree_special.tpl');