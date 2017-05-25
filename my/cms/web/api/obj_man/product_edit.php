<?php
// parameters:
//	product_id
//	product_category_id_list - comma seperated
//	object_name
//	security_level
//	archive_date
//	publish_date
//	is_enable
//	object_meta_title
//	object_meta_description
//	object_meta_keywords
//	object_friendly_url
//	object_lang_switch_id
//	is_special_cat_1 .. is_special_cat_20
//	product_custom_int_1 .. product_custom_int_20
//	product_custom_double_1 .. product_custom_double_20
//	product_custom_date_1 .. product_custom_date_20
//	product_price - deprecated, do not set if you use v2
//	product_price2 - deprecated, do not set if you use v2
//	product_price3 - deprecated, do not set if you use v2
//	product_price_v2[1-9]
//	product_bonus_point_amount - deprecated, do not set if you use v2
//	product_bonus_point_amount_v2[1-9]
//	product_bonus_point_required_v2[1-9]
//	discount_type - deprecated, do not set if you use v2, 0 - 3 only, default 0
//	discount_type_v2[1-9]
//	discount1_off_p - deprecated, do not set if you use v2
//	discount1_off_p_v2[1-9]
//	discount2_amount - deprecated, do not set if you use v2
//	discount2_amount_v2[1-9]
//	discount2_price - deprecated, do not set if you use v2
//	discount2_price_v2[1-9]
//	discount3_buy_amount - deprecated, do not set if you use v2
//	discount3_buy_amount_v2[1-9]
//	discount3_free_amount - deprecated, do not set if you use v2
//	discount3_free_amount_v2[1-9]
//	product_color_id
//	product_rgb - in 6 characters hex format (#ffaabb)
//	factory_code
//	product_code
//	product_weight
//	product_size
//	product_L
//	product_W
//	product_D
//	product_tag[lang_id]
//	product_custom_text_1[lang_id] .. product_custom_text_20[lang_id]
//	product_name[lang_id]
//	product_color[lang_id]
//	product_packaging[lang_id]
//	product_desc[lang_id]
//	product_brand_id
//	product_brand_name - if this field specified, product_brand_id will be ignored. If brand name not found, the brand name will be created.
//	product_thumbnail_url - you may skip this field if no change
//	currency_id - default: 0
//	product_key - default: product_id (support product_id/product_code/factory_code)
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

// Notice for update code: Update validation and handling of product_brand, special_cat, product_cat are different

$IsContentAdmin = true;

if ($Site['site_module_objman_enable'] != 'Y')
	APIDie(array('desc' => 'Module ObjMan is not enabled'));

$ValidProductKey = array('product_id', 'product_code', 'factory_code');
if (!in_array($_REQUEST['product_key'], $ValidProductKey))
	$_REQUEST['product_key'] = 'product_id';

if ($_REQUEST['product_key'] == 'product_id') {
	$Product = product::GetProductInfo($_REQUEST['product_id'], 0);
	if ($Product['site_id'] != $Site['site_id'])
		APIDie(array('desc' => 'Invalid product_id'));
}
else {
	$Product = product::GetProductInfoByKey($_REQUEST['product_key'], $_REQUEST[$_REQUEST['product_key']]);
	if ($Product['site_id'] != $Site['site_id'])
		APIDie(array('desc' => 'Invalid product_key'));
}
	
$SiteLanguageRoots = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	APIDie(array('desc' => ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED));

if (strlen(trim($_REQUEST['product_category_id_list'])) > 0) {
	$ProductCategoryIDList = explode(',', $_REQUEST['product_category_id_list']);
	$ProductCategoryIDList = array_unique($ProductCategoryIDList);

	// Check if all are valid Product Category / Product Root here
	$ValidParentObjTypeArray = array('PRODUCT_CATEGORY', 'PRODUCT_ROOT');
	foreach ($ProductCategoryIDList as $ProductCatID) {
		$ProductCatObj = object::GetObjectInfo($ProductCatID);
		if (!in_array($ProductCatObj['object_type'], $ValidParentObjTypeArray) || $ProductCatObj['site_id'] != $Site['site_id']) {
			APIDie(array('desc' => "Product Cat ID : " . $ProductCatID . " is invalid."));
		}
	}
}
//if (count($ProductCategoryIDList) <= 0)
//	APIDie(array('desc' => "No product_category_id found"));

