<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_article.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'layout');
$smarty->assign('MyJS', 'layout_list');

$Layouts = layout::GetLayoutList($_SESSION['site_id']);
$smarty->assign('Layouts', $Layouts);

$smarty->assign('TITLE', 'Layout List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_list.tpl');