<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_mailing_list');

$Link = emaillist::GetListSubscriberLinkInfo($_REQUEST['id']);

$EmailList = emaillist::GetEmailListDetails($Link['list_id']);
if ($EmailList['site_id'] != $_SESSION['site_id'])
	AdminDie('Sorry, this is not your list', 'elasing_mailing_list.php', __LINE__);
if (!$IsContentAdmin && $_SESSION['ContentAdminID'] != $EmailList['content_admin_id'])
	AdminDie('Sorry, this is not your list', 'elasing_mailing_list.php', __LINE__);

$query  =	" 	DELETE FROM	elasing_list_subscriber " .
			"	WHERE		list_subscriber_id = '" . intval($Link['list_subscriber_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	UPDATE	elasing_list " .
			"	SET		last_update = now() " .
			"	WHERE	list_id = '" .  intval($Link['list_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: elasing_mailing_list_edit.php?id=' . $Link['list_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS));