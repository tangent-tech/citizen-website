<?php
// parameters:
//	myorder_id
//	lang_id - 1
//	include_product_list - default:Y
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$MyOrder = cart::GetMyOrderInfo($_REQUEST['myorder_id']);
if ($MyOrder['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if (!isset($_REQUEST['include_product_list']))
	$_REQUEST['include_product_list'] = 'Y';

if (intval($_REQUEST['lang_id']) <= 0)
	$_REQUEST['lang_id'] = 1;

$ShipmentListXML = inventory::GetMyOrderShipmentListXML($_REQUEST['myorder_id'], $_REQUEST['lang_id'], ynval($_REQUEST['include_product_list']));

$smarty->assign('ShipmentListXML', $ShipmentListXML);
$Data = $smarty->fetch('api/shipment_list.tpl');

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');