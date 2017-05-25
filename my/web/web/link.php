<?php
if (!defined('IN_CMS'))
	die(realpath(__FILE__) . " " .  __LINE__);
	
$LinkGetInfo = ApiQuery('link_get_info.php', __LINE__, 'link_id=' . $ObjectLink->object->object_link_id);

$link = $LinkGetInfo->xpath("/data/link/link_url");

if (substr($link[0], 0, 4) != 'http') {
	header( "Location: " . BASEURL . "/" . $link[0]);
}

else {
	header( "Location: " . $link[0] );
}
?>