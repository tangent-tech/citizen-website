<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_layout_news.php');

acl::AclBarrier("acl_layout_news_delete", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'layout_news');
$smarty->assign('MyJS', 'layout_news_edit');

$LayoutNews = layout_news::GetLayoutNewsInfo($_REQUEST['id']);
if ($LayoutNews['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news.php', __LINE__);
$smarty->assign('LayoutNews', $LayoutNews);

acl::ObjPermissionBarrier("delete", $LayoutNews, __FILE__, false);

layout_news::UpdateTimeStamp($_REQUEST['id']);
layout_news::DeleteLayoutNews($_REQUEST['id'], $Site);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: layout_news_list.php?id=' . $LayoutNews['layout_news_root_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));