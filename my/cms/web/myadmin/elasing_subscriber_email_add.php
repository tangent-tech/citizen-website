<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_mailing_list');
$smarty->assign('MyJS', 'elasing_mailing_list_add_act');

$List = emaillist::GetEmailListDetails($_REQUEST['id']);
if ($List['site_id'] != $_SESSION['site_id'])
	AdminDie('Sorry, this is not your list', 'elasing_mailing_list.php', __LINE__);
if (!$IsContentAdmin && $_SESSION['ContentAdminID'] != $List['content_admin_id'])
	AdminDie('Sorry, this is not your list', 'elasing_mailing_list.php', __LINE__);

if (emaillist::AddEmailToList($_REQUEST['subscriber_email_address'], $_REQUEST['id'], $_SESSION['site_id'], 'Y', $_REQUEST['subscriber_first_name'], $_REQUEST['subscriber_last_name']))
	header('Location: elasing_mailing_list_edit.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS));
else
	header('Location: elasing_mailing_list_edit.php?id=' . $_REQUEST['id'] . '&ErrorMessage=' . urlencode(ADMIN_ERROR_INVALID_EMAIL));