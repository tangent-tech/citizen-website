<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_bundle_rule_list');
$smarty->assign('MyJS', 'discount_bundle_rule_add');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$smarty->assign('TITLE', 'Add Discount Bundle Rule');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/discount_bundle_rule_add.tpl');