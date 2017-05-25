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

$query	=	"	UPDATE	content_admin_group " .
			"	SET		content_admin_group_name	= '" . aveEscT($_REQUEST['content_admin_group_name']) . "', " . 
			"			content_admin_group_is_enable = '" . ynval($_REQUEST['content_admin_group_is_enable']) . "' " .
			"	WHERE	content_admin_group_id = '" . intval($ContentWriterGroup['content_admin_group_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: site_content_writer_group_edit.php?id=' . $ContentWriterGroup['content_admin_group_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));