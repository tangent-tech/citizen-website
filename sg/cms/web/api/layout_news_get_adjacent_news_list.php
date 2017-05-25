<?php
// parameters:
//	layout_news_id
//	no_of_adjacent_layout_news
//	layout_news_category_id - 0 for all
//	security_level
//	tag - empty for all
//	include_layout_details

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if (intval($_REQUEST['no_of_adjacent_layout_news']) <= 0)
	$_REQUEST['no_of_adjacent_layout_news'] = 1;

if ($_REQUEST['layout_news_category_id'] == null)
	$_REQUEST['layout_news_category_id'] = 0;

$LayoutNews = layout_news::GetLayoutNewsInfo($_REQUEST['layout_news_id']);
if ($LayoutNews['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$NextLayoutNewsListXML = layout_news::GetNextLayoutNewsXML($LayoutNews, $_REQUEST['layout_news_category_id'], $_REQUEST['tag'], $_REQUEST['security_level'], ynval($_REQUEST['include_layout_details']), $_REQUEST['no_of_adjacent_layout_news'] );
$smarty->assign('NextLayoutNewsListXML', $NextLayoutNewsListXML);

$PreviousLayoutNewsListXML = layout_news::GetPreviousLayoutNewsXML($LayoutNews, $_REQUEST['layout_news_category_id'], $_REQUEST['tag'], $_REQUEST['security_level'], ynval($_REQUEST['include_layout_details']), $_REQUEST['no_of_adjacent_layout_news'] );
$smarty->assign('PreviousLayoutNewsListXML', $PreviousLayoutNewsListXML);

$Data = $smarty->fetch('api/layout_news_get_adjacent_news_list.tpl');
$smarty->assign('Data', $Data);

$smarty->display('api/api_result.tpl');