<?php
// parameters:
//	news_root_id
//	news_category_id - 0 for all
//	security_level
//	page_no
//	news_per_page
//	tag
//  date_search - default is 'N'
//  date_from
//  date_to
//	include_news_content - default is 'N'
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$NewsRoot = news::GetNewsRootInfo($_REQUEST['news_root_id']);
if ($NewsRoot['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);
$NewsRoot['object_seo_url'] = object::GetSeoURL($NewsRoot, '', $NewsRoot['language_id'], $Site);
$smarty->assign('Object', $NewsRoot);
$NewsRootXML = $smarty->fetch('api/object_info/NEWS_ROOT.tpl');
$smarty->assign('NewsRootXML', $NewsRootXML);

$NewsCategoryXML = '';
if ($_REQUEST['news_category_id'] != 0) {
	$NewsCategory = news::GetNewsCategoryInfo($_REQUEST['news_category_id']);
	$NewsCategory['object_seo_url'] = object::GetSeoURL($NewsCategory, '', $NewsCategory['language_id'], $Site);
	$smarty->assign('Object', $NewsCategory);
	$NewsCategoryXML = $smarty->fetch('api/object_info/NEWS_CATEGORY.tpl');

	if ($NewsCategory['site_id'] != $Site['site_id'])
		APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);
}
$smarty->assign('NewsCategoryXML', $NewsCategoryXML);

$PageNo = intval($_REQUEST['page_no']);
$NewsPerPage = intval($_REQUEST['news_per_page']);

$Offset = ($PageNo -1) * $NewsPerPage;

$TotalNoOfNews = 0;
$NewsListXML = news::GetNewsListXML($TotalNoOfNews, $_REQUEST['news_root_id'], $_REQUEST['news_category_id'], $_REQUEST['tag'], $_REQUEST['security_level'], $Offset, $NewsPerPage, ynval($_REQUEST['date_search']), $_REQUEST['date_from'], $_REQUEST['date_to'], ynval($_REQUEST['include_news_content']));
$smarty->assign('NewsListXML', $NewsListXML);
$smarty->assign('TotalNoOfNews', $TotalNoOfNews);
$smarty->assign('PageNo', $PageNo);
$smarty->assign('NewsTag', trim($_REQUEST['tag']));
$Data = $smarty->fetch('api/news_list.tpl');

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');