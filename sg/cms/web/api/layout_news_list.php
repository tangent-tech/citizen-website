<?php
// parameters:
//	layout_news_root_id - 0 for all
//	layout_news_category_id - 0 for all
//	security_level
//	page_no
//	layout_news_per_page
//	tag
//	include_layout_details - Default 'N', recommend to turn off cause it costs lots of CPU cycle
//  date_search - default is 'N'
//  date_from
//  date_to
//	orderby - date / title, default: date 
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if (intval($_REQUEST['layout_news_root_id']) != 0) {
	$LayoutNewsRoot = layout_news::GetLayoutNewsRootInfo($_REQUEST['layout_news_root_id']);
	if ($LayoutNewsRoot['site_id'] != $Site['site_id'])
		APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);
	$LayoutNewsRoot['object_seo_url'] = object::GetSeoURL($LayoutNewsRoot, '', $LayoutNewsRoot['language_id'], $Site);
	$smarty->assign('Object', $LayoutNewsRoot);
	$LayoutNewsRootXML = $smarty->fetch('api/object_info/LAYOUT_NEWS_ROOT.tpl');
	$smarty->assign('LayoutNewsRootXML', $LayoutNewsRootXML);
	
	$MySiteID = 0;
}
else {
	$_REQUEST['layout_news_root_id'] = 0;
	$MySiteID = $Site['site_id'];
}


if ($_REQUEST['layout_news_category_id'] == null)
	$_REQUEST['layout_news_category_id'] = 0;

$LayoutNewsCategoryXML = '';
if ($_REQUEST['layout_news_category_id'] != 0) {
	$LayoutNewsCategory = layout_news::GetLayoutNewsCategoryInfo($_REQUEST['layout_news_category_id']);
	$LayoutNewsCategory['object_seo_url'] = object::GetSeoURL($LayoutNewsCategory, '', $LayoutNewsCategory['language_id'], $Site);
	$smarty->assign('Object', $LayoutNewsCategory);
	$LayoutNewsCategoryXML = $smarty->fetch('api/object_info/LAYOUT_NEWS_CATEGORY.tpl');

	if ($LayoutNewsCategory['site_id'] != $Site['site_id'])
		APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);
}
$smarty->assign('LayoutNewsCategoryXML', $LayoutNewsCategoryXML);

$PageNo = intval($_REQUEST['page_no']);
$LayoutNewsPerPage = intval($_REQUEST['layout_news_per_page']);

$Offset = ($PageNo -1) * $LayoutNewsPerPage;

$TotalNoOfLayoutNews = 0;

$OrderByFieldValid = array("layout_news_date", "layout_news_title");
$OrderByOrderValid = array("DESC", "ASC");

if (!in_array($_REQUEST['orderby_field'], $OrderByFieldValid)) {
	$_REQUEST['orderby_field'] = 'layout_news_date';
}

if (!in_array(strtoupper($_REQUEST['orderby_order']), $OrderByOrderValid))
	$_REQUEST['orderby_order'] = "DESC";


$LayoutNewsListXML = layout_news::GetLayoutNewsListXML($TotalNoOfLayoutNews, intval($_REQUEST['layout_news_root_id']), $_REQUEST['layout_news_category_id'], $_REQUEST['tag'], $_REQUEST['security_level'], $Offset, $LayoutNewsPerPage, ynval($_REQUEST['include_layout_details']), ynval($_REQUEST['date_search']), $_REQUEST['date_from'], $_REQUEST['date_to'], $_REQUEST['orderby_field'], strtoupper($_REQUEST['orderby_order']), $MySiteID);
$smarty->assign('LayoutNewsListXML', $LayoutNewsListXML);
$smarty->assign('TotalNoOfLayoutNews', $TotalNoOfLayoutNews);
$smarty->assign('PageNo', $PageNo);
$smarty->assign('LayoutNewsTag', trim($_REQUEST['tag']));
$Data = $smarty->fetch('api/layout_news_list.tpl');

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');