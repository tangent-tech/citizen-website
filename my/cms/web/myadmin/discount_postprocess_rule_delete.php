<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_postprocess_rule_list');
$smarty->assign('MyJS', 'discount_postprocess_rule_delete');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$PostprocessRule = discount::GetPostprocessRuleInfo($_REQUEST['id'], 0);		
if ($PostprocessRule['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'discount_postprocess_rule_list.php', __LINE__);
$smarty->assign('TheObject', $PostprocessRule);
$smarty->assign('PostprocessRule', $PostprocessRule);

if (!discount::DeletePostprocessRule($_REQUEST['id']))
	AdminDie(ADMIN_ERROR_DISCOUNT_RULE_IS_NOT_REMOVABLE, 'discount_postprocess_rule_list.php', __LINE__);
else
	header( 'Location: discount_postprocess_rule_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));