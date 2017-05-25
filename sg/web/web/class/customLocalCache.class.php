<?php
if (!defined('IN_CMS'))
	define('IN_CMS', true);
require_once(__DIR__ . '/../common/config.php');
require_once(__DIR__ . '/localCache.class.php');

class customLocalCache extends localCache {
	
	public static function Singleton() {
		static $instance = null;
		
		if ($instance === null) {
			$instance = new customLocalCache(CACHE_BASEDIR, false);
		}
		
		return $instance;
	}	

	function __construct($cacheBasePath, $testWritable = false) {
		parent::__construct($cacheBasePath, $testWritable);
	}
	
	public function xmlCacheSiteInfo($args = array()) {
		require_once(__DIR__ . '/../common/config.php');
		$siteXML = ApiQuery('site_get_info.php', __LINE__, '', false, false, null, false, true);
		return $siteXML;
	}
	
	public function xmlCacheCurrencyInfo($args = array()) {
		require_once(__DIR__ . '/../common/config.php');
		$currencyXML = ApiQuery('currency_info.php', __LINE__, 'currency_id=' . $args['currency_id'], false, false, null, false, true);
		return $currencyXML;
	}
	
	public function xmlCacheAllSiteCurrency($args = array()) {
		require_once(__DIR__ . '/../common/config.php');
		$currencyListXML = ApiQuery('currency_list.php', __LINE__, '', false, false, null, false, true);
		return $currencyListXML;	
	}
	
	public function xmlCacheLanguageInfo($args = array()) {
		$languageXML = ApiQuery('language_root_info.php', __LINE__, 'lang_id=' . $args['lang_id'], false, false, null, false, true);
		return $languageXML;
	}
	
	public function xmlCacheLanguageRootList($args = array()) {
		require_once(__DIR__ . '/../common/config.php');
		$languageListXML = ApiQuery('language_root_list.php', __LINE__, '', false, false, null, false, true);
		return $languageListXML;
	}
	
	public function xmlCacheObjectLinkGetInfo($args = array()) {
		$ObjectLink = ApiQuery('object_link_get_info.php', __LINE__, 'link_id=' . $args['link_id'], false, false, null, false, true);
		return $ObjectLink;
	}
	
	public function xmlCacheObjectInfo($args = array()) {
		$ObjectLink = ApiQuery('object_get_info.php', __LINE__, 'object_id=' . $args['id'], false, false, null, false, true);
		return $ObjectLink;
	}
	
	public function rawCacheDesktopMainMenu($args = array()) {
		require_once(BASEWEBDIR . "/common/constant.php");
		require_once(BASEWEBDIR . "/common/function.php");
		global $TOP_MENU_FOLDER_ID;
		$_SESSION['view'] = 'd';
		$smarty = new mySmarty();
		
		$langID = intval($args['lang_id']);
		
		$TopMenu = ApiQuery('folder_get_tree.php', __LINE__,
							'folder_id=' . $TOP_MENU_FOLDER_ID[$langID] .
							'&max_depth=' . 4 .
							'&security_level=0' .
							'&expand_product_root=Y' .
							'&lang_id=' . $langID .
							'&get_obj_details_type_list=PAGE',
							false, false, null, false, false
							);
		$smarty->assign('TopMenu', $TopMenu);
				
		// This is so ugly because of the function SubmenuProductGetPrice called inside the tpl
		if (!isset($GLOBALS['CurrentCurrency'])) {
			$GLOBALS['CurrentCurrency'] = currency::GetCurrencyInfo($args['currency_id']);
		}
		if (!isset($GLOBALS['CurrentLang'])) {
			$GLOBALS['CurrentLang'] = language::GetLanguageInfo($args['lang_id']);
		}		

		$MainMenu = $smarty->fetch(strval($langID) . '/header_mainmenu.tpl');
		
		return $MainMenu;
	}	
	
	public function xmlCacheFolderGetTreeMaxDepth1($args = array()) {
		require_once(BASEWEBDIR . "/common/constant.php");
		$xml = ApiQuery('folder_get_tree.php', __LINE__,
						'folder_id=' . $args['folder_id'] .
						'&max_depth=1' . 
						'&security_level=0' . 
						'&expand_product_root=N' .
						'&lang_id=' . $args['lang_id'],
						false, false, null, false, true
						);
		return $xml;
	}
	
	public function xmlCacheSiteBlockGetInfo($args = array()) {
		require_once(BASEWEBDIR . "/common/constant.php");
		$xml = ApiQuery('siteblock_get_info.php', __LINE__, 'block_def_id=' . $args['block_def_id'] . '&lang_id=' . $args['lang_id'],
						false, false, null, false, true						
				);
		return $xml;
	}
	
	public function xmlCacheProductCategoryInfoBasic($args = array()) {		
		$ProductCategory = ApiQuery('product_category_info.php', __LINE__,
									'link_id=' . $args['link_id'] .
									'&max_depth=' . 1 .
									'&page_no=1' . 
									'&products_per_page=0' . 
									'&security_level=0' .  
									'&lang_id=' . $args['lang_id'] . 
									'&currency_id=' . $args['currency_id'] . 
									'&category_order_by=order_id' .
									'&category_order_type=ASC' .
									'&include_product_details=N' .
									'&include_product_brand_details=N',
									false, false, null, false, true
									);		
		return $ProductCategory;
	}
	
	public function rawCacheProductCatPageMainContent($args = array()) {
		$_SESSION['view'] = $args['view'];
		$smarty = new mySmarty();
		// args
		//	- object_link_id
		//	- lang_id
		//	- currency_id
		
		/***
		 * Product Category Media Rule
		 * 1. Media [0] -> product root page thumbnail
		 * 2. Media [1] -> product category page key content background
		 * 3. Media [2] -> product category page key content logo
		 * 4. Media [3] -> product page brand logo
		 */
		$ProductCategory = ApiQuery('product_category_info.php', __LINE__,
									'link_id=' . $args['object_link_id'] .
									'&max_depth=' . 2 .
									'&page_no=1' . 
									'&products_per_page=9999' . 
									'&security_level=0' .  
									'&lang_id=' . $args['lang_id'] .
									'&currency_id=' . $args['currency_id'] .
									'&product_order_by=order_id' .
									'&product_order_type=ASC' .
									'&category_order_by=order_id' .
									'&category_order_type=ASC' .
									'&include_product_details=Y' .
									'&include_product_brand_details=Y',
									false, false, null, false, false
									);
		$smarty->assign('ProductCategory', $ProductCategory);

		//Get Pair or Product Brand List
		$BrandList = array();
		if(count($ProductCategory->product_category->product_categories->product_category) > 0){
			foreach($ProductCategory->product_category->product_categories->product_category as $PC){

				if(count($PC->products->product) > 0){

					//Display By Pair Handle
					if(intval($PC->product_category_custom_int_3) == 1){

						foreach($PC->products->product as $PairProduct){

							$Pair = explode(",", strval($PairProduct->product_custom_text_13));

							$BrandList[intval($PC->object_id)]['display_by_pair'][$Pair[0]] = $Pair[1];
							
						}

					}
					
					else {

						//Display By Brand Handle
						$BrandProductList = array();
						foreach($PC->products->product as $P){

							if (!array_key_exists(strval($P->product_brand_id), $BrandProductList))
								$BrandProductList[strval($P->product_brand_id)] = array();

							array_push($BrandProductList[strval($P->product_brand_id)], $P);					
						}
						$BrandList[intval($PC->object_id)]['display_by_brand'] = $BrandProductList;
					
					}
					
				}
			}
		}

		$smarty->assign('BrandList', $BrandList);

		//Main Category Level

		if($args['lang_id'] == 1)
			$ContentPageLinkID = intval($ProductCategory->product_category->product_category_custom_int_1);
		else if($args['lang_id'] == 2)
			$ContentPageLinkID = intval($ProductCategory->product_category->product_category_custom_int_2);

		//Content Page
		$Page = ApiQuery('page_get_info.php', __LINE__, 'link_id=' . $ContentPageLinkID, false, false, null, false, false);

//		$KeyVisual = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='KeyVisual']/block_contents/block");
//		$smarty->assign('KeyVisual', $KeyVisual[0]);
//
//		$KeyVisualLogo = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='KeyVisualLogo']/block_contents/block");
//		$smarty->assign('KeyVisualLogo', $KeyVisualLogo[0]);
//
//		$SliderShowTitle = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='SliderShowTitle']/block_contents/block");
//		$smarty->assign('SliderShowTitle', $SliderShowTitle[0]);
//
//		$SliderShowImage = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='SliderShowImage']/block_contents/block");
//		$smarty->assign('SliderShowImage', $SliderShowImage);

		$PickupRow1 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='PickupRow1']/block_contents/block");
		$smarty->assign('PickupRow1', $PickupRow1);

