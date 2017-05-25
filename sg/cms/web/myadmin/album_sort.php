<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_xml_album.php');

acl::AclBarrier("acl_album_sort", __FILE__, true);

header ("Content-Type:text/xml");

$AlbumIDList = $_REQUEST[$_REQUEST['table_id']];
$AlbumList = array();
foreach ($AlbumIDList as $aid) {
	if ($aid != null) {
		$Album = album::GetAlbumInfo($aid, 0);
		if ($Album['site_id'] != $_SESSION['site_id'])
			XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
		$AlbumList[$aid] = $Album;
	}
}

$orderid = 1;
foreach ($AlbumIDList as $aid) {
	if ($aid != null) {
		$query =	"	UPDATE	object_link " .
					"	SET		order_id = '" . $orderid++ . "'" .
					"	WHERE	object_link_id	= '" . intval($AlbumList[$aid]['object_link_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', 'ok');
$smarty->assign('msg', ADMIN_MSG_UPDATE_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/album_sort.tpl');
