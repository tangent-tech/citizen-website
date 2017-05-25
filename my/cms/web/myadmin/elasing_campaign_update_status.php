<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_campaign_update_status');
$smarty->assign('MyJS', 'elasing_campaign_update_status');

$Campaign = emaillist::GetCampaignDetails($_REQUEST['id']);
if ($Campaign['site_id'] != $_SESSION['site_id'])
	AdminDie('Sorry, this is not your list', 'elasing_campaign_list.php', __LINE__);
if (!$IsContentAdmin && $_SESSION['ContentAdminID'] != $Campaign['content_admin_id'])
	AdminDie('Sorry, this is not your list', 'elasing_campaign_list.php', __LINE__);

if ($Campaign['campaign_status'] == 'Completed')
	AdminDie('Sorry, this is not your list', 'elasing_mailing_list.php', __LINE__);

$status = 'Draft';
if ($_REQUEST['status'] == 'active')
	$status = 'Submitted';
elseif ($_REQUEST['status'] == 'inactive')
	$status = 'Inactive';

$query  =	" 	UPDATE	elasing_campaign " .
			"	SET		campaign_status = '" . aveEscT($status) . "'" .
			"	WHERE	campaign_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header('Location: elasing_campaign_list.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));