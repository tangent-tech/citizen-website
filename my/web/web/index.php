<?php
define('IN_CMS', true);

require_once('./common/config.php');
require_once('./common/common.php');

$ObjectLink = ApiQuery('object_link_get_info.php', __LINE__, 'link_id=' . $CurrentLang->language_root->index_link_id);

header( "HTTP/1.1 301 Moved Permanently" );
header( "Location: " . BASEURL . $ObjectLink->object->object_seo_url );
?>