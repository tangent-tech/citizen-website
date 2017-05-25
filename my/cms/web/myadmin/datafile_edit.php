<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

if ($_REQUEST['refer'] == 'product_edit') {
	require_once('../common/header_product.php');
	acl::AclBarrier("acl_product_edit", __FILE__, false);
}
elseif ($_REQUEST['refer'] == 'member_edit') {
	require_once('../common/header_member.php');
	acl::AclBarrier("acl_member_edit", __FILE__, false);	
}
elseif ($_REQUEST['refer'] == 'bonuspoint_edit') {
	require_once('../common/header_order.php');
	acl::AclBarrier("acl_bonuspoint_edit", __FILE__, false);
}
else {
	require_once('../common/header_album.php');
	acl::AclBarrier("acl_album_edit", __FILE__, false);	
}
acl::AclBarrier("acl_datafile_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');
$smarty->assign('MyJS', 'datafile_edit');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$Datafile = datafile::GetDatafileInfo($_REQUEST['id'], 0);
if ($Datafile['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);
$smarty->assign('Datafile', $Datafile);
$smarty->assign('TheObject', $Datafile);

$ParentObj = object::GetParentObjForPermissionChecking($Datafile);
acl::ObjPermissionBarrier("edit", $ParentObj, __FILE__, false);

$DatafileData = array();
foreach ($SiteLanguageRoots as $R) {
	datafile::TouchDatafileData($_REQUEST['id'], $R['language_id']);
	$DatafileData[$R['language_id']] = datafile::GetDatafileInfo($_REQUEST['id'], $R['language_id']);
}
$smarty->assign('DatafileData', $DatafileData);

$DatafileCustomFieldsDef = site::GetDatafileCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('DatafileCustomFieldsDef', $DatafileCustomFieldsDef);

$smarty->assign('TITLE', 'Edit Datafile');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/datafile_edit.tpl');