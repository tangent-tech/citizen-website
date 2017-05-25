<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_mailing_list');
$smarty->assign('MyJS', 'elasing_mailing_list_import_member');

$List = emaillist::GetEmailListDetails($_REQUEST['id']);
if ($List['site_id'] != $_SESSION['site_id'])
	AdminDie('Sorry, this is not your list', 'elasing_mailing_list.php', __LINE__);
if (!$IsContentAdmin && $_SESSION['ContentAdminID'] != $List['content_admin_id'])
	AdminDie('Sorry, this is not your list', 'elasing_mailing_list.php', __LINE__);

$ImportContact = 0;
$InvalidContact = 0;

$Members = user::GetUserSubscriberList($_SESSION['site_id'], 'Y');

foreach ($Members as $M) {
	if (emaillist::AddEmailToList($M['user_email'], $_REQUEST['id'], $_SESSION['site_id'], 'Y', $M['user_first_name'], $M['user_last_name']))
		$ImportContact++;
	else
		$InvalidContact++;
}

$smarty->assign('ImportContact', $ImportContact);
$smarty->assign('InvalidContact', $InvalidContact);

$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/elasing_mailing_list_import_member.tpl');