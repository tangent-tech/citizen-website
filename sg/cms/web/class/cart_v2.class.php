<?php
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

require_once(__DIR__ . '/bdrConditionDiscountCalculator.class.php');

class cart_v2 {
	public function cart_v2($SystemAdminID, $ContentAdminID, $UserID, $SiteID, $CartContentType, $LangID = 0) {
		$this->system_admin_id = intval($SystemAdminID);
		$this->content_admin_id = intval($ContentAdminID);
		$this->user_id = intval($UserID);
		$this->site_id = intval($SiteID);
		$this->cart_content_type = $CartContentType;
		$this->lang_id = $LangID;
		
		if ($this->cart_content_type == 'test') {
			$this->HonorArchiveDate = false;
			$this->HonorPublishDate = false;
		}
		
		if ($this->user_id > 0) {
			$this->User = user::GetUserInfo($this->user_id);
			$this->_user_security_level = $this->User['user_security_level'];
		}
	}	

	public $is_cart_valid_to_convert_order = false;
	public $error_msg = '';
	public $user_balnce_used_ca = 0;
	public $user_balance_after = 0;
	public $bonus_point_can_be_used = 0;
	public $bonus_point_balance = 0;
	public $total_price = 0;
	public $total_price_ca = 0;
	public $total_listed_price = 0;
	public $total_listed_price_ca = 0;
	public $total_cash_value = 0;
	public $total_cash_value_ca = 0;
	public $total_bonus_point = 0;
	public $total_bonus_point_required = 0;
	public $total_bonus_point_required_for_bonus_point_cart = 0;
	public $total_bonus_point_required_for_product_cart = 0;
	public $total_quantity = 0;
	public $pay_amount_ca = 0;
	public $postprocess_rule_discount_amount = 0;
	public $postprocess_rule_discount_amount_ca = 0;
	public $effective_discount_postprocess_rule_id = 0;
	public $effective_discount_postprocess_rule_discount_code = '';
	public $total_possible_discount_rule_no_by_discount_code = 0;
	public $total_applied_discount_rule_no_by_discount_code = 0;
	public $cash_paid_ca = 0;
	public $cash_change_ca = 0;
	
	public $calculated_freight_cost_ca = 0;
	public $calculated_bonus_point_item_list = array();
	public $calculated_product_list = array();

	public $under_stock_adjustment = false;
	public $quantity_adjusted_cart_content_id_array = array();
	
	public $PreprocessRuleIDList = array();
	public $BundleRuleIDList = array();
	
	private $ContinuePreProcessRule = true;
	private $ContinuePostProcessRule = true;
	
	private $system_admin_id;
	private $content_admin_id;
	private $user_id;
	private $lang_id;

	private $site_id;
	
	private $cart_content_type;
		
	private $_user_security_level = null;
	public function setUserSecurityLevel($UserSecurityLevel) {
		$this->_user_security_level = $UserSecurityLevel;
		$this->AmIDirty = true;
	}
	public function getUserSecurityLevel() {
		if ($this->user_id == 0 && $this->system_admin_id == 0 && $this->content_admin_id == 0) {
			return 0;
		}
		else {
			if ($this->_user_security_level === null) {
				$this->_user_security_level = $this->getUserObj()->user_security_level;
			}
			return intval($this->_user_security_level);		
		}
	}
	
	private $_SiteObj = null;
	private $_SiteArray = null;
	private $_SiteFreight = null;
	private function getSiteObj() {
		if ($this->_SiteObj == null) {
			$this->_SiteArray = site::GetSiteInfo($this->site_id);
			$this->_SiteObj = (object) $this->_SiteArray;
		}
		return $this->_SiteObj;
	}
	private function getSiteArray() {
		if ($this->_SiteArray == null) {
			$this->_SiteArray = site::GetSiteInfo($this->site_id);
			$this->_SiteObj = (object) $this->_SiteArray;
		}
		return $this->_SiteArray;
	}
	
	private $_UserObj = null;
	public function getUserObj() {
		if ($this->user_id != 0 && $this->_User === null) {
			$this->_UserObj = (object) user::GetUserInfo($this->user_id);
		}
		return $this->_UserObj;
	}
	
	private $_CurrencyObj = null;
	public function getCurrencyObj() {
		if ($this->_CurrencyObj === null) {
			$this->_CurrencyObj = (object) currency::GetCurrencyInfo($this->getCartDetailsObj()->currency_id, $this->site_id);
			
			if ($this->_CurrencyObj === null || $this->_CurrencyObj->currency_site_enable_id == null) {
				$this->getCartDetailsObj()->currency_id = $this->getSiteObj()->site_default_currency_id;
				$this->_CurrencyObj = (object) currency::GetCurrencyInfo($this->getSiteObj()->site_default_currency_id, $this->site_id);
				$this->AmIDirty = true;
			}
		}
		return $this->_CurrencyObj;
	}

	public function getEffectiveCurrencyRate() {
		if ($this->getSiteObj()->site_product_price_indepedent_currency == 'Y') {
			return 1;
		}
		else
			return $this->getCurrencyObj()->currency_site_rate;
	}
	
	public function getEffectiveProductPriceCurrencyID() {
		if ($this->getSiteObj()->site_product_price_indepedent_currency == 'Y')
			return $this->getCurrencyObj()->currency_id;
		else
			return 0;
	}
	
	/**
	 * 
	 * @return siteFreight
	 */
	public function getSiteFreight() {
		if ($this->_SiteFreight === null) {
			if ($this->getSiteObj()->site_product_price_indepedent_currency == 'Y')
				$this->_SiteFreight = site::GetSiteFreightObj($this->site_id, $this->getCartDetailsObj()->currency_id);
			else
				$this->_SiteFreight = site::GetSiteFreightObj($this->site_id, 0);
		}
		return $this->_SiteFreight;		
	}
	
	private $_CartDetailsObj; /* @var $_CartDetailsObj cart_details */	
	
	private $HonorArchiveDate = true;
	private $HonorPublishDate = true;
	
	private $AmIDirty = true;
		
	/**
	 * 
	 * @return cart_details
	 */
	public function getCartDetailsObj($Calculated = false, $LanguageID = 0) {
		if ($this->_CartDetailsObj == null) {
			$query =	"	SELECT		* " .
						"	FROM		cart_details " .
						"	WHERE		user_id				= '" . $this->user_id . "' " .
						"			AND	system_admin_id		= '" . $this->system_admin_id . "' " .
						"			AND	content_admin_id	= '" . $this->content_admin_id . "' " .
						"			AND	site_id				= '" . $this->site_id . "' " .
						"			AND	cart_content_type	= '" . $this->cart_content_type . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			if ($result->num_rows > 0)
				$this->_CartDetailsObj = $result->fetch_object ('cart_details');
			else
				$this->_CartDetailsObj = new cart_details();
		}
		
		if ($Calculated && $this->AmIDirty) {
			$this->processCart();
		}
		
		return $this->_CartDetailsObj;
	}

	/**
	 * Process the cart, calculate everything, break down products to different rows
	 */
	public function processCart() {
		if (!$this->AmIDirty)
			return;
		
		$this->error_msg = '';
		$this->is_cart_valid_to_convert_order = true;
		$this->user_balnce_used_ca = 0;
		$this->user_balance_after = 0;
		$this->bonus_point_can_be_used = 0;
		$this->bonus_point_balance = 0;

		$this->total_price = 0;
		$this->total_price_ca = 0;
		$this->total_listed_price = 0;
		$this->total_listed_price_ca = 0;
		$this->total_cash_value = 0;
		$this->total_cash_value_ca = 0;
		$this->total_bonus_point = 0;
		$this->total_bonus_point_required = 0;
		$this->total_bonus_point_required_for_bonus_point_cart = 0;
		$this->total_bonus_point_required_for_product_cart = 0;
		$this->total_quantity = 0;
		$this->pay_amount_ca = 0;
		$this->postprocess_rule_discount_amount = 0;
		$this->postprocess_rule_discount_amount_ca = 0;
		$this->effective_discount_postprocess_rule_id = 0;
		$this->effective_discount_postprocess_rule_discount_code = '';
		$this->total_possible_discount_rule_no_by_discount_code = 0;
		$this->total_applied_discount_rule_no_by_discount_code = 0;	
		$this->calculated_freight_cost_ca = 0;
		$this->calculated_bonus_point_item_list = array();
		$this->calculated_product_list = array();
		$this->under_stock_adjustment = false;
		$this->quantity_adjusted_cart_content_id_array = array();
		$this->PreprocessRuleIDList = array();
		$this->ContinuePostProcessRule = true;
		
		if ($this->getCartDetailsObj()->bonus_point_item_id != 0) {
			$BonusPointItem = bonuspoint::GetBonusPointItemInfo($this->getCartDetailsObj()->bonus_point_item_id, 0);
			if ($BonusPointItem['site_id'] != $this->site_id || $BonusPointItem['object_is_enable'] != 'Y') {
				$this->error_msg = 'API_ERROR_INVALID_BONUS_POINT_ITEM_ID';
				$this->is_cart_valid_to_convert_order = false;
			}
			else {
				// Add this for backward compatibility
				$this->EmptyBonusPointItemCart();
				$this->AddBonusPointItemToCart($this->getCartDetailsObj()->bonus_point_item_id, 1);
			}
		}
		
		$this->ApplyEffectiveBasePriceID();
		
		$this->ProcessBundleDiscount();
		
		$this->ProcessPreProcessDiscount();
		
		$this->ProcessCartProductItemList();
	
		$this->ProcessBonusPointItemList();
		
		$this->ProcessPostProcessDiscount();
		
		$this->ProcessFreight();
		
		$this->total_bonus_point_required = $this->total_bonus_point_required_for_bonus_point_cart + $this->total_bonus_point_required_for_product_cart;
		
		$this->pay_amount_ca = $this->total_price_ca + $this->calculated_freight_cost_ca - doubleval($this->total_cash_value_ca) - doubleval($this->getCartDetailsObj(false, 0)->discount_amount_ca) - $this->postprocess_rule_discount_amount_ca;
		
		$this->pay_amount_ca = $this->pay_amount_ca - $this->getCartDetailsObj(false, 0)->user_balance_use * $this->getEffectiveCurrencyRate();
		
		if ($this->pay_amount_ca < 0)
			$this->pay_amount_ca = 0;

		$this->bonus_point_can_be_used = $this->getUserObj()->user_bonus_point;

		if ($this->getCartDetailsObj()->bonus_point_earned_supplied_by_client >= 0)
			$this->total_bonus_point = $this->getCartDetailsObj()->bonus_point_earned_supplied_by_client;
		
		if ($this->getSiteObj()->site_use_bonus_point_at_once == 'Y') {
			if ($this->cart_content_type != 'bonus_point') {
				$this->bonus_point_can_be_used += $this->total_bonus_point;
			}
		}
		
		if ($this->is_cart_valid_to_convert_order) {
			if ($this->total_bonus_point_required > $this->bonus_point_can_be_used) {
				$this->error_msg = 'API_ERROR_NOT_ENOUGH_BONUS_POINT';
				$this->is_cart_valid_to_convert_order = false;
			}
			else if ($this->getUserObj()->user_balance < $this->getCartDetailsObj()->user_balance_use) {
				$this->error_msg = 'API_ERROR_NOT_ENOUGH_BALANCE';
				$this->is_cart_valid_to_convert_order = false;
			}			
		}
				
		$this->bonus_point_balance = intval($this->getUserObj()->user_bonus_point) + $this->total_bonus_point - $this->total_bonus_point_required;
		
		$this->user_balance_after = doubleval($this->getUserObj()->user_balance - $this->getCartDetailsObj()->user_balance_use);
		$this->user_balnce_used_ca = doubleval($this->getCartDetailsObj()->user_balance_use * $this->getEffectiveCurrencyRate());

		$PaidCurrency = (object) currency::GetCurrencyInfo($this->getCartDetailsObj()->cash_paid_currency_id, $this->site_id);
		$this->cash_paid_ca = $PaidCurrency->currency_rate * $this->getCurrencyObj()->currency_rate > 0 ? $this->getCartDetailsObj()->cash_paid / $PaidCurrency->currency_rate * $this->getCurrencyObj()->currency_rate : 0;
		$this->cash_change_ca = round($this->cash_paid_ca - $this->pay_amount_ca, $this->getCurrencyObj()->currency_precision);
		
		$this->AmIDirty = false;
	}

	/**
	 * 
	 * @param type $PreprocessItemCondition
	 * @param type $ItemRow
	 * @return boolean
	 */
	private function ProcessDiscountPreprocessItemCondition($PreprocessItemCondition, $ItemRow) {
		if ($PreprocessItemCondition['discount_preprocess_item_condition_type_id'] == 1) {
			$IncludeSubCat = 'N';
			if ($PreprocessItemCondition['discount_preprocess_item_condition_para_int_2'] == 1)
				$IncludeSubCat = 'Y';

			if (product::IsProductUnderProductCategory($ItemRow->product_id, $PreprocessItemCondition['discount_preprocess_item_condition_para_int_1'], $IncludeSubCat, $this->getUserSecurityLevel(), $this->HonorArchiveDate, $this->HonorPublishDate))
				return true;
			else
				return false;
		}
		elseif ($PreprocessItemCondition['discount_preprocess_item_condition_type_id'] == 2) {
			if ($ItemRow->product_brand_id == $PreprocessItemCondition['discount_preprocess_item_condition_para_int_1'])
				return true;
			else
				return false;
		}
		elseif ($PreprocessItemCondition['discount_preprocess_item_condition_type_id'] == 3) {
			$ProductCatSpecial = product::GetProductCatSpecialInfo($PreprocessItemCondition['discount_preprocess_item_condition_para_int_1'], 0);

			if ($ItemRow->{'is_special_cat_' . $ProductCatSpecial['product_category_special_no']} == 'Y')
				return true;
			else
				return false;
		}
		else
			return false;
	}

	/**
	 * 
	 * @param type $PreprocessExceptItemCondition
	 * @param type $ItemRow
	 * @return boolean
	 */
	private function ProcessDiscountPreprocessExceptItemCondition($PreprocessExceptItemCondition, $ItemRow) {		
		if ($PreprocessExceptItemCondition['discount_preprocess_item_except_condition_type_id'] == 1) {
			
			$IncludeSubCat = 'N';
			if ($PreprocessExceptItemCondition['discount_preprocess_item_except_condition_para_int_2'] == 1)
				$IncludeSubCat = 'Y';
			if (product::IsProductUnderProductCategory($ItemRow->product_id, $PreprocessExceptItemCondition['discount_preprocess_item_except_condition_para_int_1'], $IncludeSubCat, $this->getUserSecurityLevel(), $this->HonorArchiveDate, $this->HonorPublishDate))
				return true;
			else
				return false;
		}
		elseif ($PreprocessExceptItemCondition['discount_preprocess_item_except_condition_type_id'] == 2) {
			if ($ItemRow->product_brand_id == $PreprocessExceptItemCondition['discount_preprocess_item_except_condition_para_int_1'])
				return true;
			else
				return false;
		}
		elseif ($PreprocessExceptItemCondition['discount_preprocess_item_except_condition_type_id'] == 3) {
			$ProductCatSpecial = product::GetProductCatSpecialInfo($PreprocessItemCondition['discount_preprocess_item_except_condition_para_int_1'], 0);

			if ($ItemRow->{'is_special_cat_' . $ProductCatSpecial['product_category_special_no']} == 'Y')
				return true;
			else
				return false;
		}
		else
			return false;
	}
	
