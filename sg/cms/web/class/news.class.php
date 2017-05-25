<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class news {

	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetAllNewsRootBySiteID($SiteID) {
		$query =	"	SELECT		* " .
					"	FROM		news_root R	JOIN object O ON (R.news_root_id = O.object_id) " .
					"	WHERE		O.site_id = '" . intval($SiteID) . "'" .
					"	ORDER BY	R.language_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$NewsRoots = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($NewsRoots, $myResult);
		}
		return $NewsRoots;
	}

	public static function GetNewsCategoryList($LanguageID, $SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	news_category C	JOIN object O ON (C.news_category_id = O.object_id) " .
					"	WHERE	C.language_id =  '" . intval($LanguageID) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$NewsCategories = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($NewsCategories, $myResult);
		}
		return $NewsCategories;
	}

	public static function GetNewsRootList($LanguageID, $SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	news_root R	JOIN object O ON (R.news_root_id = O.object_id) " .
					"	WHERE	R.language_id =  '" . intval($LanguageID) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$NewsRoots = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($NewsRoots, $myResult);
		}
		return $NewsRoots;
	}

	public static function GetTotalNumOfNewsByNewsRootID($NewsRootID) {
		$query =	"	SELECT	* " .
					"	FROM	news R " .
					"	WHERE	R.news_root_id =  '" . intval($NewsRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		return $result->num_rows;
	}

	public static function GetNewsListByNewsRootID($NewsRootID, &$TotalNewsNum, $PageNo = 1, $NewsPerPage = 20, $NewsID = '', $NewsDate = '', $NewsTitle = '', $NewsCategoryID = '', $NewsTag = '', $HonorArchiveDate = false, $HonorPublishDate = false, $SecurityLevel = null) {
		$Offset = intval(($PageNo -1) * $NewsPerPage);

		$sql = '';
		if (trim($NewsID) != '')
			$sql = $sql . "	AND R.news_id = '" . aveEscT($NewsID) . "' ";
		if (trim($NewsDate) != '')
			$sql = $sql . "	AND R.news_date >= '" . aveEscT($NewsDate) . " 00:00:00' AND R.news_date <= '" . aveEscT($NewsDate) . " 23:59:59' ";
		if (trim($NewsTitle) != '')
			$sql = $sql . "	AND R.news_title LIKE '%" . aveEscT($NewsTitle) . "%' ";
		if (intval($NewsCategoryID) != 0)
			$sql = $sql . "	AND R.news_category_id = '" . intval($NewsCategoryID) . "' ";
		if (strlen(trim($NewsTag)) > 0)
			$sql = $sql . " AND R.news_tag  LIKE '%, " . aveEscT($NewsTag) . ",%'";
		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	RO.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	RO.object_publish_date < NOW() ";
		if ($SecurityLevel !== null)
			$sql	=	$sql . "	AND	RO.object_security_level <= '" . intval($SecurityLevel) . "'";


		$query =	"	SELECT	SQL_CALC_FOUND_ROWS * " .
					"	FROM	news R	JOIN	object RO		ON	(R.news_id = RO.object_id) " .
					"					JOIN	news_root RR	ON	(R.news_root_id = RR.news_root_id) " .
					"					JOIN	news_category C	ON	(R.news_category_id = C.news_category_id) " .
					"	WHERE	RR.news_root_id =  '" . intval($NewsRootID) . "'" . $sql .
					"	ORDER BY R.news_date DESC " .
					"	LIMIT	" . $Offset . ", " . intval($NewsPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalNewsNum = $myResult[0];			

		$NewsList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($NewsList, $myResult);
		}
		return $NewsList;
	}

	public static function NewNewsRoot($ObjectID, $NewsRootName, $LanguageID) {
		$query =	"	INSERT INTO news_root " .
					"	SET		news_root_id	= '" . intval($ObjectID) . "', " .
					"			news_root_name	= '" . aveEscT($NewsRootName) . "', " .
					"			language_id	= '" . intval($LanguageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetNewsRootInfo($NewsRootID) {
		$query =	"	SELECT	* " .
					"	FROM	news_root R	JOIN object RO	ON (R.news_root_id = RO.object_id) " .
					"	WHERE	R.news_root_id =  '" . intval($NewsRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function NewNewsPage($ObjectID, $NewsRootID, $NewsCategoryID = 0) {
		$query =	"	INSERT INTO news_page " .
					"	SET		news_page_id		= '" . intval($ObjectID) . "', " .
					"			news_root_id		= '" . intval($NewsRootID) . "', " .
					"			news_category_id	= '" . intval($NewsCategoryID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function NewNewsCategory($ObjectID, $NewsCategoryName, $LanguageID) {
		$query =	"	INSERT INTO news_category " .
					"	SET		news_category_id	= '" . intval($ObjectID) . "', " .
					"			news_category_name	= '" . aveEscT($NewsCategoryName) . "', " .
					"			language_id	= '" . intval($LanguageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetNewsCategoryInfo($NewsCategoryID) {
		$query =	"	SELECT	* " .
					"	FROM	news_category NC JOIN object NCO	ON (NC.news_category_id = NCO.object_id) " .
					"	WHERE	NC.news_category_id =  '" . intval($NewsCategoryID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetNewsPageInfo($NewsPageID) {
		$query =	"	SELECT	* " .
					"	FROM	object_link OL	JOIN	object O		ON	(OL.object_id = O.object_id) " .
					"							JOIN	news_page NP	ON	(NP.news_page_id = O.object_id) " .
					"	WHERE	NP.news_page_id =  '" . intval($NewsPageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function CloneNewsPage($NewsPage, $SrcSite, $DstParentObjID, $DstLanguageID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($NewsPage['object_link_id']) <= 0)
			customdb::err_die(1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__, true);

		object::CloneObjectWithObjectLink($NewsPage, $SrcSite, $DstParentObjID, $DstLanguageID, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName, $DstSite);

		$DstNewsRootID = intval($NewsPage['news_root_id']);
		$DstNewsCatID = intval($NewsPage['news_category_id']);
		if ($DstSite['site_id'] != $SrcSite['site_id']) {
			$DstNewsRootID = object::GetNewObjectIDFromOriginalCloneFromID($DstNewsRootID, $DstSite['site_id'], false);
			$DstNewsCatID = object::GetNewObjectIDFromOriginalCloneFromID($DstNewsCatID, $DstSite['site_id'], false);
		}

		$query =	"	INSERT INTO news_page " .
					"	SET		news_page_id		= '" . intval($NewObjectID) . "', " .
					"			news_root_id		= '" . intval($DstNewsRootID) . "', " .
					"			news_category_id	= '" . intval($DstNewsCatID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function NewNews($ObjectID, $NewsRootID, $Title, $Summary, $Content, $Date, $Tag, $NewsCategoryID) {
		$query =	"	INSERT INTO news " .
					"	SET		news_id				= '" . intval($ObjectID) . "', " .
					"			news_root_id		= '" . intval($NewsRootID) . "', " .
					"			news_title			= '" . aveEscT($Title) . "', " .
					"			news_summary		= '" . aveEscT($Summary) . "', " .
					"			news_content		= '" . aveEscT($Content) . "', " .
					"			news_date			= '" . aveEscT($Date) . "', " .
					"			news_tag			= '" . aveEsc($Tag) . "', " .
					"			news_category_id	= '" . intval($NewsCategoryID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetNewsInfo($NewsID) {
		$query =	"	SELECT	* " .
					"	FROM	news N	JOIN	object NO	ON	(N.news_id = NO.object_id) " .
					"					JOIN	news_root R	ON	(N.news_root_id = R.news_root_id) " .
					"					JOIN	news_category C	ON	(N.news_category_id = C.news_category_id) " .
					"	WHERE	N.news_id =  '" . intval($NewsID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function DeleteNews($NewsID) {
		$query =	"	DELETE FROM news " .
					"	WHERE	news_id	= '" . intval($NewsID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($NewsID);
	}

	public static function DeleteNewsPage($ObjectID) {
		$query =	"	DELETE FROM	news_page " .
					"	WHERE	news_page_id	= '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($ObjectID);

		// Delete all object links
		$query =	"	SELECT	* " .
					"	FROM	object_link " .
					"	WHERE	object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$ParentIDs = array();
		while ($myResult = $result->fetch_assoc())
			array_push($ParentIDs, $myResult['parent_object_id']);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id = '" . intval($ObjectID) . "'" .
					"			OR	object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		foreach ($ParentIDs as $ID)
			object::TidyUpObjectOrder($ID);
	}

	public static function DeleteNewsCategory($NewsCategoryID) {
		$query =	"	SELECT	* " .
					"	FROM	news R	JOIN	news_category C	ON	(R.news_category_id = C.news_category_id) " .
					"	WHERE	C.news_category_id =  '" . intval($NewsCategoryID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		while ($myResult = $result->fetch_assoc()) {
			news::DeleteNews($myResult['news_id']);
		}

		$query =	"	DELETE FROM news_category " .
					"	WHERE	news_category_id	= '" . intval($NewsCategoryID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($NewsCategoryID);
	}

	public static function DeleteNewsRoot($NewsRootID) {
		$query =	"	SELECT	* " .
					"	FROM	news R	JOIN	news_root RR	ON	(R.news_root_id = RR.news_root_id) " .
					"	WHERE	RR.news_root_id =  '" . intval($NewsRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		while ($myResult = $result->fetch_assoc()) {
			news::DeleteNews($myResult['news_id']);
		}

		$query =	"	DELETE FROM news_root " .
					"	WHERE	news_root_id	= '" . intval($NewsRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($NewsRootID);

		$query =	"	SELECT	* " .
					"	FROM	news_page P	" .
					"	WHERE	P.news_root_id =  '" . intval($NewsRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		while ($myResult = $result->fetch_assoc()) {
			news::DeleteNewsPage($myResult['news_page_id']);
		}
	}

	public static function GetNewsListXML(&$TotalNoOfNews, $NewsRootID, $NewsCategoryID, $Tag, $SecurityLevel, $Offset = 0, $RowCount = 20, $DateSearch = 'N', $DateFrom = '', $DateTo = '', $IncludeNewsContent = 'N') {
		$smarty = new mySmarty();

		$sql = '';
		if ($NewsCategoryID != 0)
			$sql = " AND C.news_category_id = '" . intval($NewsCategoryID) . "'";

		$tag_sql = '';
		if (strlen(trim($Tag)) > 0)
			$tag_sql = " AND R.news_tag  LIKE '%, " . aveEscT($Tag) . ",%'";

		$date_sql = '';
		if ($DateSearch == 'Y')
			$date_sql = "	AND	R.news_date >= '" . aveEscT($DateFrom) . "' AND R.news_date <= '" . aveEscT($DateTo) . "'";

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS * " .
					"	FROM	news R	JOIN	object RO		ON	(R.news_id = RO.object_id) " .
					"					JOIN	news_root RR	ON	(R.news_root_id = RR.news_root_id) " .
					"					JOIN	news_category C	ON	(R.news_category_id = C.news_category_id) " .
					"	WHERE	RO.object_security_level <= '" . intval($SecurityLevel) . "' " .
					"		AND	RO.object_is_enable = 'Y' " .
					"		AND	RO.object_archive_date > NOW() " .
					"		AND	RO.object_publish_date < NOW() " .
					"		AND	RO.is_removed = 'N' " .
					"		AND	RR.news_root_id =  '" . intval($NewsRootID) . "'" . $sql . $tag_sql . $date_sql .
					"	ORDER BY R.news_date DESC " .
					"	LIMIT	" . $Offset . ", " . intval($RowCount);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalNoOfNews = $myResult[0];

		$XML = '';
		while ($myResult = $result->fetch_assoc()) {
			if ($IncludeNewsContent == 'N')
				$myResult['news_content'] = '';				
			$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $myResult['language_id'], null);
			$smarty->assign('Object', $myResult);
			$XML = $XML . $smarty->fetch('api/object_info/NEWS.tpl');
		}
		return $XML;
	}

	public static function GetNewsCategoryListXML($LanguageID, $SiteID) {
		$smarty = new mySmarty();

		$NewsCategoryList = news::GetNewsCategoryList($LanguageID, $SiteID);

		$Site = site::GetSiteInfo($SiteID);

		$NewsCategoryListXML = '';
		foreach ($NewsCategoryList as $NC) {
			$NC['object_seo_url'] = object::GetSeoURL($NC, '', $LanguageID, $Site);
			$smarty->assign('Object', $NC);
			$NewsCategoryListXML = $NewsCategoryListXML . $smarty->fetch('api/object_info/NEWS_CATEGORY.tpl');
		}
		return "<news_category_list>" . $NewsCategoryListXML . "</news_category_list>";
	}

	public static function GetNewsXML($NewsID, $MediaPageNo = 1, $MediaPerPage = 999999, $SecurityLevel = 999999) {
		$smarty = new mySmarty();

		$News = news::GetNewsInfo($NewsID);

		$AlbumXML = '';
		if ($News['album_id'] != 0) {				
			$Album = album::GetAlbumInfo($News['album_id'], $News['language_id']);
			if (strtotime($Album['object_archive_date']) > time() && strtotime($Album['object_publish_date']) < time() ) {
				$AlbumXML = album::GetAlbumXML($News['album_id'], 0, $News['language_id'], $MediaPageNo, $MediaPerPage, $SecurityLevel);
				$smarty->assign('AlbumXML', $AlbumXML);
			}
		}
		$News['object_seo_url'] = object::GetSeoURL($News, '', $News['language_id'], null);
		$smarty->assign('Object', $News);

		return $smarty->fetch('api/object_info/NEWS.tpl');
	}

	public static function GetNoOfNews($SiteID) {
		$query =	"	SELECT	COUNT(object_id) AS NoOfObjects " .
					"	FROM	object	" .
					"	WHERE	site_id		= '" . intval($SiteID) . "'" .
					"		AND	object_type	= 'NEWS' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result->fetch_assoc();

		return $myResult['NoOfObjects'];
	}

	public static function UpdateTimeStamp($NewsID, $DateTime = null) {
		object::UpdateObjectTimeStamp($NewsID, $DateTime);
	}

	//	return TRUE if error seems temporary
	//	return FALSE if error seems fatal (e.g. Over Quota, No Site Language is enabled)
	public static function ImportNews($Site, $NewsXML, &$NoOfNewsParsed, &$NoOfNewsImported, &$NoOfNewsFailed, &$SuccessXMLString, &$ErrorXMLString, $RealWrite = 'N') {
		$smarty = new mySmarty();

		$NoOfNewsParsed++;
		$smarty->assign('import_ref_id', $NewsXML->import_ref_id);
		$smarty->assign('msg', '');

		if ($Site['site_module_news_enable'] != 'Y') {
			$smarty->assign('msg', ADMIN_MSG_MODULE_DISABLED_NEWS);
			$NoOfNewsFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/NEWS.tpl');
			return false;
		}

		$NoOfNews = news::GetNoOfNews($Site['site_id']);
		if ($NoOfNews >= $Site['site_module_news_quota']) {
			$smarty->assign('msg', ADMIN_ERROR_NEWS_QUOTA_FULL);
			$NoOfNewsFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/NEWS.tpl');
			return false;
		}

		$NewsRoot = news::GetNewsRootInfo($NewsXML->news_root_id);
		if ($NewsRoot['site_id'] != $Site['site_id']) {
			$smarty->assign('msg', 'news_root_id: This is not your object.');
			$NoOfNewsFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/NEWS.tpl');
			return false;
		}

		$NewsCategory = news::GetNewsCategoryInfo($NewsXML->news_category_id);
		if ($NewsCategory['site_id'] != $Site['site_id']) {
			$smarty->assign('msg', 'news_category_id: This is not your object.');
			$NoOfNewsFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/NEWS.tpl');
			return false;
		}

		$SiteLanguageRoot = language::GetSiteLanguageRoot($NewsXML->language_id, $Site['site_id']);
		if ($SiteLanguageRoot == null) {
			$smarty->assign('msg', 'language_id: not enabled.');
			$NoOfNewsFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/NEWS.tpl');
			return false;
		}

		// SHOULD BE ALL CLEAR HERE!!!!
		if ($RealWrite != 'Y') {
			$NoOfNewsImported++;
			$SuccessXMLString = $smarty->fetch('api/import/NEWS.tpl');
			return true;
		}
		else {
			// DO REAL IMPORT STUFF HERE!!!!!!!!!!!!!!!!!!!

			$tags = explode(",", $NewsXML->news_tag);
			$NewsTagText = ', ';
			foreach ($tags as $T)
				$NewsTagText = $NewsTagText . trim($T) . ", ";

			$NewsID = object::NewObject('NEWS', $Site['site_id'], intval($NewsXML->object_security_level));
			object::UpdateObjectSEOData($NewsID, $NewsXML->object_meta_title, $NewsXML->object_meta_description, $NewsXML->object_meta_keywords, $NewsXML->object_friendly_url);
			news::NewNews($NewsID, intval($NewsXML->news_root_id), $NewsXML->news_title, $NewsXML->news_summary, $NewsXML->news_content, $NewsXML->news_date, $NewsTagText, intval($NewsCategory['news_category_id']));
			news::UpdateTimeStamp($NewsID);

			site::EmptyAPICache($Site['site_id']);
			$NoOfNewsImported++;
			$SuccessXMLString = $smarty->fetch('api/import/NEWS.tpl');
			return true;
		}
	}

	public static function CloneAllNewsCategory($SrcSite, $SrcLanguageID, $DstLanguageID, $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		$NewsCategories = news::GetNewsCategoryList($SrcLanguageID, $SrcSite['site_id']);

		foreach ($NewsCategories as $C)
			news::CloneNewsCat($C, $SrcSite, $DstLanguageID, $NewObjectID, 'N', $DstSite);
	}

	public static function CloneNewsCat($NewsCat, $SrcSite, $DstLanguageID, &$NewObjectID, $AddCopyOfToNewsCatName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		object::CloneObject($NewsCat, $SrcSite, $NewObjectID, $DstSite);

		$NewNewsCatName = $NewsCat['news_category_name'];
		if ($AddCopyOfToLayoutNewsCatName == 'Y')
			$NewNewsCatName = "Copy of " . $NewNewsCatName;

		$query =	"	INSERT INTO news_category " .
					"	SET		news_category_id	= '" . intval($NewObjectID) . "', " .
					"			news_category_name = '" . aveEscT($NewNewsCatName) . "', " .
					"			language_id = '" . intval($DstLanguageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function CloneNews($News, $SrcSite, $DstNewsRootID, $DstNewsCatID, $DstLanguageID, &$NewObjectID, $AddCopyOfToNewsTitle = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		object::CloneObject($News, $SrcSite, $NewObjectID, $DstSite);

		$NewNewsTitle = $News['news_title'];
		if ($AddCopyOfToNewsTitle == 'Y')
			$NewNewsTitle = "Copy of " . $NewNewsTitle;

		$DstAlbumID = intval($LayoutNews['album_id']);			
		if ($DstSite['site_id'] != $SrcSite['site_id']) {
			$DstAlbumID = object::GetNewObjectIDFromOriginalCloneFromID($DstAlbumID, $DstSite['site_id'], false);
		}

		$query =	"	INSERT INTO news " .
					"	SET		news_id	= '" . intval($NewObjectID) . "', " .
					"			news_root_id = '" . intval($DstNewsRootID) . "', " .
					"			news_title = '" . aveEscT($NewNewsTitle) . "', " .
					"			news_summary = '" . aveEscT($News['news_summary']) . "', " .
					"			news_content = '" . aveEscT($News['news_content']) . "', " .
					"			news_date = '" . aveEscT($News['news_date']) . "', " .
					"			news_tag = '" . aveEscT($News['news_tag']) . "', " .
					"			news_category_id = '" . intval($DstNewsCatID) . "', " .
					"			album_id	= '" . intval($DstAlbumID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function CloneNewsRoot($NewsRoot, $SrcSite, $DstLanguageID, &$NewObjectID, $AddCopyOfToNewsRootName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		object::CloneObject($NewsRoot, $SrcSite, $NewObjectID, $DstSite);

		$NewNewsRootName = $NewsRoot['news_root_name'];
		if ($AddCopyOfToLayoutNewsRootName == 'Y')
			$NewNewsRootName = "Copy of " . $NewNewsRootName;

		$query =	"	INSERT INTO news_root " .
					"	SET		news_root_id	= '" . intval($NewObjectID) . "', " .
					"			news_root_name = '" . aveEscT($NewNewsRootName) . "', " .
					"			language_id = '" . intval($DstLanguageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$NewsList = news::GetNewsListByNewsRootID($NewsRoot['news_root_id'], $NumOfNews, 1, 999999, '', '', '', '', '', false, false, null);

		$DstNewsRootID = $NewsRoot['news_root_id'];
		if ($DstSite['site_id'] != $SrcSite['site_id']) {
			$DstNewsRootID = object::GetNewObjectIDFromOriginalCloneFromID($DstNewsRootID, $DstSite['site_id']);
		}

		foreach ($NewsList as $N) {
			$DstNewsCatID = $N['news_category_id'];
			if ($DstSite['site_id'] != $SrcSite['site_id']) {
				$DstNewsCatID = object::GetNewObjectIDFromOriginalCloneFromID($DstNewsCatID, $DstSite['site_id']);
			}

			news::CloneNews($N, $SrcSite, $DstNewsRootID, $DstNewsCatID, $DstLanguageID, $NewNewsID, 'N', $DstSite);
		}
	}

}