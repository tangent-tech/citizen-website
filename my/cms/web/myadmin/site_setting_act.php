<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');

if ($_SESSION['site_id'] != $_REQUEST['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'site_setting.php', __LINE__);

$SiteMediaWatermarkSmallFileID			= $Site['site_media_watermark_small_file_id'];
$SiteMediaWatermarkBigFileID			= $Site['site_media_watermark_big_file_id'];
$SiteProductMediaWatermarkSmallFileID	= $Site['site_product_media_watermark_small_file_id'];
$SiteProductMediaWatermarkBigFileID 	= $Site['site_product_media_watermark_big_file_id'];

$Site = site::GetSiteInfo($_SESSION['site_id']);

if (isset($_REQUEST['remove_site_media_watermark_small_file']) && $_REQUEST['remove_site_media_watermark_small_file'] == 'Y') {
	if ($Site['site_media_watermark_small_file_id'] != 0)
		filebase::DeleteFile($Site['site_media_watermark_small_file_id'], $Site);

	$Site['site_media_watermark_small_file_id'] = 0;
	$SiteMediaWatermarkSmallFileID	= 0;
}
if (isset($_REQUEST['remove_site_media_watermark_big_file']) && $_REQUEST['remove_site_media_watermark_big_file'] == 'Y') {
	if ($Site['site_media_watermark_big_file_id'] != 0)
		filebase::DeleteFile($Site['site_media_watermark_big_file_id'], $Site);

	$Site['site_media_watermark_big_file_id'] = 0;
	$SiteMediaWatermarkBigFileID	= 0;
}
if (isset($_REQUEST['remove_site_product_media_watermark_small_file']) && $_REQUEST['remove_site_product_media_watermark_small_file'] == 'Y') {
	if ($Site['site_media_product_watermark_small_file_id'] != 0)
		filebase::DeleteFile($Site['site_media_product_watermark_small_file_id'], $Site);

	$Site['site_media_product_watermark_small_file_id'] = 0;
	$SiteProductMediaWatermarkSmallFileID	= 0;
}
if (isset($_REQUEST['remove_site_product_media_watermark_big_file']) && $_REQUEST['remove_site_product_media_watermark_big_file'] == 'Y') {
	if ($Site['site_media_product_watermark_big_file_id'] != 0)
		filebase::DeleteFile($Site['site_media_product_watermark_big_file_id'], $Site);

	$Site['site_media_product_watermark_big_file_id'] = 0;
	$SiteProductMediaWatermarkBigFileID	= 0;
}



if (isset($_FILES['site_media_watermark_small_file']) && $_FILES['site_media_watermark_small_file']['size'] > 0) {
	$FileExt = strtolower(substr(strrchr($_FILES['site_media_watermark_small_file']['name'], '.'), 1));

	$Width = $Site['site_media_small_width'];
	$Height = $Site['site_media_small_height'];

	if ($FileExt != 'png')
		$ErrorMessage = ADMIN_ERROR_WATERMARK_MUST_BE_PNG;
	else {
		$SiteMediaWatermarkSmallFileID = filebase::AddPhoto($_FILES['site_media_watermark_small_file'], $Width, $Height, $Site, 0, SITE_PARENT_ID);
		if ($MediaID !== false && $MediaID != 0) {
			if ($Site['site_media_watermark_small_file_id'] != 0)
				filebase::DeleteFile($Site['site_media_watermark_small_file_id'], $Site);
		}
	}
}
if (isset($_FILES['site_media_watermark_big_file']) && $_FILES['site_media_watermark_big_file']['size'] > 0) {
	$FileExt = strtolower(substr(strrchr($_FILES['site_media_watermark_big_file']['name'], '.'), 1));

	$Width = $Site['site_media_big_width'];
	$Height = $Site['site_media_big_height'];

	if ($FileExt != 'png')
		$ErrorMessage = ADMIN_ERROR_WATERMARK_MUST_BE_PNG;
	else {
		$SiteMediaWatermarkBigFileID = filebase::AddPhoto($_FILES['site_media_watermark_big_file'], $Width, $Height, $Site, 0, SITE_PARENT_ID);
		if ($MediaID !== false && $MediaID != 0) {
			if ($Site['site_media_watermark_big_file_id'] != 0)
				filebase::DeleteFile($Site['site_media_watermark_big_file_id'], $Site);
		}
	}
}
if (isset($_FILES['site_product_media_watermark_small_file']) && $_FILES['site_product_media_watermark_small_file']['size'] > 0) {
	$FileExt = strtolower(substr(strrchr($_FILES['site_product_media_watermark_small_file']['name'], '.'), 1));

	$Width = $Site['site_product_media_small_width'];
	$Height = $Site['site_product_media_small_height'];

	if ($FileExt != 'png')
		$ErrorMessage = ADMIN_ERROR_WATERMARK_MUST_BE_PNG;
	else {
		$SiteProductMediaWatermarkSmallFileID = filebase::AddPhoto($_FILES['site_product_media_watermark_small_file'], $Width, $Height, $Site, 0, SITE_PARENT_ID);
		if ($MediaID !== false && $MediaID != 0) {
			if ($Site['site_product_media_watermark_small_file_id'] != 0)
				filebase::DeleteFile($Site['site_product_media_watermark_small_file_id'], $Site);
		}
	}
}
if (isset($_FILES['site_product_media_watermark_big_file']) && $_FILES['site_product_media_watermark_big_file']['size'] > 0) {
	$FileExt = strtolower(substr(strrchr($_FILES['site_product_media_watermark_big_file']['name'], '.'), 1));

	$Width = $Site['site_product_media_big_width'];
	$Height = $Site['site_product_media_big_height'];

	if ($FileExt != 'png')
		$ErrorMessage = ADMIN_ERROR_WATERMARK_MUST_BE_PNG;
	else {
		$SiteProductMediaWatermarkBigFileID = filebase::AddPhoto($_FILES['site_product_media_watermark_big_file'], $Width, $Height, $Site, 0, SITE_PARENT_ID);
		if ($MediaID !== false && $MediaID != 0) {
			if ($Site['site_product_media_watermark_big_file_id'] != 0)
				filebase::DeleteFile($Site['site_product_media_watermark_big_file_id'], $Site);
		}
	}
}

$_REQUEST['site_http_friendly_link_path'] = trim(str_ireplace('/', '', $_REQUEST['site_http_friendly_link_path']));

if (strlen($_REQUEST['site_http_friendly_link_path']) < 1)
	$_REQUEST['site_friendly_link_dir'] = 'html';

$query	=	"	UPDATE	site " .
			"	SET		site_default_security_level					= '" . intval($_REQUEST['site_default_security_level']) . "', " .
			"			site_country_show_other						= '" . ynval($_REQUEST['site_country_show_other']) . "', " .
			"			site_media_small_width 						= '" . intval($_REQUEST['site_media_small_width']) . "', " .
			"			site_media_small_height						= '" . intval($_REQUEST['site_media_small_height']) . "', " .
			"			site_media_big_width						= '" . intval($_REQUEST['site_media_big_width']) . "', " .
			"			site_media_big_height						= '" . intval($_REQUEST['site_media_big_height']) . "', " .
			"			site_media_resize							= '" . ynval($_REQUEST['site_media_resize']) . "', " .
			"			site_folder_media_small_width				= '" . intval($_REQUEST['site_folder_media_small_width']) . "', " .
			"			site_folder_media_small_height				= '" . intval($_REQUEST['site_folder_media_small_height']) . "', " .
			"			site_product_media_small_width				= '" . intval($_REQUEST['site_product_media_small_width']) . "', " .
			"			site_product_media_small_height 			= '" . intval($_REQUEST['site_product_media_small_height']) . "', " .
			"			site_product_media_big_width				= '" . intval($_REQUEST['site_product_media_big_width']) . "', " .
			"			site_product_media_big_height				= '" . intval($_REQUEST['site_product_media_big_height']) . "', " .
			"			site_product_media_resize					= '" . ynval($_REQUEST['site_product_media_resize']) . "', " .
			"			site_email_sent_monthly_quota				= '" . intval($_REQUEST['site_email_sent_monthly_quota']) . "', " .
			"			site_email_custom_footer					= '" . ynval($_REQUEST['site_email_custom_footer']) . "', " .
			"			site_email_default_content					= '" . aveEscT($_REQUEST['EditorEmailContent']) . "', " .
			"			site_email_user_sender_override_site_sender	= '" . ynval($_REQUEST['site_email_user_sender_override_site_sender']) . "', " .
			"			site_email_unsubscribe_hide_mailing_list	= '" . ynval($_REQUEST['site_email_unsubscribe_hide_mailing_list']) . "', " .
			"			site_module_vote_enable						= '" . ynval($_REQUEST['site_module_vote_enable']) . "', " .
			"			site_vote_multi								= '" . ynval($_REQUEST['site_vote_multi']) . "', " .
			"			site_vote_guest								= '" . ynval($_REQUEST['site_vote_guest']) . "', " .
			"			site_module_article_enable					= '" . ynval($_REQUEST['site_module_article_enable']) . "', " .
			"			site_module_article_quota					= '" . intval($_REQUEST['site_module_article_quota']) . "', " .
			"			site_module_news_enable						= '" . ynval($_REQUEST['site_module_news_enable']) . "', " .
			"			site_module_news_quota						= '" . intval($_REQUEST['site_module_news_quota']) . "', " .
			"			site_module_layout_news_enable				= '" . ynval($_REQUEST['site_module_layout_news_enable']) . "', " .
			"			site_module_layout_news_quota				= '" . intval($_REQUEST['site_module_layout_news_quota']) . "', " .
			"			site_module_discount_rule_enable			= '" . ynval($_REQUEST['site_module_discount_rule_enable']) . "', " .
			"			site_module_bundle_rule_enable				= '" . ynval($_REQUEST['site_module_bundle_rule_enable']) . "', " .
			"			site_module_product_enable					= '" . ynval($_REQUEST['site_module_product_enable']) . "', " .
			"			site_module_product_quota					= '" . intval($_REQUEST['site_module_product_quota']) . "', " .
			"			site_module_album_enable					= '" . ynval($_REQUEST['site_module_album_enable']) . "', " .
			"			site_module_member_enable					= '" . ynval($_REQUEST['site_module_member_enable']) . "', " .
			"			site_module_order_enable					= '" . ynval($_REQUEST['site_module_order_enable']) . "', " .
			"			site_module_bonus_point_enable				= '" . ynval($_REQUEST['site_module_bonus_point_enable']) . "', " .
			"			site_module_inventory_enable				= '" . ynval($_REQUEST['site_module_inventory_enable']) . "', " .
			"			site_module_inventory_partial_shipment		= '" . ynval($_REQUEST['site_module_inventory_partial_shipment']) . "', " .
			"			site_module_group_buy_enable				= '" . ynval($_REQUEST['site_module_group_buy_enable']) . "', " .
			"			site_module_content_writer_enable			= '" . ynval($_REQUEST['site_module_content_writer_enable']) . "', " .
			"			site_module_workflow_enable					= '" . ynval($_REQUEST['site_module_workflow_enable']) . "', " .
			"			site_module_objman_enable					= '" . ynval($_REQUEST['site_module_objman_enable']) . "', " .		
			"			site_invoice_enable							= '" . ynval($_REQUEST['site_invoice_enable']) . "', " .
			"			site_dn_enable								= '" . ynval($_REQUEST['site_dn_enable']) . "', " .
			"			site_order_status_change_callback_url		= '" . aveEscT($_REQUEST['site_order_status_change_callback_url']) . "', " .
			"			site_member_status_change_callback_url		= '" . aveEscT($_REQUEST['site_member_status_change_callback_url']) . "', " .
			"			site_module_elasing_enable					= '" . ynval($_REQUEST['site_module_elasing_enable']) . "', " .
			"			site_module_elasing_multi_level				= '" . ynval($_REQUEST['site_module_elasing_multi_level']) . "', " .
			"			site_product_allow_under_stock				= '" . ynval($_REQUEST['site_product_allow_under_stock']) . "', " .
			"			site_auto_hold_stock_status					= '" . aveEscT($_REQUEST['site_auto_hold_stock_status']) . "', " .
			"			site_product_category_special_max_no		= '" . intval($_REQUEST['site_product_category_special_max_no']) . "', " .
			"			site_admin_logo_url							= '" . aveEscT($_REQUEST['site_admin_logo_url']) . "', " .
			"			site_watermark_position						= '" . aveEscT($_REQUEST['site_watermark_position']) . "', " .
			"			site_media_watermark_big_file_id			= '" . intval($SiteMediaWatermarkBigFileID) . "', " .
			"			site_media_watermark_small_file_id			= '" . intval($SiteMediaWatermarkSmallFileID) . "', " .
			"			site_product_media_watermark_big_file_id	= '" . intval($SiteProductMediaWatermarkBigFileID) . "', " .
			"			site_product_media_watermark_small_file_id	= '" . intval($SiteProductMediaWatermarkSmallFileID) . "', " .
			"			site_rich_xml_data_enable					= '" . ynval($_REQUEST['site_rich_xml_data_enable']) . "', " .		
			"			site_friendly_link_enable					= '" . ynval($_REQUEST['site_friendly_link_enable']) . "', " .
			"			site_http_friendly_link_path				= '" . aveEscT($_REQUEST['site_http_friendly_link_path']) . "', " .
			"			site_friendly_link_version					= '" . aveEscT($_REQUEST['site_friendly_link_version']) . "', " .
			"			site_additional_htaccess_content			= '" . aveEscT($_REQUEST['site_additional_htaccess_content']) . "', " .
			"			site_label_product							= '" . aveEscT($_REQUEST['site_label_product']) . "', " .
			"			site_label_news								= '" . aveEscT($_REQUEST['site_label_news']) . "', " .
			"			site_label_layout_news						= '" . aveEscT($_REQUEST['site_label_layout_news']) . "', " .
			"			site_freight_cost_calculation_id			= '" . intval($_REQUEST['site_freight_cost_calculation_id']) . "', " .
			"			site_order_show_redeem_tab					= '" . ynval($_REQUEST['site_order_show_redeem_tab']) . "', " .		
			"			site_next_order_serial						= '" . aveEscT($_REQUEST['site_next_order_serial']) . "', " .
			"			site_order_serial_reset_type				= '" . aveEscT($_REQUEST['site_order_serial_reset_type']) . "', " .
			"			site_order_serial_next_reset_date			= '" . aveEscT($_REQUEST['site_order_serial_next_reset_date']) . "', " .
			"			site_order_no_format						= '" . aveEscT($_REQUEST['site_order_no_format']) . "', " .
			"			site_next_redeem_serial						= '" . aveEscT($_REQUEST['site_next_redeem_serial']) . "', " .
			"			site_redeem_serial_reset_type				= '" . aveEscT($_REQUEST['site_redeem_serial_reset_type']) . "', " .
			"			site_redeem_serial_next_reset_date			= '" . aveEscT($_REQUEST['site_redeem_serial_next_reset_date']) . "', " .
			"			site_redeem_no_format						= '" . aveEscT($_REQUEST['site_redeem_no_format']) . "', " .
			"			site_order_invoice_callback_url				= '" . aveEscT($_REQUEST['site_order_invoice_callback_url']) . "', " .
			"			site_product_price_version					= '" . intval($_REQUEST['site_product_price_version']) . "', " .
			"			site_product_price_indepedent_currency		= '" . ynval($_REQUEST['site_product_price_indepedent_currency']) . "' " .		
			"	WHERE	site_id = '" . intval($_REQUEST['site_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

if ($_REQUEST['site_product_price_indepedent_currency'] == 'Y') {
	$query =	"	UPDATE	currency_site_enable " .
				"	SET		currency_site_rate = 1 " .
				"	WHERE	site_id = '" . intval($_REQUEST['site_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$htaccess_content = '';
if (ynval($_REQUEST['site_friendly_link_enable']) == 'N')
	$htaccess_content = '';
else {
	$htaccess_content = "RewriteEngine on
RewriteRule ^/?" . trim($_REQUEST['site_http_friendly_link_path']) . "/o_([0-9]+)_(.*)/(.*)\.html load.php?id=$1&para=$2&friendly_name=$3&%{QUERY_STRING} [L]
RewriteRule ^/?" . trim($_REQUEST['site_http_friendly_link_path']) . "/l_([0-9]+)_(.*)/(.*)\.html load.php?link_id=$1&para=$2&friendly_name=$3&%{QUERY_STRING} [L]
";

	if ($_REQUEST['site_friendly_link_version'] == 'structured')
		$htaccess_content .= 
"RewriteRule ^(.*\/)$ rewrite_router.php?structured_friendly_name=$1&%{QUERY_STRING} [L]
RewriteRule ^(.*\.html)$ rewrite_router.php?structured_friendly_name=$1&%{QUERY_STRING} [L]
";
}

$htaccess_content .= $_REQUEST['site_additional_htaccess_content'];

$TmpFile = tempnam("/tmp", "TmpHtaccess");
file_put_contents($TmpFile, $htaccess_content);
$conn_id = ftp_connect($Site['site_ftp_address']);
$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password']));

if ($Site['site_ftp_need_passive'] == 'Y')
	ftp_pasv($conn_id, true);
else
	ftp_pasv($conn_id, false);

$upload_result = @ftp_put($conn_id, trim($Site['site_ftp_web_dir']) . "/.htaccess", $TmpFile, FTP_BINARY, 0);
ftp_close($conn_id);
unlink($TmpFile);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: site_setting.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));