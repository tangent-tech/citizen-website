<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'git_management');
$smarty->assign('MyJS', 'git_repo_deploy_edit');

$GitRepoDeployInfo = git::GetGitRepoDeployInfo($_REQUEST['git_repo_deploy_id']);
$smarty->assign('GitRepoDeployInfo', $GitRepoDeployInfo);

if ($GitRepoDeployInfo == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_list.php', __LINE__);

$smarty->assign('TITLE', 'Edit Git Repo Deploy');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/git_repo_deploy_edit.tpl');