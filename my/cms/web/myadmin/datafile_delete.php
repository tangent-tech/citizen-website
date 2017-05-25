<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

if ($_REQUEST['refer'] == 'product_edit') {
	require_once('../common/header_product.php');
	acl::AclBarrier("acl_product_edit", __FILE__, false);
}
elseif ($_REQUEST['refer'] == 'member_edit') {
	require_once('../common/header_member.php');
	acl::AclBarrier("acl_member_edit", __FILE__, false);	
}
elseif ($_REQUEST['refer'] == 'bonuspoint_edit') {
	require_once('../common/header_order.php');
	acl::AclBarrier("acl_bonuspoint_edit", __FILE__, false);
}
else {
	require_once('../common/header_album.php');
	acl::AclBarrier("acl_album_edit", __FILE__, false);	
}
acl::AclBarrier("acl_datafile_delete", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');
$smarty->assign('MyJS', 'datafile_delete');

$Datafile = datafile::GetDatafileInfo($_REQUEST['id'], 0);
if ($Datafile['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);

$ParentObj = object::GetParentObjForPermissionChecking($Datafile);
acl::ObjPermissionBarrier("edit", $ParentObj, __FILE__, false);

datafile::UpdateTimeStamp($Datafile['datafile_id']);
datafile::DeleteDatafile($Datafile['datafile_id'], $Site);

site::EmptyAPICache($_SESSION['site_id']);

if ($_REQUEST['refer'] == 'product_edit')
	header( 'Location: product_edit.php?link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'member_edit')
	header( 'Location: member_edit.php?id=' . $_REQUEST['user_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'bonuspoint_edit')
	header( 'Location: bonuspoint_edit.php?id=' . $_REQUEST['parent_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
else
	header( 'Location: datafile_list.php?id=' . $Datafile['parent_object_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));