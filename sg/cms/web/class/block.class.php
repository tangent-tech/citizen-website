<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class block {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function DeleteSiteBlockFile($Site) {
		if ($Site['site_block_file_id'] != 0) {
			filebase::DeleteFile($Site['site_block_file_id'], $Site);

			$query =	"	UPDATE	site " .
						"	SET		site_block_file_id = 0 " .
						"	WHERE	site_id =  '" . intval($Site['site_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function UpdateSiteBlockFile($Site, $File) {
		if ($File['size'] > 0) {
			$SiteBlockFileID = filebase::AddFile($File, $Site, SITE_PARENT_ID);
			if ($SiteBlockFileID !== false) {
				block::DeleteSiteBlockFile($Site);
				$query =	"	UPDATE	site " .
							"	SET		site_block_file_id = '" . intval($SiteBlockFileID) . "'" .
							"	WHERE	site_id =  '" . intval($Site['site_id']) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
			return $SiteBlockFileID;
		}
		return 0;
	}


	public static function NewBlockDef($ObjectID, $BlockDefDesc = '', $BlockType = 'text', $ImageWidth = 300, $ImageHeight = 300) {
		$query =	"	INSERT INTO block_definition " .
					"	SET		block_definition_id		= '" . intval($ObjectID) . "', " .
					"			block_definition_desc	= '" . aveEscT($BlockDefDesc) . "', " .
					"			block_definition_type	= '" . aveEscT($BlockType) . "', " .
					"			block_image_height		= '" . intval($ImageHeight) . "', " .
					"			block_image_width		= '" . intval($ImageWidth) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function DeleteBlockDef($BlockDefID, $Site) {
		$BlockDef = block::GetBlockDefInfo($BlockDefID);

		$query =	"	DELETE FROM	block_definition " .
					"	WHERE		block_definition_id = '" . intval($BlockDefID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($BlockDefID);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE		object_id = '" . intval($BlockDefID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::TidyUpObjectOrder($BlockDef['parent_object_id']);

		$query =	"	SELECT	* " .
					"	FROM	block_holder " .
					"	WHERE	block_definition_id = '" . intval($BlockDefID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			block::DeleteBlockHolder($myResult['block_holder_id'], $Site);
		}
	}

	public static function GetBlockDefInfo($BlockDefID) {
		$query =	"	SELECT *, O.* " .
					"	FROM	block_definition BD JOIN		object O ON (BD.block_definition_id = O.object_id) " .
					"								LEFT JOIN	object_link OL ON (O.object_id = OL.object_id) " .
					"	WHERE	block_definition_id		= '" . intval($BlockDefID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetBlockDefListByLayoutID($LayoutID) {

		$query =	"	SELECT	* " .
					"	FROM	object_link OL	JOIN	object BO ON (OL.object_id = BO.object_id) " .
					"							JOIN	block_definition BD	ON (BD.block_definition_id = BO.object_id) " .
					"	WHERE	OL.parent_object_id	= '" . intval($LayoutID) . "'" . $sql .
					"	ORDER BY OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$BlockDefs = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($BlockDefs, $myResult);
		}
		return $BlockDefs;
	}

	public static function GetBlockDefListBySiteBlockHolderRootID($SiteBlockHolderRootID) {
		$query =	"	SELECT	* " .
					"	FROM	object_link OL	JOIN	object BO ON (OL.object_id = BO.object_id) " .
					"							JOIN	block_definition BD	ON (BD.block_definition_id = BO.object_id) " .
					"	WHERE	OL.parent_object_id	= '" . intval($SiteBlockHolderRootID) . "'" .
					"	ORDER BY OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$BlockDefs = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($BlockDefs, $myResult);
		}
		return $BlockDefs;
	}

	public static function GetBlockContentListByPageID($PageID, $BlockDefID, $IsEnable = 'ALL') {
		$sql = '';			
		if ($IsEnable != 'ALL')
			$sql = " WHERE OL.object_link_is_enable ='" . aveEscT($IsEnable) . "' AND BCO.object_is_enable = '" . aveEscT($IsEnable) . "'";			

		$query =	"	SELECT	*, BCO.*, OL.* " .
					"	FROM	object_link OL	JOIN	block_holder H		ON	(OL.parent_object_id = H.block_holder_id AND H.page_id = '" . intval($PageID) . "' AND H.block_definition_id = '" . intval($BlockDefID) . "') " .
					"							JOIN	object BCO			ON	(BCO.object_id = OL.object_id) " .
					"							JOIN	block_content BC	ON	(BC.block_content_id = BCO.object_id) " .
					"							LEFT JOIN	file_base F		ON	(BC.block_file_id = F.file_id) " . $sql .
					"	ORDER BY OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$BlockContents = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($BlockContents, $myResult);
		}
		return $BlockContents;
	}

	public static function GetBlockContentListByLayoutNewsID($LayoutNewsID, $BlockDefID) {
		$query =	"	SELECT	*, BCO.*, OL.* " .
					"	FROM	object_link OL	JOIN	block_holder H		ON	(OL.parent_object_id = H.block_holder_id AND H.page_id = '" . intval($LayoutNewsID) . "' AND H.block_definition_id = '" . intval($BlockDefID) . "') " .
					"							JOIN	object BCO			ON	(BCO.object_id = OL.object_id) " .
					"							JOIN	block_content BC	ON	(BC.block_content_id = BCO.object_id) " .
					"							LEFT JOIN	file_base F		ON	(BC.block_file_id = F.file_id) " .
					"	ORDER BY OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$BlockContents = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($BlockContents, $myResult);
		}
		return $BlockContents;
	}

	public static function GetSiteBlockContentListBySiteID($SiteID, $BlockDefID, $LanguageID, $IsEnable = 'ALL', $SecurityLevel = 999999, $HonorArchiveDate = false, $HonorPublishDate = false) {
		$sql = '';
		if ($IsEnable != 'ALL')
			$sql	=	$sql . "	AND BCO.object_is_enable = '" . aveEscT($IsEnable) . "'";
		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	BCO.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	BCO.object_publish_date < NOW() ";

		$query =	"	SELECT	* " .
					"	FROM	object_link OL	JOIN	block_holder H		ON	(OL.parent_object_id = H.block_holder_id AND H.page_id = 0 AND H.site_id = '" . intval($SiteID) . "' AND H.block_definition_id = '" . intval($BlockDefID) . "' AND H.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN	object BCO			ON	(BCO.object_id = OL.object_id) " .
					"							JOIN	block_content BC	ON	(BC.block_content_id = BCO.object_id) " . 
					"	WHERE	BCO.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql .
					"	ORDER BY OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$BlockContents = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($BlockContents, $myResult);
		}
		return $BlockContents;
	}

	public static function GetBlockContentListByBlockHolderID($BlockHolderID) {
		$query =	"	SELECT	* " .
					"	FROM	object_link OL	JOIN	object BCO			ON	(BCO.object_id = OL.object_id AND OL.parent_object_id = '" . intval($BlockHolderID) . "') " .
					"							JOIN	block_content BC	ON	(BC.block_content_id = BCO.object_id) " .
					"	ORDER BY OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$BlockContents = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($BlockContents, $myResult);
		}
		return $BlockContents;
	}

	public static function GetBlockContentInfo($BlockContentID) {
		$query =	"	SELECT *, O.* " .
					"	FROM	block_content BC	JOIN 		object O		ON (BC.block_content_id = O.object_id) " .
					"								JOIN 		object_link OL	ON (O.object_id = OL.object_id) " .
					"								LEFT JOIN	file_base F		ON (BC.block_file_id = F.file_id) " .
					"	WHERE	block_content_id		= '" . intval($BlockContentID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function NewBlockContent($ObjectID, $BlockContent, $BlockLink, $BlockImageID = 0, $BlockFileID = 0) {
		
		$query =	"	INSERT INTO block_content " .
					"	SET		block_content_id	= '" . intval($ObjectID) . "', " .
					"			block_content		= '" . aveEscT($BlockContent) . "', " .
					"			block_link_url		= '" . aveEscT($BlockLink) . "', " .
					"			block_image_id		= '" . intval($BlockImageID) . "', " .
					"			block_file_id		= '" . intval($BlockFileID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}


	public static function DeleteBlockContent($BlockContentID, $Site, $CallByDeleteParent = false) {
		// If "$CallByDeleteParent" is true, no object_link will be handled as it will eventually be deleted by the parent in one SQL call.
		// This is added for saving CPU time as TidyUpObjectOrder will be called each time.
		$BlockContent = block::GetBlockContentInfo($BlockContentID);

		// Delete File
		if ($BlockContent['block_image_id'] != 0)
			filebase::DeleteFile($BlockContent['block_image_id'], $Site);
		if ($BlockContent['block_file_id'] != 0)
			filebase::DeleteFile($BlockContent['block_file_id'], $Site);

		// Delete Object And Block Content Record
		object::DeleteObject($BlockContentID);

		$query =	"	DELETE FROM	block_content " .
					"	WHERE	block_content_id = '" . intval($BlockContentID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Handle Object Link
		if (!$CallByDeleteParent) {
			$query =	"	DELETE FROM	object_link " .
						"	WHERE		parent_object_id = '" . intval($BlockContentID) . "'" .
						"			OR	object_id = '" . intval($BlockContentID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			object::TidyUpObjectOrder($BlockContent['parent_object_id']);
		}
	}

	public static function UpdateBlockContentImage($BlockContent, $BlockDef, $Site, $File) {
		if ($File['size'] > 0) {
			$FileID = filebase::AddPhoto($File, $BlockDef['block_image_width'], $BlockDef['block_image_height'], $Site, 0, $BlockContent['block_content_id']);
			if ($FileID !== false) {
				block::DeleteBlockContentImage($BlockContent, $Site);
				$query =	"	UPDATE	block_content " .
							"	SET		block_image_id = '" . intval($FileID) . "'" .
							"	WHERE	block_content_id =  '" . intval($BlockContent['block_content_id']) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
			return $FileID;
		}
		return false;
	}

	public static function UpdateBlockContentFile($BlockContent, $BlockDef, $Site, $File) {
		if ($File['size'] > 0) {
			$FileID = filebase::AddFile($File, $Site, $BlockContent['block_content_id']);

			if ($FileID !== false) {
				block::DeleteBlockContentFile($BlockContent, $Site);
				$query =	"	UPDATE	block_content " .
							"	SET		block_file_id = '" . intval($FileID) . "'" .
							"	WHERE	block_content_id =  '" . intval($BlockContent['block_content_id']) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
			return $FileID;
		}
		return false;
	}

	public static function DeleteBlockContentImage($BlockContent, $Site) {
		if ($BlockContent['block_image_id'] > 0) {
			filebase::DeleteFile($BlockContent['block_image_id'], $Site);
			$query =	"	UPDATE	block_content " .
						"	SET		block_image_id = 0 " .
						"	WHERE	block_content_id =  '" . intval($BlockContent['block_content_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function DeleteBlockContentFile($BlockContent, $Site) {
		if ($BlockContent['block_file_id'] > 0) {
			filebase::DeleteFile($BlockContent['block_file_id'], $Site);
			$query =	"	UPDATE	block_content " .
						"	SET		block_file_id = 0 " .
						"	WHERE	block_content_id =  '" . intval($BlockContent['block_content_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function TouchBlockHolderList($PageID, $BlockDefID, $SiteID, $LanguageID) {
		$query =	"	SELECT	* " .
					"	FROM	block_holder H " .
					"	WHERE	H.page_id = '" . intval($PageID) . "' AND H.block_definition_id = '" . intval($BlockDefID) . "'" .
					"		AND H.site_id = '" . intval($SiteID) . "' AND H.language_id = '" . intval($LanguageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows == 0) {
			$BlockHolderID = object::NewObject('BLOCK_HOLDER', $SiteID, 0);
			block::NewBlockHolder($BlockHolderID, $PageID, $BlockDefID, $SiteID, $LanguageID);
		}
	}

	public static function NewBlockHolder($ObjectID, $PageID, $BlockDefID, $SiteID, $LanguageID) {
		$query =	"	INSERT INTO block_holder " .
					"	SET		block_holder_id			= '" . intval($ObjectID) . "', " .
					"			page_id					= '" . intval($PageID) . "', " .
					"			block_definition_id		= '" . intval($BlockDefID) . "', " .
					"			site_id					= '" . intval($SiteID) . "', " .
					"			language_id				= '" . intval($LanguageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetBlockHolderByBlockContentID($BlockContentID) {
		$query =	"	SELECT	* " .
					"	FROM	object_link OL	JOIN	object BHO			ON	(BHO.object_id = OL.parent_object_id AND OL.object_id = '" . intval($BlockContentID) . "') " .
					"							JOIN	block_holder BH		ON	(BH.block_holder_id = BHO.object_id) ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetBlockHolderByPageID($PageID, $BlockDefID) {
		$query =	"	SELECT	* " .
					"	FROM	object OH	JOIN	block_holder H ON	(OH.object_id = H.block_holder_id)" .
					"	WHERE	H.page_id = '" . intval($PageID) . "' AND H.block_definition_id = '" . intval($BlockDefID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetBlockHolderBySiteID($SiteID, $BlockDefID, $LanguageID) {
		$query =	"	SELECT	* " .
					"	FROM	object OH	JOIN	block_holder H ON	(OH.object_id = H.block_holder_id)" .
					"	WHERE	H.page_id = 0 " .
					"		AND H.site_id = '" . intval($SiteID) . "'" .
					"		AND H.block_definition_id = '" . intval($BlockDefID) . "'" .
					"		AND H.language_id = '" . intval($LanguageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);			
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetBlockHolderInfo($BlockHolderID) {
		$query =	"	SELECT	* " .
					"	FROM	object OH	JOIN	block_holder H ON	(OH.object_id = H.block_holder_id)" .
					"	WHERE	OH.object_id = '" . intval($BlockHolderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);			
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function DeleteBlockHolder($BlockHolderID, $Site) {
		// Delete all Block Content objects
		$BlockContents = block::GetBlockContentListByBlockHolderID($BlockHolderID);
		foreach ($BlockContents as $BC)
			block::DeleteBlockContent($BC['block_content_id'], $Site, true);

		// DELETE OBJECT AND BLOCKHOLDER RECORD
		object::DeleteObject($BlockHolderID);

		$query =	"	DELETE FROM	block_holder " .
					"	WHERE	block_holder_id = '" . intval($BlockHolderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);			

		// Delete all object links
		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id = '" . intval($BlockHolderID) . "'" .
					"			OR	object_id = '" . intval($BlockHolderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);			
	}

	public static function MoveBlockContentAcrossBlockHolders($OldBlockHolderID, $NewBlockHolderID) {
		$query =	"	UPDATE	object_link " .
					"	SET		parent_object_id = '" . intval($NewBlockHolderID) . "', ".
					"			order_id = order_id + " . DEFAULT_ORDER_ID .
					"	WHERE	parent_object_id = '" . intval($OldBlockHolderID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);			

		object::TidyUpObjectOrder($NewBlockHolderID);
	}

	public static function GetBlockContentXML($BlockContentID) {
		$smarty = new mySmarty();
		$BlockContent = block::GetBlockContentInfo($BlockContentID);
		$smarty->assign('Object', $BlockContent);
		return $smarty->fetch('api/object_info/BLOCK_CONTENT.tpl');
	}
	
	public static function GetBlockContentsXML($PageID, $BlockDefID) {
		$smarty = new mySmarty();
		$BlockContents = block::GetBlockContentListByPageID($PageID, $BlockDefID, 'Y');

		$BlockContentsXML = '';
		foreach ($BlockContents as $BC) {
			$smarty->assign('Object', $BC);
			$BlockContentsXML = $BlockContentsXML . $smarty->fetch('api/object_info/BLOCK_CONTENT.tpl');
		}

		return $BlockContentsXML;
	}

	public static function GetSiteBlockContentsXML($SiteID, $BlockDefID, $LanguageID, $SecurityLevel = 999999) {
		$smarty = new mySmarty();
		$BlockContents = block::GetSiteBlockContentListBySiteID($SiteID, $BlockDefID, $LanguageID, 'Y', $SecurityLevel, true, true);

		$BlockContentsXML = '';
		foreach ($BlockContents as $BC) {
			$smarty->assign('Object', $BC);
			$BlockContentsXML = $BlockContentsXML . $smarty->fetch('api/object_info/BLOCK_CONTENT.tpl');
		}

		return $BlockContentsXML;
	}

	public static function GetSiteBlockDefXML($SiteID, $BlockDefID, $LanguageID, $SecurityLevel = 999999) {
		$smarty = new mySmarty();
		$BlockDef = block::GetBlockDefInfo($BlockDefID);

		if ($BlockDef != null) {
			$BlockContentsXML = block::GetSiteBlockContentsXML($SiteID, $BlockDefID, $LanguageID, $SecurityLevel);

			$smarty->assign('Object', $BlockDef);
			$smarty->assign('BlockContentsXML', $BlockContentsXML);

			$BlockDefXML = $smarty->fetch('api/object_info/BLOCK_DEF.tpl');
			return $BlockDefXML;
		}
		else
			return '';
	}

	public static function GetBlockDefXML($PageID, $BlockDefID) {
		$smarty = new mySmarty();
		$BlockDef = block::GetBlockDefInfo($BlockDefID);

		if ($BlockDef != null) {
			$BlockContentsXML = block::GetBlockContentsXML($PageID, $BlockDefID);

			$smarty->assign('Object', $BlockDef);
			$smarty->assign('BlockContentsXML', $BlockContentsXML);

			$BlockDefXML = $smarty->fetch('api/object_info/BLOCK_DEF.tpl');
			return $BlockDefXML;
		}
		else
			return '';
	}

	public static function CloneBlockDef($SrcSite, $SrcBlockDef, $DstLayoutID, $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		object::CloneObjectWithObjectLink($SrcBlockDef, $SrcSite,$DstLayoutID, 0, $NewObjectID, $NewObjectLinkID, 'N', 'N', $DstSite);
		block::NewBlockDef($NewObjectID, $SrcBlockDef['block_definition_desc'], $SrcBlockDef['block_definition_type'], $SrcBlockDef['block_image_width'], $SrcBlockDef['block_image_height']);
	}

	public static function CloneBlockHolderWithContent($SrcSite, $SrcPageID, $DstPageID, $SrcBlockDefID, $DstLanguageID, $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		$DstBlockDefID = $SrcBlockDefID;
		if ($DstSite['site_id'] != $SrcSite['site_id']) {
			$DstBlockDefID = object::GetNewObjectIDFromOriginalCloneFromID($SrcBlockDefID, $DstSite['site_id']);
		}

		$BlockHolder = block::GetBlockHolderByPageID($SrcPageID, $SrcBlockDefID);

		if ($BlockHolder != null) {
			$NewBlockHolderID = 0;
			object::CloneObject($BlockHolder, $SrcSite, $NewBlockHolderID, $DstSite);

			block::NewBlockHolder($NewBlockHolderID, $DstPageID, $DstBlockDefID, $DstSite['site_id'], $DstLanguageID);

			$BlockContents = block::GetBlockContentListByBlockHolderID($BlockHolder['block_holder_id']);

			foreach ($BlockContents as $BC)
				block::CloneBlockContent($SrcSite, $BC, $NewBlockHolderID, $DstLanguageID, $DstSite);
		}			
	}

	public static function CloneSiteBlockHolderWithContent($SrcSite, $SrcBlockDefID, $SrcLanguageID, $DstLanguageID, $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		$DstBlockDefID = $SrcBlockDefID;
		if ($DstSite['site_id'] != $SrcSite['site_id']) {
			$DstBlockDefID = object::GetNewObjectIDFromOriginalCloneFromID($SrcBlockDefID, $DstSite['site_id']);
		}

		$BlockHolder = block::GetBlockHolderBySiteID($SrcSite['site_id'], $SrcBlockDefID, $SrcLanguageID);

		if ($BlockHolder != null) {
			$NewBlockHolderID = 0;
			object::CloneObject($BlockHolder, $SrcSite, $NewBlockHolderID, $DstSite);

			block::NewBlockHolder($NewBlockHolderID, 0, $DstBlockDefID, $DstSite['site_id'], $DstLanguageID);

			$BlockContents = block::GetBlockContentListByBlockHolderID($BlockHolder['block_holder_id']);

			foreach ($BlockContents as $BC)
				block::CloneBlockContent($SrcSite, $BC, $NewBlockHolderID, $DstLanguageID, $DstSite);
		}			
	}		

	public static function CloneBlockContent($SrcSite, $BlockContent, $DstBlockHolderID, $DstLanguageID, $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if ($BlockContent != null) {
			$NewBlockContentID = 0;
			$NewBlockContentLinkID = 0;
			object::CloneObjectWithObjectLink($BlockContent, $SrcSite, $DstBlockHolderID, $DstLanguageID, $NewBlockContentID, $NewBlockContentLinkID, 'N', 'N', $DstSite);

			$NewBlockImageID = 0;
			$NewBlockFileID = 0;

			if (intval($BlockContent['block_image_id']) > 0)
				$NewBlockImageID = filebase::CloneFile(intval($BlockContent['block_image_id']), $SrcSite, $NewBlockContentID, $DstSite);
			if (intval($BlockContent['block_file_id']) > 0)
				$NewBlockFileID = filebase::CloneFile(intval($BlockContent['block_file_id']), $SrcSite, $NewBlockContentID, $DstSite);

			block::NewBlockContent($NewBlockContentID, $BlockContent['block_content'], $BlockContent['block_link_url'], $NewBlockImageID, $NewBlockFileID);
		}
	}

	public static function UpdateTimeStamp($BlockContentID) {
		object::UpdateObjectTimeStamp($BlockContentID);

		$BlockContent = block::GetBlockContentInfo($BlockContentID);
		$BlockHolder = block::GetBlockHolderInfo($BlockContent['parent_object_id']);
		$Object = object::GetObjectInfo($BlockHolder['page_id']);
		if ($Object['object_type'] == 'PAGE')
			page::UpdateTimeStamp($BlockHolder['page_id']);
		elseif ($Object['object_type'] == 'LAYOUT_NEWS')
			layout_news::UpdateTimeStamp($BlockHolder['page_id']);
	}

	public static function CloneAllSiteBlockFromSiteToSite($SrcSite, $DstSite) {
		$SrcSiteLanguageRoots = language::GetAllSiteLanguageRoot($SrcSite['site_id'], 'N', 'Y');

		$BlockDefs = block::GetBlockDefListBySiteBlockHolderRootID($SrcSite['site_block_holder_root_id']);

		foreach ($BlockDefs as $D) {
			block::CloneBlockDef($SrcSite, $D, $DstSite['site_block_holder_root_id'], $DstSite);

			foreach ($SrcSiteLanguageRoots as $R) {
				block::CloneSiteBlockHolderWithContent($SrcSite, $D['block_definition_id'], $R['language_id'], $R['language_id'], $DstSite);
			}
		}
	}		
}