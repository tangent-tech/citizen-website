<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_category_special_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_category_special_edit');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$ProductCatSpecial = product::GetProductCatSpecialInfo($ObjectLink['object_id'], 0);
if ($ProductCatSpecial['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

if ($_REQUEST['remove_thumbnail'] == 'Y')
	object::RemoveObjectThumbnail($ProductCatSpecial, $Site);	

if (isset($_FILES['thumbnail_file']) && $_FILES['thumbnail_file']['size'] > 0) {
	$Site = site::GetSiteInfo($_SESSION['site_id']);
	if (object::UpdateObjectThumbnail($ProductCatSpecial, $Site, $_FILES['thumbnail_file'], $Site['site_product_media_small_width'], $Site['site_product_media_small_height']) === false)
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
}

$query =	"	UPDATE	object_link " .
			"	SET		object_name	= '" . aveEscT($_REQUEST['object_name']) . "' " .
			"	WHERE	object_id = '" . intval($ProductCatSpecial['product_category_special_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::UpdateObjectSEOData($ProductCatSpecial['product_category_special_id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);

$sql = GetCustomTextSQL("product_category_special", "int") . GetCustomTextSQL("product_category_special", "double") . GetCustomTextSQL("product_category_special", "date");
if (strlen($sql) > 0) {
	$query =	"	UPDATE	product_category_special " .
				"	SET		" . substr($sql, 0, -1) .
				"	WHERE	product_category_special_id 		= '" . intval($ProductCatSpecial['product_category_special_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$ProductCategoryCustomFieldsDef = site::GetProductCategoryCustomFieldsDef($_SESSION['site_id']);

foreach ($SiteLanguageRoots as $R) {
	product::TouchProductCatSpecialData($ProductCatSpecial['product_category_special_id'], $R['language_id']);
	
	$sql = GetCustomTextSQL("product_category_special", "autotext", $R['language_id'], null, false, $ProductCategoryCustomFieldsDef);
	if (strlen($sql) > 0)
		$sql = ", " . substr($sql, 0, -1);

	$query =	"	UPDATE	product_category_special_data " .
				"	SET		product_category_special_name	= '" . aveEscT($_REQUEST['product_category_special_name'][$R['language_id']]) . "'" . $sql .
				"	WHERE	product_category_special_id	= '" . intval($ProductCatSpecial['product_category_special_id']) . "'" .
				"		AND	language_id	= '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

site::EmptyAPICache($_SESSION['site_id']);

object::UpdateObjectTimeStamp($ObjectLink['object_id']);

header( 'Location: product_category_special_edit.php?link_id=' . $_REQUEST['link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));