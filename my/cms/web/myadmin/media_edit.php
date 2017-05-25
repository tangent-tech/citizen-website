<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_media_edit", __FILE__, false);

/*
if ($_REQUEST['refer'] == 'product_edit')
	require_once('../common/header_product.php');
elseif ($_REQUEST['refer'] == 'product_category_edit')
	require_once('../common/header_product.php');
elseif ($_REQUEST['refer'] == 'bonuspoint_edit')
	require_once('../common/header_order.php');
else
	require_once('../common/header_album.php');
*/
$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');
$smarty->assign('MyJS', 'media_edit');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$Media = media::GetMediaInfo($_REQUEST['id'], 0);
if ($Media['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);
$smarty->assign('Media', $Media);
$smarty->assign('TheObject', $Media);

$ParentObj = object::GetParentObjForPermissionChecking($Media);
if ($ParentObj['object_type'] == 'PRODUCT' || $ParentObj['object_type'] == 'PRODUCT_CATEGORY' || $ParentObj['object_type'] == 'PRODUCT_SPECIAL_CATEGORY') {
	require_once('../common/header_product.php');
	acl::ObjPermissionBarrier("edit", $ParentObj, __FILE__, false);
}
elseif ($ParentObj['object_type'] == 'BONUS_POINT_ITEM') {
	require_once('../common/header_order.php');
	acl::ObjPermissionBarrier("edit", $ParentObj, __FILE__, false);
}
elseif ($ParentObj['object_type'] == 'ALBUM') {
	require_once('../common/header_album.php');
	acl::ObjPermissionBarrier("edit", $ParentObj, __FILE__, false);
}
else
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);

$MediaData = array();
foreach ($SiteLanguageRoots as $R) {
	media::TouchMediaData($_REQUEST['id'], $R['language_id']);
	$MediaData[$R['language_id']] = media::GetMediaInfo($_REQUEST['id'], $R['language_id']);
}
$smarty->assign('MediaData', $MediaData);

$MediaCustomFieldsDef = site::GetMediaCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('MediaCustomFieldsDef', $MediaCustomFieldsDef);

$CustomFieldsEditor = array();
$CustomFieldsEditorHTML = array();
$CustomFieldsEditorInstance = ' ';

for ($i = 1; $i <= 20; $i++) {
	if ($MediaCustomFieldsDef['media_custom_text_' . $i] != '') {
		if (substr($MediaCustomFieldsDef['media_custom_text_' . $i], 0, 5) != 'STXT_' ||
			substr($MediaCustomFieldsDef['media_custom_text_' . $i], 0, 5) != 'MTXT_' ) {
			
			foreach ($SiteLanguageRoots as $R) {
				$CustomFieldsEditorInstance = $CustomFieldsEditorInstance . 'CustomFieldEditor' . $i . '_' . $R['language_id'] . " ";
				$CustomFieldsEditor[$R['language_id']][$i]	= new FCKeditor('CustomFieldEditor' . $i . '_' . $R['language_id']);
				$CustomFieldsEditor[$R['language_id']][$i]->BasePath = FCK_BASEURL;
				$CustomFieldsEditor[$R['language_id']][$i]->Value	= $MediaData[$R['language_id']]['media_custom_text_' . $i];
				$CustomFieldsEditor[$R['language_id']][$i]->Width	= '700';
				$CustomFieldsEditor[$R['language_id']][$i]->Height	= '400';
				$CustomFieldsEditorHTML[$R['language_id']][$i]	= $CustomFieldsEditor[$R['language_id']][$i]->Create();			
			}			
		}		
	}
}
$smarty->assign('CustomFieldsEditorInstance', substr($CustomFieldsEditorInstance, 1, -1));
$smarty->assign('CustomFieldsEditorHTML', $CustomFieldsEditorHTML);

$smarty->assign('TITLE', 'Edit Media');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/media_edit.tpl');