	/**
	 * Process ONE discount bundle rule
	 * Return the product quantity applied by this discount rule
	 * @todo Convert all those array into object so that ppl can see what exactly it is
	 * @param array $BundleRule
	 * @param array $CartItemList
	 * @param array $HitItemList
	 * @param array $NonHitItemList
	 * @return int
	 */
	private function ProcessDiscountBundleRule($BundleRule, $CartItemList, &$HitItemList, &$NonHitItemList) {
		if (
			($BundleRule['discount_bundle_rule_quota_discount_code'] > 0 && discount::GetBundleRuleUsageForDiscountCode($BundleRule['discount_bundle_rule_id'], trim($this->getCartDetailsObj()->discount_code)) >= $BundleRule['discount_bundle_rule_quota_discount_code'])
		) {
			$HitQuantity = 0;
			$HitItemList = array();
			$NonHitItemList = $CartItemList;
			return $HitQuantity;
		}
		$EffectiveDiscountCode = '';
		if ($BundleRule['discount_bundle_rule_quota_discount_code'] != ', , ')
			$EffectiveDiscountCode = trim($this->getCartDetailsObj()->discount_code);

		$HitQuantity = 0;

		$HitItemList = array();
		$NonHitItemList = array();
		$MyNonHitItemList = array();
		$MyCartItemList = array();

		$BundleCostAwareConditionList = discount::GetBundleItemCostAwareCondition($BundleRule['discount_bundle_rule_id']);
		$BundleFreeConditionList = discount::GetBundleItemFreeCondition($BundleRule['discount_bundle_rule_id']);
		
		// Now check for maximum allowed 
		$AllowedUserQtyLeft		= 999999;
		$AllowedGlobalQtyLeft	= 999999;
		if ($BundleRule['discount_bundle_rule_quota_user'] > 0) {
			$AllowedUserQtyLeft = $BundleRule['discount_bundle_rule_quota_user'] - discount::GetBundleRuleQtyUsageForUser($BundleRule['discount_bundle_rule_id'], $this->user_id);
			if ($AllowedUserQtyLeft < 0)
				$AllowedUserQtyLeft = 0;
		}
		if ($BundleRule['discount_bundle_rule_quota_all'] > 0) {
			$AllowedGlobalQtyLeft = $BundleRule['discount_bundle_rule_quota_all'] - discount::GetBundleRuleQtyUsageForGlobal($BundleRule['discount_bundle_rule_id']);
			if ($AllowedGlobalQtyLeft < 0)
				$AllowedGlobalQtyLeft = 0;
		}
		$EffectiveAllowedDiscountQuantity = min($AllowedGlobalQtyLeft, $AllowedUserQtyLeft);
		
		foreach ($CartItemList as $I) {
			if ($BundleRule['discount_bundle_rule_apply_to_bonus_point_payment_products'] == 'N' && $I->product_bonus_point_required > 0) {
				array_push($MyNonHitItemList, $I);
				continue;
			}
			else {
				array_push($MyCartItemList, $I);
			}
		}

		$RuleRequiredQuantity = 0;
		$ConditionArray = array();
		foreach ($BundleCostAwareConditionList as $C) {
			$RuleRequiredQuantity += $C['discount_bundle_item_condition_quantity'];
			$bdrCondition = new BdrCondition($C['discount_bundle_item_condition_quantity'], array(), 'cost');

			foreach ($MyCartItemList as $I) {
				if (discount::IsProductMeetBundleItemCondition($C, (array) $I, $this->getUserSecurityLevel(), $this->HonorArchiveDate, $this->HonorPublishDate)) {
					array_push($bdrCondition->productIdArray, strval($I->product_id));
				}
			}
			array_push($ConditionArray, $bdrCondition);
		}
		foreach ($BundleFreeConditionList as $C) {
			$RuleRequiredQuantity += $C['discount_bundle_item_condition_quantity'];
			$bdrCondition = new BdrCondition($C['discount_bundle_item_condition_quantity'], array(), 'free');
			
			foreach ($MyCartItemList as $I) {
				if (discount::IsProductMeetBundleItemCondition($C, (array) $I, $this->getUserSecurityLevel(), $this->HonorArchiveDate, $this->HonorPublishDate)) {
					array_push($bdrCondition->productIdArray, strval($I->product_id));
				}
			}
			array_push($ConditionArray, $bdrCondition);
		}

		$MaxNoOfTimeThisRuleApplied = $RuleRequiredQuantity > 0 ? floor($EffectiveAllowedDiscountQuantity / $RuleRequiredQuantity) : 0;
		
		if ($MaxNoOfTimeThisRuleApplied == 0) {
			$HitItemList = array();
			$NonHitItemList = $CartItemList;
			return $HitQuantity;
		}

		$ProductQuantityArray = array();
		foreach ($MyCartItemList as $I) {
			$ProductQuantityArray[strval($I->product_id)] += $I->quantity;
		}
		
		$bdr = new bdrConditionDiscountCalculator($ProductQuantityArray, $ConditionArray, $MaxNoOfTimeThisRuleApplied);
		if ($bdr->getSolution($FreeSolution, $CostSolution, $QuantityArray, $RuleHitNoOfTimes)) {
			
			$BundleRule['discount_bundle_discount2_at_price_ca'] = round($BundleRule['discount_bundle_discount2_at_price'] * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
			$BundleRule['discount_bundle_discount3_add_price_ca'] = round($BundleRule['discount_bundle_discount3_add_price'] * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
			
			if ($BundleRule['discount_bundle_discount_type_id'] == 1) {
				foreach ($MyCartItemList as $I) {
					/* @var $I cart_result_product */
					$I->product_base_price_ca = round($I->product_base_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price_ca = round($I->product_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price2_ca = round($I->product_price2 * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price3_ca = round($I->product_price3 * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$FreeCloneItem = clone $I;
					$LeftCloneItem = clone $I;
					$QuantityLeft = $I->quantity;
					
					if (array_key_exists(strval($I->product_id), $CostSolution)) {
						$I->quantity = min($QuantityLeft, $CostSolution[strval($I->product_id)]);						
						if ($I->quantity > 0) {
							$QuantityLeft -= $I->quantity;
							$CostSolution[strval($I->product_id)] -= $I->quantity;
							$I->effective_discount_type = 6;
							$I->actual_unit_price			= round($I->product_base_price * (100 - $BundleRule['discount_bundle_discount1_off_p']) / 100, $this->getCurrencyObj()->currency_precision);
							$I->actual_unit_price_ca		= round($I->product_base_price_ca * (100 - $BundleRule['discount_bundle_discount1_off_p']) / 100, $this->getCurrencyObj()->currency_precision);
							$I->actual_subtotal_price		= round($I->actual_unit_price * $I->quantity, $this->getCurrencyObj()->currency_precision);
							$I->actual_subtotal_price_ca	= round($I->actual_unit_price_ca * $I->quantity, $this->getCurrencyObj()->currency_precision);
							$I->product_bonus_point_amount = intval($I->product_bonus_point_amount * $I->quantity);
							$I->product_bonus_point_required = intval($I->product_bonus_point_required * $I->quantity);						
							$I->discount_desc = $BundleRule['discount_bundle_discount1_off_p'] . "% OFF";
							$I->effective_discount_bundle_rule_id = $BundleRule['discount_bundle_rule_id'];
							$I->effective_discount_bundle_rule_name = $BundleRule['discount_bundle_rule_name'];
							$I->effective_discount_bundle_code = $EffectiveDiscountCode;			
							$HitQuantity += $I->quantity;
							array_push($HitItemList, $I);
						}
					}
					if (array_key_exists(strval($I->product_id), $FreeSolution)) {
						$FreeCloneItem->quantity = min($QuantityLeft, $FreeSolution[strval($I->product_id)]);						
						if ($FreeCloneItem->quantity > 0) {
							$QuantityLeft -= $FreeCloneItem->quantity;
							$FreeSolution[strval($I->product_id)] -= $FreeCloneItem->quantity;
							$FreeCloneItem->effective_discount_type = 6;
							$FreeCloneItem->actual_unit_price = null;
							$FreeCloneItem->actual_unit_price_ca = null;
							$FreeCloneItem->actual_subtotal_price = null;
							$FreeCloneItem->actual_subtotal_price_ca = null;
							$FreeCloneItem->product_bonus_point_amount = intval($FreeCloneItem->product_bonus_point_amount * $FreeCloneItem->quantity);
							$FreeCloneItem->product_bonus_point_required = intval($FreeCloneItem->product_bonus_point_required * $FreeCloneItem->quantity);
							$FreeCloneItem->effective_discount_bundle_rule_id = $BundleRule['discount_bundle_rule_id'];
							$FreeCloneItem->effective_discount_bundle_rule_name = $BundleRule['discount_bundle_rule_name'];							
							$FreeCloneItem->effective_discount_bundle_code = $EffectiveDiscountCode;
							$HitQuantity += $FreeCloneItem->quantity;
							array_push($HitItemList, $FreeCloneItem);
						}
					}
					
					if ($QuantityLeft > 0) {
						$LeftCloneItem->quantity = $QuantityLeft;
						array_push($NonHitItemList, $LeftCloneItem);
					}
				}				
			}
			else if ($BundleRule['discount_bundle_discount_type_id'] == 2) {
				// Merge the free and cost aware quantity today...
				$MergeSolution = array();
				foreach ($FreeSolution as $key => $value)
					$MergeSolution[$key] += $value;
				foreach ($CostSolution as $key => $value)
					$MergeSolution[$key] += $value;
				$HitItemIndex = 0;
				foreach ($MyCartItemList as $I) {
					/* @var $I cart_result_product */
					$I->product_base_price_ca = round($I->product_base_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price_ca = round($I->product_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price2_ca = round($I->product_price2 * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price3_ca = round($I->product_price3 * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$LeftCloneItem = clone $I;
					$QuantityLeft = $I->quantity;
					
					if (array_key_exists(strval($I->product_id), $MergeSolution)) {
						$I->quantity = min($QuantityLeft, $MergeSolution[strval($I->product_id)]);
						if ($I->quantity > 0) {
							$QuantityLeft -= $I->quantity;
							$MergeSolution[strval($I->product_id)] -= $I->quantity;

							$CostSolution[strval($I->product_id)] -= $I->quantity;
							if ($CostSolution[strval($I->product_id)] < 0 ) {
								$FreeSolution[strval($I->product_id)] += $CostSolution[strval($I->product_id)];
								$CostSolution[strval($I->product_id)] = 0;
							}
							$I->effective_discount_type = 6;
							$I->effective_discount_bundle_rule_id = $BundleRule['discount_bundle_rule_id'];
							$I->effective_discount_bundle_rule_name = $BundleRule['discount_bundle_rule_name'];							
							$I->effective_discount_bundle_code = $EffectiveDiscountCode;
							$I->discount_desc = "Buy At $" . $BundleRule['discount_bundle_discount2_at_price'];

							$HitItemIndex++;
							if ($HitItemIndex == 1) {
								$I->actual_unit_price = null;
								$I->actual_unit_price_ca = null;
								$I->actual_subtotal_price = $BundleRule['discount_bundle_discount2_at_price'] * $RuleHitNoOfTimes;
								$I->actual_subtotal_price_ca = round($I->actual_subtotal_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);							
							}
							else {
								$I->actual_unit_price = null;
								$I->actual_unit_price_ca = null;
								$I->actual_subtotal_price = null;
								$I->actual_subtotal_price_ca = null;
							}
							$I->product_bonus_point_amount = intval($I->product_bonus_point_amount * $I->quantity);
							$I->product_bonus_point_required = intval($I->product_bonus_point_required * $I->quantity);
							$HitQuantity += $I->quantity;
							array_push($HitItemList, $I);
						}
					}
					
					if ($QuantityLeft > 0) {
						$LeftCloneItem->quantity = $QuantityLeft;
						array_push($NonHitItemList, $LeftCloneItem);
					}
				}
			}
			else if ($BundleRule['discount_bundle_discount_type_id'] == 3) {
				foreach ($MyCartItemList as $I) {
					/* @var $I cart_result_product */
					$I->product_base_price_ca = round($I->product_base_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price_ca = round($I->product_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price2_ca = round($I->product_price2 * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price3_ca = round($I->product_price3 * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$FreeCloneItem = clone $I;
					$LeftCloneItem = clone $I;
					$QuantityLeft = $I->quantity;
					
					if (array_key_exists(strval($I->product_id), $CostSolution)) {
						$I->quantity = min($QuantityLeft, $CostSolution[strval($I->product_id)]);
						if ($I->quantity > 0) {
							$QuantityLeft -= $I->quantity;
							$CostSolution[strval($I->product_id)] -= $I->quantity;
							$I->effective_discount_type = 6;
							$I->actual_unit_price			= $I->product_base_price;
							$I->actual_unit_price_ca		= $I->product_base_price_ca;
							$I->actual_subtotal_price		= round($I->actual_unit_price * $I->quantity, $this->getCurrencyObj()->currency_precision);
							$I->actual_subtotal_price_ca	= round($I->actual_unit_price_ca * $I->quantity, $this->getCurrencyObj()->currency_precision);
							$I->product_bonus_point_amount = intval($I->product_bonus_point_amount * $I->quantity);
							$I->product_bonus_point_required = intval($I->product_bonus_point_required * $I->quantity);
							$I->effective_discount_bundle_rule_id = $BundleRule['discount_bundle_rule_id'];
							$I->effective_discount_bundle_rule_name = $BundleRule['discount_bundle_rule_name'];							
							$I->effective_discount_bundle_code = $EffectiveDiscountCode;
							$HitQuantity += $I->quantity;
							array_push($HitItemList, $I);							
						}
					}
					$HitItemIndex = 0;
					if (array_key_exists(strval($I->product_id), $FreeSolution)) {
						$FreeCloneItem->quantity = min($QuantityLeft, $FreeSolution[strval($I->product_id)]);
						if ($FreeCloneItem->quantity > 0) {
							$QuantityLeft -= $FreeCloneItem->quantity;
							$FreeSolution[strval($I->product_id)] -= $FreeCloneItem->quantity;
							$FreeCloneItem->effective_discount_type = 6;

							$HitItemIndex++;
							if ($HitItemIndex == 1) {
								$FreeCloneItem->actual_unit_price = null;
								$FreeCloneItem->actual_unit_price_ca = null;
								$FreeCloneItem->actual_subtotal_price = $BundleRule['discount_bundle_discount3_add_price'] * $RuleHitNoOfTimes;
								$FreeCloneItem->actual_subtotal_price_ca = round($FreeCloneItem->actual_subtotal_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);

							}
							else {
								$FreeCloneItem->actual_unit_price = null;
								$FreeCloneItem->actual_unit_price_ca = null;
								$FreeCloneItem->actual_subtotal_price = null;
								$FreeCloneItem->actual_subtotal_price_ca = null;							
							}
							$FreeCloneItem->product_bonus_point_amount = intval($FreeCloneItem->product_bonus_point_amount * $FreeCloneItem->quantity);
							$FreeCloneItem->product_bonus_point_required = intval($FreeCloneItem->product_bonus_point_required * $FreeCloneItem->quantity);
							$FreeCloneItem->discount_desc = "Add $" . $BundleRule['discount_bundle_discount3_add_price'];
							$FreeCloneItem->effective_discount_bundle_rule_id = $BundleRule['discount_bundle_rule_id'];
							$FreeCloneItem->effective_discount_bundle_rule_name = $BundleRule['discount_bundle_rule_name'];							
							$FreeCloneItem->effective_discount_bundle_code = $EffectiveDiscountCode;
							$HitQuantity += $FreeCloneItem->quantity;
							array_push($HitItemList, $FreeCloneItem);							
						}
					}
					
					if ($QuantityLeft > 0) {
						$LeftCloneItem->quantity = $QuantityLeft;
						array_push($NonHitItemList, $LeftCloneItem);
					}
				}
			}
			
			$NonHitItemList = array_merge($MyNonHitItemList, $NonHitItemList);
			
			return $HitQuantity;
		}
		else {
			$HitItemList = array();
			$NonHitItemList = $CartItemList;
			return $HitQuantity;			
		}		
	}

	private function ProcessDiscountPreprocessRule($PreprocessRule, $CartItemList, &$HitItemList, &$NonHitItemList) {		
		if (
			($PreprocessRule['discount_preprocess_rule_quota_discount_code'] > 0 && discount::GetPreprocessRuleUsageForDiscountCode($PreprocessRule['discount_preprocess_rule_id'], trim($this->getCartDetailsObj()->discount_code)) >= $PreprocessRule['discount_preprocess_rule_quota_discount_code'])
		) {
			$HitQuantity = 0;
			$HitItemList = array();
			$NonHitItemList = $CartItemList;
			return $HitQuantity;
		}
		
		$EffectiveDiscountCode = '';
		if ($PreprocessRule['discount_preprocess_rule_discount_code'] != ', , ')
			$EffectiveDiscountCode = trim($this->getCartDetailsObj()->discount_code);

		$HitQuantity = 0;

		$MyNonHitItemList = array();
		$MyHitItemList = array();

		$PreprocessItemConditionList = discount::GetPreprocessItemCondition($PreprocessRule['discount_preprocess_rule_id']);
		
		$PreprocessExceptItemConditionList = discount::GetPreprocessItemExceptCondition($PreprocessRule['discount_preprocess_rule_id']);

		foreach ($CartItemList as $I) {
			$IsHit = true;
			
			if ($PreprocessRule['discount_preprocess_rule_apply_to_bonus_point_payment_products'] == 'N' && $I->product_bonus_point_required > 0) {
				array_push($MyNonHitItemList, $I);
				continue;
			}
			
			if ($PreprocessRule['discount_preprocess_rule_apply_to_bonus_point_payment_products'] == 'Y' && $I->product_bonus_point_required > 0 && $PreprocessRule['discount_preprocess_discount_type_id'] == 2) {
				// Check if unit price is good
				$TargetUnitPrice = $PreprocessRule['discount_preprocess_discount2_price'] / $PreprocessRule['discount_preprocess_discount2_amount'];
				
				if ($I->product_base_price < $TargetUnitPrice) {
					array_push($MyNonHitItemList, $I);
					continue;
				}
			}

			foreach ($PreprocessItemConditionList as $Cond) {
				$IsHit = $this->ProcessDiscountPreprocessItemCondition($Cond, $I);
				if (!$IsHit)
					break;
			}
			
			if ($IsHit) {
				foreach ($PreprocessExceptItemConditionList as $Cond) {
					$IsHit = !$this->ProcessDiscountPreprocessExceptItemCondition($Cond, $I);
					if (!$IsHit)
						break;
				}				
			}				

			if ($IsHit) {
				array_push($MyHitItemList, $I);
				$HitQuantity += $I->quantity;
			}
			else
				array_push($MyNonHitItemList, $I);
		}

		if ($HitQuantity == 0) {
			$HitItemList = array();
			$NonHitItemList = $CartItemList;
			return $HitQuantity;
		}

		// Now apply the rule to the item
		if ($PreprocessRule['discount_preprocess_discount_type_id'] == 1) {
			// Quantity X(discount1_min_quantity) or above, Y%(discount1_off_p) Off
			if ($PreprocessRule['discount_preprocess_discount1_min_quantity'] > $HitQuantity) {
				// Not enough qty to qualify
				$HitQuantity = 0;
				$HitItemList = array();
				$NonHitItemList = $CartItemList;
				return $HitQuantity;
			}
			else {
				// Now check for maximum allowed 
				$AllowedUserQtyLeft		= 999999;
				$AllowedGlobalQtyLeft	= 999999;
				if ($PreprocessRule['discount_preprocess_rule_quota_user'] > 0) {
					$AllowedUserQtyLeft = $PreprocessRule['discount_preprocess_rule_quota_user'] - discount::GetPreprocessRuleQtyUsageForUser($PreprocessRule['discount_preprocess_rule_id'], $this->user_id);
					if ($AllowedUserQtyLeft < 0)
						$AllowedUserQtyLeft = 0;
				}
				if ($PreprocessRule['discount_preprocess_rule_quota_all'] > 0) {
					$AllowedGlobalQtyLeft = $PreprocessRule['discount_preprocess_rule_quota_all'] - discount::GetPreprocessRuleQtyUsageForGlobal($PreprocessRule['discount_preprocess_rule_id']);
					if ($AllowedGlobalQtyLeft < 0)
						$AllowedGlobalQtyLeft = 0;
				}
				$EffectiveDiscountQuantity = min($AllowedGlobalQtyLeft, $AllowedUserQtyLeft);

				$TargetQuantity = $EffectiveDiscountQuantity;

				foreach ($MyHitItemList as $Key => $I) {
					/* @var $I cart_result_product */
					$I->product_base_price_ca = round($I->product_base_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price_ca = round($I->product_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price2_ca = round($I->product_price2 * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price3_ca = round($I->product_price3 * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);

					if ($TargetQuantity >= $I->quantity) {
						$TargetQuantity = $TargetQuantity - $I->quantity;
						$I->product_base_price_ca 	= round($I->product_base_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
						$I->actual_unit_price			= round($I->product_base_price * (100 - $PreprocessRule['discount_preprocess_discount1_off_p']) / 100, $this->getCurrencyObj()->currency_precision);
						$I->actual_unit_price_ca		= round($I->product_base_price_ca * (100 - $PreprocessRule['discount_preprocess_discount1_off_p']) / 100, $this->getCurrencyObj()->currency_precision);
						$I->actual_subtotal_price		= round($I->actual_unit_price * $I->quantity, $this->getCurrencyObj()->currency_precision);
						$I->actual_subtotal_price_ca	= round($I->actual_unit_price_ca * $I->quantity, $this->getCurrencyObj()->currency_precision);
						$I->discount_desc = $PreprocessRule['discount_preprocess_discount1_off_p'] . "% OFF";
						$I->effective_discount_type = 5;
						$I->effective_discount_preprocess_rule_id = $PreprocessRule['discount_preprocess_rule_id'];
						$I->effective_discount_preprocess_rule_name = $PreprocessRule['discount_preprocess_rule_name'];
						$I->effective_discount_preprocess_code = $EffectiveDiscountCode;
						$I->product_bonus_point_amount = intval($I->product_bonus_point_amount * $I->quantity);
						$I->product_bonus_point_required = intval($I->product_bonus_point_required * $I->quantity);

						array_push($HitItemList, $I);
					}
					else {
						if ($TargetQuantity > 0) {
							$MyRow = clone $I;
							$MyRow->quantity = $TargetQuantity;
							$MyRow->product_base_price_ca 	= round($MyRow->product_base_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
							$MyRow->actual_unit_price			= round($MyRow->product_base_price * (100 - $PreprocessRule['discount_preprocess_discount1_off_p']) / 100, $this->getCurrencyObj()->currency_precision);
							$MyRow->actual_unit_price_ca		= round($MyRow->product_base_price_ca * (100 - $PreprocessRule['discount_preprocess_discount1_off_p']) / 100, $this->getCurrencyObj()->currency_precision);
							$MyRow->actual_subtotal_price		= round($MyRow->actual_unit_price * $MyRow->quantity, $this->getCurrencyObj()->currency_precision);
							$MyRow->actual_subtotal_price_ca	= round($MyRow->actual_unit_price_ca * $MyRow->quantity, $this->getCurrencyObj()->currency_precision);
							$MyRow->discount_desc = $PreprocessRule['discount_preprocess_discount1_off_p'] . "% OFF";
							$MyRow->effective_discount_type = 5;
							$MyRow->effective_discount_preprocess_rule_id = $PreprocessRule['discount_preprocess_rule_id'];
							$MyRow->effective_discount_preprocess_rule_name = $PreprocessRule['discount_preprocess_rule_name'];
							$MyRow->effective_discount_preprocess_code = $EffectiveDiscountCode;
							$MyRow->product_bonus_point_amount = intval($MyRow->product_bonus_point_amount * $MyRow->quantity);
							$MyRow->product_bonus_point_required = intval($MyRow->product_bonus_point_required * $MyRow->quantity);

							array_push($HitItemList, $MyRow);
						}

						$I->quantity = $I->quantity - $TargetQuantity;
						array_push($MyNonHitItemList, $I);
						$TargetQuantity = 0;
					}
				}
				$NonHitItemList = $MyNonHitItemList;

				$HitQuantity = $EffectiveDiscountQuantity;
				return $HitQuantity;
			}
		}
		elseif ($PreprocessRule['discount_preprocess_discount_type_id'] == 2) {
			//	$X for Y
//				if ($PreprocessRule['discount_preprocess_discount2_amount'] > $HitQuantity || $PreprocessRule['discount_preprocess_discount2_amount'] <= 1) {
//				Update: 2012/05/30 discoun2_amount = 1 should be valid here! $100 for 1
			if ($PreprocessRule['discount_preprocess_discount2_amount'] > $HitQuantity || $PreprocessRule['discount_preprocess_discount2_amount'] <= 0) {
				$HitItemList = array();
				$NonHitItemList = $CartItemList;
				return 0;
			}
			else {
				$PreprocessRule['discount_preprocess_discount2_price_ca'] = round($PreprocessRule['discount_preprocess_discount2_price'] * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);

				$AllowedUserQtyLeft		= 999999;
				$AllowedGlobalQtyLeft	= 999999;
				if ($PreprocessRule['discount_preprocess_rule_quota_user'] > 0) {
					$AllowedUserQtyLeft = $PreprocessRule['discount_preprocess_rule_quota_user'] - discount::GetPreprocessRuleQtyUsageForUser($PreprocessRule['discount_preprocess_rule_id'], $this->user_id);
					if ($AllowedUserQtyLeft < 0)
						$AllowedUserQtyLeft = 0;
				}
				if ($PreprocessRule['discount_preprocess_rule_quota_all'] > 0) {
					$AllowedGlobalQtyLeft = $PreprocessRule['discount_preprocess_rule_quota_all'] - discount::GetPreprocessRuleQtyUsageForGlobal($PreprocessRule['discount_preprocess_rule_id']);
					if ($AllowedGlobalQtyLeft < 0)
						$AllowedGlobalQtyLeft = 0;
				}
				$QtyToCal = min($AllowedGlobalQtyLeft, $AllowedUserQtyLeft, $HitQuantity);

				$EffectiveDiscountQuantity	= floor($QtyToCal / $PreprocessRule['discount_preprocess_discount2_amount']) * $PreprocessRule['discount_preprocess_discount2_amount'];

				$EffectiveNormalQuantity	= $HitQuantity - $EffectiveDiscountQuantity;

				$TargetQuantity = $EffectiveDiscountQuantity;

				foreach ($MyHitItemList as $Key => $I) {

					$I->product_base_price_ca = round($I->product_base_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price_ca = round($I->product_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price2_ca = round($I->product_price2 * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
					$I->product_price3_ca = round($I->product_price3 * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);

					if ($TargetQuantity >= $I->quantity) {
						$TargetQuantity = $TargetQuantity - $I->quantity;

						if ($Key > 0) {
							if ($PreprocessRule['discount_preprocess_discount2_amount'] == 1) {
								$I->actual_subtotal_price		= $PreprocessRule['discount_preprocess_discount2_price'] * $I->quantity;
								$I->actual_subtotal_price_ca	= $PreprocessRule['discount_preprocess_discount2_price_ca'] * $I->quantity;
								$I->actual_unit_price			= $PreprocessRule['discount_preprocess_discount2_price'];
								$I->actual_unit_price_ca		= $PreprocessRule['discount_preprocess_discount2_price_ca'];
							}
							else {
								$I->actual_subtotal_price		= null;
								$I->actual_subtotal_price_ca	= null;
								$I->actual_unit_price			= null;
								$I->actual_unit_price_ca		= null;
							}
						}
						else {
							if ($PreprocessRule['discount_preprocess_discount2_amount'] == 1) {
								$I->actual_subtotal_price		= $PreprocessRule['discount_preprocess_discount2_price'] * $I->quantity;
								$I->actual_subtotal_price_ca	= $PreprocessRule['discount_preprocess_discount2_price_ca'] * $I->quantity;
								$I->actual_unit_price			= $PreprocessRule['discount_preprocess_discount2_price'];
								$I->actual_unit_price_ca		= $PreprocessRule['discount_preprocess_discount2_price_ca'];
							}
							else {
								$I->actual_subtotal_price		= floor($EffectiveDiscountQuantity / $PreprocessRule['discount_preprocess_discount2_amount']) * $PreprocessRule['discount_preprocess_discount2_price'];
								$I->actual_subtotal_price_ca	= floor($EffectiveDiscountQuantity / $PreprocessRule['discount_preprocess_discount2_amount']) * $PreprocessRule['discount_preprocess_discount2_price_ca'];
								$I->actual_unit_price			= null;
								$I->actual_unit_price_ca		= null;
							}
						}

						if ($PreprocessRule['discount_preprocess_discount2_amount'] > 1)
						$I->discount_desc = $PreprocessRule['discount_preprocess_discount2_price_ca'] . " FOR " . $PreprocessRule['discount_preprocess_discount2_amount'];
						$I->effective_discount_type = 5;
						$I->effective_discount_preprocess_rule_id = $PreprocessRule['discount_preprocess_rule_id'];
						$I->effective_discount_preprocess_rule_name = $PreprocessRule['discount_preprocess_rule_name'];
						$I->effective_discount_preprocess_code = $EffectiveDiscountCode;
						$I->product_bonus_point_amount = intval($I->product_bonus_point_amount * $I->quantity);
						$I->product_bonus_point_required = intval($I->product_bonus_point_required * $I->quantity);
						array_push($HitItemList, $I);
					}
					else {
						if ($TargetQuantity > 0) {
							$MyRow = clone $I;
							$MyRow->quantity = $TargetQuantity;

							if ($PreprocessRule['discount_preprocess_discount2_amount'] > 1)
							$MyRow->discount_desc = $PreprocessRule['discount_preprocess_discount2_price_ca'] . " FOR " . $PreprocessRule['discount_preprocess_discount2_amount'];
							$MyRow->effective_discount_type = 5;
							$MyRow->effective_discount_preprocess_rule_id = $PreprocessRule['discount_preprocess_rule_id'];
							$MyRow->effective_discount_preprocess_rule_name = $PreprocessRule['discount_preprocess_rule_name'];
							$MyRow->effective_discount_preprocess_code = $EffectiveDiscountCode;
							$MyRow->product_bonus_point_amount = intval($MyRow->product_bonus_point_amount * $MyRow->quantity);
							$MyRow->product_bonus_point_required = intval($MyRow->product_bonus_point_required * $MyRow->quantity);

							if ($Key > 0) {
								if ($PreprocessRule['discount_preprocess_discount2_amount'] == 1) {
									$MyRow->actual_subtotal_price		= $PreprocessRule['discount_preprocess_discount2_price'] * $MyRow->quantity;
									$MyRow->actual_subtotal_price_ca	= $PreprocessRule['discount_preprocess_discount2_price_ca'] * $MyRow->quantity;
									$MyRow->actual_unit_price			= $PreprocessRule['discount_preprocess_discount2_price'];
									$MyRow->actual_unit_price_ca		= $PreprocessRule['discount_preprocess_discount2_price_ca'];
								}
								else {
									$MyRow->actual_subtotal_price		= null;
									$MyRow->actual_subtotal_price_ca	= null;
									$MyRow->actual_unit_price		= null;
									$MyRow->actual_unit_price_ca	= null;
								}
							}
							else {
								if ($PreprocessRule['discount_preprocess_discount2_amount'] == 1) {
									$MyRow->actual_subtotal_price		= $PreprocessRule['discount_preprocess_discount2_price'] * $MyRow->quantity;
									$MyRow->actual_subtotal_price_ca	= $PreprocessRule['discount_preprocess_discount2_price_ca'] * $MyRow->quantity;
									$MyRow->actual_unit_price			= $PreprocessRule['discount_preprocess_discount2_price'];
									$MyRow->actual_unit_price_ca		= $PreprocessRule['discount_preprocess_discount2_price_ca'];
								}
								else {
									$MyRow->actual_subtotal_price		= floor($EffectiveDiscountQuantity / $PreprocessRule['discount_preprocess_discount2_amount']) * $PreprocessRule['discount_preprocess_discount2_price'];
									$MyRow->actual_subtotal_price_ca	= floor($EffectiveDiscountQuantity / $PreprocessRule['discount_preprocess_discount2_amount']) * $PreprocessRule['discount_preprocess_discount2_price_ca'];
									$MyRow->actual_unit_price			= null;
									$MyRow->actual_unit_price_ca		= null;
								}
							}
							array_push($HitItemList, $MyRow);
						}

						$I->quantity = $I->quantity - $TargetQuantity;
						array_push($MyNonHitItemList, $I);
						$TargetQuantity = 0;
					}
				}
				$NonHitItemList = $MyNonHitItemList;

				$HitQuantity = $EffectiveDiscountQuantity;
				return $HitQuantity;
			}
		}
		else {
			$HitItemList = array();
			$NonHitItemList = $CartItemList;
			return $HitQuantity;
		}
	}
	
	private function ProcessCartProductItemList() {
		$this->quantity_adjusted_cart_content_id_array = array();
		
		$inventory_sql = '';

		$sql = '';
		if ($this->HonorArchiveDate)
			$sql	=	$sql . "	AND	O.object_archive_date > NOW() ";
		if ($this->HonorPublishDate)
			$sql	=	$sql . "	AND	O.object_publish_date < NOW() ";
		
		//	20151109
		//	A JOIN to parent object (PO) is required because OL.object_link_is_enable must be checked for PRODUCT_ROOT or PRODUCT_CATEGORY but not PRODUCT_BRAND or PRODUCT_SPECIAL_CATEGORY
		$query =	"	SELECT		*, W.*, P.*, OL.*, O.*, PP.*, P.product_price AS product_price, PP.product_price AS product_base_price " .
					"	FROM					product P				" .
					"				JOIN		cart_content W			ON	(P.product_id = W.product_id) " .
					"				JOIN		product_price PP		ON	(W.product_id = PP.product_id AND W.product_price_id = PP.product_price_id AND PP.currency_id = '" . $this->getEffectiveProductPriceCurrencyID() . "') " .
					"				JOIN		object O				ON	(O.object_id = P.product_id) " .
					"				JOIN		object_link OL 			ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"				JOIN		object PO 				ON	(OL.parent_object_id = PO.object_id) " .
					"				LEFT JOIN	product_option POO		ON	(W.product_option_id = POO.product_option_id AND W.product_id = POO.product_id) " .
					"	WHERE		O.object_is_enable = 'Y' " .
					"			AND	OL.object_link_is_enable = 'Y' " .
					"			AND O.object_security_level <= '" . $this->getUserSecurityLevel() . "'" . $sql .
					"			AND	W.cart_content_type = '" . $this->cart_content_type . "'" .
					"			AND	W.user_id = '" . $this->user_id . "'" .
					"			AND	W.site_id = '" . $this->site_id . "'" .
					"			AND	W.system_admin_id = '" . $this->system_admin_id . "'" .
					"			AND	W.content_admin_id = '" . $this->content_admin_id . "'" .
					"			AND	( PO.object_type = 'PRODUCT_ROOT' OR PO.object_type = 'PRODUCT_CATEGORY' ) " . $inventory_sql . 
					"	GROUP BY	P.product_id, W.product_option_id, W.product_price_id, W.cart_content_custom_key " .
					"	ORDER BY	PP.product_price " . $this->getSiteObj()->site_product_price_process_order . ", P.product_id ASC, W.product_option_id ASC, PP.product_price_id ASC, W.cart_content_custom_desc ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$AllCartItemList = array();
		$ProductTotalQuantity = array();
		$InventoryLookupTable = array();
		
		/* @var $myResult cart_result_product */
		while ($myResult = $result->fetch_object('cart_result_product')) {
						
			if ($this->site_id != 0 &&
				$this->getSiteObj()->site_module_inventory_enable == 'Y' &&
				$this->getSiteObj()->site_product_allow_under_stock == 'N') {
			
				$InventoryLevelQuantity = 0;
				$LookupCode = strval(intval($myResult->product_id)) . "_"  . strval(intval($myResult->product_option_id));

				if (intval($myResult->product_option_id) > 0) {
					$InventoryLevelQuantity = intval($myResult->product_option_stock_level);
				}
				else {
					$InventoryLevelQuantity = intval($myResult->product_stock_level);
				}

				if ($InventoryLookupTable[$LookupCode] === null) {
					$InventoryLookupTable[$LookupCode] = $InventoryLevelQuantity;
				}

				$AdjustedQuantity = min($InventoryLookupTable[$LookupCode], $myResult->quantity);
			}
			else {
				$AdjustedQuantity = $myResult->quantity;
			}
			
			if ($AdjustedQuantity != $myResult->quantity) {
				$this->under_stock_adjustment = true;
				$myResult->quantity_adjusted = true;
				$myResult->quantity_original = $myResult->quantity;
				$myResult->quantity = $AdjustedQuantity;
				$InventoryLookupTable[$LookupCode] -= $AdjustedQuantity;
				array_push($this->quantity_adjusted_cart_content_id_array, $myResult->cart_content_id);
			}
			else {
				$myResult->quantity_adjusted = false;
				$myResult->quantity_original = $myResult->quantity;
			}
			
			array_push($AllCartItemList, $myResult);
		}

		$IsEnabled = 'Y';
		if ($this->cart_content_type == 'test')
			$IsEnabled = 'ALL';
		$BundleRuleList = discount::GetBundleRuleList($this->site_id, $IsEnabled, $this->getUserSecurityLevel(), $this->HonorArchiveDate, $this->HonorPublishDate, $this->getCartDetailsObj()->discount_code, true, $this->getEffectiveProductPriceCurrencyID(), $this->lang_id);
		$DiscountRuleList = discount::GetPreprocessRuleList($this->site_id, $IsEnabled, $this->getUserSecurityLevel(), $this->HonorArchiveDate, $this->HonorPublishDate, $this->getCartDetailsObj()->discount_code, true, $this->getEffectiveProductPriceCurrencyID(), $this->lang_id);
		$HitItemList = array();
		$NonHitItemList = $AllCartItemList;

		$this->ContinuePostProcessRule = true;
		$this->ContinuePreProcessRule = true;
		
		foreach ($BundleRuleList as $R) {
			$MyHitItemList = array();
			$MyNonHitItemList = array();
			$HitQuantity = $this->ProcessDiscountBundleRule($R, $NonHitItemList, $MyHitItemList, $MyNonHitItemList);
			$HitItemList = array_merge($HitItemList, $MyHitItemList);
			$NonHitItemList = $MyNonHitItemList;

			if ($HitQuantity > 0 && $R['discount_bundle_rule_stop_process_prepostprocess_rules'] == 'Y') {
				$this->ContinuePostProcessRule = false;
				$this->ContinuePreProcessRule = false;
			}

			if ($HitQuantity > 0 && $R['discount_bundle_rule_stop_process_below_rules'] == 'Y')
				break;
			
		}
		
		if ($this->ContinuePreProcessRule) {
			foreach ($DiscountRuleList as $R) {
				$MyHitItemList = array();
				$MyNonHitItemList = array();
				$HitQuantity = $this->ProcessDiscountPreprocessRule($R, $NonHitItemList, $MyHitItemList, $MyNonHitItemList);
				$HitItemList = array_merge($HitItemList, $MyHitItemList);
				$NonHitItemList = $MyNonHitItemList;

				if ($HitQuantity > 0 && $R['discount_preprocess_rule_stop_process_postprocess_rules'] == 'Y')
					$this->ContinuePostProcessRule = false;

				if ($HitQuantity > 0 && $R['discount_preprocess_rule_stop_process_below_rules'] == 'Y')
					break;
			}			
		}

		$LastProductID = -999;
		$LastProductPriceID = -999;
		$EffectiveDiscountQuantity	= 0;
		$EffectiveFreeQuantity		= 0;
		$EffectiveNormalQuantity	= 0;
		$TargetQuantity = 0;

		$this->calculated_product_list = $HitItemList;
		
		foreach ($NonHitItemList as $myResult) {
			$ProductTotalQuantity[$myResult->product_id . "_" . $myResult->product_price_id] = intval($ProductTotalQuantity[$myResult->product_id . "_" . $myResult->product_price_id]) + $myResult->quantity;			
		}
		
		foreach ($NonHitItemList as $myResult) {
			$myResult->product_base_price_ca = round($myResult->product_base_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
			
			$myResult->product_price_ca = round($myResult->product_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
			$myResult->product_price2_ca = round($myResult->product_price2 * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
			$myResult->product_price3_ca = round($myResult->product_price3 * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);

			$myResult->discount2_price_ca = round($myResult->discount2_price * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
			if ($myResult->product_id != $LastProductID || $myResult->product_price_id != $LastProductPriceID) {
				if ($myResult->discount_type == 0) {
					$myResult->effective_discount_type = 0;
					$myResult->actual_subtotal_price		= $myResult->product_base_price * $myResult->quantity;
					$myResult->actual_subtotal_price_ca	= $myResult->product_base_price_ca * $myResult->quantity;

					$myResult->actual_unit_price		= $myResult->product_base_price;
					$myResult->actual_unit_price_ca	= $myResult->product_base_price_ca;

					$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
					$myResult->product_bonus_point_required = intval($myResult->product_bonus_point_required * $myResult->quantity);
					$LastProductID = -999;
					$LastProductPriceID = -999;
					array_push($this->calculated_product_list, $myResult);
				}
				elseif ($myResult->discount_type == 1) {
					$myResult->actual_unit_price = round($myResult->product_base_price * (100 - $myResult->discount1_off_p) / 100, $this->getCurrencyObj()->currency_precision);
					$myResult->actual_unit_price_ca	= round($myResult->product_base_price_ca * (100 - $myResult->discount1_off_p) / 100, $this->getCurrencyObj()->currency_precision);

					$myResult->actual_subtotal_price = round($myResult->actual_unit_price * $myResult->quantity, $this->getCurrencyObj()->currency_precision);
					$myResult->actual_subtotal_price_ca	= round($myResult->actual_unit_price_ca * $myResult->quantity, $this->getCurrencyObj()->currency_precision);

					$myResult->discount_desc = $myResult->discount1_off_p . "% OFF";
					$myResult->effective_discount_type = 1;
					$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
					$myResult->product_bonus_point_required = intval($myResult->product_bonus_point_required * $myResult->quantity);
					$LastProductID = -999;
					$LastProductPriceID = -999;
					array_push($this->calculated_product_list, $myResult);
				}
				elseif ($myResult->discount_type == 2 ) {
					if ($myResult->discount2_amount <= 1) {
						// $100 for 1? Must be something wrong, so no discount
						$myResult->effective_discount_type = 0;
						$myResult->actual_subtotal_price = $myResult->product_base_price * $myResult->quantity;
						$myResult->actual_subtotal_price_ca	= $myResult->product_base_price_ca * $myResult->quantity;
						$myResult->actual_unit_price = $myResult->product_base_price;
						$myResult->actual_unit_price_ca	= $myResult->product_base_price_ca;
						$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
						$myResult->product_bonus_point_required = intval($myResult->product_bonus_point_required * $myResult->quantity);
						$LastProductID = -999;
						$LastProductPriceID = -999;
						array_push($this->calculated_product_list, $myResult);
					}
					else {
						$EffectiveDiscountQuantity = floor($ProductTotalQuantity[$myResult->product_id . "_" . $myResult->product_price_id] / $myResult->discount2_amount) * $myResult->discount2_amount;
						$EffectiveNormalQuantity = $myResult->quantity - $EffectiveDiscountQuantity;
						$TargetQuantity = $EffectiveDiscountQuantity;
						$LastProductID = $myResult->product_id;
						$LastProductPriceID = $myResult->product_price_id;

						if ($TargetQuantity >= $myResult->quantity) {
							$TargetQuantity = $TargetQuantity - $myResult->quantity;
							$myResult->actual_subtotal_price		= floor($ProductTotalQuantity[$myResult->product_id . "_" . $myResult->product_price_id] / $myResult->discount2_amount) * $myResult->discount2_price;
							$myResult->actual_subtotal_price_ca	= floor($ProductTotalQuantity[$myResult->product_id . "_" . $myResult->product_price_id] / $myResult->discount2_amount) * $myResult->discount2_price_ca;
							$myResult->actual_unit_price		= null;
							$myResult->actual_unit_price_ca	= null;

							$myResult->discount_desc = $myResult->discount2_price_ca . " FOR " . $myResult->discount2_amount;
							$myResult->effective_discount_type = 2;
							$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
							$myResult->product_bonus_point_required = intval($myResult->product_bonus_point_required * $myResult->quantity);
							array_push($this->calculated_product_list, $myResult);
						}
						else {
							if ($TargetQuantity > 0) {
								/* @var $MyRow cart_result_product */
								$MyRow = clone $myResult;
								$MyRow->actual_subtotal_price		= floor($myResult->quantity / $myResult->discount2_amount) * $myResult->discount2_price;
								$MyRow->actual_subtotal_price_ca	= floor($myResult->quantity / $myResult->discount2_amount) * $myResult->discount2_price_ca;
								$MyRow->actual_unit_price		= null;
								$MyRow->actual_unit_price_ca	= null;
								$MyRow->quantity = $TargetQuantity;
								$MyRow->discount_desc = $myResult->discount2_price_ca . " FOR " . $myResult->discount2_amount;
								$MyRow->effective_discount_type = 2;
								$MyRow->product_bonus_point_amount = intval($MyRow->product_bonus_point_amount * $MyRow->quantity);
								$MyRow->product_bonus_point_required = intval($MyRow->product_bonus_point_required * $MyRow->quantity);
								array_push($this->calculated_product_list, $MyRow);
							}

							$myResult->quantity = $myResult->quantity - $TargetQuantity;
							$myResult->actual_subtotal_price		= $myResult->product_base_price * $myResult->quantity;
							$myResult->actual_subtotal_price_ca	= $myResult->product_base_price_ca * $myResult->quantity;
							$myResult->actual_unit_price		= $myResult->product_base_price;
							$myResult->actual_unit_price_ca	= $myResult->product_base_price_ca;
							$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
							$myResult->product_bonus_point_required = intval($myResult->product_bonus_point_required * $myResult->quantity);
							$myResult->effective_discount_type = 0;
							array_push($this->calculated_product_list, $myResult);

							$TargetQuantity = 0;
						}
					}
				}
				elseif ($myResult->discount_type == 3) {
					if ($myResult->discount3_buy_amount < 1 || $myResult->discount3_free_amount < 1) {
						// Buy 0 Get 1 Free??? Must be something wrong, so no discount
						$myResult->actual_subtotal_price		= $myResult->product_base_price * $myResult->quantity;
						$myResult->actual_subtotal_price_ca	= $myResult->product_base_price_ca * $myResult->quantity;
						$myResult->actual_unit_price		= $myResult->product_base_price;
						$myResult->actual_unit_price_ca	= $myResult->product_base_price_ca;
						$myResult->effective_discount_type = 0;
						$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
						$myResult->product_bonus_point_required = intval($myResult->product_bonus_point_required * $myResult->quantity);
						$LastRemainingRow == -999;
						array_push($this->calculated_product_list, $myResult);
					}
					else {
//							$EffectiveFreeQuantity		= floor($myResult->quantity / ($myResult->discount3_buy_amount + $myResult->discount3_free_amount)) * $myResult->discount3_free_amount;
						$EffectiveFreeQuantity		= floor($ProductTotalQuantity[$myResult->product_id . "_" . $myResult->product_price_id] / ($myResult->discount3_buy_amount + $myResult->discount3_free_amount)) * $myResult->discount3_free_amount;
						$EffectiveNormalQuantity	= $ProductTotalQuantity[$myResult->product_id . "_" . $myResult->product_price_id] - $EffectiveFreeQuantity;
						$TargetQuantity = $EffectiveNormalQuantity;
						$LastProductID = $myResult->product_id;
						$LastProductPriceID = $myResult->product_price_id;

						if ($TargetQuantity >= $myResult->quantity) {
							$TargetQuantity = $TargetQuantity - $myResult->quantity;
							$myResult->actual_subtotal_price		= $myResult->product_base_price * $myResult->quantity;
							$myResult->actual_subtotal_price_ca	= $myResult->product_base_price_ca * $myResult->quantity;
							$myResult->actual_unit_price		= $myResult->product_base_price;
							$myResult->actual_unit_price_ca	= $myResult->product_base_price_ca;
							$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
							$myResult->product_bonus_point_required = intval($myResult->product_bonus_point_required * $myResult->quantity);
							$myResult->effective_discount_type = 0;
							array_push($this->calculated_product_list, $myResult);
						}
						else {
							if ($TargetQuantity > 0) {
								$MyRow = clone $myResult;
								$MyRow->quantity = $TargetQuantity;
								$MyRow->actual_subtotal_price		= $MyRow->product_base_price * $MyRow->quantity;
								$MyRow->actual_subtotal_price_ca	= $MyRow->product_base_price_ca * $MyRow->quantity;
								$MyRow->actual_unit_price		= $MyRow->product_base_price;
								$MyRow->actual_unit_price_ca	= $MyRow->product_base_price_ca;
								$MyRow->product_bonus_point_amount = intval($MyRow->product_bonus_point_amount * $MyRow->quantity);
								$MyRow->product_bonus_point_required = intval($MyRow->product_bonus_point_required * $MyRow->quantity);
								$myResult->effective_discount_type = 0;
								array_push($this->calculated_product_list, $MyRow);
							}

							$myResult->quantity = $myResult->quantity - $TargetQuantity;
							$myResult->actual_subtotal_price		= 0;
							$myResult->actual_subtotal_price_ca	= 0;
							$myResult->actual_unit_price		= 0;
							$myResult->actual_unit_price_ca	= 0;
							$myResult->discount_desc = "BUY " . $myResult->discount3_buy_amount . " GET " . $myResult->discount3_free_amount . " FREE";
							$myResult->effective_discount_type = 3;
							$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
							$myResult->product_bonus_point_required = intval($myResult->product_bonus_point_required * $myResult->quantity);
							array_push($this->calculated_product_list, $myResult);

							$TargetQuantity = 0;
						}
					}
				}
				elseif ($myResult->discount_type == 4) {
					$CurrencyIdToPass = 0;
					
					if ($this->getSiteObj()->site_product_price_indepedent_currency == 'Y') {
						$CurrencyIdToPass = $this->getCurrencyObj()->currency_id;
					}
					
					$EffectiveProductPriceLevel = product::GetEffectiveProductPriceLevel($myResult->product_id, $ProductTotalQuantity[$myResult->product_id . "_" . $myResult->product_price_id], $myResult->product_price_id, $CurrencyIdToPass);

					$myResult->product_base_price = $EffectiveProductPriceLevel['product_price_level_price'];
					$myResult->product_base_price_ca = round($EffectiveProductPriceLevel['product_price_level_price'] * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);

					$myResult->effective_discount_type = 4;
					$myResult->actual_subtotal_price		= $EffectiveProductPriceLevel['product_price_level_price'] * $myResult->quantity;
					$myResult->actual_subtotal_price_ca	= $myResult->product_base_price_ca * $myResult->quantity;

					$myResult->actual_unit_price		= $EffectiveProductPriceLevel['product_price_level_price'];
					$myResult->actual_unit_price_ca	= $myResult->product_base_price_ca;

					$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
					$myResult->product_bonus_point_required = intval($myResult->product_bonus_point_required * $myResult->quantity);
					$LastProductID = -999;
					$LastProductPriceID = -999;
					array_push($this->calculated_product_list, $myResult);
				}
			}
			else {
				if ($myResult->discount_type == 2 ) {
					if ($TargetQuantity >= $myResult->quantity) {
						$TargetQuantity = $TargetQuantity - $myResult->quantity;
						$myResult->actual_subtotal_price		= null;
						$myResult->actual_subtotal_price_ca	= null;
						$myResult->actual_unit_price		= null;
						$myResult->actual_unit_price_ca	= null;
						$myResult->discount_desc = $myResult->discount2_price_ca . " FOR " . $myResult->discount2_amount;
						$myResult->effective_discount_type = 2;
						$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
						$myResult->product_bonus_point_required = intval($myResult->product_bonus_point_required * $myResult->quantity);
						array_push($this->calculated_product_list, $myResult);
					}
					else {
						if ($TargetQuantity > 0) {
							$MyRow = clone $myResult;
							$MyRow->actual_subtotal_price		= null;
							$MyRow->actual_subtotal_price_ca	= null;
							$MyRow->actual_unit_price		= null;
							$MyRow->actual_unit_price_ca	= null;
							$MyRow->quantity = $TargetQuantity;
							$MyRow->discount_desc = $myResult->discount2_price_ca . " FOR " . $myResult->discount2_amount;
							$MyRow->effective_discount_type = 2;
							$MyRow->product_bonus_point_amount = intval($MyRow->product_bonus_point_amount * $MyRow->quantity);
							$MyRow->product_bonus_point_required = intval($MyRow->product_bonus_point_required * $MyRow->quantity);
							array_push($this->calculated_product_list, $MyRow);
						}

						$myResult->quantity = $myResult->quantity - $TargetQuantity;
						$myResult->actual_subtotal_price		= $myResult->product_base_price * $myResult->quantity;
						$myResult->actual_subtotal_price_ca	= $myResult->product_base_price_ca * $myResult->quantity;
						$myResult->actual_unit_price		= $myResult->product_base_price;
						$myResult->actual_unit_price_ca	= $myResult->product_base_price_ca;
						$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
						$myResult->product_bonus_point_required = intval($myResult->product_bonus_point_required * $myResult->quantity);
						$myResult->effective_discount_type = 0;
						array_push($this->calculated_product_list, $myResult);

						$TargetQuantity = 0;
					}
				}
				elseif ($myResult->discount_type == 3 ) {
					if ($TargetQuantity >= $myResult->quantity) {
						$TargetQuantity = $TargetQuantity - $myResult->quantity;
						$myResult->actual_subtotal_price		= $myResult->product_base_price * $myResult->quantity;
						$myResult->actual_subtotal_price_ca	= $myResult->product_base_price_ca * $myResult->quantity;
						$myResult->actual_unit_price		= $myResult->product_base_price;
						$myResult->actual_unit_price_ca	= $myResult->product_base_price_ca;
						$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
						$myResult->product_bonus_point_required = intval($myResult->product_bonus_point_required * $myResult->quantity);
						$myResult->effective_discount_type = 0;
						array_push($this->calculated_product_list, $myResult);
					}
					else {
						if ($TargetQuantity > 0) {
							$MyRow = clone $myResult;
							$MyRow->quantity = $TargetQuantity;
							$MyRow->actual_subtotal_price		= $MyRow->product_base_price * $MyRow->quantity;
							$MyRow->actual_subtotal_price_ca	= $MyRow->product_base_price_ca * $MyRow->quantity;
							$MyRow->actual_unit_price		= $MyRow->product_base_price;
							$MyRow->actual_unit_price_ca	= $MyRow->product_base_price_ca;
							$MyRow->product_bonus_point_amount = intval($MyRow->product_bonus_point_amount * $MyRow->quantity);
							$MyRow->product_bonus_point_required = intval($MyRow->product_bonus_point_required * $MyRow->quantity);
							$MyRow->effective_discount_type = 0;
							array_push($this->calculated_product_list, $MyRow);
						}

						$myResult->quantity = $myResult->quantity - $TargetQuantity;
						$myResult->actual_subtotal_price		= 0;
						$myResult->actual_subtotal_price_ca	= 0;
						$myResult->actual_unit_price		= 0;
						$myResult->actual_unit_price_ca	= 0;
						$myResult->discount_desc = "BUY " . $myResult->discount3_buy_amount . " GET " . $myResult->discount3_free_amount . " FREE";
						$myResult->effective_discount_type = 3;
//						$myResult->product_bonus_point_amount = intval($myResult->product_bonus_point_amount * $myResult->quantity);
						$myResult->product_bonus_point_amount = 0;
						$myResult->product_bonus_point_required = 0;
						array_push($this->calculated_product_list, $myResult);

						$TargetQuantity = 0;
					}
				}
			}
		}
		
		foreach($this->calculated_product_list as $Item) {
			/* @var $Item cart_result_product */
			$this->total_bonus_point_required_for_product_cart += $Item->product_bonus_point_required;
			$this->total_bonus_point += $Item->product_bonus_point_amount;
			$this->total_price += $Item->actual_subtotal_price;
			$this->total_price_ca += $Item->actual_subtotal_price_ca;
			$this->total_listed_price += ($Item->product_price * $Item->quantity);
			$this->total_listed_price_ca += ($Item->product_price_ca * $Item->quantity);
			$this->total_quantity += $Item->quantity;
			
			if (in_array($Item->effective_discount_preprocess_rule_id, $this->PreprocessRuleIDList))
				$this->total_applied_discount_rule_no_by_discount_code++;
			
			if (in_array($Item->effective_discount_bundle_rule_id, $this->BundleRuleIDList))
				$this->total_applied_discount_rule_no_by_discount_code++;
		}
	}
	
	private function ProcessBonusPointItemList() {
		$sql = '';

		if ($this->HonorArchiveDate)
			$sql	=	$sql . "	AND	O.object_archive_date > NOW() ";
		if ($this->HonorPublishDate)
			$sql	=	$sql . "	AND	O.object_publish_date < NOW() ";

		$query =	"	SELECT		*, W.*, B.*, O.* " .
					"	FROM		cart_bonus_point_item W " .
					"					JOIN bonus_point_item B		ON	(B.bonus_point_item_id = W.bonus_point_item_id) " .
					"					JOIN object O				ON	(O.object_id = B.bonus_point_item_id) " .
					"	WHERE		O.object_is_enable = 'Y' " .
					"			AND	O.object_security_level <= '" . $this->getUserSecurityLevel() . "'" .
					"			AND	W.user_id				= '" . $this->user_id . "' " .
					"			AND	W.system_admin_id		= '" . $this->system_admin_id . "' " .
					"			AND	W.content_admin_id		= '" . $this->content_admin_id . "' " .
					"			AND	W.site_id				= '" . $this->site_id . "' " .
					"			AND	W.cart_content_type		= '" . $this->cart_content_type . "'" .
					"			AND	W.quantity > 0 " . $sql .
					"	ORDER BY	O.object_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->total_cash_value = 0;
		$this->total_cash_value_ca = 0;
		$this->total_bonus_point_required_for_bonus_point_cart = 0;

		while ($myResult = $result->fetch_object('cart_result_bonus_point_item')) {
			/* @var $myResult cart_result_bonus_point_item */
			$myResult->currency_id = $this->currency_id;
			$myResult->cash_ca = round($myResult->cash * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
			$myResult->subtotal_cash = $myResult->cash * $myResult->quantity;
			$myResult->subtotal_cash_ca = $myResult->cash_ca * $myResult->quantity;
			$myResult->subtotal_bonus_point_required = $myResult->bonus_point_required * $myResult->quantity;

			$this->total_cash_value += $myResult->subtotal_cash;
			$this->total_cash_value_ca += $myResult->subtotal_cash_ca;
			$this->total_bonus_point_required_for_bonus_point_cart += $myResult->subtotal_bonus_point_required;

			array_push($this->calculated_bonus_point_item_list, $myResult);
		}
	}
	
	private function ApplyPostProcessRule($TotalPrice, $IsEnabled = 'Y', &$NewDiscount, &$NewDiscountCA, &$HitRuleID) {
		$DiscountCode = $this->getCartDetailsObj(false, 0)->discount_code;		
		if ($DiscountCode == null)
			$DiscountCode = '';				

		// Check if any discount code match first
		$Rules = discount::GetPostprocessRuleList($this->site_id, $IsEnabled, $this->getUserSecurityLevel(), $this->HonorArchiveDate, $this->HonorPublishDate, $DiscountCode, $this->user_id, $this->getEffectiveProductPriceCurrencyID());
		$Rules2 = discount::GetPostprocessRuleList($this->site_id, $IsEnabled, $this->getUserSecurityLevel(), $this->HonorArchiveDate, $this->HonorPublishDate, '', $this->user_id, $this->getEffectiveProductPriceCurrencyID());
		$DiscountRuleList = array_merge($Rules, $Rules2);

		$IsHit = false;

		foreach ($DiscountRuleList as $R) {
			if ($IsHit)
				break;

			$Level = null;
			
			if ($R['discount_postprocess_discount_type_id'] == 1)
				$Level = discount::GetEffectivePostprocessDiscountLevel($this->getUserSecurityLevel() , $R['discount_postprocess_rule_id'], $this->getEffectiveProductPriceCurrencyID());
			elseif ($R['discount_postprocess_discount_type_id'] == 2)
				$Level = discount::GetEffectivePostprocessDiscountLevel($TotalPrice , $R['discount_postprocess_rule_id'], $this->getEffectiveProductPriceCurrencyID());
			if ($Level['discount_postprocess_discount_level_type_id'] == 1 && $Level['discount_postprocess_discount1_off_p'] > 0) {
				$IsHit = true;
				$HitRuleID = $R['discount_postprocess_rule_id'];
				$NewDiscount = $TotalPrice * $Level['discount_postprocess_discount1_off_p'] / 100;
				$NewDiscountCA = round($NewDiscount * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
			}
			elseif ($Level['discount_postprocess_discount_level_type_id'] == 2 && $Level['discount_postprocess_discount2_minus_amount'] > 0) {
				$IsHit = true;
				$HitRuleID = $R['discount_postprocess_rule_id'];
				$NewDiscount = min($TotalPrice, $Level['discount_postprocess_discount2_minus_amount']);
				$NewDiscountCA = round($NewDiscount * $this->getEffectiveCurrencyRate(), $this->getCurrencyObj()->currency_precision);
			}
		}
	}	
	
	private function ProcessBundleDiscount() {
		$this->total_possible_discount_rule_no_by_discount_code = 0;
		$this->total_applied_discount_rule_no_by_discount_code = 0;
		$BundleRuleList = discount::GetBundleRuleList($this->site_id, 'Y', $this->getUserSecurityLevel(), $this->HonorArchiveDate, $this->HonorPublishDate, $this->getCartDetailsObj()->discount_code, false, $this->getEffectiveProductPriceCurrencyID());
		$this->BundleRuleIDList = array();
		foreach($BundleRuleList as $R)
			array_push($this->BundleRuleIDList, $R['discount_bundle_rule_id']);
		$this->total_possible_discount_rule_no_by_discount_code += count($this->BundleRuleIDList);		
	}
	
	private function ProcessPreProcessDiscount() {
//		$this->total_possible_discount_rule_no_by_discount_code = 0;
//		$this->total_applied_discount_rule_no_by_discount_code = 0;
		$PreprocessRuleList = discount::GetPreprocessRuleList($this->site_id, 'Y', $this->getUserSecurityLevel(), $this->HonorArchiveDate, $this->HonorPublishDate, $this->getCartDetailsObj()->discount_code, false, $this->getEffectiveProductPriceCurrencyID());
		$this->PreprocessRuleIDList = array();
		foreach($PreprocessRuleList as $R)
			array_push($this->PreprocessRuleIDList, $R['discount_preprocess_rule_id']);
		$this->total_possible_discount_rule_no_by_discount_code += count($this->PreprocessRuleIDList);		
	}
	
	private function ProcessPostProcessDiscount() {
		$IsEnabled = 'Y';
		if ($this->cart_content_type == 'test')
			$IsEnabled = 'ALL';
		
		$this->postprocess_rule_discount_amount = 0;
		$this->postprocess_rule_discount_amount_ca = 0;
		$this->effective_discount_postprocess_rule_id = 0;
		
		if ($this->cart_content_type != 'bonus_point' && $this->ContinuePostProcessRule)
			$this->ApplyPostProcessRule($this->total_price, $IsEnabled, $this->postprocess_rule_discount_amount, $this->postprocess_rule_discount_amount_ca, $this->effective_discount_postprocess_rule_id);

		$PostprocessDiscountRule = discount::GetPostprocessRuleInfo($this->effective_discount_postprocess_rule_id, 0);
//			if ($PostprocessDiscountRule != null)
//				$smarty->assign('EffectivePostprocessDiscountCode', $PostprocessDiscountRule['discount_postprocess_rule_discount_code']);
		
		$PostprocessRuleList = discount::GetPostprocessRuleList($this->site_id, $IsEnabled, $this->getUserSecurityLevel(), $this->HonorArchiveDate, $this->HonorPublishDate, $this->getCartDetailsObj(false, 0)->discount_code, $this->user_id, $this->getEffectiveProductPriceCurrencyID());
		
		$PostprocessRuleIDList = array();
		foreach($PostprocessRuleList as $R)
			array_push($PostprocessRuleIDList, $R['discount_postprocess_rule_id']);
		$this->total_possible_discount_rule_no_by_discount_code += count($PostprocessRuleIDList);

		if (in_array($this->effective_discount_postprocess_rule_id, $PostprocessRuleIDList)) {
			$this->total_applied_discount_rule_no_by_discount_code++;
			$this->effective_discount_postprocess_rule_discount_code = $this->getCartDetailsObj(false, 0)->discount_code;
		}
	}
	
	private function ProcessFreight() {
		if ($this->cart_content_type != 'bonus_point') {
			if ($this->getSiteObj()->site_freight_cost_calculation_id == 1) {			
				$FreightPriceAmountToCalFor = 0;
				if ($this->getSiteFreight()->site_freight_1_free_min_total_price_def == 0)
					$FreightPriceAmountToCalFor = $this->total_price - (doubleval($this->getCartDetailsObj(false, 0)->discount_amount_ca) / $this->getEffectiveCurrencyRate()) - $this->postprocess_rule_discount_amount;
				elseif ($this->getSiteFreight()->site_freight_1_free_min_total_price_def == 1)
					$FreightPriceAmountToCalFor = $this->total_price - $this->total_cash_value - (doubleval($this->getCartDetailsObj(false, 0)->discount_amount_ca) / $this->getEffectiveCurrencyRate()) - $this->postprocess_rule_discount_amount;
				elseif ($this->getSiteFreight()->site_freight_1_free_min_total_price_def == 2)
					$FreightPriceAmountToCalFor = $this->total_listed_price;

				$this->calculated_freight_cost_ca = 0;
				if ($FreightPriceAmountToCalFor < $this->getSiteFreight()->site_freight_1_free_min_total_price)
					$this->calculated_freight_cost_ca = $this->getSiteFreight()->site_freight_1_cost * $this->getEffectiveCurrencyRate();

				if ($this->getCartDetailsObj()->self_take == 'Y')
					$this->calculated_freight_cost_ca = 0;

				if ($this->total_listed_price == 0) // No Product!
					$this->calculated_freight_cost_ca = 0;

				$query =	"	UPDATE	cart_details " .
							"	SET		freight_cost_ca	= '" . $this->calculated_freight_cost_ca . "' " .
							"	WHERE	cart_details_id		= '" . $this->getCartDetailsObj(false, 0)->cart_details_id . "' ";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

				$this->_CartDetailsObj->freight_cost_ca = $this->calculated_freight_cost_ca;
			}
			else if ($this->getSiteObj()->site_freight_cost_calculation_id == 2) {
				$MinTotalPrice = 0;
				if ($this->getSiteFreight()->site_freight_2_free_min_total_price_def == 0)
					$MinTotalPrice = $this->total_price - (doubleval($this->getCartDetailsObj(false, 0)->discount_amount_ca) / $this->getEffectiveCurrencyRate()) - $this->postprocess_rule_discount_amount;
				elseif ($this->getSiteFreight()->site_freight_2_free_min_total_price_def == 1)
					$MinTotalPrice = $this->total_price - $this->total_cash_value - (doubleval($this->getCartDetailsObj(false, 0)->discount_amount_ca) / $this->getEffectiveCurrencyRate()) - $this->postprocess_rule_discount_amount;
				elseif ($this->getSiteFreight()->site_freight_2_free_min_total_price_def == 2)
					$MinTotalPrice = $this->total_listed_price;

				$TotalBasePrice = 0;
				if ($this->getSiteFreight()->site_freight_2_total_base_price_def == 0)
					$TotalBasePrice = $this->total_price - (doubleval($this->getCartDetailsObj(false, 0)->discount_amount_ca) / $this->getEffectiveCurrencyRate()) - $this->postprocess_rule_discount_amount;
				elseif ($this->getSiteFreight()->site_freight_2_total_base_price_def == 1)
					$TotalBasePrice = $this->total_price - $this->total_cash_value - (doubleval($this->getCartDetailsObj(false, 0)->discount_amount_ca) / $this->getEffectiveCurrencyRate()) - $this->postprocess_rule_discount_amount;
				elseif ($this->getSiteFreight()->site_freight_2_total_base_price_def == 2)
					$TotalBasePrice = $this->total_listed_price;
				$this->calculated_freight_cost_ca = 0;

				if (doubleval($this->getSiteFreight()->site_freight_2_free_min_total_price) < 0 || $MinTotalPrice < $this->getSiteFreight()->site_freight_2_free_min_total_price)
					$this->calculated_freight_cost_ca = $TotalBasePrice * $this->getSiteFreight()->site_freight_2_cost_percent / 100;

				if ($this->getCartDetailsObj(false, 0)->self_take == 'Y')
					$this->calculated_freight_cost_ca = 0;

				if ($this->total_listed_price == 0) // No Product!
					$this->calculated_freight_cost_ca = 0;				

				$query =	"	UPDATE	cart_details " .
							"	SET		freight_cost_ca	= '" . $this->calculated_freight_cost_ca . "' " .
							"	WHERE	cart_details_id		= '" . $this->getCartDetailsObj(false, 0)->cart_details_id . "' ";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

				$this->_CartDetailsObj->freight_cost_ca = $this->calculated_freight_cost_ca;
			}
			else {
				$this->calculated_freight_cost_ca = doubleval($this->getCartDetailsObj()->freight_cost_ca);
			}			
		}
	}
	
	public function TouchCart() {
		if ($this->getUserObj() !== null) {
			$query  =	" 	INSERT	INTO	cart_details " .
						"	SET		user_id				= '" . $this->user_id . "', " .
						"			system_admin_id		= '" . $this->system_admin_id . "', " .
						"			content_admin_id	= '" . $this->content_admin_id . "', " .
						"			site_id				= '" . $this->site_id . "', " .
						"			cart_content_type	= '" . $this->cart_content_type . "', " .
						"			deliver_to_different_address	= 'N', " .
						"			self_take			= 'N', " .
						"			update_user_address	= 'Y', " .
						"			email_order_confirm	= 'Y', " .
						"			join_mailing_list	= 'Y', " .
						"			currency_id					= '" . intval($this->getUserObj()->user_currency_id) . "', " .
						"			invoice_country_id			= '" . intval($this->getUserObj()->user_country_id) . "', " .
						"			invoice_country_other		= '" . aveEscT($this->getUserObj()->user_country_other) . "', " .
						"			invoice_hk_district_id		= '" . intval($this->getUserObj()->user_hk_district_id) . "', " .
						"			invoice_first_name			= '" . aveEscT($this->getUserObj()->user_first_name) . "', " .
						"			invoice_last_name			= '" . aveEscT($this->getUserObj()->user_last_name) . "', " .
						"			invoice_company_name		= '" . aveEscT($this->getUserObj()->user_company_name) . "', " .
						"			invoice_city_name			= '" . aveEscT($this->getUserObj()->user_city_name) . "', " .
						"			invoice_region				= '" . aveEscT($this->getUserObj()->user_region) . "', " .
						"			invoice_postcode			= '" . aveEscT($this->getUserObj()->user_postcode) . "', " .
						"			invoice_phone_no			= '" . aveEscT($this->getUserObj()->user_tel_no) . "', " .
						"			invoice_tel_country_code	= '" . aveEscT($this->getUserObj()->user_tel_country_code) . "', " .
						"			invoice_tel_area_code		= '" . aveEscT($this->getUserObj()->user_tel_area_code) . "', " .
						"			invoice_fax_country_code	= '" . aveEscT($this->getUserObj()->user_fax_country_code) . "', " .
						"			invoice_fax_area_code		= '" . aveEscT($this->getUserObj()->user_fax_area_code) . "', " .
						"			invoice_fax_no				= '" . aveEscT($this->getUserObj()->user_fax_no) . "', " .
						"			invoice_shipping_address_1	= '" . aveEscT($this->getUserObj()->user_address_1) . "', " .
						"			invoice_shipping_address_2	= '" . aveEscT($this->getUserObj()->user_address_2) . "', " .
						"			invoice_email				= '" . aveEscT($this->getUserObj()->user_email) . "' " .
						"	ON DUPLICATE KEY UPDATE user_id = '" . $this->user_id . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			
			$this->_CartDetailsObj = null;
		}
		else if ($this->system_admin_id > 0 || $this->content_admin_id > 0) {
			$query  =	" 	INSERT	INTO	cart_details " .
						"	SET		user_id				= '" . $this->user_id . "', " .
						"			system_admin_id		= '" . $this->system_admin_id . "', " .
						"			content_admin_id	= '" . $this->content_admin_id . "', " .
						"			site_id				= '" . $this->site_id . "', " .
						"			cart_content_type	= '" . $this->cart_content_type . "', " .
						"			self_take			= 'N' " .
						"	ON DUPLICATE KEY UPDATE system_admin_id = '" . $this->system_admin_id . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			
			$this->_CartDetailsObj = null;
		}		
	}
	
	public function AddProductToCart($ProductID, $Qty, $ProductOptionID = 0, $ProductPriceID = 1, $CartContentCustomKey = '', $CartContentCustomDesc = '') {
		if ($Qty <= 0) {
			$query =	"	DELETE FROM	cart_content " .
						"	WHERE	product_id			= '" . intval($ProductID) . "'" .
						"		AND product_option_id	= '" . intval($ProductOptionID) . "'" .
						"		AND cart_content_custom_key	= '" . aveEscT($CartContentCustomKey) . "'" .
						"		AND	user_id				= '" . $this->user_id . "' " .
						"		AND	system_admin_id		= '" . $this->system_admin_id . "' " .
						"		AND	content_admin_id	= '" . $this->content_admin_id . "' " .
						"		AND	site_id				= '" . $this->site_id . "' " .
						"		AND	cart_content_type	= '" . $this->cart_content_type . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else {
			$query =	"	INSERT INTO cart_content " .
						"	SET		product_id					= '" . intval($ProductID) . "', " .
						"			quantity					= '" . intval($Qty) . "', " .
						"			user_id						= '" . $this->user_id . "', " .
						"			product_option_id			= '" . intval($ProductOptionID) . "', " .
						"			product_price_id			= '" . intval($ProductPriceID) . "', " .
						"			system_admin_id				= '" . $this->system_admin_id . "', " .
						"			content_admin_id			= '" . $this->content_admin_id . "', " .
						"			site_id						= '" . $this->site_id . "', " .
						"			cart_content_type			= '" . $this->cart_content_type . "', " .
						"			cart_content_custom_key		= '" . aveEscT($CartContentCustomKey) . "', " .
						"			cart_content_custom_desc	= '" . aveEscT($CartContentCustomDesc) . "' " .
						"	ON DUPLICATE KEY UPDATE	quantity = quantity + '" . intval($Qty) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		
		$this->AmIDirty = true;
	}
	
	public function UpdateProductCart($ProductID, $Qty, $ProductOptionID = 0, $ProductPriceID = 1, $CartContentCustomKey = '', $CartContentCustomDesc = '') {
		if ($Qty <= 0) {
			$query =	"	DELETE FROM	cart_content " .
						"	WHERE	product_id			= '" . intval($ProductID) . "'" .
						"		AND product_option_id	= '" . intval($ProductOptionID) . "'" .
						"		AND cart_content_custom_key	= '" . aveEscT($CartContentCustomKey) . "'" .
						"		AND	user_id				= '" . $this->user_id . "' " .
						"		AND	system_admin_id		= '" . $this->system_admin_id . "' " .
						"		AND	content_admin_id	= '" . $this->content_admin_id . "' " .
						"		AND	site_id				= '" . $this->site_id . "' " .
						"		AND	cart_content_type	= '" . $this->cart_content_type . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else {
			$query =	"	INSERT INTO cart_content " .
						"	SET		product_id			= '" . intval($ProductID) . "', " .
						"			product_option_id	= '" . intval($ProductOptionID) . "', " .
						"			quantity			= '" . intval($Qty) . "', " .
						"			user_id				= '" . $this->user_id . "', " .
						"			system_admin_id		= '" . $this->system_admin_id . "', " .
						"			content_admin_id	= '" . $this->content_admin_id . "', " .
						"			site_id				= '" . $this->site_id . "', " .
						"			cart_content_type	= '" . $this->cart_content_type . "', " .
						"			cart_content_custom_key		= '" . aveEscT($CartContentCustomKey) . "', " .
						"			cart_content_custom_desc	= '" . aveEscT($CartContentCustomDesc) . "' " .
						"	ON DUPLICATE KEY UPDATE	" .
						"			quantity = '" . intval($Qty) . "', " .
						"			cart_content_custom_desc	= '" . aveEscT($CartContentCustomDesc) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		$this->AmIDirty = true;
	}

	public function RemoveProductFromCart($ProductID, $Qty, $ProductOptionID = 0, $ProductPriceID = 1, $CartContentCustomKey = '') {
		$query =	"	UPDATE	cart_content " .
					"	SET		quantity	= quantity - '" . intval($Qty) . "' " .
					"	WHERE	product_id			= '" . intval($ProductID) . "' " .
					"		AND	user_id				= '" . $this->user_id . "' " .
					"		AND	product_option_id	= '" . intval($ProductOptionID) . "' " .
					"		AND	product_price_id	= '" . intval($ProductPriceID) . "' " .
					"		AND	system_admin_id		= '" . $this->system_admin_id . "' " .
					"		AND	content_admin_id	= '" . $this->content_admin_id . "' " .
					"		AND	site_id				= '" . $this->site_id . "' " .
					"		AND	cart_content_type	= '" . $this->cart_content_type . "' " .
					"		AND cart_content_custom_key = '" . aveEscT($CartContentCustomKey) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM cart_content " .
					"	WHERE	user_id				= '" . $this->user_id . "' " .
					"		AND	product_option_id	= '" . intval($ProductOptionID) . "' " .
					"		AND	product_price_id	= '" . intval($ProductPriceID) . "' " .
					"		AND	system_admin_id		= '" . $this->system_admin_id . "' " .
					"		AND	content_admin_id	= '" . $this->content_admin_id . "' " .
					"		AND	site_id				= '" . $this->site_id . "' " .
					"		AND	cart_content_type	= '" . $this->cart_content_type . "' " .
					"		AND cart_content_custom_key = '" . aveEscT($CartContentCustomKey) . "'" .
					"		AND	quantity <= 0 ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$this->AmIDirty = true;
	}

	public function EmptyProductCart() {
		$query =	"	DELETE FROM cart_content " .
					"	WHERE	user_id					= '" . $this->user_id . "' " .
					"		AND	system_admin_id			= '" . $this->system_admin_id . "' " .
					"		AND	content_admin_id		= '" . $this->content_admin_id . "' " .
					"		AND	site_id					= '" . $this->site_id . "' " .
					"		AND	cart_content_type		= '" . $this->cart_content_type . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->AmIDirty = true;
	}

	public function AddBonusPointItemToCart($BonusPointItemID, $Qty) {
		$query =	"	INSERT INTO cart_bonus_point_item " .
					"	SET		bonus_point_item_id		= '" . intval($BonusPointItemID) . "', " .
					"			quantity				= '" . intval($Qty) . "', " .
					"			user_id					= '" . $this->user_id . "', " .
					"			system_admin_id			= '" . $this->system_admin_id . "', " .
					"			content_admin_id		= '" . $this->content_admin_id . "', " .
					"			site_id					= '" . $this->site_id . "', " .
					"			cart_content_type		= '" . $this->cart_content_type . "' " .
					"	ON DUPLICATE KEY UPDATE	quantity = quantity + '" . intval($Qty) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->AmIDirty = true;
	}
	
	public function EmptyBonusPointItemCart() {
		$query =	"	DELETE FROM cart_bonus_point_item " .
					"	WHERE	user_id					= '" . $this->user_id . "' " .
					"		AND	system_admin_id			= '" . $this->system_admin_id . "' " .
					"		AND	content_admin_id		= '" . $this->content_admin_id . "' " .
					"		AND	site_id					= '" . $this->site_id . "' " .
					"		AND	cart_content_type		= '" . $this->cart_content_type . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$this->AmIDirty = true;
	}

	public function RemoveBonusPointItemFromCart($BonusPointItemID, $Qty) {
		$query =	"	UPDATE	cart_bonus_point_item " .
					"	SET		quantity				= quantity - '" . intval($Qty) . "' " .
					"	WHERE	bonus_point_item_id		= '" . intval($BonusPointItemID) . "' " .
					"		AND	user_id					= '" . $this->user_id . "' " .
					"		AND	system_admin_id			= '" . $this->system_admin_id . "' " .
					"		AND	content_admin_id		= '" . $this->content_admin_id . "' " .
					"		AND	site_id					= '" . $this->site_id . "' " .
					"		AND	cart_content_type		= '" . $this->cart_content_type . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM cart_bonus_point_item " .
					"	WHERE	quantity <= 0 " .
					"		AND	bonus_point_item_id		= '" . intval($BonusPointItemID) . "' " .
					"		AND	user_id					= '" . $this->user_id . "' " .
					"		AND	system_admin_id			= '" . $this->system_admin_id . "' " .
					"		AND	content_admin_id		= '" . $this->content_admin_id . "' " .
					"		AND	site_id					= '" . $this->site_id . "' " .
					"		AND	cart_content_type		= '" . $this->cart_content_type . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$this->AmIDirty = true;
	}

	public function UpdateBonusPointCart($BonusPointItemID, $Qty) {
		
		if ($Qty <= 0) {
			$query =	"	DELETE FROM cart_bonus_point_item " .
						"	WHERE	bonus_point_item_id	= '" . intval($BonusPointItemID) . "' " .
						"		AND	user_id				= '" . $this->user_id . "' " .
						"		AND	system_admin_id		= '" . $this->system_admin_id . "' " .
						"		AND	content_admin_id	= '" . $this->content_admin_id . "' " .
						"		AND	site_id				= '" . $this->site_id . "' " .
						"		AND	cart_content_type	= '" . $this->cart_content_type . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else {
			$query =	"	INSERT INTO cart_bonus_point_item " .
						"	SET		bonus_point_item_id		= '" . intval($BonusPointItemID) . "', " .
						"			quantity				= '" . intval($Qty) . "', " .
						"			user_id					= '" . $this->user_id . "', " .
						"			system_admin_id			= '" . $this->system_admin_id . "', " .
						"			content_admin_id		= '" . $this->content_admin_id . "', " .
						"			site_id					= '" . $this->site_id . "', " .
						"			cart_content_type		= '" . $this->cart_content_type . "'" .
						"	ON DUPLICATE KEY UPDATE	quantity = '" . intval($Qty) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		
		$this->AmIDirty = true;
	}
	
	public function UpdateCartDetailsFromObj() {
		$query  =	" 	UPDATE	cart_details " .
					"	SET		discount_code		= '" . aveEscT($this->getCartDetailsObj()->discount_code) . "', " .
					"			effective_base_price_id = '" .intval($this->getCartDetailsObj()->effective_base_price_id) . "', " .
					"			bonus_point_item_id = '" . intval($this->getCartDetailsObj()->bonus_point_item_id) . "', " .
					"			bonus_point_earned_supplied_by_client = '" . intval($this->getCartDetailsObj()->bonus_point_earned_supplied_by_client) . "', " .
					"			use_bonus_point = '" . ynval($this->getCartDetailsObj()->use_bonus_point) . "', " .
					"			deliver_to_different_address = '" . ynval($this->getCartDetailsObj()->deliver_to_different_address) . "', " .
					"			self_take = '" . ynval($this->getCartDetailsObj()->self_take) . "', " .
					"			update_user_address = '" . ynval($this->getCartDetailsObj()->update_user_address) . "', " .
					"			email_order_confirm = '" . ynval($this->getCartDetailsObj()->email_order_confirm) . "', " .
					"			join_mailing_list = '" . ynval($this->getCartDetailsObj()->join_mailing_list) . "', " .
					"			currency_id = '" . intval($this->getCartDetailsObj()->currency_id) . "', " .
					"			freight_cost_ca = '" . doubleval($this->getCartDetailsObj()->freight_cost_ca) . "', " .
					"			discount_amount_ca = '" . doubleval($this->getCartDetailsObj()->discount_amount_ca) . "', " .
					"			cash_paid = '" . doubleval($this->getCartDetailsObj()->cash_paid) . "', " .
					"			cash_paid_currency_id = '" . doubleval($this->getCartDetailsObj()->cash_paid_currency_id) . "', " .
					"			user_balance_use = '" . doubleval($this->getCartDetailsObj()->user_balance_use) . "', " .
					"			invoice_country_id = '" . intval($this->getCartDetailsObj()->invoice_country_id) . "', " .
					"			invoice_country_other = '" . aveEscT($this->getCartDetailsObj()->invoice_country_other) . "', " .
					"			invoice_hk_district_id = '" . intval($this->getCartDetailsObj()->invoice_hk_district_id) . "', " .
					"			invoice_first_name = '" . aveEscT($this->getCartDetailsObj()->invoice_first_name) . "', " .
					"			invoice_last_name = '" . aveEscT($this->getCartDetailsObj()->invoice_last_name) . "', " .
					"			invoice_company_name = '" . aveEscT($this->getCartDetailsObj()->invoice_company_name) . "', " .
					"			invoice_city_name = '" . aveEscT($this->getCartDetailsObj()->invoice_city_name) . "', " .
					"			invoice_region = '" . aveEscT($this->getCartDetailsObj()->invoice_region) . "', " .
					"			invoice_postcode = '" . aveEscT($this->getCartDetailsObj()->invoice_postcode) . "', " .
					"			invoice_phone_no = '" . aveEscT($this->getCartDetailsObj()->invoice_phone_no) . "', " .
					"			invoice_tel_country_code = '" . aveEscT($this->getCartDetailsObj()->invoice_tel_country_code) . "', " .
					"			invoice_tel_area_code = '" . aveEscT($this->getCartDetailsObj()->invoice_tel_area_code) . "', " .
					"			invoice_fax_country_code = '" . aveEscT($this->getCartDetailsObj()->invoice_fax_country_code) . "', " .
					"			invoice_fax_area_code = '" . aveEscT($this->getCartDetailsObj()->invoice_fax_area_code) . "', " .
					"			invoice_fax_no = '" . aveEscT($this->getCartDetailsObj()->invoice_fax_no) . "', " .
					"			invoice_shipping_address_1 = '" . aveEscT($this->getCartDetailsObj()->invoice_shipping_address_1) . "', " .
					"			invoice_shipping_address_2 = '" . aveEscT($this->getCartDetailsObj()->invoice_shipping_address_2) . "', " .
					"			invoice_email = '" . aveEscT($this->getCartDetailsObj()->invoice_email) . "', " .
					"			delivery_country_id = '" . intval($this->getCartDetailsObj()->delivery_country_id) . "', " .
					"			delivery_country_other = '" . aveEscT($this->getCartDetailsObj()->delivery_country_other) . "', " .
					"			delivery_hk_district_id = '" . intval($this->getCartDetailsObj()->delivery_hk_district_id) . "', " .
					"			delivery_first_name = '" . aveEscT($this->getCartDetailsObj()->delivery_first_name) . "', " .
					"			delivery_last_name = '" . aveEscT($this->getCartDetailsObj()->delivery_last_name) . "', " .
					"			delivery_company_name = '" . aveEscT($this->getCartDetailsObj()->delivery_company_name) . "', " .
					"			delivery_city_name = '" . aveEscT($this->getCartDetailsObj()->delivery_city_name) . "', " .
					"			delivery_region = '" . aveEscT($this->getCartDetailsObj()->delivery_region) . "', " .
					"			delivery_postcode = '" . aveEscT($this->getCartDetailsObj()->delivery_postcode) . "', " .
					"			delivery_city_name = '" . aveEscT($this->getCartDetailsObj()->delivery_city_name) . "', " .
					"			delivery_phone_no = '" . aveEscT($this->getCartDetailsObj()->delivery_phone_no) . "', " .
					"			delivery_tel_country_code = '" . aveEscT($this->getCartDetailsObj()->delivery_tel_country_code) . "', " .
					"			delivery_tel_area_code = '" . aveEscT($this->getCartDetailsObj()->delivery_tel_area_code) . "', " .
					"			delivery_fax_no = '" . aveEscT($this->getCartDetailsObj()->delivery_fax_no) . "', " .
					"			delivery_fax_country_code = '" . aveEscT($this->getCartDetailsObj()->delivery_fax_country_code) . "', " .
					"			delivery_fax_area_code = '" . aveEscT($this->getCartDetailsObj()->delivery_fax_area_code) . "', " .
					"			delivery_shipping_address_1 = '" . aveEscT($this->getCartDetailsObj()->delivery_shipping_address_1) . "', " .
					"			delivery_shipping_address_2 = '" . aveEscT($this->getCartDetailsObj()->delivery_shipping_address_2) . "', " .
					"			delivery_email = '" . aveEscT($this->getCartDetailsObj()->delivery_email) . "', " .
					"			user_message = '" . aveEscT($this->getCartDetailsObj()->user_message) . "', " .
					"			myorder_custom_text_1 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_1) . "', " .
					"			myorder_custom_text_2 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_2) . "', " .
					"			myorder_custom_text_3 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_3) . "', " .
					"			myorder_custom_text_4 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_4) . "', " .
					"			myorder_custom_text_5 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_5) . "', " .
					"			myorder_custom_text_6 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_6) . "', " .
					"			myorder_custom_text_7 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_7) . "', " .
					"			myorder_custom_text_8 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_8) . "', " .
					"			myorder_custom_text_9 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_9) . "', " .
					"			myorder_custom_text_10 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_10) . "', " .
					"			myorder_custom_text_11 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_11) . "', " .
					"			myorder_custom_text_12 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_12) . "', " .
					"			myorder_custom_text_13 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_13) . "', " .
					"			myorder_custom_text_14 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_14) . "', " .
					"			myorder_custom_text_15 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_15) . "', " .
					"			myorder_custom_text_16 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_16) . "', " .
					"			myorder_custom_text_17 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_17) . "', " .
					"			myorder_custom_text_18 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_18) . "', " .
					"			myorder_custom_text_19 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_19) . "', " .
					"			myorder_custom_text_20 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_text_20) . "', " .
					"			myorder_custom_int_1 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_1) . "', " .
					"			myorder_custom_int_2 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_2) . "', " .
					"			myorder_custom_int_3 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_3) . "', " .
					"			myorder_custom_int_4 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_4) . "', " .
					"			myorder_custom_int_5 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_5) . "', " .
					"			myorder_custom_int_6 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_6) . "', " .
					"			myorder_custom_int_7 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_7) . "', " .
					"			myorder_custom_int_8 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_8) . "', " .
					"			myorder_custom_int_9 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_9) . "', " .
					"			myorder_custom_int_10 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_10) . "', " .
					"			myorder_custom_int_11 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_11) . "', " .
					"			myorder_custom_int_12 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_12) . "', " .
					"			myorder_custom_int_13 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_13) . "', " .
					"			myorder_custom_int_14 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_14) . "', " .
					"			myorder_custom_int_15 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_15) . "', " .
					"			myorder_custom_int_16 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_16) . "', " .
					"			myorder_custom_int_17 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_17) . "', " .
					"			myorder_custom_int_18 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_18) . "', " .
					"			myorder_custom_int_19 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_19) . "', " .
					"			myorder_custom_int_20 = '" . intval($this->getCartDetailsObj()->myorder_custom_int_20) . "', " .
					"			myorder_custom_double_1 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_1) . "', " .
					"			myorder_custom_double_2 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_2) . "', " .
					"			myorder_custom_double_3 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_3) . "', " .
					"			myorder_custom_double_4 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_4) . "', " .
					"			myorder_custom_double_5 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_5) . "', " .
					"			myorder_custom_double_6 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_6) . "', " .
					"			myorder_custom_double_7 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_7) . "', " .
					"			myorder_custom_double_8 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_8) . "', " .
					"			myorder_custom_double_9 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_9) . "', " .
					"			myorder_custom_double_10 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_10) . "', " .
					"			myorder_custom_double_11 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_11) . "', " .
					"			myorder_custom_double_12 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_12) . "', " .
					"			myorder_custom_double_13 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_13) . "', " .
					"			myorder_custom_double_14 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_14) . "', " .
					"			myorder_custom_double_15 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_15) . "', " .
					"			myorder_custom_double_16 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_16) . "', " .
					"			myorder_custom_double_17 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_17) . "', " .
					"			myorder_custom_double_18 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_18) . "', " .
					"			myorder_custom_double_19 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_19) . "', " .
					"			myorder_custom_double_20 = '" . doubleval($this->getCartDetailsObj()->myorder_custom_double_20) . "', " .
					"			myorder_custom_date_1 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_1) . "', " .
					"			myorder_custom_date_2 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_2) . "', " .
					"			myorder_custom_date_3 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_3) . "', " .
					"			myorder_custom_date_4 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_4) . "', " .
					"			myorder_custom_date_5 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_5) . "', " .
					"			myorder_custom_date_6 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_6) . "', " .
					"			myorder_custom_date_7 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_7) . "', " .
					"			myorder_custom_date_8 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_8) . "', " .
					"			myorder_custom_date_9 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_9) . "', " .
					"			myorder_custom_date_10 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_10) . "', " .
					"			myorder_custom_date_11 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_11) . "', " .
					"			myorder_custom_date_12 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_12) . "', " .
					"			myorder_custom_date_13 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_13) . "', " .
					"			myorder_custom_date_14 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_14) . "', " .
					"			myorder_custom_date_15 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_15) . "', " .
					"			myorder_custom_date_16 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_16) . "', " .
					"			myorder_custom_date_17 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_17) . "', " .
					"			myorder_custom_date_18 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_18) . "', " .
					"			myorder_custom_date_19 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_19) . "', " .
					"			myorder_custom_date_20 = '" . aveEscT($this->getCartDetailsObj()->myorder_custom_date_20) . "' " .
					"	WHERE	user_id				= '" . $this->user_id . "' " .
					"		AND	system_admin_id		= '" . $this->system_admin_id . "' " .
					"		AND	content_admin_id	= '" . $this->content_admin_id . "' " .
					"		AND	site_id				= '" . $this->site_id . "' " .
					"		AND	cart_content_type	= '" . $this->cart_content_type . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->AmIDirty = true;
		$this->_CartDetailsObj = null;
		$this->_CurrencyObj = null;
		$this->_UserObj = null;
	}
	
	private function GetCartItemListXML() {
		$smarty = new mySmarty();
		$xml = '';
		
		$smarty->assign('CurrencyObj', $this->getCurrencyObj());
		
		$BundleRuleList = discount::GetBundleRuleList($this->site_id, 'Y', $this->getUserSecurityLevel(), true, true, $this->getCartDetailsObj()->discount_code, true, $this->getEffectiveProductPriceCurrencyID(), $this->lang_id);
		
		$PreprocessRuleList = discount::GetPreprocessRuleList($this->site_id, 'Y', $this->getUserSecurityLevel(), true, true, $this->getCartDetailsObj()->discount_code, true, $this->getEffectiveProductPriceCurrencyID(), $this->lang_id);		
		
		foreach ($this->calculated_product_list as $P) {
			/* @var $P cart_result_product */
			$ProductOption = null;
			if (intval($P->product_option_id) > 0)
				$ProductOption = product::GetProductOptionInfo($P->product_option_id, $this->lang_id);			
			$ProductXML = product::GetProductXML($P->object_link_id, $this->lang_id, false, 1, 999999, 999999, false, 1, 999999, false, $P->product_bonus_point_amount, $this->getCurrencyObj(), $this->getSiteArray(), false, $BundleRuleList, $PreprocessRuleList);
			
			$smarty->assign('ProductXML', $ProductXML);
			$smarty->assign('ProductOption', $ProductOption);
			$smarty->assign('CartResultProduct', $P);
			
			$xml .= $smarty->fetch('api/object_info/CART.tpl');
		}
		return $xml;
	}
	
	private function GetBonusPointItemListXML() {
		$smarty = new mySmarty();
		$xml = '';
		
		$smarty->assign('CurrencyObj', $this->getCurrencyObj());
		
		foreach ($this->calculated_bonus_point_item_list as $B) {
			/* @var $B cart_result_bonus_point_item */
			$BonusPointItemXML = bonuspoint::GetBonusPointItemXML($B->bonus_point_item_id, $this->lang_id, false);
			$smarty->assign('BonusPointItemXML', $BonusPointItemXML);
			$smarty->assign('CartResultBonusPointItem', $B);
			
			$xml .= $smarty->fetch('api/object_info/CART_BONUS_POINT_ITEM.tpl');
		}
		return $xml;
	}
		
	private function GetQuantityAdjustedCartContentIDXML() {
		$QuantityAdjustedCartContentIDXML = '';
		foreach ($this->quantity_adjusted_cart_content_id_array as $Q) {
			$QuantityAdjustedCartContentIDXML = $QuantityAdjustedCartContentIDXML . "<cart_content_id>" . $Q . "</cart_content_id>";
		}
		return $QuantityAdjustedCartContentIDXML;
	}
	
	public function GetCartXML() {
		$smarty = new mySmarty();

		$CartDetails = $this->getCartDetailsObj(true, $this->lang_id);		
		$smarty->assign('cart', $this);
		$smarty->assign('CartItemListXML', $this->GetCartItemListXML());
		$smarty->assign('CartBonusPointItemListXML', $this->GetBonusPointItemListXML());
		$smarty->assign('QuantityAdjustedCartContentIDXML', $this->GetQuantityAdjustedCartContentIDXML());
		
		return $smarty->fetch('api/object_info/CART_DETAILS.tpl');
	}	
	
	private function ApplyEffectiveBasePriceID() {
		if ($this->getCartDetailsObj()->effective_base_price_id != 0) {			
			
			$query =	"	SELECT	* " .
						"	FROM	cart_content " .
						"	WHERE	user_id				= '" . $this->user_id . "' " .
						"		AND	system_admin_id		= '" . $this->system_admin_id . "' " .
						"		AND	content_admin_id	= '" . $this->content_admin_id . "' " .
						"		AND	site_id				= '" . $this->site_id . "' " .
						"		AND	cart_content_type	= '" . $this->cart_content_type . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			
			$this->EmptyProductCart();
			
			while ($myResult = $result->fetch_object()) {
				$this->AddProductToCart($myResult->product_id, $myResult->quantity, $myResult->product_option_id, $this->getCartDetailsObj()->effective_base_price_id, $myResult->cart_content_custom_key, $myResult->cart_content_custom_desc);
			}
			
			$this->AmIDirty = true;
			$this->_CartDetailsObj = null;
		}		
	}

	private function GetConvertToOrderCustomTextSQL($Type) {
		$sql = '';
		for ($i = 1; $i <= 20; $i++) {
			if (trim($this->getCartDetailsObj()->{'myorder_custom_' . $Type . '_' . $i}) != '')
				$sql = $sql . " myorder_custom_" . $Type . '_' . $i . " = '" . aveEscT(trim($this->getCartDetailsObj()->{'myorder_custom_' . $Type . '_' . $i})) . "',";
		}
		return $sql;
	}
	
	public function CartConvertToOrder($OrderConfirmed = 'Y', $OldOrderID = 0, &$NewOrderID, $ShopID = 0, $TerminalID = 0) {
		$this->processCart();
		
		$OldOrder = new myorder($OldOrderID);

		if ($OldOrderID != 0)
			inventory::UnholdStockForMyOrder($OldOrderID);

		if ($OldOrderID != 0) {
			$OrderStatus			= $OldOrder->getMyOrderDetailsObj()->order_status;
			$OrderConfirmBy			= aveEscT($OldOrder->getMyOrderDetailsObj()->order_confirm_by);
			$OrderConfirmDate		= "'" . aveEscT($OldOrder->getMyOrderDetailsObj()->order_confirm_date) . "'";
			$OrderConfirmed			= aveEscT($OldOrder->getMyOrderDetailsObj()->order_confirmed);
			$OrderCreateDate		= "'" . aveEscT($OldOrder->getMyOrderDetailsObj()->create_date) . "'";
			$OrderCartType			= aveEscT($OldOrder->getMyOrderDetailsObj()->order_content_type);
		}
		else {
			$OrderCreateDate	= 'NOW()';
			$OrderCartType		= $this->cart_content_type;
			if ($OrderConfirmed == 'N') {
				$OrderStatus		= 'awaiting_freight_quote';
				$OrderConfirmBy		= 'null';
				$OrderConfirmDate	= 'null';
				$OrderConfirmed		= 'N';
			}
			else {
				$OrderStatus		= 'payment_pending';
				$OrderConfirmBy		= $this->getUserObj()->user_username;
				$OrderConfirmDate	= 'NOW()';
				$OrderConfirmed		= 'Y';
			}
		}

		$sql = $this->GetConvertToOrderCustomTextSQL('text') . $this->GetConvertToOrderCustomTextSQL('int') . $this->GetConvertToOrderCustomTextSQL('double') . $this->GetConvertToOrderCustomTextSQL('date');

		$query = '';
		if ($OldOrderID != 0)
			$query = "	UPDATE myorder ";
		else
			$query = " 	INSERT	INTO	myorder ";

		if ($this->getCartDetailsObj()->cash_paid > 0) {
			$sql .= 
					"	cash_paid_ca = '" . doubleval($this->cash_paid_ca) . "', " .
					"	cash_paid = '" . doubleval($this->getCartDetailsObj()->cash_paid) . "', " .
					"	cash_paid_currency_id = '" . intval($this->getCartDetailsObj()->cash_paid_currency_id) . "', " .
					"	cash_change_ca = '" . doubleval($this->cash_change_ca) . "', ";
		}
		
		$query = $query . 
					"	SET		order_status						= '" . $OrderStatus . "', " .
					"			user_id								= '" . $this->user_id . "', " .
					"			site_id								= '" . $this->site_id . "', " .
					"			shop_id								= '" . $ShopID . "', " .
					"			terminal_id							= '" . $TerminalID . "', " .
					"			bonus_point_item_id					= '" . intval($this->getCartDetailsObj()->bonus_point_item_id) . "', " .
					"			deliver_to_different_address		= '" . ynval($this->getCartDetailsObj()->deliver_to_different_address) . "', " .
					"			email_order_confirm					= '" . ynval($this->getCartDetailsObj()->email_order_confirm) . "', " .
					"			invoice_country_id					= '" . intval($this->getCartDetailsObj()->invoice_country_id) . "', " .
					"			invoice_country_other				= '" . aveEscT($this->getCartDetailsObj()->invoice_country_other) . "', " .
					"			invoice_hk_district_id				= '" . intval($this->getCartDetailsObj()->invoice_hk_district_id) . "', " .
					"			invoice_first_name					= '" . aveEscT($this->getCartDetailsObj()->invoice_first_name) . "', " .
					"			invoice_last_name					= '" . aveEscT($this->getCartDetailsObj()->invoice_last_name) . "', " .
					"			invoice_company_name				= '" . aveEscT($this->getCartDetailsObj()->invoice_company_name) . "', " .
					"			invoice_city_name					= '" . aveEscT($this->getCartDetailsObj()->invoice_city_name) . "', " .
					"			invoice_region						= '" . aveEscT($this->getCartDetailsObj()->invoice_region) . "', " .
					"			invoice_postcode					= '" . aveEscT($this->getCartDetailsObj()->invoice_postcode) . "', " .
					"			invoice_phone_no					= '" . aveEscT($this->getCartDetailsObj()->invoice_phone_no) . "', " .
					"			invoice_tel_country_code			= '" . aveEscT($this->getCartDetailsObj()->invoice_tel_country_code) . "', " .
					"			invoice_tel_area_code				= '" . aveEscT($this->getCartDetailsObj()->invoice_tel_area_code) . "', " .
					"			invoice_fax_country_code			= '" . aveEscT($this->getCartDetailsObj()->invoice_fax_country_code) . "', " .
					"			invoice_fax_area_code				= '" . aveEscT($this->getCartDetailsObj()->invoice_fax_area_code) . "', " .
					"			invoice_fax_no						= '" . aveEscT($this->getCartDetailsObj()->invoice_fax_no) . "', " .
					"			invoice_shipping_address_1			= '" . aveEscT($this->getCartDetailsObj()->invoice_shipping_address_1) . "', " .
					"			invoice_shipping_address_2			= '" . aveEscT($this->getCartDetailsObj()->invoice_shipping_address_2) . "', " .
					"			invoice_email						= '" . aveEscT($this->getCartDetailsObj()->invoice_email) . "', " .
					"			delivery_country_id					= '" . intval($this->getCartDetailsObj()->delivery_country_id) . "', " .
					"			delivery_country_other				= '" . aveEscT($this->getCartDetailsObj()->delivery_country_other) . "', " .
					"			delivery_hk_district_id				= '" . intval($this->getCartDetailsObj()->delivery_hk_district_id) . "', " .
					"			delivery_first_name					= '" . aveEscT($this->getCartDetailsObj()->delivery_first_name) . "', " .
					"			delivery_last_name					= '" . aveEscT($this->getCartDetailsObj()->delivery_last_name) . "', " .
					"			delivery_company_name				= '" . aveEscT($this->getCartDetailsObj()->delivery_company_name) . "', " .
					"			delivery_city_name					= '" . aveEscT($this->getCartDetailsObj()->delivery_city_name) . "', " .
					"			delivery_region						= '" . aveEscT($this->getCartDetailsObj()->delivery_region) . "', " .
					"			delivery_postcode					= '" . aveEscT($this->getCartDetailsObj()->delivery_postcode) . "', " .
					"			delivery_phone_no					= '" . aveEscT($this->getCartDetailsObj()->delivery_phone_no) . "', " .
					"			delivery_tel_country_code			= '" . aveEscT($this->getCartDetailsObj()->delivery_tel_country_code) . "', " .
					"			delivery_tel_area_code				= '" . aveEscT($this->getCartDetailsObj()->delivery_tel_area_code) . "', " .
					"			delivery_fax_no						= '" . aveEscT($this->getCartDetailsObj()->delivery_fax_no) . "', " .
					"			delivery_fax_country_code			= '" . aveEscT($this->getCartDetailsObj()->delivery_fax_country_code) . "', " .
					"			delivery_fax_area_code				= '" . aveEscT($this->getCartDetailsObj()->delivery_fax_area_code) . "', " .
					"			delivery_shipping_address_1			= '" . aveEscT($this->getCartDetailsObj()->delivery_shipping_address_1) . "', " .
					"			delivery_shipping_address_2			= '" . aveEscT($this->getCartDetailsObj()->delivery_shipping_address_2) . "', " .
					"			delivery_email						= '" . aveEscT($this->getCartDetailsObj()->delivery_email) . "', " .
					"			delivery_date						= null, " .
					"			user_message								= '" . aveEscT($this->getCartDetailsObj()->user_message) . "', " .
					"			bonus_point_earned_supplied_by_client		= '" . intval($this->getCartDetailsObj()->bonus_point_earned_supplied_by_client) . "', " .
					"			bonus_point_previous						= '" . intval($this->getUserObj()->user_bonus_point) . "', " .
					"			bonus_point_earned							= '" . intval($this->total_bonus_point) . "', " .
					"			bonus_point_canbeused						= '" . intval($this->bonus_point_can_be_used) . "', " .
					"			bonus_point_redeemed						= '" . intval($this->total_bonus_point_required) . "', " .
					"			bonus_point_balance							= '" . intval($this->bonus_point_balance)  . "', " .
					"			bonus_point_redeemed_cash					= '" . doubleval($this->total_cash_value) . "', " .
					"			bonus_point_redeemed_cash_ca				= '" . doubleval($this->total_cash_value_ca) . "', " .
					"			payment_confirmed							= 'N', " .
					"			order_confirmed								= '" . ynval($OrderConfirmed) . "', " .
					"			currency_id									= '" . intval($this->getCartDetailsObj()->currency_id) . "', " .
					"			currency_site_rate_atm						= '" . $this->getEffectiveCurrencyRate() . "', " .
					"			user_balance_previous						= '" . doubleval($this->getUserObj()->user_balance) . "', " .
					"			user_balance_used							= '" . doubleval($this->getCartDetailsObj()->user_balance_use) . "', " .
					"			user_balance_used_ca						= '" . $this->user_balnce_used_ca . "', " .
					"			user_balance_after							= '" . $this->user_balance_after . "', " .
					"			effective_base_price_id						= '" . intval($this->getCartDetailsObj()->effective_base_price_id) . "', " .
					"			total_price									= '" . doubleval($this->total_price) . "', " .
					"			total_price_ca								= '" . doubleval($this->total_price_ca) . "', " .
					"			discount_amount_ca							= '" . doubleval($this->getCartDetailsObj()->discount_amount_ca) . "', " .
					"			user_input_discount_code					= '" . aveEscT($this->getCartDetailsObj()->discount_code) . "', " .
					"			effective_discount_postprocess_rule_id		= '" . $this->effective_discount_postprocess_rule_id . "', " .
					"			effective_discount_postprocess_rule_discount_code		= '" . aveEscT($this->effective_discount_postprocess_rule_discount_code) . "', " .
					"			postprocess_rule_discount_amount			= '" . doubleval($this->postprocess_rule_discount_amount) . "', " .
					"			postprocess_rule_discount_amount_ca			= '" . doubleval($this->postprocess_rule_discount_amount_ca) . "', " .
					"			continue_process_postprocess_discount_rule	= '" . ynval($this->ContinuePostProcessRule) . "', " .
					"			freight_cost_ca								= '" . doubleval($this->calculated_freight_cost_ca) . "', " .
					"			pay_amount_ca								= '" . doubleval($this->pay_amount_ca) . "', " .
					"			payment_confirm_by							= null, " .
					"			payment_confirm_date						= null, " .
					"			order_confirm_by							= '" . $OrderConfirmBy . "', " .
					"			order_confirm_date							= " . $OrderConfirmDate . ", " .
					"			create_date									= " . $OrderCreateDate . ", " .
					"			reference_1									= '', " .
					"			reference_2									= '', " .
					"			reference_3									= '', " .
					"			is_handled									= 'N', " . $sql .
					"			user_reference								= '', " .
					"			order_content_type							= '" . $this->cart_content_type . "', " .
					"			self_take									= '" . ynval($this->getCartDetailsObj()->self_take) . "' ";
		if ($OldOrderID != 0)
			$query = $query . "	WHERE myorder_id = '" . $OldOrderID . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($OldOrderID == 0)
			$NewOrderID = customdb::mysqli()->insert_id;
		else
			$NewOrderID = $OldOrderID;

		if ($OldOrderID != 0) {
			$query  =	" 	DELETE FROM	myorder_product " .
						"	WHERE		myorder_id = '" . $OldOrderID . "' ";			
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query  =	" 	DELETE FROM	myorder_bonus_point_item " .
						"	WHERE		myorder_id = '" . $OldOrderID . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		if ($this->cart_content_type != 'bonus_point') {
			foreach($this->calculated_product_list as $P) {
				/* @var $P cart_result_product */
				if ($P->quantity > 0) {
					$query  =	" 	INSERT INTO	myorder_product " .
								"	SET		myorder_id								= '" . $NewOrderID . "', " .
								"			product_id								= '" . intval($P->product_id) . "', " .
								"			currency_id								= '" . intval($this->getCurrencyObj()->currency_id) . "', " .
								"			product_base_price						= '" . doubleval($P->product_base_price) . "', " .
								"			product_base_price_ca					= '" . doubleval($P->product_base_price_ca) . "', " .
								"			product_price							= '" . doubleval($P->product_price) . "', " .
								"			product_price_ca						= '" . doubleval($P->product_price_ca) . "', " .
								"			product_price2							= '" . doubleval($P->product_price2) . "', " .
								"			product_price2_ca						= '" . doubleval($P->product_price2_ca) . "', " .
								"			product_price3							= '" . doubleval($P->product_price3) . "', " .
								"			product_price3_ca						= '" . doubleval($P->product_price3_ca) . "', " .
								"			product_bonus_point_amount				= '" . intval($P->product_bonus_point_amount) . "', " .
								"			actual_subtotal_price					= '" . doubleval($P->actual_subtotal_price) . "', " .
								"			actual_subtotal_price_ca				= '" . doubleval($P->actual_subtotal_price_ca) . "', " .
								"			actual_unit_price						= '" . doubleval($P->actual_unit_price) . "', " .
								"			actual_unit_price_ca					= '" . doubleval($P->actual_unit_price_ca) . "', " .
								"			quantity								= '" . intval($P->quantity) . "', " .
								"			effective_discount_type					= '" . intval($P->effective_discount_type) . "', " .
								"			effective_discount_preprocess_rule_id	= '" . intval($P->effective_discount_preprocess_rule_id) . "', " .
								"			effective_discount_preprocess_code		= '" . aveEscT($P->effective_discount_preprocess_code) . "', " .
								"			effective_discount_bundle_rule_id		= '" . intval($P->effective_discount_bundle_rule_id) . "', " .
								"			effective_discount_bundle_code			= '" . aveEscT($P->effective_discount_bundle_code) . "', " .
								"			discount1_off_p							= '" . intval($P->discount1_off_p) . "', " .
								"			discount2_amount						= '" . intval($P->discount2_amount) . "', " .
								"			discount2_price							= '" . doubleval($P->discount2_price) . "', " .
								"			discount2_price_ca						= '" . doubleval($P->discount2_price_ca) . "', " .
								"			discount3_buy_amount					= '" . intval($P->discount3_buy_amount) . "', " .
								"			discount3_free_amount					= '" . intval($P->discount3_free_amount) . "', " .
								"			product_option_id						= '" . intval($P->product_option_id) . "', " .
								"			product_price_id						= '" . intval($P->product_price_id) . "', " .
								"			cart_content_custom_key					= '" . aveEscT($P->cart_content_custom_key) . "', " .
								"			cart_content_custom_desc				= '" . aveEscT($P->cart_content_custom_desc) . "', " .
								"			product_bonus_point_required			= '" . intval($P->product_bonus_point_required) . "' ";
					$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
				}
			}
		}

		foreach($this->calculated_bonus_point_item_list as $B) {
			$query  =	" 	INSERT INTO	myorder_bonus_point_item " .
						"	SET		myorder_id						= '" . $NewOrderID . "', " .
						"			bonus_point_item_id				= '" . intval($B->bonus_point_item_id) . "', " .
						"			currency_id						= '" . intval($this->getCurrencyObj()->currency_id) . "', " .
						"			quantity						= '" . intval($B->quantity) . "', " .
						"			bonus_point_required			= '" . intval($B->bonus_point_required) . "', " .
						"			cash							= '" . doubleval($B->cash) . "', " .
						"			cash_ca							= '" . doubleval($B->cash_ca) . "', " .
						"			subtotal_cash					= '" . doubleval($B->subtotal_cash) . "', " .
						"			subtotal_cash_ca				= '" . doubleval($B->subtotal_cash_ca) . "', " .
						"			subtotal_bonus_point_required	= '" . intval($B->subtotal_bonus_point_required) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		if ($OldOrderID == 0) {
			$NewOrder = new myorder($NewOrderID);
			$NewOrder->UpdateOrderNo();
		}

		$query  =	" 	DELETE	FROM	cart_content " .
					"	WHERE	user_id				= '" . $this->user_id . "' " .
					"		AND	cart_content_type	= '" . $this->cart_content_type . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query  =	" 	DELETE	FROM	cart_bonus_point_item " .
					"	WHERE	user_id				= '" . $this->user_id . "' " .
					"		AND	cart_content_type	= '" . $this->cart_content_type . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query  =	" 	DELETE	FROM	cart_details " .
					"	WHERE	user_id				= '" . $this->user_id . "' " .
					"		AND	cart_content_type	= '" . $this->cart_content_type . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($CartType != 'temp')
			$this->TouchCart();

		if ($CartType != 'bonus_point') {
			if ($this->getSiteObj()->site_module_inventory_enable == 'Y' && $OrderStatus == 'payment_pending') {
				if ($this->getSiteObj()->site_auto_hold_stock_status == 'payment_pending') {
					inventory::HoldStockForMyOrder($this->site_id, $NewOrderID);
					site::EmptyAPICache($this->site_id);
				}
			}
		}
	}

	public function GetCartItemListWithoutCalculation() {
		$sql = '';

		if ($this->HonorArchiveDate)
			$sql	=	$sql . "	AND	O.object_archive_date > NOW() ";
		if ($this->HonorPublishDate)
			$sql	=	$sql . "	AND	O.object_publish_date < NOW() ";

		$query =	"	SELECT		* " .
					"	FROM		cart_content W		JOIN object O		ON	(O.object_id = W.product_id) " .
					"									JOIN object_link OL	ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"	WHERE		O.object_is_enable = 'Y' " .
					"			AND	OL.object_link_is_enable = 'Y' " .
					"			AND O.object_security_level <= '" . $this->getUserSecurityLevel() . "'" . $sql .
					"			AND	W.cart_content_type = '" . $this->cart_content_type . "'" .
					"			AND	W.user_id = '" . $this->user_id . "'" .
					"			AND	W.site_id = '" . $this->site_id . "'" .
					"			AND	W.system_admin_id = '" . $this->system_admin_id . "'" .
					"			AND	W.content_admin_id = '" . $this->content_admin_id . "'" .
					"	GROUP BY	W.product_id, W.product_option_id, W.product_price_id, W.cart_content_custom_key " .
					"	ORDER BY	W.product_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$CartItemList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($CartItemList, $myResult);
		}
		return $CartItemList;
	}
	
	public static function GetBonusPointItemListWithCartQuantity($SiteID, $UserID, $CurrencyID, $LanguageID, $SecurityLevel, $CartContentType = 'normal', $IsEnable = 'ALL', $BonusPointRequired = 999999, $OrderBy = 'ASC', $HonorArchiveDate = false, $HonorPublishDate = false) {
		if (strtoupper($OrderBy) != 'ASC' && strtoupper($OrderBy) != 'DESC' )
			$OrderBy = 'ASC';

		$sql = '';
		if ($IsEnable == 'Y')
			$sql =	$sql . "	AND	O.object_is_enable = 'Y' ";
		elseif ($IsEnable == 'N')
			$sql =	$sql . "	AND	O.object_is_enable = 'N' ";

		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	O.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	O.object_publish_date < NOW() ";

		$query =	"	SELECT		*, W.*, B.*, O.*, L.* " .
					"	FROM		language L	JOIN bonus_point_item B					ON	(L.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN object O							ON	(O.object_id = B.bonus_point_item_id) " .
					"							LEFT JOIN cart_bonus_point_item W		ON	(B.bonus_point_item_id = W.bonus_point_item_id AND W.user_id = '" . intval($UserID) . "' AND W.cart_content_type = '" . aveEscT($CartContentType) . "')" .
					"							LEFT JOIN bonus_point_item_data BD		ON	(BD.language_id = L.language_id AND BD.bonus_point_item_id = B.bonus_point_item_id) " .
					"	WHERE		O.site_id = '" . intval($SiteID) . "'" .
					"		AND		B.bonus_point_required <= '" . intval($BonusPointRequired) . "'" .
					"		AND		O.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql .
					"	ORDER BY	B.bonus_point_required " . $OrderBy;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$BonusPointItemList = array();
		
		$Currency = currency::GetCurrencyInfo($CurrencyID, $SiteID);
		while ($myResult = $result->fetch_object()) {
			$myResult->currency_id = $CurrencyID;
			$myResult->cash_ca = round($myResult->cash * $Currency['currency_site_rate'], $Currency['currency_precision']);
			$myResult->subtotal_cash = $myResult->cash * $myResult->quantity;
			$myResult->subtotal_cash_ca = $myResult->cash_ca * $myResult->quantity;
			$myResult->subtotal_bonus_point_required = $myResult->bonus_point_required * $myResult->quantity;
			array_push($BonusPointItemList, $myResult);
		}
		return $BonusPointItemList;
	}
	
	
	public static function GetBonusPointItemListWithCartQuantityXML($SiteID, $UserID, $CurrencyID, $LanguageID, $SecurityLevel, $CartContentType = 'normal', $IsEnable = 'ALL', $BonusPointRequired = 999999, $OrderBy = 'ASC') {
		$smarty = new mySmarty();
		
		$BonusPointItemList = self::GetBonusPointItemListWithCartQuantity($SiteID, $UserID, $CurrencyID, $LanguageID, $SecurityLevel, $CartContentType, 'Y', $BonusPointRequired, $OrderBy, true, true);

		$BonusPointItemListXML = '';
		
		foreach ($BonusPointItemList as $B) {
			/* @var $B cart_result_bonus_point_item */
			$BonusPointItemXML = bonuspoint::GetBonusPointItemXML($B->bonus_point_item_id, $LanguageID, false);
			$smarty->assign('BonusPointItemXML', $BonusPointItemXML);
			$smarty->assign('CartResultBonusPointItem', $B);
			
			$BonusPointItemListXML .= $smarty->fetch('api/object_info/CART_BONUS_POINT_ITEM.tpl');
		}
		return "<bonus_point_item_list>" . $BonusPointItemListXML . "</bonus_point_item_list>";		
	}
	
}