		$PickupRow2 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='PickupRow2']/block_contents/block");
		$smarty->assign('PickupRow2', $PickupRow2);	

		return $smarty->fetch($args['lang_id'] . '/product_category_cache.tpl');
	}
	
	public function jsonCacheProductSearchFirstLevelData($args = array()) {
		require_once(BASEWEBDIR . "/common/constant.php");
		require_once(BASEWEBDIR . "/common/function.php");

		$ProductCount = array();
		for ($i = 0; $i <= 2; $i++) {
			$ProductSearch	= ApiQuery('product_search.php', __LINE__,
								 "product_category_id=" . PRODUCT_ROOT_ID .
								 '&security_level=0' . 
								 '&page_no=' . 1 .
								 '&objects_per_page=' . 0 . 
								 '&lang_id=' . $args['lang_id'] . 
								 '&include_sub_category=Y' .
								 '&product_custom_int_1=' . $i . 
								 '&return_value_list_of_product_custom_text_1=Y' .
								 '&return_value_list_of_product_custom_text_2=Y' .
								 '&return_value_list_of_product_custom_text_3=Y' .
								 '&return_value_list_of_product_custom_text_4=Y' .
								 '&return_value_list_of_product_custom_text_5=Y' .
								 '&return_value_list_of_product_custom_text_6=Y' .
								 '&return_product_category_list=Y' .							//total_no_of_products
								 '&return_value_list_of_product_custom_int_2=Y' .
								 '&return_value_list_of_product_custom_int_3=Y' .
								 '&return_value_list_of_product_custom_int_4=Y' .
								 '&return_value_list_of_product_custom_int_5=Y' .
								 '&return_value_list_of_product_custom_int_6=Y' .
								 '&return_value_list_of_product_custom_int_7=Y' .
								 '&return_value_list_of_product_custom_int_8=Y' .
								 '&return_value_list_of_product_custom_int_10=Y' .
								 '&return_value_list_of_product_custom_int_11=Y',
								 false, false, null, false, false
								 );
			$ProductCount[$i] = GetSearchResultOfObjectQtyGroup($ProductSearch);
			
			$PriceSearch = ApiQuery('product_search.php', __LINE__,
								 'product_category_id=' . PRODUCT_ROOT_ID .
								 '&security_level=0' . 
								 '&page_no=1' .
								 '&objects_per_page=0' . 
								 '&lang_id=' . $args['lang_id'] . 
								 '&include_sub_category=Y' .
								 '&product_custom_int_1=' . $i . 
								 "&product_price=2000" .
								 "&product_price_operator=" . urlencode("<="),
								 false, false, null, false, false
								 );
			$ProductCount[$i]["product_price"][2000] = doubleval($PriceSearch->total_no_of_objects);
			
			$PriceSearch = ApiQuery('product_search.php', __LINE__,
								 'product_category_id=' . PRODUCT_ROOT_ID .
								 '&security_level=0' . 
								 '&page_no=1' .
								 '&objects_per_page=0' . 
								 '&lang_id=' . $args['lang_id'] . 
								 '&include_sub_category=Y' .
								 '&product_custom_int_1=' . $i . 
								 "&product_price=4000" .
								 "&product_price_operator=" . urlencode("<="),
								 false, false, null, false, false
								 );
			$ProductCount[$i]["product_price"][4000] = doubleval($PriceSearch->total_no_of_objects);
			
			$PriceSearch = ApiQuery('product_search.php', __LINE__,
								 'product_category_id=' . PRODUCT_ROOT_ID .
								 '&security_level=0' . 
								 '&page_no=1' .
								 '&objects_per_page=0' . 
								 '&lang_id=' . $args['lang_id'] . 
								 '&include_sub_category=Y' .
								 '&product_custom_int_1=' . $i . 
								 "&product_price=8000" .
								 "&product_price_operator=" . urlencode("<="),
								 false, false, null, false, false
								 );
			$ProductCount[$i]["product_price"][8000] = doubleval($PriceSearch->total_no_of_objects);
			
			$PriceSearch = ApiQuery('product_search.php', __LINE__,
								 'product_category_id=' . PRODUCT_ROOT_ID .
								 '&security_level=0' . 
								 '&page_no=1' .
								 '&objects_per_page=0' . 
								 '&lang_id=' . $args['lang_id'] . 
								 '&include_sub_category=Y' .
								 '&product_custom_int_1=' . $i . 
								 "&product_price=99999" .
								 "&product_price_operator=" . urlencode("<="),
								 false, false, null, false, false
								 );
			$ProductCount[$i]["product_price"][99999] = doubleval($PriceSearch->total_no_of_objects);			
		}		
		
		return json_encode($ProductCount, JSON_UNESCAPED_UNICODE);		
	}
	
	public function xmlCacheProductRootLinkInfo($args = array()) {
		require_once(BASEWEBDIR . "/common/constant.php");
		global $PRODUCT_ROOT_LINK_ID;
		$ProductCategory = ApiQuery('product_category_info.php', __LINE__,
								'link_id=' . $PRODUCT_ROOT_LINK_ID[intval($args['lang_id'])] .
								'&max_depth=' . 2 .
								'&page_no=1' . 
								'&products_per_page=0' . 
								'&security_level=0' .  
								'&lang_id=' . $args['lang_id'] . 
								'&currency_id=15' . 
								'&category_order_by=order_id' .
								'&category_order_type=ASC' .
								'&include_product_details=N' .
								'&include_product_brand_details=N',
								false, false, null, false, true
								);
		return $ProductCategory;
	}
	
	public function xmlCachePageGetInfo($args = array()) {
		$Page = ApiQuery('page_get_info.php', __LINE__, 'link_id=' . $args['link_id'],
					false, false, null, false, true
				);
		return $Page;
	}
	
	public function xmlCacheObjlinkGetPath($args = array()) {
		$ObjectLinkPath = ApiQuery('object_link_get_path.php', __LINE__, 'link_id=' . $args['link_id'],
					false, false, null, false, true				
				);
		return $ObjectLinkPath;
	}
	
	public function xmlCacheLayoutNewsPageGetInfoAll($args = array()) {
		$DateFrom = $args["year"] . "-01-01";
		$DateTo = $args["year"] . "-12-31";		
		
		$NewsList = ApiQuery('layout_news_page_get_info.php', __LINE__,
							 'link_id=' . $args['link_id'] . 
							 '&page_no=1' . 
							 '&layout_news_per_page=9999' . 
							 '&security_level=0' . 
							 '&include_layout_details=Y' .
							 '&date_search=Y' .
							 '&date_from=' . urlencode($DateFrom) . 
							 '&date_to=' . urlencode($DateTo),
							false, false, null, false, true				
							);
		return $NewsList;		
	}
	
	public function jsonCacheProductCatFatherCategoryName($args = array()) {
		require_once(BASEWEBDIR . "/common/constant.php");
		require_once(BASEWEBDIR . "/common/function.php");		
		global $PRODUCT_ROOT_LINK_ID;
		
		$CatNameArray = array();
		for ($langID = 1; $langID <= 2; $langID++) {
			$ProductCategory = ApiQuery('product_category_info.php', __LINE__,
										'link_id=' . $PRODUCT_ROOT_LINK_ID[1] .
										'&max_depth=' . 3 .
										'&page_no=1' . 
										'&products_per_page=0' . 
										'&security_level=0' .  
										'&lang_id=' . $langID . 
										'&currency_id=15' . 
										'&category_order_by=order_id' .
										'&category_order_type=ASC' .
										'&include_product_details=N' .
										'&include_product_brand_details=N',
										false, false, null, false, false
										);
			$CatNameArray[$langID] = array();
			
			foreach ($ProductCategory->product_category->product_categories->product_category as $FatherCat) {
				foreach ($FatherCat->product_categories->product_category as $SonCat) {
					$CatNameArray[$langID][intval($SonCat->object_id)] = strval($FatherCat->product_category_name);
				}
			}
		}
		
		return json_encode($CatNameArray, JSON_UNESCAPED_UNICODE);
	}
}