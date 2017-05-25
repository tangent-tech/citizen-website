<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_product.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_root_list');

$ProductRoots = product::GetProductRootList($Site);
$smarty->assign('ProductRoots', $ProductRoots);

$smarty->assign('TITLE', 'Product Root List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_root_list.tpl');