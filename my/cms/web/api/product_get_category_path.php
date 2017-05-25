<?php
// parameters:
//	link_id
//	lang_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if ($ObjectLink['object_type'] == 'PRODUCT') {
	
	if ($ObjectLink['object_link_is_shadow'] == 'Y')
		$Product = product::GetProductInfo($ObjectLink['object_id'], $_REQUEST['lang_id']);
	else
		$Product = product::GetProductInfoByObjLinkID($ObjectLink['object_link_id'], $_REQUEST['lang_id']);

	$ParentObj = object::GetObjectInfo($Product['parent_object_id']);
	
	if ($ParentObj['object_type'] != 'PRODUCT_CATEGORY') // Product Special Cat or Product Brand... or .... i dunno
		$Product = product::GetProductInfo($ObjectLink['object_id'], $_REQUEST['lang_id']);
	
	$ParentObjectID = $Product['parent_object_id'];
}
else
	$ParentObjectID = $ObjectLink['parent_object_id'];
	
$ProductCatXML = '';

$FirstProductCat = null;

$ProductCat = product::GetProductCatInfo($ParentObjectID, $_REQUEST['lang_id']);
while ($ProductCat['object_type'] == 'PRODUCT_CATEGORY') {
	$FirstProductCat = $ProductCat;
	$ProductCat['object_seo_url'] = object::GetSeoURL($ProductCat, '', $_REQUEST['lang_id'], $Site);
	$smarty->assign('Object', $ProductCat);
	$ProductCatXML = $smarty->fetch('api/object_info/PRODUCT_CATEGORY.tpl') . $ProductCatXML;
	$ProductCat = product::GetProductCatInfo($ProductCat['parent_object_id'], $_REQUEST['lang_id']);
};

$ParentObjectLink = object::GetObjectInfo($FirstProductCat['parent_object_id']);

$ProductRootID = $ParentObjectLink['object_id'];
if ($ParentObjectLink['object_type'] == 'PRODUCT_ROOT_LINK') {
	$ProductRootLink = product::GetProductRootLink($ParentObjectLink['object_link_id']);
	$ProductRootID = $ParentObjectLink['product_root_id'];
}
$smarty->assign('product_root_id', $ProductRootID);

$XML = '<product_root_id>' . $ProductRootID . '</product_root_id><product_categories>' . $ProductCatXML . '</product_categories>';
$smarty->assign('Data', $XML);
$smarty->display('api/api_result.tpl');