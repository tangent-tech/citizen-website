<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');

// IMPORTANT!!!!!!!!!!!!!!
//	UPDATE site::CloneSiteSettingFromSiteToSite TOO!!!!!!!!!!!!!!!!!!!!!!!!

function GetCustomFieldSQL($Table, $Type) {
	$sql = '';
	
	$max = 20;
	if ($Type == 'rgb')
		$max = NO_OF_CUSTOM_RGB_FIELDS;
	
	for ($i = 1; $i <= $max; $i++) {
		$sql = $sql . " " . $Table . "_custom_" . $Type . "_" . $i . " = '". aveEscT($_REQUEST[$Table . '_custom_' . $Type . '_' . $i]) . "',";
	}
	return substr($sql, 0, -1);
}

$query	=	"	INSERT INTO	object_fields_show " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
			"			object_security_level		= '". ynval($_REQUEST['object_security_level']) . "'," .
			"			object_archive_date			= '". ynval($_REQUEST['object_archive_date']) . "'," .
			"			object_publish_date			= '". ynval($_REQUEST['object_publish_date']) . "', " .
			"			object_lang_switch_id		= '". ynval($_REQUEST['object_lang_switch_id']) . "', " .
			"			object_seo_tab				= '". ynval($_REQUEST['object_seo_tab']) . "' " .
			"	ON DUPLICATE KEY UPDATE " .
			"			object_security_level		= '". ynval($_REQUEST['object_security_level']) . "'," .
			"			object_archive_date			= '". ynval($_REQUEST['object_archive_date']) . "'," .
			"			object_publish_date			= '". ynval($_REQUEST['object_publish_date']) . "', " .
			"			object_lang_switch_id		= '". ynval($_REQUEST['object_lang_switch_id']) . "', " .
			"			object_seo_tab				= '". ynval($_REQUEST['object_seo_tab']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	INSERT INTO	myorder_custom_fields_def " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
				GetCustomFieldSQL("myorder", "text") . ", " .
				GetCustomFieldSQL("myorder", "int") . ", " .
				GetCustomFieldSQL("myorder", "double") . ", " .
				GetCustomFieldSQL("myorder", "date") . 
			"	ON DUPLICATE KEY UPDATE " .
				GetCustomFieldSQL("myorder", "text") . ", " .
				GetCustomFieldSQL("myorder", "int") . ", " .
				GetCustomFieldSQL("myorder", "double") . ", " .
				GetCustomFieldSQL("myorder", "date");
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	INSERT INTO	user_custom_fields_def " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
				GetCustomFieldSQL("user", "text") . ", " .
				GetCustomFieldSQL("user", "int") . ", " .
				GetCustomFieldSQL("user", "double") . ", " .
				GetCustomFieldSQL("user", "date") . 
			"	ON DUPLICATE KEY UPDATE " .
				GetCustomFieldSQL("user", "text") . ", " .
				GetCustomFieldSQL("user", "int") . ", " .
				GetCustomFieldSQL("user", "double") . ", " .
				GetCustomFieldSQL("user", "date");
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	INSERT INTO	user_fields_show " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
			"			user_datafile			= '". ynval($_REQUEST['user_datafile']) . "', " .
			"			user_thumbnail_file_id	= '". ynval($_REQUEST['user_thumbnail_file_id']) . "', " .
			"			user_security_level		= '". ynval($_REQUEST['user_security_level']) . "', " .
			"			user_title				= '". ynval($_REQUEST['user_title']) . "', " .
			"			user_company_name		= '". ynval($_REQUEST['user_company_name']) . "', " .
			"			user_city_name			= '". ynval($_REQUEST['user_city_name']) . "', " .
			"			user_region				= '". ynval($_REQUEST['user_region']) . "', " .
			"			user_postcode			= '". ynval($_REQUEST['user_postcode']) . "', " .
			"			user_address_1			= '". ynval($_REQUEST['user_address_1']) . "', " .
			"			user_address_2			= '". ynval($_REQUEST['user_address_2']) . "', " .
			"			user_country_id			= '". ynval($_REQUEST['user_country_id']) . "', " .
			"			user_hk_district_id		= '". ynval($_REQUEST['user_hk_district_id']) . "', " .
			"			user_tel_country_code	= '". ynval($_REQUEST['user_tel_country_code']) . "', " .
			"			user_tel_area_code		= '". ynval($_REQUEST['user_tel_area_code']) . "', " .
			"			user_tel_no				= '". ynval($_REQUEST['user_tel_no']) . "', " .
			"			user_fax_country_code	= '". ynval($_REQUEST['user_fax_country_code']) . "', " .
			"			user_fax_area_code		= '". ynval($_REQUEST['user_fax_area_code']) . "', " .
			"			user_fax_no				= '". ynval($_REQUEST['user_fax_no']) . "', " .
			"			user_how_to_know_this_website	= '". ynval($_REQUEST['user_how_to_know_this_website']) . "', " .
			"			user_join_mailinglist		= '". ynval($_REQUEST['user_join_mailinglist']) . "', " .
			"			user_language_id		= '". ynval($_REQUEST['user_language_id']) . "', " .
			"			user_currency_id		= '". ynval($_REQUEST['user_currency_id']) . "', " .
			"			user_first_name			= '". ynval($_REQUEST['user_first_name']) . "', " .
			"			user_last_name			= '". ynval($_REQUEST['user_last_name']) . "', " .
			"			user_balance			= '". ynval($_REQUEST['user_balance']) . "' " .
			"	ON DUPLICATE KEY UPDATE " .
			"			user_datafile			= '". ynval($_REQUEST['user_datafile']) . "', " .
			"			user_thumbnail_file_id	= '". ynval($_REQUEST['user_thumbnail_file_id']) . "', " .
			"			user_security_level		= '". ynval($_REQUEST['user_security_level']) . "', " .
			"			user_title				= '". ynval($_REQUEST['user_title']) . "', " .
			"			user_company_name		= '". ynval($_REQUEST['user_company_name']) . "', " .
			"			user_city_name			= '". ynval($_REQUEST['user_city_name']) . "', " .
			"			user_region				= '". ynval($_REQUEST['user_region']) . "', " .
			"			user_postcode			= '". ynval($_REQUEST['user_postcode']) . "', " .
			"			user_address_1			= '". ynval($_REQUEST['user_address_1']) . "', " .
			"			user_address_2			= '". ynval($_REQUEST['user_address_2']) . "', " .
			"			user_country_id			= '". ynval($_REQUEST['user_country_id']) . "', " .
			"			user_hk_district_id		= '". ynval($_REQUEST['user_hk_district_id']) . "', " .
			"			user_tel_country_code	= '". ynval($_REQUEST['user_tel_country_code']) . "', " .
			"			user_tel_area_code		= '". ynval($_REQUEST['user_tel_area_code']) . "', " .
			"			user_tel_no				= '". ynval($_REQUEST['user_tel_no']) . "', " .
			"			user_fax_country_code	= '". ynval($_REQUEST['user_fax_country_code']) . "', " .
			"			user_fax_area_code		= '". ynval($_REQUEST['user_fax_area_code']) . "', " .
			"			user_fax_no				= '". ynval($_REQUEST['user_fax_no']) . "', " .
			"			user_how_to_know_this_website	= '". ynval($_REQUEST['user_how_to_know_this_website']) . "', " .
			"			user_join_mailinglist		= '". ynval($_REQUEST['user_join_mailinglist']) . "', " .
			"			user_language_id		= '". ynval($_REQUEST['user_language_id']) . "', " .
			"			user_currency_id		= '". ynval($_REQUEST['user_currency_id']) . "', " .
			"			user_first_name			= '". ynval($_REQUEST['user_first_name']) . "', " .
			"			user_last_name			= '". ynval($_REQUEST['user_last_name']) . "', " .
			"			user_balance			= '". ynval($_REQUEST['user_balance']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	INSERT INTO	myorder_fields_show " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
			"			self_take					= '". ynval($_REQUEST['self_take']) . "', " .
			"			show_bonus_point_tab		= '". ynval($_REQUEST['show_bonus_point_tab']) . "', " .
			"			show_deliver_address_tab	= '". ynval($_REQUEST['show_deliver_address_tab']) . "', " .
			"			invoice_country_id			= '". ynval($_REQUEST['invoice_country_id']) . "', " .
			"			invoice_hk_district_id		= '". ynval($_REQUEST['invoice_hk_district_id']) . "', " .
			"			invoice_first_name			= '". ynval($_REQUEST['invoice_first_name']) . "', " .
			"			invoice_last_name			= '". ynval($_REQUEST['invoice_last_name']) . "', " .
			"			invoice_company_name		= '". ynval($_REQUEST['invoice_company_name']) . "', " .
			"			invoice_city_name			= '". ynval($_REQUEST['invoice_city_name']) . "', " .
			"			invoice_region				= '". ynval($_REQUEST['invoice_region']) . "', " .
			"			invoice_postcode			= '". ynval($_REQUEST['invoice_postcode']) . "', " .
			"			invoice_phone_no			= '". ynval($_REQUEST['invoice_phone_no']) . "', " .
			"			invoice_tel_country_code	= '". ynval($_REQUEST['invoice_tel_country_code']) . "', " .
			"			invoice_tel_area_code		= '". ynval($_REQUEST['invoice_tel_area_code']) . "', " .
			"			invoice_fax_country_code	= '". ynval($_REQUEST['invoice_fax_country_code']) . "', " .
			"			invoice_fax_area_code		= '". ynval($_REQUEST['invoice_fax_area_code']) . "', " .
			"			invoice_fax_no				= '". ynval($_REQUEST['invoice_fax_no']) . "', " .
			"			invoice_shipping_address_2	= '". ynval($_REQUEST['invoice_shipping_address_2']) . "', " .
			"			delivery_country_id			= '". ynval($_REQUEST['delivery_country_id']) . "', " .
			"			delivery_hk_district_id		= '". ynval($_REQUEST['delivery_hk_district_id']) . "', " .
			"			delivery_first_name			= '". ynval($_REQUEST['delivery_first_name']) . "', " .
			"			delivery_last_name			= '". ynval($_REQUEST['delivery_last_name']) . "', " .
			"			delivery_company_name		= '". ynval($_REQUEST['delivery_company_name']) . "', " .
			"			delivery_city_name			= '". ynval($_REQUEST['delivery_city_name']) . "', " .
			"			delivery_region				= '". ynval($_REQUEST['delivery_region']) . "', " .
			"			delivery_postcode			= '". ynval($_REQUEST['delivery_postcode']) . "', " .
			"			delivery_phone_no			= '". ynval($_REQUEST['delivery_phone_no']) . "', " .
			"			delivery_tel_country_code	= '". ynval($_REQUEST['delivery_tel_country_code']) . "', " .
			"			delivery_tel_area_code		= '". ynval($_REQUEST['delivery_tel_area_code']) . "', " .
			"			delivery_fax_no				= '". ynval($_REQUEST['delivery_fax_no']) . "', " .
			"			delivery_fax_country_code	= '". ynval($_REQUEST['delivery_fax_country_code']) . "', " .
			"			delivery_fax_area_code		= '". ynval($_REQUEST['delivery_fax_area_code']) . "', " .
			"			delivery_shipping_address_2	= '". ynval($_REQUEST['delivery_shipping_address_2']) . "', " .
			"			delivery_email				= '". ynval($_REQUEST['delivery_email']) . "', " .
			"			user_balance_tab			= '". ynval($_REQUEST['user_balance_tab']) . "' " .
			"	ON DUPLICATE KEY UPDATE " .
			"			self_take					= '". ynval($_REQUEST['self_take']) . "', " .
			"			show_bonus_point_tab		= '". ynval($_REQUEST['show_bonus_point_tab']) . "', " .
			"			show_deliver_address_tab	= '". ynval($_REQUEST['show_deliver_address_tab']) . "', " .
			"			invoice_country_id			= '". ynval($_REQUEST['invoice_country_id']) . "', " .
			"			invoice_hk_district_id		= '". ynval($_REQUEST['invoice_hk_district_id']) . "', " .
			"			invoice_first_name			= '". ynval($_REQUEST['invoice_first_name']) . "', " .
			"			invoice_last_name			= '". ynval($_REQUEST['invoice_last_name']) . "', " .
			"			invoice_company_name		= '". ynval($_REQUEST['invoice_company_name']) . "', " .
			"			invoice_city_name			= '". ynval($_REQUEST['invoice_city_name']) . "', " .
			"			invoice_region				= '". ynval($_REQUEST['invoice_region']) . "', " .
			"			invoice_postcode			= '". ynval($_REQUEST['invoice_postcode']) . "', " .
			"			invoice_phone_no			= '". ynval($_REQUEST['invoice_phone_no']) . "', " .
			"			invoice_tel_country_code	= '". ynval($_REQUEST['invoice_tel_country_code']) . "', " .
			"			invoice_tel_area_code		= '". ynval($_REQUEST['invoice_tel_area_code']) . "', " .
			"			invoice_fax_country_code	= '". ynval($_REQUEST['invoice_fax_country_code']) . "', " .
			"			invoice_fax_area_code		= '". ynval($_REQUEST['invoice_fax_area_code']) . "', " .
			"			invoice_fax_no				= '". ynval($_REQUEST['invoice_fax_no']) . "', " .
			"			invoice_shipping_address_2	= '". ynval($_REQUEST['invoice_shipping_address_2']) . "', " .
			"			delivery_country_id			= '". ynval($_REQUEST['delivery_country_id']) . "', " .
			"			delivery_hk_district_id		= '". ynval($_REQUEST['delivery_hk_district_id']) . "', " .
			"			delivery_first_name			= '". ynval($_REQUEST['delivery_first_name']) . "', " .
			"			delivery_last_name			= '". ynval($_REQUEST['delivery_last_name']) . "', " .
			"			delivery_company_name		= '". ynval($_REQUEST['delivery_company_name']) . "', " .
			"			delivery_city_name			= '". ynval($_REQUEST['delivery_city_name']) . "', " .
			"			delivery_region				= '". ynval($_REQUEST['delivery_region']) . "', " .
			"			delivery_postcode			= '". ynval($_REQUEST['delivery_postcode']) . "', " .
			"			delivery_phone_no			= '". ynval($_REQUEST['delivery_phone_no']) . "', " .
			"			delivery_tel_country_code	= '". ynval($_REQUEST['delivery_tel_country_code']) . "', " .
			"			delivery_tel_area_code		= '". ynval($_REQUEST['delivery_tel_area_code']) . "', " .
			"			delivery_fax_no				= '". ynval($_REQUEST['delivery_fax_no']) . "', " .
			"			delivery_fax_country_code	= '". ynval($_REQUEST['delivery_fax_country_code']) . "', " .
			"			delivery_fax_area_code		= '". ynval($_REQUEST['delivery_fax_area_code']) . "', " .
			"			delivery_shipping_address_2	= '". ynval($_REQUEST['delivery_shipping_address_2']) . "', " .
			"			delivery_email				= '". ynval($_REQUEST['delivery_email']) . "', " .
			"			user_balance_tab			= '". ynval($_REQUEST['user_balance_tab']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$price_sql = '';
for ($i = 1; $i <=9; $i++) {
	$price_sql = $price_sql . " product_price" . $i . " = '" . aveEscT($_REQUEST['product_price' . $i]) . "',";
}
$price_sql = substr($price_sql, 0, -1);

$query	=	"	INSERT INTO	product_custom_fields_def " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
				GetCustomFieldSQL("product", "text") . ", " .
				GetCustomFieldSQL("product", "int") . ", " .
				GetCustomFieldSQL("product", "double") . ", " .
				GetCustomFieldSQL("product", "date") . ", " .
				GetCustomFieldSQL("product", "rgb") . ", " .
			$price_sql .
			"	ON DUPLICATE KEY UPDATE " .
				GetCustomFieldSQL("product", "text") . ", " .
				GetCustomFieldSQL("product", "int") . ", " .
				GetCustomFieldSQL("product", "double") . ", " .
				GetCustomFieldSQL("product", "date") . ", " .
				GetCustomFieldSQL("product", "rgb") . ", " .
			$price_sql;
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	INSERT INTO	product_fields_show " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
			"			product_color_id			= '". ynval($_REQUEST['product_color_id']) . "'," .
			"			factory_code				= '". ynval($_REQUEST['factory_code']) . "'," .
			"			product_code				= '". ynval($_REQUEST['product_code']) . "'," .
			"			product_weight				= '". ynval($_REQUEST['product_weight']) . "'," .
			"			product_size				= '". ynval($_REQUEST['product_size']) . "'," .
			"			product_LWD					= '". ynval($_REQUEST['product_LWD']) . "'," .
			"			product_name				= '". ynval($_REQUEST['product_name']) . "'," .
			"			product_color				= '". ynval($_REQUEST['product_color']) . "'," .
			"			product_packaging			= '". ynval($_REQUEST['product_packaging']) . "'," .
			"			product_desc				= '". ynval($_REQUEST['product_desc']) . "'," .
			"			product_tag					= '". ynval($_REQUEST['product_tag']) . "', " .
			"			product_discount			= '". ynval($_REQUEST['product_discount']) . "', " .
			"			product_special_category	= '". ynval($_REQUEST['product_special_category']) . "', " .
			"			product_option				= '". ynval($_REQUEST['product_option']) . "', " .
			"			product_option_show_no		= '". intval($_REQUEST['product_option_show_no']) . "', " .
			"			product_datafile			= '". ynval($_REQUEST['product_datafile']) . "', " .
			"			product_brand_id			= '". ynval($_REQUEST['product_brand_id']) . "'" .
			"	ON DUPLICATE KEY UPDATE " .
			"			product_color_id			= '". ynval($_REQUEST['product_color_id']) . "'," .
			"			factory_code				= '". ynval($_REQUEST['factory_code']) . "'," .
			"			product_code				= '". ynval($_REQUEST['product_code']) . "'," .
			"			product_weight				= '". ynval($_REQUEST['product_weight']) . "'," .
			"			product_size				= '". ynval($_REQUEST['product_size']) . "'," .
			"			product_LWD					= '". ynval($_REQUEST['product_LWD']) . "'," .
			"			product_name				= '". ynval($_REQUEST['product_name']) . "'," .
			"			product_color				= '". ynval($_REQUEST['product_color']) . "'," .
			"			product_packaging			= '". ynval($_REQUEST['product_packaging']) . "'," .
			"			product_desc				= '". ynval($_REQUEST['product_desc']) . "'," .
			"			product_tag					= '". ynval($_REQUEST['product_tag']) . "', " .
			"			product_discount			= '". ynval($_REQUEST['product_discount']) . "', " .
			"			product_special_category	= '". ynval($_REQUEST['product_special_category']) . "', " .
			"			product_option				= '". ynval($_REQUEST['product_option']) . "', " .
			"			product_option_show_no		= '". intval($_REQUEST['product_option_show_no']) . "', " .
			"			product_datafile			= '". ynval($_REQUEST['product_datafile']) . "', " .
			"			product_brand_id			= '". ynval($_REQUEST['product_brand_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	INSERT INTO	product_brand_custom_fields_def " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
				GetCustomFieldSQL("product_brand", "text") . ", " .
				GetCustomFieldSQL("product_brand", "int") . ", " .
				GetCustomFieldSQL("product_brand", "double") . ", " .
				GetCustomFieldSQL("product_brand", "date") . 
			"	ON DUPLICATE KEY UPDATE " .
				GetCustomFieldSQL("product_brand", "text") . ", " .
				GetCustomFieldSQL("product_brand", "int") . ", " .
				GetCustomFieldSQL("product_brand", "double") . ", " .
				GetCustomFieldSQL("product_brand", "date");
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	INSERT INTO	product_brand_fields_show " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
			"			product_brand_name			= '". ynval($_REQUEST['product_brand_name']) . "'," .
			"			product_brand_desc			= '". ynval($_REQUEST['product_brand_desc']) . "'" .
			"	ON DUPLICATE KEY UPDATE " .
			"			product_brand_name			= '". ynval($_REQUEST['product_brand_name']) . "'," .
			"			product_brand_desc			= '". ynval($_REQUEST['product_brand_desc']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	INSERT INTO	product_category_fields_show " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
			"			product_category_media_list	= '". ynval($_REQUEST['product_category_media_list']) . "', " .
			"			product_category_group_fields = '". ynval($_REQUEST['product_category_group_fields']) . "' " .
			"	ON DUPLICATE KEY UPDATE " .
			"			product_category_media_list	= '". ynval($_REQUEST['product_category_media_list']) . "', " .
			"			product_category_group_fields = '". ynval($_REQUEST['product_category_group_fields']) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	INSERT INTO	product_category_custom_fields_def " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
				GetCustomFieldSQL("product_category", "text") . ", " .
				GetCustomFieldSQL("product_category", "int") . ", " .
				GetCustomFieldSQL("product_category", "double") . ", " .
				GetCustomFieldSQL("product_category", "date") . 
			"	ON DUPLICATE KEY UPDATE " .
				GetCustomFieldSQL("product_category", "text") . ", " .
				GetCustomFieldSQL("product_category", "int") . ", " .
				GetCustomFieldSQL("product_category", "double") . ", " .
				GetCustomFieldSQL("product_category", "date");
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);


$query	=	"	INSERT INTO	album_custom_fields_def " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
				GetCustomFieldSQL("album", "text") . ", " .
				GetCustomFieldSQL("album", "int") . ", " .
				GetCustomFieldSQL("album", "double") . ", " .
				GetCustomFieldSQL("album", "date") . ", " .
				GetCustomFieldSQL("album", "file") .
			"	ON DUPLICATE KEY UPDATE " .
				GetCustomFieldSQL("album", "text") . ", " .
				GetCustomFieldSQL("album", "int") . ", " .
				GetCustomFieldSQL("album", "double") . ", " .
				GetCustomFieldSQL("album", "date") . ", " .
				GetCustomFieldSQL("album", "file");
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	INSERT INTO	media_custom_fields_def " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
				GetCustomFieldSQL("media", "text") . ", " .
				GetCustomFieldSQL("media", "int") . ", " .
				GetCustomFieldSQL("media", "double") . ", " .
				GetCustomFieldSQL("media", "date") . 
			"	ON DUPLICATE KEY UPDATE " .
				GetCustomFieldSQL("media", "text") . ", " .
				GetCustomFieldSQL("media", "int") . ", " .
				GetCustomFieldSQL("media", "double") . ", " .
				GetCustomFieldSQL("media", "date");
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	INSERT INTO	folder_custom_fields_def " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
				GetCustomFieldSQL("folder", "text") . ", " .
				GetCustomFieldSQL("folder", "int") . ", " .
				GetCustomFieldSQL("folder", "double") . ", " .
				GetCustomFieldSQL("folder", "date") . ", " .
				GetCustomFieldSQL("folder", "rgb") .
			"	ON DUPLICATE KEY UPDATE " .
				GetCustomFieldSQL("folder", "text") . ", " .
				GetCustomFieldSQL("folder", "int") . ", " .
				GetCustomFieldSQL("folder", "double") . ", " .
				GetCustomFieldSQL("folder", "date") . ", " .
				GetCustomFieldSQL("folder", "rgb");
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	INSERT INTO	datafile_custom_fields_def " .
			"	SET		site_id = '" . intval($_SESSION['site_id']) . "', " .
				GetCustomFieldSQL("datafile", "text") . ", " .
				GetCustomFieldSQL("datafile", "int") . ", " .
				GetCustomFieldSQL("datafile", "double") . ", " .
				GetCustomFieldSQL("datafile", "date") . 
			"	ON DUPLICATE KEY UPDATE " .
				GetCustomFieldSQL("datafile", "text") . ", " .
				GetCustomFieldSQL("datafile", "int") . ", " .
				GetCustomFieldSQL("datafile", "double") . ", " .
				GetCustomFieldSQL("datafile", "date");
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: field_setting.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));