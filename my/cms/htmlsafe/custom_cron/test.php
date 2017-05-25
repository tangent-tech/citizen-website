<?php
die();
define('IN_CMS', true);
require_once('/var/www/demo.369cms.com/web/common/config.php');
require_once('/var/www/demo.369cms.com/web/common/common.php');
require_once('/var/www/demo.369cms.com/web/common/function.php');

// aveego.com
//	dialy: generate sitemap and rss.xml (with publish date)
//	hourly: generate last 20 rss (with publish date)


//$SiteID = 34;	// aveego.com
$SiteID = 1;
$Site = site::GetSiteInfo($SiteID);
$smarty->assign('Site', $Site);

$SitemapCounter = site::GenerateStaticSitemap($SiteID, 'sitemap.xml');
$RssCounter = site::GenerateStaticRSS($SiteID, 'rss2.xml', 999999);
$LatestCounter = site::GenerateStaticRSS($SiteID, 'latest.xml', 1);