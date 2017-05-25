<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_edit');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$Product = product::GetProductInfoByObjLinkID($_REQUEST['link_id'], 0);
if ($Product['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);
$smarty->assign('Product', $Product);

$sql = GetCustomTextSQL("product", "int") . GetCustomTextSQL("product", "double") . GetCustomTextSQL("product", "date");
if (strlen($sql) > 0)
	$sql = ", " . substr($sql, 0, -1);

//if (doubleval($_REQUEST['product_price2']) == 0 && $_REQUEST['product_price2'] != "0")
//	$sql = $sql . ", product_price2 = NULL ";
//else
//	$sql = $sql . ", product_price2 = '" . doubleval($_REQUEST['product_price2']) . "'";
//
//if (doubleval($_REQUEST['product_price3']) == 0 && $_REQUEST['product_price3'] != "0")
//	$sql = $sql . ", product_price3 = NULL ";
//else
//	$sql = $sql . ", product_price3 = '" . doubleval($_REQUEST['product_price3']) . "'";

// Handle Category Type here
$OldProductCategories = product::GetAllProductCategoriesOrProductRootsByObjectID($Product['product_id'], 0);
unset($_REQUEST['product_category_id'][-1]);
$NewProductCategoriesID = array_unique($_REQUEST['product_category_id']);

// Check if all are valid Product Category / Product Root here
$ValidParentObjTypeArray = array('PRODUCT_CATEGORY', 'PRODUCT_ROOT');
foreach ($NewProductCategoriesID as $index => $value) {
	$NewProductCatObj = object::GetObjectInfo($value);
	if (!in_array($NewProductCatObj['object_type'], $ValidParentObjTypeArray) || $NewProductCatObj['site_id'] != $_SESSION['site_id']) {
		unset($NewProductCategoriesID[$index]);
	}
}

$OldProductCategoriesID = array();

$ObjTypeArray = array("PRODUCT", "PRODUCT_CATEGORY");

$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);

if (count($NewProductCategoriesID) > 0) { // Just in case something goes wrong in the client side
	// Remove all old deleted product cat 
	foreach ($OldProductCategories as $C) {
		array_push($OldProductCategoriesID, $C['object_id']);

		if (!in_array($C['object_id'], $NewProductCategoriesID)) {
			object::DeleteObjectLink($C['son_obj_link_id']);
			object::TidyUpObjectOrder($C['object_id'], $ObjTypeArray);
			product::UpdateProductCategoryPreCalData($C['object_id'], $SiteLanguageRoots, $Site, $CurrencyList);
		}
	}

	
	foreach ($NewProductCategoriesID as $id) {
		if (!in_array($id, $OldProductCategoriesID)) {
			object::NewObjectLink($id, $ObjectLink['object_id'], $Product['object_name']);
			object::TidyUpObjectOrder($id, $ObjTypeArray);
		}
	}
}

$ProductCustomFieldsDef = site::GetProductCustomFieldsDef($_SESSION['site_id']);

// Remove all rubbish row in product_price
product::CleanUpProductPriceAndPriceLevelRows($Product['product_id']);

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
			"			product_price				= '" . doubleval($_REQUEST['product_price_0_1']) . "', " .
			"			product_price2				= '" . doubleval($_REQUEST['product_price_0_2']) . "', " .
			"			product_price3				= '" . doubleval($_REQUEST['product_price_0_3']) . "', " .
			"			product_bonus_point_amount	= '" . intval($_REQUEST['product_bonus_point_amount_0_1']) . "', " .
			"			discount_type				= '" . intval($_REQUEST['discount_type_0_1']) . "', " .
			"			discount1_off_p				= '" . intval($_REQUEST['discount1_off_p_0_1']) . "', " .
			"			discount2_amount			= '" . intval($_REQUEST['discount2_amount_0_1']) . "', " .
			"			discount2_price				= '" . doubleval($_REQUEST['discount2_price_0_1']) . "', " .
			"			discount3_buy_amount		= '" . intval($_REQUEST['discount3_buy_amount_0_1']) . "', " .
			"			discount3_free_amount		= '" . intval($_REQUEST['discount3_free_amount_0_1']) . "', " .
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
			"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

for ($i = 1; $i <=9; $i++) {
	// Always update price1 for backward compatibility....
	if ($i == 1 || $ProductCustomFieldsDef['product_price' . strval($i)]) {
		
		$CurrencyList = array();
		
		if ($Site['site_product_price_indepedent_currency'] == 'Y') {
			$CurrencyList = currency::GetAllSiteCurrencyList($_SESSION['site_id']);			
		}
		else {
			array_push($CurrencyList, array('currency_id' => 0));
		}
		
		foreach ($CurrencyList as $C) {			
			if ($_REQUEST['product_price_enable_' . $C['currency_id'] . '_' . $i] == 'Y') {
				$query =	"	INSERT INTO	product_price " .
							"	SET		product_id						= '" . intval($Product['product_id']) . "', " .
							"			product_price_id				= '" . $i . "', " .
							"			currency_id						= '" . intval($C['currency_id']) . "', " .
							"			product_price					= '" . doubleval($_REQUEST['product_price_' . $C['currency_id'] . '_' . $i]) . "', " .
							"			product_bonus_point_required	= '" . intval($_REQUEST['product_bonus_point_required_' . $C['currency_id'] . '_' . $i]) . "', " .
							"			product_bonus_point_amount		= '" . intval($_REQUEST['product_bonus_point_amount_' . $C['currency_id'] . '_' . $i]) . "', " .
							"			discount_type					= '" . intval($_REQUEST['discount_type_' . $C['currency_id'] . '_' . $i]) . "', " .
							"			discount1_off_p					= '" . intval($_REQUEST['discount1_off_p_' . $C['currency_id'] . '_' . $i]) . "', " .
							"			discount2_amount				= '" . intval($_REQUEST['discount2_amount_' . $C['currency_id'] . '_' . $i]) . "', " .
							"			discount2_price					= '" . doubleval($_REQUEST['discount2_price_' . $C['currency_id'] . '_' . $i]) . "', " .
							"			discount3_buy_amount			= '" . intval($_REQUEST['discount3_buy_amount_' . $C['currency_id'] . '_' . $i]) . "', " .
							"			discount3_free_amount			= '" . intval($_REQUEST['discount3_free_amount_' . $C['currency_id'] . '_' . $i]) . "' ";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

				if (intval($_REQUEST['discount_type_' . $C['currency_id'] . '_' . $i]) == 4) {
					$ProductPriceLevelList = array();
					foreach($_REQUEST['product_price_level_min_' . $C['currency_id'] . '_' . $i] as $key => $value) {
						if (intval($value) >= 0 && doubleval($_REQUEST['product_price_level_price_' . $C['currency_id'] . '_' . $i][$key]) > 0) {
							$ProductPriceLevelList[intval($value)] = doubleval($_REQUEST['product_price_level_price_' . $C['currency_id'] . '_' . $i][$key]);
						}
					}
					if ($ProductPriceLevelList[0] > 0) {

						krsort($ProductPriceLevelList);
						$LastMin = 99999999;
						foreach($ProductPriceLevelList as $key => $value) {
							$query =	"	INSERT INTO	product_price_level " .
										"	SET		product_price_level_min		= '" . aveEscT($key) . "', " .
										"			product_price_level_max		= '" . aveEscT($LastMin) . "', " .
										"			product_price_level_price	= '" . aveEscT($value) . "', " .
										"			product_price_id			= '" . intval($i) . "', " .
										"			currency_id					= '" . intval($C['currency_id']) . "', " .
										"			product_id					= '" . intval($Product['product_id']) . "'";
							$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

							$LastMin = $key;
						}
						$query =	"	UPDATE	product_price " .
									"	SET		product_price = '" . doubleval($ProductPriceLevelList[0]) . "' " .
									"	WHERE	product_id = '" . intval($Product['product_id']) . "'" .
									"		AND	product_price_id = '" . intval($i) . "'" .
									"		AND currency_id = '" . intval($C['currency_id']) . "'";
						$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
					}
					else {
						$query =	"	UPDATE	product_price " .
									"	SET		discount_type = '0' " .
									"	WHERE	product_id = '" . intval($Product['product_id']) . "'" .
									"		AND	product_price_id = '" . intval($i) . "'" .
									"		AND currency_id = '" . intval($C['currency_id']) . "'";
						$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

						if ($C['currency_id'] == 0) {
							if ($i == 1) {
								$query =	"	UPDATE	product " .
											"	SET		discount_type	= '0', " .
											"			product_price	= '" . doubleval($ProductPriceLevelList[0]) . "' " .
											"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
								$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
							}
							else if ($i == 2 || $i == 3) {
								$query =	"	UPDATE	product " .
											"	SET		product_price$i	= '" . doubleval($ProductPriceLevelList[0]) . "' " .
											"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
								$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
							}						
						}

						$ErrorMessage = ADMIN_ERROR_PRODUCT_PRICE_LEVEL_ZERO_MUST_BE_GREATER_THAN_ZERO;
					}
				}					
			}
		}
	}
}

foreach ($SiteLanguageRoots as $R) {
	product::TouchProductData($Product['product_id'], $R['language_id']);
	
	$tags = explode(",", $_REQUEST['product_tag'][$R['language_id']]);
	$ProductTagText = ', ';
	foreach ($tags as $T)
		$ProductTagText = $ProductTagText . trim($T) . ", ";

	$sql =	GetCustomTextSQL("product", "autotext", $R['language_id'], null, false, $ProductCustomFieldsDef);	
	if (strlen($sql) > 0)
		$sql = ", " . substr($sql, 0, -1);

	$query =	"	UPDATE	product_data " .
				"	SET		product_name		= '" . aveEscT($_REQUEST['product_name'][$R['language_id']]) . "', " .
				"			product_color		= '" . aveEscT($_REQUEST['product_color'][$R['language_id']]) . "', " .
				"			product_packaging	= '" . aveEscT($_REQUEST['product_packaging'][$R['language_id']]) . "', " .
				"			product_desc		= '" . aveEscT($_REQUEST['ContentEditor' . $R['language_id']]) . "', " .
				"			product_tag			= '" . aveEsc($ProductTagText) . "' " . $sql .
				"	WHERE	product_id	= '" . intval($Product['product_id']) . "'" .
				"		AND	language_id	= '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$query =	"	UPDATE	product_data " .
				"	SET		object_meta_title	= '" . aveEscT($_REQUEST['object_meta_title'][$R['language_id']]) . "', " .
				"			object_meta_description		= '" . aveEscT($_REQUEST['object_meta_description'][$R['language_id']]) . "', " .
				"			object_meta_keywords	= '" . aveEscT($_REQUEST['object_meta_keywords'][$R['language_id']]) . "', " .
				"			object_friendly_url		= '" . aveEscT($_REQUEST['object_friendly_url'][$R['language_id']]) . "' " .
				"	WHERE	product_id	= '" . intval($Product['product_id']) . "'" .
				"		AND	language_id	= '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

// Handle special cat now
$ProductCatSpecialList = product::GetProductCatSpecialList($_SESSION['site_id'], 0);

for ($i = 1; $i <= NO_OF_PRODUCT_CAT_SPECIAL; $i++) {
	if ($Product['is_special_cat_' . $i] == 'Y' && !isset($_REQUEST['is_special_cat_' . $i])) {
		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id	= '" . intval($ProductCatSpecialList[$i]['product_category_special_id']) . "'" .
					"			AND	object_id 			= '" . intval($Product['product_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		object::TidyUpObjectOrder($ProductCatSpecialList[$i]['product_category_special_id']);
	}
	elseif ($Product['is_special_cat_' . $i] == 'N' && $_REQUEST['is_special_cat_' . $i] == 'Y') {
		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id	= '" . intval($ProductCatSpecialList[$i]['product_category_special_id']) . "'" .
					"			AND	object_id 			= '" . intval($Product['product_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		object::NewObjectLink($ProductCatSpecialList[$i]['product_category_special_id'], $Product['product_id'], '', 0, 'normal', DEFAULT_ORDER_ID);
		object::TidyUpObjectOrder($ProductCatSpecialList[$i]['product_category_special_id']);
	}
}

// Handle Product Brand
if (intval($_REQUEST['product_brand_id']) > 0) {
	$ProductBrand = product::GetProductBrandInfo($_REQUEST['product_brand_id'], 0);

	if ($ProductBrand['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

	if ($Product['product_brand_id'] != $_REQUEST['product_brand_id']) {		
		object::NewObjectLink($ProductBrand['product_brand_id'], $Product['product_id'], '', 0, 'normal', DEFAULT_ORDER_ID);
		object::TidyUpObjectOrder($ProductBrand['product_brand_id'], 'PRODUCT');

		if ($Product['product_brand_id'] != 0) {
			$query =	"	DELETE FROM	object_link " .
						"	WHERE		parent_object_id	= '" . intval($Product['product_brand_id']) . "'" .
						"			AND	object_id 			= '" . intval($Product['product_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			object::TidyUpObjectOrder($ProductBrand['product_brand_id'], 'PRODUCT');
		}
		$query =	"	UPDATE	product " .
					"	SET		product_brand_id = '" . intval($ProductBrand['product_brand_id']) . "' " .
					"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}
else {
	if ($Product['product_brand_id'] != 0) {
		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id	= '" . intval($Product['product_brand_id']) . "'" .
					"			AND	object_id 			= '" . intval($Product['product_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		object::TidyUpObjectOrder($ProductBrand['product_brand_id'], 'PRODUCT');
		
		$query =	"	UPDATE	product " .
					"	SET		product_brand_id = '0' " .
					"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

$query =	"	UPDATE	object_link " .
			"	SET		object_name	= '" . aveEscT($_REQUEST['object_name']) . "' " .
			"	WHERE	object_id = '" . intval($Product['product_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::UpdateObjectCommonDataFromRequest($ObjectLink);
object::UpdateObjectSEOData($Product['product_id'], null, null, null, null, $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($Product['product_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

if ($_REQUEST['remove_thumbnail'] == 'Y')
	object::RemoveObjectThumbnail($Product, $Site);	

$Site = site::GetSiteInfo($_SESSION['site_id']);

// Handle Highlight File
if (isset($_FILES['product_file']) && $_FILES['product_file']['size'] > 0) {
	if (object::UpdateObjectThumbnail($Product, $Site, $_FILES['product_file'], $Site['site_product_media_small_width'], $Site['site_product_media_small_height']) === false)
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
}

product::UpdateAllProductCategoryPreCalDataByProductID($Product['product_id'], $SiteLanguageRoots, $Site, $CurrencyList);

product::UpdateTimeStamp($Product['product_id']);
site::EmptyAPICache($_SESSION['site_id']);

$Product = product::GetProductInfo($Product['product_id'], 0);

header( 'Location: product_edit.php?link_id=' . $Product['object_link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));