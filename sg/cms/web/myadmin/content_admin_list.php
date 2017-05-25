<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'content_admin');
$smarty->assign('MyJS', 'content_admin_list');

$ContentAdmins = content_admin::GetAllContentAdminList();
$smarty->assign('ContentAdmins', $ContentAdmins);

$smarty->assign('TITLE', 'Content Admin List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/content_admin_list.tpl');