<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_news.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_news_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
//$smarty->assign('CurrentTab2', 'news');
$smarty->assign('MyJS', 'news_edit');

$News = news::GetNewsInfo($_REQUEST['id']);
if ($News['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);
$News['object_seo_url'] = object::GetSeoURL($News, '', $News['language_id'], null);
$smarty->assign('News', $News);
$smarty->assign('TheObject', $News);
$smarty->assign('CurrentNewsRootID', $News['news_root_id']);

acl::ObjPermissionBarrier("edit", $News, __FILE__, false);
acl::SetIsPublisherFlagForSmarty($News);

$NewsCategories = news::GetNewsCategoryList($News['language_id'], $_SESSION['site_id']);
if (count($NewsCategories) == 0) {
	AdminDie(ADMIN_ERROR_NO_NEWS_CATEGORY, 'news_category_list.php?language_id=' . $News['language_id'], __LINE__);
}
$smarty->assign('NewsCategories', $NewsCategories);

$Albums = album::GetAlbumList($Site['album_root_id']);
$smarty->assign('Albums', $Albums);

$SummaryEditor	= new FCKeditor('SummaryEditor');
$SummaryEditor->BasePath = FCK_BASEURL;
$SummaryEditor->Value	=  $News['news_summary'];
$SummaryEditor->Width	= '800';
$SummaryEditor->Height	= '200';
$SummaryEditorHTML	= $SummaryEditor->Create();
$smarty->assign('SummaryEditorHTML', $SummaryEditorHTML);

$Editor	= new FCKeditor('ContentEditor');
$Editor->BasePath = FCK_BASEURL;
$Editor->Value	=  $News['news_content'];
$Editor->Width	= '800';
$Editor->Height	= '600';
$EditorHTML	= $Editor->Create();
$smarty->assign('EditorHTML', $EditorHTML);

$NewsTagText = $News['news_tag'];
$NewsTagText = substr($NewsTagText, 2, -2);
$smarty->assign('NewsTagText', $NewsTagText);

$smarty->assign('TITLE', 'Edit News');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/news_edit.tpl');