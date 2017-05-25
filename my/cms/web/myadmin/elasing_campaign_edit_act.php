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

$query  =	" 	UPDATE elasing_campaign " .
			"	SET	campaign_active_datetime	= '" . aveEscT($_REQUEST['campaign_active_datetime'] . " " . $_REQUEST['Time_Hour'] . ":" . $_REQUEST['Time_Minute']) . "', " .
			"		campaign_content			= '" . aveEscT($_REQUEST['ContentEditor']) . "', " .
			"		campaign_title				= '" . aveEscT($_REQUEST['campaign_title']) . "'" .
			"	WHERE	campaign_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

if ($Campaign['campaign_status'] == 'Draft') {
	$query  =	" 	DELETE FROM elasing_campaign_email " .
				"	WHERE	campaign_id = '" . intval($_REQUEST['id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

if (isset($_REQUEST['EmailList'])) {
	foreach ($_REQUEST['EmailList'] as $C) {
		$EmailList = emaillist::GetEmailListDetails($C);
		if ($EmailList['site_id'] == $_SESSION['site_id']) {
			$TotalSubscriber = 0;
			$SubscriberList = emaillist::GetSubscriberList($EmailList['list_id'], $_SESSION['site_id'], $TotalSubscriber, 1, 999999);

			if ($SubscriberList != null) {
				foreach ($SubscriberList as $S) {
					if ($S['deny_all_list'] == 'N' && $S['deny_all_elasing'] == 'N') {
						$query  =	" 	INSERT INTO elasing_campaign_email " .
									"	SET	campaign_id			= '" . intval($_REQUEST['id']) . "', " .
									"		subscriber_id		= '" . intval($S['subscriber_id']) . "', " .
									"		campaign_email_key		= '" . substr(md5(rand(0,65535) . "avbwbwe" . rand(0,65535) ), 0, 8) . "', " .
									"		delivery_status		= 'in_queue', " .
									"		delivery_datetime	= NULL, " .
									"		remark				= '', " .
									"		is_opened			= 'N', " .
									"		is_clicked			= 'N'" .
									"	ON DUPLICATE KEY " .
									"	UPDATE	campaign_email_id = LAST_INSERT_ID(campaign_email_id)";
						$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
					}
				}

			}
		}
	}
}

$query  =	" 	SELECT	COUNT(*) AS TotalEmail " .
			"	FROM	elasing_campaign_email " .
			"	WHERE	campaign_id			= '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
$myResult = $result->fetch_assoc();

$query  =	" 	UPDATE	elasing_campaign" .
			"	SET		no_of_emails = '" . intval($myResult['TotalEmail']) . "'" .
			"	WHERE	campaign_id			= '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
$smarty->assign('TotalEmail', $myResult['TotalEmail']);

header('Location: elasing_campaign_edit.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));