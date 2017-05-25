<?php
// parameters:
//	lang_id

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$AllProductBrandXML = product::GetAllProductBrandXML($Site['site_id'], intval($_REQUEST['lang_id']));
$smarty->assign('Data', $AllProductBrandXML);

$smarty->display('api/api_result.tpl');