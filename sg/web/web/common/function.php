<?php
function xmlentities ($string) {
	return str_replace ( array ( '&', '"', "'", '<', '>' ), array ( '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;' ), $string );
}

function GetNoOfDigits($no, $count = 1) {
if ($no/10 < 1)
	return $count;
else
	return GetNoOfDigits($no/10, ++$count);
}

function IsValidEmail($email) {
	return (!filter_var($email, FILTER_VALIDATE_EMAIL) === false);		
}

function IsValidEmail_ForRemoteSite($email) {
	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		return false;
	}
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
		  return false;
		}
	}
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
		    return false;
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
}

function checkDateFormat($date) {
	if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)) {
		if(checkdate($parts[2],$parts[3],$parts[1]))
			return true;
		else
			return false;
		}
	else
		return false;
}

function IsValidPassword(&$ErrMsg, $Password, $Password2) {
	if (strlen(trim($Password)) < MIN_PASSWORD || strlen(trim($Password)) > MAX_PASSWORD) {
		$ErrMsg = ERROR_INVALID_PASSWORD_LENGTH;
		return false;
	}
	if (trim($Password) !== trim($Password2)) {
		$ErrMsg = ERROR_PASSWORDS_DO_NOT_MATCH;
		return false;
	}
	return true;
}

function UserDie($Msg, $URL = "javascript: history.go(-1)", $LineNo = 0) {
	global $smarty;
	global $CurrentLang;
	$smarty->assign('Msg', $Msg);
	$smarty->assign('URL', $URL);
	$smarty->display($CurrentLang->language_root->language_id . '/user_error.tpl');
	die();
}

function LoginDie() {
	header('Location: /login.php');
	exit();
}

function ynval($input) {
	if ($input !== 'Y')
		return 'N';
	else
		return 'Y';
}

function GenerateGoToPaypalURL($Cart){
	
	global $PayPalAPICommon, $CurrentLang, $CurrentCurrency;
	
	//Postdiscount
	$PostprocessRuleIsValid = false;
	if(intval($Cart->cart_details->effective_discount_postprocess_rule_id) > 0){	
		$PostprocessRuleID = intval($Cart->cart_details->effective_discount_postprocess_rule_id);
		$PostprocessRule = ApiQuery('discount_postprocess_rule_get_info.php', __LINE__, 'rule_id=' . $PostprocessRuleID . '&lang_id=' . $CurrentLang->language_root->language_id);
		$PostprocessRuleIsValid = true;
	}
	
	// Redirect to Paypal for payment(has product list)
	$url	=	$PayPalAPICommon . "&" .
				'METHOD=SetExpressCheckout' . "&" .
				'PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($CurrentCurrency->currency->currency_paypal) . "&";
	
				$i = 0;
				foreach($Cart->cart_details->cart_item_list->product as $P){
					
					if(intval($P->quantity) > 0){
					
						$url .= 
						'L_PAYMENTREQUEST_0_NAME' . $i . '=' . urlencode($P->product_name) . "&" .				//product_name
						'L_PAYMENTREQUEST_0_NUMBER' . $i . '=' . urlencode($P->product_code) . "&" .			//product_code
						'L_PAYMENTREQUEST_0_AMT' . $i . '=' . urlencode($P->actual_unit_price_ca) . "&" .		//product_price
						'L_PAYMENTREQUEST_0_QTY' . $i . '=' . urlencode($P->quantity) . "&";					//product_qty
						$i++;
					
					}

				}

				//loop postprocess rule
				if($PostprocessRuleIsValid){

					$url .=
					'L_PAYMENTREQUEST_0_NAME' . $i . '=' . urlencode($PostprocessRule->discount_postprocess_rule->discount_postprocess_rule_name) . "&" .	//product_name
					'L_PAYMENTREQUEST_0_AMT' . $i . '=' . urlencode('-' . $Cart->cart_details->postprocess_rule_discount_amount_ca) . "&" .					//product_price (negative)
					'L_PAYMENTREQUEST_0_QTY' . $i . '=' . urlencode('1') . "&";   																			//product_qty
					$i++;

				}

				$ItemAMT = doubleval($Cart->cart_details->total_price_ca) - doubleval($Cart->cart_details->postprocess_rule_discount_amount_ca);
				$url .= 
				'PAYMENTREQUEST_0_ITEMAMT=' . urlencode($ItemAMT) . "&" .
				'PAYMENTREQUEST_0_SHIPPINGAMT=' . urlencode($Cart->cart_details->cart_freight_cost_ca) . "&" .
				'PAYMENTREQUEST_0_AMT=' . urlencode($Cart->cart_details->pay_amount_ca) . "&" .
				'L_PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($CurrentCurrency->currency->currency_paypal) . "&" .
				'RETURNURL=' . urlencode(PAYPAL_RETURN_URL) . "&" .
				'CANCELURL=' . urlencode(PAYPAL_CANCEL_URL) . "&" .
				'PAYMENTREQUEST_0_PAYMENTACTION=Sale' . "&" .
				'LANDINGPAGE=Billing' . "&" .
				'NOSHIPPING=1' . "&" .
				'LOCALECODE=' . PAYPAL_LANGUAGE_CODE;

	return $url;
				
}

