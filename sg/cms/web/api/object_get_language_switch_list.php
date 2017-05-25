<?php
// parameters:
//	object_id
//	link_id

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ObjectLink = null;
if (isset($_REQUEST['link_id'])) {
	$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
	if ($ObjectLink['site_id'] != $Site['site_id'])
		APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);	
}
else {
	$ObjectLink = object::GetObjectInfo($_REQUEST['object_id']);
	if ($ObjectLink['site_id'] != $Site['site_id'])
		APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);		
}

$LangSwitchObjListXML = object::GetLangSwitchObjectListXML($ObjectLink, $Site);

$smarty->assign('Data', $LangSwitchObjListXML);
$smarty->display('api/api_result.tpl');