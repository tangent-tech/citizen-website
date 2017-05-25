<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_article.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_sitemap_edit", __FILE__, false);
acl::AclBarrier("acl_page_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'block_delete');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$BlockContent = block::GetBlockContentInfo($_REQUEST['id']);
$smarty->assign('BlockContent', $BlockContent);
if ($BlockContent['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

block::UpdateTimeStamp($BlockContent['block_content_id']);
block::DeleteBlockContent($BlockContent['block_content_id'], $Site, false);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: page_edit.php?link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));