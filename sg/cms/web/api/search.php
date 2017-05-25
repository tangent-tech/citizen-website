<?php
// parameters:
//	security_level
//	search_text
//	object_type - all / product / page / album / media / news / bonus_point_item / layout_news
//	page_no
//	objects_per_page
//	lang_id
//	wildcard	- both / front / end / none
//	order_by_object_vote_sum_1 - asc / desc / null
//	order_by_object_vote_sum_2 - asc / desc / null
//	order_by_object_vote_sum_3 - asc / desc / null
//	order_by_object_vote_sum_4 - asc / desc / null
//	order_by_object_vote_sum_5 - asc / desc / null
//	order_by_object_vote_sum_6 - asc / desc / null
//	order_by_object_vote_sum_7 - asc / desc / null
//	order_by_object_vote_sum_8 - asc / desc / null
//	order_by_object_vote_sum_8 - asc / desc / null
//	order_by_object_vote_count_1 - asc / desc / null
//	order_by_object_vote_count_2 - asc / desc / null
//	order_by_object_vote_count_3 - asc / desc / null
//	order_by_object_vote_count_4 - asc / desc / null
//	order_by_object_vote_count_5 - asc / desc / null
//	order_by_object_vote_count_6 - asc / desc / null
//	order_by_object_vote_count_7 - asc / desc / null
//	order_by_object_vote_count_8 - asc / desc / null
//	order_by_object_vote_count_9 - asc / desc / null
//	order_by_object_vote_average_1 - asc / desc / null
//	order_by_object_vote_average_2 - asc / desc / null
//	order_by_object_vote_average_3 - asc / desc / null
//	order_by_object_vote_average_4 - asc / desc / null
//	order_by_object_vote_average_5 - asc / desc / null
//	order_by_object_vote_average_6 - asc / desc / null
//	order_by_object_vote_average_7 - asc / desc / null
//	order_by_object_vote_average_8 - asc / desc / null
//	order_by_object_vote_average_9 - asc / desc / null

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$PageNo = intval($_REQUEST['page_no']);
$ObjectsPerPage = intval($_REQUEST['objects_per_page']);

$Offset = ($PageNo -1) * $ObjectsPerPage;

function GetSQLText($ObjectType) {
	global $Site;

	$WildcardCharFront	= '%';
	$WildcardCharEnd	= '%';
	if ($_REQUEST['wildcard'] == 'none') {
		$WildcardCharFront	= '';
		$WildcardCharEnd	= '';
	}
	elseif ($_REQUEST['wildcard'] == 'front') {
		$WildcardCharFront	= '%';
		$WildcardCharEnd	= '';
	}
	elseif ($_REQUEST['wildcard'] == 'end') {
		$WildcardCharFront	= '';
		$WildcardCharEnd	= '%';
	}

	$OrderBySQL = '';
	for ($i = 1; $i <= 9; $i++) {
		if ($_REQUEST['order_by_object_vote_sum_' . $i] == 'asc')
			$OrderBySQL = $OrderBySQL . ' O.object_vote_sum_' . $i . ' ASC,';
		elseif ($_REQUEST['order_by_object_vote_sum_' . $i] == 'desc')
			$OrderBySQL = $OrderBySQL . ' O.object_vote_sum_' . $i . ' DESC,';
		if ($_REQUEST['order_by_object_vote_count_' . $i] == 'asc')
			$OrderBySQL = $OrderBySQL . ' O.object_vote_count_' . $i . ' ASC,';
		elseif ($_REQUEST['order_by_object_vote_count_' . $i] == 'desc')
			$OrderBySQL = $OrderBySQL . ' O.object_vote_count_' . $i . ' DESC,';
		if ($_REQUEST['order_by_object_vote_average_' . $i] == 'asc')
			$OrderBySQL = $OrderBySQL . ' O.object_vote_average_' . $i . ' ASC,';
		elseif ($_REQUEST['order_by_object_vote_average_' . $i] == 'desc')
			$OrderBySQL = $OrderBySQL . ' O.object_vote_average_' . $i . ' DESC,';
	}
	$OrderBySQL = substr($OrderBySQL, 0, -1);
	if (strlen($OrderBySQL) > 0)
		$OrderBySQL = "ORDER BY " . $OrderBySQL;

	if ($ObjectType == 'product') {
		$num_sql = '';
		if (isNumeric(trim($_REQUEST['search_text']))) {
			$num_sql = 
				"				OR	P.product_custom_int_1		= '" . aveEscT($_REQUEST['search_text']) . "' " .
				"				OR	P.product_custom_int_2		= '" . aveEscT($_REQUEST['search_text']) . "' " .
				"				OR	P.product_custom_int_3		= '" . aveEscT($_REQUEST['search_text']) . "' " .
				"				OR	P.product_custom_int_4		= '" . aveEscT($_REQUEST['search_text']) . "' " .
				"				OR	P.product_custom_int_5		= '" . aveEscT($_REQUEST['search_text']) . "' " .
				"				OR	P.product_custom_double_1	= '" . aveEscT($_REQUEST['search_text']) . "' " .
				"				OR	P.product_custom_double_2	= '" . aveEscT($_REQUEST['search_text']) . "' " .
				"				OR	P.product_custom_double_3	= '" . aveEscT($_REQUEST['search_text']) . "' " .
				"				OR	P.product_custom_double_4	= '" . aveEscT($_REQUEST['search_text']) . "' " .
				"				OR	P.product_custom_double_5	= '" . aveEscT($_REQUEST['search_text']) . "' ";
		}
		
		$sql =	"	SELECT	*, O.*, OL.* " .
				"	FROM	object O	JOIN	product P		ON	(O.object_id = P.product_id		AND O.object_security_level <= '" . intval($_REQUEST['security_level']) . "') " .
				"						JOIN	object_link OL	ON	(O.object_id = OL.object_id) " .
				"						JOIN	product_data PD	ON	(O.object_id = PD.product_id) " .
				"						JOIN	object PO ON (OL.parent_object_id = PO.object_id AND PO.object_type != 'PRODUCT_BRAND') " .
				"	WHERE	O.site_id	= '" . $Site['site_id'] . "' " .
				"		AND	O.object_type = 'PRODUCT' " .
				"		AND	O.object_is_enable = 'Y' " .
				"		AND	OL.object_link_is_enable = 'Y' " .
				"		AND	O.object_archive_date > NOW() " .
				"		AND	O.object_publish_date < NOW() " .
				"		AND	O.is_removed = 'N' AND " .
				"				(	OL.object_name		LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "' " .
				"				OR	P.factory_code		LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "' " .
				"				OR	P.product_code		LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd. "' " .
				"				OR	PD.product_name		LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd. "' " .
				"				OR	PD.product_color		LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd. "' " .
				"				OR	PD.product_packaging	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd. "' " .
				"				OR	PD.product_desc		LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd. "' " .
				"				OR	PD.product_tag		LIKE '%, " . aveEscT($_REQUEST['search_text']) . ",%' " .
				"				OR	PD.product_custom_text_1	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd. "' " .
				"				OR	PD.product_custom_text_2	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd. "' " .
				"				OR	PD.product_custom_text_3	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd. "' " .
				"				OR	PD.product_custom_text_4	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd. "' " .
				"				OR	PD.product_custom_text_5	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd. "' " . $num_sql . ") " .
//				"				OR	P.product_custom_date_1		= '" . aveEscT($_REQUEST['search_text']) . "' " .
//				"				OR	P.product_custom_date_2		= '" . aveEscT($_REQUEST['search_text']) . "' " .
//				"				OR	P.product_custom_date_3		= '" . aveEscT($_REQUEST['search_text']) . "' " .
//				"				OR	P.product_custom_date_4		= '" . aveEscT($_REQUEST['search_text']) . "' " .
//				"				OR	P.product_custom_date_5		= '" . aveEscT($_REQUEST['search_text']) . "' ) " .
				"	GROUP BY	O.object_id " . $OrderBySQL;

	}
	elseif ($ObjectType == 'page') {
		$lang_sql = '';
		if (intval($_REQUEST['lang_id']) != 0) {
			$lang_sql = " AND OL.language_id = '" . intval($_REQUEST['lang_id']) . "' ";
		}	
	
		$sql =	"	SELECT	*, O.*, OL.* " .
				"	FROM	object O	JOIN	page P				ON	(O.object_id = P.page_id	AND O.object_security_level <= '" . intval($_REQUEST['security_level']) . "') " .
				"						JOIN	object_link OL		ON	(O.object_id = OL.object_id) " .
				"						JOIN	block_holder BH		ON	(BH.page_id = P.page_id) " .
				"						JOIN	object_link OL_BC	ON	(OL_BC.parent_object_id = BH.block_holder_id) " .
				"						JOIN	block_content BC	ON	(OL_BC.object_id = BC.block_content_id) " .
				"	WHERE	O.site_id	= '" . $Site['site_id'] . "' " .
				"		AND	O.object_is_enable = 'Y' " . $lang_sql .
				"		AND	OL.object_link_is_enable = 'Y' " .				
				"		AND	O.object_archive_date > NOW() " .
				"		AND	O.object_publish_date < NOW() " .
				"		AND	O.is_removed = 'N' AND " .
				"				(	OL.object_name		LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "' " .
				"				OR	P.page_title		LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "' " .
				"				OR	BC.block_content	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "') " .
				"	GROUP BY	O.object_id " . $OrderBySQL;
	}
	elseif ($ObjectType == 'layout_news') {
		$lang_sql = '';
		if (intval($_REQUEST['lang_id']) != 0) {
			$lang_sql = " AND R.language_id = '" . intval($_REQUEST['lang_id']) . "' ";
		}
		
		$sql =	"	SELECT	N.*, O.*, R.language_id " .
				"	FROM	object O	JOIN	layout_news	N		ON	(O.object_id = N.layout_news_id		AND O.object_security_level <= '" . intval($_REQUEST['security_level']) . "') " .
				"						JOIN	block_holder BH		ON	(BH.page_id = N.layout_news_id) " .
				"						JOIN	object_link OL_BC	ON	(OL_BC.parent_object_id = BH.block_holder_id) " .
				"						JOIN	block_content BC	ON	(OL_BC.object_id = BC.block_content_id) " . 
				"						JOIN	layout_news_root R	ON	(R.layout_news_root_id = N.layout_news_root_id) " .
				"	WHERE	O.site_id	= '" . $Site['site_id'] . "' " .
				"		AND	O.object_is_enable = 'Y' " . $lang_sql .
//				"		AND	OL.object_link_is_enable = 'Y' " .
				"		AND	O.object_archive_date > NOW() " .
				"		AND	O.object_publish_date < NOW() " .
				"		AND	O.is_removed = 'N' AND " .
				"				(	N.layout_news_title	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "' " .
				"				OR	BC.block_content	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "') " .
				"	GROUP BY	O.object_id " . $OrderBySQL;
	}
	elseif ($ObjectType == 'album')
		$sql =	"	SELECT	*, O.*, OL.* " .
				"	FROM	object O	JOIN	album A			ON	(O.object_id = A.album_id	AND O.object_security_level <= '" . intval($_REQUEST['security_level']) . "') " .
				"						JOIN	object_link OL	ON	(O.object_id = OL.object_id) " .
				"						JOIN	album_data AD	ON	(O.object_id = AD.album_id	AND AD.language_id = '" . intval($_REQUEST['lang_id']) . "') " .
				"	WHERE	O.site_id	= '" . $Site['site_id'] . "' " .
				"		AND	O.object_is_enable = 'Y' " .
				"		AND	OL.object_link_is_enable = 'Y' " .
				"		AND	O.object_archive_date > NOW() " .
				"		AND	O.object_publish_date < NOW() " .
				"		AND	O.is_removed = 'N' AND " .
				"			AD.album_desc	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "' " .
				"	GROUP BY	O.object_id " . $OrderBySQL;
	elseif ($ObjectType == 'media')
		$sql =	"	SELECT	*, O.*, OL.* " .
				"	FROM	object O	JOIN	media M			ON	(O.object_id = M.media_id	AND O.object_security_level <= '" . intval($_REQUEST['security_level']) . "') " .
				"						JOIN	object_link OL	ON	(O.object_id = OL.object_id) " .
				"						JOIN	media_data MD	ON	(O.object_id = MD.media_id	AND MD.language_id = '" . intval($_REQUEST['lang_id']) . "') " .
				"	WHERE	O.site_id	= '" . $Site['site_id'] . "' " .
				"		AND	O.object_is_enable = 'Y' " .
				"		AND	OL.object_link_is_enable = 'Y' " .
				"		AND	O.object_archive_date > NOW() " .
				"		AND	O.object_publish_date < NOW() " .
				"		AND	O.is_removed = 'N' AND " .
				"				(	OL.object_name	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "' " .
				"				OR	MD.media_desc	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "') " .
				"	GROUP BY	O.object_id " . $OrderBySQL;
	elseif ($ObjectType == 'news') {
		$lang_sql = '';
		if (intval($_REQUEST['lang_id']) != 0) {
			$lang_sql = " AND R.language_id = '" . intval($_REQUEST['lang_id']) . "' ";
		}

		$sql =	"	SELECT	N.*, O.*, R.language_id " .
				"	FROM	object O	JOIN	news N			ON	(O.object_id = N.news_id	AND O.object_security_level <= '" . intval($_REQUEST['security_level']) . "') " . 
				"						JOIN	news_root R	ON	(R.news_root_id = N.news_root_id) " .
				"	WHERE	O.site_id	= '" . $Site['site_id'] . "' " .
				"		AND	O.object_is_enable = 'Y' " . $lang_sql .
//				"		AND	OL.object_link_is_enable = 'Y' " .
				"		AND	O.object_archive_date > NOW() " .
				"		AND	O.object_publish_date < NOW() " .
				"		AND	O.is_removed = 'N' AND " .
				"				(	N.news_title		LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "' " .
				"				OR	N.news_summary		LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "' " .
				"				OR	N.news_content		LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "' " .
//				"				OR	N.news_date			= '" . aveEscT($_REQUEST['search_text']) . "' " .
				"				OR	N.news_tag			LIKE '%, ". aveEscT($_REQUEST['search_text']) . ",%') " .
				"	GROUP BY	O.object_id " . $OrderBySQL;
	}
	elseif ($ObjectType == 'bonus_point_item')
		$sql =	"	SELECT	*, O.*, OL.* " .
				"	FROM	object O	JOIN	bonus_point_item B			ON	(O.object_id = B.bonus_point_item_id	AND O.object_security_level <= '" . intval($_REQUEST['security_level']) . "') " .
				"						JOIN	bonus_point_item_data BD	ON	(B.bonus_point_item_id = BD.bonus_point_item_id) " .
				"						JOIN	object_link OL		ON	(O.object_id = OL.object_id) " .
				"	WHERE	O.site_id	= '" . $Site['site_id'] . "' " .
				"		AND	O.object_is_enable = 'Y' " .
				"		AND	O.object_archive_date > NOW() " .
				"		AND	O.object_publish_date < NOW() " .
				"		AND	O.is_removed = 'N' AND " .
				"				(	OL.object_name				LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "' " .
				"				OR	BD.bonus_point_item_name	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "' " .
				"				OR	BD.bonus_point_item_desc	LIKE '" . $WildcardCharFront . aveEscT($_REQUEST['search_text']) . $WildcardCharEnd . "') " .
				"	GROUP BY	O.object_id " . $OrderBySQL;
	return $sql;
}

