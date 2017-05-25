<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class link {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function CloneLink($Link, $SrcSite, $DstParentObjID, $DstLanguageID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($Link['object_link_id']) <= 0)
			customdb::err_die(1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__, true);

		object::CloneObjectWithObjectLink($Link, $SrcSite, $DstParentObjID, $DstLanguageID, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName, $DstSite);

		$query =	"	INSERT INTO link " .
					"	SET		link_id		= '" . intval($NewObjectID) . "', " .
					"			link_url	= '" . aveEscT($Link['link_url']) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function NewLink($ObjectID, $LinkURL = '') {
		$query =	"	INSERT INTO link " .
					"	SET		link_id		= '" . intval($ObjectID) . "', " .
					"			link_url	= '" . aveEscT($LinkURL) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetLinkInfo($ObjectID) {
		$query =	"	SELECT	* " .
					"	FROM 	object O	JOIN link L ON (O.object_id = L.link_id) " .
					"						JOIN object_link OL ON (OL.object_id = O.object_id) " .
					"	WHERE	O.object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function DeleteLink($ObjectID) {
		$query =	"	DELETE FROM	link " .
					"	WHERE	link_id	= '" . intval($ObjectID) . "'";
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

	public static function GetLinkXML($ObjectID) {
		$smarty = new mySmarty();

		$Link = link::GetLinkInfo($ObjectID);
		if ($Link != null) {
			$Link['object_seo_url'] = object::GetSeoURL($Link, '', $Link['language_id'], null);
			$smarty->assign('Object', $Link);
			$LinkXML = $smarty->fetch('api/object_info/LINK.tpl');
			return $LinkXML;
		}
		else
			return '';
	}

	public static function UpdateTimeStamp($LinkID) {
		object::UpdateObjectTimeStamp($LinkID);
	}
}