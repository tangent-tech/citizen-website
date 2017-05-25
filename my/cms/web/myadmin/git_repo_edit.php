<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'git_management');
$smarty->assign('MyJS', 'git_edit');

$GitRepoInfo = git::GetGitRepoInfo($_REQUEST['git_repo_id']);
$smarty->assign('GitRepoInfo', $GitRepoInfo);

if ($GitRepoInfo == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_list.php', __LINE__);

if (!git::IsGitRepoAccessible($_REQUEST['git_repo_id'], $AdminInfo))
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_list.php', __LINE__);

$GitRepoDeployList = git::GetGitRepoDeployListFromGitRepoID($GitRepoInfo['git_repo_id']);
$smarty->assign('GitRepoDeployList', $GitRepoDeployList);

$AdminAccessList = git::GetGitDeployAdminAccessList($GitRepoInfo['git_repo_id']);
$smarty->assign('AdminAccessList', $AdminAccessList);

$GitURL = git::GetGitURL($GitRepoInfo);
$smarty->assign('GitURL', $GitURL);

$smarty->assign('TITLE', 'Edit Git Repo');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/git_repo_edit.tpl');