<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');

$smarty->assign('CurrentTab', 'site_content_writer');
$smarty->assign('CurrentTab2', 'site_content_writer_list');
$smarty->assign('MyJS', 'site_content_writer_delete');

$ContentWriter = content_admin::GetContentAdminInfo($_REQUEST['id']);
if ($ContentWriter['site_id'] != $_SESSION['site_id'] || $ContentWriter['content_admin_type'] != 'CONTENT_WRITER')
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'site_content_writer_list.php', __LINE__);

$query =	"	DELETE FROM	content_admin " .
			"	WHERE	content_admin_id = '" . intval($ContentWriter['content_admin_id']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	DELETE FROM content_admin_group_member_link " .
			"	WHERE	content_admin_id = '" . intval($ContentWriter['content_admin_id']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	DELETE FROM content_admin_msg " .
			"	WHERE	content_admin_id		= '" . intval($ContentWriter['content_admin_id']) . "' " .
			"		OR	sender_content_admin_id = '" . intval($ContentWriter['content_admin_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	SELECT	* " .
			"	FROM	workflow " .
			"	WHERE	sender_content_admin_id = '" . intval($ContentWriter['content_admin_id']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

while ($myResult = $result->fetch_assoc()) {
	workflow::DeleteWorkflow($myResult['workflow_id']);
}

$query =	"	UPDATE	workflow " .
			"	SET		workflow_result_content_admin_id = 0 " .
			"	WHERE	workflow_result_content_admin_id = '" . intval($ContentWriter['content_admin_id']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: site_content_writer_list.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));