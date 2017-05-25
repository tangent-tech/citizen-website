<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class layout_news {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetLayoutNewsRootList($LanguageID, $SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	layout_news_root R	JOIN object O ON (R.layout_news_root_id = O.object_id) " .
					"	WHERE	R.language_id =  '" . intval($LanguageID) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$LayoutNewsRoots = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($LayoutNewsRoots, $myResult);
		}
		return $LayoutNewsRoots;
	}

	public static function GetLayoutNewsCategoryList($LanguageID, $SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	layout_news_category C	JOIN object O ON (C.layout_news_category_id = O.object_id) " .
					"	WHERE	C.language_id =  '" . intval($LanguageID) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$LayoutNewsCategories = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($LayoutNewsCategories, $myResult);
		}
		return $LayoutNewsCategories;
	}

	public static function NewLayoutNewsCategory($ObjectID, $LayoutNewsCategoryName, $LanguageID) {
		$query =	"	INSERT INTO layout_news_category " .
					"	SET		layout_news_category_id		= '" . intval($ObjectID) . "', " .
					"			layout_news_category_name	= '" . aveEscT($LayoutNewsCategoryName) . "', " .
					"			language_id	= '" . intval($LanguageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetLayoutNewsCategoryInfo($LayoutNewsCategoryID) {
		$query =	"	SELECT	* " .
					"	FROM	layout_news_category NC JOIN object NCO	ON (NC.layout_news_category_id = NCO.object_id) " .
					"	WHERE	NC.layout_news_category_id =  '" . intval($LayoutNewsCategoryID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function NewLayoutNewsRoot($ObjectID, $LayoutNewsRootName, $LanguageID) {
		$query =	"	INSERT INTO layout_news_root " .
					"	SET		layout_news_root_id		= '" . intval($ObjectID) . "', " .
					"			layout_news_root_name	= '" . aveEscT($LayoutNewsRootName) . "', " .
					"			language_id	= '" . intval($LanguageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetLayoutNewsRootInfo($LayoutNewsRootID) {
		$query =	"	SELECT	* " .
					"	FROM	layout_news_root R	JOIN object RO	ON (R.layout_news_root_id = RO.object_id) " .
					"	WHERE	R.layout_news_root_id =  '" . intval($LayoutNewsRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetTotalNumOfLayoutNewsByLayoutNewsRootID($LayoutNewsRootID) {
		$query =	"	SELECT	* " .
					"	FROM	layout_news R " .
					"	WHERE	R.layout_news_root_id =  '" . intval($LayoutNewsRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		return $result->num_rows;
	}

	public static function GetLayoutNewsListByLayoutNewsRootID($LayoutNewsRootID, &$TotalLayoutNewsNum, $PageNo = 1, $LayoutNewsPerPage = 20, $LayoutNewsID = '', $LayoutNewsDate = '', $LayoutNewsTitle = '', $LayoutNewsCategoryID = '', $LayoutNewsTag = '') {
		$Offset = intval(($PageNo -1) * $LayoutNewsPerPage);

		$sql = '';
		if (trim($LayoutNewsID) != '')
			$sql = $sql . "	AND R.layout_news_id = '" . aveEscT($LayoutNewsID) . "' ";
		if (trim($LayoutNewsDate) != '')
			$sql = $sql . "	AND R.layout_news_date >= '" . aveEscT($LayoutNewsDate) . " 00:00:00' AND R.layout_news_date <= '" . aveEscT($LayoutNewsDate) . " 23:59:59' ";
		if (trim($LayoutNewsTitle) != '')
			$sql = $sql . "	AND R.layout_news_title LIKE '%" . aveEscT($LayoutNewsTitle) . "%' ";
		if (intval($LayoutNewsCategoryID) != 0)
			$sql = $sql . "	AND R.layout_news_category_id = '" . intval($LayoutNewsCategoryID) . "' ";
		if (strlen(trim($LayoutNewsTag)) > 0)
			$sql = $sql . " AND R.layout_news_tag  LIKE '%, " . aveEscT($LayoutNewsTag) . ",%'";		

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS * " .
					"	FROM	layout_news R	JOIN	object RO				ON	(R.layout_news_id = RO.object_id) " .
					"							JOIN	layout_news_root RR		ON	(R.layout_news_root_id = RR.layout_news_root_id) " .
					"							JOIN	layout_news_category C	ON	(R.layout_news_category_id = C.layout_news_category_id) " .
					"	WHERE	RR.layout_news_root_id =  '" . intval($LayoutNewsRootID) . "'" . $sql .
					"	ORDER BY R.layout_news_date DESC " .
					"	LIMIT	" . $Offset . ", " . $LayoutNewsPerPage;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalLayoutNewsNum = $myResult[0];

		$LayoutNewsList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($LayoutNewsList, $myResult);
		}
		return $LayoutNewsList;
	}

	public static function GetLayoutNewsListByLayoutNewsRootIDEX($LayoutNewsRootID, $Offset = 0, $RowCount = 20) {
		$query =	"	SELECT	* " .
					"	FROM	layout_news R	JOIN	object RO				ON	(R.layout_news_id = RO.object_id) " .
					"							JOIN	layout_news_root RR		ON	(R.layout_news_root_id = RR.layout_news_root_id) " .
					"							JOIN	layout_news_category C	ON	(R.layout_news_category_id = C.layout_news_category_id) " .
					"	WHERE	RR.layout_news_root_id =  '" . intval($LayoutNewsRootID) . "'" .
					"	ORDER BY R.layout_news_date DESC, RO.object_id DESC " .
					"	LIMIT	" . $Offset . ", " . $RowCount;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$LayoutNewsList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($LayoutNewsList, $myResult);
		}
		return $LayoutNewsList;
	}

	public static function GetAllLayoutNewsRootBySiteID($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	layout_news_root R	JOIN object O ON (R.layout_news_root_id = O.object_id) " .
					"	WHERE	O.site_id = '" . intval($SiteID) . "'" . 
					"	ORDER BY R.language_id, R.layout_news_root_id" ;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$LayoutNewsRoots = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($LayoutNewsRoots, $myResult);
		}
		return $LayoutNewsRoots;			
	}

	public static function GetNoOfLayoutNews($SiteID) {
		$query =	"	SELECT	COUNT(object_id) AS NoOfObjects " .
					"	FROM	object	" .
					"	WHERE	site_id		= '" . intval($SiteID) . "'" .
					"		AND	object_type	= 'LAYOUT_NEWS' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result->fetch_assoc();

		return $myResult['NoOfObjects'];
	}

	public static function NewLayoutNews($ObjectID, $LayoutNewsRootID, $Title, $Date, $Tag, $LayoutNewsCategoryID, $LayoutID, $AlbumID) {
		$query =	"	INSERT INTO layout_news " .
					"	SET		layout_news_id			= '" . intval($ObjectID) . "', " .
					"			layout_news_root_id		= '" . intval($LayoutNewsRootID) . "', " .
					"			layout_news_title		= '" . aveEscT($Title) . "', " .
					"			layout_news_date		= '" . aveEscT($Date) . "', " .
					"			layout_news_tag			= '" . aveEsc($Tag) . "', " .
					"			layout_news_category_id	= '" . intval($LayoutNewsCategoryID) . "', " .
					"			layout_id				= '" . intval($LayoutID) . "', " .
					"			album_id				= '" . intval($AlbumID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetLayoutNewsInfo($LayoutNewsID) {
		$query =	"	SELECT	* " .
					"	FROM	layout_news	N	JOIN		object NO				ON	(N.layout_news_id = NO.object_id) " .
					"							JOIN		layout_news_root R		ON	(N.layout_news_root_id = R.layout_news_root_id) " .
					"							JOIN		layout_news_category C	ON	(N.layout_news_category_id = C.layout_news_category_id) " .
					"							LEFT JOIN	layout L 				ON	(N.layout_id = L.layout_id) " .
					"	WHERE	N.layout_news_id =  '" . intval($LayoutNewsID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function UpdateTimeStamp($LayoutNewsID) {
		object::UpdateObjectTimeStamp($LayoutNewsID);
	}

	public static function DeleteLayoutNewsCategory($LayoutNewsCategoryID, $Site) {
		$query =	"	SELECT	* " .
					"	FROM	layout_news R	JOIN	layout_news_category C	ON	(R.layout_news_category_id = C.layout_news_category_id) " .
					"	WHERE	C.layout_news_category_id =  '" . intval($LayoutNewsCategoryID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		while ($myResult = $result->fetch_assoc()) {
			layout_news::DeleteLayoutNews($myResult['layout_news_id'], $Site);
		}

		$query =	"	DELETE FROM layout_news_category " .
					"	WHERE	layout_news_category_id	= '" . intval($LayoutNewsCategoryID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($LayoutNewsCategoryID);
	}

	public static function DeleteLayoutNews($ObjectID, $Site) {
		$LayoutNews = layout_news::GetLayoutNewsInfo($ObjectID);
		if ($LayoutNews == null)
			return;

		$BlockDefs = block::GetBlockDefListByLayoutID($LayoutNews['layout_id']);
		foreach ($BlockDefs as $BD) {
			$BlockHolder = block::GetBlockHolderByPageID($LayoutNews['layout_news_id'], $BD['block_definition_id']);
			block::DeleteBlockHolder($BlockHolder['block_holder_id'], $Site);
		}

		// DELETE OBJECT AND BLOCKHOLDER RECORD
		object::DeleteObject($ObjectID);

		$query =	"	DELETE FROM	layout_news " .
					"	WHERE	layout_news_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

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

	public static function DeleteLayoutNewsRoot($LayoutNewsRootID, $Site) {
		$query =	"	SELECT	* " .
					"	FROM	layout_news R	JOIN	layout_news_root RR		ON	(R.layout_news_root_id = RR.layout_news_root_id) " .
					"	WHERE	RR.layout_news_root_id =  '" . intval($LayoutNewsRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		while ($myResult = $result->fetch_assoc()) {
			layout_news::DeleteLayoutNews($myResult['layout_news_id'], $Site);
		}

		$query =	"	DELETE FROM layout_news_root " .
					"	WHERE	layout_news_root_id	= '" . intval($LayoutNewsRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($LayoutNewsRootID);

		$query =	"	SELECT	* " .
					"	FROM	layout_news_page P	" .
					"	WHERE	P.layout_news_root_id =  '" . intval($LayoutNewsRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		while ($myResult = $result->fetch_assoc()) {
			layout_news::DeleteLayoutNewsPage($myResult['layout_news_page_id']);
		}
	}

	public static function DeleteLayoutNewsPage($ObjectID) {
		$query =	"	DELETE FROM	layout_news_page " .
					"	WHERE	layout_news_page_id	= '" . intval($ObjectID) . "'";
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

	public static function NewLayoutNewsPage($ObjectID, $LayoutNewsRootID, $LayoutNewsCategoryID = 0) {
		$query =	"	INSERT INTO layout_news_page " .
					"	SET		layout_news_page_id		= '" . intval($ObjectID) . "', " .
					"			layout_news_root_id		= '" . intval($LayoutNewsRootID) . "', " .
					"			layout_news_category_id	= '" . intval($LayoutNewsCategoryID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetLayoutNewsPageInfo($LayoutNewsPageID) {
		$query =	"	SELECT	* " .
					"	FROM	object_link OL	JOIN	object O			ON	(OL.object_id = O.object_id) " .
					"							JOIN	layout_news_page NP	ON	(NP.layout_news_page_id = O.object_id) " .
					"	WHERE	NP.layout_news_page_id =  '" . intval($LayoutNewsPageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function CloneLayoutNewsRoot($LayoutNewsRoot, $SrcSite, $DstLanguageID, &$NewObjectID, $AddCopyOfToLayoutNewsRootName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		object::CloneObject($LayoutNewsRoot, $SrcSite, $NewObjectID, $DstSite);

		$NewNewsRootName = $LayoutNewsRoot['layout_news_root_name'];
		if ($AddCopyOfToLayoutNewsRootName == 'Y')
			$NewNewsRootName = "Copy of " . $NewNewsRootName;

		$query =	"	INSERT INTO layout_news_root " .
					"	SET		layout_news_root_id	= '" . intval($NewObjectID) . "', " .
					"			layout_news_root_name = '" . aveEscT($NewNewsRootName) . "', " .
					"			language_id = '" . intval($DstLanguageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$LayoutNewsList = layout_news::GetLayoutNewsListByLayoutNewsRootID($LayoutNewsRoot['layout_news_root_id'], $NumOfLayoutNews, 1, 999999, '', '', '', '', '');

		$DstLayoutNewsRootID = $LayoutNewsRoot['layout_news_root_id'];
		if ($DstSite['site_id'] != $SrcSite['site_id']) {
			$DstLayoutNewsRootID = object::GetNewObjectIDFromOriginalCloneFromID($DstLayoutNewsRootID, $DstSite['site_id']);
		}

		foreach ($LayoutNewsList as $N) {
			$DstLayoutNewsCatID = $N['layout_news_category_id'];
			if ($DstSite['site_id'] != $SrcSite['site_id']) {
				$DstLayoutNewsCatID = object::GetNewObjectIDFromOriginalCloneFromID($DstLayoutNewsCatID, $DstSite['site_id']);
			}

			layout_news::CloneLayoutNews($N, $SrcSite, $DstLayoutNewsRootID, $DstLayoutNewsCatID, $DstLanguageID, $NewLayoutNewsID, 'N', $DstSite);
		}
	}

	public static function CloneAllLayoutNewsCategory($SrcSite, $SrcLanguageID, $DstLanguageID, $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		$LayoutNewsCategories = layout_news::GetLayoutNewsCategoryList($SrcLanguageID, $SrcSite['site_id']);

		foreach ($LayoutNewsCategories as $C)
			layout_news::CloneLayoutNewsCat($C, $SrcSite, $DstLanguageID, $NewObjectID, 'N', $DstSite);
	}

	public static function CloneLayoutNewsCat($LayoutNewsCat, $SrcSite, $DstLanguageID, &$NewObjectID, $AddCopyOfToLayoutNewsCatName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		object::CloneObject($LayoutNewsCat, $SrcSite, $NewObjectID, $DstSite);

		$NewNewsCatName = $LayoutNewsCat['layout_news_category_name'];
		if ($AddCopyOfToLayoutNewsCatName == 'Y')
			$NewNewsCatName = "Copy of " . $NewNewsCatName;

		$query =	"	INSERT INTO layout_news_category " .
					"	SET		layout_news_category_id	= '" . intval($NewObjectID) . "', " .
					"			layout_news_category_name = '" . aveEscT($NewNewsCatName) . "', " .
					"			language_id = '" . intval($DstLanguageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function CloneLayoutNews($LayoutNews, $SrcSite, $DstLayoutNewsRootID, $DstLayoutNewsCatID, $DstLanguageID, &$NewObjectID, $AddCopyOfToLayoutNewsTitle = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		object::CloneObject($LayoutNews, $SrcSite, $NewObjectID, $DstSite);

		$NewNewsTitle = $LayoutNews['layout_news_title'];
		if ($AddCopyOfToLayoutNewsTitle == 'Y')
			$NewNewsTitle = "Copy of " . $NewNewsTitle;


		$DstLayoutID = intval($LayoutNews['layout_id']);
		$DstAlbumID = intval($LayoutNews['album_id']);			
		if ($DstSite['site_id'] != $SrcSite['site_id']) {
			$DstLayoutID = object::GetNewObjectIDFromOriginalCloneFromID(intval($LayoutNews['layout_id']), $DstSite['site_id'], false);
			$DstAlbumID = object::GetNewObjectIDFromOriginalCloneFromID(intval($LayoutNews['album_id']), $DstSite['site_id'], false);
		}

		$query =	"	INSERT INTO layout_news " .
					"	SET		layout_news_id	= '" . intval($NewObjectID) . "', " .
					"			layout_news_root_id = '" . intval($DstLayoutNewsRootID) . "', " .
					"			layout_news_title = '" . aveEscT($NewNewsTitle) . "', " .
					"			layout_news_date = '" . aveEscT($LayoutNews['layout_news_date']) . "', " .
					"			layout_news_tag = '" . aveEscT($LayoutNews['layout_news_tag']) . "', " .
					"			layout_news_category_id = '" . intval($DstLayoutNewsCatID) . "', " .
					"			layout_id	= '" . intval($DstLayoutID) . "', " .
					"			album_id	= '" . intval($DstAlbumID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($DstLayoutID !== false) {
			layout::CloneLayoutContent($SrcSite, $LayoutNews['object_id'], $NewObjectID, intval($LayoutNews['layout_id']), $DstLanguageID, $DstSite);
		}
	}

	public static function CloneLayoutNewsPage($LayoutNewsPage, $SrcSite, $DstParentObjID, $DstLanguageID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($LayoutNewsPage['object_link_id']) <= 0)
			customdb::err_die(1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__, true);

		object::CloneObjectWithObjectLink($LayoutNewsPage, $SrcSite, $DstParentObjID, $DstLanguageID, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName, $DstSite);

		$DstNewsRootID = intval($LayoutNewsPage['layout_news_root_id']);
		$DstNewsCatID = intval($LayoutNewsPage['layout_news_category_id']);
		if ($DstSite['site_id'] != $SrcSite['site_id']) {
			$DstNewsRootID = object::GetNewObjectIDFromOriginalCloneFromID($DstNewsRootID, $DstSite['site_id'], false);
			$DstNewsCatID = object::GetNewObjectIDFromOriginalCloneFromID($DstNewsCatID, $DstSite['site_id'], false);
		}

		$query =	"	INSERT INTO layout_news_page " .
					"	SET		layout_news_page_id		= '" . intval($NewObjectID) . "', " .
					"			layout_news_root_id		= '" . intval($DstNewsRootID) . "', " .
					"			layout_news_category_id	= '" . intval($DstNewsCatID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}


	public static function GetLayoutNewsCategoryListXML($LanguageID, $SiteID) {
		$smarty = new mySmarty();

		$Site = site::GetSiteInfo($SiteID);

		$LayoutNewsCategoryList = layout_news::GetLayoutNewsCategoryList($LanguageID, $SiteID);

		$LayoutNewsCategoryListXML = '';
		foreach ($LayoutNewsCategoryList as $NC) {
			$NC['object_seo_url'] = object::GetSeoURL($NC, '', $LanguageID, $Site);
			$smarty->assign('Object', $NC);
			$LayoutNewsCategoryListXML = $LayoutNewsCategoryListXML . $smarty->fetch('api/object_info/LAYOUT_NEWS_CATEGORY.tpl');
		}
		return "<layout_news_category_list>" . $LayoutNewsCategoryListXML . "</layout_news_category_list>";
	}

	public static function GetLayoutNewsListXML(&$TotalNoOfLayoutNews, $LayoutNewsRootID, $LayoutNewsCategoryID, $Tag, $SecurityLevel, $Offset = 0, $RowCount = 20, $IncludeLayoutDetails = 'N', $DateSearch = 'N', $DateFrom = '', $DateTo = '', $OrderByField = 'layout_news_date', $OrderByOrder = 'DESC', $SiteID = 0) {
		$smarty = new mySmarty();

		if ($SiteID == 0 && $LayoutNewsRootID == 0)
			return '<internal_error>Just an extra bit of safety check, no one should ever see this!</internal_error>';

		$sql = '';
		if ($LayoutNewsCategoryID != 0)
			$sql = " AND C.layout_news_category_id = '" . intval($LayoutNewsCategoryID) . "'";

		$tag_sql = '';
		if (strlen(trim($Tag)) > 0)
			$tag_sql = " AND R.layout_news_tag  LIKE '%, " . aveEscT($Tag) . ",%'";

		$date_sql = '';
		if ($DateSearch == 'Y')
			$date_sql = "	AND	R.layout_news_date >= '" . aveEscT($DateFrom) . "' AND R.layout_news_date <= '" . aveEscT($DateTo) . "'";

		$root_sql = '';
		if (intval($LayoutNewsRootID) > 0)
			$root_sql = "	AND	R.layout_news_root_id =  '" . intval($LayoutNewsRootID) . "'";

		$site_sql = '';
		if (intval($SiteID) > 0)
			$root_sql = "	AND	RO.site_id =  '" . intval($SiteID) . "'";

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS * " .
					"	FROM	layout_news R	JOIN	object RO				ON	(R.layout_news_id = RO.object_id) " .
//						"							JOIN	layout_news_root RR		ON	(R.layout_news_root_id = RR.layout_news_root_id) " .
					"							JOIN	layout_news_category C	ON	(R.layout_news_category_id = C.layout_news_category_id) " .
					"	WHERE	RO.object_security_level <= '" . intval($SecurityLevel) . "' " .
					"		AND	RO.object_is_enable = 'Y' " .
					"		AND	RO.object_archive_date > NOW() " .
					"		AND	RO.object_publish_date < NOW() " .
					"		AND	RO.is_removed = 'N' " . $sql . $tag_sql . $date_sql . $root_sql . $site_sql . 
					"	ORDER BY R." . $OrderByField . " " . $OrderByOrder . ", RO.object_id DESC " .
					"	LIMIT	" . $Offset . ", " . $RowCount;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalNoOfLayoutNews = $myResult[0];

		$XML = '';
		while ($myResult = $result->fetch_assoc()) {
			if ($IncludeLayoutDetails == 'Y') {
				$XML = $XML . layout_news::GetLayoutNewsXML($myResult['layout_news_id']);
			}
			else {
				$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $myResult['language_id'], null);
				$smarty->assign('Object', $myResult);
				$XML = $XML . $smarty->fetch('api/object_info/LAYOUT_NEWS.tpl');
			}
		}
		return $XML;
	}

	public static function GetLayoutNewsXML($ObjectID, $MediaPageNo = 1, $MediaPerPage = 999999, $SecurityLevel = 999999) {
		$smarty = new mySmarty();

		$LayoutNews = layout_news::GetLayoutNewsInfo($ObjectID);

		if ($LayoutNews != null) {
			$LayoutXML = layout::GetLayoutXML($LayoutNews['layout_news_id'], $LayoutNews['layout_id']);
			$smarty->assign('LayoutXML', $LayoutXML);

			if ($LayoutNews['album_id'] != 0) {

				$Album = album::GetAlbumInfo($LayoutNews['album_id'], $LayoutNews['language_id']);
				if (strtotime($Album['object_archive_date']) > time() && strtotime($Album['object_publish_date']) < time() ) {
					$AlbumXML = album::GetAlbumXML($LayoutNews['album_id'], 0, $LayoutNews['language_id'], $MediaPageNo, $MediaPerPage, $SecurityLevel);
					$smarty->assign('AlbumXML', $AlbumXML);						
				}
			}
			$LayoutNews['object_seo_url'] = object::GetSeoURL($LayoutNews, '', $LayoutNews['language_id'], $Site);
			$smarty->assign('Object', $LayoutNews);
			$LayoutNewsXML = $smarty->fetch('api/object_info/LAYOUT_NEWS.tpl');
			return $LayoutNewsXML;
		}
		else
			return '';
	}

	public static function GetNextLayoutNewsXML($LayoutNews, $LayoutNewsCategoryID, $Tag, $SecurityLevel, $IncludeLayoutDetails = 'N', $AdjacentLayoutNewsToGet = 1) {
		$smarty = new mySmarty();

		$sql = '';
		if ($LayoutNewsCategoryID != 0)
			$sql = " AND C.layout_news_category_id = '" . intval($LayoutNewsCategoryID) . "'";

		$tag_sql = '';
		if (strlen(trim($Tag)) > 0)
			$tag_sql = " AND R.layout_news_tag  LIKE '%, " . aveEscT($Tag) . ",%'";

		$query =	"	SELECT	* " .
					"	FROM	layout_news R	JOIN	object RO				ON	(R.layout_news_id = RO.object_id) " .
					"							JOIN	layout_news_root RR		ON	(R.layout_news_root_id = RR.layout_news_root_id) " .
					"							JOIN	layout_news_category C	ON	(R.layout_news_category_id = C.layout_news_category_id) " .
					"	WHERE	RO.object_security_level <= '" . intval($SecurityLevel) . "' " .
					"		AND	RO.object_is_enable = 'Y' " .
					"		AND	RO.is_removed = 'N' " .
					"		AND	RO.object_archive_date > NOW() " .
					"		AND	RO.object_publish_date < NOW() " .
					"		AND ( 		R.layout_news_date > '" . aveEscT($LayoutNews['layout_news_date']) . "' " . 
					"				OR	(R.layout_news_date = '" . aveEscT($LayoutNews['layout_news_date']) . "' AND RO.object_id > '" . intval($LayoutNews['object_id']) . "')" .
					"			)	" .
					"		AND RO.object_id != '" . intval($LayoutNews['object_id']) . "' " .
					"		AND	RR.layout_news_root_id =  '" . intval($LayoutNews['layout_news_root_id']) . "'" . $sql . $tag_sql . 
					"	ORDER BY R.layout_news_date ASC, RO.object_id ASC " .
					"	LIMIT	" . $AdjacentLayoutNewsToGet;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$XML = '';
		while ($myResult = $result->fetch_assoc()) {
			if ($IncludeLayoutDetails == 'Y') {
				$XML = $XML . layout_news::GetLayoutNewsXML($myResult['layout_news_id']);
			}
			else {
				$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $myResult['language_id'], null);
				$smarty->assign('Object', $myResult);
				$XML = $XML . $smarty->fetch('api/object_info/LAYOUT_NEWS.tpl');
			}
		}
		return $XML;
	}

	public static function GetPreviousLayoutNewsXML($LayoutNews, $LayoutNewsCategoryID, $Tag, $SecurityLevel, $IncludeLayoutDetails = 'N', $AdjacentLayoutNewsToGet = 1) {
		$smarty = new mySmarty();

		$sql = '';
		if ($LayoutNewsCategoryID != 0)
			$sql = " AND C.layout_news_category_id = '" . intval($LayoutNewsCategoryID) . "'";

		$tag_sql = '';
		if (strlen(trim($Tag)) > 0)
			$tag_sql = " AND R.layout_news_tag  LIKE '%, " . trim($Tag) . ",%'";

		$query =	"	SELECT	* " .
					"	FROM	layout_news R	JOIN	object RO				ON	(R.layout_news_id = RO.object_id) " .
					"							JOIN	layout_news_root RR		ON	(R.layout_news_root_id = RR.layout_news_root_id) " .
					"							JOIN	layout_news_category C	ON	(R.layout_news_category_id = C.layout_news_category_id) " .
					"	WHERE	RO.object_security_level <= '" . intval($SecurityLevel) . "' " .
					"		AND	RO.object_is_enable = 'Y' " .
					"		AND	RO.is_removed = 'N' " .
					"		AND	RO.object_archive_date > NOW() " .
					"		AND	RO.object_publish_date < NOW() " .
					"		AND ( 		R.layout_news_date < '" . aveEscT($LayoutNews['layout_news_date']) . "' " . 
					"				OR	(R.layout_news_date = '" . aveEscT($LayoutNews['layout_news_date']) . "' AND RO.object_id < '" . intval($LayoutNews['object_id']) . "')" .
					"			)	" .
					"		AND RO.object_id != '" . intval($LayoutNews['object_id']) . "' " .
					"		AND	RR.layout_news_root_id =  '" . intval($LayoutNews['layout_news_root_id']) . "'" . $sql . $tag_sql . 
					"	ORDER BY R.layout_news_date DESC, RO.object_id DESC " .
					"	LIMIT	" . intval($AdjacentLayoutNewsToGet);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$XML = '';
		while ($myResult = $result->fetch_assoc()) {
			if ($IncludeLayoutDetails == 'Y') {
				$XML = $XML . layout_news::GetLayoutNewsXML($myResult['layout_news_id']);
			}
			else {
				$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $myResult['language_id'], null);
				$smarty->assign('Object', $myResult);
				$XML = $XML . $smarty->fetch('api/object_info/LAYOUT_NEWS.tpl');
			}
		}
		return $XML;
	}

}