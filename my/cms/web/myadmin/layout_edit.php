<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_article.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'layout');
$smarty->assign('MyJS', 'layout_edit');

$Layout = layout::GetLayoutInfo($_REQUEST['id']);
$smarty->assign('Layout', $Layout);

if ($Layout['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');

$BlockDefs = block::GetBlockDefListByLayoutID($_REQUEST['id']);
$smarty->assign('BlockDefs', $BlockDefs);
	
$smarty->assign('TITLE', 'Edit Layout');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_edit.tpl');