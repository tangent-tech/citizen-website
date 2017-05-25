<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_news.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_news_add", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'news');
$smarty->assign('MyJS', 'news_add_act');

$NoOfNews = news::GetNoOfNews($_SESSION['site_id']);
if ($NoOfNews >= $Site['site_module_news_quota'])
	AdminDie(ADMIN_ERROR_NEWS_QUOTA_FULL, 'news.php', __LINE__);

$NewsRoot = news::GetNewsRootInfo($_REQUEST['id']);
if ($NewsRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);

acl::ObjPermissionBarrier("add_children", $NewsRoot, __FILE__, false);

$NewsCategories = news::GetNewsCategoryList($NewsRoot['language_id'], $_SESSION['site_id']);
if (count($NewsCategories) == 0) {
	AdminDie(ADMIN_ERROR_NO_NEWS_CATEGORY, 'news_category_list.php?language_id=' . $NewsRoot['language_id'], __LINE__);
}

$tags = explode(",", $_REQUEST['news_tag']);
$NewsTagText = ', ';
foreach ($tags as $T)
	$NewsTagText = $NewsTagText . trim($T) . ", ";

$NewsDateText = $_REQUEST['news_date'] . " " . $_REQUEST['Time_Hour'] . ":" . $_REQUEST['Time_Minute'];

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];
$NewsID = object::NewObject('NEWS', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable'], $NewsRoot);

object::UpdateObjectSEOData($NewsID, $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($NewsID, $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

news::NewNews($NewsID, $_REQUEST['id'], $_REQUEST['news_title'], $_REQUEST['SummaryEditor'], $_REQUEST['ContentEditor'], $NewsDateText, $NewsTagText, $_REQUEST['news_category_id']);
news::UpdateTimeStamp($NewsID);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: news_edit.php?id=' . $NewsID .  '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));