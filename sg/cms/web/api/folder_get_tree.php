<?php

// parameters:
//	folder_id
//	security_level
//	max_depth
//	expand_product_root
//	ignore_product - Default: N
//	lang_id
//	include_disabled_objects: N
//	get_obj_details_type_list: comma seperated list, support PAGE and FOLDER only now
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ObjDetailsTypeList = explode(",", strtoupper($_REQUEST['get_obj_details_type_list']));

$Folder = object::GetObjectInfo($_REQUEST['folder_id']);
if ($Folder['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$ObjectTypeList = $APIFolderTreeObjectTypeList;

if ($_REQUEST['expand_product_root'] == 'Y') {
	array_push($ObjectTypeList, 'PRODUCT_CATEGORY');
	array_push($ObjectTypeList, 'PRODUCT');
}
if ($_REQUEST['ignore_product'] == 'Y')
	$ObjectTypeList = remove_item_by_value($ObjectTypeList, 'PRODUCT', true);

$IsEnabledString = 'Y';
if ($_REQUEST['include_disabled_objects'] == 'Y')
	$IsEnabledString = 'ALL';

$Data = site::GetFolderTreeForAPI($ObjectTypeList, $Folder, $_REQUEST['lang_id'], 0, intval($_REQUEST['security_level']), intval($_REQUEST['max_depth']), $IsEnabledString, $ObjDetailsTypeList);

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');