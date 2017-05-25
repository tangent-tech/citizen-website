<?php
// parameters:
//	object_id

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$Object = object::GetObjectInfo($_REQUEST['object_id']);
if ($Object['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$query	=	"	UPDATE	object " .
			"	SET		counter_alltime = counter_alltime + 1, " .
			"			modify_date = modify_date " .
			"	WHERE	object_id	= '" . intval($_REQUEST['object_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$Object = object::GetObjectInfo($_REQUEST['object_id']);
$Object['object_seo_url'] = object::GetSeoURL($Object, '', $Object['language_id'], $Site);
$smarty->assign('Object', $Object);
$ObjectXML = $smarty->fetch('api/object_info/OBJECT.tpl');
$smarty->assign('Data', $ObjectXML);
$smarty->display('api/api_result.tpl');