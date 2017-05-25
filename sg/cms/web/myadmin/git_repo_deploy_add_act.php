<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$GitRepoInfo = git::GetGitRepoInfo($_REQUEST['git_repo_id']);
$smarty->assign('GitRepoInfo', $GitRepoInfo);

if ($GitRepoInfo == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_list.php', __LINE__);

$_REQUEST['git_repo_deploy_linux_user'] = strtolower(trim($_REQUEST['git_repo_deploy_linux_user']));

if (!git::IsLinuxUserNameCompatible($_REQUEST['git_repo_deploy_linux_user'], $ErrorMsg)) {
	$_REQUEST['ErrorMessage'] = $ErrorMsg;
	$smarty->assign('TITLE', 'Add Git Deploy Point');
	$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/git_repo_deploy_add.tpl');	
	die();
}

if (git::IsLinuxUserInUseForAnotherGit($_REQUEST['git_repo_deploy_linux_user'], null, null)) {
	$_REQUEST['ErrorMessage'] = ADMIN_ERROR_GIT_NAME_IS_IN_USE;
	$smarty->assign('TITLE', 'Add Git Deploy Point');
	$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/git_repo_deploy_add.tpl');	
	die();
}

if(preg_match('/[^a-z_\-0-9]/i', $_REQUEST['git_repo_deploy_branch'])) {
	$_REQUEST['ErrorMessage'] = ADMIN_ERROR_GIT_BRANCH_NAME_INVALID;
	$smarty->assign('TITLE', 'Add Git Deploy Point');
	$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/git_repo_deploy_add.tpl');	
	die();	
}

$query	=	"	INSERT INTO	git_repo_deploy " .
			"	SET		git_repo_id					= '" . intval($_REQUEST['git_repo_id']) . "', " .
			"			git_repo_deploy_name		= '" . aveEscT($_REQUEST['git_repo_deploy_name']) . "', " .
			"			git_repo_deploy_branch		= '" . aveEscT($_REQUEST['git_repo_deploy_branch']) . "', " .
			"			git_repo_deploy_linux_user	= '" . aveEscT($_REQUEST['git_repo_deploy_linux_user']) . "', " .
			"			git_repo_deploy_last_deploy_date = NULL, " .
			"			git_repo_deploy_by_system_admin_id	= '" . intval($_SESSION['SystemAdminID']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$GitRepoDeployID = customdb::mysqli()->insert_id;

header( 'Location: git_repo_deploy_edit.php?git_repo_deploy_id=' . $GitRepoDeployID . '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS));