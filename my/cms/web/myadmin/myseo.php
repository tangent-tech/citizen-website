<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'content_admin');
$smarty->assign('MyJS', 'myseo');

$smarty->assign('TITLE', 'Add Content Admin');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/myseo.tpl');