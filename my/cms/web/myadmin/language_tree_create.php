<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');

header ("Content-Type:text/xml");

acl::AclBarrier("acl_sitemap_add", __FILE__, true);

$status = 'ok';
$id = 0;
$link_id = 0;

$RefObjectLink = object::GetObjectLinkInfo($_REQUEST['ref_link_id']);

if ($_REQUEST['new_object_type'] == 'FOLDER') {
	acl::AclBarrier("acl_folder_add", __FILE__, true);
	
	object::ValidateCreateObjectInTree(array('FOLDER', 'LANGUAGE_ROOT'), $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id']);
	object::CreateObjectInTree($_REQUEST['new_object_type'], $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id'], $id, $link_id);
	folder::NewFolder($id, '');
}
elseif ($_REQUEST['new_object_type'] == 'PAGE') {
	acl::AclBarrier("acl_page_add", __FILE__, true);

	$NoOfPages = page::GetNoOfPage($_SESSION['site_id']);
	if ($NoOfPages >= $Site['site_module_article_quota'])
		XMLDie(__LINE__, ADMIN_ERROR_ARTICLE_QUOTA_FULL);

	object::ValidateCreateObjectInTree(array('FOLDER'), $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id']);
	object::CreateObjectInTree($_REQUEST['new_object_type'], $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id'], $id, $link_id);
	page::NewPage($id, '', 0);
}
elseif ($_REQUEST['new_object_type'] == 'LINK') {
	acl::AclBarrier("acl_link_add", __FILE__, true);

	object::ValidateCreateObjectInTree(array('FOLDER'), $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id']);
	object::CreateObjectInTree($_REQUEST['new_object_type'], $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id'], $id, $link_id);
	link::NewLink($id, '');
}
elseif ($_REQUEST['new_object_type'] == 'NEWS_PAGE') {
	acl::AclBarrier("acl_news_page_add", __FILE__, true);

	$NewsRoot = news::GetNewsRootInfo($_REQUEST['object_id']);
	if ($NewsRoot == null || $NewsRoot['site_id'] != $_SESSION['site_id'])
		XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

	object::ValidateCreateObjectInTree(array('FOLDER'), $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id']);
	object::CreateObjectInTree($_REQUEST['new_object_type'], $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id'], $id, $link_id, $NewsRoot['news_root_name']);
	news::NewNewsPage($id, $_REQUEST['object_id'], 0);
}
elseif ($_REQUEST['new_object_type'] == 'LAYOUT_NEWS_PAGE') {
	acl::AclBarrier("acl_layout_news_page_add", __FILE__, true);

	$LayoutNewsRoot = layout_news::GetLayoutNewsRootInfo($_REQUEST['object_id']);
	if ($LayoutNewsRoot == null || $LayoutNewsRoot['site_id'] != $_SESSION['site_id'])
		XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

	object::ValidateCreateObjectInTree(array('FOLDER'), $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id']);
	object::CreateObjectInTree($_REQUEST['new_object_type'], $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id'], $id, $link_id, $LayoutNewsRoot['layout_news_root_name']);
	layout_news::NewLayoutNewsPage($id, $_REQUEST['object_id'], 0);
}
elseif ($_REQUEST['new_object_type'] == 'PRODUCT_ROOT') {
	// Should no longer exist PRODUCT ROOT in language tree now
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
	
	acl::AclBarrier("acl_product_root_link_add", __FILE__, true);
	
	$ProductRoot = product::GetProductRootInfo($_REQUEST['object_id']);
	if ($ProductRoot == null || $ProductRoot['site_id'] != $_SESSION['site_id'])
		XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

	$id = $_REQUEST['object_id'];
	object::ValidateCreateObjectInTree(array('FOLDER'), $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id']);
	object::CreateObjectLinkInTree($_REQUEST['new_object_type'], $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id'], $id, $link_id, $ProductRoot['object_name']);
}
elseif ($_REQUEST['new_object_type'] == 'PRODUCT_ROOT_LINK') {
	acl::AclBarrier("acl_product_root_link_add", __FILE__, true);

	$ProductRoot = product::GetProductRootInfo($_REQUEST['object_id']);
	if ($ProductRoot == null || $ProductRoot['site_id'] != $_SESSION['site_id'])
		XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

	object::ValidateCreateObjectInTree(array('FOLDER'), $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id']);
	object::CreateObjectInTree($_REQUEST['new_object_type'], $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id'], $id, $link_id, $ProductRoot['object_name']);
	product::NewProductRootLink($id, $_REQUEST['object_id']);
}
elseif ($_REQUEST['new_object_type'] == 'ALBUM') {
	acl::AclBarrier("acl_album_link_add", __FILE__, true);

	$Album = album::GetAlbumInfo($_REQUEST['object_id'], $RefObjectLink['language_id']);
	if ($Album == null || $Album['site_id'] != $_SESSION['site_id'])
		XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

	$id = $_REQUEST['object_id'];
	object::ValidateCreateObjectInTree(array('FOLDER'), $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id']);
	object::CreateObjectLinkInTree($_REQUEST['new_object_type'], $RefObjectLink, $_REQUEST['create_type'], $_SESSION['site_id'], $id, $link_id, $Album['object_name']);
}
else {
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
}

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', $status);
$smarty->assign('id', $id);
$smarty->assign('link_id', $link_id);
$smarty->assign('msg', ADMIN_MSG_NEW_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/language_tree_create.tpl');