<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');

header ("Content-Type:text/xml");

$ParentObjID = substr($_REQUEST['table_id'], 18); // 18 = strlen('DatafileListTable-')
$ParentObj = object::GetObjectInfo($ParentObjID);
acl::ObjPermissionBarrier("edit", $ParentObj, __FILE__, false);

if ($ParentObj['site_id'] != $_SESSION['site_id'])
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
	
if ($ParentObj['object_type'] == 'PRODUCT') {
	require_once('../common/header_product.php');
	acl::AclBarrier("acl_product_edit", __FILE__, false);
}
elseif ($ParentObj['object_type'] == 'USER_DATAFILE_HOLDER') {
	require_once('../common/header_member.php');
	acl::AclBarrier("acl_member_edit", __FILE__, false);
}
elseif ($ParentObj['object_type'] == 'BONUS_POINT_ITEM') {
	require_once('../common/header_order.php');
	acl::AclBarrier("acl_bonuspoint_edit", __FILE__, false);
}
elseif ($ParentObj['object_type'] == 'ALBUM') {
	require_once('../common/header_album.php');
	acl::AclBarrier("acl_album_edit", __FILE__, false);	
}
acl::AclBarrier("acl_datafile_sort", __FILE__, false);

$DatafileIDList = $_REQUEST[$_REQUEST['table_id']];
$DatafileList = array();
foreach ($DatafileIDList as $did) {
	if ($did != null) {	
		$Datafile = datafile::GetDatafileInfo($did, 0);
		if ($Datafile['parent_object_id'] != $ParentObjID)
			XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
		$DatafileList[$did] = $Datafile;
	}
}

$orderid = intval($_REQUEST['num_of_datafile_per_page']) * (intval($_REQUEST['page_id']) - 1) + 1;
foreach ($DatafileIDList as $did) {
	if ($did != null) {
		$query =	"	UPDATE	object_link " .
					"	SET		order_id = '" . $orderid++ . "'" .
					"	WHERE	object_link_id	= '" . intval($DatafileList[$did]['object_link_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}
object::TidyUpObjectOrder($ParentObjID, 'DATAFILE');

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', 'ok');
$smarty->assign('msg', ADMIN_MSG_UPDATE_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/datafile_sort.tpl');