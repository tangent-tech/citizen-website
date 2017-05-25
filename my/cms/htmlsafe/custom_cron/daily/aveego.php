<?php
define('IN_CMS', true);
require_once('/var/www/www.369cms.com/web/common/config.php');
require_once('/var/www/www.369cms.com/web/common/common.php');
require_once('/var/www/www.369cms.com/web/common/function.php');

// aveego.com
//	dialy: generate sitemap and rss.xml (with publish date)
//	hourly: generate last 20 rss (with publish date)


$SiteID = 34;	// aveego.com
$Site = site::GetSiteInfo($SiteID);
$smarty->assign('Site', $Site);

$SitemapCounter = site::GenerateStaticSitemap($SiteID, 'sitemap.xml');
$RssCounter = site::GenerateStaticRSS($SiteID, 'rss.xml', 9999999, 'daily');