<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_postprocess_rule_list');
$smarty->assign('MyJS', 'discount_postprocess_rule_edit');

acl::AclBarrier("acl_module_discount_rule_show", __FILE__, false);

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$PostprocessRule = discount::GetPostprocessRuleInfo($_REQUEST['id'], 0);
if ($PostprocessRule['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'discount_postprocess_rule_list.php', __LINE__);
$smarty->assign('TheObject', $PostprocessRule);
$smarty->assign('PostprocessRule', $PostprocessRule);

acl::SetIsPublisherFlagForSmarty($PostprocessRule);

$PostprocessRuleData = array();
foreach ($SiteLanguageRoots as $R) {
	discount::TouchPostprocessRuleData($_REQUEST['id'], $R['language_id']);
	$PostprocessRuleData[$R['language_id']] = discount::GetPostprocessRuleInfo($_REQUEST['id'], $R['language_id']);
}
$smarty->assign('PostprocessRuleData', $PostprocessRuleData);

$RulePriceInfoList = discount::GetPostprocessDiscountPriceInfoList($_REQUEST['id'], $Site);
$smarty->assign('RulePriceInfoList', $RulePriceInfoList);

$RuleGlobalQty = discount::GetPostprocessRuleUsageForGlobal($_REQUEST['id']);
$smarty->assign('RuleGlobalQty', $RuleGlobalQty);

$DiscountText = $PostprocessRule['discount_postprocess_rule_discount_code'];
$DiscountText = substr($DiscountText, 2, -2);
$smarty->assign('DiscountText', $DiscountText);

$smarty->assign('TITLE', 'Edit Discount Postprocess Rule');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/discount_postprocess_rule_edit.tpl');