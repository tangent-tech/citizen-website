<?php
define("IN_CMS", true);
require_once(__DIR__ . '/common/config.php');
require_once(__DIR__ . '/common/constant.php');
require_once(__DIR__ . '/class/customLocalCache.class.php');
// Clean up smarty cache
$SmartyCacheDir = array(
	BASEDIR . 'htmlsafe/template_mobile_c/',
	BASEDIR . 'htmlsafe/template_c/'
);
foreach ($SmartyCacheDir as $D) {
	if ($handle = opendir($D)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				unlink($D . "/" . $entry);
			}
		}
		closedir($handle);
	}	
}
$localCache = customLocalCache::Singleton();
$localCache->cleanUpCacheDir();
/* @var $localCache customLocalCache */
$localCache->addCache('xmlCacheSiteInfo', array());
$localCache->addCache('xmlCacheAllSiteCurrency', array());
$localCache->addCache('xmlCacheLanguageRootList', array());
$localCache->addCache('jsonCacheProductCatFatherCategoryName', array());
$localCache->addCache('rawCacheDesktopMainMenu', array('lang_id' => 1, 'currency_id' => 2));
$localCache->addCache('rawCacheDesktopMainMenu', array('lang_id' => 2, 'currency_id' => 2));
$localCache->addCache('xmlCacheFolderGetTreeMaxDepth1', array('lang_id' => 1, 'folder_id' => $FOOTER_MENU_FOLDER_ID[1]));
$localCache->addCache('xmlCacheFolderGetTreeMaxDepth1', array('lang_id' => 2, 'folder_id' => $FOOTER_MENU_FOLDER_ID[2]));
$localCache->addCache('xmlCacheFolderGetTreeMaxDepth1', array('lang_id' => 1, 'folder_id' => $FOOTER_CATEGORY_FOLDE_ID[1]));
$localCache->addCache('xmlCacheFolderGetTreeMaxDepth1', array('lang_id' => 2, 'folder_id' => $FOOTER_CATEGORY_FOLDE_ID[2]));
$localCache->addCache('xmlCacheFolderGetTreeMaxDepth1', array('lang_id' => 1, 'folder_id' => $FOOTER_OTHER_LINK_CATEGORY_FOLDE_ID[1]));
$localCache->addCache('xmlCacheFolderGetTreeMaxDepth1', array('lang_id' => 2, 'folder_id' => $FOOTER_OTHER_LINK_CATEGORY_FOLDE_ID[2]));
$localCache->addCache('xmlCacheSiteBlockGetInfo', array('lang_id' => SITE_BLOCK_FORCE_LANG_ID, 'block_def_id' => RELATED_BRAND_SITE_BLOCK_ID));
$localCache->addCache('xmlCacheSiteBlockGetInfo', array('lang_id' => SITE_BLOCK_FORCE_LANG_ID, 'block_def_id' => FOOTER_SOCIAL_LINK_SITE_BLOCK_ID));
$localCache->addCache('xmlCacheProductRootLinkInfo', array('lang_id' => 1));
$localCache->addCache('xmlCacheProductRootLinkInfo', array('lang_id' => 2));

$ProductCategory = ApiQuery('product_category_info.php', __LINE__,
							'link_id=' . $PRODUCT_ROOT_LINK_ID[1] .
							'&max_depth=' . 2 .
							'&page_no=1' . 
							'&products_per_page=0' . 
							'&security_level=0' .  
							'&lang_id=1' . 
							'&currency_id=2' . 
							'&category_order_by=order_id' .
							'&category_order_type=ASC' .
							'&include_product_details=N' .
							'&include_product_brand_details=N',
							false, false, null, false, false
							);
foreach($ProductCategory->product_category->product_categories->product_category as $PC) {
	$localCache->addCache('rawCacheProductCatPageMainContent', array('object_link_id' => intval($PC->object_link_id), 'lang_id' => 1, 'currency_id' => 2, 'view' => 'd'));
	$localCache->addCache('rawCacheProductCatPageMainContent', array('object_link_id' => intval($PC->object_link_id), 'lang_id' => 2, 'currency_id' => 2, 'view' => 'd'));
	$localCache->addCache('rawCacheProductCatPageMainContent', array('object_link_id' => intval($PC->object_link_id), 'lang_id' => 1, 'currency_id' => 2, 'view' => 'm'));
	$localCache->addCache('rawCacheProductCatPageMainContent', array('object_link_id' => intval($PC->object_link_id), 'lang_id' => 2, 'currency_id' => 2, 'view' => 'm'));
}

$localCache->addCache('jsonCacheProductSearchFirstLevelData', array('lang_id' => 1));
$localCache->addCache('jsonCacheProductSearchFirstLevelData', array('lang_id' => 2));

$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[1], 'year' => '2007'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[1], 'year' => '2008'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[1], 'year' => '2009'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[1], 'year' => '2010'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[1], 'year' => '2011'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[1], 'year' => '2012'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[1], 'year' => '2013'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[1], 'year' => '2014'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[1], 'year' => '2015'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[1], 'year' => '2016'));

$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[2], 'year' => '2007'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[2], 'year' => '2008'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[2], 'year' => '2009'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[2], 'year' => '2010'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[2], 'year' => '2011'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[2], 'year' => '2012'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[2], 'year' => '2013'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[2], 'year' => '2014'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[2], 'year' => '2015'));
$localCache->addCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => $NEWS_LAYOUT_NEWS_ROOT_ID[2], 'year' => '2016'));

$localCache->updateAllCache();