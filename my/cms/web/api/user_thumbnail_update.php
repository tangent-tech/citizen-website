<?php
// parameters:
//	user_id - REQUIRED FIELD
//	filename
//	size
//	mimetype
//	file_md5 - md5 checksum of the file 

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

if ($User['user_thumbnail_file_id'] != 0)
	user::RemoveUserThumbnail ($User, $Site);

if (intval($_REQUEST['size']) <= 0)
	APIDie($API_ERROR['API_ERROR_FILE_SIZE_IS_ZERO']);

$FileID = filebase::AddRemoteFile($_REQUEST['filename'], $_REQUEST['size'], $_REQUEST['mimetype'], $Site, $Site['site_root_id'], $_REQUEST['file_md5']);

$query =	"	UPDATE	user " .
			"	SET		user_thumbnail_file_id = '" . intval($FileID) . "'" .
			"	WHERE	user_id =  '" . intval($User['user_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$smarty->assign('Data', '<user_thumbnail_file_id>' . $FileID . '</user_thumbnail_file_id>');
$smarty->display('api/api_result.tpl');