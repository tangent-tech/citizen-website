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
$smarty->assign('MyJS', 'stock_transaction_delete');

$StockTransaction = inventory::GetStockTransactionInfo($_REQUEST['id']);
if ($StockTransaction['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'stock_transaction_list.php', __LINE__);

if ($StockTransaction['stock_transaction_type'] != 'STOCK_IN' && $StockTransaction['stock_transaction_type'] != 'ADJUSTMENT')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'stock_transaction_list.php', __LINE__);
	
inventory::DeleteStockTransaction($_REQUEST['id']);

site::EmptyAPICache($_SESSION['site_id']);
header( 'Location: stock_transaction_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));