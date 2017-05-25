<?php
global $smarty;
define('GOOGLE_MAP_API_KEY',		'AIzaSyCj4OYlKjmsKihZSz2qO37Crbo2H-kIk4g');

define('WARRANTY_EMAIL_SEND_FROM',	'Citizen Watches (H.K.) Ltd.');

define('WARRANTY_EXCEL_USERNAME',	'admin');
define('WARRANTY_EXCEL_PASSWORD',	'aveego1123');
define('WARRANTY_EXCEL_TITLE',		'WarrantyList');

define('RELATED_BRAND_SITE_BLOCK_ID',									272858);
define('PRODUCT_ROOT_CATALOG_PDF_LINK_SITE_BLOCK_ID',					273083);
define('PRODUCT_ROOT_CATALOG_IMAGE_SITE_BLOCK_ID',						273082);
define('FOOTER_SOCIAL_LINK_SITE_BLOCK_ID',								282023);
define('SITE_BLOCK_FORCE_LANG_ID',										1);

define('PRODUCT_ROOT_ID',												272563);
define('PRODUCT_ROOT_LINK_ID_EN',										212356);
define('PRODUCT_ROOT_LINK_ID_TC',										213761);

define('NEWS_PER_PAGE',													20);
define('PRODUCTS_PER_PAGE',												999);
define('HOME_PAGE_LINEUP_PER_PAGE',										10);
define('HOME_PAGE_IMPORTANT_NOTICES_PER_PAGE',							3);
define('HOME_PAGE_LAYOUT_NEWS_PER_PAGE',								6);

define('SUBMENU_PRODUCT_PER_CATEGORY',									10);
define('PRODUCT_CATEGORY_BRAND_LOGO_MEDIA_INDEX',						1);
define('PRODUCT_SEARCH_PER_PAGE',										10);

define('LAYOUT_NEWS_START_YEAR',										2007);
define('IMPORTANT_NOTICES_LAYOUT_NEWS_CATEGORY_ID',						273303);
define('OTHER_LAYOUT_NEWS_PER_PAGE',									4);

define('WARRANTY_PURCHASE_YEAR_START',									2001);

define('SEARCH_OBJECTS_PER_PAGE',										10);

$KudoSearchOption[] = array( 'name_en' => 'Eco-Drive', 'name_tc' => '光動能' );
$KudoSearchOption[] = array( 'name_en' => 'Automatic', 'name_tc' => '自動機械錶芯' );
$smarty->assign("KudoSearchOption", $KudoSearchOption);

$DenpaSearchOption[] = array( 'name_en' => 'GPS Satellite Wave',			'name_tc' => '衛星對時錶',		'tag_name_en' => 'Satellite<br/>Wave-GPS',		'tag_name_tc' => '衛星對時錶' );
$DenpaSearchOption[] = array( 'name_en' => 'Global Radio-Controlled',		'name_tc' => '環球電波時計',		'tag_name_en' => 'Global Radio<br/>Controlled',	'tag_name_tc' => '環球電波時計' );
$DenpaSearchOption[] = array( 'name_en' => 'Without Radio Reception Function',	'name_tc' => '沒有電波接收信號功能',	'tag_name_en' => 'Without Radio<br/>Reception<br/>Function',		'tag_name_tc' => '沒有電波接收<br/>信號功能' );
$smarty->assign("DenpaSearchOption", $DenpaSearchOption);

$CaseSearchOption[] = array( 'name_en' => 'Stainless Steel',	'name_tc' => '不銹鋼' );
$CaseSearchOption[] = array( 'name_en' => 'Titanium',			'name_tc' => '鈦金屬' );
$smarty->assign("CaseSearchOption", $CaseSearchOption);

//***tag_name for display only, name for search
$StrapSearchOption[] = array( 'name_en' => 'Metal Band',				'name_tc' => '金屬錶帶',		'tag_name_en' => 'Metal Band',					'tag_name_tc' => '金屬錶帶');
$StrapSearchOption[] = array( 'name_en' => 'Leather Strap',				'name_tc' => '皮帶',			'tag_name_en' => 'Leather Strap',				'tag_name_tc' => '皮帶');
$StrapSearchOption[] = array( 'name_en' => 'Synthetic Rubber Strap',	'name_tc' => '合成橡膠錶帶',	'tag_name_en' => 'Synthetic<br/>Rubber Strap',	'tag_name_tc' => '合成橡膠錶帶');
$StrapSearchOption[] = array( 'name_en' => 'Nylon Strap',				'name_tc' => '尼龍錶帶',		'tag_name_en' => 'Nylon Strap',					'tag_name_tc' => '尼龍錶帶');
$StrapSearchOption[] = array( 'name_en' => 'Other',						'name_tc' => '其他',			'tag_name_en' => 'Other',						'tag_name_tc' => '其他');
$smarty->assign("StrapSearchOption", $StrapSearchOption);

