<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_member.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");
acl::AclBarrier("acl_member_add", __FILE__, false);

$smarty->assign('CurrentTab', 'member');

$ErrorMessage = '';
IsValidPassword($ErrorMessage, $_REQUEST['user_password'], $_REQUEST['user_password2']);

if (trim($_REQUEST['user_username']) == '')
	$ErrorMessage = ADMIN_ERROR_INVALID_USERNAME;
elseif (user::IsDuplicateUsername($_REQUEST['user_username'], 0, $_SESSION['site_id']))
	$ErrorMessage = ADMIN_ERROR_USERNAME_ALREADY_EXIST;

if (trim($_REQUEST['user_email']) != '') {
	if (!IsValidEmail($_REQUEST['user_email']))
		$ErrorMessage = ADMIN_ERROR_INVALID_EMAIL;
}

if (language::GetSiteLanguageRoot($_REQUEST['user_language_id'], $_SESSION['site_id']) == null)
	$ErrorMessage = ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR;
if ($_REQUEST['user_currency_id'] != 0 && currency::GetCurrencyInfo($_REQUEST['user_currency_id'], $_SESSION['site_id']) == null)
	$ErrorMessage = ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR;

if ($ErrorMessage == '') {
	$sql = GetCustomTextSQL("user", "int") . GetCustomTextSQL("user", "double") . GetCustomTextSQL("user", "date") . GetCustomTextSQL("user", "text");
	if (strlen($sql) > 0)
		$sql = ", " . substr($sql, 0, -1);

	$hash = password_hash(trim($_REQUEST['user_password']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));
	
	$query =	"	INSERT INTO user " .
				"	SET		user_is_enable			= '" . ynval($_REQUEST['user_is_enable']) . "', " .
				"			user_create_date		= NOW(), " .
				"			site_id					= '" . intval($_SESSION['site_id']) . "', " .
				"			shop_id					= '" . SHOP_ID . "', " .
				"			user_security_level		= '" . intval($_REQUEST['user_security_level']) . "', " .
				"			user_username			= '" . aveEscT($_REQUEST['user_username']) . "', " .
				"			user_email				= '" . aveEscT($_REQUEST['user_email']) . "', " .
				"			user_password			= '" . $hash . "', " .
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
				"			user_hk_district_id		= '" . intval($_REQUEST['user_hk_district_id']) . "', " .
				"			user_tel_country_code	= '" . aveEscT($_REQUEST['user_tel_country_code']) . "', " .
				"			user_tel_area_code		= '" . aveEscT($_REQUEST['user_tel_area_code']) . "', " .
				"			user_tel_no				= '" . aveEscT($_REQUEST['user_tel_no']) . "', " .
				"			user_fax_country_code	= '" . aveEscT($_REQUEST['user_fax_country_code']) . "', " .
				"			user_fax_area_code		= '" . aveEscT($_REQUEST['user_fax_area_code']) . "', " .
				"			user_fax_no				= '" . aveEscT($_REQUEST['user_fax_no']) . "', " .
				"			user_join_mailinglist	= '" . ynval($_REQUEST['user_join_mailinglist']) . "', " .
				"			user_is_email_verify	= '" . ynval($_REQUEST['user_is_email_verify']) . "', " .
				"			user_email_verify_token	= '" . md5(md5(rand(0,999999) . 'it is a good day to die... time to release my pressure!!!!! !@##!!@**@' . rand(0, 99999) . 'do not ask!!!!')) . "', " .
				"			user_new_password		= '" . substr(md5(md5(rand(0,999999) . 'The real fun is you can change this everytime you see this.... son of the bitch mr x is a lock man! poor! @##!!@**@' . rand(0, 99999) . 'do not ask!!!!')), 0, 8) . "', " .
				"			user_new_password_token	= '" . md5(md5(rand(0,999999) . 'Mr X is an lock man now!!!!! !@##!!@**@' . rand(0, 99999) . 'do not ask!!!!')) . "'" . $sql;
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$UserID = customdb::mysqli()->insert_id;
	user::TouchUserDatafileHolder($UserID, $Site['site_id']);
	$UserDatafileHolder = user::GetUserDatafileHolderByUserID($UserID);
	
	object::UpdateObjectPermission($UserDatafileHolder['object_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));
	
	site::EmptyAPICache($_SESSION['site_id']);

	header( 'Location: member_edit.php?id=' . $UserID . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
}
else {
	$_REQUEST['ErrorMessage'] = $ErrorMessage;
	require_once('member_add.php');
}