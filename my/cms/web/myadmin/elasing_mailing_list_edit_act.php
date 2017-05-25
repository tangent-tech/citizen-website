<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_mailing_list');

$EmailList = emaillist::GetEmailListDetails($_REQUEST['id']);
if ($EmailList['site_id'] != $_SESSION['site_id'])
	AdminDie('Sorry, this is not your list', 'elasing_mailing_list.php', __LINE__);
if (!$IsContentAdmin && $_SESSION['ContentAdminID'] != $EmailList['content_admin_id'])
	AdminDie('Sorry, this is not your list', 'elasing_mailing_list.php', __LINE__);

$query  =	" 	UPDATE	elasing_list" .
			"	SET		list_name = '" . aveEscT($_REQUEST['list_name']) . "', " .
			"			list_desc = '" . aveEscT($_REQUEST['list_desc']) . "' " .
			"	WHERE	list_id			= '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header('Location: elasing_mailing_list_edit.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));