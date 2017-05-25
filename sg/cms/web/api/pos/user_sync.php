<?php
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$SyncLog = new sync_log($Site['site_id'], $_REQUEST['shop_id']);

if (
		$SyncLog->getLatestLogDetails()->sync_log_status == 'start_sync' ||
		$SyncLog->getLatestLogDetails()->sync_log_status == 'user_sync'
	) {
	if (intval($_REQUEST['user_id']) > $SyncLog->getLatestLogDetails()->max_user_id) {

		// Check for existing username here!
		$OldUser = user::GetUserInfoByUsername(trim($_REQUEST['user_username']), $Site['site_id']);
		
		if ($OldUser != null) {
			$query =	"	UPDATE user " .
						"	SET		" .
						"			old_user_id		= '" . intval($_REQUEST['user_id']) . "', " .
						"			shop_id			= '" . intval($_REQUEST['shop_id']) . "', " .
						"			terminal_id		= '" . intval($_REQUEST['terminal_id']) . "' " .
						"	WHERE	user_id			= '" . intval($OldUser['user_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			$SyncLog->incrementLatestSyncNoOfUserUpdated();
			$Data = "<user_sync_result>updated</user_sync_result><original_user_id>" . $OldUser['user_id'] . "</original_user_id>";
		}
		else {
			$sql = '';
			$FieldType = array('text', 'int', 'double', 'date');
			foreach ($FieldType as $F) {
				for ($i = 1; $i <= 20; $i++) {
					if (isset($_REQUEST['user_custom_' . $F . '_' . $i]))
						$sql = $sql . " user_custom_" . $F . "_" . $i . " = '" . aveEscT($_REQUEST['user_custom_' . $F . '_' . $i]) . "', ";
				}
			}

			$query =	"	INSERT INTO user " .
						"	SET		" .
						"			old_user_id						= '" . intval($_REQUEST['user_id']) . "', " .
						"			user_create_date				= '" . aveEscT($_REQUEST['user_create_date']) . "', " .
						"			user_last_modify_date			= '" . aveEscT($_REQUEST['user_last_modify_date']) . "', " .
						"			user_is_enable					= '" . ynval($_REQUEST['user_is_enable']) . "', " .
						"			site_id							= '" . intval($Site['site_id']) . "', " .
						"			shop_id							= '" . intval($_REQUEST['shop_id']) . "', " .
						"			terminal_id						= '" . intval($_REQUEST['terminal_id']) . "', " .
						"			user_security_level				= '" . intval($_REQUEST['user_security_level']) . "', " .
						"			user_username					= '" . aveEscT($_REQUEST['user_username']) . "', " .
						"			user_email						= '" . aveEscT($_REQUEST['user_email']) . "', " .
						"			user_password					= '" . aveEscT($_REQUEST['user_password']) . "', " .
						"			user_is_temp					= '" . ynval($_REQUEST['user_is_temp']) . "', " .
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

			$Data = "<user_sync_result>imported</user_sync_result><new_user_id>" . customdb::mysqli()->insert_id . "</new_user_id>";
			
			$SyncLog->incrementLatestSyncNoOfUserImported();
			$SyncLog->updateLatestSyncStatus('user_sync');
		}
	}
	else {
		APIDie(array('no' => __LINE__, 'desc' => 'user_id is less than max_user_id'));	
	}
	$smarty->assign('Data', $Data);
	$smarty->display('api/api_result.tpl');
}
else {
	APIDie(array('no' => __LINE__, 'desc' => 'Unmatched sync status'));	
}