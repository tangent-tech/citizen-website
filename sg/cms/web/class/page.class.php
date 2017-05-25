<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class page {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function ClonePage($Page, $SrcSite, $DstParentObjID, $DstLanguageID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($Page['object_link_id']) <= 0)
			customdb::err_die(1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__, true);

		object::CloneObjectWithObjectLink($Page, $SrcSite, $DstParentObjID, $DstLanguageID, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName, $DstSite);

		$DstLayoutID = intval($Page['layout_id']);
		$DstAlbumID = intval($Page['album_id']);
		if ($DstSite['site_id'] != $SrcSite['site_id']) {
			$DstLayoutID = object::GetNewObjectIDFromOriginalCloneFromID($DstLayoutID, $DstSite['site_id'], false);
			$DstAlbumID = object::GetNewObjectIDFromOriginalCloneFromID($DstAlbumID, $DstSite['site_id'], false);
		}

		$query =	"	INSERT INTO page " .
					"	SET		page_id		= '" . intval($NewObjectID) . "', " .
					"			page_title	= '" . aveEscT($Page['page_title']) . "', " .
					"			layout_id	= '" . intval($DstLayoutID) . "', " .
					"			album_id	= '" . intval($DstAlbumID) . "', " .
					"			page_tag	= '" . aveEscT($Page['page_tag']) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($DstLayoutID !== false) {
			layout::CloneLayoutContent($SrcSite, $Page['object_id'], $NewObjectID, intval($Page['layout_id']), $DstLanguageID, $DstSite);
		}
	}

	public static function NewPage($ObjectID, $PageTitle = '', $LayerID = 0) {
		$query =	"	INSERT INTO page " .
					"	SET		page_id		= '" . intval($ObjectID) . "', " .
					"			page_title	= '" . aveEscT(trim($PageTitle)) . "', " .
					"			layout_id	= '" . intval($LayerID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetPageInfo($ObjectID) {
		$query =	"	SELECT *, O.*, P.* " .
					"	FROM	page P	JOIN object O ON (P.page_id = O.object_id) " .
					"					LEFT JOIN layout L ON (P.layout_id = L.layout_id) " .
					"					LEFT JOIN object_link OL ON (OL.object_id = O.object_id) " .
					"	WHERE	O.object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetPageXML($ObjectID, $MediaPageNo = 1, $MediaPerPage = 999999, $SecurityLevel = 999999) {
		$smarty = new mySmarty();

		$Page = page::GetPageInfo($ObjectID);
		if ($Page != null) {
			$LayoutXML = layout::GetLayoutXML($Page['page_id'], $Page['layout_id']);
			$smarty->assign('LayoutXML', $LayoutXML);
			$AlbumXML = '';

			if ($Page['album_id'] != 0) {
				$Album = album::GetAlbumInfo($Page['album_id'], $Page['language_id']);
				if (strtotime($Album['object_archive_date']) > time() && strtotime($Album['object_publish_date']) < time() ) {
					$AlbumXML = album::GetAlbumXML($Page['album_id'], 0, $Page['language_id'], $MediaPageNo, $MediaPerPage, $SecurityLevel);
				}
			}
			$Page['object_seo_url'] = object::GetSeoURL($Page, '', $Page['language_id'], null);
			$smarty->assign('Object', $Page);
			$smarty->assign('AlbumXML', $AlbumXML);
			$PageXML = $smarty->fetch('api/object_info/PAGE.tpl');
			return $PageXML;
		}
		else
			return '';
	}

	public static function DeletePage($ObjectID, $Site) {
		$Page = page::GetPageInfo($ObjectID);
		if ($Page == null)
			return;

		$BlockDefs = block::GetBlockDefListByLayoutID($Page['layout_id']);
		foreach ($BlockDefs as $BD) {
			$BlockHolder = block::GetBlockHolderByPageID($Page['page_id'], $BD['block_definition_id']);
			block::DeleteBlockHolder($BlockHolder['block_holder_id'], $Site);
		}

		// DELETE OBJECT AND BLOCKHOLDER RECORD
		object::DeleteObject($ObjectID);

		$query =	"	DELETE FROM	page " .
					"	WHERE	page_id = '" . intval($ObjectID) . "'";
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

	public static function GetNoOfPage($SiteID) {
		$query =	"	SELECT	COUNT(object_id) AS NoOfObjects " .
					"	FROM	object	" .
					"	WHERE	site_id		= '" . intval($SiteID) . "'" .
					"		AND	object_type	= 'PAGE' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result->fetch_assoc();

		return $myResult['NoOfObjects'];
	}

	public static function UpdateTimeStamp($PageID) {
		object::UpdateObjectTimeStamp($PageID);
	}
}