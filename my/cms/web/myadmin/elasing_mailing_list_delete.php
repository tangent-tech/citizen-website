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

emaillist::RemoveEmailList($_REQUEST['id']);

header( 'Location: elasing_mailing_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS));