<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

if (site::IsAPILoginExist($_REQUEST['site_api_login'])) {
	header( 'Location: site_add.php?' .
				'site_name=' . urlencode($_REQUEST['site_name']) .
				'&site_address=' . urlencode($_REQUEST['site_address']).
				'&site_ftp_address=' . urlencode($_REQUEST['site_ftp_address']).
				'&site_ftp_userfile_dir=' . urlencode($_REQUEST['site_ftp_userfile_dir']).
				'&site_http_userfile_path=' . urlencode($_REQUEST['site_http_userfile_path']).
				'&site_ftp_filebase_dir=' . urlencode($_REQUEST['site_ftp_filebase_dir']).
				'&site_ftp_static_link_dir=' . urlencode($_REQUEST['site_ftp_static_link_dir']).
				'&site_http_static_link_path=' . urlencode($_REQUEST['site_http_static_link_path']).
				'&site_ftp_username=' . urlencode($_REQUEST['site_ftp_username']).
				'&site_api_login=' . urlencode($_REQUEST['site_api_login']).
				'&ErrorMessage=' . urlencode(ADMIN_ERROR_API_LOGIN_EXIST));
	exit();
}

if (!currency::IsValidCurrencyID($_REQUEST['site_default_currency_id']))
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'site_add.php', __LINE__);
if (!language::IsValidLanguageID($_REQUEST['site_default_language_id']))
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'site_add.php', __LINE__);

if (strlen(trim($_REQUEST['site_ftp_userfile_dir'])) > 1 && substr(trim($_REQUEST['site_ftp_userfile_dir']), -1) == '/')
	$_REQUEST['site_ftp_userfile_dir'] = substr(trim($_REQUEST['site_ftp_userfile_dir']), 0, -1);
if (strlen(trim($_REQUEST['site_ftp_filebase_dir'])) > 1 && substr(trim($_REQUEST['site_ftp_filebase_dir']), -1) == '/')
	$_REQUEST['site_ftp_filebase_dir'] = substr(trim($_REQUEST['site_ftp_filebase_dir']), 0, -1);

$query	=	"	INSERT INTO	site " .
			"	SET		site_is_enable 				= 'Y', " .
			"			site_name					= '" . aveEscT($_REQUEST['site_name']) . "', " .
			"			site_address				= '" . aveEscT($_REQUEST['site_address']) . "', " .
			"			site_counter_alltime		= 0, " .
			"			site_default_language_id 	= '" . aveEscT($_REQUEST['site_default_language_id']) . "', " .
			"			site_default_currency_id 	= '" . aveEscT($_REQUEST['site_default_currency_id']) . "', " .
			"			site_ftp_address			= '" . aveEscT($_REQUEST['site_ftp_address']) . "', " .
			"			site_ftp_userfile_dir		= '" . aveEscT($_REQUEST['site_ftp_userfile_dir']) . "', " .
			"			site_http_userfile_path 	= '" . aveEscT($_REQUEST['site_http_userfile_path']) . "', " .
			"			site_ftp_filebase_dir		= '" . aveEscT($_REQUEST['site_ftp_filebase_dir']) . "', " .
			"			site_ftp_static_link_dir	= '" . aveEscT($_REQUEST['site_ftp_static_link_dir']) . "', " .
			"			site_http_static_link_path 	= '" . aveEscT($_REQUEST['site_http_static_link_path']) . "', " .
			"			site_ftp_username			= '" . aveEscT($_REQUEST['site_ftp_username']) . "', " .
			"			site_ftp_password			= '" . aveEscT(site::MyEncrypt(trim($_REQUEST['site_ftp_password']))) . "', " .
			"			site_api_login				= '" . aveEscT($_REQUEST['site_api_login']) . "', " .
			"			site_api_key				= '" . md5(md5(md5(rand(1, 999999)) . md5(rand(1, 999999)))) . "', " .
			"			site_rich_secret_key		= '" . md5(md5(md5(rand(1, 999999)) . "w09jw90wj0fgjwcx90" . md5(rand(1, 999999)))) . "' ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$NewSiteID = customdb::mysqli()->insert_id;

$SiteRootID		= object::NewObject('SITE_ROOT', $NewSiteID, 0);

$LibraryRootID	= object::NewObject('LIBRARY_ROOT', $NewSiteID, 0);
object::NewObjectLink($SiteRootID, $LibraryRootID, 'Library', 0, 'system', DEFAULT_ORDER_ID);

