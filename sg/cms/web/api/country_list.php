<?php
// parameters: lang_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$CountryListXML = country::GetCountryListXML($_REQUEST['lang_id'], $Site['site_country_show_other']);
$smarty->assign('Data', $CountryListXML);

$smarty->display('api/api_result.tpl');