<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class inventory {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetProductStockList($SiteID, $LanguageID, &$TotalProducts, $PageNo = 1, $ProductsPerPage = 20, $ProductQuantityThreshold = 999999) {
		$Offset = intval(($PageNo -1) * $ProductsPerPage);

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, P.*, O.* " .
					"	FROM	object O	JOIN		product P				ON	(P.product_id = O.object_id) " .
					"						JOIN		object_link OL			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN		object PTO				ON	(PTO.object_id = OL.parent_object_id AND PTO.object_type != 'PRODUCT_SPECIAL_CATEGORY') " .
					"						LEFT JOIN	product_option PO		ON	(P.product_id = PO.product_id) " .
					"						LEFT JOIN	product_option_data POD	ON	(PO.product_option_id = POD.product_option_id AND POD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	O.site_id = '" . intval($SiteID) . "'" .
					"		AND	(		(PO.product_option_id IS NULL 		AND P.product_stock_level < '" . intval($ProductQuantityThreshold) . "' ) " .
					"				OR	(PO.product_option_id IS NOT NULL	AND PO.product_option_stock_level < '" . intval($ProductQuantityThreshold) . "' ) " .
					"			)" .
					"	ORDER BY P.product_id ASC " .
					"	LIMIT	" . $Offset . ", " . intval($ProductsPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalProducts = $myResult[0];

		$Products = array();
		while ($myResult = $result->fetch_assoc())
			array_push($Products, $myResult);
		return $Products;
	}

	public static function GetProductStockListWithStockInOutCartInfo($SiteID, $StockInOutCartID, $LanguageID, &$TotalProducts, $PageNo = 1, $ProductsPerPage = 20, $StockLevelMin = -999999, $StockLevelMax = 999999, $ParentObjID, $ProductID, $ProductCode, $ProductRefName) {
		$Offset = intval(($PageNo -1) * $ProductsPerPage);

		$sql = '';
		if (intval($ParentObjID) != 0)
			$sql = $sql . "	AND PTO.object_id = '" . intval($ParentObjID) . "' ";
		if (intval($ProductID) != 0)
			$sql = $sql . "	AND P.product_id = '" . intval($ProductID) . "' ";
		if (trim($ProductCode) != '')
			$sql = $sql . "	AND P.product_code LIKE '%" . aveEscT($ProductCode) . "%' ";
		if (trim($ProductRefName) != '')
			$sql = $sql . "	AND OL.object_name LIKE '%" . aveEscT($ProductRefName) . "%' ";
		if (strlen(trim($StockLevelMin)) > 0)
			$sql = $sql . 
					"		AND	(		(PO.product_option_id IS NULL		AND P.product_stock_level >= '" . intval($StockLevelMin) . "' ) " .
					"				OR	(PO.product_option_id IS NOT NULL	AND PO.product_option_stock_level >= '" . intval($StockLevelMin) . "' ) " .
					"			)";
		if (strlen(trim($StockLevelMax)) > 0)
			$sql = $sql . 
					"		AND	(		(PO.product_option_id IS NULL		AND P.product_stock_level <= '" . intval($StockLevelMax) . "' ) " .
					"				OR	(PO.product_option_id IS NOT NULL	AND PO.product_option_stock_level <= '" . intval($StockLevelMax) . "' ) " .
					"			)";

		$StockInOutCart = inventory::GetStockInOutCartProducts($StockInOutCartID, 0);
		$StockInOutCartQuantity = array();
		foreach ($StockInOutCart as $C) {
			$StockInOutCartQuantity[intval($C['product_id'])][intval($C['product_option_id'])] = $C['product_quantity'];
		}

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, POL.object_name AS parent_object_ref_name, P.*, O.*, OL.* " .
					"	FROM	object O	JOIN		product P						ON	(P.product_id = O.object_id) " .
					"						JOIN		object_link OL					ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN		object PTO						ON	(PTO.object_id = OL.parent_object_id AND PTO.object_type != 'PRODUCT_SPECIAL_CATEGORY') " .
					"						JOIN		object_link POL					ON	(POL.object_id = PTO.object_id AND POL.object_link_is_shadow = 'N') " .
					"						JOIN		object PPO						ON	(PPO.object_id = POL.parent_object_id) " .
					"						LEFT JOIN	product_category PC				ON	(OL.parent_object_id = PC.product_category_id) " . 
					"						LEFT JOIN	product_option PO				ON	(P.product_id = PO.product_id ) " .
					"						LEFT JOIN	product_option_data POD			ON	(PO.product_option_id = POD.product_option_id AND POD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	O.site_id = '" . intval($SiteID) . "'" .
					"		AND (PTO.object_type = 'PRODUCT_CATEGORY' OR (PTO.object_type = 'PRODUCT_ROOT' AND PPO.object_type = 'LIBRARY_ROOT') ) " . $sql .
					"	GROUP BY P.product_id " .
					"	ORDER BY P.product_id ASC " .
					"	LIMIT	" . $Offset . ", " . intval($ProductsPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalProducts = $myResult[0];

		$Products = array();
		while ($myResult = $result->fetch_assoc()) {
			$myResult['product_quantity'] = intval($StockInOutCartQuantity[intval($myResult['product_id'])][intval($myResult['product_option_id'])]);
			array_push($Products, $myResult);
		}
		return $Products;
	}

	public static function IsProductUnderStock($Site, $ProductID, $ProductOptionID, $Quantity) {
		if ($Site['site_module_inventory_enable'] == 'Y') {
			$query =	"	SELECT		* " .
						"	FROM		product P		JOIN object O					ON	(O.object_id = P.product_id AND P.product_id = '" . intval($ProductID) . "') " .
						"								LEFT JOIN product_option PO		ON	(P.product_id = PO.product_id AND PO.product_option_id = '" . intval($ProductOptionID) . "') " .
						"	WHERE		(PO.product_option_id IS NULL		AND P.product_stock_level < " . intval($Quantity) . " ) " .
						"			OR	(PO.product_option_id IS NOT NULL	AND PO.product_option_stock_level < " . intval($Quantity) . " ) ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			if ($result->num_rows > 0)
				return true;
			else
				return false;
		}
		else
			return false;
	}

	public static function FixCartWithInventoryLevel($Site, $UserID, &$QuantityAdjustedCartContentIDArray = null ) {
		$query =	"	SELECT		PO.*, P.*, O.*, W.* " .
					"	FROM		cart_content W	JOIN product P					ON	(W.user_id = '" . intval($UserID) . "' AND P.product_id = W.product_id) " .
					"								JOIN object O					ON	(O.object_id = P.product_id) " .
					"								LEFT JOIN product_option PO		ON	(W.product_option_id = PO.product_option_id) ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$UnderStockAdjustment = false;

		while ($myResult = $result->fetch_assoc()) {
			if ($myResult['object_is_enable'] != 'Y') {
				$query =	"	DELETE FROM cart_content " .
							"	WHERE	product_id = '" . intval($myResult['product_id']) . "'";
				$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
			elseif (intval($myResult['product_option_id']) == 0 && intval($myResult['product_stock_level']) < intval($myResult['quantity'])) {
				if (intval($myResult['product_stock_level']) <= 0) {
					$query =	"	DELETE FROM	cart_content " .
								"	WHERE		product_id = '" . intval($myResult['product_id']) . "'";
					$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);

					$UnderStockAdjustment = true;

					if ($QuantityAdjustedCartContentIDArray !== null)
						array_push($QuantityAdjustedCartContentIDArray, $myResult['cart_content_id']);
				}
				else {
					$query =	"	UPDATE	cart_content " .
								"	SET		quantity = '" . intval($myResult['product_stock_level']) . "'" .
								"	WHERE	product_id = '" . intval($myResult['product_id']) . "'" .
								"		AND user_id = '" . intval($UserID) . "'";
					$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
					$UnderStockAdjustment = true;

					if ($QuantityAdjustedCartContentIDArray !== null)
						array_push($QuantityAdjustedCartContentIDArray, $myResult['cart_content_id']);
				}
			}
			elseif (intval($myResult['product_option_id']) != 0 && intval($myResult['product_option_stock_level']) < intval($myResult['quantity'])) {
				if (intval($myResult['product_option_stock_level']) <= 0) {
					$query =	"	DELETE FROM	cart_content " .
								"	WHERE	product_id = '" . intval($myResult['product_id']) . "'" . 
								"		AND product_option_id = '" . intval($myResult['product_option_id']) . "'";
					$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
					$UnderStockAdjustment = true;

					if ($QuantityAdjustedCartContentIDArray !== null)
						array_push($QuantityAdjustedCartContentIDArray, $myResult['cart_content_id']);
				}
				else {
					$query =	"	UPDATE	cart_content " .
								"	SET		quantity = '" . intval($myResult['product_option_stock_level']) . "'" .
								"	WHERE	product_id = '" . intval($myResult['product_id']) . "'" . 
								"		AND product_option_id = '" . intval($myResult['product_option_id']) . "'" .
								"		AND user_id = '" . intval($UserID) . "'";
					$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
					$UnderStockAdjustment = true;

					if ($QuantityAdjustedCartContentIDArray !== null)
						array_push($QuantityAdjustedCartContentIDArray, $myResult['cart_content_id']);
				}
			}
		}

		return $UnderStockAdjustment;
	}

	public static function IsCartUnderStock($Site, $UserID) {
		if ($Site['site_module_inventory_enable'] == 'Y') {
			$query =	"	SELECT		*, W.*, SUM(W.quantity) AS total_quantity " .
						"	FROM		cart_content W	JOIN product P					ON	(W.user_id = '" . intval($UserID) . "' AND P.product_id = W.product_id) " .
						"								JOIN object O					ON	(O.object_id = P.product_id) " .
						"								LEFT JOIN product_option PO		ON	(W.product_option_id = PO.product_option_id) " .
						"	WHERE		O.object_is_enable = 'Y' " .
						"	GROUP BY	W.product_id, W.product_option_id ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			while ($myResult = $result->fetch_assoc()) {
				if ($myResult['product_option_id'] == 0 && $myResult['product_stock_level'] < $myResult['total_quantity'])
					return true;
				else if ($myResult['product_option_id'] != 0 && $myResult['product_option_stock_level'] < $myResult['total_quantity'])
					return true;
			}

			return false;
		}
		else
			return false;
	}

	public static function IsMyOrderUnderStock($Site, $MyOrderID) {
		if ($Site['site_module_inventory_enable'] == 'Y') {

			if (inventory::IsStockHoldForMyOrder($MyOrderID))
				return false;

			$query =	"	SELECT		*, M.*, SUM(M.quantity) AS total_quantity  " .
						"	FROM		myorder_product M	JOIN product P					ON	(M.myorder_id = '" . intval($MyOrderID) . "' AND P.product_id = M.product_id) " .
						"									JOIN object O					ON	(O.object_id = P.product_id) " .
						"									LEFT JOIN product_option PO		ON	(M.product_option_id = PO.product_option_id) " .
						"	WHERE		O.object_is_enable = 'Y' " .
						"	GROUP BY	M.product_id, M.product_option_id ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			while ($myResult = $result->fetch_assoc()) {
				if ($myResult['product_option_id'] == 0 && $myResult['product_stock_level'] < $myResult['total_quantity'])
					return true;
				else if ($myResult['product_option_id'] != 0 && $myResult['product_option_stock_level'] < $myResult['total_quantity'])
					return true;
			}

			return false;
		}
		else
			return false;
	}

	public static function IsStockHoldForMyOrder($MyOrderID) {
		$query =	"	SELECT	* " .
					"	FROM	stock_transaction " .
					"	WHERE	myorder_id = '" . intval($MyOrderID) . "' " .
					"		AND	stock_transaction_type	= 'STOCK_HOLD' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return true;
		else
			return false;
	}

	public static function HoldStockForMyOrder($SiteID, $MyOrderID) {
		inventory::UnholdStockForMyOrder($MyOrderID);

		$query =	"	INSERT INTO	stock_transaction" .
					"	SET		site_id					= '" . intval($SiteID) . "', " .
					"			stock_transaction_type	= 'STOCK_HOLD', " .
					"			stock_transaction_date	= NOW(), " .
					"			stock_shipment_id 		= 0, " .
					"			myorder_id 				= '" . intval($MyOrderID) . "', " .
					"			stock_in_out_id 			= 0 ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$StockTransactionID = customdb::mysqli()->insert_id;

		$query =	"	SELECT		* " .
					"	FROM		myorder_product " .
					"	WHERE		myorder_id = '" . intval($MyOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			$query =	"	INSERT INTO	stock_transaction_product " .
						"	SET		stock_transaction_id	= '" . intval($StockTransactionID) . "', " .
						"			product_id				= '" . intval($myResult['product_id']) . "', " .
						"			product_option_id 		= '" . intval($myResult['product_option_id']) . "', " .
						"			product_quantity		= '-" . intval($myResult['quantity']) . "'" .
						"	ON DUPLICATE KEY UPDATE product_quantity = product_quantity - '" . intval($myResult['quantity']) . "'";
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);

			inventory::UpdateProductStockLevel($myResult['product_id'], $myResult['product_option_id']);
		}
	}

	public static function GetStockHoldTransactionInfoForMyOrder($MyOrderID) {
		$query =	"	SELECT	* " .
					"	FROM	stock_transaction " .
					"	WHERE	stock_transaction_type = 'STOCK_HOLD' " .
					"		AND	myorder_id	= '" . intval($MyOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function UnholdStockForMyOrder($MyOrderID) {
		$StockHoldTransaction = inventory::GetStockHoldTransactionInfoForMyOrder($MyOrderID);
		if ($StockHoldTransaction != null)
			inventory::DeleteStockTransaction($StockHoldTransaction['stock_transaction_id']);
	}

	public static function UpdateProductStockLevel($ProductID, $ProductOptionID = 0) {
		if ($ProductOptionID == 0) {
			$query =	"	UPDATE	product " .
						"	SET		product_stock_level = (" .
						"									SELECT	SUM(product_quantity) " .
						"									FROM	stock_transaction_product	" .
						"									WHERE	product_id = '" . intval($ProductID) . "'" .
						"										AND	product_option_id = 0 " .
						"								)" .
						"	WHERE	product_id = '" . intval($ProductID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else {
			$query =	"	UPDATE	product_option " .
						"	SET		product_option_stock_level = (" .
						"											SELECT	SUM(product_quantity) " .
						"											FROM	stock_transaction_product	" .
						"											WHERE	product_id = '" . intval($ProductID) . "'" .
						"												AND	product_option_id = '" . intval($ProductOptionID) . "'" .
						"										)" .
						"	WHERE	product_id = '" . intval($ProductID) . "'" .
						"		AND	product_option_id = '" . intval($ProductOptionID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function GetProductStockTransactionList($ProductID, $ProductOptionID, &$TotalTransactions, $PageNo = 1, $TransactionsPerPage = 20) {
		$Offset = intval(($PageNo -1) * $TransactionsPerPage);

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS * " .
					"	FROM	stock_transaction ST JOIN stock_transaction_product STP ON	(ST.stock_transaction_id = STP.stock_transaction_id) " .
					"									LEFT JOIN	stock_in_out IO		ON	(ST.stock_in_out_id		= IO.stock_in_out_id) " .
					"									LEFT JOIN	myorder O			ON	(ST.myorder_id			= O.myorder_id) " .						
					"	WHERE	STP.product_id = '" . intval($ProductID) . "' " .
					"		AND	STP.product_option_id = '" . intval($ProductOptionID) . "' " .
					"	ORDER BY ST.stock_transaction_date DESC " .
					"	LIMIT	" . $Offset . ", " . intval($TransactionsPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalTransactions = $myResult[0];

		$ProductStockTransactionList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ProductStockTransactionList, $myResult);
		}
		return $ProductStockTransactionList;
	}

	public static function TouchStockInOutCart($SiteID, $ContentAdminID, $SystemAdminID) {
		$query =	"	INSERT INTO stock_in_out_cart_details " .
					"	SET	site_id				= '" . intval($SiteID) . "', " .
					"		system_admin_id		= '" . intval($SystemAdminID) . "', " .
					"		content_admin_id	= '" . intval($ContentAdminID) . "', " .
					"		stock_in_out_date	= NOW() " .
					"	ON DUPLICATE KEY UPDATE site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function EmptyStockInOutCart($StockInOutCartID) {
		$query =	"	DELETE FROM stock_in_out_cart_content " .
					"	WHERE	stock_in_out_cart_id = '" . intval($StockInOutCartID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetStockInOutCartInfo($SiteID, $ContentAdminID, $SystemAdminID) {
		$query =	"	SELECT	* " .
					"	FROM	stock_in_out_cart_details " .
					"	WHERE	site_id				= '" . intval($SiteID) . "' " .
					"		AND	system_admin_id		= '" . intval($SystemAdminID) . "'" .
					"		AND	content_admin_id	= '" . intval($ContentAdminID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;			
	}

	public static function GetStockInOutCartProducts($StockInOutCartID, $LanguageID = 0) {
		$query =	"	SELECT	*, P.*, C.*, O.* " .
					"	FROM	object O	JOIN	product P						ON	(P.product_id = O.object_id) " .
					"						JOIN	object_link OL					ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN	object PTO						ON	(PTO.object_id = OL.parent_object_id AND PTO.object_type != 'PRODUCT_SPECIAL_CATEGORY') " .	
					"						JOIN	stock_in_out_cart_content C		ON	(P.product_id = C.product_id) " .
					"					LEFT JOIN	product_option PO				ON	(P.product_id = PO.product_id AND PO.product_option_id = C.product_option_id) " .
					"					LEFT JOIN	product_option_data POD			ON	(PO.product_option_id = POD.product_option_id AND POD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	C.stock_in_out_cart_id = '" . intval($StockInOutCartID) . "'" .
					"	GROUP BY P.product_id, PO.product_option_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$StockInOutCartProducts = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($StockInOutCartProducts, $myResult);
		}
		return $StockInOutCartProducts;
	}

	public static function AddToStockInOutCart($StockInOutCartID, $ProductID, $ProductOptionID, $Quantity) {
		if (intval($Quantity) == 0) {
			$query =	"	DELETE FROM stock_in_out_cart_content " .
						"	WHERE		stock_in_out_cart_id	= '" . intval($StockInOutCartID) . "' " .
						"			AND	product_id				= '" . intval($ProductID) . "' " .
						"			AND	product_option_id		= '" . intval($ProductOptionID) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else {
			$query =	"	INSERT INTO stock_in_out_cart_content " .
						"	SET	stock_in_out_cart_id	= '" . intval($StockInOutCartID) . "', " .
						"		product_id				= '" . intval($ProductID) . "', " .
						"		product_option_id		= '" . intval($ProductOptionID) . "', " .
						"		product_quantity		= '" . intval($Quantity) . "'" .
						"	ON DUPLICATE KEY UPDATE product_quantity = '" . intval($Quantity) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function GetStockTransactionList($SiteID, &$TotalTransactions, $PageNo = 1, $TransactionsPerPage = 20, $TransactionType = 'all', $ShopID = false) {
		$Offset = intval(($PageNo -1) * $TransactionsPerPage);

		$sql = '';
		if ($TransactionType != 'all')
			$sql =	"	AND	T.stock_transaction_type = '" . aveEscT($TransactionType) . "'";
		if ($ShopID !== false)
			$sql = $sql . "	AND O.shop_id = '" . intval($ShopID) . "' ";

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, T.* " .
					"	FROM	stock_transaction T		LEFT JOIN	stock_shipment S	ON	(T.stock_shipment_id	= S.stock_shipment_id) " .
					"									LEFT JOIN	stock_in_out IO		ON	(T.stock_in_out_id		= IO.stock_in_out_id) " .
					"									LEFT JOIN	myorder O			ON	(T.myorder_id			= O.myorder_id) " .
					"	WHERE	T.site_id = '" . intval($SiteID) . "' " . $sql .
					"	ORDER BY T.stock_transaction_date DESC " .
					"	LIMIT	" . $Offset . ", " . intval($TransactionsPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalTransactions = $myResult[0];

		$StockTransactionList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($StockTransactionList, $myResult);
		}
		return $StockTransactionList;
	}

	public static function GetStockTransactionInfo($StockTransactionID) {
		$query =	"	SELECT	*, T.* " .
					"	FROM	stock_transaction T		LEFT JOIN	stock_shipment S	ON	(T.stock_shipment_id	= S.stock_shipment_id) " .
					"									LEFT JOIN	stock_in_out IO		ON	(T.stock_in_out_id		= IO.stock_in_out_id) " .
					"									LEFT JOIN	myorder O			ON	(T.myorder_id			= O.myorder_id) " .
					"	WHERE	T.stock_transaction_id = '" . intval($StockTransactionID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetStockTransactionProducts($StockTransactionID, $LanguageID = 0) {
		$query =	"	SELECT	*, PD.*, P.*, STP.*, O.* " .
					"	FROM	object O	JOIN	product P						ON	(P.product_id = O.object_id) " .
					"						JOIN	object_link OL					ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"						JOIN	object PTO						ON	(PTO.object_id = OL.parent_object_id AND PTO.object_type != 'PRODUCT_SPECIAL_CATEGORY') " .	
					"						JOIN	stock_transaction_product STP	ON	(P.product_id = STP.product_id) " .
					"					LEFT JOIN	product_option PO				ON	(P.product_id = PO.product_id AND PO.product_option_id = STP.product_option_id) " .
					"					LEFT JOIN	product_option_data POD			ON	(PO.product_option_id = POD.product_option_id AND POD.language_id = '" . intval($LanguageID) . "') " .
					"					LEFT JOIN	product_data PD					ON	(PD.product_id = P.product_id AND PD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	STP.stock_transaction_id = '" . intval($StockTransactionID) . "'" .
					"	GROUP BY P.product_id, PO.product_option_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$StockTransactionProducts = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($StockTransactionProducts, $myResult);
		}
		return $StockTransactionProducts;
	}

	public static function DeleteStockTransaction($StockTransactionID) {
		$query =	"	SELECT	*, T.* " .
					"	FROM	stock_transaction T		LEFT JOIN	stock_shipment S	ON	(T.stock_shipment_id	= S.stock_shipment_id) " .
					"									LEFT JOIN	stock_in_out IO		ON	(T.stock_in_out_id		= IO.stock_in_out_id) " .
					"	WHERE	T.stock_transaction_id = '" . intval($StockTransactionID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$StockTransaction = null;

		if ($result->num_rows > 0)
			$StockTransaction = $result->fetch_assoc();
		else
			return;

		$StockTransactionProducts = inventory::GetStockTransactionProducts($StockTransactionID, 0);

		if ($StockTransaction['stock_transaction_type'] == 'STOCK_IN' || $StockTransaction['stock_transaction_type'] == 'ADJUSTMENT') {
			$query =	"	DELETE FROM	stock_in_out " .
						"	WHERE	stock_in_out_id = '" . intval($StockTransaction['stock_in_out_id']) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query =	"	DELETE FROM	stock_transaction " .
						"	WHERE	stock_transaction_id = '" . intval($StockTransaction['stock_transaction_id']) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		elseif ($StockTransaction['stock_transaction_type'] == 'SHIPMENT') {
			$query =	"	DELETE FROM	stock_shipment " .
						"	WHERE	stock_shipment_id = '" . intval($StockTransaction['stock_shipment_id']) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query =	"	DELETE FROM	stock_transaction " .
						"	WHERE	stock_transaction_id = '" . intval($StockTransaction['stock_transaction_id']) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		elseif ($StockTransaction['stock_transaction_type'] == 'STOCK_HOLD') {
			$query =	"	DELETE FROM	stock_transaction " .
						"	WHERE	stock_transaction_id = '" . intval($StockTransaction['stock_transaction_id']) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		$query =	"	DELETE FROM	stock_transaction_product " .
					"	WHERE	stock_transaction_id = '" . intval($StockTransaction['stock_transaction_id']) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		foreach ($StockTransactionProducts as $P) {
			inventory::UpdateProductStockLevel($P['product_id'], $P['product_option_id']);
		}
	}

	public static function GetMyOrderShipmentList($MyOrderID) {
		$query =	"	SELECT	*, T.* " .
					"	FROM	stock_transaction T		JOIN	stock_shipment S	ON	(T.stock_shipment_id	= S.stock_shipment_id) " .
					"	WHERE	S.myorder_id	= '" . intval($MyOrderID) . "' " .
					"	ORDER BY T.stock_transaction_date DESC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ShipmentList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($ShipmentList, $myResult);
		}
		return $ShipmentList;
	}

	public static function GetShipmentInfoXML($StockTransactionID, $LanguageID) {
		$smarty = new mySmarty();

		$Shipment = inventory::GetStockTransactionInfo($StockTransactionID);
		$ShipmentProducts = inventory::GetStockTransactionProducts($StockTransactionID, $LanguageID);

		$ShipmentProductsXML = '';
		foreach ($ShipmentProducts as $O) {
			$smarty->assign('Object', $O);
			$ShipmentProductsXML .= $smarty->fetch('api/object_info/SHIPMENT_PRODUCT.tpl');
		}
		$smarty->assign('ShipmentProductsXML', $ShipmentProductsXML);

		$smarty->assign('Object', $Shipment);
		$ShipmentXML = $smarty->fetch('api/object_info/SHIPMENT.tpl');

		return $ShipmentXML;			
	}

	public static function GetMyOrderShipmentListXML($MyOrderID, $LanguageID = 1, $WithShipmentProduct = 'Y') {
		$smarty = new mySmarty();

		$ShipmentListXML = '';
		$ShipmentList = inventory::GetMyOrderShipmentList($MyOrderID);
		foreach ($ShipmentList as $O) {
			if ($WithShipmentProduct == 'Y') {
				$ShipmentListXML .= inventory::GetShipmentInfoXML($O['stock_transaction_id'], $LanguageID);			
			}
			else {
				$smarty->assign('Object', $O);
				$ShipmentListXML .= $smarty->fetch('api/object_info/SHIPMENT.tpl');
			}
		}
		$smarty->assign('ShipmentListXML', $ShipmentListXML);

		return $ShipmentListXML;
	}
}