<?php
if (!defined('IN_CMS'))
	die(realpath(__FILE__) . " " .  __LINE__);

require_once('content_common.php');

$Product = ApiQuery('product_get_info.php', __LINE__,
					'link_id=' . $ObjectLink->object->object_link_id .
					'&lang_id=' . $CurrentLang->language_root->language_id .
					'&currency_id=' . $CurrentCurrency->currency->currency_id
					);
$smarty->assign('Product', $Product);

// die(var_dump($Product));
$ProductMedia = $Product->xpath("/data/product/media_list/media");
$smarty->assign('ProductMedia', $ProductMedia);

if(intval($Product->product->product_brand_id) > 0){
	
	$BrandFriendList = ApiQuery('product_brand_get_product_list.php', __LINE__,
								'product_brand_id=' . $Product->product->product_brand_id .
								'&product_category_id=' . 0 .
								'&products_per_page=' . 99 .
								'&security_level=' . $SessionUserSecurityLevel . 
								'&lang_id=' . $CurrentLang->language_root->language_id .
								'&currency_id=' . $CurrentCurrency->currency->currency_id
								);
	$smarty->assign('BrandFriendList', $BrandFriendList);
}

$ProductRootLink = ApiQuery('product_category_info.php', __LINE__,
							'link_id=' . PRODUCT_ROOT_LINK_ID .
							'&page_no=' . 1 .
							'&products_per_page=' . 0 .
							'&security_level=' . $SessionUserSecurityLevel . 
							'&lang_id=' . $CurrentLang->language_root->language_id .
							'&currency_id=' . $CurrentCurrency->currency->currency_id
							);
$smarty->assign('ProductRootLink', $ProductRootLink);

$ProductCatPath = ApiQuery('product_get_category_path.php', __LINE__,
							'link_id=' . $ObjectLink->object->object_link_id .
							'&lang_id=' . $CurrentLang->language_root->language_id
							);
$smarty->assign('ProductCatPath', $ProductCatPath);

//For Product page brand logo
$ProductCategory = ApiQuery('product_category_info.php', __LINE__,
						'link_id=' . $ProductCatPath->product_categories->product_category[0]->object_link_id .
						'&max_depth=' . 1 .
						'&page_no=' . 1 .
						'&products_per_page=' . 0 .
						'&security_level=' . $SessionUserSecurityLevel . 
						'&lang_id=' . $CurrentLang->language_root->language_id .
						'&currency_id=' . $CurrentCurrency->currency->currency_id .
						'&include_media_details=Y' .
						'&media_page_no=' . 1 .
						'&media_per_page=' . 4
						);
$smarty->assign('ProductCategory', $ProductCategory);

//$BrandLogo = $ProductCategory->product_category->media_list->media[PRODUCT_CATEGORY_BRAND_LOGO_MEDIA_INDEX];
//$smarty->assign('BrandLogo', $BrandLogo);

$smarty->assign('MyJS', 'Product');
$smarty->assign('PageTitle', $Product->product->product_code);

require_once('footer.php');

$smarty->display($CurrentLang->language_root->language_id . '/product.tpl');
?>