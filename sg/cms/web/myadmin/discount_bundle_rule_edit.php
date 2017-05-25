<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');
require_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_bundle_rule_list');
$smarty->assign('MyJS', 'discount_bundle_rule_edit');

acl::AclBarrier("acl_module_discount_rule_show", __FILE__, false);

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$BundleRule = discount::GetBundleRuleInfo($_REQUEST['id'], 0);
if ($BundleRule['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'discount_bundle_rule_list.php', __LINE__);
$smarty->assign('TheObject', $BundleRule);
$smarty->assign('BundleRule', $BundleRule);

acl::SetIsPublisherFlagForSmarty($BundleRule);

$BundleRuleData = array();
$Editor = array();
$EditorHTML = array();
foreach ($SiteLanguageRoots as $R) {
	discount::TouchBundleRuleData($_REQUEST['id'], $R['language_id']);
	$BundleRuleData[$R['language_id']] = discount::GetBundleRuleInfo($_REQUEST['id'], $R['language_id']);
	$Editor[$R['language_id']]	= new FCKeditor('ContentEditor' . $R['language_id']);
	$Editor[$R['language_id']]->BasePath = FCK_BASEURL;
	$Editor[$R['language_id']]->Value	= $BundleRuleData[$R['language_id']]['discount_bundle_rule_desc'];
	$Editor[$R['language_id']]->Width	= '700';
	$Editor[$R['language_id']]->Height	= '400';
	$EditorHTML[$R['language_id']]	= $Editor[$R['language_id']]->Create();
}
$smarty->assign('BundleRuleData', $BundleRuleData);
$smarty->assign('EditorHTML', $EditorHTML);

$BundleRulePriceList = discount::GetBundleRulePriceList($_REQUEST['id'], $Site);
$smarty->assign('BundleRulePriceList', $BundleRulePriceList);

$ItemCostAwareConditionList = discount::GetBundleItemCostAwareCondition($_REQUEST['id']);
$smarty->assign('ItemCostAwareConditionList', $ItemCostAwareConditionList);

$ItemFreeConditionList = discount::GetBundleItemFreeCondition($_REQUEST['id']);
$smarty->assign('ItemFreeConditionList', $ItemFreeConditionList);

$ProductCatSpecialList = product::GetProductCatSpecialList($Site['site_id'], 0);
$smarty->assign('ProductCatSpecialList', $ProductCatSpecialList);

$ProductCatList = product::GetProductCatList($Site['site_id'], 0);
$smarty->assign('ProductCatList', $ProductCatList);

$RuleGlobalQty = discount::GetBundleRuleQtyUsageForGlobal($_REQUEST['id']);
$smarty->assign('RuleGlobalQty', $RuleGlobalQty);

$DiscountText = $BundleRule['discount_bundle_rule_discount_code'];
$DiscountText = substr($DiscountText, 2, -2);
$smarty->assign('DiscountText', $DiscountText);

$smarty->assign('TITLE', 'Edit Discount Bundle Rule');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/discount_bundle_rule_edit.tpl');