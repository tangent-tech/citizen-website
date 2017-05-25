<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'content_admin');
$smarty->assign('MyJS', 'content_admin_edit');

$TheContentAdmin = content_admin::GetContentAdminInfo($_REQUEST['id']);
$smarty->assign('TheContentAdmin', $TheContentAdmin);

$Sites = site::GetAllSiteList('ALL');
$smarty->assign('Sites', $Sites);

$smarty->assign('TITLE', 'Edit Content Admin');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/content_admin_edit.tpl');