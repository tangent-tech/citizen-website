<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_member.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");
acl::AclBarrier("acl_member_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'member');

$User = user::GetUserInfo($_REQUEST['id']);
if ($User['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR . $User['site_id'], 'member_list.php', __LINE__);

$UserDatafileHolder = user::GetUserDatafileHolderByUserID($_REQUEST['id']);
acl::ObjPermissionBarrier("edit", $UserDatafileHolder, __FILE__, false);

$ErrorMessage = '';
if (trim($_REQUEST['user_password']) != '') {
	if (IsValidPassword($ErrorMessage, $_REQUEST['user_password'], $_REQUEST['user_password2'])) {

		$hash = password_hash(trim($_REQUEST['user_password']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));
		
		$query  =	" 	UPDATE	user " .
					"	SET		user_password = '" . aveEscT($hash) . "'" .
					"	WHERE	user_id = '" . intval($_REQUEST['id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

if (trim($_REQUEST['user_username']) == '')
	$ErrorMessage = ADMIN_ERROR_INVALID_USERNAME;
elseif (user::IsDuplicateUsername($_REQUEST['user_username'], $_REQUEST['id'], $_SESSION['site_id']))
	$ErrorMessage = ADMIN_ERROR_USERNAME_ALREADY_EXIST;
else {
	$query  =	" 	UPDATE	user " .
				"	SET		user_username = '" . aveEscT($_REQUEST['user_username']) . "'" .
				"	WHERE	user_id = '" . intval($_REQUEST['id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

if (trim($_REQUEST['user_email']) != '') {
	if (!IsValidEmail($_REQUEST['user_email']))
		$ErrorMessage = ADMIN_ERROR_INVALID_EMAIL;
	else {
		$query  =	" 	UPDATE	user " .
					"	SET		user_email = '" . aveEscT($_REQUEST['user_email']) . "'" .
					"	WHERE	user_id = '" . intval($_REQUEST['id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

$UserInfoErrorCheckFail = false;
if (language::GetSiteLanguageRoot($_REQUEST['user_language_id'], $_SESSION['site_id']) == null)
	$UserInfoErrorCheckFail = true;

if (currency::GetCurrencyInfo($_REQUEST['user_currency_id'], $_SESSION['site_id']) == null)
	$UserInfoErrorCheckFail = true;
	
if ($UserInfoErrorCheckFail)
	$ErrorMessage = ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR;
else {
	$sql = GetCustomTextSQL("user", "int") . GetCustomTextSQL("user", "double") . GetCustomTextSQL("user", "date") . GetCustomTextSQL("user", "text");
	if (strlen($sql) > 0)
		$sql = ", " . substr($sql, 0, -1);
	
	$query =	"	UPDATE	user " .
				"	SET		user_is_enable			= '" . ynval($_REQUEST['user_is_enable']) . "', " .
				"			user_security_level		= '" . intval($_REQUEST['user_security_level']) . "', " .
				"			user_language_id		= '" . intval($_REQUEST['user_language_id']) . "', " .
				"			user_currency_id		= '" . intval($_REQUEST['user_currency_id']) . "', " .
				"			user_first_name			= '" . aveEscT($_REQUEST['user_first_name']) . "', " .
				"			user_last_name			= '" . aveEscT($_REQUEST['user_last_name']) . "', " .
				"			user_title				= '" . aveEscT($_REQUEST['user_title']) . "', " .
				"			user_company_name		= '" . aveEscT($_REQUEST['user_company_name']) . "', " .
				"			user_city_name			= '" . aveEscT($_REQUEST['user_city_name']) . "', " .
				"			user_region				= '" . aveEscT($_REQUEST['user_region']) . "', " .
				"			user_postcode			= '" . aveEscT($_REQUEST['user_postcode']) . "', " .
				"			user_address_1			= '" . aveEscT($_REQUEST['user_address_1']) . "', " .
				"			user_address_2			= '" . aveEscT($_REQUEST['user_address_2']) . "', " .
				"			user_country_id			= '" . intval($_REQUEST['user_country_id']) . "', " .
				"			user_country_other		= '" . aveEscT($_REQUEST['user_country_other']) . "', " .
				"			user_hk_district_id		= '" . intval($_REQUEST['user_hk_district_id']) . "', " .
				"			user_tel_country_code	= '" . aveEscT($_REQUEST['user_tel_country_code']) . "', " .
				"			user_tel_area_code		= '" . aveEscT($_REQUEST['user_tel_area_code']) . "', " .
				"			user_tel_no				= '" . aveEscT($_REQUEST['user_tel_no']) . "', " .
				"			user_fax_country_code	= '" . aveEscT($_REQUEST['user_fax_country_code']) . "', " .
				"			user_fax_area_code		= '" . aveEscT($_REQUEST['user_fax_area_code']) . "', " .
				"			user_fax_no				= '" . aveEscT($_REQUEST['user_fax_no']) . "', " .
				"			user_join_mailinglist	= '" . ynval($_REQUEST['user_join_mailinglist']) . "', " .
				"			user_is_email_verify	= '" . ynval($_REQUEST['user_is_email_verify']) . "', " .
				"			user_note				= '" . aveEscT($_REQUEST['user_note']) . "' " . $sql .
				"	WHERE	user_id					= '" . intval($_REQUEST['id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$UserDatafileHolder = user::GetUserDatafileHolderByUserID($_REQUEST['id']);
	
	object::UpdateObjectPermission($UserDatafileHolder['object_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));
	
}

if (trim($Site['site_member_status_change_callback_url']) != '' ) {
	$Trigger = false;
	$MemberStatus = '';
	
	if ($User['user_is_enable'] == 'Y' && ynval($_REQUEST['user_is_enable']) == 'N') {
		$Trigger = true;
		$MemberStatus = 'member_disabled';
	}
	elseif ($User['user_is_enable'] == 'N' && ynval($_REQUEST['user_is_enable']) == 'Y') {
		$Trigger = true;
		$MemberStatus = 'member_enabled';
	}

	if ($Trigger) {	
		$URL = trim($Site['site_member_status_change_callback_url']) . '?user_id=' . $_REQUEST['id'] . '&status=' . $MemberStatus;
		
		$Para = array();
		$Para['id_1'] = $_REQUEST['id'];
		$Para['string_1'] = $MemberStatus;
		site::CallbackExec($Site, $URL, $Para);
	}
}

if ($_REQUEST['remove_thumbnail'] == 'Y')
	user::RemoveUserThumbnail ($User, $Site);

// Handle Highlight File
if (isset($_FILES['user_file']) && $_FILES['user_file']['size'] > 0) {
	$Site = site::GetSiteInfo($_SESSION['site_id']);
	if (user::UpdateUserThumbnail($User, $Site, $_FILES['user_file'], $Site['site_product_media_small_width'], $Site['site_product_media_small_height']) === false)
		$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;
}

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: member_edit.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));