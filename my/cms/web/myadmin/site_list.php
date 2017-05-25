<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'site_management');
$smarty->assign('MyJS', 'site_list');

$SiteList = site::GetAllSiteList('ALL');
$smarty->assign('SiteList', $SiteList);

$smarty->assign('TITLE', 'Site List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/site_list.tpl');