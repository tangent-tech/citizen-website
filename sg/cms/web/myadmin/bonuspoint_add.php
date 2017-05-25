<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_bonus_point.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_bonuspoint_add", __FILE__, false);

$smarty->assign('CurrentTab', 'bonuspoint');
$smarty->assign('CurrentTab2', 'bonuspoint_list_all');
$smarty->assign('MyJS', 'bonuspoint_add');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$ParentObj = object::GetObjectInfo($Site['bonus_point_root_id']);
acl::ObjPermissionBarrier("add_children", $ParentObj, __FILE__, false);

$Editor = array();
$EditorHTML = array();

foreach ($SiteLanguageRoots as $R) {
	$Editor[$R['language_id']]	= new FCKeditor('ContentEditor' . $R['language_id']);
	$Editor[$R['language_id']]->BasePath = FCK_BASEURL;
	$Editor[$R['language_id']]->Width	= '700';
	$Editor[$R['language_id']]->Height	= '400';
	$EditorHTML[$R['language_id']]	= $Editor[$R['language_id']]->Create();
	$smarty->assign('EditorHTML', $EditorHTML);
}

$TheObject = object::GetObjectInfo($Site['bonus_point_root_id']);
$smarty->assign('TheObject', $TheObject);

$smarty->assign('TITLE', 'Add Bonus Point Item');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/bonuspoint_add.tpl');