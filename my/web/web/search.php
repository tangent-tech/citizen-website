<?php
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');
require_once('content_common.php');

if(intval($_REQUEST["page_no"]) < 1)
	$_REQUEST["page_no"] = 1;
$smarty->assign('PageNo', $_REQUEST["page_no"]);

if(trim($_REQUEST["search_type"]) == "product")
	$_REQUEST["search_type"] = 'product';
else if(trim($_REQUEST["search_type"]) == "layout_news")
	$_REQUEST["search_type"] = 'layout_news';
else if(trim($_REQUEST["search_type"]) == "page")
	$_REQUEST["search_type"] = 'page';
else
	$_REQUEST["search_type"] = 'all';

$SearchResult = ApiQuery('search.php', __LINE__,
						 'search_text=' . urlencode(trim($_REQUEST['search_text'])) .
						 '&object_type=' . urlencode(trim($_REQUEST["search_type"])) . 
						 '&page_no=' . $_REQUEST['page_no'] .
						 '&objects_per_page=' . SEARCH_OBJECTS_PER_PAGE .
						 '&security_level=' . $SessionUserSecurityLevel . 
						 '&lang_id=' . $CurrentLang->language_root->language_id .
						 '&currency_id=' . $CurrentCurrency->currency->currency_id
						 );
$smarty->assign('SearchResult', $SearchResult);

$TotalItems = intval($SearchResult->total_no_of_objects);
$PageNoSelection = array();
$PageNoSelection[1] = 1;
$TotalPageNo = ceil( $TotalItems / SEARCH_OBJECTS_PER_PAGE);
$smarty->assign('TotalPageNo', $TotalPageNo);

for ($i = 2; $i <= $TotalPageNo; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$MinOffSet = (($_REQUEST["page_no"] - 1) * SEARCH_OBJECTS_PER_PAGE) + 1;
$smarty->assign('MinOffSet', $MinOffSet);

$MaxOffSet = ($_REQUEST["page_no"] * SEARCH_OBJECTS_PER_PAGE);
if($MaxOffSet > $TotalItems)
	$MaxOffSet = $TotalItems;
$smarty->assign('MaxOffSet', $MaxOffSet);

$smarty->assign('MyJS', 'Search');
$smarty->assign('PageTitle', '');

$smarty->display($CurrentLang->language_root->language_id . '/search.tpl');
?>