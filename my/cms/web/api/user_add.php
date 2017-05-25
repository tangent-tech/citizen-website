<?php
// parameters:
//	user_is_enable
//	user_security_level
//	user_username - if use email as login, enter email here. Will check if not blank only, apply validation algorithm on client side
//	user_email - email is email, if your site uses email as login, update both field
//	user_password - Will trim only, make the validation on client side!
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
//	user_is_temp
//	user_custom_text_1 to user_custom_text_20
//	user_custom_int_1 to user_custom_int_20
//	user_custom_double_1 to user_custom_double_20
//	user_custom_date_1 to user_custom_date_20
//	terminal_id - default 0

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if (trim($_REQUEST['user_email']) != '' && !IsValidEmail($_REQUEST['user_email']))
	APIDie($API_ERROR['API_ERROR_INVALID_EMAIL']);
//if (trim($_REQUEST['user_email']) != '' && user::IsDuplicateEmail($_REQUEST['user_email'], $Site['site_id']))
//	APIDie($API_ERROR['API_ERROR_DUPLICATE_EMAIL']);
if (trim($_REQUEST['user_username']) == '')
	APIDie($API_ERROR['API_ERROR_DUPLICATE_USERNAME']);

if (user::IsDuplicateUsername($_REQUEST['user_username'], 0, $Site['site_id'])) {
	$User = user::GetUserInfoByUsername($_REQUEST['user_username'], $Site['site_id']);
	$AdditionalXML = '<user_id>' . $User['user_id'] . '</user_id>';
	APIDie($API_ERROR['API_ERROR_DUPLICATE_USERNAME'], $AdditionalXML);
}

$SiteLanguageRoot = language::GetSiteLanguageRoot($_REQUEST['user_language_id'], $Site['site_id']);
if ($SiteLanguageRoot == null)
	APIDie($API_ERROR['API_ERROR_INVALID_LANGUAGE_ID']);

$Country = country::GetCountryInfo($_REQUEST['user_country_id']);
if ($Country == null)
	APIDie($API_ERROR['API_ERROR_INVALID_COUNTRY_ID']);

$Currency = currency::GetCurrencyInfo($_REQUEST['user_currency_id'], $Site['site_id']);
if ($Currency == null)
	APIDie($API_ERROR['API_ERROR_INVALID_CURRENCY_ID']);

if ($_REQUEST['user_is_temp'] != 'Y')
	$_REQUEST['user_is_temp'] = 'N';

$sql = '';
$FieldType = array('text', 'int', 'double', 'date');
foreach ($FieldType as $F) {
	for ($i = 1; $i <= 20; $i++) {
		if (isset($_REQUEST['user_custom_' . $F . '_' . $i]))
			$sql = $sql . " user_custom_" . $F . "_" . $i . " = '" . aveEscT($_REQUEST['user_custom_' . $F . '_' . $i]) . "', ";
	}
}

$passwordHash = password_hash(trim($_REQUEST['user_password']), PASSWORD_DEFAULT, array('cost' => PASSWORD_HASH_COST));
	
$query =	"	INSERT INTO user " .
			"	SET		user_is_enable					= '" . ynval($_REQUEST['user_is_enable']) . "', " .
			"			user_create_date				= NOW(), " .
			"			site_id							= '" . intval($Site['site_id']) . "', " .
			"			shop_id							= '" . intval(SHOP_ID) . "', " .
			"			terminal_id						= '" . intval($_REQUEST['terminal_id']) . "', " .
			"			user_security_level				= '" . intval($_REQUEST['user_security_level']) . "', " .
			"			user_username					= '" . aveEscT($_REQUEST['user_username']) . "', " .
			"			user_email						= '" . aveEscT($_REQUEST['user_email']) . "', " .
			"			user_password					= '" . aveEsc($passwordHash) . "', " .
			"			user_is_temp					= '" . aveEscT($_REQUEST['user_is_temp']) . "', " .
			"			user_language_id				= '" . intval($_REQUEST['user_language_id']) . "', " .
			"			user_currency_id				= '" . intval($_REQUEST['user_currency_id']) . "', " .
			"			user_first_name					= '" . aveEscT($_REQUEST['user_first_name']) . "', " .
			"			user_last_name					= '" . aveEscT($_REQUEST['user_last_name']) . "', " .
			"			user_title						= '" . aveEscT($_REQUEST['user_title']) . "', " .
			"			user_company_name				= '" . aveEscT($_REQUEST['user_company_name']) . "', " .
			"			user_city_name					= '" . aveEscT($_REQUEST['user_city_name']) . "', " .
			"			user_region						= '" . aveEscT($_REQUEST['user_region']) . "', " .
			"			user_postcode					= '" . aveEscT($_REQUEST['user_postcode']) . "', " .
			"			user_address_1					= '" . aveEscT($_REQUEST['user_address_1']) . "', " .
			"			user_address_2					= '" . aveEscT($_REQUEST['user_address_2']) . "', " .
			"			user_country_id					= '" . intval($_REQUEST['user_country_id']) . "', " .
			"			user_country_other				= '" . aveEscT($_REQUEST['user_country_other']) . "', " .
			"			user_hk_district_id				= '" . intval($_REQUEST['user_hk_district_id']) . "', " .
			"			user_tel_country_code			= '" . aveEscT($_REQUEST['user_tel_country_code']) . "', " .
			"			user_tel_area_code				= '" . aveEscT($_REQUEST['user_tel_area_code']) . "', " .
			"			user_tel_no						= '" . aveEscT($_REQUEST['user_tel_no']) . "', " .
			"			user_fax_country_code			= '" . aveEscT($_REQUEST['user_fax_country_code']) . "', " .
			"			user_fax_area_code				= '" . aveEscT($_REQUEST['user_fax_area_code']) . "', " .
			"			user_fax_no						= '" . aveEscT($_REQUEST['user_fax_no']) . "', " .
			"			user_how_to_know_this_website	= '" . aveEscT($_REQUEST['user_how_to_know_this_website']) . "', " .
			"			user_join_mailinglist			= '" . ynval($_REQUEST['user_join_mailinglist']) . "', " .
			"			user_is_email_verify			= '" . ynval($_REQUEST['user_is_email_verify']) . "', " .
			"			user_email_verify_token			= '" . md5(md5(rand(0,999999) . 'i really like this kind of random text while coding... time to release my pressure!!!!! !@##!!@**@' . rand(0, 99999) . 'do not ask!!!!')) . "', " .
			"			user_new_password				= '" . substr(md5(md5(rand(0,999999) . '!@##!!@**@' . rand(0, 99999) . 'do not ask!!!!')), 0, 8) . "', " . $sql .
			"			user_new_password_token			= '" . md5(md5(rand(0,999999) . 'Mr X is an lock man now!!!!! !@##!!@**@' . rand(0, 99999) . 'do not ask!!!!')) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$smarty->assign('UserID', customdb::mysqli()->insert_id);
$UserAddXML = $smarty->fetch('api/user_add.tpl');

$smarty->assign('Data', $UserAddXML);
$smarty->display('api/api_result.tpl');