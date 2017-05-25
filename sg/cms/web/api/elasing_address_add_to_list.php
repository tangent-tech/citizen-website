<?php
// parameters:
//	list_id
//	email_address
//	confirm_subscribe
//	user_first_name
//	user_last_name

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$EmailList = emaillist::GetEmailListDetails($_REQUEST['list_id']);
if ($EmailList['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if (emaillist::AddEmailToList($_REQUEST['email_address'], $_REQUEST['list_id'], $Site['site_id'], ynval($_REQUEST['confirm_subscribe']), trim($_REQUEST['user_first_name']), trim($_REQUEST['user_last_name']))) {
	$SubscriberXML = emaillist::GetSubscriberInfoXML($_REQUEST['email_address'], $_REQUEST['list_id']);

	$smarty->assign('Data', $SubscriberXML);
	$smarty->display('api/api_result.tpl');
}
else
	APIDie($API_ERROR['API_ERROR_INVALID_EMAIL']);