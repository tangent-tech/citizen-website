<?php
#user_id
#filename
#size
#mimetype
#security_level
#datafile_custom_int_1 to datafile_custom_int_20
#datafile_custom_double_1 to datafile_custom_double_20
#datafile_custom_date_1 to datafile_custom_date_20
#datafile_custom_text_1[lang_id] to datafile_custom_text_20[lang_id]
#datafile_desc[lang_id]
#file_md5 - md5 checksum of the file 

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if (intval($_REQUEST['size']) <= 0)
	APIDie($API_ERROR['API_ERROR_FILE_SIZE_IS_ZERO']);

user::TouchUserDatafileHolder($User['user_id'], $Site['site_id']);
$UserDatafileHolder = user::GetUserDatafileHolderByUserID($User['user_id']);

$DataFileID = datafile::NewRemoteDatafileWithObject($_REQUEST['filename'], $_REQUEST['size'], $_REQUEST['mimetype'], $Site, intval($_REQUEST['security_level']), OBJECT_DEFAULT_ARCHIVE_DATE, OBJECT_DEFAULT_PUBLISH_DATE, 'Y', $_REQUEST['file_md5']);

if ($DataFileID !== false && $DataFileID != 0) {
	object::NewObjectLink($UserDatafileHolder['user_datafile_holder_id'], $DataFileID, 'Datafile File', 0, 'normal', DEFAULT_ORDER_ID);
	object::TidyUpObjectOrder($UserDatafileHolder['user_datafile_holder_id'], 'DATAFILE');
	media::UpdateTimeStamp($DataFileID);
}

$sql = GetCustomTextSQL("datafile", "int") . GetCustomTextSQL("datafile", "double") . GetCustomTextSQL("datafile", "date");

if (strlen($sql) > 0) {	
	$query =	"	UPDATE	datafile " .
				"	SET		" . substr($sql, 0, -1) .
				"	WHERE	datafile_id = '" . intval($DataFileID) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) > 0) {
	foreach ($SiteLanguageRoots as $R) {
		datafile::TouchDatafileData($DataFileID, $R['language_id']);

		$sql = GetCustomTextSQL("datafile", "text", $R['language_id']);
		if (strlen($sql) > 0)
			$sql = ", " . substr($sql, 0, -1);

		$query	=	"	UPDATE	datafile_data " .
					"	SET		datafile_desc = '" . aveEscT($_REQUEST['datafile_desc'][$R['language_id']]) . "'" . $sql .
					"	WHERE	datafile_id = '" . intval($DataFileID) . "'" .
					"		AND	language_id = '" . intval($R['language_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}	
}

site::EmptyAPICache($Site['site_id']);

$DataFile = datafile::GetDatafileInfo($DataFileID, 0);

$Data = '<datafile_file_id>' . $DataFile['datafile_file_id'] . '</datafile_file_id>' .
		'<datafile_id>' . $DataFileID . '</datafile_id>';

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');