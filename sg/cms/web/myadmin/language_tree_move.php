<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_xml_article.php');

header ("Content-Type:text/xml");

acl::AclBarrier("acl_sitemap_move", __FILE__, true);

$status = 'ok';
$id = 0;
$link_id = 0;

$RefObjectLink = object::GetObjectLinkInfo($_REQUEST['ref_link_id']);
$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);

$AllowedObjectParent = array();

if ($ObjectLink['object_type'] == 'PAGE') {
	acl::AclBarrier("acl_page_move", __FILE__, true);
	$AllowedObjectParent = array('FOLDER');
}
elseif ($ObjectLink['object_type'] == 'FOLDER') {
	acl::AclBarrier("acl_folder_move", __FILE__, true);
	$AllowedObjectParent = array('FOLDER', 'LANGUAGE_ROOT');
}
elseif ($ObjectLink['object_type'] == 'LINK') {
	acl::AclBarrier("acl_link_move", __FILE__, true);	
	$AllowedObjectParent = array('FOLDER');
}
elseif ($ObjectLink['object_type'] == 'ALBUM') {
	acl::AclBarrier("acl_album_link_move", __FILE__, true);	
	$AllowedObjectParent = array('FOLDER');
}
elseif ($ObjectLink['object_type'] == 'NEWS_PAGE') {
	acl::AclBarrier("acl_news_page_move", __FILE__, true);		
	$AllowedObjectParent = array('FOLDER');
}
elseif ($ObjectLink['object_type'] == 'LAYOUT_NEWS_PAGE') {
	acl::AclBarrier("acl_layout_news_page_move", __FILE__, true);			
	$AllowedObjectParent = array('FOLDER');
}
elseif ($ObjectLink['object_type'] == 'PRODUCT_ROOT') {
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);	
	acl::AclBarrier("acl_product_root_link_move", __FILE__, true);		
	$AllowedObjectParent = array('FOLDER');	
}
elseif ($ObjectLink['object_type'] == 'PRODUCT_ROOT_LINK') {
	acl::AclBarrier("acl_product_root_link_move", __FILE__, true);	
	$AllowedObjectParent = array('FOLDER');	
}
else
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

object::ValidateMoveObjectInTree($AllowedObjectParent, $ObjectLink, $RefObjectLink, $_REQUEST['move_type'], $_SESSION['site_id']);
object::MoveObject($ObjectLink, $RefObjectLink, $_REQUEST['move_type']);

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', $status);
$smarty->assign('id', $id);
$smarty->assign('link_id', $link_id);
$smarty->assign('msg', ADMIN_MSG_UPDATE_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/language_tree_move.tpl');