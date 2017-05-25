<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class layout {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function NewLayout($ObjectID, $LayoutName = '', $LayoutFileID = 0) {
		$query =	"	INSERT INTO layout " .
					"	SET		layout_id		= '" . intval($ObjectID) . "', " .
					"			layout_name		= '" . aveEscT($LayoutName) . "', " .
					"			layout_file_id	= '" . intval($LayoutFileID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetLayoutInfo($LayoutID) {
		$query =	"	SELECT	* " .
					"	FROM	layout L	JOIN		object O			ON (L.layout_id = O.object_id) " .
					"	WHERE	L.layout_id =  '" . intval($LayoutID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetLayoutList($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	layout L JOIN object O ON (L.layout_id = O.object_id) " .
					"	WHERE	O.site_id =  '" . intval($SiteID) . "'" .
					"	ORDER BY L.layout_name ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$Layouts = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($Layouts, $myResult);
		}
		return $Layouts;
	}

	public static function DeleteLayoutFile($LayoutID, $Site) {
		$Layout = layout::GetLayoutInfo($LayoutID);
		if ($Layout['layout_file_id'] != 0) {
			filebase::DeleteFile($Layout['layout_file_id'], $Site);

			$query =	"	UPDATE	layout " .
						"	SET		layout_file_id = 0 " .
						"	WHERE	layout_id =  '" . intval($LayoutID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function UpdateLayoutFile($LayoutID, $Site, $File) {
		if ($File['size'] > 0) {
			$LayoutFileID = filebase::AddFile($File, $Site, SITE_PARENT_ID);
			if ($LayoutFileID !== false) {
				layout::DeleteLayoutFile($LayoutID, $Site);
				$query =	"	UPDATE	layout " .
							"	SET		layout_file_id = '" . intval($LayoutFileID) . "'" .
							"	WHERE	layout_id =  '" . intval($LayoutID) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
			return $LayoutFileID;
		}
		return 0;
	}

	public static function DeleteLayout($LayoutID, $Site) {
		$Layout = layout::GetLayoutInfo($LayoutID);

		// Find All Block Def to delete
		$BlockDefs = block::GetBlockDefListByLayoutID($LayoutID);
		foreach ($BlockDefs as $D)
			block::DeleteBlockDef($D['block_definition_id'], $Site);

		// Update All page using this layout
		$query =	"	UPDATE	page " .
					"	SET		layout_id = 0 " .
					"	WHERE	layout_id =  '" . intval($LayoutID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Delete Layout File
		if ($Layout['layout_file_id'] != 0)
			filebase::DeleteFile($Layout['layout_file_id'], $Site);

		// Delete the layout record and object
		$query =	"	DELETE FROM	layout " .
					"	WHERE		layout_id = '" . intval($LayoutID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($LayoutID);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE		object_id = '" . intval($LayoutID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetLayoutXML($PageID, $LayoutID) {
		$smarty = new mySmarty();
		$Layout = layout::GetLayoutInfo($LayoutID);
		if ($Layout != null) {
			$BlockDefXML = '';

			$BlockDefs = block::GetBlockDefListByLayoutID($LayoutID);
			foreach ($BlockDefs as $BD) {
				$BlockDefXML = $BlockDefXML . block::GetBlockDefXML($PageID, $BD['block_definition_id']);
			}

			$smarty->assign('Object', $Layout);
			$smarty->assign('BlockDefXML', $BlockDefXML);
			$LayoutXML = $smarty->fetch('api/object_info/LAYOUT.tpl');
			return $LayoutXML;
		}
		return '';
	}

	public static function CloneLayoutContent($SrcSite, $SrcPageID, $DstPageID, $SrcLayoutID, $DstLanguageID, $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		$Layout = layout::GetLayoutInfo($SrcLayoutID);
		if ($Layout != null) {
			$BlockDefs = block::GetBlockDefListByLayoutID($SrcLayoutID);
			foreach ($BlockDefs as $BD) {
				block::CloneBlockHolderWithContent($SrcSite, $SrcPageID, $DstPageID, $BD['block_definition_id'], $DstLanguageID, $DstSite);
			}
		}			
	}

	public static function CloneLayout($SrcSite, $SrcLayout, $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if ($SrcLayout != null) {
			object::CloneObject($SrcLayout, $SrcSite, $NewObjectID, $DstSite);

			$NewLayoutFileID = 0;
			if ($SrcLayout['layout_file_id'] != 0)
				$NewLayoutFileID = filebase::CloneFile($SrcLayout['layout_file_id'], $SrcSite, $NewObjectID, $DstSite);

			layout::NewLayout($NewObjectID, $SrcLayout['layout_name'], $NewLayoutFileID);

			$BlockDefs = block::GetBlockDefListByLayoutID($SrcLayout['layout_id']);

			foreach ($BlockDefs as $D)
				block::CloneBlockDef($SrcSite, $D, $NewObjectID, $DstSite);
		}
	}
}