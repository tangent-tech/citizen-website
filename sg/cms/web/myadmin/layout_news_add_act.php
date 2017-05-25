<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_layout_news.php');

acl::AclBarrier("acl_layout_news_add", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'layout_news');
$smarty->assign('MyJS', 'layout_news_add_act');

$NoOfLayoutNews = layout_news::GetNoOfLayoutNews($_SESSION['site_id']);
if ($NoOfLayoutNews >= $Site['site_module_layout_news_quota'])
	AdminDie(ADMIN_ERROR_LAYOUT_NEWS_QUOTA_FULL, 'layout_news.php', __LINE__);

$LayoutNewsRoot = layout_news::GetLayoutNewsRootInfo($_REQUEST['id']);
if ($LayoutNewsRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news.php', __LINE__);

$LayoutNewsCategories = layout_news::GetLayoutNewsCategoryList($LayoutNewsRoot['language_id'], $_SESSION['site_id']);
if (count($LayoutNewsCategories) == 0) {
	AdminDie(ADMIN_ERROR_NO_LAYOUT_NEWS_CATEGORY, 'layout_news_category_list.php?language_id=' . $LayoutNewsRoot['language_id'], __LINE__);
}

acl::ObjPermissionBarrier("add_children", $LayoutNewsRoot, __FILE__, false);

$tags = explode(",", $_REQUEST['layout_news_tag']);
$LayoutNewsTagText = ', ';
foreach ($tags as $T)
	$LayoutNewsTagText = $LayoutNewsTagText . trim($T) . ", ";

$LayoutNewsDateText = $_REQUEST['layout_news_date'] . " " . $_REQUEST['Time_Hour'] . ":" . $_REQUEST['Time_Minute'];

$LayoutNewsID = object::NewObject('LAYOUT_NEWS', $_SESSION['site_id'], $_REQUEST['object_security_level'], OBJECT_DEFAULT_ARCHIVE_DATE, OBJECT_DEFAULT_PUBLISH_DATE, 'Y', 'Y', $LayoutNewsRoot);

object::UpdateObjectSEOData($LayoutNewsID, $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);

layout_news::NewLayoutNews($LayoutNewsID, $_REQUEST['id'], $_REQUEST['layout_news_title'], $LayoutNewsDateText, $LayoutNewsTagText, $_REQUEST['layout_news_category_id'], $_REQUEST['layout_id'], $_REQUEST['album_id']);
layout_news::UpdateTimeStamp($LayoutNewsID);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: layout_news_edit.php?id=' . $LayoutNewsID .  '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));