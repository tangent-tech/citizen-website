<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_album.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_album_add", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');
$smarty->assign('MyJS', 'album_add');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$TheObject = object::GetObjectInfo($Site['album_root_id']);
$smarty->assign('TheObject', $TheObject);

acl::ObjPermissionBarrier("add_children", $TheObject, __FILE__, false);

$smarty->assign('TITLE', 'Add Album');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/album_add.tpl');