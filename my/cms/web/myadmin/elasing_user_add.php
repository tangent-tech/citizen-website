<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_elasing.php');
require_once('../common/header_elasing_multi_level.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_user_add');
$smarty->assign('MyJS', 'elasing_user_add');

$smarty->assign('TITLE', 'Add User');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/elasing_user_add.tpl');