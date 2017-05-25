<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$GitRepoDeployInfo = git::GetGitRepoDeployInfo($_REQUEST['git_repo_deploy_id']);
if ($GitRepoDeployInfo == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_list.php', __LINE__);

$query	=	"	DELETE FROM	git_repo_deploy " .
			"	WHERE		git_repo_deploy_id			= '" . intval($_REQUEST['git_repo_deploy_id']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	DELETE FROM	git_action_queue " .
			"	WHERE		git_repo_deploy_id			= '" . intval($_REQUEST['git_repo_deploy_id']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: git_repo_edit.php?git_repo_id=' . $GitRepoDeployInfo['git_repo_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS));