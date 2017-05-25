<?php
if (!defined('IN_CMS'))
	die(realpath(__FILE__) . " " .  __LINE__);

$lang_id = intval($CurrentLang->language_root->language_id);


if($_SESSION['view'] == 'm'){

	$TopMenu = ApiQuery('folder_get_tree.php', __LINE__,
						'folder_id=' . TOP_MENU_FOLDER_ID .
						'&max_depth=' . 2 .
						'&security_level=' . $SessionUserSecurityLevel .
						'&expand_product_root=Y' .
						'&lang_id=' . $CurrentLang->language_root->language_id .
						'&get_obj_details_type_list=PAGE'
						);

	$smarty->assign('TopMenu', $TopMenu);

}

else {

//	CACHED!
//	$TopMenu = ApiQuery('folder_get_tree.php', __LINE__,
//						'folder_id=' . TOP_MENU_FOLDER_ID .
//						'&max_depth=' . 4 .
//						'&security_level=' . $SessionUserSecurityLevel .
//						'&expand_product_root=Y' .
//						'&lang_id=' . $CurrentLang->language_root->language_id
//						);
//	$smarty->assign('TopMenu', $TopMenu);
	$HeaderMainMenuRaw = $localCache->getCache('rawCacheDesktopMainMenu', array('lang_id' => $lang_id, 'currency_id' => intval($CurrentCurrency->currency->currency_id)), true);

	$smarty->assign('HeaderMainMenuRaw', $HeaderMainMenuRaw);
	
//	$FooterMenu = ApiQuery('folder_get_tree.php', __LINE__,
//							'folder_id=' . FOOTER_MENU_FOLDER_ID .
//							'&max_depth=' . 1 .
//							'&security_level=' . $SessionUserSecurityLevel .
//							'&expand_product_root=N' .
//							'&lang_id=' . $CurrentLang->language_root->language_id
//							);
	$FooterMenu = $localCache->getCache('xmlCacheFolderGetTreeMaxDepth1', array('lang_id' => $lang_id, 'folder_id' => $FOOTER_MENU_FOLDER_ID[$lang_id]), false);
	$smarty->assign('FooterMenu', $FooterMenu);
	
//	$FooterCategoryMenu = ApiQuery('folder_get_tree.php', __LINE__,
//							'folder_id=' . FOOTER_CATEGORY_FOLDE_ID .
//							'&max_depth=' . 1 .
//							'&security_level=' . $SessionUserSecurityLevel .
//							'&expand_product_root=N' .
//							'&lang_id=' . $CurrentLang->language_root->language_id
//							);
	$FooterCategoryMenu = $localCache->getCache('xmlCacheFolderGetTreeMaxDepth1', array('lang_id' => $lang_id, 'folder_id' => $FOOTER_CATEGORY_FOLDE_ID[$lang_id]), false);
	$smarty->assign('FooterCategoryMenu', $FooterCategoryMenu);

}

//$FooterOtherLink = ApiQuery('folder_get_tree.php', __LINE__,
//						'folder_id=' . FOOTER_OTHER_LINK_CATEGORY_FOLDE_ID .
//						'&max_depth=' . 1 .
//						'&security_level=' . $SessionUserSecurityLevel .
//						'&expand_product_root=N' .
//						'&lang_id=' . $CurrentLang->language_root->language_id
//						);
$FooterOtherLink = $localCache->getCache('xmlCacheFolderGetTreeMaxDepth1', array('lang_id' => $lang_id, 'folder_id' => $FOOTER_OTHER_LINK_CATEGORY_FOLDE_ID[$lang_id]), true);
$smarty->assign('FooterOtherLink', $FooterOtherLink);

//$RelatedBrand = ApiQuery('siteblock_get_info.php', __LINE__, 'block_def_id=' . RELATED_BRAND_SITE_BLOCK_ID . '&lang_id=' . SITE_BLOCK_FORCE_LANG_ID);
$RelatedBrand = $localCache->getCache('xmlCacheSiteBlockGetInfo', array('lang_id' => SITE_BLOCK_FORCE_LANG_ID, 'block_def_id' => RELATED_BRAND_SITE_BLOCK_ID), false);
$RelatedBrand = $RelatedBrand->xpath("/data/block_def/block_contents/block");
$smarty->assign('RelatedBrand', $RelatedBrand);

//$FooterSocialLink = ApiQuery('siteblock_get_info.php', __LINE__, 'block_def_id=' . FOOTER_SOCIAL_LINK_SITE_BLOCK_ID . '&lang_id=' . SITE_BLOCK_FORCE_LANG_ID);
$FooterSocialLink = $localCache->getCache('xmlCacheSiteBlockGetInfo', array('lang_id' => SITE_BLOCK_FORCE_LANG_ID, 'block_def_id' => FOOTER_SOCIAL_LINK_SITE_BLOCK_ID), true);
$FooterSocialLink = $FooterSocialLink->xpath("/data/block_def/block_contents/block");
$smarty->assign('FooterSocialLink', $FooterSocialLink);

