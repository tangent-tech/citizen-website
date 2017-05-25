<?php
// parameters: link_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$Object = object::GetObjectLinkInfo($_REQUEST['link_id']);
$Object['object_seo_url'] = object::GetSeoURL($Object, '', $Object['language_id'], $Site);
$smarty->assign('Object', $Object);
$xml = $smarty->fetch('api/object_info/OBJECT.tpl');
$smarty->assign('Data', $xml);
$smarty->display('api/api_result.tpl');