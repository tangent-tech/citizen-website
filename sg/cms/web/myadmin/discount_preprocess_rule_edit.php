<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');
require_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_preprocess_rule_list');
$smarty->assign('MyJS', 'discount_preprocess_rule_edit');

acl::AclBarrier("acl_module_discount_rule_show", __FILE__, false);

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$PreprocessRule = discount::GetPreprocessRuleInfo($_REQUEST['id'], 0);
if ($PreprocessRule['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'discount_preprocess_rule_list.php', __LINE__);
$smarty->assign('TheObject', $PreprocessRule);
$smarty->assign('PreprocessRule', $PreprocessRule);

acl::SetIsPublisherFlagForSmarty($PreprocessRule);

$PreprocessRuleData = array();
$Editor = array();
$EditorHTML = array();
foreach ($SiteLanguageRoots as $R) {
	discount::TouchPreprocessRuleData($_REQUEST['id'], $R['language_id']);
	$PreprocessRuleData[$R['language_id']] = discount::GetPreprocessRuleInfo($_REQUEST['id'], $R['language_id']);
	$Editor[$R['language_id']]	= new FCKeditor('ContentEditor' . $R['language_id']);
	$Editor[$R['language_id']]->BasePath = FCK_BASEURL;
	$Editor[$R['language_id']]->Value	= $PreprocessRuleData[$R['language_id']]['discount_preprocess_rule_desc'];
	$Editor[$R['language_id']]->Width	= '700';
	$Editor[$R['language_id']]->Height	= '400';
	$EditorHTML[$R['language_id']]	= $Editor[$R['language_id']]->Create();
}
$smarty->assign('PreprocessRuleData', $PreprocessRuleData);
$smarty->assign('EditorHTML', $EditorHTML);

$ItemConditionList = discount::GetPreprocessItemCondition($_REQUEST['id']);
$smarty->assign('ItemConditionList', $ItemConditionList);

$ItemExceptConditionList = discount::GetPreprocessItemExceptCondition($_REQUEST['id']);
$smarty->assign('ItemExceptConditionList', $ItemExceptConditionList);


$TotalBrandNo = 0;
$ProductBrandList = product::GetAllBrandList($Site['site_id'], $site['site_default_language_id'], $TotalBrandNo, 1, 999999, '');
$smarty->assign('ProductBrandList', $ProductBrandList);

$ProductCatSpecialList = product::GetProductCatSpecialList($Site['site_id'], 0);
$smarty->assign('ProductCatSpecialList', $ProductCatSpecialList);

$ProductCatList = product::GetProductCatList($Site['site_id'], 0);
$smarty->assign('ProductCatList', $ProductCatList);

$RuleGlobalQty = discount::GetPreprocessRuleQtyUsageForGlobal($_REQUEST['id']);
$smarty->assign('RuleGlobalQty', $RuleGlobalQty);

$DiscountText = $PreprocessRule['discount_preprocess_rule_discount_code'];
$DiscountText = substr($DiscountText, 2, -2);
$smarty->assign('DiscountText', $DiscountText);

$RulePriceList = discount::GetPreprocessRulePriceList($_REQUEST['id'], $Site);
$smarty->assign('RulePriceList', $RulePriceList);

$smarty->assign('TITLE', 'Edit Discount Preprocess Rule');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/discount_preprocess_rule_edit.tpl');