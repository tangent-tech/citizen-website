<?php
if (!defined('IN_CMS'))
	die(realpath(__FILE__) . " " .  __LINE__);

require_once('content_common.php');

$Object = ApiQuery('object_link_get_info.php', __LINE__, 'link_id=' . $_REQUEST['link_id']);
$smarty->assign('Object', $Object);

if (intval($ObjectLink->object->object_link_id) == PHOTO_FOLDER_LINK_ID) {
	$AlbumList	= ApiQuery('folder_get_album_list.php', __LINE__,
						'folder_id=' . $Object->object->object_id .
						'&lang_id=' . $CurrentLang->language_root->language_id .
						'&security_level=' . $_SESSION['user_security_level'] .
						'&page_no=1' .
						'&album_per_page=999' . 
						'&include_album_details=N' . 
						'&media_per_page=0'
					);
	$smarty->assign('AlbumList', $AlbumList);

	$smarty->display($CurrentLang->language_root->language_id . '/folder_albumlist.tpl');
}

?>