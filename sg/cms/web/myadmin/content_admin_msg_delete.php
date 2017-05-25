<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_any_header.php');
require_once('../common/header_site_content.php');
//require_once('../common/header_article.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

//acl::AclBarrier("acl_sitemap_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'content_admin_msg');
$smarty->assign('CurrentTab2', 'content_admin_msg');
$smarty->assign('MyJS', 'content_admin_msg_action');

$ContentAdminMsg = content_admin::GetContentAdminMsgInfo($_REQUEST['id']);
if ($ContentAdminMsg['content_admin_id'] != $AdminInfo['content_admin_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'content_admin_msg_list.php', __LINE__);

$query =	"	UPDATE	content_admin_msg " .
			"	SET		content_admin_msg_delete_date = NOW() " .
			"	WHERE	content_admin_msg_id	= '" . intval($_REQUEST['id']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
header( 'Location: content_admin_msg_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS));