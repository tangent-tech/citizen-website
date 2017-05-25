<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_layout_news.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_layout_news_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'layout_news');
$smarty->assign('MyJS', 'layout_news_block_edit');

$LayoutNews = layout_news::GetLayoutNewsInfo($_REQUEST['layout_news_id']);
if ($LayoutNews['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['layout_news_id'], __LINE__);
$smarty->assign('LayoutNews', $LayoutNews);

acl::ObjPermissionBarrier("edit", $LayoutNews, __FILE__, false);

$BlockContent = block::GetBlockContentInfo($_REQUEST['id']);
$smarty->assign('BlockContent', $BlockContent);
if ($BlockContent['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

$BlockHolder = block::GetBlockHolderInfo($BlockContent['parent_object_id']);
$smarty->assign('BlockHolder', $BlockHolder);
if ($BlockHolder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['layout_news_id'], __LINE__);

$BlockDef = block::GetBlockDefInfo($BlockHolder['block_definition_id']);
$smarty->assign('BlockDef', $BlockDef);
if ($BlockDef['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['layout_news_id'], __LINE__);

if ($BlockDef['block_definition_type'] == 'html') {
	$Editor	= new FCKeditor('ContentEditor');
	$Editor->BasePath = FCK_BASEURL;
	$Editor->Value	=  $BlockContent['block_content'];
	$Editor->Width	= '800';
	$Editor->Height	= '600';
	$EditorHTML	= $Editor->Create();
	$smarty->assign('EditorHTML', $EditorHTML);
}

$smarty->assign('TITLE', 'Edit Block');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_news_block_edit.tpl');