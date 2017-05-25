<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_news.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_news_add", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
//$smarty->assign('CurrentTab2', 'news');
$smarty->assign('MyJS', 'news_add');

$smarty->assign('CurrentNewsRootID', $_REQUEST['id']);

$NoOfNews = news::GetNoOfNews($_SESSION['site_id']);
if ($NoOfNews >= $Site['site_module_news_quota'])
	AdminDie(ADMIN_ERROR_NEWS_QUOTA_FULL, 'news.php', __LINE__);

$NewsRoot = news::GetNewsRootInfo($_REQUEST['id']);
if ($NewsRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);
$smarty->assign('NewsRoot', $NewsRoot);
$smarty->assign('TheObject', $NewsRoot);
acl::ObjPermissionBarrier("add_children", $NewsRoot, __FILE__, false);

$NewsCategories = news::GetNewsCategoryList($NewsRoot['language_id'], $_SESSION['site_id']);
if (count($NewsCategories) == 0) {
	AdminDie(ADMIN_ERROR_NO_NEWS_CATEGORY, 'news_category_list.php?language_id=' . $NewsRoot['language_id'], __LINE__);
}
$smarty->assign('NewsCategories', $NewsCategories);

$SummaryEditor	= new FCKeditor('SummaryEditor');
$SummaryEditor->BasePath = FCK_BASEURL;
$SummaryEditor->Value	=  '';
$SummaryEditor->Width	= '800';
$SummaryEditor->Height	= '200';
$SummaryEditorHTML	= $SummaryEditor->Create();
$smarty->assign('SummaryEditorHTML', $SummaryEditorHTML);

$Editor	= new FCKeditor('ContentEditor');
$Editor->BasePath = FCK_BASEURL;
$Editor->Value	=  '';
$Editor->Width	= '800';
$Editor->Height	= '600';
$EditorHTML	= $Editor->Create();
$smarty->assign('EditorHTML', $EditorHTML);

$smarty->assign('TITLE', 'Add ' . $NewsRoot['news_root_name']);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/news_add.tpl');