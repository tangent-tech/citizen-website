<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_member.php');

$smarty->assign('CurrentTab', 'member');
//$smarty->assign('CurrentTab2', 'member_all');
$smarty->assign('MyJS', 'user_root_edit');

$UserRoot = object::GetObjectInfo($Site['site_user_root_id']);
$smarty->assign('TheObject', $UserRoot);

$smarty->assign('TITLE', 'Edit User Root');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/user_root_edit.tpl');