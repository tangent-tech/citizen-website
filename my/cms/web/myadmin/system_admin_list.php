<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'system_admin');
$smarty->assign('MyJS', 'system_admin_list');
	
$SystemAdmins = system_admin::GetSystemAdminList();
$smarty->assign('SystemAdmins', $SystemAdmins);

$smarty->assign('TITLE', 'System Admin List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/system_admin_list.tpl');