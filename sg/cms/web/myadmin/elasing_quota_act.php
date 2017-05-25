<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_quota');
$smarty->assign('MyJS', 'elasing_quota');

if (!IsValidEmail(trim($_REQUEST['site_module_elasing_sender_address']))) {
	header( 'Location: elasing_quota.php?email=' . urlencode($_REQUEST['site_module_elasing_sender_address']). '&ErrorMessage=' . urlencode(ADMIN_ERROR_INVALID_EMAIL));
	exit();
}

$query	=	"	UPDATE	site " .
			"	SET		site_module_elasing_sender_name		= '" . aveEscT($_REQUEST['site_module_elasing_sender_name']) . "', " . 
			"			site_module_elasing_sender_address	= '" . aveEscT($_REQUEST['site_module_elasing_sender_address']) . "' " . 
			"	WHERE	site_id	= '" . intval($_SESSION['site_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: elasing_quota.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));