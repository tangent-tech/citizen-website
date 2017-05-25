<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_product.php');

$Currency = currency::GetCurrencyInfo($_REQUEST['id'], $_SESSION['site_id']);

$CurrencyRate = $Currency['currency_rate'];

if ($Site['site_product_price_indepedent_currency'] == 'Y')
	$CurrencyRate = 1;

$query	=	"	INSERT INTO	currency_site_enable " .
			"	SET		currency_id 		= '" . intval($_REQUEST['id']) . "', " .
			"			site_id				= '" . $_SESSION['site_id'] . "', " .
			"			currency_site_rate	= '". $CurrencyRate . "'" .
			"	ON DUPLICATE KEY UPDATE currency_id = '" . intval($_REQUEST['id']) . "'";

$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: currency_list.php?SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));