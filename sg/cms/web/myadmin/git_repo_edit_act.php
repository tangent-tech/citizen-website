<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');

$_REQUEST['git_repo_linux_user'] = strtolower(trim($_REQUEST['git_repo_linux_user']));

$GitRepoInfo = git::GetGitRepoInfo($_REQUEST['git_repo_id']);
$smarty->assign('GitRepoInfo', $GitRepoInfo);

if ($GitRepoInfo == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_list.php', __LINE__);

if (!git::IsGitRepoAccessible($_REQUEST['git_repo_id'], $AdminInfo))
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_list.php', __LINE__);

// Only Super Admin can modify linux user
if ($IsSuperAdmin) {
	if ($GitRepoInfo['git_repo_linux_user'] != $_REQUEST['git_repo_linux_user']) {

		if (!git::IsLinuxUserNameCompatible($_REQUEST['git_repo_linux_user'], $ErrorMsg))
			AdminDie($ErrorMsg, 'git_repo_edit.php?git_repo_id=' . $_REQUEST['git_repo_id'], __LINE__);

		if (git::IsLinuxUserInUseForAnotherGit($_REQUEST['git_repo_linux_user'], $GitRepoInfo['git_repo_id']))
			AdminDie(ADMIN_ERROR_GIT_NAME_IS_IN_USE, 'git_repo_edit.php?git_repo_id=' . $_REQUEST['git_repo_id'], __LINE__);

		git::AddActionQueue('update_linux_user', $_REQUEST['git_repo_id'], 0, $_SESSION['SystemAdminID'], $_REQUEST['git_repo_linux_user']);
	}
}

$query	=	"	UPDATE	git_repo " .
			"	SET		git_repo_name = '" . aveEscT($_REQUEST['git_repo_name']) . "', " .
			"			git_repo_auto_deploy_on_push = '" . ynval($_REQUEST['git_repo_auto_deploy_on_push']) . "' " .
			"	WHERE	git_repo_id = '" . intval($_REQUEST['git_repo_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	UPDATE	git_repo_deploy " .
			"	SET		git_repo_deploy_name = '" . aveEscT($_REQUEST['git_repo_name']) . "'" .
			"	WHERE	git_repo_id = '" . intval($_REQUEST['git_repo_id']) . "'" .
			"		AND	git_repo_deploy_linux_user IS NULL ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

git::AddActionQueue('git_hook', $_REQUEST['git_repo_id'], 0, $_SESSION['SystemAdminID']);

header( 'Location: git_repo_edit.php?git_repo_id=' . $_REQUEST['git_repo_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));