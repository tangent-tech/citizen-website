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
$smarty->assign('MyJS', 'stock_transaction_list');

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

$TotalTransactions = 0;

$StockTransactionList = inventory::GetStockTransactionList($Site['site_id'], $TotalTransactions, $_REQUEST['page_id'], NUM_OF_TRANSACTIONS_PER_PAGE);
$smarty->assign('StockTransactionList', $StockTransactionList);

$NoOfPage = ceil($TotalTransactions / NUM_OF_TRANSACTIONS_PER_PAGE);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$smarty->assign('TITLE', 'Stock Transaction List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/stock_transaction_list.tpl');