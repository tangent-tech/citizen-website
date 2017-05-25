<?php
// parameters:
//	user_username
//	user_password
//	user_password_secure
// REMEMBER TO CHECK user_is_enable. This is designed to return disabled user so that the client side can display something special there.
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

if (isset($_REQUEST['user_password_secure'])) {
	site::IncrementApiStats($Site['site_id'], __FILE__, 'user_password_secure');
	$User = user::LoginByUsernameWithHashPass(trim($_REQUEST['user_username']), trim($_REQUEST['user_password_secure']), $Site['site_id']);
}
else {
	site::IncrementApiStats($Site['site_id'], __FILE__, 'user_password');
	$User = user::LoginByUsername(trim($_REQUEST['user_username']), trim($_REQUEST['user_password']), $Site['site_id']);
}

if ($User != null) {
	$smarty->assign('Object', $User);
	$UserXML = $smarty->fetch('api/object_info/USER.tpl');
	$smarty->assign('Data', $UserXML);
}
$smarty->display('api/api_result.tpl');