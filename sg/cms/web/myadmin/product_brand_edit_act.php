<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_brand_manage", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_brand_edit');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

$ProductBrand = product::GetProductBrandInfo($ObjectLink['object_id'], 0);
if ($ProductBrand['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_brand_list.php', __LINE__);
$smarty->assign('ProductBrand', $ProductBrand);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

$query	=	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['object_is_enable']) . "', " .
			"			object_archive_date		= '" . aveEscT($ObjectArchiveDateText) . "', " .
			"			object_publish_date		= '" . aveEscT($ObjectPublishDateText) . "', " .
			"			object_security_level	= '" . intval($_REQUEST['object_security_level']) . "' " .
			"	WHERE	object_id = '" . intval($ProductBrand['product_brand_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	UPDATE	object_link " .
			"	SET		object_name	= '" . aveEscT($_REQUEST['object_name']) . "', " .
			"			object_link_is_enable = '" . ynval($_REQUEST['object_is_enable']) . "' " .			
			"	WHERE	object_id = '" . intval($ProductBrand['product_brand_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
object::UpdateObjectSEOData($ProductBrand['product_brand_id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);

$sql = GetCustomTextSQL("product_brand", "int") . GetCustomTextSQL("product_brand", "double") . GetCustomTextSQL("product_brand", "date");

if (strlen($sql) > 0) {
	$sql = substr($sql, 0, -1);

	$query =	"	UPDATE	product_brand " .
				"	SET		" . $sql .
				"	WHERE	product_brand_id = '" . $ProductBrand['product_brand_id'] . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$ProductBrandCustomFieldsDef = site::GetProductBrandCustomFieldsDef($_SESSION['site_id']);
foreach ($SiteLanguageRoots as $R) {
	product::TouchProductBrandData($ProductBrand['product_brand_id'], $R['language_id']);

	$sql = GetCustomTextSQL("product_brand", "autotext", $R['language_id'], null, false, $ProductBrandCustomFieldsDef);
	if (strlen($sql) > 0)
		$sql = ", " . substr($sql, 0, -1);
		
	$query =	"	UPDATE	product_brand_data " .
				"	SET		product_brand_name	= '" . aveEscT($_REQUEST['product_brand_name'][$R['language_id']]) . "', " .
				"			product_brand_desc	= '" . aveEscT($_REQUEST['ContentEditor' . $R['language_id']]) . "' " . $sql .
				"	WHERE	product_brand_id	= '" . intval($ProductBrand['product_brand_id']) . "'" .
				"		AND	language_id	= '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

if ($_REQUEST['remove_thumbnail'] == 'Y')
	object::RemoveObjectThumbnail($ProductBrand, $Site);	

// Handle Highlight File
if (isset($_FILES['product_brand_file']) && $_FILES['product_brand_file']['size'] > 0) {
	$Site = site::GetSiteInfo($_SESSION['site_id']);
	if (object::UpdateObjectThumbnail($ProductBrand, $Site, $_FILES['product_brand_file'], $Site['site_product_media_small_width'], $Site['site_product_media_small_height']) === false)
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
}

product::UpdateTimeStampProductBrand($ProductBrand['product_brand_id']);
site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_brand_edit.php?link_id=' . $_REQUEST['link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));