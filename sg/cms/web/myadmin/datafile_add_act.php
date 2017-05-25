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
acl::AclBarrier("acl_datafile_add", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');
$smarty->assign('MyJS', 'datafile_add_act');

$TheUserID = 0;

if ($_REQUEST['refer'] == 'product_edit') {

	$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
	if ($ObjectLink['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
	$smarty->assign('ObjectLink', $ObjectLink);

	$Product = product::GetProductInfo($ObjectLink['object_id'], 0);
	if ($Product['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

	acl::ObjPermissionBarrier("edit", $Product, __FILE__, false);
}
elseif ($_REQUEST['refer'] == 'member_edit') {
	$UserDatafileHolder = user::GetUserDatafileHolder($_REQUEST['id']);
	
	$TheUserID = $UserDatafileHolder['user_id'];
	
	if ($UserDatafileHolder['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'member_list.php', __LINE__);

	acl::ObjPermissionBarrier("edit", $UserDatafileHolder, __FILE__, false);	
}
else {
	// Where the hell are you coming from?????
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);
}

if (!isset($_REQUEST['datafile_security_level']))
	$_REQUEST['datafile_security_level'] = $Site['datafile_security_level'];

$DatafileFiles = ReformatMultiFilePost($_FILES['datafile']);
foreach ($DatafileFiles as $TheFile) {
	if (isset($TheFile)) {
		$DatafileID = datafile::NewDatafileWithObject($TheFile, $Site, $_REQUEST['datafile_security_level']);
		
		if ($DatafileID !== false && $DatafileID != 0) {
			object::NewObjectLink($_REQUEST['id'], $DatafileID, 'Datafile File', 0, 'normal', DEFAULT_ORDER_ID);
			object::TidyUpObjectOrder($_REQUEST['id'], 'DATAFILE');
			media::UpdateTimeStamp($DatafileID);
		}
	}
}

site::EmptyAPICache($_SESSION['site_id']);

if ($_REQUEST['refer'] == 'product_edit')
	header( 'Location: product_edit.php?link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'member_edit')
	header( 'Location: member_edit.php?id=' . $TheUserID . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
else
	die("Error: Unknown referral for datafile upload!");