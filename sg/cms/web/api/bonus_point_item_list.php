<?php
// parameters:
//	lang_id
//	security_level
//	user_id
//	currency_id
//	maximum_bonus_point_required
//	order_by_bonus_point: desc / asc
//	cart_content_type - normal / bonus_point 

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if (!in_array($_REQUEST['cart_content_type'], $ValidApiCartContentType))
	$_REQUEST['cart_content_type'] = 'normal';

//$BonusPointItemListXML = bonuspoint::GetBonusPointItemListXML($Site['site_id'], $_REQUEST['lang_id'], $_REQUEST['security_level']);
if (intval($_REQUEST['currency_id']) == 0)
	$_REQUEST['currency_id'] = $Site['site_default_currency_id'];

if (!isset($_REQUEST['maximum_bonus_point_required']))
	$_REQUEST['maximum_bonus_point_required'] = 999999;

$BonusPointItemListXML = cart_v2::GetBonusPointItemListWithCartQuantityXML($Site['site_id'], $_REQUEST['user_id'], $_REQUEST['currency_id'], $_REQUEST['lang_id'], $_REQUEST['security_level'], $_REQUEST['cart_content_type'], 'Y', intval($_REQUEST['maximum_bonus_point_required']), trim($_REQUEST['order_by_bonus_point']));

$smarty->assign('Data', $BonusPointItemListXML);
$smarty->display('api/api_result.tpl');