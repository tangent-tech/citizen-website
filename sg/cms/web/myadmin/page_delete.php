<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_article.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'page_delete');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

$Page = page::GetPageInfo($ObjectLink['object_id']);
if ($Page['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

page::UpdateTimeStamp($Page['page_id']);
page::DeletePage($Page['page_id'], $Site);
site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: language_tree.php?id=' . $ObjectLink['language_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));