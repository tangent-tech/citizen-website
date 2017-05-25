<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_bonus_point.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_bonuspoint_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'bonuspoint');
$smarty->assign('MyJS', 'bonuspoint_edit');

$BonusPointItem = bonuspoint::GetBonusPointItemInfo($_REQUEST['id'], 0);

if ($BonusPointItem['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'bonuspoint_list.php', __LINE__);

//$BonusPointItem['object_seo_url'] = object::GetSeoURL($BonusPointItem, '');
$smarty->assign('BonusPointItem', $BonusPointItem);
$smarty->assign('TheObject', $BonusPointItem);

acl::ObjPermissionBarrier("edit", $BonusPointItem, __FILE__, false);
acl::SetIsPublisherFlagForSmarty($BonusPointItem);

if ($BonusPointItem['object_is_enable'] == 'Y')
	$smarty->assign('CurrentTab2', 'bonuspoint_list_enable');
elseif ($BonusPointItem['object_is_enable'] == 'N')
	$smarty->assign('CurrentTab2', 'bonuspoint_list_disable');
else {
	$smarty->assign('CurrentTab2', 'bonuspoint_list_all');
}

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$BonusPointItemData = array();
$Editor = array();
$EditorHTML = array();

foreach ($SiteLanguageRoots as $R) {
	bonuspoint::TouchBonusPointItemData($BonusPointItem['bonus_point_item_id'], $R['language_id']);
	$BonusPointItemData[$R['language_id']] = bonuspoint::GetBonusPointItemInfo($_REQUEST['id'], $R['language_id']);
	$Editor[$R['language_id']]	= new FCKeditor('ContentEditor' . $R['language_id']);
	$Editor[$R['language_id']]->BasePath = FCK_BASEURL;
	$Editor[$R['language_id']]->Value	= $BonusPointItemData[$R['language_id']]['bonus_point_item_desc'];
	$Editor[$R['language_id']]->Width	= '700';
	$Editor[$R['language_id']]->Height	= '400';
	$EditorHTML[$R['language_id']]	= $Editor[$R['language_id']]->Create();
	$smarty->assign('EditorHTML', $EditorHTML);
}
$smarty->assign('BonusPointItemData', $BonusPointItemData);

$Site = site::GetSiteInfo($_SESSION['site_id']);
$smarty->assign('Site', $Site);

$TotalMedia = 0;
$BonusPointItemMediaList = media::GetMediaList($BonusPointItem['bonus_point_item_id'], 0, $TotalMedia, 1, 999999);
$smarty->assign('BonusPointItemMediaList', $BonusPointItemMediaList);

$IsBonusPointItemRemovable = bonuspoint::IsBonusPointItemRemovable($_REQUEST['id']);
$smarty->assign('IsBonusPointItemRemovable', $IsBonusPointItemRemovable);

$smarty->assign('TITLE', 'Edit Bonus Point Item');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/bonuspoint_edit.tpl');