<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_member.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_member_balance_manage", __FILE__, false);

$smarty->assign('CurrentTab', 'member');
$smarty->assign('MyJS', 'member_balance_adjust');

$User = user::GetUserInfo($_REQUEST['id']);

if ($User['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'member_list.php', __LINE__);
$smarty->assign('User', $User);

$UserDatafileHolder = user::GetUserDatafileHolderByUserID($_REQUEST['id']);
acl::ObjPermissionBarrier("edit", $UserDatafileHolder, __FILE__, false);

//if (intval($_REQUEST['user_bonuspoint_coupon_value']) <= 0)
//	AdminDie(ADMIN_ERROR_BONUS_POINT_COUPON_INVALID_VALUE, 'member_edit.php?id=' . $_REQUEST['id'], __LINE__);

if (doubleval($_REQUEST['user_balance_transaction_amount']) != 0) {
	
	$UserBalanceLock = user::GetUserBalanceLock($User['user_id']);
	$UserBalanceLock->acquireLock(true);
	
	$UserBalance = user::GetUserBalance($User['user_id']);
	
	$UserBalancePrevious = $UserBalance;
	$UserBalanceAfter = $UserBalance + doubleval($_REQUEST['user_balance_transaction_amount']);

	$query	=	"	INSERT INTO	user_balance " .
				"	SET		user_id				=	'" . intval($User['user_id']) . "', " .
				"			system_admin_id		=	'" . intval($_SESSION['SystemAdminID']) . "', " .
				"			content_admin_id	=	'" . intval($_SESSION['ContentAdminID']) . "', " . 						
				"			user_balance_previous	=	'" . doubleval($UserBalancePrevious) . "', " .
				"			user_balance_after	=	'" . doubleval($UserBalanceAfter) . "', " .
				"			user_balance_transaction_amount	=	'" . doubleval($_REQUEST['user_balance_transaction_amount']) . "', " .
				"			user_balance_transaction_type = 'adjustment', " .
				"			create_date = NOW(), " .
				"			user_balance_remark =	'" . aveEscT($_REQUEST['user_balance_remark']) . "' ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	unset($UserBalanceLock);
}

header( 'Location: member_edit.php?id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));