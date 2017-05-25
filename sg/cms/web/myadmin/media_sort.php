<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');

header ("Content-Type:text/xml");

acl::AclBarrier("acl_media_sort", __FILE__, true);

$ParentObjectID = substr($_REQUEST['table_id'], 15);
$ParentObj = object::GetObjectInfo($ParentObjectID);
if ($ParentObj['site_id'] != $_SESSION['site_id'])
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

acl::ObjPermissionBarrier("edit", $ParentObj, __FILE__, true);

$MediaIDList = $_REQUEST[$_REQUEST['table_id']];
$MediaList = array();
foreach ($MediaIDList as $mid) {
	if ($mid != null) {
		$Media = media::GetMediaInfo($mid, 0);
		if ($Media['parent_object_id'] != $ParentObjectID)
			XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
		$MediaList[$mid] = $Media;
	}
}

$orderid = intval($_REQUEST['num_of_photos_per_page']) * (intval($_REQUEST['page_id']) - 1) + 1;
foreach ($MediaIDList as $mid) {
	if ($mid != null) {
		$query =	"	UPDATE	object_link " .
					"	SET		order_id = '" . $orderid++ . "'" .
					"	WHERE	object_link_id	= '" . intval($MediaList[$mid]['object_link_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}
object::TidyUpObjectOrder($ParentObjectID, 'MEDIA');

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', 'ok');
$smarty->assign('msg', ADMIN_MSG_UPDATE_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/media_sort.tpl');