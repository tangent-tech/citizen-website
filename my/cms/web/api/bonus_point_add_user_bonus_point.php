<?php
// parameters:
//	user_id
//	amount
//	reason
//	expiry_date - use site default if not expired / no need if amount < 0
//	custom_reference_no
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);
	
if (intval($_REQUEST['amount']) > 0) {
	
	$sql = " expiry_date = '" . custom::GetBonusPointExpiryDate($Site, time()) . "', ";
//	$sql = " expiry_date = DATE_ADD(NOW(), INTERVAL ". $Site['site_bonus_point_valid_days'] ." DAY), ";
	if (trim($_REQUEST['expiry_date']) != '') {
		$sql = "expiry_date = '" . trim($_REQUEST['expiry_date']) . "', ";
	}
		
	$query	=	"	INSERT INTO	user_bonus_point " .
				"	SET		user_id				=	'" . intval($_REQUEST['user_id']) . "', " .
				"			bonus_point_amount_previous	=	'" . intval($User['user_bonus_point']) . "', " .
				"			bonus_point_amount_after	=	'" . intval($User['user_bonus_point'] + intval($_REQUEST['amount'])) . "', " .
				"			bonus_point_earned	=	'" . intval($_REQUEST['amount']) . "', " .
				"			bonus_point_used	=	0, " .	
				"			bonus_point_spent	=	0, " .
				"			earn_type			=	'custom', " . $sql .
				"			create_date			= NOW(), " .
				"			bonus_point_reason	=	'" . aveEscT($_REQUEST['reason']) . "', " .
				"			custom_reference_no	=	'" . aveEscT($_REQUEST['custom_reference_no']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	$NewID = customdb::mysqli()->insert_id;

	// Add this for expiration! If the bonus point is earned by adjustment, myorder = user_bonus_point_id
	$query	=	"	UPDATE	user_bonus_point " .
				"	SET		myorder_id			=	user_bonus_point_id " .
				"	WHERE	user_bonus_point_id = '" . $NewID . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
else if (intval($_REQUEST['amount']) < 0) {
	user::DeduceUserBonusPoint(intval($_REQUEST['user_id']), intval($_REQUEST['amount']) * -1, 0, 'custom', trim($_REQUEST['reason']), 0, 0, trim($_REQUEST['custom_reference_no']));	
}
	
$smarty->display('api/api_result.tpl');