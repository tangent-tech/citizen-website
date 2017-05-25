<?php
// parameters:
//	link_id
//	parent_object_id
//	no_of_adjacent_products
//	security_level
//	lang_id
//	tag - empty for all
//	include_product_details
//	order_by_field - Default: order_id. Other acceptable values: product_price, product_price2, product_price3, product_custom_date_1, product_custom_date_2, product_custom_date_3, product_custom_date_4, product_custom_date_5 
//	group_function - default: min, possible values: min, max, avg
//	currency_id - default: site default currency

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if (intval($_REQUEST['no_of_adjacent_products']) <= 0)
	$_REQUEST['no_of_adjacent_products'] = 1;

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$ValidOrderByFields = array("product_price", "product_price2", "product_price3", "product_custom_date_1", "product_custom_date_2", "product_custom_date_3", "product_custom_date_4", "product_custom_date_5" );

if (!isset($_REQUEST['order_by_field']) || !in_array($_REQUEST['order_by_field'], $ValidOrderByFields))
	$_REQUEST['order_by_field']	= 'order_id';

$ValidGroupFuncFields = array("min", "max", "avg");
if (!isset($_REQUEST['group_function']) || !in_array($_REQUEST['group_function'], $ValidGroupFuncFields))
	$_REQUEST['group_function'] = 'min';

if (!isset($_REQUEST['parent_object_id'])) {
	$_REQUEST['parent_object_id'] = $ObjectLink['parent_object_id'];
}

$CurrencyObj = null;
$Currency = currency::GetCurrencyInfo($_REQUEST['currency_id'], $Site['site_id']);
if ($Currency != null)
	$CurrencyObj = (object) $Currency;

$NextProductsListXML = product::GetAdjacentProductsXML('Next', $ObjectLink, $_REQUEST['parent_object_id'], $_REQUEST['group_function'], $_REQUEST['tag'], $_REQUEST['security_level'], $_REQUEST['lang_id'], ynval($_REQUEST['include_product_details']), $_REQUEST['no_of_adjacent_products'], $_REQUEST['order_by_field'], $CurrencyObj, $Site);
$smarty->assign('NextProductsListXML', $NextProductsListXML);

$PreviousProductsListXML = product::GetAdjacentProductsXML('Prev', $ObjectLink, $_REQUEST['parent_object_id'], $_REQUEST['group_function'], $_REQUEST['tag'], $_REQUEST['security_level'], $_REQUEST['lang_id'], ynval($_REQUEST['include_product_details']), $_REQUEST['no_of_adjacent_products'], $_REQUEST['order_by_field'], $CurrencyObj, $Site);
$smarty->assign('PreviousProductsListXML', $PreviousProductsListXML);

$Data = $smarty->fetch('api/product_get_adjacent_product_list.tpl');
$smarty->assign('Data', $Data);

$smarty->display('api/api_result.tpl');