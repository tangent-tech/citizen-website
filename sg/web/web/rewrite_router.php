<?php
define('IN_CMS', true);
require_once('./common/config.php');

$SeoInfo = ApiQuery('seo_get_structured_seo_url_info.php', __LINE__, 'structured_seo_url=' . $_REQUEST['structured_friendly_name']);

if (intval($SeoInfo->object_link_id) > 0)
	$_REQUEST['link_id'] = $SeoInfo->object_link_id;

$_REQUEST['id'] = $SeoInfo->object_id;
$_REQUEST['lang_id'] = $SeoInfo->language_id;

require_once('load.php');

?>