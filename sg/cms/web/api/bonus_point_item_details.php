<?php
// parameters:
//	bonus_point_item_id
//	lang_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$BonusPointItemXML = bonuspoint::GetBonusPointItemXML($_REQUEST['bonus_point_item_id'], $_REQUEST['lang_id']);

$smarty->assign('Data', $BonusPointItemXML);
$smarty->display('api/api_result.tpl');