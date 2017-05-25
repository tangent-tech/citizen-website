<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_add", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_add');

$NoOfProducts = product::GetNoOfProduct($_SESSION['site_id']);
if ($NoOfProducts >= $Site['site_module_product_quota'])
	AdminDie(ADMIN_ERROR_PRODUCT_QUOTA_FULL, 'product_tree.php', __LINE__);

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] == $_SESSION['site_id'])
	$smarty->assign('ObjectLink', $ObjectLink);
//	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);

acl::ObjPermissionBarrier("add_children", $ObjectLink, __FILE__, false);
$smarty->assign('TheObject', $ObjectLink);

$ProductCat = product::GetProductCatInfo($ObjectLink['object_id'], 0);
$smarty->assign('ProductCat', $ProductCat);

foreach ($SiteLanguageRoots as $R) {
	$ProductCatData[$R['language_id']] = product::GetProductCatInfo($ProductCat['product_category_id'], $R['language_id']);
}
$smarty->assign('ProductCatData', $ProductCatData);

$Editor = array();
$EditorHTML = array();

foreach ($SiteLanguageRoots as $R) {
	$Editor[$R['language_id']]	= new FCKeditor('ContentEditor' . $R['language_id']);
	$Editor[$R['language_id']]->BasePath = FCK_BASEURL;
	$Editor[$R['language_id']]->Value	= '';
	$Editor[$R['language_id']]->Width	= '700';
	$Editor[$R['language_id']]->Height	= '400';
	$EditorHTML[$R['language_id']]	= $Editor[$R['language_id']]->Create();
	$smarty->assign('EditorHTML', $EditorHTML);
}

$TotalBrandNo = 0;
$ProductBrandList = product::GetAllBrandList($Site['site_id'], $site['site_default_language_id'], $TotalBrandNo, 1, 999999, '');
$smarty->assign('ProductBrandList', $ProductBrandList);

$ProductRoots = product::GetProductRootList($Site);
$smarty->assign('ProductRoots', $ProductRoots);

$ProductCatList = product::GetProductCatList($_SESSION['site_id'], 0);
$smarty->assign('ProductCatList', $ProductCatList);

$ProductCatSpecialList = product::GetProductCatSpecialList($_SESSION['site_id'], 0);
foreach ($ProductCatSpecialList as &$PCS)
	$PCS['is_product_below'] = $Product['is_special_cat_' . $PCS['product_category_special_no']];
$smarty->assign('ProductCatSpecialList', $ProductCatSpecialList);

$Colors = product::GetColorList(1, 'Y');
$smarty->assign('Colors', $Colors);

$Site = site::GetSiteInfo($_SESSION['site_id']);
$smarty->assign('Site', $Site);

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

$smarty->assign('TITLE', 'Add Product');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_add.tpl');