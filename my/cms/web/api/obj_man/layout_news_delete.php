<?php
// layout_news_id
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if ($Site['site_module_objman_enable'] != 'Y')
	APIDie(array('desc' => 'Module ObjMan is not enabled'));

$LayoutNews = layout_news::GetLayoutNewsInfo($_REQUEST['layout_news_id']);
if ($LayoutNews['site_id'] != $Site['site_id'])
	APIDie(array('desc' => 'Invalid layout_news_id'));

layout_news::DeleteLayoutNews($_REQUEST['layout_news_id'], $Site);

site::EmptyAPICache($Site['site_id']);

$smarty->display('api/api_result.tpl');