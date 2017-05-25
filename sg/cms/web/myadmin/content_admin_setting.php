<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_any_header.php');

$smarty->assign('MyJS', 'content_admin_setting');

$smarty->assign('TITLE', 'Content Admin Setting');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/content_admin_setting.tpl');