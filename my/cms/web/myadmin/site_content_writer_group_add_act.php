<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');

$query	=	"	INSERT INTO	content_admin_group " .
			"	SET		content_admin_group_name	= '" . aveEscT($_REQUEST['content_admin_group_name']) . "', " . 
			"			content_admin_group_is_enable = 'Y', " .
			"			site_id	= '" . intval($_SESSION['site_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$ContentWriterGroupID = customdb::mysqli()->insert_id;

header( 'Location: site_content_writer_group_edit.php?id=' . $ContentWriterGroupID . '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS));