<?php
// parameters:
//	link_id
//	security_level
//	page_no
//	layout_news_per_page
//	tag
//	layout_news_category_id - Optional
//	include_layout_details - Default 'N', recommend to turn off cause it costs lots of CPU cycle
//  date_search - default is 'N'
//  date_from
//  date_to

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$LayoutNewsPage = layout_news::GetLayoutNewsPageInfo($ObjectLink['object_id']);

$LayoutNewsRoot = layout_news::GetLayoutNewsRootInfo($LayoutNewsPage['layout_news_root_id']);
$LayoutNewsRoot['object_seo_url'] = object::GetSeoURL($LayoutNewsRoot, '', $LayoutNewsRoot['language_id'], $Site);
$smarty->assign('Object', $LayoutNewsRoot);
$LayoutNewsRootXML = $smarty->fetch('api/object_info/LAYOUT_NEWS_ROOT.tpl');
$smarty->assign('LayoutNewsRootXML', $LayoutNewsRootXML);

if ($_REQUEST['layout_news_category_id'] == null)
	$_REQUEST['layout_news_category_id'] = 0;

$LayoutNewsCategoryXML = '';
if ($_REQUEST['layout_news_category_id'] != 0) {
	$LayoutNewsCategory = layout_news::GetLayoutNewsCategoryInfo($_REQUEST['layout_news_category_id']);
	$LayoutNewsCategory['object_seo_url'] = object::GetSeoURL($LayoutNewsCategory, '', $LayoutNewsCategory['language_id'], $Site);
	$smarty->assign('Object', $LayoutNewsCategory);
	$NewsCategoryXML = $smarty->fetch('api/object_info/LAYOUT_NEWS_CATEGORY.tpl');
}
$smarty->assign('LayoutNewsCategoryXML', $LayoutNewsCategoryXML);

$PageNo = intval($_REQUEST['page_no']);
$LayoutNewsPerPage = intval($_REQUEST['layout_news_per_page']);

$Offset = ($PageNo -1) * $LayoutNewsPerPage;

$TotalNoOfLayoutNews = 0;
$LayoutNewsListXML = layout_news::GetLayoutNewsListXML($TotalNoOfLayoutNews, $LayoutNewsPage['layout_news_root_id'], $LayoutNewsPage['layout_news_category_id'], $_REQUEST['tag'], $_REQUEST['security_level'], $Offset, $LayoutNewsPerPage, ynval($_REQUEST['include_layout_details']), ynval($_REQUEST['date_search']), $_REQUEST['date_from'], $_REQUEST['date_to']);
$LayoutNewsPage['object_seo_url'] = object::GetSeoURL($LayoutNewsPage, '', $LayoutNewsPage['language_id'], $Site);
$smarty->assign('Object', $LayoutNewsPage);
$smarty->assign('LayoutNewsListXML', $LayoutNewsListXML);
$smarty->assign('TotalNoOfLayoutNews', $TotalNoOfLayoutNews);
$smarty->assign('PageNo', $PageNo);
$Data = $smarty->fetch('api/object_info/LAYOUT_NEWS_PAGE.tpl');

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');