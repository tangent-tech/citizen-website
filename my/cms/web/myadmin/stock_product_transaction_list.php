<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_inventory.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'inventory');
$smarty->assign('CurrentTab2', 'stock_list');
$smarty->assign('MyJS', 'stock_product_transaction_list');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

$Product = product::GetProductInfo($ObjectLink['object_id'], $Site['site_default_language_id']);
if ($Product['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

if (intval($_REQUEST['poid']) != 0) {
	$ProductStockOption = product::GetProductOptionInfo($_REQUEST['poid'], $Site['site_default_language_id']);
	$Product = array_merge($ProductStockOption, $Product);
}
$smarty->assign('Product', $Product);

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

$TotalTransactions = 0;

$ProductStockTransactionList = inventory::GetProductStockTransactionList($Product['product_id'], intval($_REQUEST['poid']), $TotalTransactions, $_REQUEST['page_id'], NUM_OF_TRANSACTIONS_PER_PAGE);
$smarty->assign('ProductStockTransactionList', $ProductStockTransactionList);

$NoOfPage = ceil($TotalTransactions / NUM_OF_TRANSACTIONS_PER_PAGE);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$smarty->assign('TITLE', 'Product Stock Transaction List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/stock_product_transaction_list.tpl');