<?php
// parameters:
//	product_brand_id
//	lang_id
//	security_level - 0
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ProductBrand = product::GetProductBrandInfo($_REQUEST['product_brand_id'], $_REQUEST['lang_id']);
if ($ProductBrand['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$ProductCatListXML = product::GetProductCatListXMLByProductBrandID($ProductBrand['product_brand_id'], $_REQUEST['lang_id'], $_REQUEST['security_level']);

$smarty->assign('Data', $ProductCatListXML);
$smarty->display('api/api_result.tpl');