function GeneratePaypalBackURL($MyOrder, $requestToken, $requestPayerID){
	
	global $PayPalAPICommon, $CurrentLang, $CurrentCurrency;
	
	//Postdiscount
	$PostprocessRuleIsValid = false;
	if(intval($MyOrder->myorder->effective_discount_postprocess_rule_id) > 0){	
		$PostprocessRuleID = intval($MyOrder->myorder->effective_discount_postprocess_rule_id);
		$PostprocessRule = ApiQuery('discount_postprocess_rule_get_info.php', __LINE__, 'rule_id=' . $PostprocessRuleID . '&lang_id=' . $CurrentLang->language_root->language_id);
		$PostprocessRuleIsValid = true;
	}
	
	// Redirect to Paypal for payment(has product list)
	$url	=	$PayPalAPICommon . "&" .
				'METHOD=DoExpressCheckoutPayment' . "&" .
				'TOKEN=' . urlencode($requestToken) . "&" .
				'PAYERID=' . urlencode($requestPayerID) . "&" .
				'PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($MyOrder->myorder->currency_paypal) . "&";
			
				$i = 0;
				foreach($MyOrder->myorder->myorder_products->myorder_product as $P){
					
					if(intval($P->quantity) > 0){
					
						$url .= 
						'L_PAYMENTREQUEST_0_NAME' . $i . '=' . urlencode($P->product_name) . "&" .				//product_name
						'L_PAYMENTREQUEST_0_NUMBER' . $i . '=' . urlencode($P->product_code) . "&" .			//product_code
						'L_PAYMENTREQUEST_0_AMT' . $i . '=' . urlencode($P->actual_unit_price_ca) . "&" .		//product_price
						'L_PAYMENTREQUEST_0_QTY' . $i . '=' . urlencode($P->quantity) . "&";					//product_qty
						$i++;
					
					}
					
				}
				
				//loop postprocess rule
				if($PostprocessRuleIsValid){

					$url .=
					'L_PAYMENTREQUEST_0_NAME' . $i . '=' . urlencode($PostprocessRule->discount_postprocess_rule->discount_postprocess_rule_name) . "&" .	//product_name
					'L_PAYMENTREQUEST_0_AMT' . $i . '=' . urlencode('-' . $MyOrder->myorder->postprocess_rule_discount_amount_ca) . "&" .					//product_price (negative)
					'L_PAYMENTREQUEST_0_QTY' . $i . '=' . urlencode('1') . "&";   																			//product_qty
					$i++;

				}
	
				$ItemAMT = doubleval($MyOrder->myorder->total_price_ca) - doubleval($MyOrder->myorder->postprocess_rule_discount_amount_ca);
				$url .= 
				'PAYMENTREQUEST_0_ITEMAMT=' . urlencode($ItemAMT) . "&" .
				'PAYMENTREQUEST_0_SHIPPINGAMT=' . urlencode($MyOrder->myorder->freight_cost_ca) . "&" .
				'PAYMENTREQUEST_0_AMT=' . urlencode($MyOrder->myorder->pay_amount_ca) . "&" .
				//'PAYMENTREQUEST_0_CUSTOM=' . urlencode($MyOrder->myorder->order_no) . "&" .
				'PAYMENTREQUEST_0_INVNUM=' . urlencode($MyOrder->myorder->order_no) . "&" .
				'L_PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($CurrentCurrency->currency->currency_paypal) . "&" .
				'PAYMENTREQUEST_0_PAYMENTACTION=Sale';

	return $url;
				
}

function SubmenuProductGetProductCode($ProductLinkID){
	
	global $CurrentLang, $CurrentCurrency;

	$Product = ApiQuery('product_get_info.php', __LINE__,
						'link_id=' . $ProductLinkID .
						'&lang_id=' . $CurrentLang->language_root->language_id .
						'&currency_id=' . $CurrentCurrency->currency->currency_id
						);
	
	return $Product->product->product_code;
}

function SubmenuProductGetPrice($ProductLinkID){
	
	global $CurrentLang, $CurrentCurrency;

	$Product = ApiQuery('product_get_info.php', __LINE__,
						'link_id=' . $ProductLinkID .
						'&lang_id=' . $CurrentLang->language_root->language_id .
						'&currency_id=' . $CurrentCurrency->currency->currency_id
						);
	
	return $Product->product->product_price;
}

function AddressTcMakeGoogleSearchKey($AddressTC){
	
	if(strpos($AddressTC, '號') !== false){
		$SearchKey = explode('號', $AddressTC);
		return $SearchKey[0] . '號';
	}
	if(strpos($AddressTC, '大廈') !== false){
		$SearchKey = explode('大廈', $AddressTC);
		return $SearchKey[0] . '大廈';
	}
	if(strpos($AddressTC, '廣場') !== false){
		$SearchKey = explode('廣場', $AddressTC);
		return $SearchKey[0] . '廣場';
	}
	if(strpos($AddressTC, '商場') !== false){
		$SearchKey = explode('商場', $AddressTC);
		return $SearchKey[0] . '商場';
	}
	if(strpos($AddressTC, '中心') !== false){
		$SearchKey = explode('中心', $AddressTC);
		return $SearchKey[0] . '中心';
	}
	if(strpos($AddressTC, '花園') !== false){
		$SearchKey = explode('花園', $AddressTC);
		return $SearchKey[0] . '花園';
	}
	if(strpos($AddressTC, '道') !== false){
		$SearchKey = explode('道', $AddressTC);
		return $SearchKey[0] . '道';
	}
	if(strpos($AddressTC, '街') !== false){
		$SearchKey = explode('街', $AddressTC);
		return $SearchKey[0] . '街';
	}
	else {
		
		if(strpos($AddressTC, '旺角') !== false){
			$SearchKey = explode('旺角', $AddressTC);
			return $SearchKey[0] . '旺角';
		}
		
		return $AddressTC;
	}
	
}

function GetSeoUrl($LinkID){
	
	global $CurrentLang, $CurrentCurrency;

	$ObjectLink = ApiQuery('object_link_get_info.php', __LINE__, 'link_id=' . $LinkID);
	
	if($ObjectLink->object->object_type == "PRODUCT_CATEGORY"){
		
		$ProductCategoryLink = ApiQuery('product_category_info.php', __LINE__,
										'link_id=' . $LinkID .
										'&page_no=' . 1 .
										'&products_per_page=' . 0 .
										'&security_level=' . 0 . 
										'&lang_id=' . $CurrentLang->language_root->language_id .
										'&currency_id=' . $CurrentCurrency->currency->currency_id
										);
		return $ProductCategoryLink->product_category->object_seo_url;
	}
	else 
		return $ObjectLink->object->object_seo_url;

}

function LayoutNewsRootIDGetLayoutNewsPageLinkID($rootID){
	
	if($rootID == NEWS_LAYOUT_NEWS_ROOT_ID)
		return LAYOUT_NEWS_ROOT_LINK_ID;

	else if($rootID == OTHER_NEWS_LAYOUT_NEWS_ROOT_ID)
		return OTHER_LAYOUT_NEWS_ROOT_LINK_ID;

	else if($rootID == IMPORTANT_ISSUE_LAYOUT_NEWS_ROOT_ID)
		return IMPORTANT_NOTICES_LAYOUT_NEWS_ROOT_LINK_ID;	
}

function ProductGetProductFatherCategoryName($productParentObjID){
	
	global $CurrentLang;

	$localCache = customLocalCache::Singleton();
	$productCatFatherCategoryName = $localCache->getCache('jsonCacheProductCatFatherCategoryName', array(), false);
	$langID = intval($CurrentLang->language_root->language_id);
	
	return $productCatFatherCategoryName[$langID][strval($productParentObjID)];
}

function ProductSearchIntergerValueQTY($customValue){	
	$ValueListCount = array(0 => 0, 1 => 0);

	for ($index = 0; $index < count($customValue->value); $index++) {
		$ValueListCount[intval($customValue->value[$index])] += intval($customValue->count[$index]);
	}
	return $ValueListCount;
}

function ProductSearchStringValueQTY($customValue){
	$ValueListCount = array();

	for ($index = 0; $index < count($customValue->value); $index++) {
		$ValueListCount[trim(strval($customValue->value[$index]))] = intval($customValue->count[$index]);
	}
	return $ValueListCount;
}

function ProductSearchCategoryResultQTY($product_category_list, $categoryQTYGroup){

	if(count($product_category_list) > 0){

		foreach($product_category_list as $productCat){
			
			$categoryQTYGroup[intval($productCat->parent_object_id)][0] += intval($productCat->total_no_of_products);
			
			//echo "Cat:" . $productCat->parent_object_id . " - " . $categoryQTYGroup[intval($productCat->parent_object_id)][0] . "<br/>";
		}
	}
	
	return $categoryQTYGroup;
}

function GetSearchResultOfObjectQtyGroup($ApisearchProducts){	
	$SearchValueQTY = array();
	
	$XMLFieldName = "";

	//Custom Int Handle
	for($i=2;$i<=11;$i++){
		$XMLFieldName = "value_list_of_product_custom_int_" . $i;
		$SearchValueQTY["product_custom_int_" . $i] = ProductSearchIntergerValueQTY($ApisearchProducts->$XMLFieldName);
	}
	
	$XMLFieldName = "";
	//Custom Text Handle
	for($i=1;$i<=6;$i++){
		$XMLFieldName = "value_list_of_product_custom_text_" . $i;
		$SearchValueQTY["product_custom_text_" . $i] = ProductSearchStringValueQTY($ApisearchProducts->$XMLFieldName);
	}
	
	//Product Category Handle
	//$SearchValueQTY = ProductSearchCategoryResultQTY($ApisearchProducts->product_category_list->product_category, $SearchValueQTY);
	
	return $SearchValueQTY;
}