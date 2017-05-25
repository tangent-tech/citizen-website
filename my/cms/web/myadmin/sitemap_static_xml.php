<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_article.php');

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'language_root_list');

$Counter = site::GenerateStaticSitemap($_SESSION['site_id']);
$smarty->assign('Counter', $Counter);

$SitemapURL = 'http://' . $Site['site_address'] . '/sitemap.xml';
$smarty->assign('SitemapURL', $SitemapURL);

$RssCounter = site::GenerateStaticRSS($_SESSION['site_id']);
$smarty->assign('RSSCounter', $RSSCounter);

$RssURL = 'http://' . $Site['site_address'] . '/rss.xml';
$smarty->assign('RssURL', $RssURL);

$smarty->assign('TITLE', 'XML Sitemap Generation');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/sitemap_static_xml.tpl');