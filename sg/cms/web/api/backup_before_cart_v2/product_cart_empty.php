<?php
// parameters:
//	user_id

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

cart::EmptyProductCart($_REQUEST['user_id'], 'normal', $Site['site_id'], 0, 0);

$smarty->display('api/api_result.tpl');
?>