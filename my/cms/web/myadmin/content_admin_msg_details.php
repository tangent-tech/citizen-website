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
$smarty->assign('MyJS', 'content_admin_msg_details');

$ContentAdminMsg = content_admin::GetContentAdminMsgInfo($_REQUEST['id']);
if ($ContentAdminMsg['content_admin_id'] != $AdminInfo['content_admin_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'content_admin_msg_list.php', __LINE__);
$smarty->assign('ContentAdminMsg', $ContentAdminMsg);

workflow::UpdateContentAdminMsgRead($_REQUEST['id']);

$TheObject = null;
if ($ContentAdminMsg['workflow_type'] == 'SECURITY_LEVEL_UPDATE_REQUEST') {
	if (intval($ContentAdminMsg['object_id']) != 0)
		$TheObject = object::GetObjectInfo ($ContentAdminMsg['object_id']);
}
$smarty->assign('TheObject', $TheObject);

$smarty->assign('TITLE', 'Message Details');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/content_admin_msg_details.tpl');