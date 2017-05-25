<?php
define('IN_CMS', true);
require_once('/var/www/www.369cms.com/web/common/config.php');
require_once('/var/www/www.369cms.com/web/common/common.php');
require_once('/var/www/www.369cms.com/web/common/function.php');

// HKEAA
$SiteID = 42;
$Site = site::GetSiteInfo($SiteID);
$smarty->assign('Site', $Site);
$XHTML = '';

$TCLayoutNewsRootID = 38136;

$TCLayoutNewsRoot = layout_news::GetLayoutNewsRootInfo($TCLayoutNewsRootID);
$TotalNoOfLayoutNews = 0;

$LayoutNewsListXML = layout_news::GetLayoutNewsListXML($TotalNoOfLayoutNews, $TCLayoutNewsRootID, 0, '', 0, 0, 999999, 'Y', 'N', '', '');
//layout_news::GetLayoutNewsListByLayoutNewsRootID($TCLayoutNewsRootID, $TotalNewsNum, 1, 999999, '', '', '', '', '');
$smarty->assign('LayoutNewsListXML', $LayoutNewsListXML);
$smarty->assign('TotalNoOfLayoutNews', $TotalNoOfLayoutNews);
$smarty->assign('PageNo', $PageNo);
$smarty->assign('LayoutNewsTag', trim($_REQUEST['tag']));
$Data = $smarty->fetch('api/layout_news_list.tpl');

$smarty->assign('Data', $Data);
$XML = $smarty->fetch('api/api_result.tpl');

$LayoutNews = new SimpleXMLElement($XML);

foreach ($LayoutNews->layout_news_list->children() as $N) {
	$tags = explode(",", substr($Obj->layout_news_tag, 1, -2));
	$smarty->assign('tags', $tags);

	// Get File And Write Here
	$loc = 'http://' . $Site['site_address'] . '/news.php?id=' . $N->object_id;
//	$loc = 'http://' . $Site['site_address'] . object::GetSeoEncodedURL($Obj, '');
//	$theloc = 'http://' . $Site['site_address'] . object::GetSeoURL($Obj, '');
	
	$smarty->assign('pubDate', strftime ("%a, %d %b %Y %H:%M:%S %z", strtotime($N->create_date)));
	$smarty->assign('lastBuildDate', strftime ("%a, %d %b %Y %H:%M:%S %z", strtotime($N->modify_date)));
	$smarty->assign('link', $loc);
	$smarty->assign('title', $N->layout_news_title);
	
	$NewsContent = $N->xpath('layout/block_defs/block_def[object_name="BlogContent"]/block_contents/block');
	
	$smarty->assign('content', $NewsContent[0]->block_content);
	$smarty->assign('description', $NewsContent[0]->block_content);

	$XHTML = $XHTML . $smarty->fetch('sitemap/rss_item.tpl');
}

$smarty->assign('urls', $XHTML);
$RSS = $smarty->fetch('sitemap/rss.tpl');

$TmpFileName = tempnam("/tmp", "FOO");
$FP = fopen($TmpFileName, "w");

fwrite($FP, $RSS);
fclose($FP);

$smarty->assign('urls', $XHTML);
$RSS = $smarty->fetch('sitemap/rss.tpl');

$conn_id = ftp_connect($Site['site_ftp_address']);
$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password']));

$Filename = $Site['site_ftp_web_dir'] . '/rss.xml';
$upload_result = @ftp_put($conn_id, $Filename, $TmpFileName, FTP_BINARY, 0);
unlink($TmpFileName);
ftp_close($conn_id);