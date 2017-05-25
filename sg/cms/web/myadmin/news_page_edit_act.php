<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_news.php');

acl::AclBarrier("acl_news_page_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'news_page_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$smarty->assign('ObjectLink', $ObjectLink);

$NewsPage = news::GetNewsPageInfo($ObjectLink['object_id']);
if ($NewsPage == null)
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');

$NewsRoot = news::GetNewsRootInfo($_REQUEST['news_root_id']);
if ($NewsRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');

if ($_REQUEST['news_category_id'] != 0) {
	$NewsCategory = news::GetNewsCategoryInfo($_REQUEST['news_category_id']);
	if ($NewsCategory['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
}

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

$query	=	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['object_is_enable']) . "', " .
			"			object_archive_date		= '" . aveEscT($ObjectArchiveDateText) . "', " .
			"			object_publish_date		= '" . aveEscT($ObjectPublishDateText) . "', " .
			"			object_security_level	= '" . intval($_REQUEST['object_security_level']) . "' " .
			"	WHERE	object_id = '" . intval($ObjectLink['object_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::UpdateObjectSEOData($ObjectLink['object_id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($ObjectLink['object_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

object::UpdateObjectTimeStamp($ObjectLink['object_id']);

$query =	"	UPDATE	news_page " .
			"	SET		news_root_id		= '". intval($_REQUEST['news_root_id']) . "'," .
			"			news_category_id	= '" . intval($_REQUEST['news_category_id']) . "'" .
			"	WHERE	news_page_id =  '" . intval($ObjectLink['object_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: news_page_edit.php?link_id=' . $_REQUEST['link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));