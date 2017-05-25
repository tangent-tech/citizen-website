<?php
// parameters:
//	link_id
//	security_level
//	page_no
//	news_per_page
//	tag
//	news_category_id - Optional
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$NewsPage = news::GetNewsPageInfo($ObjectLink['object_id']);

$NewsRoot = news::GetNewsRootInfo($NewsPage['news_root_id']);
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
}
$smarty->assign('NewsCategoryXML', $NewsCategoryXML);

$PageNo = intval($_REQUEST['page_no']);
$NewsPerPage = intval($_REQUEST['news_per_page']);

$Offset = ($PageNo -1) * $NewsPerPage;

$TotalNoOfNews = 0;
$NewsListXML = news::GetNewsListXML($TotalNoOfNews, $NewsPage['news_root_id'], $NewsPage['news_category_id'], $_REQUEST['tag'], $_REQUEST['security_level'], $Offset, $NewsPerPage);
$NewsPage['object_seo_url'] = object::GetSeoURL($NewsPage, '', $NewsPage['language_id'], $Site);
$smarty->assign('Object', $NewsPage);
$smarty->assign('NewsListXML', $NewsListXML);
$smarty->assign('TotalNoOfNews', $TotalNoOfNews);
$smarty->assign('PageNo', $PageNo);
$Data = $smarty->fetch('api/object_info/NEWS_PAGE.tpl');

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');