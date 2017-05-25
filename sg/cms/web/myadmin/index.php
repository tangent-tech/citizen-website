<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');

user::CleanUpTempUser();

system_admin::Logout();

$smarty->assign('TITLE', 'System Admin Login');

$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/index.tpl' );