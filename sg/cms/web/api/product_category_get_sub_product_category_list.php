<?php
// parameters:
//	product_category_id
//	lang_id
//	security_level - 0
//	max_depth - default: 10
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ProductCat = product::GetProductCatInfo($_REQUEST['product_category_id'], $_REQUEST['lang_id']);
if ($ProductCat['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if (intval($_REQUEST['max_depth']) <= 0)
	$_REQUEST['max_depth'] = 10;
	
$XML = product::GetProductSubCatXMLByProductCatID($ProductCat['product_category_id'], intval($_REQUEST['lang_id']), intval($_REQUEST['security_level']), $_REQUEST['max_depth']);

$smarty->assign('Data', $XML);
$smarty->display('api/api_result.tpl');