$TotalNoOfObjectsFound = array('product' => 0, 'page' => 0, 'album' => 0, 'media' => 0, 'news' => 0, 'bonus_point_item' => 0, 'layout_news' => 0);
if ($_REQUEST['object_type'] == 'all') {
	$query = GetSQLText('product');
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	$TotalNoOfObjectsFound['product'] = $result->num_rows;

	$query = GetSQLText('page');
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	$TotalNoOfObjectsFound['page'] = $result->num_rows;

	$query = GetSQLText('layout_news');
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	$TotalNoOfObjectsFound['layout_news'] = $result->num_rows;

	$query = GetSQLText('album');
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	$TotalNoOfObjectsFound['album'] = $result->num_rows;

	$query = GetSQLText('media');
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	$TotalNoOfObjectsFound['media'] = $result->num_rows;

	$query = GetSQLText('news');
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	$TotalNoOfObjectsFound['news'] = $result->num_rows;

	$query = GetSQLText('bonus_point_item');
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	$TotalNoOfObjectsFound['bonus_point_item'] = $result->num_rows;
}
else {
	$query = GetSQLText($_REQUEST['object_type']);
	if ($query != '') {
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$TotalNoOfObjectsFound[$_REQUEST['object_type']] = $result->num_rows;
	}
}

