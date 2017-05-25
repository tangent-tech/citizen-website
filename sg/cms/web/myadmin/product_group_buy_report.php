<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_group_buy_report');

if ($Site['site_module_group_buy_enable'] != 'Y')
	AdminDie(ADMIN_MSG_MODULE_DISABLED_GROUP_BUY, 'product_tree.php', __LINE__);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

$Product = product::GetProductInfo($ObjectLink['object_id'], 0);
if ($Product['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);
$smarty->assign('Product', $Product);

$OrderList = cart::GetMyOrderItemListByProductID($Product['product_id']);

$PrintOrderList = array();

foreach ($OrderList as $O) {

	for ($i = 1; $i <= $O['quantity']; $i++) {
		$PrintOrder = $O;
		$PrintOrder['QuantityNo'] = $i;
		
		$PrintOrder['SecurityCode1'] = product::GetSecurityCode1($O['myorder_id'], $Site['site_api_key'], $Product['object_id'], $i);
		$PrintOrder['SecurityCode2'] = product::GetSecurityCode2($O['myorder_id'], $Site['site_api_key'], $Product['object_id'], $i);
		array_push($PrintOrderList, $PrintOrder);
	}
}
$smarty->assign('PrintOrderList', $PrintOrderList);

$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_group_buy_report.tpl');