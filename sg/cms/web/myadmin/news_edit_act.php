<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_news.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_news_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'news');
$smarty->assign('MyJS', 'news_edit_act');

$News = news::GetNewsInfo($_REQUEST['id']);
if ($News['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);

acl::ObjPermissionBarrier("edit", $News, __FILE__, false);

$NewsCategories = news::GetNewsCategoryList($News['language_id'], $_SESSION['site_id']);
if (count($NewsCategories) == 0) {
	AdminDie(ADMIN_ERROR_NO_NEWS_CATEGORY, 'news_category_list.php?language_id=' . $News['language_id'], __LINE__);
}

$NewsCategory = news::GetNewsCategoryInfo($_REQUEST['news_category_id']);
if ($NewsCategory['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

$query	=	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['object_is_enable']) . "', " .
			"			object_archive_date		= '" . aveEscT($ObjectArchiveDateText) . "', " .
			"			object_publish_date		= '" . aveEscT($ObjectPublishDateText) . "', " .
			"			object_security_level	= '" . intval($_REQUEST['object_security_level']) . "' " .
			"	WHERE	object_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::UpdateObjectSEOData($_REQUEST['id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($_REQUEST['id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

$tags = explode(",", $_REQUEST['news_tag']);
$NewsTagText = ', ';
foreach ($tags as $T)
	$NewsTagText = $NewsTagText . trim($T) . ", ";
$NewsDateText = $_REQUEST['news_date'] . " " . $_REQUEST['Time_Hour'] . ":" . $_REQUEST['Time_Minute'];

$query =	"	UPDATE	news " .
			"	SET		news_title			= '" . aveEscT($_REQUEST['news_title']) . "', " .
			"			news_summary		= '" . aveEscT($_REQUEST['SummaryEditor']) . "', " .
			"			news_content		= '" . aveEscT($_REQUEST['ContentEditor']) . "', " .
			"			news_date			= '" . aveEscT($NewsDateText) . "', " .
			"			news_tag			= '" . aveEsc($NewsTagText) . "', " .
			"			news_category_id	= '" . intval($_REQUEST['news_category_id']) . "', " .
			"			album_id			= '" . intval($_REQUEST['album_id']) . "'" .
			"	WHERE	news_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

news::UpdateTimeStamp($_REQUEST['id']);
site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: news_edit.php?id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));