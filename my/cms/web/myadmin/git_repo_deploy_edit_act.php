<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'git_management');
$smarty->assign('MyJS', 'git_repo_deploy_edit_act');

$GitRepoDeployInfo = git::GetGitRepoDeployInfo($_REQUEST['git_repo_deploy_id']);
$smarty->assign('GitRepoDeployInfo', $GitRepoDeployInfo);

if ($GitRepoDeployInfo == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_list.php', __LINE__);

// Default Deploy Point cannot be edited
if ($GitRepoDeployInfo['git_repo_deploy_linux_user'] == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_edit.php?git_repo_id' . $GitRepoDeployInfo['git_repo_id'], __LINE__);

$_REQUEST['git_repo_deploy_linux_user'] = strtolower(trim($_REQUEST['git_repo_deploy_linux_user']));

if (!git::IsLinuxUserNameCompatible($_REQUEST['git_repo_deploy_linux_user'], $ErrorMsg))
	AdminDie($ErrorMsg, 'git_repo_deploy_edit.php?git_repo_deploy_id=' . $_REQUEST['git_repo_deploy_id'], __LINE__);		

if (git::IsLinuxUserInUseForAnotherGit($_REQUEST['git_repo_deploy_linux_user'], null, $_REQUEST['git_repo_deploy_id']))
	AdminDie(ADMIN_ERROR_GIT_NAME_IS_IN_USE, 'git_repo_deploy_edit.php?git_repo_deploy_id=' . $_REQUEST['git_repo_deploy_id'], __LINE__);

if(preg_match('/[^a-z_\-0-9]/i', $_REQUEST['git_repo_deploy_branch']))
	AdminDie(ADMIN_ERROR_GIT_BRANCH_NAME_INVALID, 'git_repo_deploy_edit.php?git_repo_deploy_id=' . $_REQUEST['git_repo_deploy_id'], __LINE__);

$query	=	"	UPDATE	git_repo_deploy " .
			"	SET		git_repo_deploy_name		= '" . aveEscT($_REQUEST['git_repo_deploy_name']) . "', " .
			"			git_repo_deploy_branch		= '" . aveEscT($_REQUEST['git_repo_deploy_branch']) . "', " .
			"			git_repo_deploy_linux_user	= '" . aveEscT($_REQUEST['git_repo_deploy_linux_user']) . "'" .
			"	WHERE	git_repo_deploy_id = '" . intval($_REQUEST['git_repo_deploy_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: git_repo_deploy_edit.php?git_repo_deploy_id=' . $_REQUEST['git_repo_deploy_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));