$SiteBlockHolderRootID	= object::NewObject('SITE_BLOCK_HOLDER_ROOT', $NewSiteID, 0);
object::NewObjectLink($LibraryRootID, $SiteBlockHolderRootID, 'Site Block Holder Root', 0, 'system', DEFAULT_ORDER_ID);

$AlbumRootID = object::NewObject('ALBUM_ROOT', $NewSiteID, 0);
object::NewObjectLink($LibraryRootID, $AlbumRootID, 'Albums', 0, 'system', DEFAULT_ORDER_ID);

$ProductRootSpecialID = object::NewObject('PRODUCT_ROOT_SPECIAL', $NewSiteID, 0);
object::NewObjectLink($LibraryRootID, $ProductRootSpecialID, 'Special Product Categories', 0, 'system', DEFAULT_ORDER_ID);

$SiteProductBrandRootID = object::NewObject('PRODUCT_BRAND_ROOT', $NewSiteID, 0);
object::NewObjectLink($LibraryRootID, $SiteProductBrandRootID, 'Product Brand Root', 0, 'system', DEFAULT_ORDER_ID);

$BonusPointRootID = object::NewObject('BONUS_POINT_ROOT', $NewSiteID, 0);
object::NewObjectLink($LibraryRootID, $BonusPointRootID, 'Bonus Point Root', 0, 'system', DEFAULT_ORDER_ID);

$UserRootID = object::NewObject('USER_ROOT', $NewSiteID, 0);
object::NewObjectLink($LibraryRootID, $UserRootID, 'User Root', 0, 'system', DEFAULT_ORDER_ID);

object::TidyUpObjectOrder($LibraryRootID);

// Create Product Special Category now
for ($i = 1; $i <= NO_OF_PRODUCT_CAT_SPECIAL; $i++) {
	$SpecialCatID = object::NewObject('PRODUCT_SPECIAL_CATEGORY', $NewSiteID, 0);
	product::NewProductCatSpecial($SpecialCatID, $i);
	object::NewObjectLink($ProductRootSpecialID, $SpecialCatID, 'Special Category ' . $i, 0, 'system', $i);
}
object::TidyUpObjectOrder($ProductRootSpecialID);

// Now Update Site Root in Site
$query	=	"	UPDATE	site " .
			"	SET		site_root_id	= '" . intval($SiteRootID) . "', " .
			"			library_root_id	= '" . intval($LibraryRootID) . "', " .
			"			album_root_id	= '" . intval($AlbumRootID) . "', " .
			"			bonus_point_root_id	= '" . intval($BonusPointRootID) . "', " .
			"			site_user_root_id	= '" . intval($UserRootID) . "', " .
			"			site_block_holder_root_id		= '" . intval($SiteBlockHolderRootID) . "', " .
			"			site_product_brand_root_id		= '" . intval($SiteProductBrandRootID) . "', " .
			"			site_product_root_special_id	= '" . intval($ProductRootSpecialID) . "'" .
			"	WHERE	site_id			= '" . intval($NewSiteID) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

// Create default language root
$Language = language::GetLanguageInfo($_REQUEST['site_default_language_id']);

$LanguageRootID = object::NewObject('LANGUAGE_ROOT', $NewSiteID, 0);

$query	=	"	INSERT INTO	language_root " .
			"	SET		language_id 			= '" . intval($_REQUEST['site_default_language_id']) . "', " .
			"			index_link_id			= 0, " .
			"			language_root_id		= '". intval($LanguageRootID) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

// Create shop
shop::CreateShop($NewSiteID, 'WEB', 0);

object::NewObjectLink($SiteRootID, $LanguageRootID, $Language['language_native'], $Language['language_id'], 'normal', DEFAULT_ORDER_ID);
object::TidyUpObjectOrder($SiteRootID);

$Currency = currency::GetCurrencyInfo($_REQUEST['site_default_currency_id'], $NewSiteID);
$query	=	"	INSERT INTO	currency_site_enable " .
			"	SET		currency_id 		= '" . intval($_REQUEST['site_default_currency_id']) . "', " .
			"			site_id				= '" . intval($NewSiteID) . "', " .
			"			currency_site_rate	= '". $Currency['currency_rate'] . "'" .
			"	ON DUPLICATE KEY UPDATE currency_id = '" . intval($_REQUEST['site_default_currency_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: site_edit.php?site_id=' . $NewSiteID . '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS));