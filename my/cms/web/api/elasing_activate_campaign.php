<?php
// parameters:
//	campaign_id

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

if ($Campaign['campaign_status'] != 'Completed') {
	$query  =	" 	UPDATE	elasing_campaign " .
				"	SET		campaign_status = 'Submitted'" .
				"	WHERE	campaign_id = '" . intval($_REQUEST['campaign_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$smarty->display('api/api_result.tpl');