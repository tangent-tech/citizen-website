<?php
// parameters:
//	shipment_id
//	language_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$Shipment = inventory::GetStockTransactionInfo($_REQUEST['shipment_id']);
if ($Shipment['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$ShipmentXML = inventory::GetShipmentInfoXML($_REQUEST['shipment_id'], $_REQUEST['language_id']);

$smarty->assign('Data', $ShipmentXML);
$smarty->display('api/api_result.tpl');