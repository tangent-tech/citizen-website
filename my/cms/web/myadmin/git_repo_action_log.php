<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'git_management');
$smarty->assign('MyJS', 'git_repo_action_log');

$GitRepoInfo = git::GetGitRepoInfo($_REQUEST['git_repo_id']);
$smarty->assign('GitRepoInfo', $GitRepoInfo);

if ($GitRepoInfo == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_list.php', __LINE__);

if (!git::IsGitRepoAccessible($_REQUEST['git_repo_id'], $AdminInfo))
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'git_repo_list.php', __LINE__);

$ActionLog = git::GetActionQueueList('all', $_REQUEST['git_repo_id']);
$smarty->assign('ActionLog', $ActionLog);

$smarty->assign('TITLE', 'Git Action Log');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/git_repo_action_log.tpl');