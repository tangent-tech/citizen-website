<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

if ($_SESSION['SystemAdminID'] == $_REQUEST['id']) {
	header( 'Location: system_admin_list.php?ErrorMessage=' . urlencode(ADMIN_ERROR_CANNOT_DELETE_YOURSELF));
	exit();
}

$query	=	"	DELETE FROM	system_admin " .
			"	WHERE		system_admin_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	DELETE FROM	system_admin_site_link " .
			"	WHERE		system_admin_id	= '" . intval($_REQUEST['id']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: system_admin_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS));