<?php
if (!defined('IN_CMS'))
	die(realpath(__FILE__) . " " .  __LINE__);

require_once('content_common.php');

$localCache = customLocalCache::Singleton();
$Page = $localCache->getCache('xmlCachePageGetInfo', array('link_id' => intval($ObjectLink->object->object_link_id)), false);
$smarty->assign('Page', $Page);

$Layout = $Page->xpath("/data/page/layout");

if ($Page->page->page_title != '')
	$smarty->assign('PageTitle', $Page->page->page_title);
else
	$smarty->assign('PageTitle', $Page->page->object_name);

$ObjectLinkPath = $localCache->getCache('xmlCacheObjlinkGetPath', array('link_id' => intval($ObjectLink->object->object_link_id)), false);
$smarty->assign('ObjectLinkPath', $ObjectLinkPath);

require_once('footer.php');

$smarty->assign('MyJS', $Layout[0]->layout_name);

if ($Layout[0]->layout_name == 'Index') {

	if($_SESSION['view'] == 'm'){
		
		//Mobile Ver
		$WatchLineup = ApiQuery('product_category_info.php', __LINE__,
								'link_id=' . PRODUCT_ROOT_LINK_ID .
								'&page_no=' . 1 .
								'&products_per_page=' . 0 .
								'&security_level=' . $SessionUserSecurityLevel . 
								'&lang_id=' . $CurrentLang->language_root->language_id .
								'&currency_id=' . $CurrentCurrency->currency->currency_id .
								'&category_order_by=order_id' .
								'&category_order_type=ASC'
								);
		$smarty->assign('WatchLineup', $WatchLineup);
		
	}
	
	else {

		$HomePageLineup = ApiQuery('layout_news_page_get_info.php', __LINE__,
									'link_id=' . HOME_PAGE_LINEUP_LAYOUT_NEWS_ROOT_LINK_ID . 
									'&page_no=' . 1 .
									'&layout_news_per_page=' . HOME_PAGE_LINEUP_PER_PAGE .
									'&security_level=' . $SessionUserSecurityLevel . 
									'&include_layout_details=Y'
									);
		$smarty->assign('HomePageLineup', $HomePageLineup);
	
	}
	
	/*
	$ImportantNotices = ApiQuery('layout_news_page_get_info.php', __LINE__,
								 'link_id=' . IMPORTANT_NOTICES_LAYOUT_NEWS_ROOT_LINK_ID . 
								 '&page_no=' . 1 .
								 '&layout_news_per_page=' . HOME_PAGE_IMPORTANT_NOTICES_PER_PAGE .
								 '&security_level=' . $SessionUserSecurityLevel . 
								 '&include_layout_details=N'
								 );
	$smarty->assign('ImportantNotices', $ImportantNotices);
	 */
	
	$LayoutNewsList = ApiQuery('layout_news_page_get_info.php', __LINE__,
								 'link_id=' . LAYOUT_NEWS_ROOT_LINK_ID . 
								 '&page_no=' . 1 .
								 '&layout_news_per_page=' . HOME_PAGE_LAYOUT_NEWS_PER_PAGE .
								 '&security_level=' . $SessionUserSecurityLevel . 
								 '&include_layout_details=Y'
								 );
	$smarty->assign('LayoutNewsList', $LayoutNewsList);
	
	$Slider = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='Slider']/block_contents/block");
	$smarty->assign('Slider', $Slider);

	$AboutCITIZEN = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='AboutCITIZEN']/block_contents/block");
	$smarty->assign('AboutCITIZEN', $AboutCITIZEN[0]);
	
	$Youtube01 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='Youtube01']/block_contents/block");
	$smarty->assign('Youtube01', $Youtube01[0]);
	
	$Youtube02 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='Youtube02']/block_contents/block");
	$smarty->assign('Youtube02', $Youtube02[0]);
	
	$TechnologImage = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='TechnologImage']/block_contents/block");
	$smarty->assign('TechnologImage', $TechnologImage);
	
	$PickupLeftYoutudeID = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='PickupLeftYoutudeID']/block_contents/block");
	$smarty->assign('PickupLeftYoutudeID', $PickupLeftYoutudeID[0]);
	
	$PickupRightYoutudeID = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='PickupRightYoutudeID']/block_contents/block");
	$smarty->assign('PickupRightYoutudeID', $PickupRightYoutudeID[0]);
	
	$PickupLinkLine1 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='PickupLinkLine1']/block_contents/block");
	$smarty->assign('PickupLinkLine1', $PickupLinkLine1);
	
	$PickupLinkLine2 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='PickupLinkLine2']/block_contents/block");
	$smarty->assign('PickupLinkLine2', $PickupLinkLine2);
	
	$TechnologiesBlockName = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='TechnologiesBlockName']/block_contents/block");
	$smarty->assign('TechnologiesBlockName', $TechnologiesBlockName);
	
	$TechnologiesBlockContent = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='TechnologiesBlockContent']/block_contents/block");
	$smarty->assign('TechnologiesBlockContent', $TechnologiesBlockContent[0]);
	
	$ServiceAndSupport_Left = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='ServiceAndSupport_Left']/block_contents/block");
	$smarty->assign('ServiceAndSupport_Left', $ServiceAndSupport_Left[0]);
	
	$ServiceAndSupport_Left_Link = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='ServiceAndSupport_Left_Link']/block_contents/block");
	$smarty->assign('ServiceAndSupport_Left_Link', $ServiceAndSupport_Left_Link[0]);
	
	$ServiceAndSupport_Right = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='ServiceAndSupport_Right']/block_contents/block");
	$smarty->assign('ServiceAndSupport_Right', $ServiceAndSupport_Right[0]);
	
	$ServiceAndSupport_Right_Link = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='ServiceAndSupport_Right_Link']/block_contents/block");
	$smarty->assign('ServiceAndSupport_Right_Link', $ServiceAndSupport_Right_Link[0]);
	
	//Mobile Ver
	$MobileSlider = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='MobileSlider']/block_contents/block");
	$smarty->assign('MobileSlider', $MobileSlider);
	
	$MobilePickupLink = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='MobilePickupLink']/block_contents/block");
	$smarty->assign('MobilePickupLink', $MobilePickupLink);
	
	$MobileServiceAndSupport_Left = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='MobileServiceAndSupport_Left']/block_contents/block");
	$smarty->assign('MobileServiceAndSupport_Left', $MobileServiceAndSupport_Left[0]);
	
	$MobileServiceAndSupport_Right = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='MobileServiceAndSupport_Right']/block_contents/block");
	$smarty->assign('MobileServiceAndSupport_Right', $MobileServiceAndSupport_Right[0]);

	$smarty->display($CurrentLang->language_root->language_id . '/index.tpl');
}

else if ($Layout[0]->layout_name == 'Philosophy') {
	
	$KeyVisual = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='KeyVisual']/block_contents/block");
	$smarty->assign('KeyVisual', $KeyVisual[0]);
	
	$MissionContent01 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='MissionContent01']/block_contents/block");
	$smarty->assign('MissionContent01', $MissionContent01[0]);
	
	$MissionContent02 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='MissionContent02']/block_contents/block");
	$smarty->assign('MissionContent02', $MissionContent02[0]);
	
	$MissionContent03 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='MissionContent03']/block_contents/block");
	$smarty->assign('MissionContent03', $MissionContent03[0]);

	$MiddleContent01 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='MiddleContent01']/block_contents/block");
	$smarty->assign('MiddleContent01', $MiddleContent01[0]);
	
	$MiddleContent02 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='MiddleContent02']/block_contents/block");
	$smarty->assign('MiddleContent02', $MiddleContent02[0]);
	
	$Youtube = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='Youtube']/block_contents/block");
	$smarty->assign('Youtube', $Youtube[0]);
	
	$AboutCitizen01 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='AboutCitizen01']/block_contents/block");
	$smarty->assign('AboutCitizen01', $AboutCitizen01[0]);
	
	$AboutCitizen02 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='AboutCitizen02']/block_contents/block");
	$smarty->assign('AboutCitizen02', $AboutCitizen02[0]);
	
	$PickupLinkLine1 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='PickupLinkLine1']/block_contents/block");
	$smarty->assign('PickupLinkLine1', $PickupLinkLine1);
	
	$PickupLinkLine2 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='PickupLinkLine2']/block_contents/block");
	$smarty->assign('PickupLinkLine2', $PickupLinkLine2);
	
	$PickupLinkLine3 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='PickupLinkLine3']/block_contents/block");
	$smarty->assign('PickupLinkLine3', $PickupLinkLine3);
	
	//Mobile Ver
	$MobileKeyVisual = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='MobileKeyVisual']/block_contents/block");
	$smarty->assign('MobileKeyVisual', $MobileKeyVisual[0]);
	
	$MobilePickupLinkLine2 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='MobilePickupLinkLine2']/block_contents/block");
	$smarty->assign('MobilePickupLinkLine2', $MobilePickupLinkLine2);
	
	$smarty->display($CurrentLang->language_root->language_id . '/philosophy.tpl');
}

else if ($Layout[0]->layout_name == 'Technology') {
	
	die();
	
	$KeyContent = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='KeyContent']/block_contents/block");
	$smarty->assign('KeyContent', $KeyContent[0]);
	
	$TechnologyBlock01 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='TechnologyBlock01']/block_contents/block");
	$smarty->assign('TechnologyBlock01', $TechnologyBlock01[0]);
	
	$TechnologyBlock02 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='TechnologyBlock02']/block_contents/block");
	$smarty->assign('TechnologyBlock02', $TechnologyBlock02[0]);
	
	$TechnologyBlock03 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='TechnologyBlock03']/block_contents/block");
	$smarty->assign('TechnologyBlock03', $TechnologyBlock03[0]);

	$TechnologyBlock04 = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='TechnologyBlock04']/block_contents/block");
	$smarty->assign('TechnologyBlock04', $TechnologyBlock04[0]);

	$smarty->display($CurrentLang->language_root->language_id . '/technology.tpl');
}

