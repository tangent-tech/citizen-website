<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');

$smarty->assign('CurrentTab', 'site_content_writer');
$smarty->assign('CurrentTab2', 'site_content_writer_list');
$smarty->assign('MyJS', 'site_content_writer_add');

$smarty->assign('TITLE', 'Add Writer');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/site_content_writer_add.tpl');