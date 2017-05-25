<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_mailing_list');
$smarty->assign('MyJS', 'elasing_mailing_list_add_act');

$query  =	" 	INSERT INTO elasing_list " .
			"	SET	is_deleted			= 'N', " .
			"		site_id				= '" . intval($_SESSION['site_id']) . "', " .
			"		list_name			= '" . aveEscT($_REQUEST['list_name']) . "', " .
			"		list_desc			= '" . aveEscT($_REQUEST['list_desc']) . "', " .
			"		content_admin_id	= '" . intval($_SESSION['ContentAdminID']) . "', " .
			"		create_date = now(), " .
			"		last_update = now()	";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
$ListID = customdb::mysqli()->insert_id;

header( 'Location: elasing_mailing_list_edit.php?id=' . $ListID . '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS));