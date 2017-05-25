<?php
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');

/***
 * page_no
 * product_custom_int_1 (gender)
 * product_custom_text_1 (kudo)
 * product_custom_text_2 (Denpa)
 * product_custom_text_3 (Case)
 * product_custom_text_3 (Strap)
 * product_custom_text_5 (Water Resistant)
 * product_custom_text_6 (Glass)
 * product_price		 (product_price <= search_price)
 * product_features		 (product_custom_int 2-8)
 * order_by				 (order_by)
 * product_category_id
 */

if(intval($_REQUEST["page_no"]) < 1)
	$_REQUEST["page_no"] = 1;

if(intval($_REQUEST['product_custom_int_1']) < 0 || intval($_REQUEST['product_custom_int_1']) > 2)
	$_REQUEST['product_custom_int_1'] = 1;

$product_custom_int_1_sql = "";
$product_custom_int_1_sql = "&product_custom_int_1=" . intval($_REQUEST["product_custom_int_1"]);

$product_custom_text_1_sql = "";
if(trim($_REQUEST["product_custom_text_1"]) != ""){
	$CustomText1 = substr(trim($_REQUEST["product_custom_text_1"]), 1);
	$product_custom_text_1_sql .= "&product_custom_text_1=" . urlencode(trim($CustomText1));
}

$product_custom_text_2_sql = "";
if(trim($_REQUEST["product_custom_text_2"]) != ""){
	$CustomText2 = substr(trim($_REQUEST["product_custom_text_2"]), 1);
	$product_custom_text_2_sql .= "&product_custom_text_2=" . urlencode(trim($CustomText2));
}

$product_custom_text_3_sql = "";
if(trim($_REQUEST["product_custom_text_3"]) != ""){
	$CustomText3 = substr(trim($_REQUEST["product_custom_text_3"]), 1);
	$product_custom_text_3_sql .= "&product_custom_text_3=" . urlencode(trim($CustomText3));
}

$product_custom_text_4_sql = "";
if(trim($_REQUEST["product_custom_text_4"]) != ""){
	$CustomText4 = substr(trim($_REQUEST["product_custom_text_4"]), 1);
	$product_custom_text_4_sql .= "&product_custom_text_4=" . urlencode(trim($CustomText4));
}

$product_custom_text_5_sql = "";
if(trim($_REQUEST["product_custom_text_5"]) != ""){
	$CustomText5 = substr(trim($_REQUEST["product_custom_text_5"]), 1);
	$product_custom_text_5_sql .= "&product_custom_text_5=" . urlencode(trim($CustomText5));
}

$product_custom_text_6_sql = "";
if(trim($_REQUEST["product_custom_text_6"]) != ""){
	$CustomText6 = substr(trim($_REQUEST["product_custom_text_6"]), 1);
	$product_custom_text_6_sql .= "&product_custom_text_6=" . urlencode(trim($CustomText6));
}

$product_price_sql = "";
$ProductPrice = substr(trim($_REQUEST["product_price"]), 1);
if(doubleval($ProductPrice) > 0){
	$product_price_sql = "&product_price=" . urlencode(doubleval($ProductPrice));
	$product_price_sql .= "&product_price_operator=" . urlencode('<=');
	$product_price_sql .= "&product_price_id=" . 1;
}

$product_features_sql = "";
if(trim($_REQUEST["product_features"]) != ""){
	
	$ProductFeatures = substr(trim($_REQUEST["product_features"]), 1);
	$ProductFeaturesList = explode(",", $ProductFeatures);

	if(count($ProductFeaturesList) > 0){
		foreach($ProductFeaturesList as $F){
			
			switch($F){
				case "product_custom_int_2":
					$product_features_sql .= "&product_custom_int_2=1"; //New - 新產品
					break;
				case "product_custom_int_3":
					$product_features_sql .= "&product_custom_int_3=1"; //Limited - 限量款式
					break;
				case "product_custom_int_4":
					$product_features_sql .= "&product_custom_int_4=1"; //Calendar - 日曆顯示
					break;
				case "product_custom_int_5":
					$product_features_sql .= "&product_custom_int_5=1"; //Chronograph - 計時秒錶
					break;
				case "product_custom_int_6":
					$product_features_sql .= "&product_custom_int_6=1"; //Alarm - 嚮鬧功能
					break;
				case "product_custom_int_7":
					$product_features_sql .= "&product_custom_int_7=1"; //Duratect
					break;
				case "product_custom_int_8":
					$product_features_sql .= "&product_custom_int_8=1"; //Luminous - 夜光顯示
					break;
				case "product_custom_int_10":
					$product_features_sql .= "&product_custom_int_10=1"; //Flying Distance and Navigation Calculations - 飛行計算尺
					break;
				case "product_custom_int_11":
					$product_features_sql .= "&product_custom_int_11=1"; //Perpetual Calendar - 萬年曆
					break;
				default:
					break;
			}
			
		}
	}

}

$order_by_sql = "";
switch(trim($_REQUEST["order_by"])){
	case "price_desc":
		$order_by_sql .= "&order_by_product_price=desc";
		break;
	case "price_asc":
		$order_by_sql .= "&order_by_product_price=asc";
		break;
}

if(intval($_REQUEST["product_custom_int_1"]) == 0){
	$order_by_sql .= "&order_by_product_custom_text_13=asc";
}
$order_by_sql .= "&order_by_object_link_order_id=asc";

$product_category_id_sql = "";
if(intval($_REQUEST["product_category_id"]) > 0)
	$product_category_id_sql = "product_category_id=" . intval($_REQUEST["product_category_id"]);
else 
	$product_category_id_sql = "product_category_id=" . PRODUCT_ROOT_ID;

//Real Search API
$Products = ApiQuery('product_search.php', __LINE__,
					 $product_category_id_sql .
					 '&security_level=' . $SessionUserSecurityLevel .
					 '&page_no=' . intval($_REQUEST["page_no"]) .
					 '&objects_per_page=' . PRODUCT_SEARCH_PER_PAGE . 
					 '&lang_id=' . $CurrentLang->language_root->language_id .
					 '&include_sub_category=Y' .
					 $product_custom_int_1_sql .
					 $product_custom_text_1_sql .
					 $product_custom_text_2_sql .
					 $product_custom_text_3_sql .
					 $product_custom_text_4_sql .
					 $product_custom_text_5_sql .
					 $product_custom_text_6_sql .
					 $product_price_sql .
					 $product_features_sql .
					 $order_by_sql// .
//					 '&return_value_list_of_product_custom_text_1=Y' .
//					 '&return_value_list_of_product_custom_text_2=Y' .
//					 '&return_value_list_of_product_custom_text_3=Y' .
//					 '&return_value_list_of_product_custom_text_4=Y' .
//					 '&return_value_list_of_product_custom_text_5=Y' .
//					 '&return_value_list_of_product_custom_text_6=Y' .
//					 '&return_product_category_list=Y' .							//total_no_of_products
//					 '&return_value_list_of_product_custom_int_2=Y' .
//					 '&return_value_list_of_product_custom_int_3=Y' .
//					 '&return_value_list_of_product_custom_int_4=Y' .
//					 '&return_value_list_of_product_custom_int_5=Y' .
//					 '&return_value_list_of_product_custom_int_6=Y' .
//					 '&return_value_list_of_product_custom_int_7=Y' .
//					 '&return_value_list_of_product_custom_int_8=Y' .
//					 '&return_value_list_of_product_custom_int_10=Y' .
//					 '&return_value_list_of_product_custom_int_11=Y'
					 //,false, true
					 );
$smarty->assign("Products", $Products);

$TotalNoOfObjects = intval($Products->total_no_of_objects);
$TotalPageNo = ceil( $Products->total_no_of_objects / PRODUCT_SEARCH_PER_PAGE);

//Get Other Condition Search QTY API
$localCache = customLocalCache::Singleton();
$SearchValueQTY = $localCache->getCache('jsonCacheProductSearchFirstLevelData', array('lang_id' => intval($CurrentLang->language_root->language_id)), true);
$SearchValueQTY = $SearchValueQTY[intval($_REQUEST["product_custom_int_1"])];

$ForProductCategoryQtyData = ApiQuery('product_search.php', __LINE__,
										'product_category_id=' . PRODUCT_ROOT_ID .
										'&security_level=' . $SessionUserSecurityLevel .
										'&page_no=' . intval($_REQUEST["page_no"]) .
										'&objects_per_page=' . PRODUCT_SEARCH_PER_PAGE . 
										'&lang_id=' . $CurrentLang->language_root->language_id .
										'&include_sub_category=Y' .
										$product_custom_int_1_sql .
										$product_custom_text_1_sql .
										$product_custom_text_2_sql .
										$product_custom_text_3_sql .
										$product_custom_text_4_sql .
										$product_custom_text_5_sql .
										$product_custom_text_6_sql .
										$product_price_sql .
										$product_features_sql .
										$order_by_sql .
										'&return_product_category_list=Y'							//total_no_of_products
										//,false, true
										);

//Product Category Handle
$SearchValueQTY = ProductSearchCategoryResultQTY($ForProductCategoryQtyData->product_category_list->product_category, $SearchValueQTY);

//For Mobile Category Option
$MobileWatchSearchCategorySelectOption = "";
if($_SESSION['view'] == 'm'){
	
		$ProductRootLink = $localCache->getCache('xmlCacheProductRootLinkInfo', array('lang_id' => intval($CurrentLang->language_root->language_id)));
		
		$MobileWatchSearchCategorySelectOption = "<option value='0'>" . ALL_SERIES_LABEL . "(" . intval(intval($ForProductCategoryQtyData->total_no_of_objects)) . ")</option>";
		
		if(count($ProductRootLink->product_category->product_categories->product_category) > 0){
			foreach($ProductRootLink->product_category->product_categories->product_category as $productCategory){
			
				if(intval($_REQUEST["product_category_id"]) == intval($productCategory->object_id)){
					
					$MobileWatchSearchCategorySelectOption .= 
						"<option value='" . $productCategory->object_id . "' selected>" . 
						$productCategory->product_category_name . 
						"(" . intval($SearchValueQTY[ intval($productCategory->object_id) ][0]) . ")" .
						"</option>";
					
				}
				else {
				
					$MobileWatchSearchCategorySelectOption .= 
						"<option value='" . $productCategory->object_id . "'>" . 
						$productCategory->product_category_name . 
						"(" . intval($SearchValueQTY[ intval($productCategory->object_id) ][0]) . ")" .
						"</option>";

				}
				
			}
		}

}

if($_SESSION['view'] == 'm')
	$HTML = $smarty->fetch(BASEDIR .'htmlsafe/template_mobile/' . $CurrentLang->language_root->language_id . '/ajax_product_search.tpl');
else 
	$HTML = $smarty->fetch(BASEDIR .'htmlsafe/template/' . $CurrentLang->language_root->language_id . '/ajax_product_search.tpl');

echo json_encode( 
	array(	'html'				=> $HTML,
			//'total_result'		=> $TotalNoOfObjects,
			'real_total_result'	=> $TotalNoOfObjects,
			'total_result'		=> intval($ForProductCategoryQtyData->total_no_of_objects),
			'total_page'		=> $TotalPageNo,
			'search_value_qty'	=> $SearchValueQTY,
			'page_no'			=> $_REQUEST["page_no"],
			'product_category_option_html' => $MobileWatchSearchCategorySelectOption
		)
);
?>
