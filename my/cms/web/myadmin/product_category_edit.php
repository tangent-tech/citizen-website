<?php
define('IN_CMS', true);

require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_category_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_category_edit');

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

$ProductCat = product::GetProductCatInfo($ObjectLink['object_id'], 0);
if ($ProductCat['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);
$ProductCat['object_seo_url'] = object::GetSeoURL($ProductCat, '', $Site['site_default_language_id'], $Site);

$smarty->assign('ProductCat', $ProductCat);
$smarty->assign('TheObject', $ProductCat);

$ProductCatData = array();
$Editor = array();
$EditorHTML = array();

foreach ($SiteLanguageRoots as $R) {
	product::TouchProductCatData($ProductCat['product_category_id'], $R['language_id']);
	$ProductCatData[$R['language_id']] = product::GetProductCatInfo($ObjectLink['object_id'], $R['language_id']);
}

$smarty->assign('ProductCatData', $ProductCatData);

$IsProductCatRemovable = product::IsProductCatRemovable($ProductCat['object_id']);
$smarty->assign('IsProductCatRemovable', $IsProductCatRemovable);

$ProductCatFieldsShow = site::GetProductCatFieldsShow($_SESSION['site_id']);
$smarty->assign('ProductCatFieldsShow', $ProductCatFieldsShow);

$ProductCategoryCustomFieldsDef = site::GetProductCategoryCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('ProductCategoryCustomFieldsDef', $ProductCategoryCustomFieldsDef);

$ProductCustomFieldsDef = site::GetProductCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('ProductCustomFieldsDef', $ProductCustomFieldsDef);

$ProductCatPriceRangeList = product::GetProductCatPriceRangeList($ProductCat['product_category_id'], $Site);
$smarty->assign('ProductCatPriceRangeList', $ProductCatPriceRangeList);

$CustomFieldsEditor = array();
$CustomFieldsEditorHTML = array();
$CustomFieldsEditorInstance = ' ';

for ($i = 1; $i <= 20; $i++) {
	if ($ProductCategoryCustomFieldsDef['product_category_custom_text_' . $i] != '') {
		if (substr($ProductCategoryCustomFieldsDef['product_category_custom_text_' . $i], 0, 5) != 'STXT_' ||
			substr($ProductCategoryCustomFieldsDef['product_category_custom_text_' . $i], 0, 5) != 'MTXT_' ) {

			foreach ($SiteLanguageRoots as $R) {
				$CustomFieldsEditorInstance = $CustomFieldsEditorInstance . 'CustomFieldEditor' . $i .'_' . $R['language_id'] . " ";
				$CustomFieldsEditor[$R['language_id']][$i]	= new FCKeditor('CustomFieldEditor' . $i .'_' .$R['language_id']);
				$CustomFieldsEditor[$R['language_id']][$i]->BasePath = FCK_BASEURL;
				$CustomFieldsEditor[$R['language_id']][$i]->Value	= $ProductCatData[$R['language_id']]['product_category_custom_text_' . $i];
				$CustomFieldsEditor[$R['language_id']][$i]->Width	= '700';
				$CustomFieldsEditor[$R['language_id']][$i]->Height	= '400';
				$CustomFieldsEditorHTML[$R['language_id']][$i]	= $CustomFieldsEditor[$R['language_id']][$i]->Create();			
			}
		}
	}
}
$smarty->assign('CustomFieldsEditorInstance', substr($CustomFieldsEditorInstance, 1, -1));
$smarty->assign('CustomFieldsEditorHTML', $CustomFieldsEditorHTML);

$ValidObjectList = array('PRODUCT', 'PRODUCT_CATEGORY');
$ChildObjects = site::GetAllChildObjects($ValidObjectList, $ProductCat['object_id'], 999999, 'ALL', 'N');
$smarty->assign('ChildObjects', $ChildObjects);

$ValidObjectList = array("PRODUCT_CATEGORY");
$SubCatList = site::GetAllChildObjects($ValidObjectList, $ObjectLink['object_id'], 999999, 'ALL', 'ALL', false, false, true);
$smarty->assign('NoOfSubCat', count($SubCatList));

$TotalMedia = 0;
$ProductCatMediaList = media::GetMediaList($ProductCat['object_id'], 0, $TotalMedia, 1, 999999, 999999, false, false);
$smarty->assign('ProductCatMediaList', $ProductCatMediaList);

$ProductCategoryGroupValidFields = product::GetProductGroupValidFieldList($_SESSION['site_id']);
$smarty->assign('ProductCategoryGroupValidFields', $ProductCategoryGroupValidFields);

$smarty->assign('TITLE', 'Edit Product Category');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_category_edit.tpl');