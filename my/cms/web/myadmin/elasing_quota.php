<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_quota');
$smarty->assign('MyJS', 'elasing_quota');

$smarty->assign('TITLE', 'Newsletter Quota');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/elasing_quota.tpl');