<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');

$smarty->assign('CurrentTab', 'site_content_writer');
$smarty->assign('CurrentTab2', 'site_content_writer_group_list');
$smarty->assign('MyJS', 'site_content_writer_group_edit');

$query	=	"	SELECT	* " .
			"	FROM	content_admin_group_member_link " .
			"	WHERE	content_admin_group_member_link_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
$myResult = $result->fetch_assoc();

$ContentWriterGroup = content_admin::GetContentWriterGroupInfo($myResult['content_admin_group_id']);
if ($ContentWriterGroup['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'site_content_writer_group_list.php', __LINE__);

$ContentWriter = content_admin::GetContentAdminInfo($myResult['content_admin_id']);
if ($ContentWriter['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'site_content_writer_group_list.php', __LINE__);

$query	=	"	DELETE FROM	content_admin_group_member_link " .
			"	WHERE		content_admin_group_member_link_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: site_content_writer_group_edit.php?id=' . $ContentWriterGroup['content_admin_group_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS));