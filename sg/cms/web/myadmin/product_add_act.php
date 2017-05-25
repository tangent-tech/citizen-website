<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_add", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_add_act');

$NoOfProducts = product::GetNoOfProduct($_SESSION['site_id']);
if ($NoOfProducts >= $Site['site_module_product_quota'])
	AdminDie(ADMIN_ERROR_PRODUCT_QUOTA_FULL, 'product_tree.php', __LINE__);

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

//$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
$ObjectLink = object::GetObjectInfo($_REQUEST['parent_object_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("add_children", $ObjectLink, __FILE__, false);

$id = 0;
$link_id = 0;

if (!object::ValidateCreateObjectInTree(array('PRODUCT_ROOT', 'PRODUCT_CATEGORY'), $ObjectLink, 'inside', $_SESSION['site_id'], false, 'PRODUCT'))
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
object::CreateObjectInTree('PRODUCT', $ObjectLink, 'inside', $_SESSION['site_id'], $id, $link_id, trim($_REQUEST['object_name']), $ObjectLink);
product::NewProduct($id);

$Product = product::GetProductInfo($id, 0);
if ($Product['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);
$smarty->assign('Product', $Product);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

$query	=	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['object_is_enable']) . "', " .
			"			object_archive_date		= '" . aveEscT($ObjectArchiveDateText) . "', " .
			"			object_publish_date		= '" . aveEscT($ObjectPublishDateText) . "', " .
			"			object_security_level	= '" . intval($_REQUEST['object_security_level']) . "' " .
			"	WHERE	object_id = '" . intval($Product['product_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	UPDATE	object_link " .
			"	SET		object_name	= '" . aveEscT($_REQUEST['object_name']) . "' " .
			"	WHERE	object_id = '" . intval($Product['product_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::UpdateObjectSEOData($Product['product_id'], null, null, null, null, $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($Product['product_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

$sql = GetCustomTextSQL("product", "int") . GetCustomTextSQL("product", "double") . GetCustomTextSQL("product", "date");
if (strlen($sql) > 0)
	$sql = ", " . substr($sql, 0, -1);

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
			"			product_price				= '" . doubleval($_REQUEST['product_price'][1]) . "', " .
			"			product_price2				= '" . doubleval($_REQUEST['product_price'][2]) . "', " .
			"			product_price3				= '" . doubleval($_REQUEST['product_price'][3]) . "', " .
			"			product_bonus_point_amount	= '" . intval($_REQUEST['product_bonus_point_amount'][1]) . "', " .
			"			discount_type				= '" . intval($_REQUEST['discount_type'][1]) . "', " .
			"			discount1_off_p				= '" . intval($_REQUEST['discount1_off_p'][1]) . "', " .
			"			discount2_amount			= '" . intval($_REQUEST['discount2_amount'][1]) . "', " .
			"			discount2_price				= '" . doubleval($_REQUEST['discount2_price'][1]) . "', " .
			"			discount3_buy_amount		= '" . intval($_REQUEST['discount3_buy_amount'][1]) . "', " .
			"			discount3_free_amount		= '" . intval($_REQUEST['discount3_free_amount'][1]) . "', " .
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
			"			product_D					= '" . doubleval($_REQUEST['product_D']) . "' " . $sql .
			"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$ProductCustomFieldsDef = site::GetProductCustomFieldsDef($_SESSION['site_id']);

for ($i = 1; $i <=9; $i++) {
	// Always update price1 for backward compatibility....
	if ($i == 1 || $ProductCustomFieldsDef['product_price' . strval($i)]) {
		$query =	"	INSERT INTO	product_price " .
					"	SET		product_id						= '" . intval($Product['product_id']) . "', " .
					"			product_price_id				= '" . $i . "', " .
					"			product_price					= '" . doubleval($_REQUEST['product_price'][$i]) . "', " .
					"			product_bonus_point_required	= '" . intval($_REQUEST['product_bonus_point_required'][$i]) . "', " .
					"			product_bonus_point_amount		= '" . intval($_REQUEST['product_bonus_point_amount'][$i]) . "', " .
					"			discount_type					= '" . intval($_REQUEST['discount_type'][$i]) . "', " .
					"			discount1_off_p					= '" . intval($_REQUEST['discount1_off_p'][$i]) . "', " .
					"			discount2_amount				= '" . intval($_REQUEST['discount2_amount'][$i]) . "', " .
					"			discount2_price					= '" . doubleval($_REQUEST['discount2_price'][$i]) . "', " .
					"			discount3_buy_amount			= '" . intval($_REQUEST['discount3_buy_amount'][$i]) . "', " .
					"			discount3_free_amount			= '" . intval($_REQUEST['discount3_free_amount'][$i]) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if (intval($_REQUEST['discount_type'][$i]) == 4) {
			$ProductPriceLevelList = array();
			foreach($_REQUEST['product_price_level_min'. strval($i)] as $key => $value) {
				if (intval($value) >= 0 && doubleval($_REQUEST['product_price_level_price' . strval($i)][$key]) > 0) {
					$ProductPriceLevelList[intval($value)] = doubleval($_REQUEST['product_price_level_price' . strval($i)][$key]);
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
								"			product_price_id			= '" . aveEscT($i) . "', " .
								"			product_id					= '" . intval($Product['product_id']) . "'";
					$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

					$LastMin = $key;
				}
				$query =	"	UPDATE	product_price " .
							"	SET		product_price = '" . aveEscT($ProductPriceLevelList[0]) . "' " .
							"	WHERE	product_id = '" . intval($Product['product_id']) . "'" .
							"		AND	product_price_id = '" . $i . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
			else {
				$query =	"	UPDATE	product_price " .
							"	SET		discount_type = '0' " .
							"	WHERE	product_id = '" . intval($Product['product_id']) . "'" .
							"		AND	product_price_id = '" . $i . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

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
				
				$ErrorMessage = ADMIN_ERROR_PRODUCT_PRICE_LEVEL_ZERO_MUST_BE_GREATER_THAN_ZERO;
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
	$sql = GetCustomTextSQL("product", "autotext", $R['language_id'], null, false, $ProductCustomFieldsDef);
	if (strlen($sql) > 0)
		$sql = ", " . substr($sql, 0, -1);

	$query =	"	UPDATE	product_data " .
				"	SET		product_name		= '" . aveEscT($_REQUEST['product_name'][$R['language_id']]) . "', " .
				"			product_color		= '" . aveEscT($_REQUEST['product_color'][$R['language_id']]) . "', " .
				"			product_packaging	= '" . aveEscT($_REQUEST['product_packaging'][$R['language_id']]) . "', " .
				"			product_desc		= '" . aveEscT($_REQUEST['ContentEditor' . $R['language_id']]) . "', " .
				"			product_tag			= '" . aveEsc($ProductTagText) . "'" . $sql .
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
	if ($_REQUEST['is_special_cat_' . $i] == 'Y') {
		object::NewObjectLink($ProductCatSpecialList[$i]['product_category_special_id'], $Product['product_id'], '', 0, 'normal', DEFAULT_ORDER_ID);
		object::TidyUpObjectOrder($ProductCatSpecialList[$i]['product_category_special_id']);
	}
}

// Handle Product Brand
if ($_REQUEST['product_brand_id'] != 0) {
	$ProductBrand = product::GetProductBrandInfo($_REQUEST['product_brand_id'], 0);

	if ($ProductBrand['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

	object::NewObjectLink($ProductBrand['product_brand_id'], $Product['product_id'], '', 0, 'normal', DEFAULT_ORDER_ID);
	object::TidyUpObjectOrder($ProductBrand['product_brand_id'], 'PRODUCT');

	$query =	"	UPDATE	product " .
				"	SET		product_brand_id = '" . intval($ProductBrand['product_brand_id']) . "' " .
				"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

// Handle Highlight File
if (isset($_FILES['product_file']) && $_FILES['product_file']['size'] > 0) {
	$Site = site::GetSiteInfo($_SESSION['site_id']);
	if (object::UpdateObjectThumbnail($Product, $Site, $_FILES['product_file'], $Site['site_product_media_small_width'], $Site['site_product_media_small_height']) === false)
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
}

$ProductCat = product::GetProductCatInfo($ObjectLink['object_id'], 0);
for ($i = 1; $i <= $ProductCat['product_category_no_of_group_media_fields']; $i++) {
	if (isset($_FILES['product_group_media_file_' . $i]) && $_FILES['product_group_media_file_' . $i]['size'] > 0)
		$FileID = filebase::AddPhoto($_FILES['product_group_media_file_' . $i], 0, 0, $Site, 0, $ObjectLink['object_id']);
	
	if ($FileID !== false) {
		$query =	"	UPDATE	product " .
					"	SET		product_group_media_file_1 = '" . intval($FileID) . "' " .
					"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);
product::UpdateAllProductCategoryPreCalDataByProductID($Product['product_id'], $SiteLanguageRoots, $Site, $CurrencyList);

product::UpdateTimeStamp($Product['product_id']);
site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_edit.php?link_id=' . $link_id .  '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));