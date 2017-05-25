<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$_REQUEST['git_repo_linux_user'] = strtolower(trim($_REQUEST['git_repo_linux_user']));

if (!git::IsLinuxUserNameCompatible($_REQUEST['git_repo_linux_user'], $ErrorMsg)) {
	$_REQUEST['ErrorMessage'] = $ErrorMsg;
	$smarty->assign('TITLE', 'Add Git Repo');
	$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/git_repo_add.tpl');	
	die();
}

if (git::IsLinuxUserInUseForAnotherGit($_REQUEST['git_repo_linux_user'], null)) {
	$_REQUEST['ErrorMessage'] = ADMIN_ERROR_GIT_NAME_IS_IN_USE;
	$smarty->assign('TITLE', 'Add Git Repo');
	$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/git_repo_add.tpl');	
	die();
}

$query	=	"	INSERT INTO	git_repo " .
			"	SET		git_repo_name					= '" . aveEscT($_REQUEST['git_repo_name']) . "', " .
			"			git_repo_linux_user				= '" . aveEscT($_REQUEST['git_repo_linux_user']) . "', " .
			"			git_repo_auto_deploy_on_push	= '" . ynval($_REQUEST['git_repo_auto_deploy_on_push']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$GitRepoID = customdb::mysqli()->insert_id;

git::AddActionQueue('git_creation', $GitRepoID, 0, $_SESSION['SystemAdminID']);

$query	=	"	INSERT INTO	git_repo_deploy " .
			"	SET		git_repo_id = '" . intval($GitRepoID) . "', " .
			"			git_repo_deploy_linux_user		= null, " .
			"			git_repo_deploy_last_deploy_date = null, " .
			"			git_repo_deploy_by_system_admin_id = '" . intval($_SESSION['SystemAdminID']) . "', " .
			"			git_repo_deploy_name = '" . aveEscT($_REQUEST['git_repo_name']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

git::AddActionQueue('git_hook', $GitRepoID, 0, $_SESSION['SystemAdminID']);

header( 'Location: git_repo_edit.php?git_repo_id=' . $GitRepoID . '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS));