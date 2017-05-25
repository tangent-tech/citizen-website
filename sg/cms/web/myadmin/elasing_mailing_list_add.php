<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_mailing_list');
$smarty->assign('MyJS', 'elasing_mailing_list_add');

$smarty->assign('TITLE', 'Mailing List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/elasing_mailing_list_add.tpl');