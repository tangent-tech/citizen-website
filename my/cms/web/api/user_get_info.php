<?php
// parameters:
//	user_id
//	user_email
//	user_username
//	datafile_page_no
//	datafile_per_page
//	language_id

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$User = null;
if (isset($_REQUEST['user_id']))
	$User = user::GetUserInfo($_REQUEST['user_id']);
elseif (isset($_REQUEST['user_email']))
	$User = user::GetUserInfoByEmail($_REQUEST['user_email'], $Site['site_id']);
elseif (isset($_REQUEST['user_username']))
	$User = user::GetUserInfoByUsername($_REQUEST['user_username'], $Site['site_id']);

if (!isset($_REQUEST['datafile_page_no']))
	$_REQUEST['datafile_page_no'] = 1;
if (!isset($_REQUEST['datafile_per_page']))
	$_REQUEST['datafile_per_page'] = 999999;

if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

//$UserXML = user::GetUserXML($_REQUEST['user_id']);
$UserXML = user::GetUserXMLByUserObj($User, true, $_REQUEST['datafile_page_no'], $_REQUEST['datafile_per_page'], $REQUEST['language_id']);

$smarty->assign('Data', $UserXML);
$smarty->display('api/api_result.tpl');