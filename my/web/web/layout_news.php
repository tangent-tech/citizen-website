<?php
if (!defined('IN_CMS'))
	die(realpath(__FILE__) . " " .  __LINE__);

require_once('content_common.php');

$LayoutNews = ApiQuery('layout_news_get_info.php', __LINE__, 'layout_news_id=' . urlencode($ObjectLink->object->object_id));
$smarty->assign('LayoutNews', $LayoutNews);

if(isset($_REQUEST["lid"]) && intval($_REQUEST["lid"]) > 0){

	$NewsList = ApiQuery('layout_news_page_get_info.php', __LINE__,
						 'link_id=' . $_REQUEST["lid"] . 
						 '&page_no=' . 1 .
						 '&layout_news_per_page=' . 0 .
						 '&security_level=' . $SessionUserSecurityLevel
						 );
	$smarty->assign('NewsList', $NewsList);
	
	if(intval($NewsList->object_link_id) != IMPORTANT_NOTICES_LAYOUT_NEWS_ROOT_LINK_ID){
		$_REQUEST["year"] = date("Y", strtotime(strval($LayoutNews->layout_news->layout_news_date)));
	}
	else {
		
		//For Page Path
		$NewsInfo = ApiQuery('layout_news_page_get_info.php', __LINE__,
							 'link_id=' . LAYOUT_NEWS_ROOT_LINK_ID . 
							 '&page_no=' . 1 .
							 '&layout_news_per_page=' . 0 .
							 '&security_level=' . $SessionUserSecurityLevel
							 );
		$smarty->assign('NewsInfo', $NewsInfo);
		
	}

}

//$ImportantNotices = ApiQuery('layout_news_page_get_info.php', __LINE__,
//							 'link_id=' . IMPORTANT_NOTICES_LAYOUT_NEWS_ROOT_LINK_ID . 
//							 '&page_no=' . 1 .
//							 '&layout_news_per_page=' . 0 .
//							 '&security_level=' . $SessionUserSecurityLevel . 
//							 '&include_layout_details=N'
//							 );
//$smarty->assign('ImportantNotices', $ImportantNotices);

$smarty->assign('MyJS', 'LayoutNews');
$smarty->assign('PageTitle', $LayoutNews->layout_news->layout_news_title);

require_once('footer.php');

$smarty->display($CurrentLang->language_root->language_id . '/layout_news.tpl');
?>