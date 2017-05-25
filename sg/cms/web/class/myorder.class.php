<?php

if (!defined('IN_CMS'))
	die("huh?");

class myorder {
	
	private $myorder_id;
	/* @var $_MyOrderDetailsObj myorder_details */
	public $_MyOrderDetailsObj = null; 
	
	private $_SiteObj = null;
	private $_SiteArray = null;
	private function getSiteObj() {
		if ($this->_SiteObj == null) {
			$this->_SiteArray = site::GetSiteInfo($this->getMyOrderDetailsObj()->site_id);
			$this->_SiteObj = (object) $this->_SiteArray;
		}
		return $this->_SiteObj;
	}
	private function getSiteArray() {
		if ($this->_SiteArray == null) {
			$this->_SiteArray = site::GetSiteInfo($this->getMyOrderDetailsObj()->site_id);
			$this->_SiteObj = (object) $this->_SiteArray;
		}
		return $this->_SiteArray;
	}	
	
	public function myorder($MyOrderID) {
		$this->myorder_id = $MyOrderID;
	}

	/**
	 * 
	 * @return myorder_details
	 */
	public function getMyOrderDetailsObj() {
		if ($this->_MyOrderDetailsObj == null) {
			$query =	"	SELECT	* " .
						"	FROM	myorder	M 	JOIN currency C ON (C.currency_id = M.currency_id) " .
						"	WHERE	M.myorder_id = '" . $this->myorder_id . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			if ($result->num_rows > 0) {
				$this->_MyOrderDetailsObj = $result->fetch_object('myorder_details');

				$DeletableStatus = array('awaiting_freight_quote', 'awaiting_order_confirmation', 'order_cancelled', 'payment_pending');
				$VoidableStatus = array('payment_confirmed', 'partial_shipped', 'shipped', 'payment_pending');
		
				$this->_MyOrderDetailsObj->order_can_delete = in_array($this->_MyOrderDetailsObj->order_status, $DeletableStatus);
				$this->_MyOrderDetailsObj->order_can_void = in_array($this->_MyOrderDetailsObj->order_status, $VoidableStatus);
			}
		}
		
		return $this->_MyOrderDetailsObj;
	}
	
	public function RefreshMyOrderDetailsObj() {
		$this->_MyOrderDetailsObj = null;
	}
	
	private function UpdateNextSerial() {
		// Must re-read to get latest value
		$this->_SiteArray = null;
		$this->_SiteObj = null;
		
		if ($this->ShouldResetSerialNo($this->getSiteObj()->site_order_serial_reset_type, $this->getSiteObj()->site_order_serial_next_reset_date)) {
			
			$NextResetDate = $this->GenerateNextResetDate($this->getSiteObj()->site_order_serial_reset_type, $this->getSiteObj()->site_order_serial_next_reset_date);

			$query  =	" 	UPDATE	site " .
						"	SET		site_order_serial_next_reset_date = '" . aveEscT($NextResetDate) . "', " .
						"			site_next_order_serial = 1 " .
						"	WHERE	site_id = '" . $this->getSiteObj()->site_id . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			
			$this->_SiteArray = null;
			$this->_SiteObj = null;
		}

		if ($this->ShouldResetSerialNo($this->getSiteObj()->site_redeem_serial_reset_type, $this->getSiteObj()->site_redeem_serial_next_reset_date)) {
			$NextResetDate = $this->GenerateNextResetDate($this->getSiteObj()->site_redeem_serial_reset_type, $this->getSiteObj()->site_redeem_serial_next_reset_date);

			$query  =	" 	UPDATE	site " .
						"	SET		site_redeem_serial_next_reset_date = '" . aveEscT($NextResetDate) . "', " .
						"			site_next_redeem_serial = 1 " .
						"	WHERE	site_id = '" . $this->getSiteObj()->site_id . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$this->_SiteArray = null;
			$this->_SiteObj = null;
		}
	}

//		public static function UpdateOrderNo($MyOrderID, $SiteID, $IgnoreProducts = 'N', $IgnoreBonusPointItems = 'N') {
	public function UpdateOrderNo() {

		$LockName = "UpdateOrderNoSiteID" . strval($this->getMyOrderDetailsObj()->site_id);
		
		$MyLock = new mylock($LockName);
		$MyLock->acquireLock(true);
		
		$this->UpdateNextSerial();
		
		$OrderSerial = $this->getSiteObj()->site_next_order_serial;
		$RedeemSerial = $this->getSiteObj()->site_next_redeem_serial;
		
		if ($this->getMyOrderDetailsObj()->order_content_type == 'normal') {
			$OrderNo = $this->GetNextFormatNo($this->getSiteObj()->site_order_no_format, $OrderSerial);

			$query  =	" 	UPDATE	myorder " .
						"	SET		order_no = '" . aveEscT($OrderNo) . "'" .
						"	WHERE	myorder_id = '" . $this->myorder_id . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query  =	" 	UPDATE	site " .
						"	SET		site_next_order_serial = '" . intval(++$OrderSerial) . "'" .
						"	WHERE	site_id = '" . $this->getSiteObj()->site_id . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			
			$this->_SiteArray = null;
			$this->_SiteObj = null;
			$this->_MyOrderDetailsObj = null;
		}
		elseif ($this->getMyOrderDetailsObj()->order_content_type == 'bonus_point') {
			$RedeemNo = $this->GetNextFormatNo($this->getSiteObj()->site_redeem_no_format, $RedeemSerial);

			$query  =	" 	UPDATE	myorder " .
						"	SET		order_no = '" . aveEscT($RedeemNo) . "'" .
						"	WHERE	myorder_id = '" . $this->myorder_id . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query  =	" 	UPDATE	site " .
						"	SET		site_next_redeem_serial = '" . intval(++$RedeemSerial) . "'" .
						"	WHERE	site_id = '" . $this->getSiteObj()->site_id . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$this->_SiteArray = null;
			$this->_SiteObj = null;
			$this->_MyOrderDetailsObj = null;
		}

		unset($MyLock);
	}

	private function GetNextFormatNo($FormatText = "{SN0}", $NextNo = 1, $TimestampNow = NULL) {
		if ($TimestampNow == NULL)
			$TimestampNow = time();

		$FormatText = str_replace("{SN0}", $NextNo, $FormatText);
		$FormatText = str_replace("{SN1}", str_pad($NextNo, 1, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN2}", str_pad($NextNo, 2, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN3}", str_pad($NextNo, 3, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN4}", str_pad($NextNo, 4, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN5}", str_pad($NextNo, 5, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN6}", str_pad($NextNo, 6, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN7}", str_pad($NextNo, 7, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN8}", str_pad($NextNo, 8, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN9}", str_pad($NextNo, 9, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{SN10}", str_pad($NextNo, 10, '0', STR_PAD_LEFT), $FormatText);
		$FormatText = str_replace("{Y}", date('Y', $TimestampNow), $FormatText);
		$FormatText = str_replace("{y}", date('y', $TimestampNow), $FormatText);
		$FormatText = str_replace("{n}", date('n', $TimestampNow), $FormatText);
		$FormatText = str_replace("{m}", date('m', $TimestampNow), $FormatText);
		$FormatText = str_replace("{d}", date('d', $TimestampNow), $FormatText);
		$FormatText = str_replace("{j}", date('j', $TimestampNow), $FormatText);

		return $FormatText;
	}

	private function GenerateNextResetDate($SiteSerialResetType, $LastResetDate = '', $TimestampNow = NULL) {
		if ($TimestampNow == NULL)
			$TimestampNow = time();

		if ($SiteSerialResetType == 'no_reset')
			return '0000-00-00';
		else if ($SiteSerialResetType == 'monthly') {
			$Year = date("Y", $TimestampNow);
			$Month = date("m", $TimestampNow);				
			$NextMonthTS = mktime(0, 0, 0, $Month + 1, 1, $Year);

			return date("Y-m-d", $NextMonthTS);
		}
		else if ($SiteSerialResetType == 'yearly') {
			$Year = date("Y", $TimestampNow);
			$NextYearTS = mktime(0, 0, 0, 1, 1, $Year + 1);
			return date("Y-m-d", $NextYearTS);
		}
		else if ($SiteSerialResetType == 'absolute_year') {
			if ($LastResetDate == '0000-00-00')
				$LastResetDate = '1980-01-01';

			$Year = date("Y", $TimestampNow);
			$Month = date("m", strtotime($LastResetDate));
			$Day = date("d", strtotime($LastResetDate));

			if ($Month == 2 && $Day == 29)
				$Day = 28;

			$NextYearTS = mktime(0, 0, 0, $Month, $Day, $Year + 1);
			return date("Y-m-d", $NextYearTS);
		}			
	}

	private function ShouldResetSerialNo($SiteSerialResetType, $SiteNextResetDate, $TimestampNow = NULL) {
		if ($SiteSerialResetType == 'no_reset')
			return false;

		if ($TimestampNow == NULL)
			$TimestampNow = time();

		$NextResetTS = strtotime($SiteNextResetDate);

		if ($TimestampNow > $NextResetTS)
			return true;
	}
	
	public function UpdateMyOrderProductQuantitySold() {
		$query =	"	SELECT		* " .
					"	FROM		myorder_product " .
					"	WHERE		myorder_id = '" . $this->myorder_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			product::UpdateProductQuantitySold($myResult['product_id'], $myResult['product_option_id']);
		}
	}

	public function GetMyOrderXML($LanguageID, $IncludeProductDetails = 'N') {
		$smarty = new mySmarty();

		$MyOrderProductsXML = '';
		$MyOrderBonusPointItemsXML = '';
		$TotalPrice = 0;
		$TotalPriceCA = 0;
		$TotalCash = 0;
		$TotalCashCA = 0;
		$TotalBonusPoint = 0;
		$TotalBonusPointRequired = 0;

		$MyOrderItemList = $this->GetMyOrderItemList($LanguageID);
		foreach ($MyOrderItemList as $O) {
			if ($IncludeProductDetails == 'Y') {
				$TotalNoOfMedia = 0;

				$MediaListXML = media::GetMediaListXML($O['product_id'], $LanguageID, $TotalNoOfMedia, 1, NUM_OF_PHOTOS_PER_PAGE);
				$smarty->assign('MediaListXML', $MediaListXML);
				$smarty->assign('TotalNoOfMedia', $TotalNoOfMedia);
				$smarty->assign('MediaPageNo', 1);
			}

			$O['object_seo_url'] = object::GetSeoURL($O, '', $LanguageID, $this->getSiteArray());
			$smarty->assign('Object', $O);

			$MyOrderProductsXML .= $smarty->fetch('api/object_info/MYORDER_PRODUCT.tpl');
		}
		$smarty->assign('MyOrderProductsXML', $MyOrderProductsXML);

		$MyOrderBonusPointItemList = $this->GetMyOrderBonusPointItemList($LanguageID);
		foreach ($MyOrderBonusPointItemList as $O) {
			$O['object_seo_url'] = object::GetSeoURL($O, '', $LanguageID, $this->getSiteArray());
			$smarty->assign('Object', $O);
			$MyOrderBonusPointItemsXML .= $smarty->fetch('api/object_info/MYORDER_BONUS_POINT_ITEM.tpl');
		}
		$smarty->assign('MyOrderBonusPointItemsXML', $MyOrderBonusPointItemsXML);

		$smarty->assign('MyOrderObj', $this->getMyOrderDetailsObj());
		$MyOrderXML = $smarty->fetch('api/object_info/MYORDER.tpl');

		return $MyOrderXML;
	}
	
	public function GetMyOrderItemList($LanguageID) {
		$ParentObjTypeToIgnore = array('PRODUCT_BRAND');
		$sql_to_ignore = '';
		foreach ($ParentObjTypeToIgnore as $T)
			$sql_to_ignore = $sql_to_ignore . " AND TPO.object_type != '" . aveEscT($T) . "'";

		$query =	"	SELECT		*, L.*, P.*, OL.*, O.*, C.*, M.* " .
					"	FROM		language L	JOIN myorder_product M	ON ( M.myorder_id = '" . $this->myorder_id . "')" .
					"							JOIN currency C ON (C.currency_id = M.currency_id) " .
					"							JOIN product P	ON (P.product_id = M.product_id AND L.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN object O	ON (O.object_id = P.product_id) " .
					"							JOIN ( SELECT TOL.* FROM object_link TOL JOIN object TPO ON (TOL.parent_object_id = TPO.object_id " . $sql_to_ignore . ") WHERE TOL.object_link_is_shadow = 'N' GROUP BY TOL.object_id) OL ON (O.object_id = OL.object_id) " .
					"							LEFT JOIN product_data D ON (D.language_id = L.language_id AND P.product_id = D.product_id) " .
					"							LEFT JOIN product_option_data POD ON (POD.language_id = L.language_id AND POD.product_option_id = M.product_option_id) " .
					"	ORDER BY	P.product_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$MyOrderItemList = array();

		while ($myResult = $result->fetch_assoc()) {
			if ($myResult['effective_discount_preprocess_rule_id'] > 0) {
				$PreprocessRule = discount::GetPreprocessRuleInfo($myResult['effective_discount_preprocess_rule_id'], $LanguageID);
				$myResult['effective_discount_preprocess_rule_name'] = $PreprocessRule['discount_preprocess_rule_name'];
			}
			else if ($myResult['effective_discount_bundle_rule_id'] > 0) {
				$BundleRule = discount::GetBundleRuleInfo($myResult['effective_discount_bundle_rule_id'], $LanguageID);
				$myResult['effective_discount_bundle_rule_name'] = $BundleRule['discount_bundle_rule_name'];
			}
			
			array_push($MyOrderItemList, $myResult);
		}
		return $MyOrderItemList;
	}
	
	public function GetMyOrderBonusPointItemList($LanguageID) {
		$query =	"	SELECT		*, L.*, B.*, O.*, C.*, M.* " .
					"	FROM		language L	JOIN myorder_bonus_point_item M		ON (M.myorder_id = '" . $this->myorder_id . "')" .
					"							JOIN currency C 					ON (C.currency_id = M.currency_id) " .
					"							JOIN bonus_point_item B 			ON (B.bonus_point_item_id = M.bonus_point_item_id AND L.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN object O						ON (O.object_id = B.bonus_point_item_id) " .
					"							LEFT JOIN bonus_point_item_data D	ON (D.language_id = L.language_id AND B.bonus_point_item_id = D.bonus_point_item_id) " .
					"	ORDER BY	B.bonus_point_item_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$MyOrderBonusPointItemList = array();

		while ($myResult = $result->fetch_assoc()) {
			array_push($MyOrderBonusPointItemList, $myResult);
		}
		return $MyOrderBonusPointItemList;
	}
	
	public static function GetUserMyOrderItemList($UserID, &$TotalItems, $PageNo = 1, $ItemsPerPage = 20) {
		$Offset = intval(($PageNo -1) * $ItemsPerPage);

		$query =	"	SELECT		SQL_CALC_FOUND_ROWS * " .
					"	FROM		myorder O	JOIN	user U				ON	(O.user_id = U.user_id) " .
					"							JOIN	currency C			ON	(C.currency_id = O.currency_id) " .
					"							JOIN	myorder_product	MP	ON	(MP.myorder_id = O.myorder_id) " .
					"							JOIN	product P			ON	(MP.product_id = P.product_id) " .
					"							JOIN	object	OBJ			ON	(P.product_id = OBJ.object_id) " .
					"							JOIN	object_link OL		ON	(OBJ.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"	WHERE		O.user_id = '" . intval($UserID) . "'" .
					"	ORDER BY	O.create_date DESC " .
					"	LIMIT	" . $Offset . ", " . intval($ItemsPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalItems = $myResult[0];

		$UserMyOrderItemList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($UserMyOrderItemList, $myResult);
		}
		return $UserMyOrderItemList;
	}

	public static function GetUserMyOrderItemListXML($UserID, $PageNo = 1, $ItemsPerPage = 20) {
		$smarty = new mySmarty();

		$User = user::GetUserInfo($UserID);
		$Site = site::GetSiteInfo($User['site_id']);

		$NoOfOrderItems = 0;

		$UserMyOrderItemList = cart::GetUserMyOrderItemList($UserID, $NoOfOrderItems, $PageNo, $ItemsPerPage);

		$smarty->assign('NoOfOrderItems', $NoOfOrderItems);

		$UserMyOrderItemListXML = '';
		foreach ($UserMyOrderItemList as $M) {
			$M['object_seo_url'] = object::GetSeoURL($M, '', $Site['site_default_language_id'], $Site);
			$smarty->assign('Object', $M);
			$smarty->assign('MyOrderObj', (object) $M);
			$UserMyOrderItemListXML = $UserMyOrderItemListXML . $smarty->fetch('api/object_info/MYORDER_PRODUCT_WITH_MYORDER_DETAILS.tpl');
		}
		return "<total_no_of_order_items>" . $NoOfOrderItems . "</total_no_of_order_items><myorder_item_list>" . $UserMyOrderItemListXML . "</myorder_item_list>";

	}
	
	public static function GetNoOfOrdersByUserID($UserID, $CartContentType = 'normal') {
		$query =	"	SELECT		COUNT(*) as no_of_orders " .
					"	FROM		myorder O	JOIN	user U ON (O.user_id = U.user_id) " .
					"	WHERE		O.user_id = '" . intval($UserID) . "'" .
					"			AND	O.order_content_type = '" . aveEscT($CartContentType) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result->fetch_assoc();
		return $myResult['no_of_orders'];
	}
	
	public static function GetMyOrderListByUserID($UserID, $IsHandled = 'ALL', $Offset = 0, $RowCount = 20, $CartContentType = 'normal') {			
		$query =	"	SELECT		* " .
					"	FROM		myorder O	JOIN	user U ON (O.user_id = U.user_id) " .
					"							JOIN	currency C	ON (C.currency_id = O.currency_id) " .
					"	WHERE		O.user_id = '" . intval($UserID) . "'" . 
					"			AND	O.order_content_type = '" . aveEscT($CartContentType) . "'" .
					"	ORDER BY	O.myorder_id DESC " .
					"	LIMIT	" . $Offset . ", " . $RowCount;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$MyOrderList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($MyOrderList, $myResult);
		}
		return $MyOrderList;
	}
	
	public static function GetMyOrderListXML($UserID, $Offset = 0, $RowCount = 20, $CartContentType = 'normal') {
		$smarty = new mySmarty();
		$NoOfOrders = myorder::GetNoOfOrdersByUserID($UserID, $CartContentType);
		$smarty->assign('NoOfOrders', $NoOfOrders);

		$MyOrderList = myorder::GetMyOrderListByUserID($UserID, 'ALL', $Offset, $RowCount, $CartContentType);
		$MyOrderListXML = '';
		foreach ($MyOrderList as $M) {
			$smarty->assign('MyOrderObj', (object) $M);
			$MyOrderListXML = $MyOrderListXML . $smarty->fetch('api/object_info/MYORDER.tpl');
		}
		return "<total_no_of_orders>" . $NoOfOrders . "</total_no_of_orders><myorder_list>" . $MyOrderListXML . "</myorder_list>";

	}
	
	public function ConfirmPayment(&$ErrorCode, $PaymentConfirmBy, $Ref1, $Ref2, $Ref3, $ClientSideBonusPointEarned = null, $RerunFromSyncForPOS = false) {
		
		$ConfirmPaymentLock = new mylock('ConfirmPayment' . $this->myorder_id);
		$ConfirmPaymentLock->acquireLock();
		
		$this->RefreshMyOrderDetailsObj();
		$InventoryCheckLock = new mylock('SiteInventoryCheck' . $this->getMyOrderDetailsObj()->site_id);
		$InventoryCheckLock->acquireLock();
		
		if ($this->getMyOrderDetailsObj()->payment_confirmed == 'Y' || $this->getMyOrderDetailsObj()->order_status != 'payment_pending') {
			$ErrorCode = 'API_ERROR_ORDER_ALREADY_CONFIRMED';
			if (!$RerunFromSyncForPOS)
				return false;
		}

		if ($this->getSiteObj()->site_module_inventory_enable == 'Y' ) {

			if ($this->getSiteObj()->site_product_allow_under_stock == 'N' && inventory::IsMyOrderUnderStock($this->getSiteArray(), $this->myorder_id)) {
				$ErrorCode = 'API_ERROR_MYORDER_UNDER_STOCK';
				if (!$RerunFromSyncForPOS)
					return false;
			}

			if ($this->getSiteObj()->site_auto_hold_stock_status == 'payment_confirmed' || $this->getSiteObj()->site_auto_hold_stock_status == 'payment_pending') {
				inventory::HoldStockForMyOrder($this->getSiteObj()->site_id, $this->myorder_id);
				site::EmptyAPICache($this->getSiteObj()->site_id);
			}
		}
		elseif ($this->getSiteObj()->site_module_inventory_partial_shipment == 'Y') {
			inventory::HoldStockForMyOrder($this->getSiteObj()->site_id, $this->myorder_id);
			site::EmptyAPICache($this->getSiteObj()->site_id);
		}

		$UserBalanceLock = user::GetUserBalanceLock($this->getMyOrderDetailsObj()->user_id);
		$UserBalanceLock->acquireLock(true);

		$User = user::GetUserInfo($this->getMyOrderDetailsObj()->user_id);

		$TotalBonusPointEarned = $this->getMyOrderDetailsObj()->bonus_point_earned;
		if ($ClientSideBonusPointEarned !== null)
			$TotalBonusPointEarned = intval($ClientSideBonusPointEarned);

		$BonusPointEarnedSuppliedByClient = $this->getMyOrderDetailsObj()->bonus_point_earned_supplied_by_client;
		if ($ClientSideBonusPointEarned !== null)
			$BonusPointEarnedSuppliedByClient = intval($ClientSideBonusPointEarned);

		$BonusPointCanBeUsed = 0;
		
		if ($this->getSiteObj()->site_use_bonus_point_at_once == 'Y')
			$BonusPointCanBeUsed = $User['user_bonus_point'] + $TotalBonusPointEarned;
		else
			$BonusPointCanBeUsed = $User['user_bonus_point'];

		if ($this->getMyOrderDetailsObj()->bonus_point_redeemed > $BonusPointCanBeUsed) {
			$ErrorCode = 'API_ERROR_NOT_ENOUGH_BONUS_POINT_TO_PROCEED_ORDER';
			if (!$RerunFromSyncForPOS)
				return false;
		}

		if ($this->getMyOrderDetailsObj()->user_balance_used > $User['user_balance']) {
			$ErrorCode = 'API_ERROR_NOT_ENOUGH_BALANCE_TO_PROCEED_ORDER';
			if (!$RerunFromSyncForPOS)
				return false;
		}

		$UserBalancePrevious = $User['user_balance'];
		$UserBalanceAfter = $User['user_balance'] - $this->getMyOrderDetailsObj()->user_balance_used;

		// Deduce user_balance here!
		if (doubleval($this->getMyOrderDetailsObj()->user_balance_used) > 0) {

			$query  =	" 	INSERT INTO	 user_balance " .
						"	SET		myorder_id				=	'" . $this->myorder_id . "', " .
						"			user_id					=	'" . intval($User['user_id']) . "', " .
						"			user_balance_previous	=	'" . doubleval($UserBalancePrevious) . "', " .
						"			user_balance_after		=	'" . doubleval($UserBalanceAfter) . "', " .
						"			user_balance_transaction_amount = '" . (doubleval($this->getMyOrderDetailsObj()->user_balance_used) * -1) . "', " .
						"			user_balance_transaction_type	= 'uorder', " .
						"			create_date 		= NOW()";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		unset($UserBalanceLock);

		$payment_confirm_date_sql = "";
		if (!$RerunFromSyncForPOS)
			$payment_confirm_date_sql = " payment_confirm_date = NOW(), ";
		
		$query =	"	UPDATE		myorder " .
					"	SET			bonus_point_previous	=	'" . intval($User['user_bonus_point']) . "', " .
					"				bonus_point_canbeused	=	'" . intval($BonusPointCanBeUsed) . "', " .
					"				bonus_point_earned_supplied_by_client = '" . intval($BonusPointEarnedSuppliedByClient) . "', " .		
					"				bonus_point_earned		=	'" . intval($TotalBonusPointEarned) . "', " .		
					"				bonus_point_balance		=	'" . intval($User['user_bonus_point'] + $TotalBonusPointEarned - $this->getMyOrderDetailsObj()->bonus_point_redeemed) . "', " .
					"				user_balance_previous	=	'" . doubleval($UserBalancePrevious) . "', " .
					"				user_balance_after		=	'" . doubleval($UserBalanceAfter) . "', " .
					"				payment_confirmed		=	'Y', " .
					"				order_status			=	'payment_confirmed', " .
					"				payment_confirm_by		=	'" . aveEscT($PaymentConfirmBy) . "', " . $payment_confirm_date_sql .
					"				reference_1				=	'" . aveEscT($Ref1) . "', " .
					"				reference_2				=	'" . aveEscT($Ref2) . "', " .
					"				reference_3				=	'" . aveEscT($Ref3) . "' " .
					"	WHERE		myorder_id = '" . $this->myorder_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$this->RefreshMyOrderDetailsObj();

		if ($TotalBonusPointEarned > 0) {
			$query  =	" 	INSERT INTO	user_bonus_point " .
						"	SET		myorder_id			=	'" . $this->myorder_id . "', " .
						"			user_id				=	'" . intval($User['user_id']) . "', " .
						"			bonus_point_amount_previous	=	'" . intval($User['user_bonus_point']) . "', " .
						"			bonus_point_amount_after	=	'" . intval($User['user_bonus_point'] + $TotalBonusPointEarned) . "', " .
						"			bonus_point_earned	=	'" . intval($TotalBonusPointEarned) . "', " .
						"			bonus_point_used	= 0, " .
						"			earn_type			= 'uorder', " .
						"			create_date 		= NOW(), " .
						"			expiry_date			= '" . custom::GetBonusPointExpiryDate($this->getSiteArray(), time()) . "', " . 
		//				"			expiry_date			= DATE_ADD(NOW(), INTERVAL ". $Site['site_bonus_point_valid_days'] ." DAY), " .
						"			bonus_point_reason	= 'uorder' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		user::DeduceUserBonusPoint($User['user_id'], $this->getMyOrderDetailsObj()->bonus_point_redeemed, $this->myorder_id, 'uorder', '', 0, 0);

		$this->UpdateMyOrderProductQuantitySold();
		site::EmptyAPICache($this->getSiteObj()->site_id);
		
		unset($ConfirmPaymentLock);
		unset($InventoryCheckLock);
		
		return true;
	}
	
	public function ConfirmOrder(&$ErrorCode, $ConfirmBy = '') {
		if (
			$this->getMyOrderDetailsObj()->order_confirmed == 'Y' ||
			(	$this->getMyOrderDetailsObj()->order_status != 'awaiting_order_confirmation' &&
				$this->getMyOrderDetailsObj()->order_status != 'awaiting_freight_quote' )
		) {
			$ErrorCode = 'API_ERROR_ORDER_ALREADY_CONFIRMED';
			return false;
		}
		
		$InventoryCheckLock = new mylock('SiteInventoryCheck' . $this->getMyOrderDetailsObj()->site_id);
		$InventoryCheckLock->acquireLock();
		
		if ($ConfirmBy == '') {
			$User = user::GetUserInfo($this->getMyOrderDetailsObj()->user_id);
			$ConfirmBy = $User['user_username'];
		}
		
		if ($this->getSiteObj()->site_module_inventory_enable == 'Y') {
			if ($this->getSiteObj()->site_product_allow_under_stock == 'N' && inventory::IsMyOrderUnderStock($this->getSiteArray(), $this->myorder_id)) {
				$ErrorCode = 'API_ERROR_MYORDER_UNDER_STOCK';
				return false;
			}
		}
		
		$query =	"	UPDATE		myorder " .
					"	SET			order_confirmed		=	'Y', " .
					"				order_status			=	'payment_pending', " .
					"				order_confirm_by		=	'" . aveEscT($ConfirmBy) . "', " .
					"				order_confirm_date		=	NOW() " .
					"	WHERE		myorder_id = '" . $this->myorder_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($this->getSiteObj()->site_auto_hold_stock_status == 'payment_pending') {
			inventory::HoldStockForMyOrder($this->getMyOrderDetailsObj()->site_id, $this->myorder_id);

			site::EmptyAPICache($this->getMyOrderDetailsObj()->site_id);
		}

		return true;
	}
	
	public function CancelOrder(&$ErrorCode, $ConfirmBy = '') {
		if (
			$this->getMyOrderDetailsObj()->order_confirmed == 'Y' ||
			(	$this->getMyOrderDetailsObj()->order_status != 'awaiting_order_confirmation' &&
				$this->getMyOrderDetailsObj()->order_status != 'awaiting_freight_quote' )
		) {
			$ErrorCode = 'API_ERROR_ORDER_ALREADY_CONFIRMED';
			return false;
		}
		
		if ($ConfirmBy == '') {
			$User = user::GetUserInfo($this->getMyOrderDetailsObj()->user_id);
			$ConfirmBy = $User['user_username'];
		}

		$query =	"	UPDATE		myorder " .
					"	SET			order_confirmed			=	'N', " .
					"				order_status			=	'order_cancelled', " .
					"				order_confirm_by		=	'" . aveEscT($ConfirmBy) . "', " .
					"				order_confirm_date		=	NOW() " .
					"	WHERE		myorder_id = '" . $this->myorder_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($this->getSiteObj()->site_module_inventory_enable == 'Y') {
			inventory::UnholdStockForMyOrder($this->myorder_id);
			site::EmptyAPICache($this->getMyOrderDetailsObj()->site_id);
		}
		
		return true;
	}
	
	public function VoidOrder(&$ErrorMsg, $SystemAdminID = 0, $ContentAdminID = 0) {
		//TODO: 
		//	check ProductQuantitySold is correct?
		//	check isPaymentConfirmed and do proper actions
		//	check DiscountRule processing
		
		if (!$this->getMyOrderDetailsObj()->order_can_void) {
			$ErrorMsg = ADMIN_ERROR_ORDER_CANNOT_BE_VOIDED;
			return false;
		}

		inventory::UnholdStockForMyOrder($this->myorder_id);
		
		if ($this->getMyOrderDetailsObj()->payment_confirmed == 'Y') {
			$NetBonusPoint = $this->getMyOrderDetailsObj()->bonus_point_redeemed - $this->getMyOrderDetailsObj()->bonus_point_earned;		
			
			$User = user::GetUserInfo($this->getMyOrderDetailsObj()->user_id);
			
			if ($NetBonusPoint > 0) {

				$query	=	"	INSERT INTO	user_bonus_point " .
							"	SET		user_id				=	'" . $this->getMyOrderDetailsObj()->user_id . "', " .
							"			system_admin_id		=	'" . intval($SystemAdminID) . "', " .
							"			content_admin_id	=	'" . intval($ContentAdminID) . "', " . 
							"			bonus_point_amount_previous	=	'" . intval($User['user_bonus_point']) . "', " .
							"			bonus_point_amount_after	=	'" . intval($User['user_bonus_point'] + $NetBonusPoint) . "', " .
							"			bonus_point_earned	=	'" . intval($NetBonusPoint) . "', " .
							"			bonus_point_used	=	0, " .
							"			earn_type			=	'void', " .
							"			myorder_id			=	'" . $this->myorder_id . "', " .
							"			expiry_date			= DATE_ADD(NOW(), INTERVAL ". $this->getSiteObj()->site_bonus_point_valid_days ." DAY), " .
							"			create_date			= NOW() ";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			}
			elseif ($NetBonusPoint < 0) {
				user::DeduceUserBonusPoint($this->getMyOrderDetailsObj()->user_id, intval($NetBonusPoint * -1), $this->myorder_id, 'void', '', $SystemAdminID, $ContentAdminID);
			}

			$RefundAmount = $this->getMyOrderDetailsObj()->user_balance_used + (doubleval($this->getMyOrderDetailsObj()->pay_amount_ca) * doubleval($this->getMyOrderDetailsObj()->currency_site_rate_atm));

			if ($RefundAmount > 0) {

				$UserBalanceLock = user::GetUserBalanceLock($this->getMyOrderDetailsObj()->user_id);
				$UserBalanceLock->acquireLock(true);

				$UserBalance = user::GetUserBalance($this->getMyOrderDetailsObj()->user_id);

				$UserBalancePrevious = $UserBalance;
				$UserBalanceAfter = $UserBalance + $RefundAmount;

				$query	=	"	INSERT INTO	user_balance " .
							"	SET		user_id				=	'" . $this->getMyOrderDetailsObj()->user_id . "', " .
							"			myorder_id			=	'" . $this->myorder_id . "', " .
							"			system_admin_id		=	'" . intval($SystemAdminID) . "', " .
							"			content_admin_id	=	'" . intval($ContentAdminID) . "', " . 						
							"			user_balance_previous	=	'" . doubleval($UserBalancePrevious) . "', " .
							"			user_balance_after	=	'" . doubleval($UserBalanceAfter) . "', " .
							"			user_balance_transaction_amount	=	'" . doubleval($RefundAmount) . "', " .
							"			user_balance_transaction_type = 'void', " .
							"			create_date = NOW(), " .
							"			user_balance_remark =	'void order' ";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

				unset($UserBalanceLock);
			}
			
		}

		$query	=	"	UPDATE	myorder " .
					"	SET		order_status =	'void' " .
					"	WHERE	myorder_id = '" . $this->myorder_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT		* " .
					"	FROM		myorder_product " .
					"	WHERE		myorder_id = '" . $this->myorder_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			product::UpdateProductQuantitySold($myResult['product_id'], $myResult['product_option_id']);
		}
		
		return true;
	}
	
	public static function GetMyOrderByOldMyOrderID($SiteID, $ShopID, $OldMyOrderID) {
		$query  =	" 	SELECT * " .
					"	FROM	myorder	" .
					"	WHERE	old_myorder_id = '" . intval($OldMyOrderID) . "'" .
					"		AND	site_id = '" . intval($SiteID) . "'" .
					"		AND shop_id = '" . intval($ShopID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			return $result->fetch_assoc();
		}
		else
			return null;
	}
	
	public static function GetMaxMyOrderID($SiteID) {
		$query  =	" 	SELECT	MAX(myorder_id) as max_myorder_id " .
					"	FROM	myorder " .
					"	WHERE	site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result->fetch_assoc();

		return $myResult['max_myorder_id'];
	}
	
	public static function DeleteOrder($MyOrderID) {
		$query =	"	SELECT		* " .
					"	FROM		myorder_product " .
					"	WHERE		myorder_id = '" . intval($MyOrderID) . "'";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		inventory::UnholdStockForMyOrder($MyOrderID);

		$query =	"	DELETE FROM	myorder " .
					"	WHERE		myorder_id = '" . intval($MyOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	myorder_product " .
					"	WHERE		myorder_id = '" . intval($MyOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	myorder_bonus_point_item " .
					"	WHERE		myorder_id = '" . intval($MyOrderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		while ($myResult = $result2->fetch_assoc()) {
			product::UpdateProductQuantitySold($myResult['product_id'], $myResult['product_option_id']);
		}		
	}	
	
	public static function GetSalesReportPerPaymentConfirmBy($SiteID, $StartDate, $EndDate, $NonVoid = true, $ShopID = false, $GroupByShop = true, $GroupByPaymentConfirm = true) {
		$shop_sql = '';
		if ($ShopID !== false)
			$shop_sql = "	AND M.shop_id = '" . intval($ShopID) . "'";
		
		$void_sql = '';
		if ($NonVoid === false)
			$void_sql = "	AND M.order_status = 'void' ";
		else {
			$void_sql = "	AND M.order_status != 'void' ";
		}
		
		$group_by_shop_sql = '';
		if ($GroupByShop)			
			$group_by_shop_sql = " M.shop_id, ";
		
		$group_by_payment_confirm_sql = '';
		if ($GroupByPaymentConfirm)			
			$group_by_payment_confirm_sql = " M.payment_confirm_by, ";
		
		$query  =	" 	SELECT	*, " .
					"		count(M.myorder_id) AS no_of_orders, " .
					"		sum(M.bonus_point_redeemed_cash_ca) AS sum_bonus_point_redeemed_cash_ca, " .
					"		sum(M.total_price_ca) AS sum_total_price_ca, " .
					"		sum(M.discount_amount_ca) AS sum_discount_amount_ca, " .
					"		sum(M.freight_cost_ca) AS sum_freight_cost_ca, " .
					"		sum(M.pay_amount_ca) AS sum_pay_amount_ca, " .
					"		sum(M.bonus_point_redeemed) AS sum_bonus_point_redeemed, " .
					"		sum(M.bonus_point_earned) AS sum_bonus_point_earned, " .
					"		sum(M.postprocess_rule_discount_amount_ca) AS sum_postprocess_rule_discount_amount_ca, " .
					"		sum(M.freight_cost_ca) AS sum_freight_cost_ca " .
					"	FROM	myorder	M	JOIN shop S ON (M.site_id = S.site_id AND M.shop_id = S.shop_id) " .
					"						JOIN currency C ON (C.currency_id = M.currency_id) " .
					"	WHERE	" .
					"			M.site_id = '" . intval($SiteID) . "'" .
					"		AND	M.payment_confirm_date >= '" . aveEscT($StartDate) . " 00:00:00'" .
					"		AND	M.payment_confirm_date <= '" . aveEscT($EndDate) . " 23:59:59'" . $shop_sql . $void_sql .
					"		AND M.payment_confirmed = 'Y' " .
					//"		AND M.payment_confirm_by != 'API: PayPal Sandbox' " .
					"		AND M.payment_confirm_by NOT LIKE '%Sandbox%' " .
					"	GROUP BY " . $group_by_shop_sql . $group_by_payment_confirm_sql . " M.currency_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Report = array();
		while ($myResult = $result->fetch_assoc()) {
			if (!$GroupByShop)
				$myResult['shop_name'] = 'ALL';
			if (!$GroupByPaymentConfirm)
				$myResult['payment_confirm_by'] = 'ALL';
			array_push($Report, $myResult);
		}
		
		return $Report;
	}
	
	public static function GetSalesReportPerOrderConfirmBy($SiteID, $StartDate, $EndDate, $NonVoid = true, $ShopID = false, $GroupByShop = true, $GroupByPaymentConfirm = true) {
		$shop_sql = '';
		if ($ShopID !== false)
			$shop_sql = "	AND M.shop_id = '" . intval($ShopID) . "'";
		
		$void_sql = '';
		if ($NonVoid === false)
			$void_sql = "	AND M.order_status = 'void' ";
		else {
			$void_sql = "	AND M.order_status != 'void' ";
		}

		$group_by_shop_sql = '';
		if ($GroupByShop)			
			$group_by_shop_sql = " M.shop_id, ";
		
		$group_by_payment_confirm_sql = '';
		if ($GroupByPaymentConfirm)			
			$group_by_payment_confirm_sql = " M.payment_confirm_by, ";
		
		$query  =	" 	SELECT	*, " .
					"		count(M.myorder_id) AS no_of_orders, " .
					"		sum(M.bonus_point_redeemed_cash_ca) AS sum_bonus_point_redeemed_cash_ca, " .
					"		sum(M.total_price_ca) AS sum_total_price_ca, " .
					"		sum(M.discount_amount_ca) AS sum_discount_amount_ca, " .
					"		sum(M.freight_cost_ca) AS sum_freight_cost_ca, " .
					"		sum(M.pay_amount_ca) AS sum_pay_amount_ca, " .
					"		sum(M.bonus_point_redeemed) AS sum_bonus_point_redeemed, " .
					"		sum(M.bonus_point_earned) AS sum_bonus_point_earned, " .
					"		sum(M.postprocess_rule_discount_amount_ca) AS sum_postprocess_rule_discount_amount_ca, " .
					"		sum(M.freight_cost_ca) AS sum_freight_cost_ca " .
					"	FROM	myorder	M	JOIN shop S ON (M.site_id = S.site_id AND M.shop_id = S.shop_id) " .
					"						JOIN currency C ON (C.currency_id = M.currency_id) " .
					"	WHERE	" .
					"			M.site_id = '" . intval($SiteID) . "'" .
					"		AND	M.order_confirm_date >= '" . aveEscT($StartDate) . " 00:00:00'" .
					"		AND	M.order_confirm_date <= '" . aveEscT($EndDate) . " 23:59:59'" . $shop_sql . $void_sql .
					"		AND M.payment_confirmed = 'Y' " .
					//"		AND M.payment_confirm_by != 'API: PayPal Sandbox' " .
					"		AND M.payment_confirm_by NOT LIKE '%Sandbox%' " .
					"	GROUP BY " . $group_by_shop_sql . $group_by_payment_confirm_sql . " M.currency_id " .
					"	ORDER BY M.payment_confirm_by ASC, C.currency_shortname ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Report = array();
		while ($myResult = $result->fetch_assoc()) {
			if (!$GroupByShop)
				$myResult['shop_name'] = 'ALL';
			if (!$GroupByPaymentConfirm)
				$myResult['payment_confirm_by'] = 'ALL';
			array_push($Report, $myResult);
		}
		
		return $Report;
	}
	
	public static function GetSalesReportPerCountryAllCountryList($SiteID, $StartDate, $EndDate, $ShopID = false) {
		$shop_sql = '';
		if ($ShopID !== false)
			$shop_sql = "	AND M.shop_id = '" . intval($ShopID) . "'";
		
		$query  =	" 	SELECT	* " .
					"	FROM	myorder	M	JOIN shop S ON (M.site_id = S.site_id AND M.shop_id = S.shop_id) " .
					"						JOIN country Y ON (Y.country_id = M.invoice_country_id) " .
					"	WHERE	" .
					"			M.site_id = '" . intval($SiteID) . "'" . $shop_sql .
					"		AND	M.order_confirm_date >= '" . aveEscT($StartDate) . " 00:00:00'" .
					"		AND	M.order_confirm_date <= '" . aveEscT($EndDate) . " 23:59:59'" .
					"		AND M.payment_confirmed = 'Y' " .
					//"		AND M.payment_confirm_by != 'API: PayPal Sandbox' " .
					"		AND M.payment_confirm_by NOT LIKE '%Sandbox%' " .
					"	GROUP BY Y.country_id " .
					"	ORDER BY Y.country_name_en_only ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$CountryList = array();

		while ($myResult = $result->fetch_assoc()) {
			array_push($CountryList, $myResult);
		}
		
		return $CountryList;
	}
	
	public static function GetSalesReportPerCountry($SiteID, $StartDate, $EndDate, $NonVoid = true, $ShopID = false, $GroupByShop = true, $GroupByCountry = true, $CountryID = 0) {
		$shop_sql = '';
		if ($ShopID !== false)
			$shop_sql = "	AND M.shop_id = '" . intval($ShopID) . "'";
		
		$void_sql = '';
		if ($NonVoid === false)
			$void_sql = "	AND M.order_status = 'void' ";
		else {
			$void_sql = "	AND M.order_status != 'void' ";
		}
		
		$country_sql = '';
		if ($CountryID != 0)
			$country_sql = "	AND M.invoice_country_id = '" . intval($CountryID) . "'";

		$group_by_shop_sql = '';
		if ($GroupByShop)			
			$group_by_shop_sql = " M.shop_id, ";
		
		$group_by_country_sql = '';
		if ($GroupByCountry)
			$group_by_country_sql = " M.invoice_country_id, ";
		
		$query  =	" 	SELECT	*, " .
					"		count(M.myorder_id) AS no_of_orders, " .
					"		sum(M.bonus_point_redeemed_cash_ca) AS sum_bonus_point_redeemed_cash_ca, " .
					"		sum(M.total_price_ca) AS sum_total_price_ca, " .
					"		sum(M.discount_amount_ca) AS sum_discount_amount_ca, " .
					"		sum(M.freight_cost_ca) AS sum_freight_cost_ca, " .
					"		sum(M.pay_amount_ca) AS sum_pay_amount_ca, " .
					"		sum(M.bonus_point_redeemed) AS sum_bonus_point_redeemed, " .
					"		sum(M.bonus_point_earned) AS sum_bonus_point_earned, " .
					"		sum(M.postprocess_rule_discount_amount_ca) AS sum_postprocess_rule_discount_amount_ca, " .
					"		sum(M.freight_cost_ca) AS sum_freight_cost_ca " .
					"	FROM	myorder	M	JOIN shop S ON (M.site_id = S.site_id AND M.shop_id = S.shop_id) " .
					"						JOIN currency C ON (C.currency_id = M.currency_id) " .
					"						JOIN country Y ON (Y.country_id = M.invoice_country_id) " .
					"	WHERE	" .
					"			M.site_id = '" . intval($SiteID) . "'" .
					"		AND	M.order_confirm_date >= '" . aveEscT($StartDate) . " 00:00:00'" .
					"		AND	M.order_confirm_date <= '" . aveEscT($EndDate) . " 23:59:59'" . $shop_sql . $void_sql . $country_sql .
					"		AND M.payment_confirmed = 'Y' " .
					//"		AND M.payment_confirm_by != 'API: PayPal Sandbox' " .
					"		AND M.payment_confirm_by NOT LIKE '%Sandbox%' " .
					"	GROUP BY " . $group_by_shop_sql . $group_by_country_sql . " M.currency_id " .
					"	ORDER BY Y.country_name_en_only ASC, C.currency_shortname ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Report = array();
		while ($myResult = $result->fetch_assoc()) {
			if (!$GroupByShop)
				$myResult['shop_name'] = 'ALL';
			if (!$GroupByCountry)
				$myResult['country_name_en_only'] = 'ALL';
			array_push($Report, $myResult);
		}
		
		return $Report;
	}	
	
	public static function GetSalesReportPerProductandPaymentConfirmDate($SiteID, $StartDate, $EndDate, $ShopID = false, $GroupByShop = true, $LangID = 1) {
		$shop_sql = '';
		if ($ShopID !== false)
			$shop_sql = "	AND M.shop_id = '" . intval($ShopID) . "'";
		
		$group_by_shop_sql = '';
		if ($GroupByShop)			
			$group_by_shop_sql = " M.shop_id, ";
				
		$query  =	" 	SELECT	*, " .
					"		count(distinct(M.myorder_id)) AS no_of_orders, " .
					"		sum(MP.actual_subtotal_price_ca) AS sum_actual_subtotal_price_ca, " .
					"		sum(MP.quantity) AS sum_quantity, " .
					"		sum(MP.product_bonus_point_required) AS sum_product_bonus_point_required " .
					"	FROM	myorder	M	JOIN shop S ON (M.site_id = S.site_id AND M.shop_id = S.shop_id) " .
					"						JOIN currency C ON (C.currency_id = M.currency_id) " .
					"						JOIN myorder_product MP ON (M.myorder_id = MP.myorder_id) " .
					"						JOIN product P ON (MP.product_id = P.product_id) " .
					"						JOIN product_data PD ON (P.product_id = PD.product_id AND PD.language_id = '" . intval($LangID) . "') " .
					"	WHERE	" .
					"			M.site_id = '" . intval($SiteID) . "'" .
					"		AND M.order_status != 'void' " .
					"		AND	M.payment_confirm_date >= '" . aveEscT($StartDate) . " 00:00:00'" .
					"		AND	M.payment_confirm_date <= '" . aveEscT($EndDate) . " 23:59:59'" . $shop_sql . 
					"		AND M.payment_confirmed = 'Y' " .
					//"		AND M.payment_confirm_by != 'API: PayPal Sandbox' " .
					"		AND M.payment_confirm_by NOT LIKE '%Sandbox%' " .
					"	GROUP BY " . $group_by_shop_sql . " P.product_id, M.currency_id " .
					"	ORDER BY " . $group_by_shop_sql . " P.product_code ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Report = array();
		while ($myResult = $result->fetch_assoc()) {
			if (!$GroupByShop)
				$myResult['shop_name'] = 'ALL';
			
//			$Product = product::GetProductInfo($myResult['product_id'], $LangID);
			array_push($Report, $myResult);
		}
		
		return $Report;
	}
	
	public static function GetSalesReportPerProductandOrderConfirmDate($SiteID, $StartDate, $EndDate, $ShopID = false, $GroupByShop = true, $LangID = 1, $CountryID = 0) {
		$country_sql = '';
		if ($CountryID != 0)
			$country_sql = "	AND	M.invoice_country_id = '" . intval($CountryID) . "'";
		
		$shop_sql = '';
		if ($ShopID !== false)
			$shop_sql = "	AND M.shop_id = '" . intval($ShopID) . "'";
		
		$group_by_shop_sql = '';
		if ($GroupByShop)			
			$group_by_shop_sql = " M.shop_id, ";
				
		$query  =	" 	SELECT	*, " .
					"		count(distinct(M.myorder_id)) AS no_of_orders, " .
					"		sum(MP.actual_subtotal_price_ca) AS sum_actual_subtotal_price_ca, " .
					"		sum(MP.quantity) AS sum_quantity, " .
					"		sum(MP.product_bonus_point_required) AS sum_product_bonus_point_required " .
					"	FROM	myorder	M	JOIN shop S ON (M.site_id = S.site_id AND M.shop_id = S.shop_id) " .
					"						JOIN currency C ON (C.currency_id = M.currency_id) " .
					"						JOIN myorder_product MP ON (M.myorder_id = MP.myorder_id) " .
					"						JOIN product P ON (MP.product_id = P.product_id) " .
					"						JOIN product_data PD ON (P.product_id = PD.product_id AND PD.language_id = '" . intval($LangID) . "') " .
					"	WHERE	" .
					"			M.site_id = '" . intval($SiteID) . "'" .
					"		AND M.order_status != 'void' " .
					"		AND	M.order_confirm_date >= '" . aveEscT($StartDate) . " 00:00:00'" .
					"		AND	M.order_confirm_date <= '" . aveEscT($EndDate) . " 23:59:59'" . $shop_sql . $country_sql .
					//"		AND M.payment_confirm_by != 'API: PayPal Sandbox' " .
					"		AND M.payment_confirm_by NOT LIKE '%Sandbox%' " .
					"		AND M.payment_confirmed = 'Y' " .
					"	GROUP BY " . $group_by_shop_sql . " P.product_id, M.currency_id " .
					"	ORDER BY " . $group_by_shop_sql . " P.product_code ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Report = array();
		while ($myResult = $result->fetch_assoc()) {
			if (!$GroupByShop)
				$myResult['shop_name'] = 'ALL';
			
//			$Product = product::GetProductInfo($myResult['product_id'], $LangID);
			array_push($Report, $myResult);
		}
		
		return $Report;
	}
}