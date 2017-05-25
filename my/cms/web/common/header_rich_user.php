<?php
if (!defined('IN_CMS'))
	die("header_rich_user.php is called directly " . realpath(__FILE__) . " " .  __LINE__);

$MyUser = user::GetUserByRichSession($_REQUEST['rich_user_id'], $_REQUEST['rich_user_session']);

if ($MyUser['site_id'] != $Site['site_id'] || $MyUser == NULL)
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

?>