<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_article.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_sitemap_edit", __FILE__, false);
acl::AclBarrier("acl_page_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'page_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);
acl::SetIsPublisherFlagForSmarty($ObjectLink);

$Page = page::GetPageInfo($ObjectLink['object_id']);
if ($Page['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$Page['object_seo_url'] = object::GetSeoURL($ObjectLink, '', $ObjectLink['language_id'], $Site);
$smarty->assign('Page', $Page);
$smarty->assign('TheObject', $Page);

$Layouts = layout::GetLayoutList($_SESSION['site_id']);
$smarty->assign('Layouts', $Layouts);

$BlockDefs = block::GetBlockDefListByLayoutID($Page['layout_id']);
$smarty->assign('BlockDefs', $BlockDefs);

$Albums = album::GetAlbumList($Site['album_root_id']);
$smarty->assign('Albums', $Albums);

$BlockContents = array();
foreach ($BlockDefs as $key => $value) {
	block::TouchBlockHolderList($Page['page_id'], $value['block_definition_id'], $_SESSION['site_id'], $Page['language_id']);
	$BlockContentList = block::GetBlockContentListByPageID($Page['page_id'], $value['block_definition_id']);
	$BlockContents[$value['block_definition_id']] = $BlockContentList;
}
$smarty->assign('BlockContents', $BlockContents);

$smarty->assign('TITLE', 'Edit Page');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/page_edit.tpl');