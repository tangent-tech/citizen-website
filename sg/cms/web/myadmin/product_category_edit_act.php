<?php
define('IN_CMS', true);

require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_category_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_category_edit');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$ProductCat = product::GetProductCatInfo($ObjectLink['object_id'], 0);
if ($ProductCat['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

$query =	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['object_is_enable']) . "', " .
			"			object_security_level	= '" . intval($_REQUEST['object_security_level']) . "' " .
			"	WHERE	object_id = '" . intval($ProductCat['product_category_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$sql = GetCustomTextSQL("product_category", "int") . GetCustomTextSQL("product_category", "double") . GetCustomTextSQL("product_category", "date");

$ProductCategoryGroupValidFields = product::GetProductGroupValidFieldList($_SESSION['site_id']);
$ProductCategoryGroupUpdateFields = array();

for ($i = 1; $i <= NO_OF_PRODUCT_GROUP_FIELDS; $i++) {
	if (
			in_array($_REQUEST['product_category_group_field_name'][$i], array_keys($ProductCategoryGroupValidFields)) &&
			$_REQUEST['product_category_group_field_name'][$i] != '' &&
			!in_array($_REQUEST['product_category_group_field_name'][$i], $ProductCategoryGroupUpdateFields)
		) {
			array_push($ProductCategoryGroupUpdateFields, $_REQUEST['product_category_group_field_name'][$i]);
	}
}

for ($i = 1; $i <= count($ProductCategoryGroupUpdateFields); $i++)
	$sql = $sql . " product_category_group_field_name_" . $i . " = '" . trim($ProductCategoryGroupUpdateFields[$i-1]) . "',";
for ($i = count($ProductCategoryGroupUpdateFields) + 1; $i <= NO_OF_PRODUCT_GROUP_FIELDS; $i++)
	$sql = $sql . " product_category_group_field_name_" . $i . " = '',";

$ValidObjectList = array("PRODUCT_CATEGORY");
$SubCatList = site::GetAllChildObjects($ValidObjectList, $ObjectLink['object_id'], 999999, 'ALL', 'ALL', false, false, true);

if (count($SubCatList) > 0) {
	for ($i = 1; $i <= NO_OF_PRODUCT_GROUP_FIELDS; $i++)
		$sql = $sql . " product_category_group_field_name_" . $i . " = 0 ,";	
}

if (count($ProductCategoryGroupUpdateFields) > 0 && count($SubCatList) == 0) {
	// So this is now a product group
	$query =	"	UPDATE	product_category " .
				"	SET		" . $sql . 
				"			product_category_is_product_group = 'Y' " .
				"	WHERE	product_category_id = '" . intval($ProductCat['product_category_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
//	No Need To call product::ProductGroupUpdateShadowProduct($ObjectLink['object_id']) as UpdateProductCategoryPreCalData will call
//	product::ProductGroupUpdateShadowProduct($ObjectLink['object_id']);
}
else {
	$query =	"	UPDATE	product_category " .
				"	SET		" . $sql . 
				"			product_category_is_product_group = 'N' " .
				"	WHERE	product_category_id = '" . intval($ProductCat['product_category_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	product::ProductGroupRemoveShadowProduct($ObjectLink['object_id']);
}

$query =	"	UPDATE	object_link " .
			"	SET		object_name	= '" . aveEscT($_REQUEST['object_name']) . "', " .
			"			object_link_is_enable = '" . ynval($_REQUEST['object_is_enable']) . "' " .
			"	WHERE	object_id = '" . intval($ProductCat['product_category_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::UpdateObjectCommonDataFromRequest($ObjectLink);
object::UpdateObjectSEOData($ProductCat['product_category_id'], null, null, null, null, $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($ProductCat['product_category_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

if (isset($_FILES['thumbnail_file']) && $_FILES['thumbnail_file']['size'] > 0) {
	$Site = site::GetSiteInfo($_SESSION['site_id']);
	if (object::UpdateObjectThumbnail($ProductCat, $Site, $_FILES['thumbnail_file'], $Site['site_product_media_small_width'], $Site['site_product_media_small_height']) === false)
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
}

$ProductCategoryCustomFieldsDef = site::GetProductCategoryCustomFieldsDef($_SESSION['site_id']);
foreach ($SiteLanguageRoots as $R) {
	$sql = GetCustomTextSQL("product_category", "autotext", $R['language_id'], null, false, $ProductCategoryCustomFieldsDef);
	if (strlen($sql) > 0)
		$sql = ", " . substr($sql, 0, -1);
	
	$query =	"	UPDATE	product_category_data " .
				"	SET		product_category_name	= '" . aveEscT($_REQUEST['product_category_name'][$R['language_id']]) . "'" . $sql .
				"	WHERE	product_category_id	= '" . intval($ProductCat['product_category_id']) . "'" .
				"		AND	language_id	= '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	$query =	"	UPDATE	product_category_data " .
				"	SET		object_meta_title	= '" . aveEscT($_REQUEST['object_meta_title'][$R['language_id']]) . "', " .
				"			object_meta_description		= '" . aveEscT($_REQUEST['object_meta_description'][$R['language_id']]) . "', " .
				"			object_meta_keywords	= '" . aveEscT($_REQUEST['object_meta_keywords'][$R['language_id']]) . "', " .
				"			object_friendly_url		= '" . aveEscT($_REQUEST['object_friendly_url'][$R['language_id']]) . "' " .
				"	WHERE	product_category_id	= '" . intval($ProductCat['product_category_id']) . "'" .
				"		AND	language_id	= '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);
product::UpdateProductCategoryPreCalData($ProductCat['product_category_id'], $SiteLanguageRoots, $Site, $CurrencyList);
product::UpdateTimeStampProductCat($ProductCat['product_category_id']);
site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_category_edit.php?link_id=' . $_REQUEST['link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));