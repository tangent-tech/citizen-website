<?php
// parameters:
//	xml_url - xml url to be fetched
//	real_import - indicates if data is really written to database, set 'N' for error checking, default is 'N'
//	new_or_update - default = 'new'
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$IsContentAdmin = true;

$_REQUEST['real_import'] = ynval($_REQUEST['real_import']);

$xml_string = file_get_contents($_REQUEST['xml_url']);

if ($xml_string === false)
	APIDie(API_ERROR_FAIL_TO_READ_FILE);

libxml_use_internal_errors(true);
$xml = simplexml_load_string($xml_string);

$xml_parse_error_msg = '';
if ($xml === false) {
	foreach(libxml_get_errors() as $error)
		$xml_parse_error_msg .= $error->message;
	$ApiError = array('no' => 999,	'desc' => $xml_parse_error_msg);
	APIDie($ApiError);
}

$NoOfProductsParsed = 0;
$NoOfProductImported = 0;
$NoOfProductFailed = 0;
$gSuccessXMLString = '';
$gErrorXMLString = '';

$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);
foreach ($xml->xpath('/product_list/product') as $Product) {
	$SuccessXMLString = '';
	$ErrorXMLString = '';
	$WarnedXMLString = '';

	$ImportResult = product::ImportProduct($Site, $Product, $NoOfProductsParsed, $NoOfProductImported, $NoOfProductFailed, $SuccessXMLString, $ErrorXMLString, $_REQUEST['real_import'], $_REQUEST['new_or_update'], $_REQUEST['update_media'], $CurrencyList);
	$gSuccessXMLString = $gSuccessXMLString . $SuccessXMLString;
	$gErrorXMLString = $gErrorXMLString . $ErrorXMLString;

	if ($ImportResult == false)
		break;
}

$smarty->assign('no_of_object_parsed', $NoOfProductsParsed);
$smarty->assign('no_of_object_imported', $NoOfProductImported);
$smarty->assign('no_of_object_failed', $NoOfProductFailed);

$smarty->assign('no_of_product_parsed', $NoOfProductsParsed);
$smarty->assign('no_of_product_imported', $NoOfProductImported);
$smarty->assign('no_of_product_failed', $NoOfProductFailed);

$smarty->assign('ErrorProductXMLString', $gErrorXMLString);
$smarty->assign('SuccessProductXMLString', $gSuccessXMLString);
$Data = $smarty->fetch('api/import.tpl');
$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');