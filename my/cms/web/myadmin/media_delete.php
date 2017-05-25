<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_media_delete", __FILE__, false);

if ($_REQUEST['refer'] == 'product_edit')
	require_once('../common/header_product.php');
elseif ($_REQUEST['refer'] == 'product_category_edit' || $_REQUEST['refer'] == 'product_category_special_edit')
	require_once('../common/header_product.php');
elseif ($_REQUEST['refer'] == 'bonuspoint_edit')
	require_once('../common/header_order.php');
else
	require_once('../common/header_album.php');

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');
$smarty->assign('MyJS', 'media_delete');

$Media = media::GetMediaInfo($_REQUEST['id'], 0);
if ($Media['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);

$ParentObj = object::GetParentObjForPermissionChecking($Media);
acl::ObjPermissionBarrier("edit", $ParentObj, __FILE__, false);

media::UpdateTimeStamp($Media['media_id']);
media::DeleteMedia($Media['media_id'], $Site);

site::EmptyAPICache($_SESSION['site_id']);

if ($_REQUEST['refer'] == 'product_edit')
	header( 'Location: product_edit.php?link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'product_category_edit')
	header( 'Location: product_category_edit.php?link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'product_category_special_edit')
	header( 'Location: product_category_special_edit.php?link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'bonuspoint_edit')
	header( 'Location: bonuspoint_edit.php?id=' . $_REQUEST['parent_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
else
	header( 'Location: media_list.php?id=' . $Media['parent_object_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));