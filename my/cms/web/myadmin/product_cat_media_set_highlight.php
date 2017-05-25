<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');

$Site = site::GetSiteInfo($_SESSION['site_id']);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

if ($_REQUEST['refer'] == 'product_category_edit') {
	acl::AclBarrier("acl_product_category_edit", __FILE__, false);

$ProductCat = product::GetProductCatInfo($ObjectLink['object_id'], 0);	
}
elseif ($_REQUEST['refer'] == 'product_category_special_edit') {
	acl::AclBarrier("acl_product_category_special_edit", __FILE__, false);

	$ProductCat = product::GetProductCatSpecialInfo($ObjectLink['object_id'], 0);
}
else
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

if ($ProductCat['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

acl::ObjPermissionBarrier("edit", $ProductCat, __FILE__, false);

$Media = media::GetMediaInfo($_REQUEST['id'], 0);
if ($Media['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

$NewFileID = filebase::CloneFile($Media['media_small_file_id'], $Site, $ObjectLink['object_id']);

if ($NewFileID != false) {
	if ($ObjectLink['object_thumbnail_file_id'] != 0)
		filebase::DeleteFile($ObjectLink['object_thumbnail_file_id'], $Site);
	
	$query =	"	UPDATE	object " .
				"	SET		object_thumbnail_file_id	= '" . intval($NewFileID) . "'" .
				"	WHERE	object_id = '" . intval($ObjectLink['object_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

if ($_REQUEST['refer'] == 'product_category_edit') {
	product::UpdateTimeStampProductCat($ObjectLink['object_id']);
site::EmptyAPICache($_SESSION['site_id']);
header( 'Location: product_category_edit.php?link_id=' . $_REQUEST['link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
}
elseif ($_REQUEST['refer'] == 'product_category_special_edit') {
	object::UpdateObjectTimeStamp($ObjectLink['object_id']);
	site::EmptyAPICache($_SESSION['site_id']);
	header( 'Location: product_category_special_edit.php?link_id=' . $_REQUEST['link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
}