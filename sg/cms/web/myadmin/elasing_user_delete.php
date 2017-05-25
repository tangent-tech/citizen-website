<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_elasing.php');
require_once('../common/header_elasing_multi_level.php');

$TheContentAdmin = content_admin::GetContentAdminInfo($_REQUEST['id']);
$smarty->assign('TheContentAdmin', $TheContentAdmin);

if ($TheContentAdmin['site_id'] != $_SESSION['site_id'] || !$IsContentAdmin || $TheContentAdmin['content_admin_type'] != 'ELASING_USER')
	AdminDie('Sorry, you are not allowed to delete this user.', 'elasing_user_list.php', __LINE__);

$query	=	"	DELETE FROM	content_admin " .
			"	WHERE		content_admin_id		= '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: elasing_user_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS));