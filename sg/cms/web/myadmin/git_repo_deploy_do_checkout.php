<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'git_management');
$smarty->assign('MyJS', 'git_repo_deploy_edit');

$GitRepoDeployInfo = git::GetGitRepoDeployInfo($_REQUEST['git_repo_deploy_id']);
$smarty->assign('GitRepoDeployInfo', $GitRepoDeployInfo);

if ($GitRepoDeployInfo == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_list.php', __LINE__);

if (!git::IsGitRepoAccessible($GitRepoDeployInfo['git_repo_id'], $AdminInfo))
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_list.php', __LINE__);

git::AddActionQueue('git_deploy', $GitRepoDeployInfo['git_repo_id'], $GitRepoDeployInfo['git_repo_deploy_id'], $_SESSION['SystemAdminID']);

header( 'Location: git_repo_action_log.php?git_repo_id=' . $GitRepoDeployInfo['git_repo_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));