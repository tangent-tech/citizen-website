<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');

$smarty->assign('CurrentTab', 'site_content_writer');
$smarty->assign('CurrentTab2', 'site_content_writer_list');
$smarty->assign('MyJS', 'site_content_writer_edit');

$ContentWriter = content_admin::GetContentAdminInfo($_REQUEST['id']);
if ($ContentWriter['site_id'] != $_SESSION['site_id'] || $ContentWriter['content_admin_type'] != 'CONTENT_WRITER')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'site_content_writer_list.php', __LINE__);
$smarty->assign('ContentWriter', $ContentWriter);

$ContentWriterACL = acl::GetAclListForContentAdmin($_REQUEST['id']);
$smarty->assign('ContentWriterACL', $ContentWriterACL);

$smarty->assign('TITLE', 'Edit Writer');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/site_content_writer_edit.tpl');