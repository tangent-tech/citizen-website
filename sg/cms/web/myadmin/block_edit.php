<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_article.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_sitemap_edit", __FILE__, false);
acl::AclBarrier("acl_page_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'block_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$Page = page::GetPageInfo($ObjectLink['object_id']);
if ($Page['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $ObjectLink['object_link_id'], __LINE__);
$smarty->assign('Page', $Page);

$BlockContent = block::GetBlockContentInfo($_REQUEST['id']);
$smarty->assign('BlockContent', $BlockContent);
$smarty->assign('TheObject', $BlockContent);
if ($BlockContent['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

$BlockHolder = block::GetBlockHolderInfo($BlockContent['parent_object_id']);
$smarty->assign('BlockHolder', $BlockHolder);
if ($BlockHolder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $ObjectLink['object_link_id'], __LINE__);

$BlockDef = block::GetBlockDefInfo($BlockHolder['block_definition_id']);
$smarty->assign('BlockDef', $BlockDef);
if ($BlockDef['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $ObjectLink['object_link_id'], __LINE__);

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
$smarty->display("myadmin/" . $CurrentLang['language_id'] . "/block_edit.tpl");