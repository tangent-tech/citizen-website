<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_inventory.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'inventory');
$smarty->assign('CurrentTab2', 'stock_transaction_list');
$smarty->assign('MyJS', 'stock_hold_details');

$StockTransaction = inventory::GetStockTransactionInfo($_REQUEST['id']);
if ($StockTransaction['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'stock_transaction_list.php', __LINE__);
$smarty->assign('StockTransaction', $StockTransaction);

$StockTransactionProducts = inventory::GetStockTransactionProducts($_REQUEST['id'], $Site['site_default_language_id']);
$smarty->assign('StockTransactionProducts', $StockTransactionProducts);

$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/stock_hold_details.tpl');