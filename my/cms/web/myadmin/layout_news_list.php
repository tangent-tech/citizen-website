<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_layout_news.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_layout_news_list", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
//$smarty->assign('CurrentTab2', 'layout_news');
$smarty->assign('MyJS', 'layout_news_list');

$smarty->assign('CurrentLayoutNewsRootID', $_REQUEST['id']);

$LayoutNewsRoot = layout_news::GetLayoutNewsRootInfo($_REQUEST['id']);
if ($LayoutNewsRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news.php', __LINE__);
$smarty->assign('LayoutNewsRoot', $LayoutNewsRoot);

acl::ObjPermissionBarrier("browse_children", $LayoutNewsRoot, __FILE__, false);

$LayoutNewsCategories = layout_news::GetLayoutNewsCategoryList($LayoutNewsRoot['language_id'], $_SESSION['site_id']);
if (count($LayoutNewsCategories) == 0) {
	AdminDie(ADMIN_ERROR_NO_NEWS_CATEGORY, 'layout_news_category_list.php?language_id=' . $LayoutNewsRoot['language_id'], __LINE__);
}
$smarty->assign('LayoutNewsCategories', $LayoutNewsCategories);

$NumOfLayoutNews = 0;

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

$LayoutNewsList = layout_news::GetLayoutNewsListByLayoutNewsRootID($_REQUEST['id'], $NumOfLayoutNews, $_REQUEST['page_id'], NUM_OF_NEWS_PER_PAGE, $_REQUEST['layout_news_id'], $_REQUEST['layout_news_date'], $_REQUEST['layout_news_title'], $_REQUEST['layout_news_category_id'], $_REQUEST['layout_news_tag']);
$smarty->assign('LayoutNewsList', $LayoutNewsList);
	
$NoOfPage = ceil($NumOfLayoutNews / NUM_OF_NEWS_PER_PAGE);
$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$smarty->assign('TITLE', $LayoutNewsRoot['layout_news_root_name'] . ' List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/layout_news_list.tpl');