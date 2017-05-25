<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_postprocess_rule_list');
$smarty->assign('MyJS', 'discount_postprocess_rule_list');

acl::AclBarrier("acl_module_discount_rule_show", __FILE__, false);

$DiscountPostprocessRuleList = discount::GetPostprocessRuleList($Site['site_id'], 'ALL', 999999, false, false, null, -1);
$smarty->assign('DiscountPostprocessRuleList', $DiscountPostprocessRuleList);

$smarty->assign('TITLE', 'Discount Postprocess Rule List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/discount_postprocess_rule_list.tpl');