<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_article.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_siteblock_delete", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'siteblock');
$smarty->assign('MyJS', 'siteblock_delete');

$BlockContent = block::GetBlockContentInfo($_REQUEST['id']);
if ($BlockContent['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'siteblock.php', __LINE__);

acl::ObjPermissionBarrier("delete", $BlockContent, __FILE__, false);

block::DeleteBlockContent($BlockContent['block_content_id'], $Site, false);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: siteblock.php?language_id=' . $BlockContent['language_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));