<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class folder {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function NewFolder($ObjectID, $LinkURL) {
		$query =	"	INSERT INTO folder " .
					"	SET		folder_id = '" . intval($ObjectID) . "', " .
					"			folder_link_url = '" . aveEscT($LinkURL) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetFolderDetails($ObjectID) {
		$query =	"	SELECT	* " .
					"	FROM 	object O	JOIN	folder F ON (O.object_id = F.folder_id) " .
					"						JOIN	object_link OL ON (OL.object_id = O.object_id) " .
					"	WHERE	O.object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetLockFolderByName($FolderName, $LangID, $SiteID) {
		$query =	"	SELECT	* " .
					"	FROM 	object O	JOIN	object_link OL	ON (O.object_id = OL.object_id) " .
					"	WHERE	O.object_type = 'FOLDER'" .
					"		AND OL.object_name = '" . aveEscT($FolderName) . "'" .
					"		AND	OL.language_id = '" . intval($LangID) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetFolderXML($ObjectID) {
		$smarty = new mySmarty();
		$Folder = folder::GetFolderDetails($ObjectID);
		if ($Folder != null) {
			$Folder['object_seo_url'] = object::GetSeoURL($Folder, '', $Folder['language_id'], null);
			$smarty->assign('Object', $Folder);
			$FolderXML = $smarty->fetch('api/object_info/FOLDER.tpl');
			return $FolderXML;
		}
		return '';
	}

	public static function IsFolderRemovable($ObjectID) {
		$query =	"	SELECT	* " .
					"	FROM 	object_link " .
					"	WHERE	parent_object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return false;
		else
			return true;
	}

	public static function DeleteFolder($ObjectID) {
		if (folder::IsFolderRemovable($ObjectID)) {
			$query =	"	DELETE FROM	folder " .
						"	WHERE	folder_id	= '" . intval($ObjectID) . "'";
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
	}

	public static function UpdateTimeStamp($FolderID) {
		object::UpdateObjectTimeStamp($FolderID);
	}


	public static function GetAlbumList($FolderID, $LanguageID=0, $SecurityLevel=0, &$TotalAlbum, $PageNo = 1, $AlbumPerPage = 20, $HonorArchiveDate = false, $HonorPublishDate = false, $OrderByOrder = "ASC") {
		$Offset = intval(($PageNo -1) * $AlbumPerPage);

		$sql = '';
		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	AO.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	AO.object_publish_date < NOW() ";

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, OL.*, AO.* " .
					"	FROM	object_link OL	JOIN		object AO		ON (OL.object_id = AO.object_id) " .
					"							JOIN		album A			ON (A.album_id = AO.object_id) " .
					"							LEFT JOIN	album_data AD	ON (A.album_id = AD.album_id AND AD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	OL.parent_object_id = '" . intval($FolderID) . "'" .
					"		AND AO.object_is_enable = 'Y' " .
					"		AND OL.object_link_is_enable = 'Y' " .
					"		AND	AO.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql .
					"	ORDER BY OL.order_id " . $OrderByOrder . 
					"	LIMIT	" . $Offset . ", " . intval($AlbumPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalAlbum = $myResult[0];

		$AlbumList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($AlbumList, $myResult);
		}
		return $AlbumList;
	}

	public static function GetAlbumListXML($FolderID, $LanguageID=0, $SecurityLevel=0, $PageNo = 1, $AlbumPerPage = 20, $MediaPerPage = 20, $IncludeAlbumDetails = 'N', $OrderByOrder = 'ASC') {
		$smarty = new mySmarty();

		$TotalNoOfAlbum = 0;

		$AlbumList = folder::GetAlbumList($FolderID, $LanguageID, $SecurityLevel, $TotalNoOfAlbum, $PageNo, $AlbumPerPage, true, true, $OrderByOrder);
		$AlbumListXML = '';

		$Folder = folder::GetFolderDetails($FolderID);
		$Site = site::GetSiteInfo($Folder['site_id']);

		foreach ($AlbumList as $A) {
			//$smarty->clearAllAssign();
			$A['object_seo_url'] = object::GetSeoURL($A, '', $LanguageID, $Site);

			$TotalNoOfMedia = 0;
			$MediaListXML = '';
			if ($IncludeAlbumDetails == 'Y')
				$MediaListXML = media::GetMediaListXML($A['object_id'], $LanguageID, $TotalNoOfMedia, 1, $MediaPerPage, $SecurityLevel);

			$smarty->assign('Object', $A);
			$smarty->assign('TotalNoOfMedia', $TotalNoOfMedia);
			$smarty->assign('MediaListXML', $MediaListXML);

			$AlbumListXML = $AlbumListXML . $smarty->fetch('api/object_info/ALBUM.tpl');
		}
		$FolderXML = folder::GetFolderXML($FolderID);
		$smarty->assign('FolderXML', $FolderXML);

		$smarty->assign('AlbumListXML', $AlbumListXML);
		$smarty->assign('TotalNoOfAlbum', $TotalNoOfAlbum);
		$smarty->assign('PageNo', $PageNo);
		$xml = $smarty->fetch('api/folder_get_album_list.tpl');

		return $xml;
	}

	public static function GetPageList($FolderID, $LanguageID=0, $SecurityLevel=0, &$TotalPages, $PageNo = 1, $PageObjectsPerPage = 20, $HonorArchiveDate = false, $HonorPublishDate = false, $PageTag = '') {
		$Offset = intval(($PageNo -1) * $PageObjectsPerPage);

		$sql = '';
		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	PO.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	PO.object_publish_date < NOW() ";
		if (trim($PageTag) != '')
			$sql	=	$sql . "	AND	P.page_tag	LIKE '%, " . aveEscT($PageTag) . ",%' ";

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, OL.*, PO.* " .
					"	FROM	object_link OL	JOIN		object PO		ON (OL.object_id = PO.object_id) " .
					"							JOIN		page P			ON (P.page_id = PO.object_id) " .
					"	WHERE	OL.parent_object_id = '" . intval($FolderID) . "'" .
					"		AND PO.object_is_enable = 'Y' " .
					"		AND OL.object_link_is_enable = 'Y' " .
					"		AND	PO.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql .
					"	ORDER BY OL.order_id ASC " .
					"	LIMIT	" . $Offset . ", " . intval($PageObjectsPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalPages = $myResult[0];

		$PageList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($PageList, $myResult);
		}
		return $PageList;
	}

	public static function GetPageListXML($FolderID, $LanguageID=0, $SecurityLevel=0, $PageNo = 1, $PageObjectsPerPage = 20, $MediaPerPage = 20, $IncludePageDetails = 'N', $PageTag = '') {
		$smarty = new mySmarty();

		$TotalNoOfPageObjects = 0;

		$PageList = folder::GetPageList($FolderID, $LanguageID, $SecurityLevel, $TotalNoOfPageObjects, $PageNo, $PageObjectsPerPage, true, true, $PageTag);
		$PageListXML = '';

		$Folder = folder::GetFolderDetails($FolderID);
		$Site = site::GetSiteInfo($Folder['site_id']);

		foreach ($PageList as $P) {
//				$smarty->clearAllAssign();

			$P['object_seo_url'] = object::GetSeoURL($P, '', $LanguageID, $Site);

			if ($IncludePageDetails == 'Y') {
				$PageXML = '';
				$PageXML = page::GetPageXML($P['object_id'], 1, $MediaPerPage, $SecurityLevel);
				$PageListXML = $PageListXML . $PageXML;
			}
			else {
				$smarty->assign('Object', $P);
				$PageListXML = $PageListXML . $smarty->fetch('api/object_info/PAGE.tpl');
			}
		}
		$FolderXML = folder::GetFolderXML($FolderID);
		$smarty->assign('FolderXML', $FolderXML);

		$smarty->assign('PageListXML', $PageListXML);
		$smarty->assign('TotalNoOfPageObjects', $TotalNoOfPageObjects);
		$smarty->assign('PageNo', $PageNo);
		$xml = $smarty->fetch('api/folder_get_page_list.tpl');

		return $xml;
	}

	public static function CloneFolder($Folder, $SrcSite, $DstParentObjID, $DstLanguageID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($Folder['object_link_id']) <= 0)
			customdb::err_die (1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__, true);

		object::CloneObjectWithObjectLink($Folder, $SrcSite, $DstParentObjID, $DstLanguageID, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName, $DstSite);

		$sql = '';
		for ($i = 1; $i <= 20; $i++) {
			$sql = $sql . "folder_custom_int_" . $i . " = '" . aveEscT($Folder['folder_custom_int_' . $i]) . "', " 
						. "folder_custom_double_" . $i . " = '" . aveEscT($Folder['folder_custom_double_' . $i]) . "', "
						. "folder_custom_date_" . $i . " = '" . aveEscT($Folder['folder_custom_date_' . $i]) . "', "
						. "folder_custom_text_" . $i . " = '" . aveEscT($Folder['folder_custom_text_' . $i]) . "', ";
		}

		$query =	"	INSERT INTO folder " .
					"	SET		folder_id		= '" . intval($NewObjectID) . "', " . $sql .
					"			folder_link_url = '" . aveEscT($Folder['folder_link_url']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Duplicate with content
		global $APIFolderTreeObjectTypeList;
		$ChildObjects = site::GetAllChildObjects($APIFolderTreeObjectTypeList, $Folder['object_id'], 99999999, 'ALL', 'ALL', false, false);

		foreach ($ChildObjects as $O) {
			$NewChildObjectID = 0;
			$NewChildObjectLinkID = 0;

			if ($O['object_type'] == 'FOLDER') {
				$TheFolder = folder::GetFolderDetails($O['object_id']);
				folder::CloneFolder($TheFolder, $SrcSite, $NewObjectID, $DstLanguageID, $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite);
			}
			elseif ($O['object_type'] == 'PAGE') {
				$NoOfPages = page::GetNoOfPage($DstSite['site_id']);
				if ($NoOfPages >= $DstSite['site_module_article_quota'])
					return;
				$Page = page::GetPageInfo($O['object_id']);
				page::ClonePage($Page, $SrcSite, $NewObjectID, $DstLanguageID, $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite);
			}
			elseif ($O['object_type'] == 'LINK') {
				$Link = link::GetLinkInfo($O['object_id']);
				link::CloneLink($Link, $SrcSite, $NewObjectID, $DstLanguageID, $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite);
			}
			elseif ($O['object_type'] == 'NEWS_PAGE') {
				$NewsPage = news::GetNewsPageInfo($O['object_id']);
				news::CloneNewsPage($NewsPage, $SrcSite, $NewObjectID, $DstLanguageID, $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite);
			}
			elseif ($O['object_type'] == 'LAYOUT_NEWS_PAGE') {
				$LayoutNewsPage = layout_news::GetLayoutNewsPageInfo($O['object_id']);
				layout_news::CloneLayoutNewsPage($LayoutNewsPage, $SrcSite, $NewObjectID, $DstLanguageID, $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite);
			}
			elseif ($O['object_type'] == 'PRODUCT_ROOT_LINK') {
				$ProductRootLink = product::GetProductRootLink($O['object_link_id']);
				product::CloneProductRootLink($ProductRootLink, $SrcSite, $NewObjectID, $DstLanguageID, $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite);
			}
			elseif ($O['object_type'] == 'ALBUM') {
				$DstObject = $O;
				if ($DstSite['site_id'] != $SrcSite['site_id']) {

					$DstAlbumObjID = object::GetNewObjectIDFromOriginalCloneFromID($O['object_id'], $DstSite['site_id'], false);

					if ($DstAlbumObjID !== false) {
						$DstObject = object::GetObjectInfo($DstAlbumObjID);
						object::CloneObjectLink($DstObject, $SrcSite, $NewObjectID, $DstLanguageID, $NewChildObjectLinkID, 'N', 'N');							
					}
				}
				else
					object::CloneObjectLink($DstObject, $SrcSite, $NewObjectID, $DstLanguageID, $NewChildObjectLinkID, 'N', 'N');
			}
		}
	}

	public static function DeleteFolderRecursive($ObjectID, $Site) {
		$Folder = folder::GetFolderDetails($ObjectID);
		if ($Folder == null)
			return;

		global $APIFolderTreeObjectTypeList;
		$ChildObjects = site::GetAllChildObjects($APIFolderTreeObjectTypeList, $ObjectID, 99999999, 'ALL', 'ALL', false, false);

		foreach ($ChildObjects as $O) {
			if ($O['object_type'] == 'FOLDER') {
				folder::DeleteFolderRecursive($O['object_id'], $Site);
			}
			elseif ($O['object_type'] == 'PAGE') {
				page::DeletePage($O['object_id'], $Site);
			}
			elseif ($O['object_type'] == 'LINK') {
				link::DeleteLink($O['object_id']);
			}
			elseif ($O['object_type'] == 'NEWS_PAGE') {
				news::DeleteNewsPage($O['object_id']);
			}
			elseif ($O['object_type'] == 'LAYOUT_NEWS_PAGE') {
				layout_news::DeleteLayoutNews($O['object_id'], $Site);
			}
			elseif ($O['object_type'] == 'PRODUCT_ROOT_LINK') {
				product::DeleteProductRootLink($O['object_link_id']);
			}
			elseif ($O['object_type'] == 'ALBUM') {
				object::DeleteObjectLink($O['object_link_id']);
			}
		}

		folder::DeleteFolder($ObjectID);
	}

}