<?php
if (!defined('IN_CMS'))
	die(realpath(__FILE__) . " " .  __LINE__);

require_once('content_common.php');

$ObjectLinkPath = ApiQuery('object_link_get_path.php', __LINE__, 'link_id=' . $ObjectLink->object->object_link_id);
$smarty->assign('ObjectLinkPath', $ObjectLinkPath);

$ProductCategory = ApiQuery('product_category_info.php', __LINE__,
							'link_id=' . $ObjectLink->object->object_link_id .
							'&page_no=' . 1 .
							'&products_per_page=' . 0 .
							'&security_level=' . $SessionUserSecurityLevel . 
							'&lang_id=' . $CurrentLang->language_root->language_id .
							'&currency_id=' . $CurrentCurrency->currency->currency_id .
							'&category_order_by=order_id' .
							'&category_order_type=ASC' .
							'&include_media_details=Y' .
							'&media_page_no=' . 1 .
							'&media_per_page=' . 1
							);
$smarty->assign('ProductCategory', $ProductCategory);

//Siteblock
$CatalogImage = ApiQuery('siteblock_get_info.php', __LINE__, 'block_def_id=' . PRODUCT_ROOT_CATALOG_IMAGE_SITE_BLOCK_ID . '&lang_id=' . SITE_BLOCK_FORCE_LANG_ID);
$CatalogImage = $CatalogImage->xpath("/data/block_def/block_contents/block");
$smarty->assign('CatalogImage', $CatalogImage[0]);

$CatalogPdfLink = ApiQuery('siteblock_get_info.php', __LINE__, 'block_def_id=' . PRODUCT_ROOT_CATALOG_PDF_LINK_SITE_BLOCK_ID . '&lang_id=' . SITE_BLOCK_FORCE_LANG_ID);
$CatalogPdfLink = $CatalogPdfLink->xpath("/data/block_def/block_contents/block");
$smarty->assign('CatalogPdfLink', $CatalogPdfLink[0]);

$smarty->assign('MyJS', 'ProductRoot');
$smarty->assign('PageTitle', '');

require_once('footer.php');

$smarty->display($CurrentLang->language_root->language_id . '/product_root.tpl');
?>