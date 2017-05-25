<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_xml_discount_rule.php');

header ("Content-Type:text/xml");

$RuleIDList = $_REQUEST[$_REQUEST['table_id']];
$RuleList = array();
foreach ($RuleIDList as $rid) {
	if ($rid != null) {
		$Rule = discount::GetPreprocessRuleInfo($rid, 0);
		if ($Rule['site_id'] != $_SESSION['site_id'])
			XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
		$RuleList[$rid] = $Rule;
	}
}

$orderid = 1;
foreach ($RuleIDList as $rid) {
	if ($rid != null) {
		$query =	"	UPDATE	object_link " .
					"	SET		order_id = '" . $orderid++ . "'" .
					"	WHERE	object_link_id	= '" . intval($RuleList[$rid]['object_link_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', 'ok');
$smarty->assign('msg', ADMIN_MSG_UPDATE_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/discount_preprocess_rule_sort.tpl');