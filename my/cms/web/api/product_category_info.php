<?php
// parameters:
//	link_id
//	page_no - deprecated
//	product_page_no
//	products_per_page
//	media_page_no
//	media_per_page
//	datafile_page_no
//	datafile_per_page
//	lang_id
//	security_level
//	product_order_by : order_id, product_custom_*_1 to 20
//	product_order_type : ASC / DESC
//	category_order_by : order_id, product_category_custom_*_1 to 20
//	category_order_type : ASC / DESC
//	tag
//	include_product_details
//	include_media_details
//	include_datafile_details
//	include_product_brand_details
//	max_depth = 2 - default
//	currency_id - default (site_default_currency)
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if (!isset($_REQUEST['product_page_no']))
	$_REQUEST['product_page_no'] = 1;
if (intval($_REQUEST['page_no']) > 0)
	$_REQUEST['product_page_no'] = intval($_REQUEST['page_no']);
if (!isset($_REQUEST['products_per_page']))
	$_REQUEST['products_per_page'] = 999999;

if (!isset($_REQUEST['media_page_no']))
	$_REQUEST['media_page_no'] = 1;
if (!isset($_REQUEST['media_per_page']))
	$_REQUEST['media_per_page'] = 999999;

if (!isset($_REQUEST['datafile_page_no']))
	$_REQUEST['datafile_page_no'] = 1;
if (!isset($_REQUEST['datafile_per_page']))
	$_REQUEST['datafile_per_page'] = 999999;


$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$ProductOrderBy = 'OL.order_id ';
if ($_REQUEST['product_order_by'] == 'order_id')
	$ProductOrderBy = 'OL.order_id ';
for ($i = 1; $i <= 20; $i++) {
	if ($_REQUEST['product_order_by'] == 'product_custom_int_' . $i) {
		$ProductOrderBy = 'P.product_custom_int_' . $i;
		$i = 99;
	}
	elseif ($_REQUEST['product_order_by'] == 'product_custom_double_' . $i) {
		$ProductOrderBy = 'P.product_custom_double_' . $i;
		$i = 99;
	}
	elseif ($_REQUEST['product_order_by'] == 'product_custom_date_' . $i) {
		$ProductOrderBy = 'P.product_custom_date_' . $i;
		$i = 99;		
	}
	elseif ($_REQUEST['product_order_by'] == 'product_custom_text_' . $i) {
		$ProductOrderBy = 'D.product_custom_text_' . $i;
		$i = 99;		
	}
}
if ($_REQUEST['product_order_type'] == 'ASC')
	$ProductOrderBy = $ProductOrderBy . " ASC";
else
	$ProductOrderBy = $ProductOrderBy . " DESC";

$CategoryOrderBy = 'OL.order_id ';
if ($_REQUEST['category_order_by'] == 'order_id')
	$CategoryOrderBy = 'OL.order_id ';
for ($i = 1; $i <= 20; $i++) {
	if ($_REQUEST['category_order_by'] == 'product_category_custom_int_' . $i) {
		$ProductOrderBy = 'C.product_category_custom_int_' . $i;
		$i = 99;
	}
	elseif ($_REQUEST['category_order_by'] == 'product_category_custom_double_' . $i) {
		$ProductOrderBy = 'C.product_category_custom_double_' . $i;
		$i = 99;
	}
	elseif ($_REQUEST['category_order_by'] == 'product_category_custom_date_' . $i) {
		$ProductOrderBy = 'C.product_category_custom_date_' . $i;
		$i = 99;
	}
	elseif ($_REQUEST['category_order_by'] == 'product_category_custom_text_' . $i) {
		$ProductOrderBy = 'D.product_category_custom_text_' . $i;
		$i = 99;
	}
}
if ($_REQUEST['category_order_type'] == 'ASC')
	$CategoryOrderBy = $CategoryOrderBy . " ASC";
else
	$CategoryOrderBy = $CategoryOrderBy . " DESC";

if (!isset($_REQUEST['max_depth']))
	$_REQUEST['max_depth'] = 2;

$Object = null;
if ($ObjectLink['object_type'] == 'PRODUCT_ROOT')
	$Object = product::GetProductRootInfo($ObjectLink['object_id']);
elseif ($ObjectLink['object_type'] == 'PRODUCT_ROOT_LINK')
	$Object = product::GetProductRootLink($ObjectLink['object_link_id']);
elseif ($ObjectLink['object_type'] == 'PRODUCT_SPECIAL_CATEGORY') {
	$Object = product::GetProductCatSpecialInfo($ObjectLink['object_id'], $_REQUEST['lang_id']);
}
else
	$Object = product::GetProductCatInfo($ObjectLink['object_id'], $_REQUEST['lang_id']);

$CurrencyObj = null;
$Currency = currency::GetCurrencyInfo($_REQUEST['currency_id'], $Site['site_id']);
if ($Currency != null)
	$CurrencyObj = (object) $Currency;

$XML = product::GetProductCategoryXML($Object, $_REQUEST['lang_id'], $_REQUEST['security_level'], $_REQUEST['tag'], $_REQUEST['product_page_no'], $_REQUEST['products_per_page'], $CategoryOrderBy, $ProductOrderBy, ynval($_REQUEST['include_product_details']), ynval($_REQUEST['include_media_details']), $_REQUEST['media_page_no'], $_REQUEST['media_per_page'], 1, $_REQUEST['max_depth'], $_REQUEST['include_datafile_details'], $_REQUEST['datafile_page_no'], $_REQUEST['datafile_per_page'], $CurrencyObj, $Site, $_REQUEST['include_product_brand_details']);

$smarty->assign('Data', $XML);
$smarty->display('api/api_result.tpl');