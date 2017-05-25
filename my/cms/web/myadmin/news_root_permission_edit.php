<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_news.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'site_content');
//$smarty->assign('CurrentTab2', 'news');
$smarty->assign('MyJS', 'news_root_permission_edit');

$NewsRoot = news::GetNewsRootInfo($_REQUEST['id']);
if ($NewsRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);
$smarty->assign('NewsRoot', $NewsRoot);
$smarty->assign('TheObject', $NewsRoot);

$smarty->assign('CurrentNewsRootID', $_REQUEST['id']);

$smarty->assign('TITLE', 'Edit News Root');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/news_root_permission_edit.tpl');