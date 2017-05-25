<?php
// parameters:	link_id
//				lang_id - default 0, 0 will get object name instead of product_name/product_category_name
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
$ObjectLink['object_seo_url'] = object::GetSeoURL($ObjectLink, '', $ObjectLink['language_id'], $Site);
if (intval($_REQUEST['lang_id']) != 0) {
	if ($ObjectLink['object_type'] == 'PRODUCT_CATEGORY') {
		$ProductCategory = product::GetProductCatInfo($ObjectLink['object_id'], $_REQUEST['lang_id']);
		$ObjectLink['object_name'] = $ProductCategory['product_category_name'];
	}
	else if ($ObjectLink['object_type'] == 'PRODUCT_CATEGORY') {
		$Product = product::GetProductInfo($ObjectLink['object_id'], $_REQUEST['lang_id']);
		$ObjectLink['object_name'] = $Product['product_name'];
	}
}
$smarty->assign('Object', $ObjectLink);
$ObjectsXML = $smarty->fetch('api/object_info/OBJECT.tpl');

while ($ObjectLink['parent_object_id'] != null) {	
	$ObjectLink = object::GetObjectInfo($ObjectLink['parent_object_id']);
	$ObjectLink['object_seo_url'] = object::GetSeoURL($ObjectLink, '', $ObjectLink['language_id'], $Site);
	if (intval($_REQUEST['lang_id']) != 0) {
		if ($ObjectLink['object_type'] == 'PRODUCT_CATEGORY') {
			$ProductCategory = product::GetProductCatInfo($ObjectLink['object_id'], $_REQUEST['lang_id']);
			$ObjectLink['object_name'] = $ProductCategory['product_category_name'];
		}
		else if ($ObjectLink['object_type'] == 'PRODUCT_CATEGORY') {
			$Product = product::GetProductInfo($ObjectLink['object_id'], $_REQUEST['lang_id']);
			$ObjectLink['object_name'] = $Product['product_name'];
		}
	}
	
	$smarty->assign('Object', $ObjectLink);
	$ObjectsXML = $smarty->fetch('api/object_info/OBJECT.tpl') . $ObjectsXML;
};
$ObjectsXML = '<objects>' . $ObjectsXML . '</objects>';
$smarty->assign('Data', $ObjectsXML);
$smarty->display('api/api_result.tpl');