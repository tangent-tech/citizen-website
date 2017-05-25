<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_bonus_point.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'bonuspoint');
$smarty->assign('CurrentTab2', 'bonuspoint_list_all');
$smarty->assign('MyJS', 'bonuspoint_root_edit');

$BonusPointRoot = object::GetObjectInfo($Site['bonus_point_root_id']);
$smarty->assign('TheObject', $BonusPointRoot);

$smarty->assign('TITLE', 'Edit Bonus Root');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/bonuspoint_root_edit.tpl');