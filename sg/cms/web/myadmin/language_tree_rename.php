<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_xml_article.php');

header ("Content-Type:text/xml");

acl::AclBarrier("acl_sitemap_rename", __FILE__, true);

$Node = null;
$status = 'ERROR';
$Node = object::GetObjectLinkInfo($_REQUEST['link_id']);

if ($Node == null || $Node['site_id'] != $_SESSION['site_id'])
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

if (in_array($Node['object_type'], array ('SITE_ROOT', 'LIBRARY_ROOT')))
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

acl::ObjPermissionBarrier("edit", $Node, __FILE__, true);

if ($Node['object_type'] == 'FOLDER') {
	acl::AclBarrier("acl_folder_edit", __FILE__, true);
}
elseif ($Node['object_type'] == 'PAGE') {
	acl::AclBarrier("acl_page_edit", __FILE__, true);
}
elseif ($Node['object_type'] == 'LINK') {
	acl::AclBarrier("acl_link_edit", __FILE__, true);
}
elseif ($Node['object_type'] == 'NEWS_PAGE') {
	acl::AclBarrier("acl_news_page_edit", __FILE__, true);	
}
elseif ($Node['object_type'] == 'LAYOUT_NEWS_PAGE') {
	acl::AclBarrier("acl_layout_news_page_edit", __FILE__, true);
}
elseif ($Node['object_type'] == 'PRODUCT_ROOT') {	
	// Should no longer exist PRODUCT ROOT in language tree now
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
}
elseif ($Node['object_type'] == 'PRODUCT_ROOT_LINK') {
	acl::AclBarrier("acl_product_root_link_edit", __FILE__, true);
}
elseif ($Node['object_type'] == 'ALBUM') {
	acl::AclBarrier("acl_album_link_edit", __FILE__, true);
}

$query	=	"	UPDATE	object_link " .
			"	SET		object_name = '". aveEscT($_REQUEST['obj_name']) . "'" .
			"	WHERE	object_link_id = '" . intval($Node['object_link_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$status = 'ok';

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', $status);
$smarty->assign('msg', ADMIN_MSG_RENAME_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/language_tree_rename.tpl');