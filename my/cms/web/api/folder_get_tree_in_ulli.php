<?php
// parameters:
//	folder_id
//	security_level
//	max_depth
//	expand_product_root
//	ignore_product - Default: N
//	folder_href - # or something else
//	product_category_href - # or something else
//	lang_id
//	with_ul
//  friendly_link - Y/N
//	baseurl
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$Folder = object::GetObjectInfo($_REQUEST['folder_id']);
if ($Folder['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$XHTML = '';
if ($_REQUEST['with_ul'] != 'N')
	$_REQUEST['with_ul'] = 'Y';

$ObjectTypeList = $APIFolderTreeObjectTypeList;

if ($_REQUEST['expand_product_root'] == 'Y') {
	array_push($ObjectTypeList, 'PRODUCT_CATEGORY');
	array_push($ObjectTypeList, 'PRODUCT');
}
if ($_REQUEST['ignore_product'] == 'Y')
	$ObjectTypeList = remove_item_by_value($ObjectTypeList, 'PRODUCT', true);

site::GetFolderTreeInULLI($XHTML, $ObjectTypeList, $_REQUEST['folder_id'], $_REQUEST['lang_id'], 0, intval($_REQUEST['security_level']), intval($_REQUEST['max_depth']), $_REQUEST['folder_href'], $_REQUEST['with_ul'], ynval($_REQUEST['friendly_link']), $_REQUEST['baseurl']);

$smarty->assign('Data', $XHTML);
$Data = $smarty->fetch('api/folder_get_tree_in_ulli.tpl');
$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');