<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_article.php');

acl::AclBarrier("acl_folder_delete", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'folder_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'language_tree.php?id=' . $ObjectLink['language_id']);
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("delete", $ObjectLink, __FILE__, false);

if (!folder::IsFolderRemovable($ObjectLink['object_id']))
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'language_tree.php?id=' . $ObjectLink['language_id']);

folder::UpdateTimeStamp($ObjectLink['object_id']);
folder::DeleteFolder($ObjectLink['object_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: language_tree.php?id=' . $ObjectLink['language_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));