<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class bonuspoint {

	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetBonusPointItemInfo($ObjectID, $LanguageID) {
		$query =	"	SELECT	*, BP.*, O.* " .
					"	FROM	bonus_point_item BP	JOIN		object O ON (O.object_id = BP.bonus_point_item_id) " .
					"								JOIN		object_link OL	ON (OL.object_id = O.object_id) " .
					"								LEFT JOIN	bonus_point_item_data BPD ON (BP.bonus_point_item_id = BPD.bonus_point_item_id AND BPD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	O.object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetBonusPointItemList($SiteID, $LanguageID, $SecurityLevel, $IsEnable = 'ALL') {
		$sql = '';
		if ($IsEnable == 'Y')
			$sql =	"	AND	O.object_is_enable = 'Y' ";
		elseif ($IsEnable == 'N')
			$sql =	"	AND	O.object_is_enable = 'N' ";

		$query =	"	SELECT	*, BP.*, O.* " .
					"	FROM	bonus_point_item BP	JOIN		object O		ON (O.object_id = BP.bonus_point_item_id) " .
					"								JOIN		object_link OL	ON (OL.object_id = O.object_id) " .
					"								LEFT JOIN	bonus_point_item_data BPD ON (BP.bonus_point_item_id = BPD.bonus_point_item_id AND BPD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	O.site_id = '" . intval($SiteID) . "'" .
					"		AND	O.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql .
					"	ORDER BY OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$BonusPointItemList = array();
		while ($myResult = $result->fetch_assoc())
			array_push($BonusPointItemList, $myResult);
		return $BonusPointItemList;
	}

	public static function NewBonusPointItem($ObjectID, $RefName, $Type, $BonusPointRequired, $Cash) {
		$query =	"	INSERT INTO	bonus_point_item " .
					"	SET		bonus_point_item_id			= '" . intval($ObjectID) . "', " .
					"			bonus_point_item_ref_name	= '" . aveEscT($RefName) . "', " .
					"			bonus_point_item_type		= '" . aveEscT($Type) . "', " .
					"			bonus_point_required		= '" . intval($BonusPointRequired) . "', " .
					"			cash						= '" . doubleval($Cash) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function TouchBonusPointItemData($BonusPointItemID, $LanguageID) {
		$query =	"	INSERT INTO bonus_point_item_data " .
					"	SET		bonus_point_item_id	= '" . intval($BonusPointItemID) . "', " .
					"			language_id			= '" . intval($LanguageID) . "'" .
					"	ON DUPLICATE KEY UPDATE bonus_point_item_id = '" . intval($BonusPointItemID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function IsBonusPointItemRemovable($BonusPointItemID) {
		$query =	"	SELECT	* " .
					"	FROM 	myorder " .
					"	WHERE	bonus_point_item_id = '" . intval($BonusPointItemID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return false;
		else
			return true;
	}

	public static function UpdateThumbnail($BonusPointItem, $Site, $File) {
		if ($File['size'] > 0) {
			$FileID = filebase::AddPhoto($File, $Site['site_product_media_small_width'], $Site['site_product_media_small_width'], $Site, 0, $BonusPointItem['bonus_point_item_id']);
			if ($FileID !== false) {
				if ($BonusPointItem['object_thumbnail_file_id'] != 0)
					filebase::DeleteFile($BonusPointItem['object_thumbnail_file_id'], $Site);

				$query =	"	UPDATE	object " .
							"	SET		object_thumbnail_file_id = '" . intval($FileID) . "'" .
							"	WHERE	object_id =  '" . intval($BonusPointItem['bonus_point_item_id']) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
			return $FileID;
		}
		return false;
	}

	public static function DeleteBonusPointItem($ObjectID, $Site) {
		if (!bonuspoint::IsBonusPointItemRemovable($ObjectID))
			return false;

		$BonusPointItem = bonuspoint::GetBonusPointItemInfo($ObjectID, 0);
		$TotalMedia = 0;
		$MediaList = media::GetMediaList($ObjectID, 0, $TotalMedia, 1, 999999, 999999, false, false);

		$query =	"	UPDATE	cart_details " .
					"	SET		bonus_point_item_id = 0 " .
					"	WHERE	bonus_point_item_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Delete Bonus Point Item
		$query =	"	DELETE FROM	bonus_point_item " .
					"	WHERE	bonus_point_item_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	bonus_point_item_data " .
					"	WHERE	bonus_point_item_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($BonusPointItem['object_thumbnail_file_id'] != 0)
			filebase::DeleteFile($BonusPointItem['object_thumbnail_file_id'], $Site);

		foreach ($MediaList as $M)
			media::DeleteMedia($M['object_id'], $Site, true);

		object::DeleteObject($ObjectID);

		// Delete all object links
		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id = '" . intval($ObjectID) . "'" .
					"			OR	object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetBonusPointItemXML($ObjectID, $LanguageID, $XmlIncludeRootTag = true) {
		$smarty = new mySmarty();
		$BonusPointItem = bonuspoint::GetBonusPointItemInfo($ObjectID, $LanguageID);
		$BonusPointItem['object_seo_url'] = object::GetSeoURL($BonusPointItem, '', $LanguageID, null);
		$smarty->assign('Object', $BonusPointItem);
		$BonusPointItemXML = $smarty->fetch('api/object_info/BONUS_POINT_ITEM.tpl');
		if ($XmlIncludeRootTag)
			return "<bonus_point_item>" . $BonusPointItemXML . "</bonus_point_item>";
		else
			return $BonusPointItemXML;
	}

	public static function GetBonusPointItemListXML($SiteID, $LanguageID, $SecurityLevel) {
		$smarty = new mySmarty();
		$BonusPointItemList = bonuspoint::GetBonusPointItemList($SiteID, $LanguageID, $SecurityLevel, 'Y');
		$BonusPointItemListXML = '';
		foreach ($BonusPointItemList as $B) {
			$B['object_seo_url'] = object::GetSeoURL($B, '', $LanguageID, null);
			$smarty->assign('Object', $B);
			$BonusPointItemListXML = $BonusPointItemListXML . $smarty->fetch('api/object_info/BONUS_POINT_ITEM.tpl');
		}
		return "<bonus_point_item_list>" . $BonusPointItemListXML . "</bonus_point_item_list>";
	}

	public static function UpdateTimeStamp($BonusPointItemID) {
		object::UpdateObjectTimeStamp($BonusPointItemID);
	}
}