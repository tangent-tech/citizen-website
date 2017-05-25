<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_layout_news.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'site_content');
//$smarty->assign('CurrentTab2', 'news');
$smarty->assign('MyJS', 'news_list');
$smarty->assign('MyJS', 'news_root_permission_edit');

$LayoutNewsRoot = layout_news::GetLayoutNewsRootInfo($_REQUEST['id']);
if ($LayoutNewsRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news.php', __LINE__);
$smarty->assign('LayoutNewsRoot', $LayoutNewsRoot);
$smarty->assign('TheObject', $LayoutNewsRoot);

$smarty->assign('CurrentLayoutNewsRootID', $_REQUEST['id']);

$smarty->assign('TITLE', 'Edit Layout News Root Permission');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_news_root_permission_edit.tpl');