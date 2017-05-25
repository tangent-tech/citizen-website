<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_brand_manage", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_brand_edit');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

$ProductBrand = product::GetProductBrandInfo($ObjectLink['object_id'], 0);
if ($ProductBrand['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_brand_list.php', __LINE__);
$ProductBrand['object_seo_url'] = object::GetSeoURL($ProductBrand, '', $Site['site_default_language_id'], $Site);
$smarty->assign('ProductBrand', $ProductBrand);
$smarty->assign('TheObject', $ProductBrand);

$ProductBrandData = array();

$Editor = array();
$EditorHTML = array();

foreach ($SiteLanguageRoots as $R) {
//	product::TouchProductData($Product['product_id'], $R['language_id']);
	$ProductBrandData[$R['language_id']] = product::GetProductBrandInfo($ObjectLink['object_id'], $R['language_id']);
//	$ProductData[$R['language_id']]['product_tag'] = substr($ProductData[$R['language_id']]['product_tag'], 2, -2);
//	$ProductData[$R['language_id']]['product_option'] = substr($ProductData[$R['language_id']]['product_option'], 2, -2);
	$Editor[$R['language_id']]	= new FCKeditor('ContentEditor' . $R['language_id']);
	$Editor[$R['language_id']]->BasePath = FCK_BASEURL;
	$Editor[$R['language_id']]->Value	= $ProductBrandData[$R['language_id']]['product_brand_desc'];
	$Editor[$R['language_id']]->Width	= '700';
	$Editor[$R['language_id']]->Height	= '400';
	$EditorHTML[$R['language_id']]	= $Editor[$R['language_id']]->Create();
}
$smarty->assign('EditorHTML', $EditorHTML);
$smarty->assign('ProductBrandData', $ProductBrandData);

$ProductBrandCustomFieldsDef = site::GetProductBrandCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('ProductBrandCustomFieldsDef', $ProductBrandCustomFieldsDef);

$CustomFieldsEditor = array();
$CustomFieldsEditorHTML = array();
$CustomFieldsEditorInstance = ' ';

for ($i = 1; $i <= 20; $i++) {
	if ($ProductBrandCustomFieldsDef['product_brand_custom_text_' . $i] != '') {
		if (substr($ProductBrandCustomFieldsDef['product_brand_custom_text_' . $i], 0, 5) != 'STXT_' ||
			substr($ProductBrandCustomFieldsDef['product_brand_custom_text_' . $i], 0, 5) != 'MTXT_' ) {
			
			foreach ($SiteLanguageRoots as $R) {
				$CustomFieldsEditorInstance = $CustomFieldsEditorInstance . 'CustomFieldEditor' . $i . '_' . $R['language_id'] . " ";
				$CustomFieldsEditor[$R['language_id']][$i]	= new FCKeditor('CustomFieldEditor' . $i . '_' . $R['language_id']);
				$CustomFieldsEditor[$R['language_id']][$i]->BasePath = FCK_BASEURL;
				$CustomFieldsEditor[$R['language_id']][$i]->Value	= $ProductBrandData[$R['language_id']]['product_brand_custom_text_' . $i];
				$CustomFieldsEditor[$R['language_id']][$i]->Width	= '700';
				$CustomFieldsEditor[$R['language_id']][$i]->Height	= '400';
				$CustomFieldsEditorHTML[$R['language_id']][$i]	= $CustomFieldsEditor[$R['language_id']][$i]->Create();			
			}
		}
	}
}
$smarty->assign('CustomFieldsEditorInstance', substr($CustomFieldsEditorInstance, 1, -1));
$smarty->assign('CustomFieldsEditorHTML', $CustomFieldsEditorHTML);

$ProductBrandFieldsShow = site::GetProductBrandFieldsShow($_SESSION['site_id']);
$smarty->assign('ProductBrandFieldsShow', $ProductBrandFieldsShow);

$smarty->assign('TITLE', 'Edit Product Brand');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_brand_edit.tpl');