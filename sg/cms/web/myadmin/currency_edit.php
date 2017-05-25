<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_product.php');

$smarty->assign('CurrentTab', 'currency');
$smarty->assign('CurrentTab2', 'currency');
$smarty->assign('MyJS', 'currency_edit');

$Currency = currency::GetCurrencyInfo($_REQUEST['id'], $_SESSION['site_id']);
$smarty->assign('Currency', $Currency);

$IsCurrencyRemovable = currency::IsCurrencyRemovable($_REQUEST['id'], $_SESSION['site_id']);
$smarty->assign('IsCurrencyRemovable', $IsCurrencyRemovable);

$smarty->assign('TITLE', 'Edit Currency');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/currency_edit.tpl');