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
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'currency_list.php', __LINE__);

if (!currency::IsCurrencyRemovable($_REQUEST['id'], $_SESSION['site_id']))
	AdminDie(ADMIN_ERROR_CURRENCY_IS_NOT_REMOVABLE, 'currency_list.php', __LINE__);

currency::RemoveSiteCurrency($_REQUEST['id'], $_SESSION['site_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: currency_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS));