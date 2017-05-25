<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_article.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_siteblock_add", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'siteblock');
$smarty->assign('MyJS', 'siteblock_add');

$BlockDef = block::GetBlockDefInfo($_REQUEST['block_def_id']);
$smarty->assign('BlockDef', $BlockDef);
if ($BlockDef['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'siteblock.php', __LINE__);

$SiteLanguage = language::GetSiteLanguageRoot($_REQUEST['language_id'], $_SESSION['site_id']);
if ($SiteLanguage == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'siteblock.php', __LINE__);

$BlockHolder = block::GetBlockHolderBySiteID($_SESSION['site_id'], $_REQUEST['block_def_id'], $_REQUEST['language_id']);
$smarty->assign('BlockHolder', $BlockHolder);
$smarty->assign('TheObject', $BlockHolder);

if ($BlockHolder['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'siteblock.php', __LINE__);

acl::ObjPermissionBarrier("add_children", $BlockHolder, __FILE__, false);

if ($BlockDef['block_definition_type'] == 'html') {
	$Editor	= new FCKeditor('ContentEditor');
	$Editor->BasePath = FCK_BASEURL;
	$Editor->Value	=  '';
	$Editor->Width	= '800';
	$Editor->Height	= '600';
	$EditorHTML	= $Editor->Create();
	$smarty->assign('EditorHTML', $EditorHTML);
}

$smarty->assign('TITLE', 'Add Site Block');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/siteblock_add.tpl');