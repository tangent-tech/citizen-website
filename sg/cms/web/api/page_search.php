<?php
// parameters:
//	page_title
//	lang_id
//	layout_id
//	security_level
//	page_tag
//	page_objects_per_page
//	page_no

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

if (intval($_REQUEST['page_no']) <= 1)
	$_REQUEST['page_no'] = 1;
if (intval($_REQUEST['page_objects_per_page']) <= 0)
	$_REQUEST['page_objects_per_page'] = 20;
if (!isset($_REQUEST['security_level']))
	$_REQUEST['security_level'] = 999999;
else
	$_REQUEST['security_level'] = intval($_REQUEST['security_level']);
	
$Offset = intval(($_REQUEST['page_no'] -1) * $_REQUEST['page_objects_per_page']);

$sql = '';
if (trim($_REQUEST['page_tag']) != '')
	$sql	=	$sql . "	AND	P.page_tag	LIKE '%, " . aveEscT($_REQUEST['page_tag']) . ",%' ";
if (isset($_REQUEST['layout_id']))
	$sql	=	$sql . "	AND	P.layout_id	= '" . intval($_REQUEST['layout_id']) . "' ";
if (isset($_REQUEST['page_title']))
	$sql	=	$sql . "	AND	P.page_title = '" . aveEscT($_REQUEST['page_title']) . "'";
if (isset($_REQUEST['lang_id']))
	$sql	=	$sql . "	AND	OL.language_id = '" . intval($_REQUEST['lang_id']) . "'";

$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, OL.*, PO.* " .
			"	FROM	object_link OL	JOIN		object PO		ON (OL.object_id = PO.object_id) " .
			"							JOIN		page P			ON (P.page_id = PO.object_id) " .
			"	WHERE	PO.object_is_enable = 'Y' " .
			"		AND OL.object_link_is_enable = 'Y' " .
			"		AND	PO.object_security_level <= '" . intval($_REQUEST['security_level']) . "'" .
			"		AND	PO.object_archive_date > NOW() " .
			"		AND	PO.object_publish_date < NOW() " . $sql .
			"	ORDER BY OL.order_id ASC " .
			"	LIMIT	" . $Offset . ", " . intval($_REQUEST['page_objects_per_page']);
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	SELECT FOUND_ROWS() ";
$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
$myResult = $result2->fetch_row();
$TotalNoOfPageObjects = $myResult[0];

$PageListXML = '';

while ($myResult = $result->fetch_assoc()) {
	$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $myResult['language_id'], $Site);

	$PageXML = '';
	$PageXML = page::GetPageXML($myResult['object_id'], 1, $MediaPerPage, $_REQUEST['security_level']);
	$PageListXML = $PageListXML . $PageXML;
}

$smarty->assign('PageListXML', $PageListXML);
$smarty->assign('TotalNoOfPageObjects', $TotalNoOfPageObjects);
$smarty->assign('PageNo', $_REQUEST['page_no']);
$Data = $smarty->fetch('api/page_search.tpl');

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');