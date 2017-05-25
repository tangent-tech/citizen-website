<?php
if (!defined('IN_CMS'))
	define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');

$Paras = array();
if (isset($_REQUEST['friendly_name']))
	$Paras = explode('_', $_REQUEST['para']);

$ObjectLink = null;
if (isset($_REQUEST['link_id'])) {
	$ObjectLink = $localCache->getCache('xmlCacheObjectLinkGetInfo', array('link_id' => $_REQUEST['link_id']), false);
	$smarty->assign('ObjectLink', $ObjectLink);
}
elseif (isset($_REQUEST['id'])) {
	$ObjectLink = $localCache->getCache('xmlCacheObjectInfo', array( 'id' => $_REQUEST['id']), false);
	$smarty->assign('ObjectLink', $ObjectLink);
}

/*
if (urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) != $ObjectLink->object->object_seo_url) {
	header( "HTTP/1.1 301 Moved Permanently" );
	header( "Location: " . BASEURL . $ObjectLink->object->object_seo_url);
	exit();
}
*/

if ($ObjectLink == null || intval($ObjectLink->object->object_id) < 1) {
	header( "HTTP/1.1 404 Not Found" );
	die();
}

if( intval($ObjectLink->object->object_security_level) > intval($SessionUserSecurityLevel))
	UserDie('Security Level Error');

if (intval($ObjectLink->object->language_id) != 0)
	$CurrentLang = language::SetCurrentLanguage($ObjectLink->object->language_id);

$Result = ApiQuery('object_counter_increment.php', __LINE__,
						'object_id=' . $ObjectLink->object->object_id);
if ($ObjectLink->object->object_type == 'FOLDER')
	require_once('folder.php');
elseif ($ObjectLink->object->object_type == 'PAGE')
	require_once('page.php');
elseif ($ObjectLink->object->object_type == 'LINK')
	require_once('link.php');
elseif ($ObjectLink->object->object_type == 'PRODUCT_CATEGORY')
	require_once('product_category.php');
elseif ($ObjectLink->object->object_type == 'PRODUCT_ROOT' || $ObjectLink->object->object_type == 'PRODUCT_ROOT_LINK')
	require_once('product_root.php');
elseif ($ObjectLink->object->object_type == 'PRODUCT')
	require_once('product.php');
//elseif ($ObjectLink->object->object_type == 'ALBUM')
//	require_once('album.php');
//elseif ($ObjectLink->object->object_type == 'NEWS_PAGE')
//	require_once('news_page.php');
//elseif ($ObjectLink->object->object_type == 'NEWS_CATEGORY')
//	require_once('news_category.php');
//elseif ($ObjectLink->object->object_type == 'NEWS')
//	require_once('news.php');
elseif ($ObjectLink->object->object_type == 'LAYOUT_NEWS_PAGE')
	require_once('layout_news_page.php');
elseif ($ObjectLink->object->object_type == 'LAYOUT_NEWS')
	require_once('layout_news.php');
else
	echo $ObjectLink->object->object_type;
?>