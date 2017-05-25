<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$GitRepoInfo = git::GetGitRepoInfo($_REQUEST['git_repo_id']);

if (intval($GitRepoInfo['git_repo_id']) > 0) {
	git::AddActionQueue('git_delete', intval($GitRepoInfo['git_repo_id']), 0, $_SESSION['SystemAdminID']);
}

header( 'Location: git_repo_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS));