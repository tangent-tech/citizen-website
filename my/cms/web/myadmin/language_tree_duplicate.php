<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');

header ("Content-Type:text/xml");

acl::AclBarrier("acl_sitemap_duplicate", __FILE__, true);

$status = 'ok';

$RefObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);

$NewObjectID = 0;
$NewObjectLinkID = 0;

if ($RefObjectLink['site_id'] != $_SESSION['site_id'])
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

$ParentObj = object::GetObjectInfo($RefObjectLink['parent_object_id']);
acl::ObjPermissionBarrier("add_children", $ParentObj, __FILE__, true);

if ($_REQUEST['object_type'] == 'FOLDER') {
	acl::AclBarrier("acl_folder_duplicate", __FILE__, true);
	
	$Folder = folder::GetFolderDetails($RefObjectLink['object_id']);
	folder::CloneFolder($Folder, $Site, $RefObjectLink['parent_object_id'], $RefObjectLink['language_id'], $NewObjectID, $NewObjectLinkID, 'Y', 'Y');
}
elseif ($_REQUEST['object_type'] == 'PAGE') {
	acl::AclBarrier("acl_page_duplicate", __FILE__, true);

	$NoOfPages = page::GetNoOfPage($_SESSION['site_id']);
	if ($NoOfPages >= $Site['site_module_article_quota'])
		XMLDie(__LINE__, ADMIN_ERROR_ARTICLE_QUOTA_FULL);

	$Page = page::GetPageInfo($RefObjectLink['object_id']);
	
	page::ClonePage($Page, $Site, $RefObjectLink['parent_object_id'], $RefObjectLink['language_id'], $NewObjectID, $NewObjectLinkID, 'Y', 'Y');
}
elseif ($_REQUEST['object_type'] == 'LINK') {
	acl::AclBarrier("acl_link_duplicate", __FILE__, true);

	$Link = link::GetLinkInfo($RefObjectLink['object_id']);
	link::CloneLink($Link, $Site, $RefObjectLink['parent_object_id'], $RefObjectLink['language_id'], $NewObjectID, $NewObjectLinkID, 'Y', 'Y');
}
elseif ($_REQUEST['object_type'] == 'NEWS_PAGE') {
	acl::AclBarrier("acl_news_page_duplicate", __FILE__, true);	
	
	$NewsPage = news::GetNewsPageInfo($RefObjectLink['object_id']);
	news::CloneNewsPage($NewsPage, $Site, $RefObjectLink['parent_object_id'], $RefObjectLink['language_id'], $NewObjectID, $NewObjectLinkID, 'Y', 'Y');
}
elseif ($_REQUEST['object_type'] == 'LAYOUT_NEWS_PAGE') {
	acl::AclBarrier("acl_layout_news_page_duplicate", __FILE__, true);	

	$LayoutNewsPage = layout_news::GetLayoutNewsPageInfo($RefObjectLink['object_id']);
	layout_news::CloneLayoutNewsPage($LayoutNewsPage, $Site, $RefObjectLink['parent_object_id'], $RefObjectLink['language_id'], $NewObjectID, $NewObjectLinkID, 'Y', 'Y');
}
elseif ($_REQUEST['object_type'] == 'PRODUCT_ROOT') {	
	// Should no longer exist PRODUCT ROOT in language tree now
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
}
elseif ($_REQUEST['object_type'] == 'PRODUCT_ROOT_LINK') {
	acl::AclBarrier("acl_product_root_link_duplicate", __FILE__, true);
	
	$ProductRootLink = product::GetProductRootLink($RefObjectLink['object_link_id']);
	product::CloneProductRootLink($ProductRootLink, $Site, $RefObjectLink['parent_object_id'], $RefObjectLink['language_id'], $NewObjectID, $NewObjectLinkID, 'Y', 'Y');
}
elseif ($_REQUEST['object_type'] == 'ALBUM') {
	acl::AclBarrier("acl_album_link_duplicate", __FILE__, true);
	
	object::CloneObjectLink($RefObjectLink, $Site, $RefObjectLink['parent_object_id'], $RefObjectLink['language_id'], $NewObjectLinkID, 'Y', 'Y');
}
else {
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
}

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('id', $NewObjectID);
$smarty->assign('link_id', $NewObjectLinkID);

$smarty->assign('status', $status);
$smarty->assign('msg', ADMIN_MSG_NEW_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/language_tree_duplicate.tpl');