$WaterResistantSearchOption[] = array( 'name_en' => 'Daily Water Resistant',				'name_tc' => '日常生活防水',			'tag_name_en' => 'Daily Water<br/>Resistant',						'tag_name_tc' => '日常生活防水' );
$WaterResistantSearchOption[] = array( 'name_en' => 'Water Resistant to 5 bar',				'name_tc' => '5 bar 防水',			'tag_name_en' => 'Water Resistant<br/>to 5 bar',					'tag_name_tc' => '5 bar 防水' );
$WaterResistantSearchOption[] = array( 'name_en' => 'Water Resistant to 5 bar (Case Only)', 'name_tc' => '5 bar 防水 (只限錶殼)',	'tag_name_en' => 'Water Resistant<br/>to 5 bar<br/>(Case Only)',	'tag_name_tc' => '5 bar 防水<br/>(只限錶殼)' );
$WaterResistantSearchOption[] = array( 'name_en' => 'Water Resistant to 10 bar','name_tc' => '10 bar 防水',	'tag_name_en' => 'Water Resistant<br/>to 10 bar',	'tag_name_tc' => '10 bar 防水' );
$WaterResistantSearchOption[] = array( 'name_en' => 'Water Resistant to 20 bar','name_tc' => '20 bar 防水',	'tag_name_en' => 'Water Resistant<br/>to 20 bar',	'tag_name_tc' => '20 bar 防水' );
$WaterResistantSearchOption[] = array( 'name_en' => 'Water Resistant to 200m',	'name_tc' => '200米防水',		'tag_name_en' => 'Water Resistant<br/>to 200m',		'tag_name_tc' => '200米防水' );
$WaterResistantSearchOption[] = array( 'name_en' => 'Water Resistant to 300m',	'name_tc' => '300米防水',		'tag_name_en' => 'Water Resistant<br/>to 300m',		'tag_name_tc' => '300米防水' );
$smarty->assign("WaterResistantSearchOption", $WaterResistantSearchOption);

$GlassSearchOption[] = array( 'name_en' => 'Crystal Glass',		'name_tc' => '水晶玻璃錶面' );
$GlassSearchOption[] = array( 'name_en' => 'Sapphire Glass',	'name_tc' => '藍寶石玻璃錶面' );
$smarty->assign("GlassSearchOption", $GlassSearchOption);

$PriceSearchOption[] = array( 'name_en' => "~HK$" . number_format(2000, 0, '.', ','),	'name_tc' => "~HK$" . number_format(2000, 0, '.', ','),	'below_value' => 2000 );
$PriceSearchOption[] = array( 'name_en' => "~HK$" . number_format(4000, 0, '.', ','),	'name_tc' => "~HK$" . number_format(4000, 0, '.', ','),	'below_value' => 4000 );
$PriceSearchOption[] = array( 'name_en' => "~HK$" . number_format(8000, 0, '.', ','),	'name_tc' => "~HK$" . number_format(8000, 0, '.', ','),	'below_value' => 8000 );
$PriceSearchOption[] = array( 'name_en' => 'Without limit',								'name_tc' => '沒有限制' ,									'below_value' => 99999 );
$smarty->assign("PriceSearchOption", $PriceSearchOption);

$FeaturesSearchOption[] = array( 'name_en' => 'New',				'name_tc' => '新產品',				'field_name' => 'product_custom_int_2', 'tag_name_en' => 'New' );
$FeaturesSearchOption[] = array( 'name_en' => 'Limited',			'name_tc' => '限量款式',				'field_name' => 'product_custom_int_3', 'tag_name_en' => 'Limited' );
$FeaturesSearchOption[] = array( 'name_en' => 'Calendar',			'name_tc' => '日曆顯示 ',				'field_name' => 'product_custom_int_4', 'tag_name_en' => 'Calendar' );
$FeaturesSearchOption[] = array( 'name_en' => 'Chronograph',		'name_tc' => '計時秒錶',				'field_name' => 'product_custom_int_5', 'tag_name_en' => 'Chronograph' );
$FeaturesSearchOption[] = array( 'name_en' => 'Alarm',				'name_tc' => '嚮鬧功能',				'field_name' => 'product_custom_int_6', 'tag_name_en' => 'Alarm' );
$FeaturesSearchOption[] = array( 'name_en' => 'Duratect',			'name_tc' => 'Duratect',			'field_name' => 'product_custom_int_7', 'tag_name_en' => 'Duratect' );
$FeaturesSearchOption[] = array( 'name_en' => 'Luminous',			'name_tc' => '夜光顯示',				'field_name' => 'product_custom_int_8', 'tag_name_en' => 'Luminous' );
$FeaturesSearchOption[] = array( 'name_en' => 'Flying Distance and Navigation Calculations','name_tc' => '飛行計算尺','field_name' => 'product_custom_int_10',	'tag_name_en' => 'Flying Distance<br/>and Navigation<br/>Calculations' );
$FeaturesSearchOption[] = array( 'name_en' => 'Perpetual Calendar',	'name_tc' => '萬年曆',				'field_name' => 'product_custom_int_11',				'tag_name_en' => 'Perpetual<br/>Calendar' );
$smarty->assign("FeaturesSearchOption", $FeaturesSearchOption);

$StoreLocationRegionList = array(
	1 => array('name_en'=>'CITIZEN Exclusive Shop'),
	2 => array('name_en'=>'Central'),
	3 => array('name_en'=>'East'),
	4 => array('name_en'=>'North'),
	5 => array('name_en'=>'South'),
	6 => array('name_en'=>'West') 
);
$smarty->assign("StoreLocationRegionList", $StoreLocationRegionList);

define('MACAU_STORE_AREA_LIST_ID',		999);

$TOP_MENU_FOLDER_ID = array( 1 => 272559, 2 => 275044);
$FOOTER_MENU_FOLDER_ID = array (1 => 272637, 2 => 275151);
$FOOTER_CATEGORY_FOLDE_ID = array (1=> 272645, 2 => 275098);
$FOOTER_OTHER_LINK_CATEGORY_FOLDE_ID = array(1 => 282108, 2 => 282113);

$PRODUCT_ROOT_LINK_ID = array ( 1=> 212356, 2 => 213761);
$NEWS_LAYOUT_NEWS_ROOT_ID = array (1 => 272632, 2=> 277353);
$OTHER_NEWS_LAYOUT_NEWS_ROOT_ID = array (1 =>273304, 2 =>277371);
