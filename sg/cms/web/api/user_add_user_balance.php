<?php
// parameters:
//	user_id
//	amount
//	reason
//	reference_1 - Payment Gateway parameter info 

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);
	
if (doubleval($_REQUEST['amount']) > 0) {
	
	$UserBalanceLock = user::GetUserBalanceLock($User['user_id']);
	$UserBalanceLock->acquireLock(true);
	
	$UserBalance = user::GetUserBalance($User['user_id']);
	
	$UserBalancePrevious = $UserBalance;
	$UserBalanceAfter = $UserBalance + doubleval($_REQUEST['amount']);
	
	$query	=	"	INSERT INTO	user_balance " .
				"	SET		user_id				=	'" . intval($_REQUEST['user_id']) . "', " .
				"			user_balance_previous	=	'" . $UserBalancePrevious . "', " .
				"			user_balance_after	=	'" . $UserBalanceAfter . "', " .
				"			user_balance_transaction_amount	=	'" . doubleval($_REQUEST['amount']) . "', " .
				"			user_balance_transaction_type = 'recharge', " .
				"			create_date = NOW(), " .
				"			reference_1 = '" . aveEscT($_REQUEST['reference_1']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	$NewUserBalanceID = customdb::mysqli()->insert_id;
	
	unset($UserBalanceLock);

	$smarty->assign('UserBalanceID', $NewUserBalanceID);
	$smarty->assign('UserBalancePrevious', $UserBalancePrevious);
	$smarty->assign('UserBalanceAfter', $UserBalanceAfter);
	$smarty->assign('UserBalanceTransactionAmount', doubleval($_REQUEST['amount']));

	$Data = $smarty->fetch('api/user_add_user_balance.tpl');
	
	$smarty->assign('Data', $Data);
}

$smarty->display('api/api_result.tpl');