<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$query	=	"	DELETE FROM	content_admin " .
			"	WHERE		content_admin_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: content_admin_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS));