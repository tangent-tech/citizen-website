<?php
// parameters:
//	campaign_active_datetime
//	activate_campaign - Y/N, default N
//	campaign_title
//	campaign_content

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if ($Site['site_module_elasing_enable'] != 'Y')
	APIDie(API_ERROR_ELASING_MODULE_IS_DISABLED);

$CampaignStatus = 'Draft';
if ($_REQUEST['activate_campaign'] == 'Y')
	$CampaignStatus = 'Submitted';

$query  =	" 	INSERT INTO elasing_campaign " .
			"	SET	site_id						= '" . intval($Site['site_id']) . "', " .
			"		content_admin_id			= 0, " .
			"		campaign_active_datetime	= '" . aveEscT($_REQUEST['campaign_active_datetime']) . "', " .
			"		campaign_status				= '" . aveEscT($CampaignStatus) . "', " .
			"		campaign_content			= '" . aveEscT($_REQUEST['campaign_content']) . "', " .
			"		campaign_title				= '" . aveEscT($_REQUEST['campaign_title']) . "', " .
			"		no_of_opened_emails			= 0, " .
			"		no_of_clicked_emails		= 0, " .
			"		no_of_soft_bounce			= 0, " .
			"		no_of_hard_bounce			= 0, " .
			"		no_of_sent					= 0, " .
			"		no_of_emails				= 0 ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
$CampaignID = customdb::mysqli()->insert_id;
$smarty->assign('CampaignID', $CampaignID);

$ElasingNewCampaignXML = $smarty->fetch('api/elasing_new_campaign.tpl');
$smarty->assign('Data', $ElasingNewCampaignXML);
$smarty->display('api/api_result.tpl');