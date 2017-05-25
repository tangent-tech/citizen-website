<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_news.php');

acl::AclBarrier("acl_news_delete", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'news');
$smarty->assign('MyJS', 'news_edit');

$News = news::GetNewsInfo($_REQUEST['id']);
if ($News['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);
$smarty->assign('News', $News);
acl::ObjPermissionBarrier("delete", $News, __FILE__, false);

news::UpdateTimeStamp($_REQUEST['id']);
news::DeleteNews($_REQUEST['id']);
site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: news_list.php?id=' . $News['news_root_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));