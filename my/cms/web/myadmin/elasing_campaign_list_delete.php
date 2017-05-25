<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_campaign_list');

$Campaign = emaillist::GetCampaignDetails($_REQUEST['id']);
if ($Campaign['site_id'] != $_SESSION['site_id'])
	AdminDie('Sorry, this is not your list', 'elasing_campaign_list.php', __LINE__);
if (!$IsContentAdmin && $_SESSION['ContentAdminID'] != $Campaign['content_admin_id'])
	AdminDie('Sorry, this is not your list', 'elasing_campaign_list.php', __LINE__);
$smarty->assign('Campaign', $Campaign);

emaillist::RemoveCampaign($_REQUEST['id']);

header( 'Location: elasing_campaign_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS));