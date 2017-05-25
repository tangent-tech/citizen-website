<?php
// parameters: currency_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$CurrencyXML = currency::GetCurrencyXML($_REQUEST['currency_id'], $Site['site_id']);
$smarty->assign('Data', $CurrencyXML);

$smarty->display('api/api_result.tpl');