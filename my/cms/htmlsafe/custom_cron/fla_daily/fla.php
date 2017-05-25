<?php
define('IN_CMS', true);
require_once('/var/www/cmsadmin.inseducation.org/web/common/config.php');
require_once('/var/www/cmsadmin.inseducation.org/web/common/common.php');
require_once('/var/www/cmsadmin.inseducation.org/web/common/function.php');

$SiteID = 139;
$Site = site::GetSiteInfo($SiteID);
$smarty->assign('Site', $Site);

$SitemapCounter = site::GenerateStaticSitemap($SiteID, 'sitemap.xml');
//$RssCounter = site::GenerateStaticRSS($SiteID, 'rss.xml', 9999999, 'daily');