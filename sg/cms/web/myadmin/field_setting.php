<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'field_setting');
$smarty->assign('MyJS', 'field_setting');

$UserCustomFieldsDef = Site::GetUserCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('UserCustomFieldsDef', $UserCustomFieldsDef);

$ProductCustomFieldsDef = Site::GetProductCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('ProductCustomFieldsDef', $ProductCustomFieldsDef);

$ProductBrandCustomFieldsDef = Site::GetProductBrandCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('ProductBrandCustomFieldsDef', $ProductBrandCustomFieldsDef);

$ProductBrandFieldsShow = Site::GetProductBrandFieldsShow($_SESSION['site_id']);
$smarty->assign('ProductBrandFieldsShow', $ProductBrandFieldsShow);

$ProductCategoryCustomFieldsDef = Site::GetProductCategoryCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('ProductCategoryCustomFieldsDef', $ProductCategoryCustomFieldsDef);

$ProductFieldsShow = Site::GetProductFieldsShow($_SESSION['site_id']);
$smarty->assign('ProductFieldsShow', $ProductFieldsShow);

$ProductCatFieldsShow = Site::GetProductCatFieldsShow($_SESSION['site_id']);
$smarty->assign('ProductCatFieldsShow', $ProductCatFieldsShow);

$UserFieldsShow = Site::GetUserFieldsShow($_SESSION['site_id']);
$smarty->assign('UserFieldsShow', $UserFieldsShow);

$AlbumCustomFieldsDef = Site::GetAlbumCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('AlbumCustomFieldsDef', $AlbumCustomFieldsDef);

$FolderCustomFieldsDef = Site::GetFolderCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('FolderCustomFieldsDef', $FolderCustomFieldsDef);

$MediaCustomFieldsDef = Site::GetMediaCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('MediaCustomFieldsDef', $MediaCustomFieldsDef);

$DatafileCustomFieldsDef = Site::GetDatafileCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('DatafileCustomFieldsDef', $DatafileCustomFieldsDef);

$MyorderFieldsShow = Site::GetMyorderFieldsShow($_SESSION['site_id']);
$smarty->assign('MyorderFieldsShow', $MyorderFieldsShow);


$MyorderCustomFieldsDef = Site::GetMyorderCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('MyorderCustomFieldsDef', $MyorderCustomFieldsDef);

$smarty->assign('TITLE', 'Field Setting');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/field_setting.tpl');