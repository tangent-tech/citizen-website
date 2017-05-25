<?php
// parameters:
//	product_brand_id
//	product_category_id - 0 for all
//	lang_id
//	security_level - 0
//	product_page_no
//	products_per_page
//	currency_id - default: site default currency

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ProductBrand = product::GetProductBrandInfo($_REQUEST['product_brand_id'], $_REQUEST['lang_id']);
if ($ProductBrand['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if ($_REQUEST['product_category_id'] != 0) {
	$ProductCat = product::GetProductCatInfo($_REQUEST['product_category_id'], $_REQUEST['lang_id']);
	if ($ProductCat['site_id'] != $Site['site_id'])
		APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);
}

if (!isset($_REQUEST['product_page_no']))
	$_REQUEST['product_page_no'] = 1;
if (!isset($_REQUEST['products_per_page']))
	$_REQUEST['products_per_page'] = 20;

$CurrencyObj = null;
$Currency = currency::GetCurrencyInfo($_REQUEST['currency_id'], $Site['site_id']);
if ($Currency != null)
	$CurrencyObj = (object) $Currency;

$TotalNoOfProducts = 0;
$ProductListXML = product::GetProductListXMLByProductBrandID($ProductBrand['product_brand_id'], $_REQUEST['product_category_id'], $_REQUEST['lang_id'], $_REQUEST['security_level'], $TotalNoOfProducts, $_REQUEST['product_page_no'], $_REQUEST['products_per_page'], $CurrencyObj, $Site);
$smarty->assign('ProductCatListXML', $ProductCatListXML);

$smarty->assign('TotalNoOfProducts', $TotalNoOfProducts);
$smarty->assign('ProductListXML', $ProductListXML);

$Data = $smarty->fetch('api/product_brand_get_product_list.tpl');
$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');