<?php

/**
 * @property cmObjectLinkInfo $_cmObjectInfo
 */
class cmObjectLink extends cmObject {
	
	public $object_link_id;
	
	function __construct($objLinkID, cmSite $cmSite) {
		parent::__construct(null, $cmSite);
		$this->object_link_id = $objLinkID;
	}
	
	protected function loadCmInfoFromDB() {
		$query = " SELECT * FROM object_link WHERE object_link_id = '" . intval($this->object_link_id) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$this->_cmObjectInfo = $result->fetch_object('cmObjectLinkInfo');
	}
	
	protected function loadLangInfoFromDB() {
	}
	
	protected function updateCmMetaInfoFromDB() {
	}
	
	public static function newObjectLinkToDB(cmSite $cmSite, $parentObjID, $objectID, $objectName, $langID = 0, $objectSystemFlag = 'normal', $orderID = DEFAULT_ORDER_ID, $objectLinkIsEnable = 'Y', $isShadowLink = 'N', $shadowParentID = 0, $depth = 1) {
		if ($shadowParentID == 0)
			$shadowParentID = $objectID;

		$query	=	"	INSERT INTO	object_link " .
					"	SET		cm_site_id = '" . $cmSite->site_id . "', " .
					"			parent_object_id	= '" . intval($parentObjID) . "', " .
					"			language_id			= '" . intval($langID) . "', " .
					"			object_id			= '" . intval($objectID) . "', " .
					"			object_link_is_enable = '" . ynval($objectLinkIsEnable) . "', " .
					"			object_name			= '" . aveEscT($objectName) . "', " .
					"			object_system_flag	= '" . aveEscT($objectSystemFlag) . "', " .
					"			order_id = '" . intval($orderID) . "', " .
					"			object_link_is_shadow = '" . ynval($isShadowLink) . "', " .
					"			shadow_parent_id = '" . intval($shadowParentID) . "', " .
					"			object_link_depth = '" . intval($depth) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$newObjectLinkID = customdb::mysqli()->insert_id;
		
		$cmObjLink = new cmObjectLink($newObjectLinkID);
		
		return $cmObjLink;
	}
	
	public static function tidyUpObjectOrder($parentObjID, $objType = 'ANY') {
		$obj_type_sql == '';

		if (is_array($objType)) {
			foreach ($objType as $T)
				$obj_type_sql = $obj_type_sql . " O.object_type = '" . aveEscT($T) . "' OR ";

			$obj_type_sql = "	AND	( " . $obj_type_sql . " 1 > 2 ) ";
		}
		elseif ($objType != 'ANY') {
			$obj_type_sql = "	AND	O.object_type = '" . aveEscT($objType) . "'";
		}

		$query =	"	SELECT		* " .
					"	FROM		object_link OL JOIN object O ON (OL.object_id = O.object_id AND OL.object_link_is_shadow = 'N') " .
					"	WHERE		OL.parent_object_id = '" . intval($parentObjID) . "'" . 
					"		AND		OL.object_link_depth = 1 " . $obj_type_sql .
					"	ORDER BY	OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$TheOrder = 1;

		while ($myResult = $result->fetch_assoc()) {
			$query2	=	"	UPDATE	object_link " .
						"	SET		order_id = '". intval($TheOrder) . "'" .
						"	WHERE	parent_object_id = '" . intval($myResult['parent_object_id']) . "'" .
						"		AND	shadow_parent_id = '" . intval($myResult['object_id']) . "'" .
						"		AND	object_link_is_shadow = 'Y' " .
						"		AND object_link_depth = 1 ";
			$result2 = ave_mysqli_query($query2, __FILE__, __LINE__, true);

			$query2	=	"	UPDATE	object_link " .
						"	SET		order_id = '". $TheOrder++ . "'" .
						"	WHERE	object_link_id = '" . intval($myResult['object_link_id']) . "'";
			$result2 = ave_mysqli_query($query2, __FILE__, __LINE__, true);
		}
	}
}

class cmObjectLinkInfo {
	public $cm_site_id;
	public $object_link_id;
	public $parent_object_id;
	public $language_id;
	public $object_link_is_enable;
	public $object_id;
	public $object_name;
	public $object_system_flag;
	public $order_id;
	public $object_link_is_shadow;
	public $shadow_parent_id;
	public $object_link_depth;	
}