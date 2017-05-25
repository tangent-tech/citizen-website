<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_product_link_update_status');
$smarty->assign('MyJS', 'discount_product_link_update_status');

acl::AclBarrier("acl_module_discount_rule_show", __FILE__, false);

$smarty->assign('TITLE', 'Product Tagging Status');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/discount_product_link_update_status.tpl');