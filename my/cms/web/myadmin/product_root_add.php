<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_product.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_root_add');

$smarty->assign('TITLE', 'Add Product Root');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_root_add.tpl');