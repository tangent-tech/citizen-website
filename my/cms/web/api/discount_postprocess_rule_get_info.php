<?php
// parameters:
//	rule_id
//	lang_id

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$Object = object::GetObjectInfo($_REQUEST['rule_id']);
if ($Object['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$RuleXML = discount::GetPostprocessRuleXML($_REQUEST['rule_id'], $_REQUEST['lang_id']);

$smarty->assign('Data', $RuleXML);
$smarty->display('api/api_result.tpl');