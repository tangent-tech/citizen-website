<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'system_admin');
$smarty->assign('MyJS', 'system_admin_add');

$smarty->assign('TITLE', 'Add System Admin');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/system_admin_add.tpl');