/**
 * Language Switch (GET SITE All LANGUAGE)
 */
$LangIDList = array();
$LangSwitchURLList = array();

foreach($LanguageList->language_root_list->language_root as $L){
	array_push($LangIDList, intval($L->language_id));
}

if( intval($_REQUEST['id']) < 1 && intval($_REQUEST['link_id']) < 1 ){

	//FALSE
	$AdditionalPara = "";
	$Arg = array();
	$ExcludeArgFieldNameList = array('lang_id', '');
	$UriData = explode("&", trim($_SERVER['QUERY_STRING']));
	
	if(count($UriData) > 0){
		foreach ($UriData as $Var) {
			$Temp = explode("=", $Var);
			$Arg[$Temp[0]] = urldecode($Temp[1]);
		}
	}
	if(count($Arg) > 0){
		foreach ($Arg as $aKey => $aValue) {
			if (!in_array($aKey, $ExcludeArgFieldNameList))
				$AdditionalPara .= urlencode($aKey) . '=' . urlencode($aValue) . '&';
		}
	}
	
	if(strlen(trim($AdditionalPara)) > 0)
		$AdditionalPara = "?" . $AdditionalPara . "&";
	else
		$AdditionalPara = "?";

	foreach ($LangIDList as $L) {
		$LangSwitchURLList[$L] = $_SERVER['PHP_SELF'] . $AdditionalPara . "lang_id=" . $L;
	}

}

else if ($ObjectLink->object->object_type == 'PRODUCT_ROOT_LINK' || $ObjectLink->object->object_type == 'PRODUCT_ROOT') {
	
	//PRODUCT CATEGORY
//	$ProductRootObjectLinkEN = ApiQuery('object_link_get_info.php', __LINE__, 'link_id=' . PRODUCT_ROOT_LINK_ID_EN);
	$ProductRootObjectLinkEN = $localCache->getCache('xmlCacheObjectLinkGetInfo', array('link_id' => PRODUCT_ROOT_LINK_ID_EN), false);
	$LangSwitchURLList[1] = BASEURL . $ProductRootObjectLinkEN->object->object_seo_url . "?lang_id=" . 1;
	
//	$ProductRootObjectLinkTC = ApiQuery('object_link_get_info.php', __LINE__, 'link_id=' . PRODUCT_ROOT_LINK_ID_TC);
	$ProductRootObjectLinkTC = $localCache->getCache('xmlCacheObjectLinkGetInfo', array('link_id' => PRODUCT_ROOT_LINK_ID_TC), false);
	$LangSwitchURLList[2] = BASEURL . $ProductRootObjectLinkTC->object->object_seo_url . "?lang_id=" . 2;	
}

else if ($ObjectLink->object->object_type == 'PRODUCT_CATEGORY') {
	
	//PRODUCT CATEGORY
	foreach ($LangIDList as $L) {
		
		$ProductSEOInfo = ApiQuery('product_category_info.php', __LINE__,
									'link_id=' . $ObjectLink->object->object_link_id .
									'&page_no=' . 0 .
									'&products_per_page=' . 0 .
									'&security_level=' . 0 .
									'&lang_id=' . $L
									);
	
		$LangSwitchURLList[$L] = BASEURL . $ProductSEOInfo->product_category->object_seo_url . "?lang_id=" . $L;
		
	}
	
}

else if ($ObjectLink->object->object_type == 'PRODUCT') {
	
	//PRODUCT	
	foreach ($LangIDList as $L) {
		
		$ProductSeo = ApiQuery('product_get_info.php', __LINE__,
							'link_id=' . $ObjectLink->object->object_link_id .
							'&lang_id=' . $L
							);
		$LangSwitchURLList[$L] = BASEURL . $ProductSeo->product->object_seo_url . "?lang_id=" . $L;

	}
	
}

else {

	//PAGE & LAYOUT NEWS PAGE
	$LangSwitchObjectList = ApiQuery('object_get_language_switch_list.php', __LINE__, 'object_id=' . $ObjectLink->object->object_id);

	if(count($LangSwitchObjectList->lang_switch_object_list->object) > 0){

		foreach ($LangSwitchObjectList->lang_switch_object_list->object as $L) {
			$LangSwitchURLList[intval($L->language_id)] = BASEURL . $L->object_seo_url . "?lang_id=" . $L->language_id;
		}
		
	}
	
	else{
		
		foreach ($LangIDList as $L) {
			if(intval($L) == intval($CurrentLang->language_root->language_id)){
				
				if(intval($_REQUEST['link_id']) > 0)
					$LangSwitchURLList[$L] = BASEURL . $ObjectLink->object->object_seo_url;
				else
					$LangSwitchURLList[$L] = BASEURL . '/index.php?lang_id=' . $L;
				
			}
			else{
				$LangSwitchURLList[$L] = BASEURL . '/index.php?lang_id=' . $L;
			}
		}
		
	}

}

$smarty->assign('LangSwitchURLList', $LangSwitchURLList);
?>