<?php
if (!defined('IN_CMS'))
	die(realpath(__FILE__) . " " .  __LINE__);

require_once('content_common.php');

$localCache = customLocalCache::Singleton();

//$ProductRootLink = ApiQuery('product_category_info.php', __LINE__,
//							'link_id=' . PRODUCT_ROOT_LINK_ID .
//							'&page_no=' . 1 .
//							'&products_per_page=' . 0 .
//							'&security_level=' . $SessionUserSecurityLevel . 
//							'&lang_id=' . $CurrentLang->language_root->language_id .
//							'&currency_id=' . $CurrentCurrency->currency->currency_id
//							);
$ProductRootLink = $localCache->getCache('xmlCacheProductCategoryInfoBasic', array('lang_id' => intval($CurrentLang->language_root->language_id), 'link_id' => PRODUCT_ROOT_LINK_ID, 'currency_id' => intval($CurrentCurrency->currency->currency_id)));
$smarty->assign('ProductRootLink', $ProductRootLink);

$ProductCategory = $localCache->getCache('xmlCacheProductCategoryInfoBasic', array('lang_id' => intval($CurrentLang->language_root->language_id), 'link_id' => intval($ObjectLink->object->object_link_id), 'currency_id' => intval($CurrentCurrency->currency->currency_id)));
$smarty->assign('ProductCategory', $ProductCategory);

$ProductCategoryCacheRaw = $localCache->getCache('rawCacheProductCatPageMainContent', array('object_link_id' => intval($ObjectLink->object->object_link_id), 'lang_id' => intval($CurrentLang->language_root->language_id), 'currency_id' => intval($CurrentCurrency->currency->currency_id), 'view' => $_SESSION['view']), true);
$smarty->assign('ProductCategoryCacheRaw', $ProductCategoryCacheRaw);

$smarty->assign('MyJS', 'ProductCategory');
$smarty->assign('PageTitle', $ProductCategory->product_category->product_category_name);
$smarty->display($CurrentLang->language_root->language_id . '/product_category.tpl');

//Subcategory Category Level
if($ProductCategory->product_category->parent_object_id != PRODUCT_ROOT_ID) {
	$ObjectSeo = GetSeoUrl(PRODUCT_ROOT_LINK_ID);
	header("Location:" . BASEURL . $ObjectSeo);
}