<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_album.php');

acl::AclBarrier("acl_sitemap_delete", __FILE__, false);
acl::AclBarrier("acl_album_link_delete", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$smarty->assign('ObjectLink', $ObjectLink);

$Album = album::GetAlbumInfo($ObjectLink['object_id'], $ObjectLink['language_id']);
if ($Album == null)
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');

album::DeleteAlbumRootLink($_REQUEST['link_id']);
site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: language_tree.php?id=' . $ObjectLink['language_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));