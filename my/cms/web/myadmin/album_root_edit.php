<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_album.php');

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');
$smarty->assign('MyJS', 'album_root_edit');

$AlbumRoot = object::GetObjectInfo($Site['album_root_id']);
$smarty->assign('TheObject', $AlbumRoot);

if ($AlbumRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

foreach ($SiteLanguageRoots as $R) {
	$AlbumRootData[$R['language_id']] = album::GetAlbumRootInfo($AlbumRoot['object_id'], $R['language_id']);
}
$smarty->assign('AlbumRootData', $AlbumRootData);

$smarty->assign('TITLE', 'Edit Album Root');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/album_root_edit.tpl');