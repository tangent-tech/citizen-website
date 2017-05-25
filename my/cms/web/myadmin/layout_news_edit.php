<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_layout_news.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_layout_news_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
//$smarty->assign('CurrentTab2', 'layout_news');
$smarty->assign('MyJS', 'layout_news_edit');

$LayoutNews = layout_news::GetLayoutNewsInfo($_REQUEST['id']);
if ($LayoutNews['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news.php', __LINE__);
$LayoutNews['object_seo_url'] = object::GetSeoURL($LayoutNews, '', $LayoutNews['language_id'], $Site);
$smarty->assign('LayoutNews', $LayoutNews);
$smarty->assign('TheObject', $LayoutNews);
$smarty->assign('CurrentLayoutNewsRootID', $LayoutNews['layout_news_root_id']);

acl::ObjPermissionBarrier("edit", $LayoutNews, __FILE__, false);
acl::SetIsPublisherFlagForSmarty($LayoutNews);

$Layouts = layout::GetLayoutList($_SESSION['site_id']);
$smarty->assign('Layouts', $Layouts);

$BlockDefs = block::GetBlockDefListByLayoutID($LayoutNews['layout_id']);
$smarty->assign('BlockDefs', $BlockDefs);

$Albums = album::GetAlbumList($Site['album_root_id']);
$smarty->assign('Albums', $Albums);

$LayoutNewsCategories = layout_news::GetLayoutNewsCategoryList($LayoutNews['language_id'], $_SESSION['site_id']);
if (count($LayoutNewsCategories) == 0) {
	AdminDie(ADMIN_ERROR_NO_LAYOUT_NEWS_CATEGORY, 'layout_news_category_list.php?language_id=' . $LayoutNews['language_id'], __LINE__);
}
$smarty->assign('LayoutNewsCategories', $LayoutNewsCategories);

$Albums = album::GetAlbumList($Site['album_root_id']);
$smarty->assign('Albums', $Albums);

$BlockContents = array();
foreach ($BlockDefs as $key => $value) {
	block::TouchBlockHolderList($LayoutNews['layout_news_id'], $value['block_definition_id'], $_SESSION['site_id'], $LayoutNews['language_id']);
	$BlockContentList = block::GetBlockContentListByLayoutNewsID($LayoutNews['layout_news_id'], $value['block_definition_id']);
	$BlockContents[$value['block_definition_id']] = $BlockContentList;
}
$smarty->assign('BlockContents', $BlockContents);

$LayoutNewsTagText = $LayoutNews['layout_news_tag'];
$LayoutNewsTagText = substr($LayoutNewsTagText, 2, -2);
$smarty->assign('LayoutNewsTagText', $LayoutNewsTagText);

$smarty->assign('TITLE', 'Edit Layout News');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_news_edit.tpl');