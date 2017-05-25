<?php
if (!defined('IN_CMS'))
	die("common_rich.php is called directly " . realpath(__FILE__) . " " .  __LINE__);
header('Content-type: text/xml');
echo("<?xml version=\"1.0\" encoding=\"utf-8\" ?>");

$Site = site::GetSiteInfoByAppSecret($_REQUEST['site_id'], $_REQUEST['site_secret']);
$smarty->assign('Site', $Site);

$UserCustomFieldsDef = Site::GetUserCustomFieldsDef($Site['site_id']);
$smarty->assign('UserCustomFieldsDef', $UserCustomFieldsDef);

$ProductCustomFieldsDef = Site::GetProductCustomFieldsDef($Site['site_id']);
$smarty->assign('ProductCustomFieldsDef', $ProductCustomFieldsDef);

$ProductBrandCustomFieldsDef = Site::GetProductBrandCustomFieldsDef($Site['site_id']);
$smarty->assign('ProductBrandCustomFieldsDef', $ProductBrandCustomFieldsDef);

$ProductCategoryCustomFieldsDef = Site::GetProductCategoryCustomFieldsDef($Site['site_id']);
$smarty->assign('ProductCategoryCustomFieldsDef', $ProductCategoryCustomFieldsDef);

$AlbumCustomFieldsDef = Site::GetAlbumCustomFieldsDef($Site['site_id']);
$smarty->assign('AlbumCustomFieldsDef', $AlbumCustomFieldsDef);

$FolderCustomFieldsDef = Site::GetFolderCustomFieldsDef($Site['site_id']);
$smarty->assign('FolderCustomFieldsDef', $FolderCustomFieldsDef);

$MediaCustomFieldsDef = Site::GetMediaCustomFieldsDef($Site['site_id']);
$smarty->assign('MediaCustomFieldsDef', $MediaCustomFieldsDef);

$DatafileCustomFieldsDef = Site::GetDatafileCustomFieldsDef($Site['site_id']);
$smarty->assign('DatafileCustomFieldsDef', $DatafileCustomFieldsDef);

$MyorderCustomFieldsDef = Site::GetMyorderCustomFieldsDef($Site['site_id']);
$smarty->assign('MyorderCustomFieldsDef', $MyorderCustomFieldsDef);

if ($Site['site_is_enable'] != 'Y')
	APIDie($API_ERROR['API_ERROR_AUTH_FAIL']);
?>