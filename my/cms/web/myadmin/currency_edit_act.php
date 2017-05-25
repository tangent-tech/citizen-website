<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_product.php');

$smarty->assign('CurrentTab', 'currency');
$smarty->assign('CurrentTab2', 'currency');
$smarty->assign('MyJS', 'currency_edit');

$Currency = currency::GetCurrencyInfo($_REQUEST['id'], $_SESSION['site_id']);
if ($Currency['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'currency_list.php');

$query	=	"	UPDATE	currency_site_enable " .
			"	SET		currency_site_rate = '". aveEscT($_REQUEST['currency_site_rate']) . "'" .
			"	WHERE	currency_id = '" . intval($_REQUEST['id']) . "'" .
			"		AND	site_id = '" . $_SESSION['site_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: currency_edit.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));