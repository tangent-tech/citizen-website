<?php
// parameters:
//	user_username
//	password_pattern: normal(default) / all_upper_cap
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$User = user::GetUserInfoByUsername($_REQUEST['user_username'], $Site['site_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$ValidPattern = array('normal', 'all_upper_cap');
if (!in_array($_REQUEST['password_pattern'], $ValidPattern))
	$_REQUEST['password_pattern'] = 'normal';

$NewPassword = 'thisismeaninglesscrazyallyougetrubbishtextbyjeffthestupidoncowcow';
if ($_REQUEST['password_pattern'] == 'normal')
	$NewPassword = substr(md5(md5(rand(0,999999) . '!@##!!@**@' . rand(0, 99999) . 'do not ask!!!!')), 0, 8);
else if ($_REQUEST['password_pattern'] == 'all_upper_cap')
	$NewPassword = strtoupper(substr(md5(md5(rand(0,999999) . '!@##!!@$$T@^**@' . rand(0, 99999) . 'do not ask!!!! YNWA!!!!')), 0, 8));

$query =	"	UPDATE	user " .
			"	SET		user_new_password				= '" . $NewPassword . "', " .
			"			user_new_password_token			= '" . md5(md5(rand(0,999999) . 'Mr X is an lock man now!!!!! !@##!!@**@' . rand(0, 99999) . 'do not ask!!!!')) . "'" .
			"	WHERE	user_id	= '" . intval($User['user_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$User = user::GetUserInfo($User['user_id']);
if ($User != null) {
	$smarty->assign('Object', $User);
	$UserXML = $smarty->fetch('api/object_info/USER.tpl');
	$smarty->assign('Data', $UserXML);
}
$smarty->display('api/api_result.tpl');