if (!isset($_REQUEST['currency_id']))
	$_REQUEST['currency_id'] = 0;	
if (!isset($_REQUEST['archive_date']))
	$_REQUEST['archive_date'] = OBJECT_DEFAULT_ARCHIVE_DATE;
if (!isset($_REQUEST['publish_date']))
	$_REQUEST['publish_date'] = OBJECT_DEFAULT_PUBLISH_DATE;
if (!isset($_REQUEST['is_enable']))
	$_REQUEST['is_enable'] = 'Y';
if (!isset($_REQUEST['object_name']))
	$_REQUEST['object_name'] = 'Untitled Object';
if (intval($_REQUEST['discount_type']) < 0 || intval($_REQUEST['discount_type']) > 3)
	$_REQUEST['discount_type'] = 0;
if ($_REQUEST['product_brand_id'] != 0 && strlen(trim($_REQUEST['product_brand_name'])) == 0) {
	$ProductBrand = product::GetProductBrandInfo($_REQUEST['product_brand_id'], 0);
	if ($ProductBrand['site_id'] != $Site['site_id'])
		APIDie(array('desc' => "Product Brand is invalid"), __LINE__);
}

$ObjectThumbnailInfo = array();
if (strlen(trim($_REQUEST['product_thumbnail_url'])) > 0) {
	$ObjectThumbnailInfo = @getimagesize(trim($_REQUEST['product_thumbnail_url']));

	if ($ObjectThumbnailInfo[0] == 0) {
		APIDie(array('desc' => "object_thumbnail_url: cannot load image"), __LINE__);
	}
	elseif ($ObjectThumbnailInfo[2] > 3) { // 1 = GIF, 2 = JPG, 3 = PNG
		APIDie(array('desc' => "object_thumbnail_url: unsupported image type"), __LINE__);
	}
}

// VALIDATION COMPLETE AT THIS POINT!
// Handle Category Type here
$OldProductCategories = product::GetAllProductCategoriesOrProductRootsByObjectID($Product['product_id'], 0);

$OldProductCategoriesID = array();

$ObjTypeArray = array("PRODUCT", "PRODUCT_CATEGORY");

$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);

if (count($ProductCategoryIDList) > 0) { // Just in case something goes wrong in the client side
	// Remove all old deleted product cat 
	foreach ($OldProductCategories as $C) {
		array_push($OldProductCategoriesID, $C['object_id']);

		if (!in_array($C['object_id'], $ProductCategoryIDList)) {
			object::DeleteObjectLink($C['son_obj_link_id']);
			object::TidyUpObjectOrder($C['object_id'], $ObjTypeArray);
			product::UpdateProductCategoryPreCalData($C['object_id'], $SiteLanguageRoots, $Site, $CurrencyList);
		}
	}
	
	foreach ($ProductCategoryIDList as $id) {
		if (!in_array($id, $OldProductCategoriesID)) {
			object::NewObjectLink($id, $Product['product_id'], $Product['object_name']);
			object::TidyUpObjectOrder($id, $ObjTypeArray);
		}
	}
}

