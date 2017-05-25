<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'site_management');

$query =	"	UPDATE	site " .
			"	SET		site_generate_link_status	= 'in_queue'" .
			"	WHERE	site_id = '" . intval($_REQUEST['site_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header('Location: site_list.php');