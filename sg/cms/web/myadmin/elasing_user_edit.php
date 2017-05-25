<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_elasing.php');
require_once('../common/header_elasing_multi_level.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_user_edit');
$smarty->assign('MyJS', 'elasing_user_edit');

$TheContentAdmin = content_admin::GetContentAdminInfo($_REQUEST['id']);
$smarty->assign('TheContentAdmin', $TheContentAdmin);

if ($TheContentAdmin['site_id'] != $_SESSION['site_id'] || !$IsContentAdmin || $TheContentAdmin['content_admin_type'] != 'ELASING_USER')
	AdminDie('Sorry, you are not allowed to edit this user.', 'elasing_user_list.php', __LINE__);

$smarty->assign('TITLE', 'Edit User');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/elasing_user_edit.tpl');