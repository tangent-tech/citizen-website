<?php
// parameters:
//	link_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$ProductRootLink = product::GetProductRootLink($ObjectLink['object_link_id']);
$ProductRootLink['object_seo_url'] = object::GetSeoURL($ProductRootLink, '', $ProductRootLink['language_id'], $Site);
$smarty->assign('Object', $ProductRootLink);
$ProductRootLinkXML = $smarty->fetch('api/object_info/PRODUCT_ROOT_LINK.tpl');

$smarty->assign('Data', $ProductRootLinkXML);
$smarty->display('api/api_result.tpl');