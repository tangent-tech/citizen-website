<?php
// parameters:
//	product_category_id
//	lang_id
//	security_level - 0
//	include_sub_category - Default: N
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ProductCat = product::GetProductCatInfo($_REQUEST['product_category_id'], $_REQUEST['lang_id']);
if ($ProductCat['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$ProductBrandListXML = product::GetProductBrandListXMLByProductCatID($Site, $ProductCat['product_category_id'], $_REQUEST['lang_id'], $_REQUEST['security_level'], ynval($_REQUEST['include_sub_category']));

$smarty->assign('Data', $ProductBrandListXML);
$smarty->display('api/api_result.tpl');