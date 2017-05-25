<?php
// parameters:
//	link_id
//	lang_id
//	page_no <- deprecated
//	media_page_no
//	media_per_page
//	datafile_page_no
//	datafile_per_page
//	include_product_brand_details
//	security_level - default: 999999
//	currency_id - default: site default currency

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if (!isset($_REQUEST['media_page_no']))
	$_REQUEST['media_page_no'] = 1;
if (intval($_REQUEST['page_no']) > 0)
	$_REQUEST['media_page_no'] = intval($_REQUEST['page_no']);
if (!isset($_REQUEST['media_per_page']))
	$_REQUEST['media_per_page'] = 999999;
if (!isset($_REQUEST['datafile_page_no']))
	$_REQUEST['datafile_page_no'] = 1;
if (!isset($_REQUEST['datafile_per_page']))
	$_REQUEST['datafile_per_page'] = 999999;
if (!isset($_REQUEST['security_level']))
	$_REQUEST['security_level'] = 999999;

$CurrencyObj = null;
$Currency = currency::GetCurrencyInfo($_REQUEST['currency_id'], $Site['site_id']);
if ($Currency != null)
	$CurrencyObj = (object) $Currency;

$ProductXML = product::GetProductXML($ObjectLink['object_link_id'], $_REQUEST['lang_id'], true, intval($_REQUEST['media_page_no']), intval($_REQUEST['media_per_page']), intval($_REQUEST['security_level']), true, $_REQUEST['datafile_page_no'], $_REQUEST['datafile_per_page'], true, null, $CurrencyObj, $Site, false, null, null, $_REQUEST['include_product_brand_details']);

$smarty->assign('Data', $ProductXML);
$smarty->display('api/api_result.tpl');