<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_member.php');
require_once('../common/header_bonus_point.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_member_bonuspoint_manage", __FILE__, false);

$smarty->assign('CurrentTab', 'member');
$smarty->assign('MyJS', 'member_bonuspoint_add_coupon');

$User = user::GetUserInfo($_REQUEST['id']);

if ($User['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'member_list.php', __LINE__);
$smarty->assign('User', $User);

$UserDatafileHolder = user::GetUserDatafileHolderByUserID($_REQUEST['id']);
acl::ObjPermissionBarrier("edit", $UserDatafileHolder, __FILE__, false);

//if (intval($_REQUEST['user_bonuspoint_coupon_value']) <= 0)
//	AdminDie(ADMIN_ERROR_BONUS_POINT_COUPON_INVALID_VALUE, 'member_edit.php?id=' . $_REQUEST['id'], __LINE__);

if (intval($_REQUEST['user_bonuspoint_coupon_value']) > 0) {
	
	$query	=	"	INSERT INTO	user_bonus_point " .
				"	SET		user_id				=	'" . intval($_REQUEST['id']) . "', " .
				"			system_admin_id		=	'" . intval($_SESSION['SystemAdminID']) . "', " .
				"			content_admin_id	=	'" . intval($_SESSION['ContentAdminID']) . "', " . 
				"			bonus_point_amount_previous	=	'" . intval($User['user_bonus_point']) . "', " .
				"			bonus_point_amount_after	=	'" . intval($User['user_bonus_point'] + intval($_REQUEST['user_bonuspoint_coupon_value'])) . "', " .
				"			bonus_point_earned	=	'" . intval($_REQUEST['user_bonuspoint_coupon_value']) . "', " .
				"			bonus_point_used	=	0, " .
				"			earn_type			=	'coupon', " .
				"			expiry_date			= '" . aveEscT($_REQUEST['user_bonuspoint_coupon_expiry_date']) . "', " .
				"			create_date			= NOW(), " .
				"			bonus_point_reason	= '" . aveEscT($_REQUEST['bonus_point_reason']) .  "' ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$NewID = customdb::mysqli()->insert_id;

	// Add this for expiration! If the bonus point is earned by adjustment, myorder = user_bonus_point_id
	$query	=	"	UPDATE	user_bonus_point " .
				"	SET		myorder_id			=	user_bonus_point_id " .
				"	WHERE	user_bonus_point_id = '" . $NewID . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
elseif (intval($_REQUEST['user_bonuspoint_coupon_value']) < 0) {

	user::DeduceUserBonusPoint($User['user_id'], intval($_REQUEST['user_bonuspoint_coupon_value'] * -1), 0, 'coupon', trim($_REQUEST['bonus_point_reason']), $_SESSION['SystemAdminID'], $_SESSION['ContentAdminID']);
}

// site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: member_edit.php?id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));