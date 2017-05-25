<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');

$smarty->assign('CurrentTab', 'site_content_writer');
$smarty->assign('CurrentTab2', 'site_content_writer_group_list');
$smarty->assign('MyJS', 'site_content_writer_group_edit');

$ContentWriterGroup = content_admin::GetContentWriterGroupInfo($_REQUEST['id']);

if ($ContentWriterGroup['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'site_content_writer_group_list.php', __LINE__);
$smarty->assign('ContentWriterGroup', $ContentWriterGroup);

$ContentWriterGroupMemberList = content_admin::GetContentWriterGroupMemberList($_REQUEST['id'], 'CONTENT_WRITER');
$smarty->assign('ContentWriterGroupMemberList', $ContentWriterGroupMemberList);

$ContentWriterGroupNonMemberList = content_admin::GetContentWriterGroupNonMemberList($_REQUEST['id'], 'CONTENT_WRITER');
$smarty->assign('ContentWriterGroupNonMemberList', $ContentWriterGroupNonMemberList);

$smarty->assign('TITLE', 'Edit Group');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/site_content_writer_group_edit.tpl');