$TotalNoOfAllObjectsFound = 0;
foreach ($TotalNoOfObjectsFound as $key => $value)
	$TotalNoOfAllObjectsFound += $value;

$ObjectsXML = '';

if ($_REQUEST['object_type'] == 'all') {
	$FoundObjects = 0;
	$RemainObjects = $ObjectsPerPage;
	$ScannedObjects = 0;
	$BreakHeart = false;
	$TargetLimit = 0;

	foreach ($TotalNoOfObjectsFound as $key => $value) {
		if ($RemainObjects <= 0) {
			break;
		}
		if ($ScannedObjects + $value > $Offset && $value > 0) {
			$ThisOffset = 0;
			if (!$BreakHeart) {
				$ThisOffset = $Offset - $ScannedObjects;
				$ScannedObjects = $ScannedObjects + $value;
				$TargetLimit = min($value - $ThisOffset, $ObjectsPerPage, $RemainObjects);
				$BreakHeart = true;
			}
			else {
				$ThisOffset = 0;
				$ScannedObjects = $ScannedObjects + $value;
				$TargetLimit = min($value, $ObjectsPerPage, $RemainObjects);
				$FoundObjects = $FoundObjects + min($value, $ObjectsPerPage, $RemainObjects);
				$RemainObjects = $RemainObjects - min($value, $ObjectsPerPage, $RemainObjects);
			}
			$FoundObjects = $FoundObjects + $TargetLimit;
			$RemainObjects = $RemainObjects - $TargetLimit;

			$query = GetSQLText($key);
			$query = $query . "	LIMIT " . $ThisOffset . ", " . $TargetLimit;

			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			while ($myResult = $result->fetch_assoc()) {
				$DetectedLangID = intval($myResult['language_id']) > 0 ? intval($myResult['language_id']) : $_REQUEST['lang_id'];
				$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $DetectedLangID, $Site);
				$smarty->assign('Object', $myResult);
				if ($myResult['object_type'] == 'PRODUCT') {
					$ProductXML = product::GetProductXML($myResult['object_link_id'], $_REQUEST['lang_id'], false, 1, 999999, $_REQUEST['security_level'], false, 1, 999999, true, null, null, $Site);
					$ObjectsXML = $ObjectsXML . $ProductXML;
				}
				elseif ($myResult['object_type'] == 'PAGE')
					$ObjectsXML = $ObjectsXML . $smarty->fetch('api/object_info/PAGE.tpl');
				elseif ($myResult['object_type'] == 'LAYOUT_NEWS')
					$ObjectsXML = $ObjectsXML . $smarty->fetch('api/object_info/LAYOUT_NEWS.tpl');
				elseif ($myResult['object_type'] == 'ALBUM')
					$ObjectsXML = $ObjectsXML . $smarty->fetch('api/object_info/ALBUM.tpl');
				elseif ($myResult['object_type'] == 'MEDIA')
					$ObjectsXML = $ObjectsXML . $smarty->fetch('api/object_info/MEDIA.tpl');
				elseif ($myResult['object_type'] == 'NEWS')
					$ObjectsXML = $ObjectsXML . $smarty->fetch('api/object_info/NEWS.tpl');
				elseif ($myResult['object_type'] == 'BONUS_POINT_ITEM')
					$ObjectsXML = $ObjectsXML . $smarty->fetch('api/object_info/BONUS_POINT_ITEM.tpl');
			}
		}
		else
			$ScannedObjects = $ScannedObjects + $value;
	}
}
else {
	$query = GetSQLText($_REQUEST['object_type']);
	$query = $query . "	LIMIT " . $Offset . ", " . intval($ObjectsPerPage);
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	while ($myResult = $result->fetch_assoc()) {
		$DetectedLangID = intval($myResult['language_id']) > 0 ? intval($myResult['language_id']) : $_REQUEST['lang_id'];
		$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $DetectedLangID, $Site);
		$smarty->assign('Object', $myResult);
		if ($myResult['object_type'] == 'PRODUCT') {
			$ProductXML = product::GetProductXML($myResult['object_link_id'], $_REQUEST['lang_id'], false, 1, 999999, $_REQUEST['security_level'], false, 1, 999999, true, null, null, $Site);
			$ObjectsXML = $ObjectsXML . $ProductXML;
		}
		elseif ($myResult['object_type'] == 'PAGE')
			$ObjectsXML = $ObjectsXML . $smarty->fetch('api/object_info/PAGE.tpl');
		elseif ($myResult['object_type'] == 'LAYOUT_NEWS')
			$ObjectsXML = $ObjectsXML . $smarty->fetch('api/object_info/LAYOUT_NEWS.tpl');
		elseif ($myResult['object_type'] == 'ALBUM')
			$ObjectsXML = $ObjectsXML . $smarty->fetch('api/object_info/ALBUM.tpl');
		elseif ($myResult['object_type'] == 'MEDIA')
			$ObjectsXML = $ObjectsXML . $smarty->fetch('api/object_info/MEDIA.tpl');
		elseif ($myResult['object_type'] == 'NEWS')
			$ObjectsXML = $ObjectsXML . $smarty->fetch('api/object_info/NEWS.tpl');
		elseif ($myResult['object_type'] == 'BONUS_POINT_ITEM')
			$ObjectsXML = $ObjectsXML . $smarty->fetch('api/object_info/BONUS_POINT_ITEM.tpl');
	}
}

$smarty->assign('TotalNoOfObjects', $TotalNoOfAllObjectsFound);
$smarty->assign('SearchKey', trim($_REQUEST['search_text']));
$smarty->assign('PageNo', $PageNo);
$smarty->assign('ObjectsXML', $ObjectsXML);
$Data = $smarty->fetch('api/search.tpl');

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');