object::UpdateObjectSEOData($Product['product_id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);

$query	=	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['is_enable']) . "', " . 
			"			object_security_level	= '" . intval($_REQUEST['security_level']) . "', " .
			"			object_archive_date		= '" . aveEscT($_REQUEST['archive_date']) . "', " .
			"			object_publish_date		= '" . aveEscT($_REQUEST['publish_date']) . "' " .
			"	WHERE	object_id = '" . $Product['product_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	UPDATE	object_link " .
			"	SET		object_link_is_enable	= '" . ynval($_REQUEST['is_enable']) . "' " . 
			"	WHERE	object_id = '" . $Product['product_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$sql = GetCustomTextSQL("product", "int") . GetCustomTextSQL("product", "double") . GetCustomTextSQL("product", "date");
if (strlen($sql) > 0)
	$sql = ", " . substr($sql, 0, -1);

// Backward Compatible
if (isset($_REQUEST['product_price']))
	$_REQUEST['product_price_v2'][1] = $_REQUEST['product_price'];
if (isset($_REQUEST['product_price2']))
	$_REQUEST['product_price_v2'][2] = $_REQUEST['product_price2'];
if (isset($_REQUEST['product_price3']))
	$_REQUEST['product_price_v2'][3] = $_REQUEST['product_price3'];
if (isset($_REQUEST['product_bonus_point_amount']))
	$_REQUEST['product_bonus_point_amount_v2'][1] = $_REQUEST['product_bonus_point_amount'];
if (isset($_REQUEST['discount_type']))
	$_REQUEST['discount_type_v2'][1] = $_REQUEST['discount_type'];
if (isset($_REQUEST['discount1_off_p']))
	$_REQUEST['discount1_off_p_v2'][1] = $_REQUEST['discount1_off_p'];
if (isset($_REQUEST['discount2_amount']))
	$_REQUEST['discount2_amount_v2'][1] = $_REQUEST['discount2_amount'];
if (isset($_REQUEST['discount2_price']))
	$_REQUEST['discount2_price_v2'][1] = $_REQUEST['discount2_price'];
if (isset($_REQUEST['discount3_buy_amount']))
	$_REQUEST['discount3_buy_amount_v2'][1] = $_REQUEST['discount3_buy_amount'];
if (isset($_REQUEST['discount3_free_amount']))
	$_REQUEST['discount3_free_amount_v2'][1] = $_REQUEST['discount3_free_amount'];

if (!isset($_REQUEST['product_price_v2'][1]))
	$sql = $sql . ", product_price = NULL ";
else
	$sql = $sql . ", product_price = '" . doubleval($_REQUEST['product_price_v2'][1]) . "'";

if (!isset($_REQUEST['product_price_v2'][2]))
	$sql = $sql . ", product_price2 = NULL ";
else
	$sql = $sql . ", product_price2 = '" . doubleval($_REQUEST['product_price_v2'][2]) . "'";

if (!isset($_REQUEST['product_price_v2'][3]))
	$sql = $sql . ", product_price3 = NULL ";
else
	$sql = $sql . ", product_price3 = '" . doubleval($_REQUEST['product_price_v2'][3]) . "'";

$query =	"	UPDATE	product " .
			"	SET		is_special_cat_1			= '" . ynval($_REQUEST['is_special_cat_1']) . "', " .
			"			is_special_cat_2			= '" . ynval($_REQUEST['is_special_cat_2']) . "', " .
			"			is_special_cat_3			= '" . ynval($_REQUEST['is_special_cat_3']) . "', " .
			"			is_special_cat_4			= '" . ynval($_REQUEST['is_special_cat_4']) . "', " .
			"			is_special_cat_5			= '" . ynval($_REQUEST['is_special_cat_5']) . "', " .
			"			is_special_cat_6			= '" . ynval($_REQUEST['is_special_cat_6']) . "', " .
			"			is_special_cat_7			= '" . ynval($_REQUEST['is_special_cat_7']) . "', " .
			"			is_special_cat_8			= '" . ynval($_REQUEST['is_special_cat_8']) . "', " .
			"			is_special_cat_9			= '" . ynval($_REQUEST['is_special_cat_9']) . "', " .
			"			is_special_cat_10			= '" . ynval($_REQUEST['is_special_cat_10']) . "', " .
			"			is_special_cat_11			= '" . ynval($_REQUEST['is_special_cat_11']) . "', " .
			"			is_special_cat_12			= '" . ynval($_REQUEST['is_special_cat_12']) . "', " .
			"			is_special_cat_13			= '" . ynval($_REQUEST['is_special_cat_13']) . "', " .
			"			is_special_cat_14			= '" . ynval($_REQUEST['is_special_cat_14']) . "', " .
			"			is_special_cat_15			= '" . ynval($_REQUEST['is_special_cat_15']) . "', " .
			"			is_special_cat_16			= '" . ynval($_REQUEST['is_special_cat_16']) . "', " .
			"			is_special_cat_17			= '" . ynval($_REQUEST['is_special_cat_17']) . "', " .
			"			is_special_cat_18			= '" . ynval($_REQUEST['is_special_cat_18']) . "', " .
			"			is_special_cat_19			= '" . ynval($_REQUEST['is_special_cat_19']) . "', " .
			"			is_special_cat_20			= '" . ynval($_REQUEST['is_special_cat_20']) . "', " .
//			"			product_stock_level			= '" . intval($_REQUEST['product_stock_level']) . "', " .
			"			product_bonus_point_amount	= '" . intval($_REQUEST['product_bonus_point_amount_v2'][1]) . "', " .
			"			discount_type				= '" . intval($_REQUEST['discount_type_v2'][1]) . "', " .
			"			discount1_off_p				= '" . intval($_REQUEST['discount1_off_p_v2'][1]) . "', " .
			"			discount2_amount			= '" . intval($_REQUEST['discount2_amount_v2'][1]) . "', " .
			"			discount2_price				= '" . doubleval($_REQUEST['discount2_price_v2'][1]) . "', " .
			"			discount3_buy_amount		= '" . intval($_REQUEST['discount3_buy_amount_v2'][1]) . "', " .
			"			discount3_free_amount		= '" . intval($_REQUEST['discount3_free_amount_v2'][1]) . "', " .
			"			product_color_id			= '" . intval($_REQUEST['product_color_id']) . "', " .
			"			product_rgb_r				= '" . intval(hexdec(substr($_REQUEST['product_rgb'], 1, 2))) . "', " .
			"			product_rgb_g				= '" . intval(hexdec(substr($_REQUEST['product_rgb'], 3, 2))) . "', " .
			"			product_rgb_b				= '" . intval(hexdec(substr($_REQUEST['product_rgb'], 5, 2))) . "', " .
			"			factory_code				= '" . aveEscT($_REQUEST['factory_code']) . "', " .
			"			product_code				= '" . aveEscT($_REQUEST['product_code']) . "', " .
			"			product_weight				= '" . floatval($_REQUEST['product_weight']) . "', " .
			"			product_size				= '" . aveEscT($_REQUEST['product_size']) . "', " .
			"			product_L					= '" . doubleval($_REQUEST['product_L']) . "', " .
			"			product_W					= '" . doubleval($_REQUEST['product_W']) . "', " . 
			"			product_D					= '" . doubleval($_REQUEST['product_D']) . "'" . $sql .
			"	WHERE	product_id = '" . $Product['product_id'] . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$ProductCustomFieldsDef = site::GetProductCustomFieldsDef($Site['site_id']);

// Remove all rubbish row in product_price
product::CleanUpProductPriceAndPriceLevelRows($Product['product_id'], $_REQUEST['currency_id']);

for ($i = 1; $i <=9; $i++) {
	// Always update price1 for backward compatibility....
	if ($i == 1 || $ProductCustomFieldsDef['product_price' . strval($i)]) {
		$query =	"	INSERT INTO	product_price " .
					"	SET		product_id						= '" . $Product['product_id'] . "', " .
					"			currency_id						= '" . intval($_REQUEST['currency_id']) . "', " .
					"			product_price_id				= '" . $i . "', " .
					"			product_price					= '" . doubleval($_REQUEST['product_price_v2'][$i]) . "', " .
					"			product_bonus_point_required	= '" . intval($_REQUEST['product_bonus_point_required_v2'][$i]) . "', " .
					"			product_bonus_point_amount		= '" . intval($_REQUEST['product_bonus_point_amount_v2'][$i]) . "', " .
					"			discount_type					= '" . intval($_REQUEST['discount_type_v2'][$i]) . "', " .
					"			discount1_off_p					= '" . intval($_REQUEST['discount1_off_p_v2'][$i]) . "', " .
					"			discount2_amount				= '" . intval($_REQUEST['discount2_amount_v2'][$i]) . "', " .
					"			discount2_price					= '" . doubleval($_REQUEST['discount2_price_v2'][$i]) . "', " .
					"			discount3_buy_amount			= '" . intval($_REQUEST['discount3_buy_amount_v2'][$i]) . "', " .
					"			discount3_free_amount			= '" . intval($_REQUEST['discount3_free_amount_v2'][$i]) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

foreach ($SiteLanguageRoots as $R) {
	product::TouchProductData($Product['product_id'], $R['language_id']);
	$tags = explode(",", $_REQUEST['product_tag'][$R['language_id']]);
	$ProductTagText = ', ';
	foreach ($tags as $T)
		$ProductTagText = $ProductTagText . trim($T) . ", ";
	$sql = GetCustomTextSQL("product", "text", $R['language_id'], null, false, $ProductCustomFieldsDef);
	if (strlen($sql) > 0)
		$sql = ", " . substr($sql, 0, -1);

	$query =	"	UPDATE	product_data " .
				"	SET		product_name		= '" . aveEscT($_REQUEST['product_name'][$R['language_id']]) . "', " .
				"			product_color		= '" . aveEscT($_REQUEST['product_color'][$R['language_id']]) . "', " .
				"			product_packaging	= '" . aveEscT($_REQUEST['product_packaging'][$R['language_id']]) . "', " .
				"			product_desc		= '" . aveEscT($_REQUEST['product_desc'][$R['language_id']]) . "', " .
				"			product_tag			= '" . aveEscT($ProductTagText) . "'" . $sql .
				"	WHERE	product_id	= '" . $Product['product_id'] . "'" .
				"		AND	language_id	= '" . $R['language_id'] . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

// Handle special cat now
$ProductCatSpecialList = product::GetProductCatSpecialList($Site['site_id'], 0);
for ($i = 1; $i <= NO_OF_PRODUCT_CAT_SPECIAL; $i++) {
	if ($Product['is_special_cat_' . $i] == 'Y' && $_REQUEST['is_special_cat_' . $i] == 'N') {
		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id	= '" . $ProductCatSpecialList[$i]['product_category_special_id'] . "'" .
					"			AND	object_id 			= '" . $Product['product_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		object::TidyUpObjectOrder($ProductCatSpecialList[$i]['product_category_special_id']);
	}
	elseif ($Product['is_special_cat_' . $i] == 'N' && $_REQUEST['is_special_cat_' . $i] == 'Y') {
		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id	= '" . $ProductCatSpecialList[$i]['product_category_special_id'] . "'" .
					"			AND	object_id 			= '" . $Product['product_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		object::NewObjectLink($ProductCatSpecialList[$i]['product_category_special_id'], $Product['product_id'], '', 0, 'normal', DEFAULT_ORDER_ID);
		object::TidyUpObjectOrder($ProductCatSpecialList[$i]['product_category_special_id']);
	}
}

// Handle Product Brand
if (strlen(trim($_REQUEST['product_brand_name'])) > 0) {
	$query =	"	SELECT	* " .
				"	FROM	object O	JOIN product_brand B ON (O.object_id = B.product_brand_id) " .
				"						JOIN object_link OL ON (OL.object_id = O.object_id) " .
				"	WHERE	OL.object_name = '" . aveEscT($_REQUEST['product_brand_name']) . "'" .
				"		AND O.site_id = '" . $Site['site_id'] . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	if ($result->num_rows > 0) {
		$myResult = $result->fetch_assoc();
		$_REQUEST['product_brand_id'] = $myResult['product_brand_id'];
	}
	else {
		$ProductBrandID = object::NewObject('PRODUCT_BRAND', $Site['site_id'], 0);
		$ObjLinkID = object::NewObjectLink($Site['site_product_brand_root_id'], $ProductBrandID, trim($_REQUEST['product_brand_name']), 0, 'normal', DEFAULT_ORDER_ID);
		object::TidyUpObjectOrder($Site['site_product_brand_root_id']);
		product::NewProductBrand($ProductBrandID);
		
		$_REQUEST['product_brand_id'] = $ProductBrandID;		
	}
}

if (intval($_REQUEST['product_brand_id']) > 0) {
	$ProductBrand = product::GetProductBrandInfo($_REQUEST['product_brand_id'], 0);
	
	if ($Product['product_brand_id'] != $_REQUEST['product_brand_id']) {		
		object::NewObjectLink($ProductBrand['product_brand_id'], $Product['product_id'], '', 0, 'normal', DEFAULT_ORDER_ID);
		object::TidyUpObjectOrder($ProductBrand['product_brand_id'], 'PRODUCT');

		if ($Product['product_brand_id'] != 0) {
			$query =	"	DELETE FROM	object_link " .
						"	WHERE		parent_object_id	= '" . $Product['product_brand_id'] . "'" .
						"			AND	object_id 			= '" . $Product['product_id'] . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			object::TidyUpObjectOrder($ProductBrand['product_brand_id'], 'PRODUCT');
		}
		$query =	"	UPDATE	product " .
					"	SET		product_brand_id = '" . $ProductBrand['product_brand_id'] . "' " .
					"	WHERE	product_id = '" . $Product['product_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}
else if (intval($_REQUEST['product_brand_id']) < 0) {
	if ($Product['product_brand_id'] != 0) {
		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id	= '" . $Product['product_brand_id'] . "'" .
					"			AND	object_id 			= '" . $Product['product_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		object::TidyUpObjectOrder($ProductBrand['product_brand_id'], 'PRODUCT');

		$query =	"	UPDATE	product " .
					"	SET		product_brand_id = '0' " .
					"	WHERE	product_id = '" . $Product['product_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

if (isset($_REQUEST['product_thumbnail_url']) && @getimagesize($_REQUEST['product_thumbnail_url'])) {
	$PathInfo = pathinfo(trim($_REQUEST['product_thumbnail_url']));
	$ObjectThumbnailFile = file_get_contents(trim($_REQUEST['product_thumbnail_url']));
	
	$TmpFile = tempnam("/tmp", "TmpImportImageFile");
	file_put_contents($TmpFile, $ObjectThumbnailFile);

	$TheFile = array();
	$TheFile['name'] = $PathInfo['basename'];
	$TheFile['size'] = filesize($TmpFile);
	$TheFile['tmp_name'] = $TmpFile;
	$FileExt = strtolower(substr(strrchr($PathInfo['basename'], '.'), 1));
	$ThumbnailOK = true;

	if ($ObjectThumbnailInfo[2] == 1) {
		$TheFile['type'] = 'image/gif';
		$GenFileExt = 'gif';
	}
	elseif ($ObjectThumbnailInfo[2] == 2) {
		$TheFile['type'] = 'image/jpeg';
		$GenFileExt = 'jpg';
	}
	elseif ($ObjectThumbnailInfo[2] == 3) {
		$TheFile['type'] = 'image/png';
		$GenFileExt = 'png';
	}
	else
		$ThumbnailOK = false; // Should not happen actually. Error checking before
	
	if ($GenFileExt != $FileExt)
		$TheFile['name'] = $TheFile['name'] . "." . $GenFileExt;
	
	if ($ThumbnailOK)
		object::UpdateObjectThumbnail($Product, $Site, $TheFile, $Site['site_product_media_small_width'], $Site['site_product_media_small_height']);

	unlink($TmpFile);
}

product::UpdateAllProductCategoryPreCalDataByProductID($Product['product_id'], $SiteLanguageRoots, $Site, $CurrencyList);

product::UpdateTimeStamp($Product['product_id']);
site::EmptyAPICache($Site['site_id']);

//$smarty->assign('Data', "<product_id>" . $NewProductID . "</product_id>");
$smarty->display('api/api_result.tpl');