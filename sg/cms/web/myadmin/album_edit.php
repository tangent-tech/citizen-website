<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_album.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_album_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');
$smarty->assign('MyJS', 'album_edit');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$Object = object::GetObjectLinkInfo($_REQUEST['link_id']);
$Album = album::GetAlbumInfo($Object['object_id'], 0);
if ($Album['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);
$Album['object_seo_url'] = object::GetSeoURL($Album, '', $Site['site_default_language_id'], $Site);
$smarty->assign('Album', $Album);
$smarty->assign('TheObject', $Album);

acl::ObjPermissionBarrier("edit", $Object, __FILE__, false);
acl::SetIsPublisherFlagForSmarty($Object);

$AlbumData = array();
foreach ($SiteLanguageRoots as $R) {
	album::TouchAlbumData($Object['object_id'], $R['language_id']);
	$AlbumData[$R['language_id']] = album::GetAlbumInfo($Object['object_id'], $R['language_id']);
}
$smarty->assign('AlbumData', $AlbumData);

$AlbumFiles = array();
for ($i = 1; $i <= 20; $i++) {
	if ($Album['album_custom_file_id_' . $i] != 0) {
		$FileInfo = filebase::GetFileInfo($Album['album_custom_file_id_' . $i]);
		$AlbumFiles[$i] = $FileInfo;
	}
}
$smarty->assign('AlbumFiles', $AlbumFiles);

$AlbumCustomFieldsDef = site::GetAlbumCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('AlbumCustomFieldsDef', $AlbumCustomFieldsDef);

$CustomFieldsEditor = array();
$CustomFieldsEditorHTML = array();
$CustomFieldsEditorInstance = ' ';

for ($i = 1; $i <= 20; $i++) {
	if ($AlbumCustomFieldsDef['album_custom_text_' . $i] != '') {
		if (substr($AlbumCustomFieldsDef['album_custom_text_' . $i], 0, 5) != 'STXT_' ||
			substr($AlbumCustomFieldsDef['album_custom_text_' . $i], 0, 5) != 'MTXT_' ) {

			foreach ($SiteLanguageRoots as $R) {
				$CustomFieldsEditorInstance = $CustomFieldsEditorInstance . 'CustomFieldEditor' . $i . '_' . $R['language_id'] . " ";
				$CustomFieldsEditor[$R['language_id']][$i]	= new FCKeditor('CustomFieldEditor' . $i . '_' . $R['language_id']);
				$CustomFieldsEditor[$R['language_id']][$i]->BasePath = FCK_BASEURL;
				$CustomFieldsEditor[$R['language_id']][$i]->Value	= $AlbumData[$R['language_id']]['album_custom_text_' . $i];
				$CustomFieldsEditor[$R['language_id']][$i]->Width	= '700';
				$CustomFieldsEditor[$R['language_id']][$i]->Height	= '400';
				$CustomFieldsEditorHTML[$R['language_id']][$i]	= $CustomFieldsEditor[$R['language_id']][$i]->Create();			
			}
		}
	}
}
$smarty->assign('CustomFieldsEditorInstance', substr($CustomFieldsEditorInstance, 1, -1));
$smarty->assign('CustomFieldsEditorHTML', $CustomFieldsEditorHTML);

$smarty->assign('TITLE', 'Edit Album');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/album_edit.tpl');