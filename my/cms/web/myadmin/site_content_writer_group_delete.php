<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');

$smarty->assign('CurrentTab', 'site_content_writer');
$smarty->assign('CurrentTab2', 'site_content_writer_list');
$smarty->assign('MyJS', 'site_content_writer_delete');

$ContentWriterGroup = content_admin::GetContentWriterGroupInfo($_REQUEST['id']);

if ($ContentWriterGroup['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'site_content_writer_group_list.php', __LINE__);

$query =	"	DELETE FROM	content_admin_group " .
			"	WHERE	content_admin_group_id = '" . intval($ContentWriterGroup['content_admin_group_id']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	DELETE FROM content_admin_group_member_link " .
			"	WHERE	content_admin_group_id = '" . intval($ContentWriterGroup['content_admin_group_id']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	SELECT	* " .
			"	FROM	workflow " .
			"	WHERE	receiver_content_admin_group_id = '" . intval($ContentWriterGroup['content_admin_group_id']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

while ($myResult = $result->fetch_assoc()) {
	workflow::DeleteWorkflow($myResult['workflow_id']);
}

header( 'Location: site_content_writer_group_list.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));