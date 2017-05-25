<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_preprocess_rule_list');
$smarty->assign('MyJS', 'discount_preprocess_rule_delete');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$PreprocessRule = discount::GetPreprocessRuleInfo($_REQUEST['id'], 0);
if ($PreprocessRule['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'discount_preprocess_rule_list.php', __LINE__);

if (!discount::DeletePreprocessRule($_REQUEST['id']))
	AdminDie(ADMIN_ERROR_DISCOUNT_RULE_IS_NOT_REMOVABLE, 'discount_preprocess_rule_list.php', __LINE__);
else
	header( 'Location: discount_preprocess_rule_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));