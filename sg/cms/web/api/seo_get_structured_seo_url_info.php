<?php
// parameters:
//	structured_seo_url

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$SeoLinkInfoXML = object::GetStructuredSeoURLInfoXML($_REQUEST['structured_seo_url'], $Site['site_id']);

$smarty->assign('Data', $SeoLinkInfoXML);
$smarty->display('api/api_result.tpl');