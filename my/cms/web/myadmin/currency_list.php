<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_product.php');

$smarty->assign('CurrentTab', 'currency');
$smarty->assign('CurrentTab2', 'currency');
$smarty->assign('MyJS', 'currency_list');

$SiteCurrencyList = currency::GetAllSiteCurrencyList($_SESSION['site_id']);
$smarty->assign('SiteCurrencyList', $SiteCurrencyList);

$SiteCurrencyListNotEnabled = currency::GetAllSiteCurrencyList_NotEnabled($_SESSION['site_id']);
$smarty->assign('SiteCurrencyListNotEnabled', $SiteCurrencyListNotEnabled);

$smarty->assign('TITLE', 'Currency List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/currency_list.tpl');