<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'git_management');
$smarty->assign('MyJS', 'git_add');

if (!isset($_REQUEST['git_repo_auto_deploy_on_push']))
	$_REQUEST['git_repo_auto_deploy_on_push'] = 'Y';
if (!isset($_REQUEST['create_default_deploy_point']))
	$_REQUEST['create_default_deploy_point'] = 'Y';


$smarty->assign('TITLE', 'Add Git Repo');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/git_repo_add.tpl');