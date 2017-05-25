<?php
// parameters:
//	campaign_id
//	email_address
//	user_first_name
//	user_last_name

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if ($Site['site_module_elasing_enable'] != 'Y')
	APIDie(API_ERROR_ELASING_MODULE_IS_DISABLED);

$Campaign = emaillist::GetCampaignDetails($_REQUEST['campaign_id']);
if ($Campaign == null)
	APIDie(API_ERROR_INVALID_CAMPAIGN_ID);

$ErrorMsg = '';
if (emaillist::AddEmailToCampaign($ErrorMsg, trim($_REQUEST['email_address']), $_REQUEST['campaign_id'], $Site['site_id'], trim($_REQUEST['user_first_name']), trim($_REQUEST['user_last_name'])))
	$smarty->display('api/api_result.tpl');
else
	APIDie($API_ERROR[$ErrorMsg]);