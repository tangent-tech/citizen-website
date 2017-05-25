<?php
// parameters:
//	object_id
//	user_id - 0 for guest
//	vote_no
//	vote_rate

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if ($Site['site_module_vote_enable'] == 'N')
	APIDie($API_ERROR['API_ERROR_VOTE_MODULE_DISABLED']);

if (intval($_REQUEST['vote_no']) < 1 || intval($_REQUEST['vote_no']) > MAX_VOTE_NO)
	APIDie($API_ERROR['API_ERROR_INVALID_VOTE_NO']);

$Object = object::GetObjectInfo($_REQUEST['object_id']);
if ($Object['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$User = null;
if (intval($_REQUEST['user_id']) != 0) {
	$User = user::GetUserInfo($_REQUEST['user_id']);
	if ($User['site_id'] != $Site['site_id'])
		APIDie($API_ERROR['API_ERROR_NOT_YOUR_USER']);
}

// Guest Check
if ($Site['site_vote_guest'] == 'N' && $User == null)
	APIDie($API_ERROR['API_ERROR_GUEST_VOTE_IS_DISABLED']);

if ($Site['site_vote_multi'] == 'Y') {
	$query	=	"	UPDATE	object " .
				"	SET		object_vote_sum_" . intval($_REQUEST['vote_no']) . " =	object_vote_sum_" . intval($_REQUEST['vote_no']) . " + (" . intval($_REQUEST['vote_rate']) . "), " .
				"			object_vote_count_" . intval($_REQUEST['vote_no']) . " = object_vote_count_" . intval($_REQUEST['vote_no']) . " + 1 " .
				"	WHERE	object_id	= '" . intval($_REQUEST['object_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
else {
	$Vote = object::GetVoteRate($_REQUEST['object_id'], $_REQUEST['user_id'], $_REQUEST['vote_no']);

	$Delta = $_REQUEST['vote_rate'] - intval($Vote['vote_rate']);

	$sql = '';
	if ($Vote == null)
		$sql = ", object_vote_count_" . intval($_REQUEST['vote_no']) . " = object_vote_count_" . intval($_REQUEST['vote_no']) . " + 1 ";

	$query	=	"	INSERT INTO	vote_table " .
				"	SET		user_id		= '" . intval($_REQUEST['user_id']) . "', " .
				"			object_id	= '" . intval($_REQUEST['object_id']) . "', " .
				"			vote_no		= '" . intval($_REQUEST['vote_no']) . "', " .
				"			vote_rate	= '" . doubleval($_REQUEST['vote_rate']) . "' " .
				"	ON DUPLICATE KEY UPDATE	vote_rate	= '" . doubleval($_REQUEST['vote_rate']) . "' ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$query	=	"	UPDATE	object " .
				"	SET		object_vote_sum_" . intval($_REQUEST['vote_no']) . " =	object_vote_sum_" . intval($_REQUEST['vote_no']) . " + (" . $Delta . ") " . $sql .
				"	WHERE	object_id	= '" . intval($_REQUEST['object_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$query	=	"	UPDATE	object " .
			"	SET		object_vote_average_" . intval($_REQUEST['vote_no']) . " =	object_vote_sum_" . intval($_REQUEST['vote_no']) . " / object_vote_count_" . intval($_REQUEST['vote_no']) .
			"	WHERE	object_id	= '" . intval($_REQUEST['object_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

site::EmptyAPICache($Site['site_id']);

$Object = object::GetObjectInfo($_REQUEST['object_id']);
$Object['object_seo_url'] = object::GetSeoURL($Object, '', $Object['language_id'], $Site);
$smarty->assign('Object', $Object);
$ObjectXML = $smarty->fetch('api/object_info/OBJECT.tpl');
$smarty->assign('Data', $ObjectXML);
$smarty->display('api/api_result.tpl');