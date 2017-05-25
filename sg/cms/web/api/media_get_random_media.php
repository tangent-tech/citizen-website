<?php
// parameters:
//	lang_id
//	no_of_media
//	media_type - a comma seperated string of (gif, jpg, png, avi, wmv, mov, mpg, mp3, wma, ra), empty string for everything
//	security_level
//	parent_type - album / product
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if (intval($_REQUEST['no_of_media']) < 1)
	$_REQUEST['no_of_media'] = 1;

$MediaTypeArray = null;
if (trim($_REQUEST['media_type']) != '') {
	$MediaTypeArray = explode(',', $_REQUEST['media_type']);
	if (count($MediaTypeArray) > 0) {
		foreach ($MediaTypeArray as &$M)
			$M = trim($M);
	}
}

$MediaXML = media::GetRandomMediaXML($Site['site_id'], $_REQUEST['lang_id'], $_REQUEST['security_level'], $_REQUEST['no_of_media'], $MediaTypeArray, $_REQUEST['parent_type']);
$MediaXML = '<media_list>' . $MediaXML . '</media_list>';

$smarty->assign('Data', $MediaXML);
$smarty->display('api/api_result.tpl');