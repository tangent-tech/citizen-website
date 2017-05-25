<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'git_management');
$smarty->assign('MyJS', 'git_repo_list');

$GitRepoList = git::GetGitRepoListBySystemAdminInfo($AdminInfo);
$smarty->assign('GitRepoList', $GitRepoList);

$smarty->assign('TITLE', 'GitRepo List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/git_repo_list.tpl');