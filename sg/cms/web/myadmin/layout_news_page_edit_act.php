<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_layout_news.php');

acl::AclBarrier("acl_sitemap_edit", __FILE__, false);
acl::AclBarrier("acl_layout_news_page_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'layout_news_page_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$smarty->assign('ObjectLink', $ObjectLink);

$LayoutNewsPage = layout_news::GetLayoutNewsPageInfo($ObjectLink['object_id']);
if ($LayoutNewsPage == null)
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');

acl::ObjPermissionBarrier("edit", $LayoutNewsPage, __FILE__, false);

if (intval($_REQUEST['layout_news_root_id']) != 0) {
	$LayoutNewsRoot = layout_news::GetLayoutNewsRootInfo($_REQUEST['layout_news_root_id']);
	if ($LayoutNewsRoot['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');	
}

if (intval($_REQUEST['layout_news_category_id']) != 0) {
	$LayoutNewsCategory = layout_news::GetLayoutNewsCategoryInfo($_REQUEST['layout_news_category_id']);
	if ($LayoutNewsCategory['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
}

object::UpdateObjectCommonDataFromRequest($ObjectLink);
object::UpdateObjectSEOData($ObjectLink['object_id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($ObjectLink['object_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

object::UpdateObjectTimeStamp($ObjectLink['object_id']);

$query =	"	UPDATE	layout_news_page " .
			"	SET		layout_news_root_id		= '". intval($_REQUEST['layout_news_root_id']) . "'," .
			"			layout_news_category_id	= '" . intval($_REQUEST['layout_news_category_id']) . "'" .
			"	WHERE	layout_news_page_id =  '" . intval($ObjectLink['object_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: layout_news_page_edit.php?link_id=' . $_REQUEST['link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));