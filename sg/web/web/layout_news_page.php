<?php
if (!defined('IN_CMS'))
	die(realpath(__FILE__) . " " .  __LINE__);

require_once('content_common.php');

$localCache = customLocalCache::Singleton();
$ObjectLinkPath = $localCache->getCache('xmlCacheObjlinkGetPath', array('link_id' => intval($ObjectLink->object->object_link_id)), false);
$smarty->assign('ObjectLinkPath', $ObjectLinkPath);

if ($ObjectLink->object->object_link_id == LAYOUT_NEWS_ROOT_LINK_ID) {
	
	if(!isset($_REQUEST["year"]) || intval($_REQUEST["year"]) < 1)
		$_REQUEST["year"] = date("Y");
	
	$NewsList = $localCache->getCache('xmlCacheLayoutNewsPageGetInfoAll', array('link_id' => intval($ObjectLink->object->object_link_id), 'year' => strval($_REQUEST["year"])), $allowOutdated);
	$smarty->assign('NewsList', $NewsList);
	
//	$ImportantNotices = ApiQuery('layout_news_page_get_info.php', __LINE__,
//								 'link_id=' . IMPORTANT_NOTICES_LAYOUT_NEWS_ROOT_LINK_ID . 
//								 '&page_no=' . 1 .
//								 '&layout_news_per_page=' . 0 .
//								 '&security_level=' . $SessionUserSecurityLevel . 
//								 '&include_layout_details=N'
//								 );
//	$smarty->assign('ImportantNotices', $ImportantNotices);
	
	$OtherNewsList = ApiQuery('layout_news_page_get_info.php', __LINE__,
							  'link_id=' . OTHER_LAYOUT_NEWS_ROOT_LINK_ID . 
							  '&page_no=' . 1 .
							  '&layout_news_per_page=' . OTHER_LAYOUT_NEWS_PER_PAGE .
							  '&security_level=' . $SessionUserSecurityLevel . 
							  '&include_layout_details=Y'
							  );
	$smarty->assign('OtherNewsList', $OtherNewsList);

	$smarty->assign('MyJS', 'LayoutNewsPage');
	$smarty->assign('PageTitle', $NewsList->object_name);
	
	$smarty->display($CurrentLang->language_root->language_id . '/layout_news_page.tpl');
}

else if ( 1 > 2 && $ObjectLink->object->object_link_id == IMPORTANT_NOTICES_LAYOUT_NEWS_ROOT_LINK_ID) {
	
	$NewsList = ApiQuery('layout_news_page_get_info.php', __LINE__,
						 'link_id=' . $ObjectLink->object->object_link_id . 
						 '&page_no=' . 1 .
						 '&layout_news_per_page=' . 999 .
						 '&security_level=' . $SessionUserSecurityLevel . 
						 '&include_layout_details=Y'
						 );
	$smarty->assign('NewsList', $NewsList);
	
	$ImportantNotices = ApiQuery('layout_news_page_get_info.php', __LINE__,
								 'link_id=' . IMPORTANT_NOTICES_LAYOUT_NEWS_ROOT_LINK_ID . 
								 '&page_no=' . 1 .
								 '&layout_news_per_page=' . 0 .
								 '&security_level=' . $SessionUserSecurityLevel . 
								 '&include_layout_details=N'
								 );
	$smarty->assign('ImportantNotices', $ImportantNotices);
	
	//For Page Path
	$NewsInfo = ApiQuery('layout_news_page_get_info.php', __LINE__,
						 'link_id=' . LAYOUT_NEWS_ROOT_LINK_ID . 
						 '&page_no=' . 1 .
						 '&layout_news_per_page=' . 0 .
						 '&security_level=' . $SessionUserSecurityLevel
						 );
	$smarty->assign('NewsInfo', $NewsInfo);
	
	$smarty->assign('MyJS', 'LayoutNewsPage');
	$smarty->assign('PageTitle', $NewsList->object_name);
	
	$smarty->display($CurrentLang->language_root->language_id . '/layout_news_page.tpl');
}
?>