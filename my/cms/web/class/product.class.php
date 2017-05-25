<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class product {

	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetProductRootList($Site) {

		$query =	"	SELECT	* " .
					"	FROM	object O	JOIN	object_link OL ON (OL.object_id = O.object_id AND OL.object_link_is_shadow = 'N') " .
					"	WHERE	OL.parent_object_id = '" . intval($Site['library_root_id']) . "'" .
					"		AND	O.object_type = 'PRODUCT_ROOT' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductRoots = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ProductRoots, $myResult);
		}
		return $ProductRoots;
	}

	public static function GetProductRootInfo($ProductRootID, $LanguageID = 0) {
		$query =	"	SELECT	O.*, D.*, OL.* " .
					"	FROM	object O	" . 
					"				JOIN		object_link OL ON (OL.object_id = O.object_id AND OL.object_link_is_shadow = 'N') " .
					"				LEFT JOIN	product_root_data D ON (D.product_root_id = O.object_id AND D.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	O.object_id =  '" . intval($ProductRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetProductRootByObjLinkID($ObjLinkID) {
		$query =	"	SELECT	* " .
					"	FROM	object O JOIN object_link OL ON (OL.object_id = O.object_id AND OL.object_link_is_shadow = 'N') " .
					"	WHERE	OL.object_link_id =  '" . intval($ObjLinkID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function NewProductCatSpecial($ObjectID, $No) {
		$query =	"	INSERT INTO product_category_special " .
					"	SET		product_category_special_id	= '" . intval($ObjectID) . "', " .
					"			product_category_special_no	= '" . intval($No) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function NewProductCat($ObjectID, $ProductCatCommonName) {
		$query =	"	INSERT INTO product_category " .
					"	SET		product_category_id	= '" . intval($ObjectID) . "'";
//						"			product_category_common_name = '" . trim($ProductCatCommonName) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function NewProductBrand($ObjectID) {
		$query =	"	INSERT INTO product_brand " .
					"	SET		product_brand_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function NewProduct($ObjectID) {
		$query =	"	INSERT INTO product " .
					"	SET		product_id	= '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetProductBrandInfo($ObjectID, $LanguageID) {
		$query =	"	SELECT	*, B.* " .
					"	FROM	object_link OL	JOIN		object BO				ON (OL.object_id = BO.object_id AND OL.object_link_is_shadow = 'N') " .
					"							JOIN		product_brand B			ON (B.product_brand_id = BO.object_id) " .
					"							LEFT JOIN	product_brand_data BD	ON (B.product_brand_id = BD.product_brand_id AND BD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	OL.object_id	= '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetProductInfo($ObjectID, $LanguageID) {
		$query =	"	SELECT	C.*, PO.*, PD.*, PC.*, P.*, OL.* " .
					"	FROM	object_link OL	JOIN		object PO			ON	(OL.object_id = PO.object_id AND OL.object_link_is_shadow = 'N') " .
					"							JOIN		product P			ON	(P.product_id = PO.object_id) " .
					"							LEFT JOIN	product_category PC	ON	(PC.product_category_id = OL.parent_object_id) " .
					"							LEFT JOIN	product_data PD		ON	(P.product_id = PD.product_id AND PD.language_id = '" . intval($LanguageID) . "') " .
					"							LEFT JOIN	color C				ON	(C.color_id = P.product_color_id AND C.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	OL.object_id	= '" . intval($ObjectID) . "'" .
					"	ORDER BY PC.product_category_id DESC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		// die(var_dump($query));
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetProductInfoByKey($KeyName, $KeyValue) {
		$ValidKeyNameArray = array('product_code', 'factory_code');
		if (!in_array($KeyName, $ValidKeyNameArray))
			return null;
		
		$query =	"	SELECT	C.*, PO.*, PD.*, PC.*, P.*, OL.* " .
					"	FROM	object_link OL	JOIN		object PO			ON	(OL.object_id = PO.object_id AND OL.object_link_is_shadow = 'N') " .
					"							JOIN		product P			ON	(P.product_id = PO.object_id) " .
					"							LEFT JOIN	product_category PC	ON	(PC.product_category_id = OL.parent_object_id) " .
					"							LEFT JOIN	product_data PD		ON	(P.product_id = PD.product_id AND PD.language_id = '" . intval($LanguageID) . "') " .
					"							LEFT JOIN	color C				ON	(C.color_id = P.product_color_id AND C.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	P." . aveEscT($KeyName) . "	= '" . aveEscT($KeyValue) . "'" .
					"	ORDER BY PC.product_category_id DESC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
		
	}
	
	public static function GetProductInfoByObjLinkID($ObjLinkID, $LanguageID) {
		$query =	"	SELECT	C.*, PC.*, PO.*, PD.*, P.*, OL.* " .
//						"	FROM	object_link OL	JOIN		object PO			ON	(OL.object_id = PO.object_id AND OL.object_link_is_shadow = 'N') " .
					"	FROM	object_link OL	JOIN		object PO			ON	(OL.object_id = PO.object_id) " .
					"							JOIN		product P			ON	(P.product_id = PO.object_id) " .
					"							LEFT JOIN	product_category PC	ON	(PC.product_category_id = OL.parent_object_id) " .
					"							LEFT JOIN	product_data PD		ON	(P.product_id = PD.product_id AND PD.language_id = '" . intval($LanguageID) . "') " .
					"							LEFT JOIN	color C				ON	(C.color_id = P.product_color_id AND C.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	OL.object_link_id	= '" . intval($ObjLinkID) . "'" .
					"	ORDER BY PC.product_category_id DESC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetEffectiveProductPriceLevel($ObjectID, $Quantity, $ProductPriceID = 1, $CurrencyID = 0) {
		$query =	"	SELECT	* " .
					"	FROM	product P	JOIN	product_price_level L	ON	(P.product_id = L.product_id) " .
					"	WHERE	P.product_id	= '" . intval($ObjectID) . "'" .
					"		AND	L.product_price_level_min <= '" . intval($Quantity) . "'" .
					"		AND	L.product_price_level_max > '" . intval($Quantity) . "'" .
					"		AND	L.product_price_id = '" . intval($ProductPriceID) . "'" .
					"		AND L.currency_id = '" . intval($CurrencyID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetAllProductPriceList($ProductID, $Site) {
		$AllProductPriceList = array();

		if ($Site['site_product_price_indepedent_currency'] == 'Y') {
			$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);

			foreach ($CurrencyList as $C) {
				$AllProductPriceList[intval($C['currency_id'])] = array();
				$ProductPriceList = product::GetProductPriceList($ProductID, $C['currency_id']);

				$AllProductPriceList[intval($C['currency_id'])]['product_price_list'] = $ProductPriceList;

				$AllProductPriceList[intval($C['currency_id'])]['currency_name'] = $C['currency_shortname'];
			}
		}
		else {
			$AllProductPriceList[0]['product_price_list'] = product::GetProductPriceList($ProductID, 0);
		}

		return $AllProductPriceList;
	}

	public static function GetProductPriceList($ProductID, $CurrencyID = 0) {
		$query =	"	SELECT	* " .
					"	FROM	product_price " .
					"	WHERE	product_id	= '" . intval($ProductID) . "'" .
					"		AND	currency_id = '" . intval($CurrencyID) . "'" .
					"	ORDER By	product_price_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductPrice = array();
		while ($myResult = $result->fetch_assoc()) {
			$myResult['ProductPriceLevel'] = product::GetProductPriceLevelList($ProductID, $myResult['product_price_id'], $CurrencyID);
			$ProductPrice[$myResult['product_price_id']] = $myResult;
		}
		return $ProductPrice;
	}

	public static function GetProductPriceLevelList($ProductID, $ProductPriceID, $CurrencyID = 0) {
		$query =	"	SELECT	* " .
					"	FROM	product_price_level " .
					"	WHERE	product_id	= '" . intval($ProductID) . "'" .
					"		AND	product_price_id = '" . intval($ProductPriceID) . "'" .
					"		AND currency_id = '" . intval($CurrencyID) . "'" .
					"	ORDER By product_price_level_min ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductLevels = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ProductLevels, $myResult);
		}
		return $ProductLevels;
	}

	public static function GetProductPriceLevelListXML($ProductID, $ProductPriceID = 1, $CurrencyObj = null, $Site = null) {
		$smarty = new mySmarty();

		if ($Site == null) {
			//This is not what I want to maintain but for safety
			$Product = product::GetProductInfo($ProductID, 0);
			$Site = site::GetSiteInfo($Product['site_id']);
		}

		$EffectiveCurrencyID = 0;
		if ($Site['site_product_price_indepedent_currency'] == 'Y')
			$EffectiveCurrencyID = intval($CurrencyObj->currency_id);			

		$ProductPriceLevelList = product::GetProductPriceLevelList($ProductID, $ProductPriceID, $EffectiveCurrencyID);
		$ProductPriceLevelListXML = '';
		foreach ($ProductPriceLevelList as $L) {
			$L['product_price_level_price_ca'] = round($L['product_price_level_price'] * $CurrencyObj->currency_site_rate, $CurrencyObj->currency_precision);
			$smarty->assign('Object', $L);

			$ProductPriceLevelListXML = $ProductPriceLevelListXML . $smarty->fetch('api/object_info/PRODUCT_PRICE_LEVEL.tpl');
		}
		return $ProductPriceLevelListXML;
	}

	public static function EmptyAllProductPriceLevelEX($ObjectID) {
		$query =	"	DELETE FROM 	product_price_level " .
					"	WHERE			product_id	= '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function TouchProductData($ProductID, $LanguageID) {
		$query =	"	INSERT INTO product_data " .
					"	SET		product_id	= '" . intval($ProductID) . "', " .
					"			language_id = '" . intval($LanguageID) . "'" .
					"	ON DUPLICATE KEY UPDATE product_id = '" . intval($ProductID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function TouchProductBrandData($ProductBrandID, $LanguageID) {
		$query =	"	INSERT INTO product_brand_data " .
					"	SET		product_brand_id	= '" . intval($ProductBrandID) . "', " .
					"			language_id			= '" . intval($LanguageID) . "'" .
					"	ON DUPLICATE KEY UPDATE product_brand_id = '" . intval($ProductBrandID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetColorList($LanguageID, $IncludeOtherColor = 'Y') {
		$sql = '';
		if ($IncludeOtherColor != 'Y')
			$sql = " AND color_id != 1 ";

		$query =	"	SELECT	* " .
					"	FROM	color " .
					"	WHERE	language_id = '" . intval($LanguageID) . "'" . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Colors = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($Colors, $myResult);
		}
		return $Colors;
	}

	public static function GetProductCatSpecialList($SiteID, $LanguageID) {
		$query =	"	SELECT	*, PCS.* " .
					"	FROM	object O	JOIN 		object_link OL ON (OL.object_id = O.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN 		product_category_special PCS ON (PCS.product_category_special_id = O.object_id) " .
					"						LEFT JOIN	product_category_special_data PCSD ON (PCSD.product_category_special_id = PCS.product_category_special_id AND PCSD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	O.object_type = 'PRODUCT_SPECIAL_CATEGORY' AND O.site_id = '" . intval($SiteID) . "'" .
					"	ORDER BY OL.order_id ASC ";
//						"	ORDER BY PCS.product_category_special_no ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductCatSpecialList = array();
		while ($myResult = $result->fetch_assoc()) {
			$ProductCatSpecialList[$myResult['product_category_special_no']] = $myResult;
		}
		return $ProductCatSpecialList;
	}

	public static function GetProductCatList($SiteID, $LanguageID) {
		$query =	"	SELECT	*, PC.* " .
					"	FROM	object O	JOIN 		object_link OL ON (OL.object_id = O.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN 		product_category PC ON (PC.product_category_id = O.object_id) " .
					"						LEFT JOIN	product_category_data PCD ON (PCD.product_category_id = PC.product_category_id AND PCD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	O.object_type = 'PRODUCT_CATEGORY' " .
					"		AND O.site_id = '" . intval($SiteID) . "'" . 
					"	ORDER BY PC.product_category_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductCatList = array();
		while ($myResult = $result->fetch_assoc()) {
			$ProductCatList[$myResult['product_category_id']] = $myResult;
		}
		return $ProductCatList;
	}

	public static function GetProductCatInfo($ObjectID, $LanguageID) {
		$query =	"	SELECT	*, CD.*, C.* " .
					"	FROM	object_link OL	JOIN		object CO					ON (OL.object_id = CO.object_id AND OL.object_link_is_shadow = 'N') " .
					"							JOIN		product_category C			ON (C.product_category_id = CO.object_id) " .
					"							LEFT JOIN	product_category_data CD	ON (C.product_category_id = CD.product_category_id AND CD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	OL.object_id	= '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetProductCatPriceRange($ProductCatID, $CurrencyObj = null, $Site = null) {
		if ($Site == null) {
			//This is not what I want to maintain but for safety
			$ProductCat = product::GetProductCatInfo($ProductCatID, 0);
			$Site = site::GetSiteInfo($ProductCat['site_id']);
		}			

		$EffectiveCurrencyID = 0;			
		if ($Site['site_product_price_indepedent_currency'] == 'Y')
			$EffectiveCurrencyID = $CurrencyObj->currency_id;

		$query =	"	SELECT	* " .
					"	FROM	product_category_price_range " .
					"	WHERE	product_category_id = '" . intval($ProductCatID) . "'" .
					"		AND	currency_id = '" . intval($EffectiveCurrencyID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();				

			for ($i = 1; $i <= 9; $i++) {
				$myResult['product_category_price' . $i . '_ca_range_min'] = round($myResult['product_category_price' . $i . '_range_min'] * $CurrencyObj->currency_site_rate, $CurrencyObj->currency_precision);
				$myResult['product_category_price' . $i . '_ca_range_max'] = round($myResult['product_category_price' . $i . '_range_max'] * $CurrencyObj->currency_site_rate, $CurrencyObj->currency_precision);
			}
			return $myResult;
		}
		else
			return null;
	}
	
	public static function GetProductCatPriceRangeList($ProductCatID, $Site) {
		$CurrencyList = array();
		if ($Site['site_product_price_indepedent_currency'] == 'N') {
			$Currency = array();
			$Currency['currency_id'] = 0;
			array_push($CurrencyList, $Currency);
		}
		else {
			$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);
		}
		foreach ($CurrencyList as &$C) {
			$CurrencyObj = (object) $C;
			$priceRange = product::GetProductCatPriceRange($ProductCatID, $CurrencyObj, $Site);
			if ($priceRange != null)
				$C = array_merge($C, $priceRange);
		}
		return $CurrencyList;
	}

	public static function GetProductCatSpecialInfo($ObjectID, $LanguageID) {
		$query =	"	SELECT	*, C.* " .
					"	FROM	object_link OL	JOIN		object CO							ON (OL.object_id = CO.object_id AND OL.object_link_is_shadow = 'N') " .
					"							JOIN		product_category_special	C		ON (C.product_category_special_id = CO.object_id) " .
					"							LEFT JOIN	product_category_special_data CD	ON (C.product_category_special_id = CD.product_category_special_id AND CD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	OL.object_id	= '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function TouchProductCatData($ProductCatID, $LanguageID) {
		$query =	"	INSERT INTO product_category_data " .
					"	SET		product_category_id	= '" . intval($ProductCatID) . "', " .
					"			language_id = '" . intval($LanguageID) . "'" .
					"	ON DUPLICATE KEY UPDATE product_category_id = '" . intval($ProductCatID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function TouchProductCatSpecialData($ProductCatSpecialID, $LanguageID) {
		$query =	"	INSERT INTO product_category_special_data " .
					"	SET		product_category_special_id	= '" . intval($ProductCatSpecialID) . "', " .
					"			language_id = '" . intval($LanguageID) . "'" .
					"	ON DUPLICATE KEY UPDATE product_category_special_id = '" . intval($ProductCatSpecialID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function IsProductCatRemovable($ObjectID) {
		$query =	"	SELECT	* " .
					"	FROM 	object_link " .
					"	WHERE	parent_object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return false;
		else
			return true;
	}

	public static function IsProductRemovable($ObjectID) {
		$query =	"	SELECT	* " .
					"	FROM 	myorder_product " .
					"	WHERE	product_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return false;
		else
			return true;
	}

	public static function GetProductListByBrandID($BrandID, $LanguageID, &$TotalProducts, $PageNo = 1, $ProductsPerPage = 20, $ProductCatID = 0) {
		$Offset = intval(($PageNo -1) * $ProductsPerPage);

		$sql = '';
		if ($ProductCatID != 0)
			$sql = " AND PO.object_id = '" . intval($ProductCatID) . "'";

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, PCOL.object_name AS parent_object_ref_name, PBOL.object_link_id AS product_brand_object_link_id, OL.*, O.*, P.*, PB.* " .
					"	FROM	object O	JOIN		product P				ON	(P.product_id = O.object_id) " .
					"						JOIN		object_link PBOL		ON	(O.object_id = PBOL.object_id AND PBOL.parent_object_id	= '" . intval($BrandID) . "'  AND PBOL.object_link_is_shadow = 'N') " .
					"						JOIN		product_brand PB		ON	(PB.product_brand_id = PBOL.parent_object_id ) " .
					"						JOIN		object_link OL			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN		object PO				ON	(OL.parent_object_id = PO.object_id) " .
					"						JOIN		object_link PCOL		ON	(PCOL.object_id = PO.object_id AND PCOL.object_link_is_shadow = 'N') " .
					"						JOIN		object PPO				ON	(PPO.object_id = PCOL.parent_object_id) " .
					"						LEFT JOIN	product_category PC		ON	(OL.parent_object_id = PC.product_category_id) " .
					"						LEFT JOIN	product_brand_data PBD	ON	(PB.product_brand_id = PBD.product_brand_id	AND PBD.language_id = '" . intval($LanguageID) . "') " .
					"						LEFT JOIN	product_data PD			ON	(P.product_id = PD.product_id AND PD.language_id = '" . intval($LanguageID) . "') " .
					"						LEFT JOIN	color C					ON	(C.color_id = P.product_color_id AND C.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	(PO.object_type = 'PRODUCT_CATEGORY' OR (PO.object_type = 'PRODUCT_ROOT' AND PPO.object_type = 'LIBRARY_ROOT')) " . $sql .
					"	GROUP BY P.product_id " .
					"	ORDER BY PBOL.order_id ASC " .
					"	LIMIT	" . $Offset . ", " . intval($ProductsPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalProducts = $myResult[0];

		$ProductList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ProductList, $myResult);
		}
		return $ProductList;
	}

	public static function GetProductCatListXMLByProductBrandID($ProductBrandID, $LanguageID, $SecurityLevel = 0) {
		$smarty = new mySmarty();

		$query =	"	SELECT	*, CD.*, CO.*, OL.*, C.* " .
					"	FROM	object O	JOIN		product P					ON	(P.product_id = O.object_id AND O.object_security_level <= '" . intval($SecurityLevel) . "' AND P.product_brand_id = '" . intval($ProductBrandID) . "') " .
					"						JOIN		object_link OL				ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN		product_category C			ON	(OL.parent_object_id = C.product_category_id) " .
					"						JOIN		object CO					ON	(CO.object_id = C.product_category_id AND CO.object_security_level <= '" . intval($SecurityLevel) . "')" .
					"						LEFT JOIN	product_category_data CD	ON	(C.product_category_id = CD.product_category_id	AND CD.language_id = '" . intval($LanguageID) . "') ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductCategoryListXML = '';
		while ($myResult = $result->fetch_assoc()) {
			$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $LanguageID, null);
			$smarty->assign('Object', $myResult);
			$ProductCategoryListXML .= $smarty->fetch('api/object_info/PRODUCT_CATEGORY.tpl');
		}
		return "<product_category_list>" . $ProductCategoryListXML . "</product_category_list>";

	}

	public static function IsProductUnderProductCategory($ProductID, $ProductCatID, $IncludeSubCat = 'N', $ProductCatSecurityLevel = 0, $HonorArchiveDate = false, $HonorPublishDate = false) {
		$ProductCatList = array();
		$ProductCat = object::GetObjectInfo($ProductCatID);

		if ($IncludeSubCat == 'Y') {
			$TargetObjList = array('PRODUCT_CATEGORY');
			$ValidObjList = array('PRODUCT_CATEGORY', 'PRODUCT_ROOT', 'PRODUCT_ROOT_LINK');
			$ProductCatList = site::GetAllSubChildObjects($TargetObjList, $ValidObjList, $ProductCat, 0, $ProductCatSecurityLevel, 999999, $HonorArchiveDate, $HonorPublishDate, 'Y', 'N', 'Y');
		}
		array_push($ProductCatList, $ProductCat);

		if (count($ProductCatList) <= 0)
			return false;

		$sql = '';
		foreach ($ProductCatList as $C)
			$sql = $sql . " C.product_category_id = '" . $C['object_id'] . "' OR ";
		if (strlen($sql) > 0)
			$sql = "AND ( " . substr($sql, 0, -3) . ")";
		else
			return false;

		// NO NEED TO IGNORE SHADOW PRODUCT HERE!
		// This is where shadow product should take charge!
		$query =	"	SELECT	* " .
					"	FROM	object O	JOIN		product P					ON	(P.product_id = O.object_id) " .
					"						JOIN		object_link OL				ON	(O.object_id = OL.object_id) " .
					"						JOIN		product_category C			ON	(OL.parent_object_id = C.product_category_id) " .
					"						JOIN		object CO					ON	(CO.object_id = C.product_category_id AND CO.object_security_level <= '" . intval($ProductCatSecurityLevel) . "')" .
					"	WHERE	P.product_id = '" . intval($ProductID) . "'" . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return true;
		else
			return false;
	}

	public static function GetProductSubCatXMLByProductCatID($ProductCatID, $LanguageID, $SecurityLevel, $MaxDepth) {
		$smarty = new mySmarty();
		$TargetObjList = array('PRODUCT_CATEGORY');
		$ValidObjList = array('PRODUCT_CATEGORY', 'PRODUCT_ROOT', 'PRODUCT_ROOT_LINK');
		$ProductCat = object::GetObjectInfo($ProductCatID);
		$ProductCatList = site::GetAllSubChildObjects($TargetObjList, $ValidObjList, $ProductCat, 0, $SecurityLevel, $MaxDepth, true, true, 'Y', 'N');

		$ProductCatListXML = '';
		if (count($ProductCatList) > 0) {
			foreach ($ProductCatList as $C) {
				$ProductCat = product::GetProductCatInfo($C['object_id'], $LanguageID);

				if (product::IsProductCatAProductGroup($ProductCat))
					continue;

				$ProductCat['object_seo_url'] = object::GetSeoURL($ProductCat, '', $LanguageID, null);
				$smarty->assign('Object', $ProductCat);
				$ProductCatXML = $smarty->fetch('api/object_info/PRODUCT_CATEGORY.tpl');
				$ProductCatListXML .= $ProductCatXML;
			}
		}

		return "<product_category_list>" . $ProductCatListXML . "</product_category_list>";
	}

	public static function GetProductListXMLByProductBrandID($ProductBrandID, $ProductCatID, $LanguageID, $SecurityLevel, &$TotalProducts, $PageNo = 1, $ProductsPerPage = 20, $CurrenyObj = null, $Site = null) {
		$smarty = new mySmarty();

		$Products = product::GetProductListByBrandID($ProductBrandID, $LanguageID, $TotalProducts, $PageNo, $ProductsPerPage, $ProductCatID);

		$ProductListXML = '';
		foreach ($Products as $P) {
			$ProductListXML .= product::GetProductXML($P['object_link_id'], $LanguageID, false, 1, 999999, 999999, false, 1, 999999, true, null, $CurrenyObj, $Site);
		}
		return $ProductListXML;
	}

	public static function GetProductBrandXML($ProductBrandID, $LanguageID, $Site) {
		$smarty = new mySmarty();
		$ProductBrand = product::GetProductBrandInfo($ProductBrandID, $LanguageID);
		
		$ProductBrand['object_seo_url'] = object::GetSeoURL($ProductBrand, '', $LanguageID, $Site);
		$smarty->assign('Object', $ProductBrand);
		return $smarty->fetch('api/object_info/PRODUCT_BRAND.tpl');
	}
	
	public static function GetAllProductBrandXML($SiteID, $LanguageID) {
		$smarty = new mySmarty();

		$query =	"	SELECT	*, B.* " .
					"	FROM	object_link OL	JOIN		object BO				ON (OL.object_id = BO.object_id AND OL.object_link_is_shadow = 'N') " .
					"							JOIN		product_brand B			ON (B.product_brand_id = BO.object_id) " .
					"							LEFT JOIN	product_brand_data BD	ON (B.product_brand_id = BD.product_brand_id AND BD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	BO.site_id	= '" . intval($SiteID) . "'" .
					"	ORDER BY OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductBrandListXML = '';
		while ($myResult = $result->fetch_assoc()) {
			$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $LanguageID, null);
			$smarty->assign('Object', $myResult);
			$ProductBrandListXML .= $smarty->fetch('api/object_info/PRODUCT_BRAND.tpl');
		}
		return '<product_brand_list>' . $ProductBrandListXML . '</product_brand_list>';
	}

	public static function GetProductBrandListXMLByProductCatID($Site, $ProductCatID, $LanguageID, $SecurityLevel = 0, $IncludeSubCat = 'N') {
		$smarty = new mySmarty();

		$sql = '';

		if ($IncludeSubCat == 'Y') {
			$TargetObjList = array('PRODUCT_CATEGORY');
			$ValidObjList = array('PRODUCT_CATEGORY', 'PRODUCT_ROOT', 'PRODUCT_ROOT_LINK');
			$ProductCat = object::GetObjectInfo($ProductCatID);
			$ProductCatList = site::GetAllSubChildObjects($TargetObjList, $ValidObjList, $ProductCat, 0, $SecurityLevel, 99999, true, true, 'Y', 'N');

			if (count($ProductCatList) > 0) {
				foreach ($ProductCatList as $C) {
					$sql = $sql . " OR OL.parent_object_id = '" . $C['object_id'] . "'";
				}
			}
		}

		$query =	"	SELECT	*, PBD.*, PB.*, PBO.*, PBOL.* " .
					"	FROM	object O	JOIN		product P				ON	(P.product_id = O.object_id AND O.object_security_level <= '" . intval($SecurityLevel) . "') " .
					"						JOIN		product_brand PB		ON	(PB.product_brand_id = P.product_brand_id ) " .
					"						JOIN		object PBO				ON	(PB.product_brand_id = PBO.object_id AND PBO.object_security_level <= '" . intval($SecurityLevel) . "') " .
					"						JOIN		object_link PBOL		ON	(PB.product_brand_id = PBOL.object_id AND PBOL.parent_object_id	= '" . $Site['site_product_brand_root_id'] . "' AND PBOL.object_link_is_shadow = 'N') " .
					"						JOIN		object_link OL			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						LEFT JOIN	product_brand_data PBD	ON	(PB.product_brand_id = PBD.product_brand_id	AND PBD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	OL.parent_object_id = '" . intval($ProductCatID) . "'" . $sql .
					"	GROUP BY PB.product_brand_id " .
					"	ORDER BY PBOL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductBrandListXML = '';
		while ($myResult = $result->fetch_assoc()) {
			$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $LanguageID, $Site);
			$smarty->assign('Object', $myResult);
			$ProductBrandListXML .= $smarty->fetch('api/object_info/PRODUCT_BRAND.tpl');
		}
		return "<product_brand_list>" . $ProductBrandListXML . "</product_brand_list>";
	}

	public static function DeleteProductBrand($ProductBrandID, $Site) {
		$ProductBrand = product::GetProductBrandInfo($ProductBrandID, 0);

		$TotalProducts = 0;
		$ProductList = product::GetProductListByBrandID($ProductBrandID, 0, $TotalProducts, 1, 999999);

		foreach ($ProductList as $P) {
			$query =	"	UPDATE	product " .
						"	SET		product_brand_id = 0 " .
						"	WHERE	product_id = '" . $P['product_id'] . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		if ($ProductBrand['object_thumbnail_file_id'] != 0)
			filebase::DeleteFile($ProductBrand['object_thumbnail_file_id'], $Site);

		$query =	"	DELETE FROM	product_brand_data " .
					"	WHERE	product_brand_id = '" . intval($ProductBrandID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	product_brand " .
					"	WHERE	product_brand_id = '" . intval($ProductBrandID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id = '" . intval($ProductBrandID) . "'" .
					"			OR	object_id = '" . intval($ProductBrandID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		Object::TidyUpObjectOrder($Site['site_product_brand_root_id']);
	}


	public static function DeleteProduct($ObjectID, $Site, $CurrencyList = null) {
		if (!product::IsProductRemovable($ObjectID))
			return false;

		$Product = product::GetProductInfo($ObjectID, 0);
		$TotalMedia = 0;
		$TotalDatafile = 0;
		$MediaList = media::GetMediaList($ObjectID, 0, $TotalMedia, 1, 999999);
		$DatafileList = datafile::GetDatafileList($ObjectID, 0, $TotalDatafile, 1, 999999);
		$ProductOptionList = product::GetProductOptionList($ObjectID, 'all');

		$query =	"	DELETE FROM	cart_content " .
					"	WHERE		product_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Delete Product
		$query =	"	DELETE FROM	product " .
					"	WHERE	product_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	product_data " .
					"	WHERE	product_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	product_price_level " .
					"	WHERE	product_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	product_price " .
					"	WHERE	product_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

//			if ($Product['object_thumbnail_file_id'] != 0)
//				filebase::DeleteFile($Product['object_thumbnail_file_id'], $Site);

		foreach($ProductOptionList as $PO)
			product::DeleteProductOption ($PO['product_option_id']);			
		foreach ($MediaList as $M)
			media::DeleteMedia($M['object_id'], $Site, true);
		foreach ($DatafileList as $D)
			datafile::DeleteDatafile($D['object_id'], $Site, true);

		object::DeleteObject($ObjectID);

		// Delete all object links
		$query =	"	SELECT	* " .
					"	FROM	object_link " .
					"	WHERE	object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$ParentIDs = array();
		while ($myResult = $result->fetch_assoc())
			array_push($ParentIDs, $myResult['parent_object_id']);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id = '" . intval($ObjectID) . "'" .
					"			OR	object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ObjTypeArray = array("PRODUCT", "PRODUCT_CATEGORY");

		$SiteLanguageRoots = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');

		foreach ($ParentIDs as $ID) {
			object::TidyUpObjectOrder($ID, $ObjTypeArray);

			$ParentObj = object::GetObjectInfo($ID);

			if ($ParentObj['object_type'] == 'PRODUCT_CATEGORY')
				product::UpdateProductCategoryPreCalData($ID, $SiteLanguageRoots, $Site, $CurrencyList);
		}
	}

	public static function EmptyProductMedia($ObjectID, $Site) {
		$TotalMedia = 0;
		$MediaList = media::GetMediaList($ObjectID, 0, $TotalMedia, 1, 999999, 999999, false, false);
		foreach ($MediaList as $M)
			media::DeleteMedia($M['object_id'], $Site, true);
		object::TidyUpObjectOrder($ObjectID);
	}

	public static function DeleteProductCat($ObjectID) {
		product::ProductGroupRemoveShadowProduct($ObjectID);

		$query =	"	DELETE FROM	product_category " .
					"	WHERE	product_category_id	= '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	product_category_data " .
					"	WHERE	product_category_id	= '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	product_category_price_range " .
					"	WHERE	product_category_id	= '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($ObjectID);

		// Delete all object links
		$query =	"	SELECT	* " .
					"	FROM	object_link " .
					"	WHERE	object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$ParentIDs = array();
		while ($myResult = $result->fetch_assoc())
			array_push($ParentIDs, $myResult['parent_object_id']);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id = '" . intval($ObjectID) . "'" .
					"			OR	object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		foreach ($ParentIDs as $ID)
			object::TidyUpObjectOrder($ID);
	}

	public static function GetProductPriceListXML($ProductID, $CurrencyObj = null, $Site = null) {
		$smarty = new mySmarty();

		if ($Site == null) {
			//This is not what I want to maintain but for safety
			$Product = product::GetProductInfo($ProductID, 0);
			$Site = site::GetSiteInfo($Product['site_id']);
		}

		$EffectiveCurrencyID = 0;
		if ($Site['site_product_price_indepedent_currency'] == 'Y')
			$EffectiveCurrencyID = intval($CurrencyObj->currency_id);

		$query =	"	SELECT	* " .
					"	FROM	product_price " .
					"	WHERE	product_id = '" . intval($ProductID) . "'" . 
					"		AND	currency_id = '" . intval($EffectiveCurrencyID) . "'" .
					"	ORDER BY product_price_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductPriceListXML = '';
		while ($myResult = $result->fetch_assoc()) {
			$ProductPriceLevelListXML = '';
			if (intval($myResult['discount_type']) == 4) {
				$ProductPriceLevelListXML = product::GetProductPriceLevelListXML($myResult['product_id'], $myResult['product_price_id'], $CurrencyObj, $Site);
			}				
			$myResult['product_price_ca'] = round($myResult['product_price'] * $CurrencyObj->currency_site_rate, $CurrencyObj->currency_precision);
			$myResult['discount2_price_ca'] = round($myResult['discount2_price'] * $CurrencyObj->currency_site_rate, $CurrencyObj->currency_precision);
			$smarty->assign('ProductPriceLevelListXML', $ProductPriceLevelListXML);
			$smarty->assign('Object', $myResult);

			$ProductPriceListXML .= $smarty->fetch('api/object_info/PRODUCT_PRICE.tpl');
		}

		return $ProductPriceListXML;
	}

	public static function GetProductXML($ObjectLinkID, $LanguageID, $ReturnMediaListXML = false, $MediaPageNo = 1, $MediaPerPage = 999999, $SecurityLevel = 999999, $ReturnDatafileListXML = false, $DatafilePageNo = 1, $DatafilePerPage = 999999, $XmlIncludeRootTag = true, $OverrideBonusPointAmountValue = null, $CurrencyObj = null, $Site = null, $UpdateDiscountBundleRuleProductLink = false, $BundleRuleList = null, $PreprocessRuleList = null, $IncludeProductBrandDetails = 'N') {

		$smarty = new mySmarty();
		$Product = product::GetProductInfoByObjLinkID($ObjectLinkID, $LanguageID);
		if ($Product != null) {
			if ($UpdateDiscountBundleRuleProductLink) {
				discount::updateDiscountBundleRuleProductLink($Product['site_id'], $Product, $BundleRuleList);
			}

			if ($OverrideBonusPointAmountValue !== null)
				$Product['product_bonus_point_amount'] = intval($OverrideBonusPointAmountValue);

			if ($ReturnMediaListXML) {
				$TotalNoOfMedia = 0;

				$MediaListXML = media::GetMediaListXML($Product['product_id'], $LanguageID, $TotalNoOfMedia, $MediaPageNo, $MediaPerPage, $SecurityLevel);
				$smarty->assign('MediaListXML', $MediaListXML);
				$smarty->assign('TotalNoOfMedia', $TotalNoOfMedia);
				$smarty->assign('MediaPageNo', $MediaPageNo);
			}

			if ($ReturnDatafileListXML) {
				$TotalNoOfDatafile = 0;

				$DatafileListXML = datafile::GetDatafileListXML($Product['product_id'], $LanguageID, $TotalNoOfDatafile, $DatafilePageNo, $DatafilePerPage, $SecurityLevel);
				$smarty->assign('DatafileListXML', $DatafileListXML);
				$smarty->assign('TotalNoOfDatafile', $TotalNoOfDatafile);
				$smarty->assign('DatafilePageNo', $DatafilePageNo);
			}

			$ProductOptionListXML = product::GetProductOptionListXML($Product['product_id'], $LanguageID);
			$smarty->assign('ProductOptionListXML', $ProductOptionListXML);

			$ProductPriceListXML = product::GetProductPriceListXML($Product['product_id'], $CurrencyObj, $Site);
			$smarty->assign('ProductPriceListXML', $ProductPriceListXML);

			if (intval($Product['discount_type']) == 4) {
				$ProductPriceLevelListXML = product::GetProductPriceLevelListXML($Product['product_id'], 1, $CurrencyObj, $Site);
				$smarty->assign('ProductPriceLevelListXML', $ProductPriceLevelListXML);
			}

			if ($Product['object_type'] == 'PRODUCT_CATEGORY') { // This is a Product Group Shadow!
				$ProductCatGroup = product::GetProductCatInfo($Product['product_id'], $LanguageID);
				$Product['product_category_price1_range_min'] = $ProductCatGroup['product_category_price1_range_min'];
				$Product['product_category_price1_range_max'] = $ProductCatGroup['product_category_price1_range_max'];
				$Product['product_category_price2_range_min'] = $ProductCatGroup['product_category_price2_range_min'];
				$Product['product_category_price2_range_max'] = $ProductCatGroup['product_category_price2_range_max'];
				$Product['product_category_price3_range_min'] = $ProductCatGroup['product_category_price3_range_min'];
				$Product['product_category_price3_range_max'] = $ProductCatGroup['product_category_price3_range_max'];
			}

			$BundleRuleListXML = discount::GetBundleDiscountRuleListXMLByProductID($Product['product_id'], $LanguageID, $SecurityLevel, $CurrencyObj, $Site);
			$smarty->assign('BundleRuleListXML', $BundleRuleListXML);

			if ($IncludeProductBrandDetails == 'Y') {
				$ProductBrandXML = product::GetProductBrandXML($Product['product_brand_id'], $LanguageID, $Site);
				$smarty->assign('ProductBrandXML', $ProductBrandXML);
			}
			
			$Product['object_seo_url'] = object::GetSeoURL($Product, '', $LanguageID, null);
			$smarty->assign('Object', $Product);
			$ProductXML = $smarty->fetch('api/object_info/PRODUCT.tpl');

			if ($XmlIncludeRootTag)
				return "<product>" . $ProductXML . "</product>";
			else
				return $ProductXML;
		}
		return '';
	}

	public static function GetProductsXML($ParentObjectID, $LanguageID, $SecurityLevel, $Tag, $PageNo = 1, $ProductsPerPage = 20, $OrderByField = 'OL.order_id ASC', $IncludeProductDetails = 'N', &$NoOfProducts, $ReturnXMLAsStringOrArray = 'string', $ProductMediaPageNo = 1, $ProductMediaPerPage = 99999, $IncludeDatafileDetails = 'N', $DatafilePageNo = 1, $DatafilePerPage = 99999, $CurrencyObj = null, $Site = null, $IncludeProductBrandDetails = 'N') {
		$smarty = new mySmarty();

		$Offset = intval(($PageNo -1) * $ProductsPerPage);

		$tag_sql = '';
		if (strlen(trim($Tag)) > 0)
			$tag_sql = " AND D.product_tag  LIKE '%, " . aveEscT($Tag) . ",%'";

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, O.*, D.*, P.*, OL.* " .
					"	FROM	object_link	OL	JOIN		object O		ON (O.object_id = OL.object_id AND OL.parent_object_id = '" . intval($ParentObjectID) . "')" .
					"							JOIN		product P		ON (P.product_id = O.object_id) " .
					"							LEFT JOIN	product_data D	ON (P.product_id = D.product_id AND D.language_id = '" . intval($LanguageID) . "')" .
					"	WHERE	O.object_is_enable = 'Y' " .
					"		AND OL.object_link_is_enable = 'Y' " . $tag_sql .
					"		AND	O.object_security_level <= '" . intval($SecurityLevel) . "'" .
					"	GROUP BY OL.shadow_parent_id " .
					"	ORDER BY " . $OrderByField .
					"	LIMIT	" . $Offset . ", " . intval($ProductsPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result2->fetch_row();
		$NoOfProducts = $myResult[0];

		$smarty->assign('PageNo', $PageNo);
		$smarty->assign('ProductsPerPage', $ProductsPerPage);

		$ProductsXML = '';
		$XMLArray = array();

		while ($myResult = $result->fetch_assoc()) {
			if ($myResult['object_link_is_shadow'] == 'Y') {
				// This is product group
				$ProductCatGroup = product::GetProductCatInfo($myResult['shadow_parent_id'], $LanguageID);
				$ProductCatGroup['product_name'] = $ProductCatGroup['product_category_name'];
				$myResult['object_seo_url'] = object::GetSeoURL($ProductCatGroup, '', $LanguageID, null);
				$smarty->assign('Object', $ProductCatGroup);
				
				$ProductCatPriceRange = product::GetProductCatPriceRange($myResult['shadow_parent_id'], $CurrencyObj, $Site);
				$smarty->assign('ProductCatPriceRange', $ProductCatPriceRange);
				
				$ProductXML = $smarty->fetch('api/object_info/PRODUCT_GROUP.tpl');
			}
			else {
				// This is real product
				$ProductOptionListXML = product::GetProductOptionListXML($myResult['product_id'], $LanguageID);
				$smarty->assign('ProductOptionListXML', $ProductOptionListXML);

				$ProductPriceListXML = product::GetProductPriceListXML($myResult['product_id'], $CurrencyObj, $Site);
				$smarty->assign('ProductPriceListXML', $ProductPriceListXML);					

				if (intval($myResult['discount_type']) == 4) {
					$ProductPriceLevelListXML = product::GetProductPriceLevelListXML($myResult['product_id'], 1, $CurrencyObj, $Site);
					$smarty->assign('ProductPriceLevelListXML', $ProductPriceLevelListXML);
				}
				else
					$smarty->assign('ProductPriceLevelListXML', '');					

				if ($IncludeProductDetails == 'Y') {
					$TotalNoOfMedia = 0;

					$MediaListXML = media::GetMediaListXML($myResult['product_id'], $LanguageID, $TotalNoOfMedia, $ProductMediaPageNo, $ProductMediaPerPage);
					$smarty->assign('MediaListXML', $MediaListXML);
					$smarty->assign('TotalNoOfMedia', $TotalNoOfMedia);
					$smarty->assign('MediaPageNo', $MediaPageNo);
				}

				if ($IncludeDatafileDetails == 'Y') {
					$TotalNoOfDatafile = 0;

					$DatafileListXML = datafile::GetDatafileListXML($myResult['product_id'], $LanguageID, $TotalNoOfDatafile, $DatafilePageNo, $DatafilePerPage, $SecurityLevel);
					$smarty->assign('DatafileListXML', $DatafileListXML);
					$smarty->assign('TotalNoOfDatafile', $TotalNoOfDatafile);
					$smarty->assign('DatafilePageNo', $DatafilePageNo);
				}
				
				if ($IncludeProductBrandDetails == 'Y') {
					$ProductBrandXML = product::GetProductBrandXML($myResult['product_brand_id'], $LanguageID, $Site);
					$smarty->assign('ProductBrandXML', $ProductBrandXML);
				}
				
				$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $LanguageID, null);
				$smarty->assign('Object', $myResult);
				$ProductXML = "<product>" . $smarty->fetch('api/object_info/PRODUCT.tpl') . "</product>";					
			}

			if ($ReturnXMLAsStringOrArray == 'string')
				$ProductsXML .= $ProductXML;
			elseif ($ReturnXMLAsStringOrArray == 'array')
				$XMLArray[intval($myResult['order_id'])] = $ProductXML;
		}
		if ($ReturnXMLAsStringOrArray == 'string')
			return $ProductsXML;
		elseif ($ReturnXMLAsStringOrArray == 'array')
			return $XMLArray;
	}

	public static function GetProductCategoryTreeXML($CurrentObject, $LanguageID, $SecurityLevel, $Tag, $PageNo = 1, $ObjectsPerPage = 20, $CategoryOrderByField = 'OL.order_id ASC', $ProductOrderByField = 'OL.order_id ASC', $IncludeProductDetails = 'N', $IncludeMediaList = 'N', $MediaPageNo = 1, $MediaPerPage = 999999, $CurrentDepth = 0, $MaxDepth = 1, $ExcludeAllProducts = 'N', $CurrencyObj = null, $Site = null) {
		$smarty = new mySmarty();
		
		if ($CurrentDepth > $MaxDepth)
			return;

		$ParentObjID = $CurrentObject['object_id'];
		if ($CurrentObject['object_type'] == 'PRODUCT_ROOT_LINK')
			$ParentObjID = $CurrentObject['product_root_id'];

		$TotalNoOfMedia = 0;
		$MediaListXML = '';
		if ($IncludeMediaList == 'Y') {
			$MediaListXML = media::GetMediaListXML($ParentObjID, $LanguageID, $TotalNoOfMedia, $MediaPageNo, $MediaPerPage, $SecurityLevel);
		}

		$ObjectsXMLArray = array();

		$NoOfProducts = 0;
		if ($ExcludeAllProducts != 'Y') {
			if ($ObjectsPerPage > 0) {
				$ObjectsXMLArray = product::GetProductsXML($ParentObjID, $LanguageID, $SecurityLevel, $Tag, 1, 999999, $ProductOrderByField, $IncludeProductDetails, $NoOfProducts, 'array', 1, 999999, 'N', 1, 999999, $CurrencyObj, $Site);
			}
		}

		$sql_cat_join = '';
		if ($CurrentObject['object_type'] == 'PRODUCT_SPECIAL_CATEGORY') {
			$sql_cat_join = "							JOIN		product_category_special C	ON (C.product_category_special_id = O.object_id) " .
							"							LEFT JOIN	product_category_special_data D	ON (C.product_category_special_id = D.product_category_special_id AND D.language_id = '" . intval($LanguageID) . "')";
		}
		else {
			$sql_cat_join = "							JOIN		product_category C	ON (C.product_category_id = O.object_id AND C.product_category_is_product_group = 'N') " .
							"							LEFT JOIN	product_category_data D	ON (C.product_category_id = D.product_category_id AND D.language_id = '" . intval($LanguageID) . "')";
		}
		// Product Cat now
		$query =	"	SELECT	*, C.* " .
					"	FROM	object_link	OL	JOIN		object O			ON (O.object_id = OL.object_id AND OL.parent_object_id = '" . intval($ParentObjID) . "' AND OL.object_link_is_shadow = 'N')" . $sql_cat_join .
					"	WHERE	O.object_is_enable = 'Y' " .
					"		AND	O.object_archive_date > NOW() " .
					"		AND	O.object_publish_date < NOW() " .
					"		AND OL.object_link_is_enable = 'Y' " .
					"		AND	O.object_security_level <= '" . intval($SecurityLevel) . "'" .					
					"	ORDER BY " . $CategoryOrderByField;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		while ($myResult = $result->fetch_assoc()) {
			$ObjectsXMLArray[intval($myResult['order_id'])] = product::GetProductCategoryTreeXML($myResult, $LanguageID, $SecurityLevel, $Tag, $PageNo, $ObjectsPerPage, $CategoryOrderByField, $ProductOrderByField, $IncludeProductDetails, $IncludeMediaList, $MediaPageNo, $MediaPerPage, $CurrentDepth+1, $MaxDepth, $ExcludeAllProducts, $CurrencyObj, $Site);
		}

		$ObjectsXML = '';
		for ($i = ($PageNo -1) * $ObjectsPerPage + 1; $i <= $PageNo * $ObjectsPerPage; $i++) {
			$ObjectsXML .= $ObjectsXMLArray[$i];
		}
		$smarty->assign('NoOfObjects', count($ObjectsXMLArray));
		$smarty->assign('ObjectsXML', $ObjectsXML);

//			$ProductCat = product::GetProductCatInfo($ObjectID, $LanguageID);
		$CurrentObject['object_seo_url'] = object::GetSeoURL($CurrentObject, '', $LanguageID, null);
		$smarty->assign('Object', $CurrentObject);

		$smarty->assign('NoOfProducts', $NoOfProducts);
		$smarty->assign('ProductsXML', $ProductsXML);
		$smarty->assign('MediaListXML', $MediaListXML);
		$smarty->assign('TotalNoOfMedia', $TotalNoOfMedia);
		$smarty->assign('MediaPageNo', $MediaPageNo);

		$XML = '';
		if ($CurrentObject['object_type'] == 'PRODUCT_CATEGORY')
			$XML = $smarty->fetch('api/object_info/PRODUCT_CATEGORY.tpl');
		elseif ($CurrentObject['object_type'] == 'PRODUCT_SPECIAL_CATEGORY')
			$XML = $smarty->fetch('api/object_info/PRODUCT_CATEGORY.tpl');
		elseif ($CurrentObject['object_type'] == 'PRODUCT_ROOT_LINK')
			$XML = $smarty->fetch('api/object_info/PRODUCT_ROOT_LINK.tpl');
		elseif ($CurrentObject['object_type'] == 'PRODUCT_ROOT')
			$XML = $smarty->fetch('api/object_info/PRODUCT_ROOT.tpl');

		return $XML;
	}

	public static function GetProductCategoryXML($CurrentObject, $LanguageID, $SecurityLevel, $Tag, $PageNo = 1, $ProductsPerPage = 20, $CategoryOrderByField = 'OL.order_id ASC', $ProductOrderByField = 'OL.order_id ASC', $IncludeProductDetails = 'N', $IncludeMediaList = 'N', $MediaPageNo = 1, $MediaPerPage = 999999, $CurrentDepth = 0, $MaxDepth = 1, $IncludeDatafileDetails = 'N', $DatafilePageNo = 1, $DatafilePerPage = 999999, $CurrencyObj = null, $Site = null, $IncludeProductBrandDetails = 'N') {
		$smarty = new mySmarty();

		if ($CurrentDepth > $MaxDepth)
			return;

		$ParentObjID = $CurrentObject['object_id'];
		if ($CurrentObject['object_type'] == 'PRODUCT_ROOT_LINK')
			$ParentObjID = $CurrentObject['product_root_id'];

		$TotalNoOfMedia = 0;
		$MediaListXML = '';
		if ($IncludeMediaList == 'Y') {
			$MediaListXML = media::GetMediaListXML($ParentObjID, $LanguageID, $TotalNoOfMedia, $MediaPageNo, $MediaPerPage, $SecurityLevel);
		}

		$ProductsXML = '';
		$NoOfProducts = 0;
		if ($ProductsPerPage > 0) {
			$ProductsXML = product::GetProductsXML($ParentObjID, $LanguageID, $SecurityLevel, $Tag, $PageNo, $ProductsPerPage, $ProductOrderByField, $IncludeProductDetails, $NoOfProducts, 'string', $MediaPageNo, $MediaPerPage, $IncludeDatafileDetails, $DatafilePageNo, $DatafilePerPage, $CurrencyObj, $Site, $IncludeProductBrandDetails);
		}

		$sql_cat_join = '';
		if ($CurrentObject['object_type'] == 'PRODUCT_SPECIAL_CATEGORY') {
			$sql_cat_join = "							JOIN		product_category_special C	ON (C.product_category_special_id = O.object_id) " .
							"							LEFT JOIN	product_category_special_data D	ON (C.product_category_special_id = D.product_category_special_id AND D.language_id = '" . intval($LanguageID) . "')";
		}
		else {
			$sql_cat_join = "							JOIN		product_category C	ON (C.product_category_id = O.object_id AND C.product_category_is_product_group = 'N') " .
							"							LEFT JOIN	product_category_data D	ON (C.product_category_id = D.product_category_id AND D.language_id = '" . intval($LanguageID) . "')";
		}
		// Product Cat now
		$query =	"	SELECT	*, C.* " .
					"	FROM	object_link	OL	JOIN	object O	ON (O.object_id = OL.object_id AND OL.parent_object_id = '" . intval($ParentObjID) . "' AND OL.object_link_is_shadow = 'N')" . $sql_cat_join .
					"						LEFT JOIN	product P	ON (O.object_id = P.product_id) " .
					"	WHERE	O.object_is_enable = 'Y' " .
					"		AND	P.product_id IS NULL " .
					"		AND	O.object_security_level <= '" . intval($SecurityLevel) . "'" .
					"		AND	O.object_archive_date > NOW() " .
					"		AND	O.object_publish_date < NOW() " .
					"		AND OL.object_link_is_enable = 'Y' " .
					"	ORDER BY " . $CategoryOrderByField;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$ProductCategoriesXML = '';
		while ($myResult = $result->fetch_assoc()) {
			$ProductCategoriesXML = $ProductCategoriesXML . product::GetProductCategoryXML($myResult, $LanguageID, $SecurityLevel, $Tag, $PageNo, $ProductsPerPage, $CategoryOrderByField, $ProductOrderByField, $IncludeProductDetails, $IncludeMediaList, $MediaPageNo, $MediaPerPage, $CurrentDepth+1, $MaxDepth, $IncludeDatafileDetails, $DatafilePageNo, $DatafilePerPage, $CurrencyObj, $Site, $IncludeProductBrandDetails);
		}
		$smarty->assign('ProductCategoriesXML', $ProductCategoriesXML);

//			$ProductCat = product::GetProductCatInfo($ObjectID, $LanguageID);
		$CurrentObject['object_seo_url'] = object::GetSeoURL($CurrentObject, '', $LanguageID, null);
		$smarty->assign('Object', $CurrentObject);

		$smarty->assign('NoOfProducts', $NoOfProducts);
		$smarty->assign('ProductsXML', $ProductsXML);
		$smarty->assign('MediaListXML', $MediaListXML);
		$smarty->assign('TotalNoOfMedia', $TotalNoOfMedia);
		$smarty->assign('MediaPageNo', $MediaPageNo);

		$ProductCatPriceRange = product::GetProductCatPriceRange($CurrentObject['object_id'], $CurrencyObj, $Site);
		$smarty->assign('ProductCatPriceRange', $ProductCatPriceRange);

		$XML = '';
		if ($CurrentObject['object_type'] == 'PRODUCT_CATEGORY')
			$XML = $smarty->fetch('api/object_info/PRODUCT_CATEGORY.tpl');
		elseif ($CurrentObject['object_type'] == 'PRODUCT_SPECIAL_CATEGORY')
			$XML = $smarty->fetch('api/object_info/PRODUCT_CATEGORY_SPECIAL.tpl');
		elseif ($CurrentObject['object_type'] == 'PRODUCT_ROOT_LINK')
			$XML = $smarty->fetch('api/object_info/PRODUCT_ROOT_LINK.tpl');
		elseif ($CurrentObject['object_type'] == 'PRODUCT_ROOT')
			$XML = $smarty->fetch('api/object_info/PRODUCT_ROOT.tpl');

		return $XML;
	}

	public static function GetNoOfProduct($SiteID) {
		$query =	"	SELECT	COUNT(object_id) AS NoOfObjects " .
					"	FROM	object	" .
					"	WHERE	site_id		= '" . intval($SiteID) . "'" .
					"		AND	object_type	= 'PRODUCT' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result->fetch_assoc();

		return $myResult['NoOfObjects'];
	}

	public static function DeleteProductRoot($ObjectID, $Site) {
		$ValidObjectList = array('PRODUCT', 'PRODUCT_CATEGORY', 'PRODUCT_ROOT');
		$Objects = site::GetAllChildObjects($ValidObjectList, $ObjectID, 999999, 'ALL', 'ALL');

		foreach($Objects as $O) {
			if ($O['object_type'] == 'PRODUCT_CATEGORY')
				product::DeleteProductRoot($O['object_id'], $Site);
			elseif ($O['object_type'] == 'PRODUCT')
				product::DeleteProduct($O['object_id'], $Site);
		}

		$Object = object::GetObjectInfo($ObjectID);

		if ($Object['object_type'] == 'PRODUCT_CATEGORY')
			product::DeleteProductCat($ObjectID);
		elseif ($Object['object_type'] == 'PRODUCT_ROOT') {
			object::DeleteObject($ObjectID);

			$query =	"	DELETE FROM	object_link " .
						"	WHERE		parent_object_id = '" . intval($ObjectID) . "'" .
						"			OR	object_id = '" . intval($ObjectID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function DeleteProductRootLink($ObjectLinkID) {
		$ObjectLink = object::GetObjectLinkInfo($ObjectLinkID);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE	object_link_id = '" . intval($ObjectLinkID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::TidyUpObjectOrder($ObjectLink['parent_object_id']);
	}

	public static function DeleteProductRootRealLink($ObjectLinkID) {
		$ObjectLink = object::GetObjectLinkInfo($ObjectLinkID);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE	object_link_id = '" . intval($ObjectLinkID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	product_root_link " .
					"	WHERE	product_root_link_id = '" . intval($ObjectLink['object_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::TidyUpObjectOrder($ObjectLink['parent_object_id']);
	}

	public static function UpdateTimeStamp($ProductID) {
		object::UpdateObjectTimeStamp($ProductID);
	}

	public static function UpdateTimeStampProductCat($ProductCatID) {
		object::UpdateObjectTimeStamp($ProductCatID);
	}

	public static function UpdateTimeStampProductBrand($ProductBrandID) {
		object::UpdateObjectTimeStamp($ProductBrandID);
	}

	//	return TRUE if error seems temporary
	//	return FALSE if error seems fatal (e.g. Over Quota, No Site Language is enabled)
	public static function ImportProduct($Site, $ProductXML, &$NoOfProductsParsed, &$NoOfProductImported, &$NoOfProductFailed, &$SuccessXMLString, &$ErrorXMLString, $RealWrite = 'N', $NewOrUpdate = 'new', $UpdateMedia = "Y", $CurrencyList = null) {
		$smarty = new mySmarty();

		$smarty->assign('msg', '');

		$NoOfProductsParsed++;
		$smarty->assign('import_ref_id', $ProductXML->import_ref_id);

		$TheObject = null;
		if ($NewOrUpdate == 'update') {
			$TheObject = object::GetObjectsByObjectName($Site['site_id'], $ProductXML->object_name);
			if (count($TheObject) < 1) {
				$smarty->assign('msg', 'object_name (' . $ProductXML->object_name . ') - Not Found!');
				$NoOfProductFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
				return true;
			}
			if (count($TheObject) > 1) {
				$smarty->assign('msg', 'object_name (' . $ProductXML->object_name . ') - More than one objects with same object name found.');
				$NoOfProductFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
				return true;
			}
		}

		if ($Site['site_module_product_enable'] != 'Y') {
			$smarty->assign('msg', ADMIN_MSG_MODULE_DISABLED_PRODUCT);
			$NoOfProductFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
			return false;
		}

		$NoOfProducts = product::GetNoOfProduct($Site['site_id']);
		if ($NoOfProducts >= $Site['site_module_product_quota']) {
			$smarty->assign('msg', ADMIN_ERROR_PRODUCT_QUOTA_FULL);
			$NoOfProductFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
			return false;
		}

		$SiteLanguageRoots = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');
		if (count($SiteLanguageRoots) == 0) {
			$smarty->assign('msg', ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED);
			$NoOfProductFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
			return false;
		}

		if ($NewOrUpdate != 'update') {
			$ObjectLink = object::GetObjectLinkInfo($ProductXML->parent_object_link_id);
			if ($ObjectLink['site_id'] != $Site['site_id']) {
				$smarty->assign('msg', 'parent_object_link_id: this is not your object!');
				$NoOfProductFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
				return true;
			}

			if (object::ValidateCreateObjectInTree(array('PRODUCT_ROOT', 'PRODUCT_CATEGORY'), $ObjectLink, 'inside', $Site['site_id'], false) === false) {
				$smarty->assign('msg', 'parent_object_link_id: invalid parent object type');
				$NoOfProductFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
				return true;
			}				
		}

		// Product Data Checking
		$ProductDataList = $ProductXML->product_data_list;

		$NoOfValidProductData = 0;
		foreach ($SiteLanguageRoots as $R) {
			$ProductData = $ProductDataList->xpath("product_data[language_id='" . $R['language_id'] . "']");
			if (count($ProductData) > 0)
				$NoOfValidProductData++;
		}
		if (count($ProductDataList->children()) != $NoOfValidProductData) {
			if (count($ProductDataList->children()) > $NoOfValidProductData)
				$smarty->assign('msg', 'product_data: invalid language_id found (not enabled?) ');
			elseif (count($ProductDataList->children()) < $NoOfValidProductData)
				$smarty->assign('msg', 'product_data: not enough data (some language_id is enabled but not found in XML ');
			$NoOfProductFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
			return true;
		}

		//	Product Brand Checking			
		if (intval($ProductXML->product_brand_id) != 0) {
			$ProductBrand = product::GetProductBrandInfo(intval($ProductXML->product_brand_id), 0);

			if ($ProductBrand['site_id'] != $Site['site_id']) {
				$smarty->assign('msg', 'product_brand_id: Brand ID not belongs to your site');
				$NoOfProductFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
				return true;
			}
		}

		// Object Thumbnail Check
		$ObjectThumbnailInfo = array();
		if (strlen(trim($ProductXML->object_thumbnail_url)) > 0) {
			$ObjectThumbnailInfo = @getimagesize($ProductXML->object_thumbnail_url);

			if ($ObjectThumbnailInfo[0] == 0) {
				$smarty->assign('msg', 'object_thumbnail_url: cannot load image');
				$NoOfProductFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
				return true;
			}
			elseif ($ObjectThumbnailInfo[2] > 3) { // 1 = GIF, 2 = JPG, 3 = PNG
				$smarty->assign('msg', 'object_thumbnail_url: unsupported image type');
				$NoOfProductFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
				return true;
			}
		}

		// Media Checking
		$NoOfMediaParsed = 0;
		$NoOfMediaImported = 0;
		$NoOfMediaFailed = 0;
		$gSuccessMediaListXMLString = '';
		$gErrorMediaListXMLString = '';

		foreach ($ProductXML->media_list->children() as $Media) {
			$SuccessMediaListXMLString = '';
			$ErrorMediaListXMLString = '';
			$ImportResult = media::ImportMedia($Site, 0, $Media, $NoOfMediaParsed, $NoOfMediaImported, $NoOfMediaFailed, $SuccessMediaListXMLString, $ErrorMediaListXMLString, 'N');

			$gSuccessMediaListXMLString = $gSuccessMediaListXMLString . $SuccessMediaListXMLString;
			$gErrorMediaListXMLString	= $gErrorMediaListXMLString . $ErrorMediaListXMLString;

			if ($ImportResult == false)
				break;
		}

		$ProductImportMsg = '';
		if (strlen($gErrorMediaListXMLString) > 0) {
			$smarty->assign('no_of_media_parsed', $NoOfMediaParsed);
			$smarty->assign('no_of_media_imported', $NoOfMediaImported);
			$smarty->assign('no_of_media_failed', $NoOfMediaFailed);
			$smarty->assign('ErrorMediaListXMLString', $gErrorMediaListXMLString);
			$smarty->assign('SuccessMediaListXMLString', $gSuccessMediaListXMLString);
			$smarty->assign('msg', 'Error in importing media');
			$NoOfProductFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
			return true;
		}

		if (!isset($ProductXML->product_price_list)) {
			$smarty->assign('msg', "Old format! Please update your xml format to the latest.");
			$NoOfProductFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
			return true;
		}
		else {
			foreach ($ProductXML->xpath('product_price_list/product_price') as $ProductPrice) {
				// Product Price Level Error Checking
				$ProductPriceLevelList = array();
				if (intval($ProductPrice->discount_type) == 4) {

					foreach ($ProductPrice->xpath('product_price_level_list/product_price_level') as $ProductPriceLevel) {
						$ProductPriceLevelMin	= intval($ProductPriceLevel->product_price_level_min);
						$ProductPriceLevelPrice	= doubleval($ProductPriceLevel->product_price_level_price);
						if ( $ProductPriceLevelMin >= 0 && $ProductPriceLevelPrice > 0) {
							$ProductPriceLevelList[$ProductPriceLevelMin] = $ProductPriceLevelPrice;
						}
					}
					if (count($ProductPriceLevelList) > 0) {
						if ($ProductPriceLevelList[0] <= 0) {
							$smarty->assign('msg', 'product_price_level: must specific a price for product_price_level_min=0 ');
							$NoOfProductFailed++;
							$ErrorXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
							return true;
						}
					}
				}					
			}
		}

		// SHOULD BE ALL CLEAR HERE!!!!
		if ($RealWrite != 'Y') {
			$smarty->assign('no_of_media_parsed', $NoOfMediaParsed);
			$smarty->assign('no_of_media_imported', $NoOfMediaImported);
			$smarty->assign('no_of_media_failed', $NoOfMediaFailed);
			$smarty->assign('ErrorMediaListXMLString', $gErrorMediaListXMLString);
			$smarty->assign('SuccessMediaListXMLString', $gSuccessMediaListXMLString);
			$NoOfProductImported++;
			$SuccessXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
			return true;
		}
		else {
			// DO REAL IMPORT STUFF HERE!!!!!!!!!!!!!!!!!!!
			$id = 0;
			$link_id = 0;

			if ($NewOrUpdate == 'update') {
				$id			= $TheObject[0]['object_id'];
				$link_id	= $TheObject[0]['object_link_id'];

				if ($UpdateMedia == "Y") {
					product::EmptyProductMedia($id, $Site);
				}
			}
			else {
				object::CreateObjectInTree('PRODUCT', $ObjectLink, 'inside', $Site['site_id'], $id, $link_id);
				product::NewProduct($id);
			}
			$Product = product::GetProductInfo($id, 0);
			$smarty->assign('product_id', $id);

			$query =	"	UPDATE	object " .
						"	SET		object_is_enable		= '" . ynval($ProductXML->object_is_enable) . "', " .
						"			object_security_level	= '" . intval($ProductXML->object_security_level) . "' " .
						"	WHERE	object_id = '" . intval($Product['product_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query =	"	UPDATE	object_link " .
						"	SET		object_name	= '" . aveEscT($ProductXML->object_name) . "' " .
						"	WHERE	object_id = '" . intval($Product['product_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			object::UpdateObjectSEOData($Product['product_id'], $ProductXML->object_meta_title, $ProductXML->object_meta_description, $ProductXML->object_meta_keywords, $ProductXML->object_friendly_url);

			$query =	"	UPDATE	product " .
						"	SET		is_special_cat_1			= '" . ynval($ProductXML->is_special_cat_1) . "', " .
						"			is_special_cat_2			= '" . ynval($ProductXML->is_special_cat_2) . "', " .
						"			is_special_cat_3			= '" . ynval($ProductXML->is_special_cat_3) . "', " .
						"			is_special_cat_4			= '" . ynval($ProductXML->is_special_cat_4) . "', " .
						"			product_stock_level			= '" . intval($ProductXML->product_stock_level) . "', " .
						"			product_price				= '" . doubleval($ProductXML->product_price_list->product_price[0]->product_price) . "', " .
						"			product_bonus_point_amount	= '" . intval($ProductXML->product_price_list->product_price[0]->product_bonus_point_amount) . "', " .
						"			discount_type				= '" . intval($ProductXML->product_price_list->product_price[0]->discount_type) . "', " .
						"			discount1_off_p				= '" . intval($ProductXML->product_price_list->product_price[0]->discount1_off_p) . "', " .
						"			discount2_amount			= '" . intval($ProductXML->product_price_list->product_price[0]->discount2_amount) . "', " .
						"			discount2_price				= '" . doubleval($ProductXML->product_price_list->product_price[0]->discount2_price) . "', " .
						"			discount3_buy_amount		= '" . intval($ProductXML->product_price_list->product_price[0]->discount3_buy_amount) . "', " .
						"			discount3_free_amount		= '" . intval($ProductXML->product_price_list->product_price[0]->discount3_free_amount) . "', " .
						"			product_color_id			= '" . intval($ProductXML->product_color_id) . "', " .
						"			product_rgb_r				= '" . intval(hexdec(substr($ProductXML->product_rgb, 1, 2))) . "', " .
						"			product_rgb_g				= '" . intval(hexdec(substr($ProductXML->product_rgb, 3, 2))) . "', " .
						"			product_rgb_b				= '" . intval(hexdec(substr($ProductXML->product_rgb, 5, 2))) . "', " .
						"			factory_code				= '" . aveEscT($ProductXML->factory_code) . "', " .
						"			product_code				= '" . aveEscT($ProductXML->product_code) . "', " .
						"			product_weight				= '" . floatval($ProductXML->product_weight) . "', " .
						"			product_size				= '" . aveEscT($ProductXML->product_size) . "', " .
						"			product_L					= '" . doubleval($ProductXML->product_L) . "', " .
						"			product_W					= '" . doubleval($ProductXML->product_W) . "', " .
						"			product_D					= '" . doubleval($ProductXML->product_D) . "', " .
						"			product_custom_int_1		= '" . intval($ProductXML->product_custom_int_1) . "', " .
						"			product_custom_int_2		= '" . intval($ProductXML->product_custom_int_2) . "', " .
						"			product_custom_int_3		= '" . intval($ProductXML->product_custom_int_3) . "', " .
						"			product_custom_int_4		= '" . intval($ProductXML->product_custom_int_4) . "', " .
						"			product_custom_int_5		= '" . intval($ProductXML->product_custom_int_5) . "', " .
						"			product_custom_int_6		= '" . intval($ProductXML->product_custom_int_6) . "', " .
						"			product_custom_int_7		= '" . intval($ProductXML->product_custom_int_7) . "', " .
						"			product_custom_int_8		= '" . intval($ProductXML->product_custom_int_8) . "', " .
						"			product_custom_int_9		= '" . intval($ProductXML->product_custom_int_9) . "', " .
						"			product_custom_int_10		= '" . intval($ProductXML->product_custom_int_10) . "', " .
						"			product_custom_int_11		= '" . intval($ProductXML->product_custom_int_11) . "', " .
						"			product_custom_int_12		= '" . intval($ProductXML->product_custom_int_12) . "', " .
						"			product_custom_int_13		= '" . intval($ProductXML->product_custom_int_13) . "', " .
						"			product_custom_int_14		= '" . intval($ProductXML->product_custom_int_14) . "', " .
						"			product_custom_int_15		= '" . intval($ProductXML->product_custom_int_15) . "', " .
						"			product_custom_int_16		= '" . intval($ProductXML->product_custom_int_16) . "', " .
						"			product_custom_int_17		= '" . intval($ProductXML->product_custom_int_17) . "', " .
						"			product_custom_int_18		= '" . intval($ProductXML->product_custom_int_18) . "', " .
						"			product_custom_int_19		= '" . intval($ProductXML->product_custom_int_19) . "', " .
						"			product_custom_int_20		= '" . intval($ProductXML->product_custom_int_20) . "', " .
						"			product_custom_double_1		= '" . doubleval($ProductXML->product_custom_double_1) . "', " .
						"			product_custom_double_2		= '" . doubleval($ProductXML->product_custom_double_2) . "', " .
						"			product_custom_double_3		= '" . doubleval($ProductXML->product_custom_double_3) . "', " .
						"			product_custom_double_4		= '" . doubleval($ProductXML->product_custom_double_4) . "', " .
						"			product_custom_double_5		= '" . doubleval($ProductXML->product_custom_double_5) . "', " .
						"			product_custom_double_6		= '" . doubleval($ProductXML->product_custom_double_6) . "', " .
						"			product_custom_double_7		= '" . doubleval($ProductXML->product_custom_double_7) . "', " .
						"			product_custom_double_8		= '" . doubleval($ProductXML->product_custom_double_8) . "', " .
						"			product_custom_double_9		= '" . doubleval($ProductXML->product_custom_double_9) . "', " .
						"			product_custom_double_10	= '" . doubleval($ProductXML->product_custom_double_10) . "', " .
						"			product_custom_double_11	= '" . doubleval($ProductXML->product_custom_double_11) . "', " .
						"			product_custom_double_12	= '" . doubleval($ProductXML->product_custom_double_12) . "', " .
						"			product_custom_double_13	= '" . doubleval($ProductXML->product_custom_double_13) . "', " .
						"			product_custom_double_14	= '" . doubleval($ProductXML->product_custom_double_14) . "', " .
						"			product_custom_double_15	= '" . doubleval($ProductXML->product_custom_double_15) . "', " .
						"			product_custom_double_16	= '" . doubleval($ProductXML->product_custom_double_16) . "', " .
						"			product_custom_double_17	= '" . doubleval($ProductXML->product_custom_double_17) . "', " .
						"			product_custom_double_18	= '" . doubleval($ProductXML->product_custom_double_18) . "', " .
						"			product_custom_double_19	= '" . doubleval($ProductXML->product_custom_double_19) . "', " .
						"			product_custom_double_20	= '" . doubleval($ProductXML->product_custom_double_20) . "', " .
						"			product_custom_date_1		= '" . aveEscT($ProductXML->product_custom_date_1) . "', " .
						"			product_custom_date_2		= '" . aveEscT($ProductXML->product_custom_date_2) . "', " .
						"			product_custom_date_3		= '" . aveEscT($ProductXML->product_custom_date_3) . "', " .
						"			product_custom_date_4		= '" . aveEscT($ProductXML->product_custom_date_4) . "', " .
						"			product_custom_date_5		= '" . aveEscT($ProductXML->product_custom_date_5) . "', " .
						"			product_custom_date_6		= '" . aveEscT($ProductXML->product_custom_date_6) . "', " .
						"			product_custom_date_7		= '" . aveEscT($ProductXML->product_custom_date_7) . "', " .
						"			product_custom_date_8		= '" . aveEscT($ProductXML->product_custom_date_8) . "', " .
						"			product_custom_date_9		= '" . aveEscT($ProductXML->product_custom_date_9) . "', " .
						"			product_custom_date_10		= '" . aveEscT($ProductXML->product_custom_date_10) . "', " .
						"			product_custom_date_11		= '" . aveEscT($ProductXML->product_custom_date_11) . "', " .
						"			product_custom_date_12		= '" . aveEscT($ProductXML->product_custom_date_12) . "', " .
						"			product_custom_date_13		= '" . aveEscT($ProductXML->product_custom_date_13) . "', " .
						"			product_custom_date_14		= '" . aveEscT($ProductXML->product_custom_date_14) . "', " .
						"			product_custom_date_15		= '" . aveEscT($ProductXML->product_custom_date_15) . "', " .
						"			product_custom_date_16		= '" . aveEscT($ProductXML->product_custom_date_16) . "', " .
						"			product_custom_date_17		= '" . aveEscT($ProductXML->product_custom_date_17) . "', " .
						"			product_custom_date_18		= '" . aveEscT($ProductXML->product_custom_date_18) . "', " .
						"			product_custom_date_19		= '" . aveEscT($ProductXML->product_custom_date_19) . "', " .
						"			product_custom_date_20		= '" . aveEscT($ProductXML->product_custom_date_20) . "' " .
						"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query =	"	DELETE FROM	product_price " .
						"	WHERE		product_id = '" . intval($Product['product_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$i = 1;
			foreach ($ProductXML->xpath('product_price_list/product_price') as $ProductPrice) {
				$query =	"	INSERT INTO	product_price " .
							"	SET		product_id						= '" . intval($Product['product_id']) . "', " .
							"			product_price_id				= '" . $i . "', " .
							"			product_price					= '" . doubleval($ProductPrice->product_price) . "', " .
							"			product_bonus_point_required	= '" . intval($ProductPrice->product_bonus_point_required) . "', " .
							"			product_bonus_point_amount		= '" . intval($ProductPrice->product_bonus_point_amount) . "', " .
							"			discount_type					= '" . intval($ProductPrice->discount_type) . "', " .
							"			discount1_off_p					= '" . intval($ProductPrice->discount1_off_p) . "', " .
							"			discount2_amount				= '" . intval($ProductPrice->discount2_amount) . "', " .
							"			discount2_price					= '" . doubleval($ProductPrice->discount2_price) . "', " .
							"			discount3_buy_amount			= '" . intval($ProductPrice->discount3_buy_amount) . "', " .
							"			discount3_free_amount			= '" . intval($ProductPrice->discount3_free_amount) . "' ";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

				if (intval($ProductPrice->discount_type) == 4) {
					$ProductPriceLevelList = array();

					foreach ($ProductPrice->xpath('product_price_level_list/product_price_level') as $ProductPriceLevel) {
						$ProductPriceLevelMin	= intval($ProductPriceLevel->product_price_level_min);
						$ProductPriceLevelPrice	= doubleval($ProductPriceLevel->product_price_level_price);
						if ( $ProductPriceLevelMin >= 0 && $ProductPriceLevelPrice > 0) {
							$ProductPriceLevelList[$ProductPriceLevelMin] = $ProductPriceLevelPrice;
						}
					}

					krsort($ProductPriceLevelList);
					$LastMin = 99999999;
					foreach($ProductPriceLevelList as $key => $value) {
						$query =	"	INSERT INTO	product_price_level " .
									"	SET		product_price_level_min		= '" . $key . "', " .
									"			product_price_level_max		= '" . $LastMin . "', " .
									"			product_price_level_price	= '" . $value . "', " .
									"			product_price_id			= '" . $i . "', " .
									"			product_id					= '" . intval($Product['product_id']) . "'";
						$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

						$LastMin = $key;
					}

					$query =	"	UPDATE	product " .
								"	SET		product_price = '" . $ProductPriceLevelList[0] . "' " .
								"	WHERE	product_id = '" . $Product['product_id'] . "'";
					$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

					$query =	"	UPDATE	product_price " .
								"	SET		product_price = '" . $ProductPriceLevelList[0] . "' " .
								"	WHERE	product_id = '" . $Product['product_id'] . "'" .
								"		AND	product_price_id = '" . $i . "' ";
					$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

				}

				$i++;
			}
			foreach ($SiteLanguageRoots as $R) {
				$ProductData = $ProductDataList->xpath("product_data[language_id='" . $R['language_id'] . "']");

				product::TouchProductData($Product['product_id'], $R['language_id']);
				$tags = explode(",", $ProductData[0]->product_tag);
				$ProductTagText = ', ';
				foreach ($tags as $T)
					$ProductTagText = $ProductTagText . trim($T) . ", ";

				$query =	"	UPDATE	product_data " .
							"	SET		product_name		= '" . aveEscT($ProductData[0]->product_name) . "', " .
							"			product_color		= '" . aveEscT($ProductData[0]->product_color) . "', " .
							"			product_packaging	= '" . aveEscT($ProductData[0]->product_packaging) . "', " .
							"			product_desc		= '" . aveEscT($ProductData[0]->product_desc) . "', " .
							"			product_tag			= '" . aveEscT($ProductTagText) . "', " .
							"			product_custom_text_1		= '" . aveEscT($ProductData[0]->product_custom_text_1) . "', " .
							"			product_custom_text_2		= '" . aveEscT($ProductData[0]->product_custom_text_2) . "', " .
							"			product_custom_text_3		= '" . aveEscT($ProductData[0]->product_custom_text_3) . "', " .
							"			product_custom_text_4		= '" . aveEscT($ProductData[0]->product_custom_text_4) . "', " .
							"			product_custom_text_5		= '" . aveEscT($ProductData[0]->product_custom_text_5) . "', " .
							"			product_custom_text_6		= '" . aveEscT($ProductData[0]->product_custom_text_6) . "', " .
							"			product_custom_text_7		= '" . aveEscT($ProductData[0]->product_custom_text_7) . "', " .
							"			product_custom_text_8		= '" . aveEscT($ProductData[0]->product_custom_text_8) . "', " .
							"			product_custom_text_9		= '" . aveEscT($ProductData[0]->product_custom_text_9) . "', " .
							"			product_custom_text_10		= '" . aveEscT($ProductData[0]->product_custom_text_10) . "', " .
							"			product_custom_text_11		= '" . aveEscT($ProductData[0]->product_custom_text_11) . "', " .
							"			product_custom_text_12		= '" . aveEscT($ProductData[0]->product_custom_text_12) . "', " .
							"			product_custom_text_13		= '" . aveEscT($ProductData[0]->product_custom_text_13) . "', " .
							"			product_custom_text_14		= '" . aveEscT($ProductData[0]->product_custom_text_14) . "', " .
							"			product_custom_text_15		= '" . aveEscT($ProductData[0]->product_custom_text_15) . "', " .
							"			product_custom_text_16		= '" . aveEscT($ProductData[0]->product_custom_text_16) . "', " .
							"			product_custom_text_17		= '" . aveEscT($ProductData[0]->product_custom_text_17) . "', " .
							"			product_custom_text_18		= '" . aveEscT($ProductData[0]->product_custom_text_18) . "', " .
							"			product_custom_text_19		= '" . aveEscT($ProductData[0]->product_custom_text_19) . "', " .
							"			product_custom_text_20		= '" . aveEscT($ProductData[0]->product_custom_text_20) . "' " .
							"	WHERE	product_id	= '" . intval($Product['product_id']) . "'" .
							"		AND	language_id	= '" . intval($R['language_id']) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}

			// Handle special cat now
			$Product = product::GetProductInfo($id, 0);
			$ProductCatSpecialList = product::GetProductCatSpecialList($Site['site_id'], 0);
			for ($i = 1; $i <= NO_OF_PRODUCT_CAT_SPECIAL; $i++) {
				if ($Product['is_special_cat_' . $i] == 'Y') {
					object::NewObjectLink($ProductCatSpecialList[$i]['product_category_special_id'], $Product['product_id'], '', 0, 'normal', DEFAULT_ORDER_ID);
					object::TidyUpObjectOrder($ProductCatSpecialList[$i]['product_category_special_id']);
				}
			}

			// Handle Product Brand
			if (intval($ProductXML->product_brand_id) != 0) {
				$ProductBrand = product::GetProductBrandInfo(intval($ProductXML->product_brand_id), 0);

				if ($ProductBrand['site_id'] == $Site['site_id']) {
					object::NewObjectLink($ProductBrand['product_brand_id'], $Product['product_id'], '', 0, 'normal', DEFAULT_ORDER_ID);
					object::TidyUpObjectOrder($ProductBrand['product_brand_id'], 'PRODUCT');

					$query =	"	UPDATE	product " .
								"	SET		product_brand_id = '" . intval($ProductBrand['product_brand_id']) . "' " .
								"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
					$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
				}
			}

			if ($UpdateMedia == "Y") {
				if (strlen(trim($ProductXML->object_thumbnail_url)) > 0) {
					$TheFile = array();
					$PathInfo = pathinfo(trim($ProductXML->object_thumbnail_url));
					$ObjectThumbnailFile = file_get_contents(trim($ProductXML->object_thumbnail_url));
					$TmpFile = tempnam("/tmp", "TmpImportImageFile");
					file_put_contents($TmpFile, $ObjectThumbnailFile);

					$TheFile = array();
					$TheFile['name'] = $PathInfo['basename'];
					$TheFile['size'] = filesize($TmpFile);
					$TheFile['tmp_name'] = $TmpFile;

					$FileExt = strtolower(substr(strrchr(trim($ProductXML->object_thumbnail_url), '.'), 1));
					if ($FileExt == 'gif') {
						$TheFile['type'] = 'image/gif';
					}
					elseif ($FileExt == 'jpg') {
						$TheFile['type'] = 'image/jpeg';
					}
					elseif ($FileExt == 'png') {
						$TheFile['type'] = 'image/png';
					}

					object::UpdateObjectThumbnail($Product, $Site, $TheFile, $Site['site_product_media_small_width'], $Site['site_product_media_small_height']);
				}

				$NoOfMediaParsed = 0;
				$NoOfMediaImported = 0;
				$NoOfMediaFailed = 0;
				$gSuccessMediaListXMLString = '';
				$gErrorMediaListXMLString = '';

				foreach ($ProductXML->media_list->children() as $Media) {
					$SuccessMediaListXMLString = '';
					$ErrorMediaListXMLString = '';
					$ImportResult = media::ImportMedia($Site, $Product['object_link_id'], $Media, $NoOfMediaParsed, $NoOfMediaImported, $NoOfMediaFailed, $SuccessMediaListXMLString, $ErrorMediaListXMLString, 'Y', 'new');

					if (!$ImportResult)
						$ErrorMediaListXMLString .= " Import result is false ";

					$gSuccessMediaListXMLString = $gSuccessMediaListXMLString . $SuccessMediaListXMLString;
					$gErrorMediaListXMLString	= $gErrorMediaListXMLString . $ErrorMediaListXMLString;
				}
			}

			product::UpdateAllProductCategoryPreCalDataByProductID($Product['product_id'], $SiteLanguageRoots, $Site, $CurrencyList);

			product::UpdateTimeStamp($Product['product_id']);
			site::EmptyAPICache($Site['site_id']);

			$smarty->assign('no_of_media_parsed', $NoOfMediaParsed);
			$smarty->assign('no_of_media_imported', $NoOfMediaImported);
			$smarty->assign('no_of_media_failed', $NoOfMediaFailed);
			$smarty->assign('ErrorMediaListXMLString', $gErrorMediaListXMLString);
			$smarty->assign('SuccessMediaListXMLString', $gSuccessMediaListXMLString);
			$NoOfProductImported++;
			$SuccessXMLString = $smarty->fetch('api/import/PRODUCT.tpl');
			return true;
		}
	}

	public static function GetProductOptionList($ProductID, $IsEnable = 'all') {
		$is_enable_sql = '';
		if ($IsEnable != 'all')
			$is_enable_sql = "	AND	O.is_enable = '" . ynval($IsEnable) . "'";

		$query =	"	SELECT	* " .
					"	FROM	object O	JOIN	object_link OL			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN	product_option	PO		ON	(O.object_id = PO.product_option_id) " .
					"						JOIN	product_option_data POD	ON	(PO.product_option_id = POD.product_option_id) " .
					"	WHERE	PO.product_id	= '" . intval($ProductID) . "'" . $is_enable_sql .
					"	ORDER By	OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductOptionList = array();
		while ($myResult = $result->fetch_assoc()) {
			$ProductOptionList[$myResult['product_option_id']][$myResult['language_id']] = $myResult['product_option_data_text'];
			$ProductOptionList[$myResult['product_option_id']]['object_is_enable'] = $myResult['object_is_enable'];
			$ProductOptionList[$myResult['product_option_id']]['product_option_code'] = $myResult['product_option_code'];

			for ($i = 1; $i <= PRODUCT_OPTION_DATA_TEXT_MAX_NO; $i++)
				$ProductOptionList[$myResult['product_option_id']][$myResult['language_id']][$i] = $myResult['product_option_data_text_' . $i];
		}
		return $ProductOptionList;
	}

	public static function GetProductOptionInfo($ProductOptionID, $LanguageID) {
		$query =	"	SELECT	*, OL.* " .
					"	FROM	object O	JOIN	object_link OL			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN	product_option	PO		ON	(O.object_id = PO.product_option_id) " .
					"						LEFT JOIN	product_option_data POD	ON	(PO.product_option_id = POD.product_option_id AND POD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	PO.product_option_id	= '" . intval($ProductOptionID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetProductOptionDataList($ProductOptionID) {
		$query =	"	SELECT	* " .
					"	FROM	object O	JOIN	object_link OL			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN	product_option	PO		ON	(O.object_id = PO.product_option_id) " .
					"						JOIN	product_option_data POD	ON	(PO.product_option_id = POD.product_option_id) " .
					"	WHERE	PO.product_option_id	= '" . intval($ProductOptionID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductOptionDataList = array();
		while ($myResult = $result->fetch_assoc()) {
			$ProductOptionDataList[$myResult['language_id']] = $myResult;
		}
		return $ProductOptionDataList;
	}

	public static function GetProductOptionListXML($ProductID, $LanguageID) {
		$smarty = new mySmarty();
		$query =	"	SELECT	*, OL.* " .
					"	FROM	object O	JOIN	object_link OL			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN	product_option	PO		ON	(O.object_id = PO.product_option_id) " .
					"						LEFT JOIN	product_option_data POD	ON	(PO.product_option_id = POD.product_option_id AND POD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	PO.product_id	= '" . intval($ProductID) . "'" .
					"		AND	O.object_is_enable = 'Y' " .
					"	ORDER BY	OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductOptionListXML = '';
		while ($myResult = $result->fetch_assoc()) {
			$smarty->assign('Object', $myResult);
			$ProductOptionListXML .= $smarty->fetch('api/object_info/PRODUCT_OPTION.tpl');
		}
		return $ProductOptionListXML;
	}

	public static function IsProductOptionRemovable($ProductOptionID) {
		$query =	"	SELECT	* " .
					"	FROM 	myorder_product " .
					"	WHERE	product_option_id = '" . intval($ProductOptionID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return false;
		else
			return true;
	}

	public static function DeleteProductOption($ProductOptionID) {
		if (!product::IsProductOptionRemovable($ProductOptionID))
			return false;

		$ProductOption = product::GetProductOptionInfo($ProductOptionID, 0);

		$query =	"	DELETE FROM	product_option " .
					"	WHERE		product_option_id = '" . intval($ProductOptionID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	product_option_data " .
					"	WHERE		product_option_id = '" . intval($ProductOptionID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($ProductOptionID);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE		object_id = '" . intval($ProductOptionID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	cart_content " .
					"	WHERE		product_option_id = '" . intval($ProductOptionID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::TidyUpObjectOrder($ProductOption['product_id'], 'PRODUCT_OPTION');
	}

	public static function IsProductOptionExist($ProductID) {
		$query =	"	SELECT	* " .
					"	FROM	object O	JOIN	object_link OL			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN	product_option	PO		ON	(O.object_id = PO.product_option_id) " .
					"	WHERE	PO.product_id	= '" . intval($ProductID) . "'" .
					"		AND O.object_is_enable 	= 'Y' " .
					"		AND OL.object_link_is_enable = 'Y' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return true;
		else
			return false;
	}

	public static function GetAllBrandList($SiteID, $LanguageID, &$TotalBrandNo, $PageNo = 1, $BrandsPerPage = 20, $BrandRefName = '') {
		$sql = '';
		if (trim($BrandRefName) != '')
			$sql = $sql . "	AND OL.object_name LIKE '%" . aveEscT($BrandRefName) . "%' ";

		$Offset = intval(($PageNo -1) * $BrandsPerPage);

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, B.*, O.*, OL.* " .
					"	FROM	object O	JOIN		product_brand B			ON	(B.product_brand_id = O.object_id) " .
					"						JOIN		object_link OL			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						LEFT JOIN	product_brand_data BD	ON	(BD.product_brand_id = B.product_brand_id AND BD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	O.site_id = '" . intval($SiteID) . "'" . $sql .
					"	ORDER BY OL.order_id ASC " .
					"	LIMIT	" . $Offset . ", " . intval($BrandsPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalBrandNo = $myResult[0];

		$ProductBrandList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ProductBrandList, $myResult);
		}
		return $ProductBrandList;
	}

	public static function GetAllProductListWithProductOption($SiteID, $LanguageID, $HonorArchiveDate = false, $HonorPublishDate = false) {
		$sql = '';

		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	O.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	O.object_publish_date < NOW() ";

		$query =	"	SELECT	*, OL.*, O.*, P.* " .
					"	FROM	object O	JOIN		product P				ON	(P.product_id = O.object_id	AND	O.site_id = '" . intval($SiteID) . "') " .
					"						JOIN		object_link OL			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN		object PaO				ON	(OL.parent_object_id = PaO.object_id) " .
					"						LEFT JOIN	product_option	PO		ON	(PO.product_id = P.product_id) " .
					"						LEFT JOIN	product_option_data POD	ON	(PO.product_option_id = POD.product_option_id AND POD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE		O.object_is_enable = 'Y' " . 
					"			AND (PaO.object_type = 'PRODUCT_CATEGORY' OR PaO.object_type = 'PRODUCT_ROOT') " . $sql .
					"	GROUP BY P.product_id, PO.product_option_id " .
					"	ORDER BY OL.object_name ASC ";			
//						"	ORDER BY OL.parent_object_id ASC, OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Products = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($Products, $myResult);
		}
		return $Products;
	}

	public static function GetAllProductList($SiteID, $LanguageID, &$TotalProducts, $PageNo = 1, $ProductsPerPage = 20, $ParentObjID = 0, $ProductID = 0, $ProductCode = '', $ProductRefName = '') {
		// Jeff 20140607: Added LEFT JOIN to product data
		// Jeff 20131203: Removed PPO as PRODUCT_ROOT_LINK is used to hook LANGUAGE_TREE instead of PRODUCT_ROOT
		// Jeff 20110627: PPO (Parent-Parent-Object) is needed as two or above PRODUCT_ROOT object link will exist , one from LIBRARY_ROOT and others from language_tree

		$sql = '';
		if (intval($ParentObjID) != 0)
			$sql = $sql . "	AND PO.object_id = '" . intval($ParentObjID) . "' ";
		if (intval($ProductID) != 0)
			$sql = $sql . "	AND P.product_id = '" . intval($ProductID) . "' ";
		if (trim($ProductCode) != '')
			$sql = $sql . "	AND P.product_code LIKE '%" . aveEscT($ProductCode) . "%' ";
		if (trim($ProductRefName) != '')
			$sql = $sql . "	AND OL.object_name LIKE '%" . aveEscT($ProductRefName) . "%' ";

		$Offset = intval(($PageNo -1) * $ProductsPerPage);

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, PD.*, PCOL.object_name AS parent_object_ref_name, OL.*, O.* " .
					"	FROM	object O	JOIN		product P				ON	(P.product_id = O.object_id) " .
					"						JOIN		object_link OL			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN		object PO				ON	(OL.parent_object_id = PO.object_id) " .
					"						JOIN		object_link PCOL		ON	(PCOL.object_id = PO.object_id) " .
					"						LEFT JOIN	product_data PD			ON	(P.product_id = PD.product_id AND PD.language_id = '" . intval($LanguageID) . "') " .
					"						LEFT JOIN	product_category PC		ON	(OL.parent_object_id = PC.product_category_id) " .
					"	WHERE	O.site_id = '" . intval($SiteID) . "'" .
					"		AND (PO.object_type = 'PRODUCT_CATEGORY' OR PO.object_type = 'PRODUCT_ROOT') " . $sql .
//						"	ORDER BY PO.object_id ASC, P.product_id ASC " .
//						"	ORDER BY PC.product_category_id ASC, OL.order_id ASC " .
					"	GROUP BY O.object_id " .
					"	ORDER BY O.object_global_order_id ASC " .
					"	LIMIT	" . $Offset . ", " . intval($ProductsPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalProducts = $myResult[0];

		$Products = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($Products, $myResult);
		}
		return $Products;
	}		

	public static function GetAdjacentProductsXML($GetType = 'Prev|Next', $RefObjectLink, $ObjParentID, $GroupFunction, $Tag, $SecurityLevel, $LanguageID, $IncludeProductDetails = 'N', $AdjacentProductToGet = 1, $OrderByField = 'order_id', $CurrencyObj = null, $Site = null) {
//	order_by_field - Default: order_id. Other acceptable values: product_price, product_price2, product_price3, product_custom_date_1, product_custom_date_2, product_custom_date_3, product_custom_date_4, product_custom_date_5 
//	group_function - default: min, possible values: min, max, avg			

		$ObjectLink = object::GetObjectLinkByParentObjIDAndObjID($ObjParentID, $RefObjectLink['object_id'], false);
		$smarty = new mySmarty();

		$tag_sql = '';
		if (strlen(trim($Tag)) > 0)
			$tag_sql = " AND PD.product_tag  LIKE '%, " . aveEscT($Tag) . ",%'";

		$OrderIDOperator = '>';
		$OrderIDOrderBy = 'ASC';
		if ($GetType == 'Prev') {
			$OrderIDOperator = '<';
			$OrderIDOrderBy = 'DESC';
		}

		$ProductTableFields = array("product_price", "product_price2", "product_price3", "product_custom_date_1", "product_custom_date_2", "product_custom_date_3", "product_custom_date_4", "product_custom_date_5");
		$ProductDataTableFields = array();
		$ObjectTableFields = array();
		$ObjectLinkTableFiedls = array();

		$SelectSql = '';
		$OrderBySql = '';
		$CompareValue = '';
		$CompareField = '';


		if ($OrderByField == 'order_id') {
			$OrderBySql = 'OL.order_id';
			$CompareValue = $ObjectLink['order_id'];
			$CompareField = 'OL.order_id';
		}
		else if (in_array($OrderByField, $ProductTableFields)) {
			$SelectSql = ", " . $GroupFunction . "(P." . $OrderByField . ") AS myorderbyfield ";
			$OrderBySql = 'myorderbyfield';
			$CompareField = 'P.' . $OrderByField;
		}
		else if (in_array($OrderByField, $ProductDataTableFields)) {
			$SelectSql = ", " . $GroupFunction . "(PD." . $OrderByField . ") AS myorderbyfield ";
			$OrderBySql = 'myorderbyfield';
			$CompareField = 'PD.' . $OrderByField;
		}
		else if (in_array($OrderByField, $ObjectTableFields)) {
			$SelectSql = ", " . $GroupFunction . "(O." . $OrderByField . ") AS myorderbyfield ";
			$OrderBySql = 'myorderbyfield';
			$CompareField = 'O.' . $OrderByField;
		}
		else if (in_array($OrderByField, $ObjectLinkTableFiedls)) {
			$SelectSql = ", " . $GroupFunction . "(OL." . $OrderByField . ") AS myorderbyfield ";
			$OrderBySql = 'myorderbyfield';
			$CompareField = 'OL.' . $OrderByField;
		}

		if ($CompareValue == '') {

			if ($ObjectLink['object_link_is_shadow'] == 'Y') {
				$query =	"	SELECT " . substr($SelectSql, 1) .
							"	FROM	object_link OL	JOIN		object PO			ON	(OL.object_id = PO.object_id AND OL.parent_object_id = '" . $RefObjectLink['parent_object_id'] . "')" .
							"							JOIN		product P			ON	(P.product_id = PO.object_id) " .
							"							LEFT JOIN	product_data PD		ON	(P.product_id = PD.product_id AND PD.language_id = '" . intval($LanguageID) . "') " .
							"							LEFT JOIN	color C				ON	(C.color_id = P.product_color_id AND C.language_id = '" . intval($LanguageID) . "') " .
							"	WHERE	PO.object_security_level <= '" . intval($SecurityLevel) . "' " .
							"		AND	PO.object_archive_date > NOW() " .
							"		AND	PO.object_publish_date < NOW() " . $tag_sql .
							"	GROUP BY OL.parent_object_id ";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

				$myResult = $result->fetch_row();

				$CompareValue = $myResult[0];					
			}
			else {
				$Product = product::GetProductInfoByObjLinkID($ObjectLink['object_link_id'], $LanguageID);
				$CompareValue = $Product[$OrderByField];
			}				
		}

		$query =	"	SELECT	*, P.* " . $SelectSql .
					"	FROM	object_link OL	JOIN		object PO			ON	(OL.object_id = PO.object_id AND OL.parent_object_id = '" . intval($ObjParentID) . "')" .
					"							JOIN		product P			ON	(P.product_id = PO.object_id) " .
					"							LEFT JOIN	product_data PD		ON	(P.product_id = PD.product_id AND PD.language_id = '" . intval($LanguageID) . "') " .
					"							LEFT JOIN	color C				ON	(C.color_id = P.product_color_id AND C.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	PO.object_security_level <= '" . intval($SecurityLevel) . "' " .
					"		AND	PO.object_archive_date > NOW() " .
					"		AND	PO.object_publish_date < NOW() " . $tag_sql .
					"		AND	OL.shadow_parent_id != '" . intval($ObjectLink['shadow_parent_id']) . "'" .
					"	GROUP BY OL.shadow_parent_id " .
					"	HAVING	" . $CompareField . " " . $OrderIDOperator . " '" . $CompareValue . "'" . 					
					"	ORDER BY " . $OrderBySql . " " . $OrderIDOrderBy .
					"	LIMIT	" . intval($AdjacentProductToGet);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$XML = '';
//			$XML = '<query>' . xmlentities($query) . '</query>';
//			$XML = $XML . '<CompareValue>' . xmlentities($CompareValue) . '</CompareValue>';

		while ($myResult = $result->fetch_assoc()) {
			if ($myResult['object_link_is_shadow'] == 'Y') {
				$ProductCatGroup = product::GetProductCatInfo($myResult['shadow_parent_id'], $LanguageID);
				$ProductCatGroup['product_name'] = $ProductCatGroup['product_category_name'];
				$myResult['object_seo_url'] = object::GetSeoURL($ProductCatGroup, '', $LanguageID, null);
				$smarty->assign('Object', $ProductCatGroup);
				$XML = $XML . $smarty->fetch('api/object_info/PRODUCT_GROUP.tpl');
			}
			else {
				if ($IncludeProductDetails == 'Y') {
					$XML = $XML . product::GetProductXML($myResult['object_link_id'], $LanguageID, true, 1, 10, $SecurityLevel, false, 1, 999999, true, null, $CurrencyObj, $Site);
				}
				else {
					$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $LanguageID, null);
					$smarty->assign('Object', $myResult);
					$XML = $XML . "<product>" . $smarty->fetch('api/object_info/PRODUCT.tpl') . "</product>";
				}					
			}
		}
		return $XML;
	}


	public static function UpdateProductQuantitySold($ProductID, $ProductOptionID) {
		$query =	"	UPDATE	product P " .
					"	SET		P.product_quantity_sold = (" .
					"		SELECT	SUM(MP.quantity) AS ProductQuantitySold " .
					"		FROM 	myorder_product MP	JOIN	myorder M	ON	(MP.myorder_id = M.myorder_id)" .
					"		WHERE	MP.product_id = '" . intval($ProductID) . "'" .
					"			AND	M.payment_confirmed = 'Y' " .
					"			AND	M.order_status != 'order_cancelled' " .
					"			AND M.order_status != 'void' " .					
					"		)" .
					"	WHERE P.product_id = '" . intval($ProductID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	UPDATE	product_option P " .
					"	SET		P.product_option_quantity_sold = (" .
					"		SELECT	SUM(MP.quantity) AS ProductOptionQuantitySold " .
					"		FROM 	myorder_product MP	JOIN	myorder M	ON	(MP.myorder_id = M.myorder_id)" .
					"		WHERE	MP.product_id = '" . intval($ProductID) . "'" .
					"			AND	MP.product_option_id = '" . intval($ProductOptionID) . "'" .
					"			AND	M.payment_confirmed = 'Y' " .
					"			AND	M.order_status != 'order_cancelled' " .
					"			AND M.order_status != 'void' " .					
					"		)" .
					"	WHERE	P.product_id = '" . intval($ProductID) . "'" .
					"		AND	P.product_option_id = '" . intval($ProductOptionID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetSecurityCode1($MyOrderID, $ApiKey, $ProductID, $QuantityNo) {
		return strtoupper(substr(md5($MyOrderID . "@##%^&*" . $ApiKey . "$%^&*" . $ProductID . "(%^&*(" . $QuantityNo), 0, 8));
	}

	public static function GetSecurityCode2($MyOrderID, $ApiKey, $ProductID, $QuantityNo) {
		return strtoupper(substr(md5($MyOrderID . "@SGH#H*" . $ApiKey . "*(*^&^" . $ProductID . "#_+)&*(" . $QuantityNo), 0, 8));
	}

	public static function NewProductRootLink($ObjectID, $ProductRootID) {
		$query =	"	INSERT INTO product_root_link " .
					"	SET		product_root_link_id	= '" . intval($ObjectID) . "', " .
					"			product_root_id			= '" . intval($ProductRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetProductRootLink($ObjLinkID) {
		$query =	"	SELECT	* " .
					"	FROM	object O	JOIN	object_link OL			ON (OL.object_id = O.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN	product_root_link PRL	ON (PRL.product_root_link_id = O.object_id) " .
					"	WHERE	OL.object_link_id =  '" . intval($ObjLinkID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function CloneProductRootLink($ProductRootLink, $SrcSite, $DstParentObjID, $DstLanguageID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($ProductRootLink['object_link_id']) <= 0)
			customdb::err_die(1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__, true);

		object::CloneObjectWithObjectLink($ProductRootLink, $SrcSite, $DstParentObjID, $DstLanguageID, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName, $DstSite);

		$DstProductRootID = $ProductRootLink['product_root_id'];
		if ($SrcSite['site_id'] != $DstSite['site_id']) {
			$DstProductRootID = object::GetNewObjectIDFromOriginalCloneFromID($DstProductRootID, $DstSite['site_id'], false);
		}

		$query =	"	INSERT INTO	product_root_link " .
					"	SET		product_root_id = '" . intval($DstProductRootID) . "', " .
					"			product_root_link_id	= '" . intval($NewObjectID) . "'" .
					"	ON DUPLICATE KEY UPDATE product_root_id = '" . intval($DstProductRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function CloneProductBrand($ProductBrand, $SrcSite, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToBrandName = 'N', $DstSite) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		object::CloneObjectWithObjectLink($ProductBrand, $SrcSite, $DstSite['site_product_brand_root_id'], 0, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, 'N', $DstSite);

		product::NewProductBrand($NewObjectID);

		$sql = GetCustomTextSQL("product_brand", "int", 0, $ProductBrand) . GetCustomTextSQL("product_brand", "double", 0, $ProductBrand) . GetCustomTextSQL("product_brand", "date", 0, $ProductBrand);
		if (strlen($sql) > 0) {
			$sql = substr($sql, 0, -1);

			$query =	"	UPDATE	product_brand " .
						"	SET		" . $sql .
						"	WHERE	product_brand_id = '" . intval($NewObjectID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		$query =	"	SELECT	* " .
					"	FROM	product_brand_data " .
					"	WHERE	product_brand_id = '" . intval($ProductBrand['product_brand_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			$sql = GetCustomTextSQL("product_brand", "text", 0, $myResult);
			if (strlen($sql) > 0)
				$sql = ", " . substr($sql, 0, -1);

			$NewBrandName = $myResult['product_brand_name'];
			if ($AddCopyOfToBrandName == 'Y')
				$NewBrandName = "Copy Of " . $NewBrandName;

			$query =	"	INSERT INTO product_brand_data " .
						"	SET		product_brand_id	= '" . intval($NewObjectID) . "', " .
						"			product_brand_name	= '" . aveEscT($NewBrandName) . "', " .
						"			language_id			= '" . aveEscT($myResult['language_id']) . "', " .
						"			product_brand_desc	= '" . aveEscT($myResult['product_brand_desc']) . "' " . $sql;
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function CloneProductCategorySpecialFromSiteToSite($SrcSite, $DstSite) {
		// Special Cat is created already in site_add_act
		$SrcProductCatSpecialList = product::GetProductCatSpecialList($SrcSite['site_id'], 0);

		foreach ($SrcProductCatSpecialList as $C) {
			$query =	"	SELECT * " .
						"	FROM	product_category_special S JOIN object O ON (S.product_category_special_id = O.object_id) " .
						"	WHERE	O.site_id = '" . intval($DstSite['site_id']) . "'" .
						"		AND	S.product_category_special_no = '" . intval($C['product_category_special_no']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$DstProductCatSpecial = $result->fetch_assoc();

			if (intval($DstProductCatSpecial['object_thumbnail_file_id']) > 0)
				object::RemoveObjectThumbnail ($DstProductCatSpecial, $DstSite);

			$ThumbnailFileID = 0;
			if (intval($C['object_thumbnail_file_id']) > 0) {
				$ThumbnailFileID = filebase::CloneFile(intval($C['object_thumbnail_file_id']), $SrcSite, $DstProductCatSpecial['product_category_special_id'], $DstSite);
			}

			// Update object_id_clone_from
			$query =	"	UPDATE	object " .
						"	SET		object_thumbnail_file_id = '" . intval($ThumbnailFileID) . "', " .
						"			object_id_clone_from = '" . intval($C['product_category_special_id']) . "'" .
						"	WHERE	object_id = '" . intval($DstProductCatSpecial['product_category_special_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			// Update object_link
			$query =	"	UPDATE	object_link " .
						"	SET		object_name  = '" . aveEscT($C['object_name']) . "', " .
						"			order_id = '" . intval($C['order_id']) . "'" .
						"	WHERE	object_id = '" . intval($DstProductCatSpecial['product_category_special_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$sql = GetCustomTextSQL("product_category_special", "int", 0, $C) . GetCustomTextSQL("product_category_special", "double", 0, $C) . GetCustomTextSQL("product_category_special", "date", 0, $C);

			if (strlen($sql) > 0) {
				$sql = substr($sql, 0, -1);

				$query =	"	UPDATE	product_category_special " .
							"	SET " . $sql . 
							"	WHERE	product_category_special_id = '" . intval($DstProductCatSpecial['product_category_special_id']) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}

			// Update product category data
			$query =	"	SELECT	* " .
						"	FROM	product_category_special_data " .
						"	WHERE	product_category_special_id = '" . intval($C['product_category_special_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			while ($myResult = $result->fetch_assoc()) {
				product::TouchProductCatSpecialData($DstProductCatSpecial['product_category_special_id'], $myResult['language_id']);
				$sql = GetCustomTextSQL("product_category_special", "text", 0, $myResult);
				if (strlen($sql) > 0)
					$sql = ", " . substr($sql, 0, -1);

				$query =	"	UPDATE	product_category_special_data " .
							"	SET		product_category_special_name	= '" . aveEscT($myResult['product_category_special_name']) . "'" . $sql .
							"	WHERE	product_category_special_id	= '" . intval($DstProductCatSpecial['product_category_special_id']) . "'" .
							"		AND	language_id	= '" . intval($myResult['language_id']) . "'";
				$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}					

			// Media
			$TotalMedia = 0;
			$ProductMediaList = media::GetMediaList($C['product_category_special_id'], 0, $TotalMedia, 1, 999999, 999999, false, false);

			foreach ($ProductMediaList as $M) {
				media::CloneMedia($M, $SrcSite, $DstProductCatSpecial['product_category_special_id'], $NewMediaID, $NewMediaObjLinkID, 'N', 'N', $DstSite);
			}
		}
	}

	public static function CloneProduct($Product, $SrcSite, $DstParentObjID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null, $DstCurrencyList = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($Product['object_link_id']) <= 0)
			err_die(1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__);

		object::CloneObjectWithObjectLink($Product, $SrcSite, $DstParentObjID, 0, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName, $DstSite);

		$sql = GetCustomTextSQL("product", "int", 0, $Product) . GetCustomTextSQL("product", "double", 0, $Product) . GetCustomTextSQL("product", "date", 0, $Product);
		if (strlen($sql) > 0)
			$sql = ", " . substr($sql, 0, -1);

		if ($Product['product_price2'] != NULL)
			$sql = $sql . ", product_price2 = '" . doubleval($Product['product_price2']) . "'";
		if ($Product['product_price3'] != NULL)
			$sql = $sql . ", product_price3 = '" . doubleval($Product['product_price3']) . "'";

		$query =	"	INSERT INTO product " .
					"	SET		product_id					= '" . intval($NewObjectID) . "', " .
					"			is_special_cat_1			= '" . ynval($Product['is_special_cat_1']) . "', " .
					"			is_special_cat_2			= '" . ynval($Product['is_special_cat_2']) . "', " .
					"			is_special_cat_3			= '" . ynval($Product['is_special_cat_3']) . "', " .
					"			is_special_cat_4			= '" . ynval($Product['is_special_cat_4']) . "', " .
					"			is_special_cat_5			= '" . ynval($Product['is_special_cat_5']) . "', " .
					"			is_special_cat_6			= '" . ynval($Product['is_special_cat_6']) . "', " .
					"			is_special_cat_7			= '" . ynval($Product['is_special_cat_7']) . "', " .
					"			is_special_cat_8			= '" . ynval($Product['is_special_cat_8']) . "', " .
					"			is_special_cat_9			= '" . ynval($Product['is_special_cat_9']) . "', " .
					"			is_special_cat_10			= '" . ynval($Product['is_special_cat_10']) . "', " .
					"			is_special_cat_11			= '" . ynval($Product['is_special_cat_11']) . "', " .
					"			is_special_cat_12			= '" . ynval($Product['is_special_cat_12']) . "', " .
					"			is_special_cat_13			= '" . ynval($Product['is_special_cat_13']) . "', " .
					"			is_special_cat_14			= '" . ynval($Product['is_special_cat_14']) . "', " .
					"			is_special_cat_15			= '" . ynval($Product['is_special_cat_15']) . "', " .
					"			is_special_cat_16			= '" . ynval($Product['is_special_cat_16']) . "', " .
					"			is_special_cat_17			= '" . ynval($Product['is_special_cat_17']) . "', " .
					"			is_special_cat_18			= '" . ynval($Product['is_special_cat_18']) . "', " .
					"			is_special_cat_19			= '" . ynval($Product['is_special_cat_19']) . "', " .
					"			is_special_cat_20			= '" . ynval($Product['is_special_cat_20']) . "', " .
					"			product_quantity_sold		= 0, " .
					"			product_stock_level			= 0, " .
					"			product_price				= '" . doubleval($Product['product_price']) . "', " .
					"			product_bonus_point_amount	= '" . intval($Product['product_bonus_point_amount']) . "', " .
					"			discount_type				= '" . intval($Product['discount_type']) . "', " .
					"			discount1_off_p				= '" . intval($Product['discount1_off_p']) . "', " .
					"			discount2_amount			= '" . intval($Product['discount2_amount']) . "', " .
					"			discount2_price				= '" . doubleval($Product['discount2_price']) . "', " .
					"			discount3_buy_amount		= '" . intval($Product['discount3_buy_amount']) . "', " .
					"			discount3_free_amount		= '" . intval($Product['discount3_free_amount']) . "', " .
					"			product_color_id			= '" . intval($Product['product_color_id']) . "', " .
					"			product_rgb_r				= '" . aveEscT($Product['product_rgb_r']) . "', " .
					"			product_rgb_g				= '" . aveEscT($Product['product_rgb_g']) . "', " .
					"			product_rgb_b				= '" . aveEscT($Product['product_rgb_b']) . "', " .
					"			factory_code				= '" . aveEscT($Product['factory_code']) . "', " .
					"			product_code				= '" . aveEscT($Product['product_code']) . "', " .
					"			product_weight				= '" . floatval($Product['product_weight']) . "', " .
					"			product_size				= '" . aveEscT($Product['product_size']) . "', " .
					"			product_L					= '" . doubleval($Product['product_L']) . "', " .
					"			product_W					= '" . doubleval($Product['product_W']) . "', " .
					"			product_D					= '" . doubleval($Product['product_D']) . "', " . 
					"			product_brand_id			= '" . intval($Product['product_brand_id']) . "' " . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Product Data
		$query =	"	SELECT	* " .
					"	FROM	product_data " .
					"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			$sql = GetCustomTextSQL("product", "text", 0, $myResult);
			if (strlen($sql) > 0)
				$sql = ", " . substr($sql, 0, -1);

			$query =	"	INSERT INTO product_data " .
						"	SET		product_id					= '" . intval($NewObjectID) . "', " .
						"			object_meta_title			= '" . aveEscT($myResult['object_meta_title']) . "', " .
						"			object_meta_description		= '" . aveEscT($myResult['object_meta_description']) . "', " .
						"			object_meta_keywords		= '" . aveEscT($myResult['object_meta_keywords']) . "', " .
						"			object_friendly_url			= '" . aveEscT($myResult['object_friendly_url']) . "', " .
						"			product_name				= '" . aveEscT($myResult['product_name']) . "', " .
						"			language_id					= '" . aveEscT($myResult['language_id']) . "', " .
						"			product_color				= '" . aveEscT($myResult['product_color']) . "', " .
						"			product_packaging			= '" . aveEscT($myResult['product_packaging']) . "', " .
						"			product_desc				= '" . aveEscT($myResult['product_desc']) . "', " .
						"			product_tag					= '" . aveEscT($myResult['product_tag']) . "' " . $sql;
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}			

		// Product Option
		$query =	"	SELECT	* " .
					"	FROM	object O	JOIN	object_link OL			ON	(O.object_id = OL.object_id) " .
					"						JOIN	product_option	PO		ON	(O.object_id = PO.product_option_id) " .
					"	WHERE	PO.product_id	= '" . intval($Product['product_id']) . "'";
		$result3 = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult3 = $result3->fetch_assoc()) {
			$NewProductOptionID = 0;
			$NewProductOptionLinkID = 0;
			object::CloneObjectWithObjectLink($myResult3, $SrcSite, $NewObjectID, 0, $NewProductOptionID, $NewProductOptionLinkID, 'N', 'N', $DstSite);

			$query =	"	INSERT INTO product_option " .
						"	SET		product_option_id				= '" . intval($NewProductOptionID) . "', " .
						"			product_id						= '" . intval($NewObjectID) . "', " .
						"			product_option_stock_level		= 0, " .
						"			product_option_quantity_sold	= 0 ";
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);

			// Product Option Data
			$query =	"	SELECT	* " .
						"	FROM	product_option_data " .
						"	WHERE	product_option_id = '" . intval($myResult3['product_option_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			while ($myResult = $result->fetch_assoc()) {
				$query =	"	INSERT INTO product_option_data " .
							"	SET		product_option_id			= '" . intval($NewProductOptionID) . "', " .
							"			language_id					= '" . intval($myResult['language_id']) . "', " .
							"			product_option_data_text_1	= '" . aveEscT($myResult['product_option_data_text_1']) . "', " .
							"			product_option_data_text_2	= '" . aveEscT($myResult['product_option_data_text_2']) . "', " .
							"			product_option_data_text_3	= '" . aveEscT($myResult['product_option_data_text_3']) . "', " .
							"			product_option_data_text_4	= '" . aveEscT($myResult['product_option_data_text_4']) . "', " .
							"			product_option_data_text_5	= '" . aveEscT($myResult['product_option_data_text_5']) . "', " .
							"			product_option_data_text_6	= '" . aveEscT($myResult['product_option_data_text_6']) . "', " .
							"			product_option_data_text_7	= '" . aveEscT($myResult['product_option_data_text_7']) . "', " .
							"			product_option_data_text_8	= '" . aveEscT($myResult['product_option_data_text_8']) . "', " .
							"			product_option_data_text_9	= '" . aveEscT($myResult['product_option_data_text_9']) . "', " .
							"			product_option_data_rgb_1	= '" . aveEscT($myResult['product_option_data_rgb_1']) . "', " .
							"			product_option_data_rgb_2	= '" . aveEscT($myResult['product_option_data_rgb_2']) . "', " .
							"			product_option_data_rgb_3	= '" . aveEscT($myResult['product_option_data_rgb_3']) . "', " .
							"			product_option_data_rgb_4	= '" . aveEscT($myResult['product_option_data_rgb_4']) . "', " .
							"			product_option_data_rgb_5	= '" . aveEscT($myResult['product_option_data_rgb_5']) . "', " .
							"			product_option_data_rgb_6	= '" . aveEscT($myResult['product_option_data_rgb_6']) . "', " .
							"			product_option_data_rgb_7	= '" . aveEscT($myResult['product_option_data_rgb_7']) . "', " .
							"			product_option_data_rgb_8	= '" . aveEscT($myResult['product_option_data_rgb_8']) . "', " .
							"			product_option_data_rgb_9	= '" . aveEscT($myResult['product_option_data_rgb_9']) . "' ";
				$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
		}

		// Product Price
		$query =	"	SELECT	* " .
					"	FROM	product_price " .
					"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			$query =	"	INSERT INTO product_price " .
						"	SET		product_id			= '" . intval($NewObjectID) . "', " .
						"			product_price_id	= '" . intval($myResult['product_price_id']) . "', " .
						"			currency_id			= '" . intval($myResult['currency_id']) . "', " .
						"			product_price		= '" . aveEscT($myResult['product_price']) . "', " .
						"			product_bonus_point_required	= '" . aveEscT($myResult['product_bonus_point_required']) . "', " .
						"			product_bonus_point_amount		= '" . aveEscT($myResult['product_bonus_point_amount']) . "', " .
						"			discount_type		= '" . aveEscT($myResult['discount_type']) . "', " .
						"			discount1_off_p		= '" . aveEscT($myResult['discount1_off_p']) . "', " .
						"			discount2_amount		= '" . aveEscT($myResult['discount2_amount']) . "', " .
						"			discount2_price		= '" . aveEscT($myResult['discount2_price']) . "', " .
						"			discount3_buy_amount	= '" . aveEscT($myResult['discount3_buy_amount']) . "', " .
						"			discount3_free_amount	= '" . aveEscT($myResult['discount3_free_amount']) . "' ";
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		// Product Price Level
		$query =	"	SELECT	* " .
					"	FROM	product_price_level " .
					"	WHERE	product_id = '" . intval($Product['product_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			$query =	"	INSERT INTO product_price_level " .
						"	SET		product_id					= '" . intval($NewObjectID) . "', " .
						"			currency_id					= '" . intval($myResult['currency_id']) . "', " .
						"			product_price_level_min		= '" . aveEscT($myResult['product_price_level_min']) . "', " .
						"			product_price_level_max		= '" . aveEscT($myResult['product_price_level_max']) . "', " .
						"			product_price_level_price	= '" . aveEscT($myResult['product_price_level_price']) . "' ";
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		// Product Brand
		if ($Product['product_brand_id'] != 0) {

			$DstProductBrandID = $Product['product_brand_id'];
			if ($SrcSite['site_id'] != $DstSite['site_id']) {
				$DstProductBrandID = object::GetNewObjectIDFromOriginalCloneFromID($DstProductBrandID, $DstSite['site_id'], false);
			}

			if ($DstProductBrandID !== false) {
				object::NewObjectLink($DstProductBrandID, $NewObjectID, '', 0, 'normal', DEFAULT_ORDER_ID);
				object::TidyUpObjectOrder($DstProductBrandID, 'PRODUCT');
			}
		}

		// Special Cat
		$ProductCatSpecialList = product::GetProductCatSpecialList($SrcSite['site_id'], 0);

		for ($i = 1; $i <= NO_OF_PRODUCT_CAT_SPECIAL; $i++) {
			if ($Product['is_special_cat_' . $i] == 'Y') {
				$DstProductCatSpecialID = $ProductCatSpecialList[$i]['product_category_special_id'];
				if ($SrcSite['site_id'] != $DstSite['site_id']) {
					$DstProductCatSpecialID = object::GetNewObjectIDFromOriginalCloneFromID($DstProductCatSpecialID, $DstSite['site_id']);
				}

				object::NewObjectLink($DstProductCatSpecialID, $NewObjectID, '', 0, 'normal', DEFAULT_ORDER_ID);
				object::TidyUpObjectOrder($DstProductCatSpecialID);
			}
		}

		// Media
		$TotalMedia = 0;
		$ProductMediaList = media::GetMediaList($Product['product_id'], 0, $TotalMedia, 1, 999999, 999999, false, false);

		foreach ($ProductMediaList as $M) {
			media::CloneMedia($M, $SrcSite, $NewObjectID, $NewMediaID, $NewMediaObjLinkID, 'N', 'N', $DstSite);
		}

		$ProductDatafileList = datafile::GetDatafileList($Product['product_id'], 0, $TotalMedia, 1, 999999, 999999, false, false);
		foreach ($ProductDatafileList as $M) {
			datafile::CloneDatafile($M, $SrcSite, $NewObjectID, $NewMediaID, $NewMediaObjLinkID, 'N', 'N', $DstSite);
		}

		$SiteLanguageRoots = language::GetAllSiteLanguageRoot($DstSite['site_id'], 'N', 'Y');
		product::UpdateAllProductCategoryPreCalDataByProductID($NewObjectID, $SiteLanguageRoots, $DstSite, $DstCurrencyList);

	}

	public static function CloneProductRootWithSharedProducts($ProductRoot, $SrcSite, $DstParentObjID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null, $DstCurrencyList = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($ProductRoot['object_link_id']) <= 0)
			err_die(1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__);

		object::CloneObjectWithObjectLink($ProductRoot, $SrcSite, $DstParentObjID, 0, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName, $DstSite);

		global $ProductTreeObjectTypeList;
		$ChildObjects = site::GetAllChildObjects($ProductTreeObjectTypeList, $ProductRoot['object_id'], 99999999, 'ALL', 'ALL', false, false);

		foreach ($ChildObjects as $O) {
			$NewChildObjectID = 0;
			$NewChildObjectLinkID = 0;

			if ($O['object_type'] == 'PRODUCT_CATEGORY') {
				$TheProductCat = product::GetProductCatInfo($O['object_id'], 0);
				product::CloneProductCategoryWithSharedProducts($TheProductCat, $SrcSite, $NewObjectID, $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite, $DstCurrencyList);
			}
			elseif ($O['object_type'] == 'PRODUCT') {
				// If cross site, single product need to create!
				if ($SrcSite['site_id'] != $DstSite['site_Id']) {

					$DstProductID = object::GetNewObjectIDFromOriginalCloneFromID($O['object_id'], $DstSite['site_id'], false);
					if ($DstProductID === false) {
						$NoOfProducts = product::GetNoOfProduct($DstSite['site_id']);
						if ($NoOfProducts >= $DstSite['site_module_product_quota'])
							return;

						$Product = product::GetProductInfo($O['object_id'], 0);
						product::CloneProduct($Product, $SrcSite, $NewObjectID, $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite, $DstCurrencyList);
					}
					else {
						// Someone created the product before... just link it...
						object::NewObjectLink($NewObjectID, $DstProductID, $O['object_name'], 0, 'normal', DEFAULT_ORDER_ID, $O['object_is_enable'], 'N', 0);
					}
				}
				else {
				// Shared Products.... So.... So.... So.... insert a new object link only
					object::NewObjectLink($NewObjectID, $O['object_id'], $O['object_name'], 0, 'normal', DEFAULT_ORDER_ID, $O['object_is_enable'], 'N', 0);						
				}					
			}
		}
	}

	public static function CloneProductCategoryWithSharedProducts($ProductCat, $SrcSite, $DstParentObjID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null, $DstCurrencyList = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($ProductCat['object_link_id']) <= 0)
			customdb::err_die(1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__, true);

		object::CloneObjectWithObjectLink($ProductCat, $SrcSite, $DstParentObjID, 0, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName, $DstSite);
		$sql = GetCustomTextSQL("product_category", "int", 0, $ProductCat) . GetCustomTextSQL("product_category", "double", 0, $ProductCat) . GetCustomTextSQL("product_category", "date", 0, $ProductCat) . GetCustomTextSQL("product_category", "group_field_name", 0, $ProductCat);
		if (strlen($sql) > 0)
			$sql = ", " . substr($sql, 0, -1);

		$query =	"	INSERT INTO product_category " .
					"	SET		 	product_category_id		= '" . intval($NewObjectID) . "', product_category_is_product_group = '" . ynval($ProductCat['product_category_is_product_group']) . "'" . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Product Cat Data
		$query =	"	SELECT	* " .
					"	FROM	product_category_data " .
					"	WHERE	product_category_id = '" . intval($ProductCat['product_category_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			$sql = GetCustomTextSQL("product_category", "text", 0, $myResult);
			if (strlen($sql) > 0)
				$sql = ", " . substr($sql, 0, -1);

			$query =	"	INSERT INTO product_category_data " .
						"	SET		product_category_id			= '" . intval($NewObjectID) . "', " .
						"			object_meta_title			= '" . aveEscT($myResult['object_meta_title']) . "', " .
						"			object_meta_description		= '" . aveEscT($myResult['object_meta_description']) . "', " .
						"			object_meta_keywords		= '" . aveEscT($myResult['object_meta_keywords']) . "', " .
						"			object_friendly_url			= '" . aveEscT($myResult['object_friendly_url']) . "', " .

						"			language_id					= '" . aveEscT($myResult['language_id']) . "', " .
						"			product_category_name		= '" . aveEscT($myResult['product_category_name']) . "' " . $sql;
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}		

		// Duplicate with content
		global $ProductTreeObjectTypeList;
		$ChildObjects = site::GetAllChildObjects($ProductTreeObjectTypeList, $ProductCat['object_id'], 99999999, 'ALL', 'ALL', false, false);

		foreach ($ChildObjects as $O) {
			$NewChildObjectID = 0;
			$NewChildObjectLinkID = 0;

			if ($O['object_type'] == 'PRODUCT_CATEGORY') {
				$TheProductCat = product::GetProductCatInfo($O['object_id'], 0);
				product::CloneProductCategoryWithSharedProducts($TheProductCat, $SrcSite, $NewObjectID, $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite, $DstCurrencyList);
			}
			elseif ($O['object_type'] == 'PRODUCT') {
				// If cross site, single product need to create!
				if ($SrcSite['site_id'] != $DstSite['site_Id']) {

					$DstProductID = object::GetNewObjectIDFromOriginalCloneFromID($O['object_id'], $DstSite['site_id'], false);
					if ($DstProductID === false) {
						$NoOfProducts = product::GetNoOfProduct($DstSite['site_id']);
						if ($NoOfProducts >= $DstSite['site_module_product_quota'])
							return;

						$Product = product::GetProductInfo($O['object_id'], 0);
						product::CloneProduct($Product, $SrcSite, $NewObjectID, $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite, $DstCurrencyList);
					}
					else {
						// Someone created the product before... just link it...
						object::NewObjectLink($NewObjectID, $DstProductID, $O['object_name'], 0, 'normal', DEFAULT_ORDER_ID, $O['object_is_enable'], 'N', 0);
					}
				}
				else {
				// Shared Products.... So.... So.... So.... insert a new object link only
					object::NewObjectLink($NewObjectID, $O['object_id'], $O['object_name'], 0, 'normal', DEFAULT_ORDER_ID, $O['object_is_enable'], 'N', 0);						
				}					
			}
		}

		$TotalMedia = 0;
		$ProductMediaList = media::GetMediaList($ProductCat['product_category_id'], 0, $TotalMedia, 1, 999999, 999999, false, false);

		foreach ($ProductMediaList as $M) {
			media::CloneMedia($M, $SrcSite, $NewObjectID, $NewMediaID, $NewMediaObjLinkID, 'N', 'N', $DstSite);
		}			

		$SiteLanguageRoots = language::GetAllSiteLanguageRoot($DstSite['site_id'], 'N', 'Y');
		product::UpdateProductCategoryPreCalData($NewObjectID, $SiteLanguageRoots, $DstSite, $DstCurrencyList);
	}

	public static function CloneProductCategory($ProductCat, $Site, $DstParentObjID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $CurrencyList = null) {
		if (intval($ProductCat['object_link_id']) <= 0)
			customdb::err_die(1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__, true);

		object::CloneObjectWithObjectLink($ProductCat, $Site, $DstParentObjID, 0, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName);
		$sql = GetCustomTextSQL("product_category", "int", 0, $ProductCat) . GetCustomTextSQL("product_category", "double", 0, $ProductCat) . GetCustomTextSQL("product_category", "date", 0, $ProductCat) . GetCustomTextSQL("product_category", "group_field_name", 0, $ProductCat);
		if (strlen($sql) > 0)
			$sql = ", " . substr($sql, 0, -1);

		$query =	"	INSERT INTO product_category " .
					"	SET		 	product_category_id		= '" . intval($NewObjectID) . "', product_category_is_product_group = '" . ynval($ProductCat['product_category_is_product_group']) . "'" . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Product Cat Data
		$query =	"	SELECT	* " .
					"	FROM	product_category_data " .
					"	WHERE	product_category_id = '" . intval($ProductCat['product_category_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			$sql = GetCustomTextSQL("product_category", "text", 0, $myResult);
			if (strlen($sql) > 0)
				$sql = ", " . substr($sql, 0, -1);

			$query =	"	INSERT INTO product_category_data " .
						"	SET		product_category_id			= '" . intval($NewObjectID) . "', " .
						"			language_id					= '" . aveEscT($myResult['language_id']) . "', " .
						"			product_category_name		= '" . aveEscT($myResult['product_category_name']) . "' " . $sql;
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}		

		// Duplicate with content
		global $ProductTreeObjectTypeList;
		$ChildObjects = site::GetAllChildObjects($ProductTreeObjectTypeList, $ProductCat['object_id'], 99999999, 'ALL', 'ALL', false, false);

		foreach ($ChildObjects as $O) {
			$NewChildObjectID = 0;
			$NewChildObjectLinkID = 0;

			if ($O['object_type'] == 'PRODUCT_CATEGORY') {
				$TheProductCat = product::GetProductCatInfo($O['object_id'], 0);
				product::CloneProductCategory($TheProductCat, $Site, $NewObjectID, $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $CurrencyList);
			}
			elseif ($O['object_type'] == 'PRODUCT') {
				$NoOfProducts = product::GetNoOfProduct($Site['site_id']);
				if ($NoOfProducts >= $Site['site_module_product_quota'])
					return;

				$Product = product::GetProductInfo($O['object_id'], 0);
				product::CloneProduct($Product, $Site, $NewObjectID, $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $Site, $CurrencyList);
			}
		}

		$TotalMedia = 0;
		$ProductMediaList = media::GetMediaList($ProductCat['product_category_id'], 0, $TotalMedia, 1, 999999, 999999, false, false);

		foreach ($ProductMediaList as $M) {
			media::CloneMedia($M, $Site, $NewObjectID, $NewMediaID, $NewMediaObjLinkID, 'N', 'N');
		}

		$SiteLanguageRoots = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');
		product::UpdateProductCategoryPreCalData($NewObjectID, $SiteLanguageRoots, $Site, $CurrencyList);
	}

	public static function DeleteProductCatRecursive($ObjectID, $Site) {
		$ProductCat = product::GetProductCatInfo($ObjectID, 0);

		if ($ProductCat == null)
			return;

		global $ProductTreeObjectTypeList;
		$ChildObjects = site::GetAllChildObjects($ProductTreeObjectTypeList, $ObjectID, 99999999, 'ALL', 'ALL', false, false);

		foreach ($ChildObjects as $O) {
			if ($O['object_type'] == 'PRODUCT_CATEGORY') {
				product::DeleteProductCatRecursive($O['object_id'], $Site);
			}
			elseif ($O['object_type'] == 'PRODUCT') {

				$AllProductParents = product::GetAllProductCategoriesOrProductRootsByObjectID($O['object_id'], 0);

				if (count($AllProductParents) > 1) {
					// Delete this link only
					object::DeleteObjectLink($O['object_link_id']);
				}
				else
					product::DeleteProduct($O['object_id'], $Site);
			}
		}

		// Read again to make sure the cat can be deleted
		$ChildObjects = site::GetAllChildObjects($ProductTreeObjectTypeList, $ObjectID, 99999999, 'ALL', 'ALL', false, false);
		if (count($ChildObjects) == 0) {
			product::DeleteProductCat($ObjectID);
		}
	}

	public static function GetProductRootForProductOrProductCat($ObjectID) {			
		// USED IN HNK IMPORT SCRIPT!

		$ParentObj == null;

		do {
			$query	=	"	SELECT		PO.* " .
						"	FROM		object O	JOIN object_link OL ON (O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
						"							JOIN object PO ON (PO.object_id = OL.parent_object_id) " .
						"	WHERE		OL.object_id	=	'" . intval($ObjectID) . "'" .
						"			AND	(PO.object_type	= 'PRODUCT_CATEGORY' OR PO.object_type = 'PRODUCT_ROOT') ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$ParentObj = $result->fetch_assoc();

			$ObjectID = $ParentObj['object_id'];
//var_dump($ParentObj); echo "<hr />";
		} while ($ParentObj['object_type'] != 'PRODUCT_ROOT' && $ParentObj != null);

		if ($ParentObj['object_type'] == 'PRODUCT_ROOT') {
			$ProductRoot = product::GetProductRootInfo($ParentObj['object_id']);
			return $ProductRoot;
		}
		return null;
	}

	public static function GetAllProductCategoriesOrProductRootsByObjectID($ObjectID, $LanguageID = 0) {
		// Only product and product cat group can be multi cats
		// Product cat cannot be under multi cat to avoid dead loop!			

		$query =	"	SELECT	PCD.*, PC.*, PRO.*, PROL.*, OL.object_link_id AS son_obj_link_id, OL.order_id AS son_order_id " .
					"	FROM	object_link OL	JOIN		object PRO				ON	(OL.parent_object_id = PRO.object_id AND OL.object_id = '" . intval($ObjectID) . "' AND OL.object_link_is_shadow = 'N') " .
					"							LEFT JOIN	product_category PC		ON	(PC.product_category_id = PRO.object_id)" .
					"							LEFT JOIN	product_category_data PCD	ON	(PCD.product_category_id = PRO.object_id AND PCD.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN		object_link PROL	ON	(PROL.object_id = PRO.object_id AND PROL.object_link_is_shadow = 'N') " . 
					"	WHERE	 PRO.object_type	= 'PRODUCT_CATEGORY' OR PRO.object_type = 'PRODUCT_ROOT' " .
					"	ORDER BY PROL.object_name ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductCategories = array();

		while ($myResult = $result->fetch_assoc()) {
			array_push($ProductCategories, $myResult);
		}

		return $ProductCategories;
	}

	public static function GetAllProductCategoriesByObjectID($ObjectID, $LanguageID = 0) {
		// Only product and product cat group can be multi cats
		// Product cat cannot be under multi cat to avoid dead loop!			
		$query =	"	SELECT	PCD.*, PC.*, PRO.*, PROL.*, OL.object_link_id AS son_obj_link_id, OL.order_id AS son_order_id " .
					"	FROM	object_link OL	JOIN		object PRO					ON	(OL.parent_object_id = PRO.object_id AND OL.object_id = '" . intval($ObjectID) . "' AND OL.object_link_is_shadow = 'N') " .
					"							JOIN	product_category PC			ON	(PC.product_category_id = PRO.object_id) " .
					"							LEFT JOIN	product_category_data PCD	ON	(PCD.product_category_id = PRO.object_id AND PCD.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN		object_link PROL	ON	(PROL.object_id = PRO.object_id AND PROL.object_link_is_shadow = 'N') " .
					"	ORDER BY PC.product_category_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductCategories = array();

		while ($myResult = $result->fetch_assoc()) {
			array_push($ProductCategories, $myResult);
		}

		return $ProductCategories;
	}		

	public static function GetProductCatByProductLinkID($ProductLinkID, $LanguageID = 0) {
		$query =	"	SELECT	PCOL.*, PC.*, PCO.* " .
					"	FROM	object_link OL	JOIN	product_category PC	ON	(PC.product_category_id = OL.parent_object_id AND OL.object_link_id = '" . intval($ProductLinkID) . "' AND OL.object_link_is_shadow = 'N') " .
					"							JOIN	object_link PCOL	ON	(PCOL.object_id = PC.product_category_id AND PCOL.object_link_is_shadow = 'N') " . 
					"							JOIN	object PCO			ON	(PCO.object_id = PC.product_category_id) ";
					"						LEFT JOIN	product_category_data CD	ON (PC.product_category_id = CD.product_category_id AND CD.language_id = '" . intval($LanguageID) . "') ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;			
	}

	public static function UpdateProductCategoryPreCalData($ProductCatID, $SiteLanguageRoots, $Site = null, $CurrencyList = null) {
		// 1) Price Range
		product::UpdateProductCategoryPriceRange($ProductCatID, $Site, $CurrencyList);
 
		// 2) Json Cache
		foreach ($SiteLanguageRoots as $R) {
			$ProductGroupCacheObj = product::GetProductGroupCacheObj($ProductCatID, $R['language_id']);

			$query =	"	UPDATE	product_category_data	" .
						"	SET		" .
						"			product_category_group_json_cache = '" . aveEsc(json_encode($ProductGroupCacheObj)) . "' " .
						"	WHERE	product_category_id = '" . intval($ProductCatID) . "' " .
						"		AND	language_id = '" . intval($R['language_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		// 3)
		product::ProductGroupUpdateShadowProduct($ProductCatID);
	}

	private static function UpdateProductCategoryPriceRange($ProductCatID, $Site = null, $CurrencyList = null) {
		if ($Site == null) {
			//This is not what I want to maintain but for safety
			$ProductCat = product::GetProductCatInfo($ProductCatID, 0);
			$Site = site::GetSiteInfo($ProductCat['site_id']);
		}

		$query =	"	DELETE FROM	product_category_price_range " .
					"	WHERE	product_category_id = '" . intval($ProductCatID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($Site['site_product_price_indepedent_currency'] == 'N') {
			$CurrencyList = array();
			$Currency = array();
			$Currency['currency_id'] = 0;
			array_push($CurrencyList, $Currency);
		}
		else {
			if ($CurrencyList == null) {
				$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);
			}
		}

		foreach ($CurrencyList as $C) {
			$PriceRange = array();

			for ($i=1; $i <= 9; $i++)
				$PriceRange[$i] = array();

			$query =	"	SELECT	* " .
						"	FROM	object_link OL	" .
						"				JOIN	product P ON (P.product_id = OL.object_id AND OL.parent_object_id = '" . intval($ProductCatID) . "' AND OL.object_link_is_shadow = 'N') " .
						"				JOIN	object O ON (P.product_id = O.object_id) " . 
						"				JOIN	product_price PP ON (P.product_id = PP.product_id AND PP.currency_id = '" . intval($C['currency_id']) . "') " .
						"	WHERE OL.object_link_is_enable = 'Y' AND O.object_is_enable = 'Y' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			while ($myResult = $result->fetch_assoc()) {
				array_push($PriceRange[$myResult['product_price_id']], $myResult['product_price']);
			}

			$query =	"	SELECT	* " .
						"	FROM	object_link OL	JOIN	product_category PC		ON	(PC.product_category_id = OL.object_id AND OL.parent_object_id = '" . intval($ProductCatID) . "' AND OL.object_link_is_shadow = 'N') " .
						"							JOIN	object O ON (OL.object_id = O.object_id) " .
						"							JOIN	product_category_price_range R ON (PC.product_category_id = R.product_category_id AND currency_id = '" . intval($C['currency_id']) . "') " .
						"	WHERE OL.object_link_is_enable = 'Y' AND O.object_is_enable = 'Y' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			while ($myResult = $result->fetch_assoc()) {
				for ($i=1; $i <= 9; $i++) {
					array_push($PriceRange[$i], $myResult['product_category_price' . $i . '_range_min']);
					array_push($PriceRange[$i], $myResult['product_category_price' . $i . '_range_max']);
				}
			}

			$sql_update = '';
			for ($i=1; $i <= 9; $i++) {
				$sql_update = $sql_update .
								"	product_category_price" . $i . "_range_min = '" . @min($PriceRange[$i]) . "'," .
								"	product_category_price" . $i . "_range_max = '" . @max($PriceRange[$i]) . "',";						
			}
			$sql_update = substr($sql_update, 0, -1);

			$query =	"	INSERT INTO	product_category_price_range " .
						"	SET		product_category_id = '" . intval($ProductCatID) . "', " .
						"			currency_id = '" . intval($C['currency_id']) . "', " . $sql_update .
						"	ON DUPLICATE KEY UPDATE " . $sql_update;
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		$ParentProductCats = product::GetAllProductCategoriesByObjectID($ProductCatID, 0);

		foreach($ParentProductCats as $C) // Should be only one actually...
			product::UpdateProductCategoryPriceRange($C['object_id'], $Site, $CurrencyList);
	}

	public static function UpdateAllProductCategoryPreCalDataByProductID($ProductID, $SiteLanguageRoots, $Site = null, $CurrencyList = null) {
		$AllProductCategoryList = product::GetAllProductCategoriesByObjectID($ProductID);
		foreach ($AllProductCategoryList as $C) {
			product::UpdateProductCategoryPreCalData($C['product_category_id'], $SiteLanguageRoots, $Site, $CurrencyList);
		}
	}

	public static function GetProductGroupValidFieldList($SiteID) {
		$ProductFieldsShow = site::GetProductFieldsShow($SiteID);
//			$ProductCatFieldsShow = site::GetProductCatFieldsShow($SiteID);
		$ProductCustomFieldsDef = site::GetProductCustomFieldsDef($SiteID);
//			$ProductCategoryCustomFieldsDef = site::GetProductCategoryCustomFieldsDef($SiteID);

		global $ProductCategoryBasicGroupValidFields;

		$ValidFields = $ProductCategoryBasicGroupValidFields;

		foreach ($ValidFields as $key => $value) {
			$prefix = substr($key, 0, 1);
			$fieldname = substr($key, 2);

//				if ($prefix == 'p')
			$FieldsShowVar = &$ProductFieldsShow;
//				else if ($prefix == 'd')
//					$FieldsShowVar = &$ProductCatFieldsShow;
//				else
//					continue;

			if ($FieldsShowVar[$fieldname] == 'N') {
				unset($ValidFields[$key]);
			}
		}

		// Now Custom Fields
		for ($i = 1; $i <= 20; $i++) {
			$fieldname = "product_custom_int_" . $i;
			if ($ProductCustomFieldsDef[$fieldname] != '')
				$ValidFields["p_" . $fieldname] = $ProductCustomFieldsDef[$fieldname];
		}
		for ($i = 1; $i <= 20; $i++) {
			$fieldname = "product_custom_double_" . $i;
			if ($ProductCustomFieldsDef[$fieldname] != '')
				$ValidFields["p_" . $fieldname] = $ProductCustomFieldsDef[$fieldname];
		}
		for ($i = 1; $i <= 20; $i++) {
			$fieldname = "product_custom_date_" . $i;
			if ($ProductCustomFieldsDef[$fieldname] != '')
				$ValidFields["p_" . $fieldname] = $ProductCustomFieldsDef[$fieldname];
		}
		for ($i = 1; $i <= 20; $i++) {
			$fieldname = "product_custom_rgb_" . $i;
			if ($ProductCustomFieldsDef[$fieldname] != '')
				$ValidFields["p_" . $fieldname] = $ProductCustomFieldsDef[$fieldname];
		}
		for ($i = 1; $i <= 20; $i++) {
			$fieldname = "product_custom_text_" . $i;
			if ($ProductCustomFieldsDef[$fieldname] != '') {
				$SpecialFieldDef = array("STXT_", "MTXT_", "HTML_");
				if (in_array(substr($ProductCustomFieldsDef[$fieldname], 0, 5), $SpecialFieldDef))
					$ValidFields["d_" . $fieldname] = substr($ProductCustomFieldsDef[$fieldname], 5);
				else
					$ValidFields["d_" . $fieldname] = $ProductCustomFieldsDef[$fieldname];
			}
		}

		return $ValidFields;
	}

	public static function GetProductGroupCacheObj($ProductCategoryID, $LanguageID) {
		$ProductCat = product::GetProductCatInfo($ProductCategoryID, $LanguageID);

		$ProductGroupFields = array();
		for ($i = 1; $i <=9; $i++) {
			if ($ProductCat['product_category_group_field_name_' . $i] != '')
				array_push($ProductGroupFields, str_replace("product_custom_rgb", "object_custom_rgb", substr($ProductCat['product_category_group_field_name_' . $i], 2)));
		}

		if (count($ProductGroupFields) == 0)
			return null;

		$TheResultObj = array(
			'ProductGroupFieldValue' => array(),
			'TheObjIDMatrix' => array(),
			'TheLinkIDMatrix' => array(),
//				'TheValidationMatrix' => array()
		);

		for ($i = 0; $i < count($ProductGroupFields); $i++) {
			$TheResultObj['ProductGroupFieldValue'][$i] = array();
//				$TheResultObj['TheValidationMatrix'][$i] = array();				
		}

		$query =	"	SELECT	PD.*, O.*, OL.*, P.* " .
					"	FROM	object O	JOIN		product P				ON	(P.product_id = O.object_id AND O.object_is_enable = 'Y') " .
					"						JOIN		object_link OL			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N' AND OL.object_link_is_enable = 'Y') " .
					"						JOIN		object PO				ON	(OL.parent_object_id = PO.object_id AND PO.object_id = '" . intval($ProductCategoryID) . "') " .
					"						LEFT JOIN	product_data PD			ON	(P.product_id = PD.product_id AND PD.language_id = '" . intval($LanguageID) . "') ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Products = array();

		while ($myResult = $result->fetch_assoc()) {
			array_push($Products, $myResult);

			foreach ($ProductGroupFields as $IndexF => $ValueF) {					
				if (strlen($myResult[$ValueF]) > 0) {
					array_push($TheResultObj['ProductGroupFieldValue'][$IndexF], $myResult[$ValueF]);

// NO MORE PRODUCT BRAND
//						if ($ValueF == 'product_brand_id') {
//							$ProductBrand = product::GetProductBrandInfo($myResult[$ValueF], $LanguageID);
//							array_push($TheResultObj['ProductGroupFieldValue'][$IndexF], $ProductBrand['product_brand_name']);
//						}
//						else
//							array_push($TheResultObj['ProductGroupFieldValue'][$IndexF], $myResult[$ValueF]);
				}
			}
		}

		for ($i = 0; $i < count($ProductGroupFields); $i++) {
			$TheResultObj['ProductGroupFieldValue'][$i] = array_unique($TheResultObj['ProductGroupFieldValue'][$i]);

			// product_custom_int, product_custom_double, product_custom_date
			if (
				substr($ProductGroupFields[$i], 0, strlen('product_custom_int')) == 'product_custom_int' ||
				substr($ProductGroupFields[$i], 0, strlen('product_custom_double')) == 'product_custom_double'
			)
				sort ($TheResultObj['ProductGroupFieldValue'][$i], SORT_NUMERIC);
			else if (substr($ProductGroupFields[$i], 0, strlen('product_custom_date')) == 'product_custom_date') {
				natsort ($TheResultObj['ProductGroupFieldValue'][$i]);
				$temp = array();
				foreach ($TheResultObj['ProductGroupFieldValue'][$i] as $Value)
					array_push($temp, $Value);
				$TheResultObj['ProductGroupFieldValue'][$i] = $temp;
			}
			else {
				natsort ($TheResultObj['ProductGroupFieldValue'][$i]);
				$temp = array();
				foreach ($TheResultObj['ProductGroupFieldValue'][$i] as $Value) {

					array_push($temp, $Value);
				}
				$TheResultObj['ProductGroupFieldValue'][$i] = $temp;
				//sort ($TheResultObj['ProductGroupFieldValue'][$i], SORT_STRING);
				//natsort ($TheResultObj['ProductGroupFieldValue'][$i]);
			}
		}

		// 20140724... the day the ValidationMatrix dies...

		// Now create 2nd Dimension Array
//			for ($i = 0; $i < count($ProductGroupFields); $i++) {
//				
//				for ($j = 0; $j < count($TheResultObj['ProductGroupFieldValue'][$i]); $j++) {
//					$TheResultObj['TheValidationMatrix'][$i][$j] = array();
//
//					for ($k = 0; $k < count($ProductGroupFields); $k++) {
//						if ($i != $k) {
//							$TheResultObj['TheValidationMatrix'][$i][$j][$k] = array();
//							
//							for ($m = 0; $m < count($TheResultObj['ProductGroupFieldValue'][$k]); $m++) {
//								$TheResultObj['TheValidationMatrix'][$i][$j][$k][$m] = false;
//							}
//						}
//					}
//				}
//			}

		// Now call me The Architect!!!!!		
		foreach ($Products as $P) {
			$TheField = '';

			foreach ($ProductGroupFields as $IndexF => $ValueF) {
				// Search for value
				$TheIndex = array_search($P[$ValueF], $TheResultObj['ProductGroupFieldValue'][$IndexF]);

				// NO MORE PRODUCT BRAND
//					if ($ValueF == 'product_brand_id') {
//						$ProductBrand = product::GetProductBrandInfo($P[$ValueF], $LanguageID);
//						$TheIndex = array_search($ProductBrand['product_brand_name'], $TheResultObj['ProductGroupFieldValue'][$IndexF]);
//					}
//					else
//						$TheIndex = array_search($P[$ValueF], $TheResultObj['ProductGroupFieldValue'][$IndexF]);

				if ($TheIndex === false) {
					$TheField = '';
					break;
				}

				$TheField = $TheField . "_" . $TheIndex;

				// Now add possible value for each validation
//					$ArrayAtD3 = &$TheResultObj['TheValidationMatrix'][$IndexF][$TheIndex];
//					
//					for ($i = 0; $i < count($ProductGroupFields); $i++) {
//						if ($i != $IndexF) {
//							$ProductGroupFieldAtD3 = $ProductGroupFields[$i];
//							$IndexAtD4 = array_search($P[$ProductGroupFieldAtD3], $TheResultObj['ProductGroupFieldValue'][$i]);
//							
//							$TheResultObj['TheValidationMatrix'][$IndexF][$TheIndex][$i][$IndexAtD4] = true;
//						}
//					}
			}

			if ($TheField != '') {
				$TheResultObj['TheObjIDMatrix'][$TheField] = $P['product_id'];
				$TheResultObj['TheLinkIDMatrix'][$TheField] = $P['object_link_id'];
			}
		}

		// The Validation Matrix!!!

		return $TheResultObj;
	}

	public static function IsProductCatAProductGroup($ProductCat) {
		return ($ProductCat['product_category_is_product_group'] == 'Y');
	}

	// Shadow product is the shadow of product group
	public static function ProductGroupUpdateShadowProduct($ProductGroupCatID) {
		$LockName = "ProductGroupUpdateShadowProduct" . $ProductGroupCatID;
		$MyLock = new mylock($LockName);
		$MyLock->acquireLock(true);

		product::ProductGroupRemoveShadowProduct($ProductGroupCatID);

		$ProductCat = product::GetProductCatInfo($ProductGroupCatID, 0);

		if (!product::IsProductCatAProductGroup($ProductCat))
			return;

		$ParentProductCatOrProductRootList = product::GetAllProductCategoriesOrProductRootsByObjectID($ProductGroupCatID, 0);

		$query =	"	SELECT	O.*, OL.*, P.* " .
					"	FROM	object O	JOIN		product P		ON	(P.product_id = O.object_id) " .
					"						JOIN		object_link OL	ON	(O.object_id = OL.object_id AND OL.parent_object_id = '" . intval($ProductGroupCatID) . "' AND OL.object_link_is_shadow = 'N') ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$IsAllDisabled = true;

		while ($Product = $result->fetch_assoc()) {
			if ($Product['object_link_is_enable'] == 'Y' && $Product['object_is_enable'] == 'Y')
				$IsAllDisabled = false;

			foreach ($ParentProductCatOrProductRootList as $PPC) {
				$query =	"	INSERT INTO	object_link SET " .
							"		parent_object_id = '" . intval($PPC['object_id']) . "', " .
							"		language_id = 0, " .
							"		object_link_is_enable = '" . ynval($Product['object_link_is_enable']) . "', " .
							"		object_id = '" . intval($Product['product_id']) . "', " .
							"		object_name = '" . aveEscT($Product['object_name']) . "', " .
							"		object_system_flag = '" . aveEscT($Product['object_system_flag']) . "', " .
							"		order_id = '" . intval($PPC['son_order_id']) . "', " .
							"		object_link_is_shadow = 'Y', " .
							"		shadow_parent_id = '" . intval($ProductGroupCatID) . "'";
				$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
		}

		if ($IsAllDisabled) {
			$query =	"	UPDATE	object " .
						"	SET		object_is_enable = 'N' " .
						"	WHERE	object_id = '" . intval($ProductGroupCatID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query =	"	UPDATE	object_link " .
						"	SET		object_link_is_enable = 'N' " .
						"	WHERE	object_id = '" . intval($ProductGroupCatID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		unset($MyLock);
	}

	public static function ProductGroupRemoveShadowProduct($ProductGroupCatID) {
		$query =	"	DELETE FROM object_link WHERE " .
					"		object_link_is_shadow = 'Y' " .
					"	AND	shadow_parent_id = '" . intval($ProductGroupCatID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function CloneAllProductBrandFromSiteToSite($SrcSite, $DstSite) {
		if ($SrcSite['site_id'] == $DstSite['site_id'])
			die("CloneAllProductBrandFromSiteToSite failed: cannot clone to itself");
		if ($DstSite['site_product_brand_root_id'] == 0) {
			// Legendary old site...
			// Let me create one for you
			$SiteProductBrandRootID = object::NewObject('PRODUCT_BRAND_ROOT', $DstSite['site_id'], 0);
			object::NewObjectLink($DstSite['library_root_id'], $SiteProductBrandRootID, 'Product Brand Root', 0, 'system', DEFAULT_ORDER_ID);
		}

		$ProductBrandList = product::GetAllBrandList($SrcSite['site_id'], $SrcSite['site_default_language_id'], $TotalProductBrand, 1, 999999, '');

		foreach ($ProductBrandList as $B)
			product::CloneProductBrand ($B, $SrcSite, $NewObjectID, $NewObjectLinkID, 'N', 'N', $DstSite);			
	}

	public static function CloneAllProductRootFromSiteToSite($SrcSite, $DstSite) {

		$ProductRoots = product::GetProductRootList($SrcSite);
		$DstCurrencyList = currency::GetAllSiteCurrencyList($DstSite['site_id']);

		foreach ($ProductRoots as $R)
			product::CloneProductRootWithSharedProducts($R, $SrcSite, $DstSite['library_root_id'], $NewObjectID, $NewObjectLinkID, 'N', 'N', $DstSite, $DstCurrencyList);
	}

	public static function TouchProductRootData($ProductRootID, $LanguageID) {
		$query =	"	INSERT INTO product_root_data " .
					"	SET		product_root_id	= '" . intval($ProductRootID) . "', " .
					"			language_id = '" . intval($LanguageID) . "'" .
					"	ON DUPLICATE KEY UPDATE product_root_id = '" . intval($ProductRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function CleanUpProductPriceAndPriceLevelRows($ProductID, $CurrencyID = null) {
		$where_sql = "";
		if ($CurrencyID !== null)
			$where_sql = " AND currency_id = '" . intval($CurrencyID) . "'";

		$query =	"	DELETE FROM	product_price " .
					"	WHERE		product_id = '" . intval($ProductID) . "'" . $where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	product_price_level " .
					"	WHERE		product_id = '" . intval($ProductID) . "'" . $where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}