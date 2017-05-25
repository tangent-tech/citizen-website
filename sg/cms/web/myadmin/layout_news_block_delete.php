<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_layout_news.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_layout_news_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'layout_news');
$smarty->assign('MyJS', 'layout_news_block_delete');

$LayoutNews = layout_news::GetLayoutNewsInfo($_REQUEST['layout_news_id']);
if ($LayoutNews['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news.php', __LINE__);

acl::ObjPermissionBarrier("edit", $LayoutNews, __FILE__, false);

$BlockContent = block::GetBlockContentInfo($_REQUEST['id']);
$smarty->assign('BlockContent', $BlockContent);
if ($BlockContent['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

block::UpdateTimeStamp($BlockContent['block_content_id']);
block::DeleteBlockContent($BlockContent['block_content_id'], $Site, false);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: layout_news_edit.php?id=' . $_REQUEST['layout_news_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));