<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_any_header.php');
//require_once('../common/header_site_content.php');
//require_once('../common/header_article.php');

if ($IsSiteAdmin) {
	$query =	"	UPDATE	system_admin " .
				"	SET		screen_width = '" . intval($_REQUEST['width']) . "'" .
				"	WHERE	system_admin_id = '" . intval($_SESSION['SystemAdminID']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
elseif ($IsElasingUser) {
	$query =	"	UPDATE	content_admin " .
				"	SET		screen_width = '" . intval($_REQUEST['width']) . "'" .
				"	WHERE	content_admin_id = '" . intval($_SESSION['ContentAdminID']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}