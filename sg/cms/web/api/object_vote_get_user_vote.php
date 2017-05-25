<?php
// parameters:
//	object_id
//	user_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$Object = object::GetObjectInfo($_REQUEST['object_id']);
if ($Object['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_USER']);

$VoteXML = object::GetVoteXMLByUserID($_REQUEST['object_id'], $_REQUEST['user_id']);

$smarty->assign('Data', $VoteXML);
$smarty->display('api/api_result.tpl');