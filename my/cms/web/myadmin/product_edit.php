<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_edit');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);
$smarty->assign('TheObject', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);
acl::SetIsPublisherFlagForSmarty($ObjectLink);

$ProductRoots = product::GetProductRootList($Site);
$smarty->assign('ProductRoots', $ProductRoots);

$Product = product::GetProductInfo($ObjectLink['object_id'], 1);

if ($Product['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);
$Product['object_seo_url'] = object::GetSeoURL($Product, '', $Site['site_default_language_id'], $Site);
$smarty->assign('Product', $Product);
$smarty->assign('TheObject', $Product);

$ProductParentCatAndRootList = product::GetAllProductCategoriesOrProductRootsByObjectID($ObjectLink['object_id'], 0);
$smarty->assign('ProductParentCatAndRootList', $ProductParentCatAndRootList);

// Get Product Group here?????
$ProductCat = product::GetProductCatByProductLinkID($ObjectLink['object_link_id']);
$smarty->assign('ProductCat', $ProductCat);

foreach ($SiteLanguageRoots as $R) {
	$ProductCatData[$R['language_id']] = product::GetProductCatInfo($ProductCat['product_category_id'], $R['language_id']);
}
$smarty->assign('ProductCatData', $ProductCatData);

$TotalBrandNo = 0;
$ProductBrandList = product::GetAllBrandList($Site['site_id'], $Site['site_default_language_id'], $TotalBrandNo, 1, 999999, '');
$smarty->assign('ProductBrandList', $ProductBrandList);

$ProductPriceList = product::GetAllProductPriceList($ObjectLink['object_id'], $Site);
$smarty->assign('ProductPriceList', $ProductPriceList);

$ProductData = array();

$Editor = array();
$EditorHTML = array();

foreach ($SiteLanguageRoots as $R) {
//	product::TouchProductData($Product['product_id'], $R['language_id']);
	$ProductData[$R['language_id']] = product::GetProductInfo($ObjectLink['object_id'], $R['language_id']);
//	$ProductData[$R['language_id']]['product_tag'] = substr($ProductData[$R['language_id']]['product_tag'], 2, -2);
//	$ProductData[$R['language_id']]['product_option'] = substr($ProductData[$R['language_id']]['product_option'], 2, -2);
	$Editor[$R['language_id']]	= new FCKeditor('ContentEditor' . $R['language_id']);
	$Editor[$R['language_id']]->BasePath = FCK_BASEURL;
	$Editor[$R['language_id']]->Value	= $ProductData[$R['language_id']]['product_desc'];
	$Editor[$R['language_id']]->Width	= '700';
	$Editor[$R['language_id']]->Height	= '400';
	$EditorHTML[$R['language_id']]	= $Editor[$R['language_id']]->Create();
}
$smarty->assign('EditorHTML', $EditorHTML);
$smarty->assign('ProductData', $ProductData);

$ProductCatSpecialList = product::GetProductCatSpecialList($_SESSION['site_id'], 0);
foreach ($ProductCatSpecialList as &$PCS)
	$PCS['is_product_below'] = $Product['is_special_cat_' . $PCS['product_category_special_no']];
$smarty->assign('ProductCatSpecialList', $ProductCatSpecialList);

$ProductCatList = product::GetProductCatList($_SESSION['site_id'], 0);
$smarty->assign('ProductCatList', $ProductCatList);

$Colors = product::GetColorList(1, 'Y');
$smarty->assign('Colors', $Colors);

$ProductOptionList = product::GetProductOptionList($Product['product_id']);
$smarty->assign('ProductOptionList', $ProductOptionList);

$TotalMedia = 0;
$ProductMediaList = media::GetMediaList($Product['product_id'], 0, $TotalMedia, 1, 999999, 999999, false, false);
$smarty->assign('ProductMediaList', $ProductMediaList);

$TotalDatafile = 0;
$ProductDatafileList = datafile::GetDatafileList($Product['product_id'], 0, $TotalDatafile, 1, 999999);
$smarty->assign('ProductDatafileList', $ProductDatafileList);

$Site = site::GetSiteInfo($_SESSION['site_id']);
$smarty->assign('Site', $Site);

$IsProductRemovable = product::IsProductRemovable($ObjectLink['object_id']);
$smarty->assign('IsProductRemovable', $IsProductRemovable);

$ProductCustomFieldsDef = site::GetProductCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('ProductCustomFieldsDef', $ProductCustomFieldsDef);

$CustomFieldsEditor = array();
$CustomFieldsEditorHTML = array();
$CustomFieldsEditorInstance = ' ';

for ($i = 1; $i <= 20; $i++) {
	if ($ProductCustomFieldsDef['product_custom_text_' . $i] != '') {
		if (substr($ProductCustomFieldsDef['product_custom_text_' . $i], 0, 5) != 'STXT_' ||
			substr($ProductCustomFieldsDef['product_custom_text_' . $i], 0, 5) != 'MTXT_' ) {
			
			foreach ($SiteLanguageRoots as $R) {
				$CustomFieldsEditorInstance = $CustomFieldsEditorInstance . 'CustomFieldEditor' . $i . '_' . $R['language_id'] . " ";
				$CustomFieldsEditor[$R['language_id']][$i]	= new FCKeditor('CustomFieldEditor' . $i . '_' . $R['language_id']);
				$CustomFieldsEditor[$R['language_id']][$i]->BasePath = FCK_BASEURL;
				$CustomFieldsEditor[$R['language_id']][$i]->Value	= $ProductData[$R['language_id']]['product_custom_text_' . $i];
				$CustomFieldsEditor[$R['language_id']][$i]->Width	= '700';
				$CustomFieldsEditor[$R['language_id']][$i]->Height	= '400';
				$CustomFieldsEditorHTML[$R['language_id']][$i]	= $CustomFieldsEditor[$R['language_id']][$i]->Create();			
			}			
		}		
	}
}
$smarty->assign('CustomFieldsEditorInstance', substr($CustomFieldsEditorInstance, 1, -1));
$smarty->assign('CustomFieldsEditorHTML', $CustomFieldsEditorHTML);

$ProductFieldsShow = site::GetProductFieldsShow($_SESSION['site_id']);
$smarty->assign('ProductFieldsShow', $ProductFieldsShow);

$ProductCatFieldsShow = site::GetProductCatFieldsShow($_SESSION['site_id']);
$smarty->assign('ProductCatFieldsShow', $ProductCatFieldsShow);


$OrderList = cart::GetMyOrderListByProductID($Product['product_id'], $TotalOrders, 1,99999);
$smarty->assign('OrderList', $OrderList);

$smarty->assign('TITLE', 'Edit Product');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_edit.tpl');