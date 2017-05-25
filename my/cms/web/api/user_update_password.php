<?php
// parameters:
//	user_id
//	user_password
//	user_new_password
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$User = user::LoginByUsername($User['user_username'], trim($_REQUEST['user_password']), $Site['site_id']);
if ($User == null)
	APIDie($API_ERROR['API_ERROR_INCORRECT_OLD_PASSWORD']);
else {
	$passwordHash = password_hash(trim($_REQUEST['user_new_password']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));
	
	$query =	"	UPDATE	user " .
				"	SET		user_password	= '" . aveEsc($passwordHash) . "'" .
				"	WHERE	user_id	= '" . intval($_REQUEST['user_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	$smarty->display('api/api_result.tpl');
}