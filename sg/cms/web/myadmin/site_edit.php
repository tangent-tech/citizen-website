<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'site_management');
$smarty->assign('MyJS', 'site_edit');

$TheSite = site::GetSiteInfo($_REQUEST['site_id']);
$smarty->assign('TheSite', $TheSite);

$ConnectionTest = site::ConnectionTest($_REQUEST['site_id']);
$smarty->assign('ConnectionTest', $ConnectionTest);

$smarty->assign('TITLE', 'Edit Site');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/site_edit.tpl');