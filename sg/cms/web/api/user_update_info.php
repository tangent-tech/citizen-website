<?php
// parameters:
//	user_id - REQUIRED FIELD
//	user_is_enable
//	user_security_level
//	user_username - if use email as login, enter email here. Will check if not blank only, apply validation algorithm on client side
//	user_email - email is email, if your site uses email as login, update both field
//	user_password - leave blank if unchange
//	user_is_temp
//	user_language_id
//	user_currency_id
//	user_first_name
//	user_last_name
//	user_title
//	user_company_name
//	user_city_name
//	user_region
//	user_postcode
//	user_address_1
//	user_address_2
//	user_country_id
//	user_country_other
//	user_hk_district_id
//	user_tel_country_code
//	user_tel_area_code
//	user_tel_no
//	user_fax_country_code
//	user_fax_area_code
//	user_fax_no
//	user_how_to_know_this_website
//	user_balance
//	user_join_mailinglist
//	user_is_email_verify
//	user_custom_text_1
//	user_custom_text_2
//	user_custom_text_3
//	user_custom_text_4
//	user_custom_text_5
//	user_custom_int_1
//	user_custom_int_2
//	user_custom_int_3
//	user_custom_int_4
//	user_custom_int_5
//	user_custom_double_1
//	user_custom_double_2
//	user_custom_double_3
//	user_custom_double_4
//	user_custom_double_5
//	user_custom_date_1
//	user_custom_date_2
//	user_custom_date_3
//	user_custom_date_4
//	user_custom_date_5
// ******** IMPORTANT **********
//	new_user_email_verify_token - 'Y' or not set
//	new_user_new_password - 'Y' or not set

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$sql = '';

if (isset($_REQUEST['user_email'])) {
	if (trim($_REQUEST['user_email']) != '' && !IsValidEmail($_REQUEST['user_email']))
		APIDie($API_ERROR['API_ERROR_INVALID_EMAIL']);
}
//if (trim($_REQUEST['user_email']) != '' && user::IsDuplicateEmail($_REQUEST['user_email'], $Site['site_id']))
//	APIDie($API_ERROR['API_ERROR_DUPLICATE_EMAIL']);

if (isset($_REQUEST['user_username'])) {
	if (user::IsDuplicateUsername($_REQUEST['user_username'], $_REQUEST['user_id'], $Site['site_id']))
	APIDie($API_ERROR['API_ERROR_DUPLICATE_USERNAME']);
}

if (isset($_REQUEST['user_language_id'])) {
	$SiteLanguageRoot = language::GetSiteLanguageRoot($_REQUEST['user_language_id'], $Site['site_id']);
	if ($SiteLanguageRoot == null)
		APIDie($API_ERROR['API_ERROR_INVALID_LANGUAGE_ID']);
}

if (isset($_REQUEST['user_country_id'])) {
	$Country = country::GetCountryInfo($_REQUEST['user_country_id']);
	if ($Country == null)
		APIDie($API_ERROR['API_ERROR_INVALID_COUNTRY_ID']);
}

if (isset($_REQUEST['user_currency_id'])) {
	$Currency = currency::GetCurrencyInfo($_REQUEST['user_currency_id'], $Site['site_id']);
	if ($Currency == null)
		APIDie($API_ERROR['API_ERROR_INVALID_CURRENCY_ID']);
}

if (isset($_REQUEST['user_is_enable']))
	$sql = $sql . "	user_is_enable = '" . ynval($_REQUEST['user_is_enable']) . "', ";
if (isset($_REQUEST['user_security_level']))
	$sql = $sql . "	user_security_level = '" . intval($_REQUEST['user_security_level']) . "', ";
if (isset($_REQUEST['user_username']))
	$sql = $sql . "	user_username = '" . aveEscT($_REQUEST['user_username']) . "', ";
if (isset($_REQUEST['user_email']))
	$sql = $sql . "	user_email = '" . aveEscT($_REQUEST['user_email']) . "', ";
if (isset($_REQUEST['user_password'])) {
	$passwordHash = password_hash(trim($_REQUEST['user_password']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));
	$sql = $sql . " user_password = '" . aveEsc($passwordHash) . "', ";
}
if (isset($_REQUEST['user_is_temp']))
	$sql = $sql . " user_is_temp = '" . ynval($_REQUEST['user_is_temp']) . "', ";
if (isset($_REQUEST['user_language_id']))
	$sql = $sql . " user_language_id = '" . intval($_REQUEST['user_language_id']) . "', ";
if (isset($_REQUEST['user_currency_id']))
	$sql = $sql . " user_currency_id = '" . intval($_REQUEST['user_currency_id']) . "', ";
if (isset($_REQUEST['user_first_name']))
	$sql = $sql . " user_first_name = '" . aveEscT($_REQUEST['user_first_name']) . "', ";
if (isset($_REQUEST['user_last_name']))
	$sql = $sql . " user_last_name = '" . aveEscT($_REQUEST['user_last_name']) . "', ";
if (isset($_REQUEST['user_title']))
	$sql = $sql . " user_title = '" . aveEscT($_REQUEST['user_title']) . "', ";
if (isset($_REQUEST['user_company_name']))
	$sql = $sql . " user_company_name = '" . aveEscT($_REQUEST['user_company_name']) . "', ";
if (isset($_REQUEST['user_city_name']))
	$sql = $sql . " user_city_name = '" . aveEscT($_REQUEST['user_city_name']) . "', ";
if (isset($_REQUEST['user_region']))
	$sql = $sql . " user_region = '" . aveEscT($_REQUEST['user_region']) . "', ";
if (isset($_REQUEST['user_postcode']))
	$sql = $sql . " user_postcode = '" . aveEscT($_REQUEST['user_postcode']) . "', ";
if (isset($_REQUEST['user_address_1']))
	$sql = $sql . " user_address_1 = '" . aveEscT($_REQUEST['user_address_1']) . "', ";
if (isset($_REQUEST['user_address_2']))
	$sql = $sql . " user_address_2 = '" . aveEscT($_REQUEST['user_address_2']) . "', ";
if (isset($_REQUEST['user_country_id']))
	$sql = $sql . " user_country_id = '" . intval($_REQUEST['user_country_id']) . "', ";
if (isset($_REQUEST['user_country_other']))
	$sql = $sql . " user_country_other = '" . aveEscT($_REQUEST['user_country_other']) . "', ";
if (isset($_REQUEST['user_hk_district_id']))
	$sql = $sql . " user_hk_district_id = '" . intval($_REQUEST['user_hk_district_id']) . "', ";
if (isset($_REQUEST['user_tel_country_code']))
	$sql = $sql . " user_tel_country_code = '" . aveEscT($_REQUEST['user_tel_country_code']) . "', ";
if (isset($_REQUEST['user_tel_area_code']))
	$sql = $sql . " user_tel_area_code = '" . aveEscT($_REQUEST['user_tel_area_code']) . "', ";
if (isset($_REQUEST['user_tel_no']))
	$sql = $sql . " user_tel_no = '" . aveEscT($_REQUEST['user_tel_no']) . "', ";
if (isset($_REQUEST['user_fax_country_code']))
	$sql = $sql . " user_fax_country_code = '" . aveEscT($_REQUEST['user_fax_country_code']) . "', ";
if (isset($_REQUEST['user_fax_area_code']))
	$sql = $sql . " user_fax_area_code = '" . aveEscT($_REQUEST['user_fax_area_code']) . "', ";
if (isset($_REQUEST['user_fax_no']))
	$sql = $sql . " user_fax_no = '" . aveEscT($_REQUEST['user_fax_no']) . "', ";
if (isset($_REQUEST['user_how_to_know_this_website']))
	$sql = $sql . " user_how_to_know_this_website = '" . aveEscT($_REQUEST['user_how_to_know_this_website']) . "', ";
//if (isset($_REQUEST['user_balance']))
//	$sql = $sql . " user_balance = '" . doubleval($_REQUEST['user_balance']) . "', ";
if (isset($_REQUEST['user_join_mailinglist']))
	$sql = $sql . " user_join_mailinglist = '" . ynval($_REQUEST['user_join_mailinglist']) . "', ";
if (isset($_REQUEST['user_is_email_verify']))
	$sql = $sql . " user_is_email_verify = '" . ynval($_REQUEST['user_is_email_verify']) . "', ";
if ($_REQUEST['new_user_email_verify_token'] == 'Y')
	$sql = $sql . " new_user_email_verify_token = '" . md5(md5(rand(0,999999) . 'i really like this kind of random text while coding... time to release my pressure!!!!! !@##!!@**@' . rand(0, 99999) . 'do not ask!!!!')) . "', ";
if ($_REQUEST['new_user_new_password'] == 'Y') {
	$sql = $sql . " user_new_password = '" . substr(md5(md5(rand(0,999999) . '!@##!!@**@' . rand(0, 99999) . 'do not ask!!!!')), 0, 8) . "', ";
	$sql = $sql . " user_new_password_token = '" . md5(md5(rand(0,999999) . 'Mr X is an lock man now!!!!! !@##!!@**@' . rand(0, 99999) . 'do not ask!!!!')) . "', ";
}

$FieldType = array('text', 'int', 'double', 'date');
foreach ($FieldType as $F) {
	for ($i = 1; $i <= 20; $i++) {
		if (isset($_REQUEST['user_custom_' . $F . '_' . $i]))
			$sql = $sql . " user_custom_" . $F . "_" . $i . " = '" . aveEscT($_REQUEST['user_custom_' . $F . '_' . $i]) . "', ";
	}
}

if ($sql != '') {
	$query =	"	UPDATE user " .
				"	SET		" . substr($sql, 0, -2) .
				"	WHERE	user_id	= '" . intval($_REQUEST['user_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
$smarty->display('api/api_result.tpl');