<?php
// parameters:
//	myorder_id
//	language_id
//	include_product_details

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$MyOrder = new myorder($_REQUEST['myorder_id']);

if ($MyOrder->getMyOrderDetailsObj()->site_id != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$MyOrderXML = $MyOrder->GetMyOrderXML($_REQUEST['language_id'], ynval($_REQUEST['include_product_details']));

$smarty->assign('Data', $MyOrderXML);
$smarty->display('api/api_result.tpl');