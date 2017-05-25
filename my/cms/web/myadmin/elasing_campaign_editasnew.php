<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_campaign_list');
$smarty->assign('MyJS', 'elasing_campaign_list_edit');

$Campaign = emaillist::GetCampaignDetails($_REQUEST['id']);
if ($Campaign['site_id'] != $_SESSION['site_id'])
	AdminDie('Sorry, this is not your list', 'elasing_campaign_list.php', __LINE__);
if (!$IsContentAdmin && $_SESSION['ContentAdminID'] != $Campaign['content_admin_id'])
	AdminDie('Sorry, this is not your list', 'elasing_campaign_list.php', __LINE__);
$smarty->assign('Campaign', $Campaign);

$query  =	" 	INSERT INTO elasing_campaign " .
			"	SET	site_id						= '" . intval($_SESSION['site_id']) . "', " .
			"		content_admin_id			= '" . intval($_SESSION['ContentAdminID']) . "', " .
			"		campaign_active_datetime	= NOW() + INTERVAL 1 YEAR, " .
			"		campaign_status				= 'Draft', " .
			"		campaign_content			= '" . aveEscT($Campaign['campaign_content']) . "', " .
			"		campaign_title				= '" . aveEscT($Campaign['campaign_title']) . "', " .
			"		no_of_opened_emails			= 0, " .
			"		no_of_clicked_emails		= 0, " .
			"		no_of_soft_bounce			= 0, " .
			"		no_of_hard_bounce			= 0, " .
			"		no_of_sent					= 0, " .
			"		no_of_emails				= 0 ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
$CampaignID = customdb::mysqli()->insert_id;

header('Location: elasing_campaign_edit.php?id=' . $CampaignID);