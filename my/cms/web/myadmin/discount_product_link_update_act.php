<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');

$query =	"	UPDATE	site " .
			"	SET		site_discount_product_link_update_status	= 'in_progress' " .
			"	WHERE	site_id	= '" . $_SESSION['site_id'] . "'" .
			"		AND	site_discount_product_link_update_status	= 'job_done'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: discount_product_link_update_status.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));