<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_article.php');

if ($_REQUEST['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

$query	=	"	UPDATE	site " .
			"	SET		site_bonus_point_valid_days 				= '" . aveEscT($_REQUEST['site_bonus_point_valid_days']) . "', " .
			"			site_default_language_id					= '" . intval($_REQUEST['site_default_language_id']) . "', " .
			"			site_default_currency_id					= '" . intval($_REQUEST['site_default_currency_id']) . "', " .
			"			site_product_stock_threshold_quantity		= '" . intval($_REQUEST['site_product_stock_threshold_quantity']) . "', " .
			"			site_invoice_show_product_code				= '" . ynval($_REQUEST['site_invoice_show_product_code']) . "', " .
			"			site_invoice_show_bonus_point				= '" . ynval($_REQUEST['site_invoice_show_bonus_point']) . "', " .
			"			site_invoice_show_product_image				= '" . ynval($_REQUEST['site_invoice_show_product_image']) . "', " .
			"			site_invoice_header							= '" . aveEscT($_REQUEST['EditorInvoiceHeader']) . "', " .
			"			site_invoice_footer							= '" . aveEscT($_REQUEST['EditorInvoiceFooter']) . "', " .
			"			site_invoice_tnc							= '" . aveEscT($_REQUEST['EditorInvoiceTNC']) . "', " .
			"			site_dn_show_product_code					= '" . ynval($_REQUEST['site_dn_show_product_code']) . "', " .
			"			site_dn_show_product_image					= '" . ynval($_REQUEST['site_dn_show_product_image']) . "', " .
			"			site_dn_header								= '" . aveEscT($_REQUEST['EditorDnHeader']) . "', " .
			"			site_dn_footer								= '" . aveEscT($_REQUEST['EditorDnFooter']) . "', " .
			"			site_dn_tnc									= '" . aveEscT($_REQUEST['EditorDnTNC']) . "', " .
			"			site_product_price_process_order			= '" . aveEscT($_REQUEST['site_product_price_process_order']) . "'" .
			"	WHERE	site_id = '" . intval($_REQUEST['site_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$CurrencyList = currency::GetAllSiteCurrencyList($_SESSION['site_id']);

$query =	"	DELETE FROM site_freight " .
			"	WHERE	site_id = '" . intval($_SESSION['site_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

foreach ($CurrencyList as $C) {
	$CurrencyID = intval($C['currency_id']);
	
	$update_sql =
			"	site_freight_1_free_min_total_price			= '" . doubleval($_REQUEST['site_freight_1_free_min_total_price'][$CurrencyID]) . "', " .
			"	site_freight_1_cost							= '" . doubleval($_REQUEST['site_freight_1_cost'][$CurrencyID]) . "', " .
			"	site_freight_1_free_min_total_price_def		= '" . intval($_REQUEST['site_freight_1_free_min_total_price_def'][$CurrencyID]) . "', " .
			"	site_freight_2_free_min_total_price			= '" . doubleval($_REQUEST['site_freight_2_free_min_total_price'][$CurrencyID]) . "', " .
			"	site_freight_2_cost_percent					= '" . doubleval($_REQUEST['site_freight_2_cost_percent'][$CurrencyID]) . "', " .
			"	site_freight_2_free_min_total_price_def		= '" . intval($_REQUEST['site_freight_2_free_min_total_price_def'][$CurrencyID]) . "', " .
			"	site_freight_2_total_base_price_def			= '" . intval($_REQUEST['site_freight_2_total_base_price_def'][$CurrencyID]) . "' ";
	
	$query =	"	INSERT INTO site_freight " .
				"	SET	site_id = '" . intval($_SESSION['site_id']) . "', " .
				"		currency_id = '" . $CurrencyID . "', " . $update_sql .
				"	ON DUPLICATE KEY UPDATE " . $update_sql;
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: site_setting_general.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));