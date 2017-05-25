<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_article.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_sitemap_edit", __FILE__, false);
acl::AclBarrier("acl_folder_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'folder_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);
acl::SetIsPublisherFlagForSmarty($ObjectLink);

$Folder = folder::GetFolderDetails($ObjectLink['object_id']);
$Folder['object_seo_url'] = object::GetSeoURL($Folder, '', $Folder['language_id'], $Site);
$smarty->assign('Folder', $Folder);
$smarty->assign('TheObject', $Folder);

$IsFolderRemovable = folder::IsFolderRemovable($ObjectLink['object_id']);
$smarty->assign('IsFolderRemovable', $IsFolderRemovable);

$FolderCustomFieldsDef = site::GetFolderCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('FolderCustomFieldsDef', $FolderCustomFieldsDef);

$CustomFieldsEditor = array();
$CustomFieldsEditorHTML = array();
$CustomFieldsEditorInstance = ' ';

for ($i = 1; $i <= 20; $i++) {
	if ($FolderCustomFieldsDef['folder_custom_text_' . $i] != '') {
		if (substr($FolderCustomFieldsDef['folder_custom_text_' . $i], 0, 5) != 'STXT_' ||
			substr($FolderCustomFieldsDef['folder_custom_text_' . $i], 0, 5) != 'MTXT_' ) {
			
			$CustomFieldsEditorInstance = $CustomFieldsEditorInstance . 'CustomFieldEditor' . $i . " ";
			$CustomFieldsEditor[$i]	= new FCKeditor('CustomFieldEditor' . $i);
			$CustomFieldsEditor[$i]->BasePath = FCK_BASEURL;
			$CustomFieldsEditor[$i]->Value	= $Folder['folder_custom_text_' . $i];
			$CustomFieldsEditor[$i]->Width	= '700';
			$CustomFieldsEditor[$i]->Height	= '400';
			$CustomFieldsEditorHTML[$i]	= $CustomFieldsEditor[$i]->Create();
		}		
	}
}
$smarty->assign('CustomFieldsEditorInstance', substr($CustomFieldsEditorInstance, 1, -1));
$smarty->assign('CustomFieldsEditorHTML', $CustomFieldsEditorHTML);

$smarty->assign('TITLE', 'Edit Folder');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/folder_edit.tpl');