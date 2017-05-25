<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_discount_rule.php');

$smarty->assign('CurrentTab', 'discount_rule');
$smarty->assign('CurrentTab2', 'discount_preprocess_rule_list');
$smarty->assign('MyJS', 'discount_preprocess_rule_add_act');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

$RuleID = object::NewObject('DISCOUNT_PREPROCESS_RULE', $_SESSION['site_id'], $_REQUEST['object_security_level'], $ObjectArchiveDateText, $ObjectPublishDateText, $_REQUEST['object_is_enable']);
discount::NewPreprocessRule($RuleID, $_REQUEST['discount_preprocess_rule_discount_code']);

$DiscountCode = explode(",", $_REQUEST['discount_preprocess_rule_discount_code']);
$DiscountCodeText = ', ';
foreach ($DiscountCode as $T)
	$DiscountCodeText = $DiscountCodeText . trim($T) . ", ";

$query =	"	UPDATE	discount_preprocess_rule " .
			"	SET		discount_preprocess_rule_discount_code				= '" . aveEscT($DiscountCodeText) . "', " .
			"			discount_preprocess_rule_stop_process_below_rules	= '" . ynval($_REQUEST['discount_preprocess_rule_stop_process_below_rules']) . "' " .
			"	WHERE	discount_preprocess_rule_id = '" . $RuleID . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::NewObjectLink($Site['library_root_id'], $RuleID, trim($_REQUEST['object_name']), 0, 'normal', DEFAULT_ORDER_ID);
discount::UpdateTimeStamp($RuleID);
object::TidyUpObjectOrder($Site['library_root_id'], 'DISCOUNT_PREPROCESS_RULE');

foreach ($SiteLanguageRoots as $R)
	discount::NewPreprocessRuleData($RuleID, $R['language_id'], $_REQUEST['discount_preprocess_rule_name'][$R['language_id']]);

header( 'Location: discount_preprocess_rule_edit.php?id=' . $RuleID .  '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));