else if ($Layout[0]->layout_name == 'WatchSearch') {

	$Brand = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='Brand']/block_contents/block");
	$smarty->assign('Brand', $Brand);
	
	$ProductRootLink = $localCache->getCache('xmlCacheProductRootLinkInfo', array('lang_id' => intval($CurrentLang->language_root->language_id)));
	$smarty->assign('ProductRootLink', $ProductRootLink);
	
	//Init Product Search Page
	$_REQUEST["product_custom_int_1"] = 1;

	$Products = ApiQuery('product_search.php', __LINE__,
							'product_category_id=' . PRODUCT_ROOT_ID .
							'&security_level=' . $SessionUserSecurityLevel .
							'&page_no=' . 1 .
							'&objects_per_page=' . PRODUCT_SEARCH_PER_PAGE . 
							'&lang_id=' . $CurrentLang->language_root->language_id .
							'&include_sub_category=Y' .
							"&product_custom_int_1=" . $_REQUEST["product_custom_int_1"] .
							"&order_by_object_link_order_id=asc" .
							'&return_product_category_list=Y'					//total no of products of search result
						 );
	$smarty->assign("Products", $Products);
	
	$TotalPageNo = ceil( $Products->total_no_of_objects / PRODUCT_SEARCH_PER_PAGE);
	$smarty->assign('TotalPageNo', $TotalPageNo);

	$SearchValueQTY = $localCache->getCache('jsonCacheProductSearchFirstLevelData', array('lang_id' => intval($CurrentLang->language_root->language_id)), true);
	$SearchValueQTY = $SearchValueQTY[intval($_REQUEST["product_custom_int_1"])];

	//Product Category Handle
	$SearchValueQTY = ProductSearchCategoryResultQTY($Products->product_category_list->product_category, $SearchValueQTY);
	
	$smarty->assign("SearchValueQTY", $SearchValueQTY);

	
	$smarty->display($CurrentLang->language_root->language_id . '/watch_search.tpl');
}

else if ($Layout[0]->layout_name == 'Support') {
	
	die();
	
	$smarty->display($CurrentLang->language_root->language_id . '/support.tpl');
}

else if ($Layout[0]->layout_name == 'ProductCategory') {
	
	$ProductCategoryLinkID = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='ProductCategoryLinkID']/block_contents/block");

	if(intval($ProductCategoryLinkID[0]->block_content) > 0){
		
		$ObjectSeo = GetSeoUrl(intval($ProductCategoryLinkID[0]->block_content));

		header("Location:" . BASEURL . $ObjectSeo);
		die();
		
	}

}

else if ($Layout[0]->layout_name == "StoreLocation") {
	
	if(intval($_REQUEST["area_parent_id"]) > 0){
		$SearchAreaList = store_location::GetDistrictList($_REQUEST["area_parent_id"]);
		$smarty->assign('SearchAreaList', $SearchAreaList);
	}

	$IsBroadwayOnly = false;
	if ($_REQUEST['broadway_only'] == 'Y')
		$IsBroadwayOnly = true;
	
	$StoreLocationList = store_location::GetAreaListGroupByAreaParentID( $_REQUEST["area_parent_id"], $_REQUEST["area_list_id"], $_REQUEST["search_text"], $IsBroadwayOnly);
	$smarty->assign('StoreLocationList', $StoreLocationList);
	
	$Content = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='Content']/block_contents/block");
	$smarty->assign('Content', $Content[0]);
	
	$smarty->display($CurrentLang->language_root->language_id . '/store_location.tpl');
}

else if ($Layout[0]->layout_name  == "WarrantyRegistration") {

	require_once('warranty_part1.php');
	
	$Content = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='Content']/block_contents/block");
	$smarty->assign('Content', $Content[0]);
	
	$smarty->display($CurrentLang->language_root->language_id . '/warranty_registration.tpl');
}

else if ($Layout[0]->layout_name  == "Article") {
	
	$Content = $Page->xpath("/data/page/layout/block_defs/block_def[block_def_name='Content']/block_contents/block");
	$smarty->assign('Content', $Content[0]);
	
	$smarty->display($CurrentLang->language_root->language_id . '/article.tpl');
}

else if ($Layout[0]->layout_name  == "Sitemap") {
	
	$TopMenu = ApiQuery('folder_get_tree.php', __LINE__,
						'folder_id=' . TOP_MENU_FOLDER_ID .
						'&max_depth=' . 4 .
						'&security_level=' . $SessionUserSecurityLevel .
						'&expand_product_root=Y' .
						'&lang_id=' . $CurrentLang->language_root->language_id .
						'&get_obj_details_type_list=PAGE'
						);
	$smarty->assign('TopMenu', $TopMenu);
	
	$smarty->display($CurrentLang->language_root->language_id . '/sitemap.tpl');
}
