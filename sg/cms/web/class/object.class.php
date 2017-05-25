<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class object {

	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function CloneObject($Object, $SrcSite, &$NewObjectID, $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($Object['object_id']) <= 0)
			customdb::err_die(1, "Invalid Object ID to clone", "", realpath(__FILE__), __LINE__, true);

		$query	=	"	INSERT INTO object (object_type, site_id, object_is_enable, object_security_level, object_meta_title, object_meta_description, object_meta_keywords, object_friendly_url, object_lang_switch_id, is_removed, object_archive_date, object_publish_date, object_owner_content_admin_id, object_owner_content_admin_group_id, object_publisher_content_admin_group_id, object_permission_browse_children, object_permission_add_children, object_permission_edit, object_permission_delete, object_custom_rgb_1, object_custom_rgb_2, object_custom_rgb_3, object_custom_rgb_4, object_custom_rgb_5, object_custom_rgb_6, object_custom_rgb_7, object_custom_rgb_8, object_custom_rgb_9, object_global_order_id, object_id_clone_from) " .
					"	SELECT 				object_type, " . intval($DstSite['site_id']) . ", object_is_enable, object_security_level, object_meta_title, object_meta_description, object_meta_keywords, object_friendly_url, object_lang_switch_id, is_removed, object_archive_date, object_publish_date, object_owner_content_admin_id, object_owner_content_admin_group_id, object_publisher_content_admin_group_id, object_permission_browse_children, object_permission_add_children, object_permission_edit, object_permission_delete, object_custom_rgb_1, object_custom_rgb_2, object_custom_rgb_3, object_custom_rgb_4, object_custom_rgb_5, object_custom_rgb_6, object_custom_rgb_7, object_custom_rgb_8, object_custom_rgb_9, object_global_order_id, " . intval($Object['object_id']) .
					"	FROM		object " .
					"	WHERE		object_id = '" . intval($Object['object_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$NewObjectID = customdb::mysqli()->insert_id;

		// Clone file
		if (intval($Object['object_thumbnail_file_id']) > 0) {
			$ThumbnailFileID = filebase::CloneFile(intval($Object['object_thumbnail_file_id']), $SrcSite, $NewObjectID, $DstSite);

			$query	=	"	UPDATE	object " .
						"	SET		object_thumbnail_file_id = '" . intval($ThumbnailFileID) . "'" .		
						"	WHERE	object_id = '" . intval($NewObjectID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function CloneObjectLink($Object, $Site, $DstParentObjID, $DstLanguageID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N') {
		if (intval($Object['object_link_id']) <= 0)
			customdb::err_die(1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__, true);

		$NewObjectName = $Object['object_name'];
		if ($AddCopyOfToObjectName == 'Y')
			$NewObjectName = "Copy of " . $NewObjectName;

		$NewObjectLinkID = object::NewObjectLink($DstParentObjID, $Object['object_id'], $NewObjectName, intval($DstLanguageID), $Object['object_system_flag'], $Object['order_id'], $Object['object_link_is_enable']);

		if ($ReorderSiblingLinkID == 'Y')
			object::TidyUpObjectOrder($DstParentObjID, 'ANY');
	}

	public static function CloneObjectWithObjectLink($Object, $SrcSite, $DstParentObjID, $DstLanguageID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($Object['object_link_id']) <= 0)
			customdb::err_die(1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__, true);

		object::CloneObject($Object, $SrcSite, $NewObjectID, $DstSite);

		$NewObjectName = $Object['object_name'];
		if ($AddCopyOfToObjectName == 'Y')
			$NewObjectName = "Copy of " . $NewObjectName;

		$NewObjectLinkID = object::NewObjectLink($DstParentObjID, $NewObjectID, $NewObjectName, intval($DstLanguageID), $Object['object_system_flag'], $Object['order_id'], $Object['object_link_is_enable']);

		if ($ReorderSiblingLinkID == 'Y')
			object::TidyUpObjectOrder($DstParentObjID, 'ANY');
	}

	public static function GetObjectInfo($ObjID) {
		$query	=	"	SELECT	*, O.* " .
					"	FROM	object O LEFT JOIN object_link OL ON (O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"	WHERE	O.object_id = '" . intval($ObjID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function NewObject($ObjType, $SiteID, $SecurityLevel = 0, $ArchiveDate = OBJECT_DEFAULT_ARCHIVE_DATE, $PublishDate = OBJECT_DEFAULT_PUBLISH_DATE, $IsEnable = 'Y', $InheritPermissionFromParent = 'Y', $ParentObj = null) {
		if (!in_array($ObjType, $GLOBALS['ObjectTypeList']))
			die('Unknown Object Type');

		$query	=	"	INSERT INTO object " .
					"	SET		object_type = '" . aveEscT($ObjType) . "', " .
					"			site_id = '" . intval($SiteID) . "', " .
					"			object_is_enable = '" . ynval($IsEnable) . "', " .
					"			object_security_level	= '" . intval($SecurityLevel) . "', " .
					"			object_archive_date		= '" . aveEscT($ArchiveDate) . "', " .
					"			object_publish_date		= '" . aveEscT($PublishDate) . "', " .
					"			modify_date = NOW(), " .
					"			create_date = NOW(), " .
					"			counter_alltime = 0, " .
					"			is_removed = 'N', " .
					"			object_removed_date = NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$NewObjID = customdb::mysqli()->insert_id;

		if ($InheritPermissionFromParent == 'Y') {
			global $AdminInfo;

			if ($ParentObj == null) {
				$Object = object::GetObjectInfo($NewObjID);
				$ParentObj = object::GetParentObjForPermissionChecking($Object);
			}

			object::UpdateObjectPermission($NewObjID, intval($AdminInfo['content_admin_id']), $ParentObj['object_owner_content_admin_group_id'], $ParentObj['object_publisher_content_admin_group_id'], $ParentObj['object_permission_browse_children'], $ParentObj['object_permission_add_children'], $ParentObj['object_permission_edit'], $ParentObj['object_permission_delete'], 0);
		}

		return $NewObjID;
	}

	public static function GetObjectLinkInfo($ObjectLinkID) {
		$query =	"	SELECT	* " .
					"	FROM 	object O JOIN object_link OL ON (OL.object_id = O.object_id) " .
					"	WHERE	OL.object_link_id = '" . intval($ObjectLinkID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function NewObjectLink($ParentObjID, $ObjectID, $ObjectName, $LanguageID = 0, $ObjectSystemFlag = 'normal', $OrderID = DEFAULT_ORDER_ID, $ObjectLinkIsEnable = 'Y', $IsShadowLink = 'N', $ShadowParentID = 0) {

		if ($ShadowParentID == 0)
			$ShadowParentID = $ObjectID;

		$query	=	"	INSERT INTO	object_link " .
					"	SET		parent_object_id	= '" . intval($ParentObjID) . "', " .
					"			language_id			= '" . intval($LanguageID) . "', " .
					"			object_id			= '" . intval($ObjectID) . "', " .
					"			object_link_is_enable = '" . ynval($ObjectLinkIsEnable) . "', " .
					"			object_name			= '" . aveEscT($ObjectName) . "', " .
					"			object_system_flag	= '" . aveEscT($ObjectSystemFlag) . "', " .
					"			order_id = '" . intval($OrderID) . "', " .
					"			object_link_is_shadow = '" . ynval($IsShadowLink) . "', " .
					"			shadow_parent_id = '" . intval($ShadowParentID) . "'"
				;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		return customdb::mysqli()->insert_id;
	}

	public static function TidyUpObjectGlobalOrder($SiteID, $ObjType = 'ANY') {
		$obj_type_sql == '';

		if (is_array($ObjType)) {
			foreach ($ObjType as $T)
				$obj_type_sql = $obj_type_sql . " O.object_type = '" . aveEscT($T) . "' OR ";

			$obj_type_sql = "	AND	( " . $obj_type_sql . " 1 > 2 ) ";
		}
		elseif ($ObjType != 'ANY') {
			$obj_type_sql = "	AND	O.object_type = '" . aveEscT($ObjType) . "'";
		}

		$query =	"	SELECT		* " .
					"	FROM		object O " .
					"	WHERE		O.site_id = '" . intval($SiteID) . "'" . $obj_type_sql .
					"	ORDER BY	O.object_global_order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$TheOrder = 1;

		while ($myResult = $result->fetch_assoc()) {
			$query2	=	"	UPDATE	object " .
						"	SET		object_global_order_id = '". $TheOrder++ . "'" .
						"	WHERE	object_id = '" . intval($myResult['object_id']) . "'";
			$result2 = ave_mysqli_query($query2, __FILE__, __LINE__, true);
		}			

	}

	public static function TidyUpObjectOrder($ParentObjID, $ObjType = 'ANY') {
		$obj_type_sql == '';

		if (is_array($ObjType)) {
			foreach ($ObjType as $T)
				$obj_type_sql = $obj_type_sql . " O.object_type = '" . aveEscT($T) . "' OR ";

			$obj_type_sql = "	AND	( " . $obj_type_sql . " 1 > 2 ) ";
		}
		elseif ($ObjType != 'ANY') {
			$obj_type_sql = "	AND	O.object_type = '" . aveEscT($ObjType) . "'";
		}

		$query =	"	SELECT		* " .
					"	FROM		object_link OL JOIN object O ON (OL.object_id = O.object_id AND OL.object_link_is_shadow = 'N') " .
					"	WHERE		OL.parent_object_id = '" . intval($ParentObjID) . "'" . $obj_type_sql .
					"	ORDER BY	OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$TheOrder = 1;

		while ($myResult = $result->fetch_assoc()) {
			$query2	=	"	UPDATE	object_link " .
						"	SET		order_id = '". intval($TheOrder) . "'" .
						"	WHERE	parent_object_id = '" . intval($myResult['parent_object_id']) . "'" .
						"		AND	shadow_parent_id = '" . intval($myResult['object_id']) . "'" .
						"		AND	object_link_is_shadow = 'Y' ";
			$result2 = ave_mysqli_query($query2, __FILE__, __LINE__, true);

			$query2	=	"	UPDATE	object_link " .
						"	SET		order_id = '". $TheOrder++ . "'" .
						"	WHERE	object_link_id = '" . intval($myResult['object_link_id']) . "'";
			$result2 = ave_mysqli_query($query2, __FILE__, __LINE__, true);
		}
	}

	public static function CreateObjectInTree($NewObjectType, $RefObjectLink, $CreateType, $SiteID, &$NewObjectID, &$NewObjectLinkID, $ObjectName = 'Untitled', $ParentObj = null) {
		if ($ParentObj === null) {
			if ($CreateType == 'inside') {
				$ParentObj = $RefObjectLink;
			}
			else {
				$ParentObj = object::GetParentObjForPermissionChecking($RefObjectLink);
			}
		}

		$Site = site::GetSiteInfo($SiteID);

		if ($CreateType == 'inside') {
			$NewObjectID = object::NewObject($NewObjectType, $SiteID, $Site['site_default_security_level'], OBJECT_DEFAULT_ARCHIVE_DATE, OBJECT_DEFAULT_PUBLISH_DATE, 'Y', 'Y', $ParentObj);
			$NewObjectLinkID = object::NewObjectLink($RefObjectLink['object_id'], $NewObjectID, $ObjectName, $RefObjectLink['language_id'], 'normal', DEFAULT_ORDER_ID);
			object::TidyUpObjectOrder($RefObjectLink['object_id']);
		}
		elseif ($CreateType == 'before' || $CreateType == 'after') {
			$OrderVal = 0;
			if ($CreateType == 'before')
				$OrderVal = -0.5;
			elseif ($CreateType == 'after')
				$OrderVal = 0.5;
			$NewObjectID = object::NewObject($NewObjectType, $SiteID, $Site['site_default_security_level'], OBJECT_DEFAULT_ARCHIVE_DATE, OBJECT_DEFAULT_PUBLISH_DATE, 'Y', 'Y', $ParentObj);
			$NewObjectLinkID = object::NewObjectLink($RefObjectLink['parent_object_id'], $NewObjectID, $ObjectName, $RefObjectLink['language_id'], 'normal', $RefObjectLink['order_id'] + $OrderVal);
			object::TidyUpObjectOrder($RefObjectLink['parent_object_id']);
		}
	}

	public static function CreateObjectLinkInTree($NewObjectType, $RefObjectLink, $CreateType, $SiteID, $ObjectID, &$NewObjectLinkID, $ObjectName = 'Untitled') {
		if ($CreateType == 'inside') {
			$NewObjectLinkID = object::NewObjectLink($RefObjectLink['object_id'], $ObjectID, $ObjectName, $RefObjectLink['language_id'], 'normal', DEFAULT_ORDER_ID);
			object::TidyUpObjectOrder($RefObjectLink['object_id']);
		}
		elseif ($CreateType == 'before' || $CreateType == 'after') {
			$OrderVal = 0;
			if ($CreateType == 'before')
				$OrderVal = -0.5;
			elseif ($CreateType == 'after')
				$OrderVal = 0.5;
			$NewObjectLinkID = object::NewObjectLink($RefObjectLink['parent_object_id'], $ObjectID, $ObjectName, $RefObjectLink['language_id'], 'normal', $RefObjectLink['order_id'] + $OrderVal);
			object::TidyUpObjectOrder($RefObjectLink['parent_object_id']);
		}
	}

	public static function ValidateCreateObjectInTree($ArrayAllowedObjectParent, $RefObjectLink, $CreateType, $SiteID, $XMLDie = true, $NewObjectType = '') {
		if ($RefObjectLink == null || $RefObjectLink['site_id'] != $SiteID) {
			if ($XMLDie)
				XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
			else
				return false;
		}

		if ($CreateType == 'inside') {
			acl::ObjPermissionBarrier("add_children", $RefObjectLink, __FILE__, $XMLDie);

			if (!in_array($RefObjectLink['object_type'], $ArrayAllowedObjectParent)) {
				if ($XMLDie)
					XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
				else
					return false;
			}

			// Special check for product group
			if ($RefObjectLink['object_type'] == 'PRODUCT_CATEGORY' && $NewObjectType == 'PRODUCT_CATEGORY') {
				$ParentProductCat = product::GetProductCatInfo($RefObjectLink['object_id'], 0);
				if (product::IsProductCatAProductGroup($ParentProductCat)) {
					if ($XMLDie)
						XMLDie(__LINE__, ADMIN_ERROR_AJAX_PRODUCT_CAT_MOVE_TO_PRODUCT_GROUP);
					else
						return false;
				}
			}
		}
		elseif ($CreateType == 'before' || $CreateType == 'after') {
			$RefParentObject = object::GetObjectInfo($RefObjectLink['parent_object_id']);
			acl::ObjPermissionBarrier("add_children", $RefParentObject, __FILE__, $XMLDie);
			if (!in_array($RefParentObject['object_type'], $ArrayAllowedObjectParent)) {
				if ($XMLDie)
					XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
				else
					return false;
			}

			// Special check for product group
			if ($RefParentObject['object_type'] == 'PRODUCT_CATEGORY' && $NewObjectType == 'PRODUCT_CATEGORY') {
				$ParentProductCat = product::GetProductCatInfo($RefParentObject['object_id'], 0);
				if (product::IsProductCatAProductGroup($ParentProductCat)) {
					if ($XMLDie)
						XMLDie(__LINE__, ADMIN_ERROR_AJAX_PRODUCT_CAT_MOVE_TO_PRODUCT_GROUP);
					else
						return false;
				}
			}


		}
		return true;
	}

	public static function GetObjectLinkByParentObjIDAndObjID($ParentObjID, $ObjectID, $ExcludeShadowLink = true) {
		if ($ExcludeShadowLink)
			$sql_shadow_link = " AND OL.object_link_is_shadow ='N' ";

		$query =	"	SELECT		* " .
					"	FROM		object_link OL JOIN object O ON (OL.object_id = O.object_id " . $sql_shadow_link . ") " .
					"	WHERE		OL.parent_object_id = '" . intval($ParentObjID) . "'" . 
					"			AND	O.object_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function ValidateMoveObjectInTree($ArrayAllowedObjectParent, $ObjectLink, $RefObjectLink, $MoveType, $SiteID) {
		if ($RefObjectLink == null || $RefObjectLink['site_id'] != $SiteID)
			XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
		if ($ObjectLink == null || $ObjectLink['site_id'] != $SiteID)
			XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

		if ($MoveType == 'inside') {
			if (!in_array($RefObjectLink['object_type'], $ArrayAllowedObjectParent))
				XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

			// Check for duplicate pair except for ALBUM!
			if ($ObjectLink['parent_object_id'] != $RefObjectLink['object_id'] && $ObjectLink['object_type'] != 'ALBUM') {
				if ( object::GetObjectLinkByParentObjIDAndObjID($RefObjectLink['object_id'], $ObjectLink['object_id']) != null )
					XMLDie(__LINE__, ADMIN_ERROR_AJAX_MOVE_TO_SAME_PARENT);
			}

			// Special check for product group
			if ($RefObjectLink['object_type'] == 'PRODUCT_CATEGORY' && $ObjectLink['object_type'] == 'PRODUCT_CATEGORY') {
				$ParentProductCat = product::GetProductCatInfo($RefObjectLink['object_id'], 0);
				if (product::IsProductCatAProductGroup($ParentProductCat))
					XMLDie(__LINE__, ADMIN_ERROR_AJAX_PRODUCT_CAT_MOVE_TO_PRODUCT_GROUP);
			}
		}
		elseif ($MoveType == 'before' || $MoveType == 'after') {
			$RefParentObject = object::GetObjectInfo($RefObjectLink['parent_object_id']);
			if (!in_array($RefParentObject['object_type'], $ArrayAllowedObjectParent))
				XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

			if ($ObjectLink['parent_object_id'] != $RefParentObject['object_id'] && $ObjectLink['object_type'] != 'ALBUM') {					
				if ( object::GetObjectLinkByParentObjIDAndObjID($RefParentObject['object_id'], $ObjectLink['object_id']) != null )
					XMLDie(__LINE__, ADMIN_ERROR_AJAX_MOVE_TO_SAME_PARENT);
			}

			// Special check for product group
			if ($RefParentObject['object_type'] == 'PRODUCT_CATEGORY' && $ObjectLink['object_type'] == 'PRODUCT_CATEGORY') {
				$ParentProductCat = product::GetProductCatInfo($RefParentObject['object_id'], 0);
				if (product::IsProductCatAProductGroup($ParentProductCat))
					XMLDie(__LINE__, ADMIN_ERROR_AJAX_PRODUCT_CAT_MOVE_TO_PRODUCT_GROUP);
			}

		}
		return true;
	}

	public static function MoveObject($ObjectLink, $RefObjectLink, $MoveType) {
		if ($MoveType == 'inside') {
			$query	=	"	UPDATE	object_link " .
						"	SET		parent_object_id	= '" . intval($RefObjectLink['object_id']) . "', " .
						"			order_id = '" . DEFAULT_ORDER_ID . "'" .
						"	WHERE	object_link_id = '" . intval($ObjectLink['object_link_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			object::TidyUpObjectOrder($ObjectLink['parent_object_id']);
			object::TidyUpObjectOrder($RefObjectLink['object_id']);
		}
		elseif ($MoveType == 'before' || $MoveType == 'after') {
			$NewOrderID = DEFAULT_ORDER_ID;
			if ($MoveType == 'before')
				$NewOrderID = $RefObjectLink['order_id'] - 0.5;
			elseif ($MoveType == 'after')
				$NewOrderID = $RefObjectLink['order_id'] + 0.5;

			$query	=	"	UPDATE	object_link " .
						"	SET		parent_object_id	= '" . intval($RefObjectLink['parent_object_id']) . "', " .
						"			order_id = '" . $NewOrderID . "'" .
						"	WHERE	object_link_id = '" . intval($ObjectLink['object_link_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			object::TidyUpObjectOrder($ObjectLink['parent_object_id']);
			object::TidyUpObjectOrder($RefObjectLink['parent_object_id']);
		}
	}

	public static function RemoveObjectThumbnail($Object, $Site) {
		if ($Object['object_thumbnail_file_id'] != 0) {
			filebase::DeleteFile($Object['object_thumbnail_file_id'], $Site);

			$query =	"	UPDATE	object " .
						"	SET		object_thumbnail_file_id = 0 " .
						"	WHERE	object_id =  '" . intval($Object['object_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			site::EmptyAPICache($Site['site_id']);
		}
	}

	public static function UpdateObjectThumbnail($Object, $Site, $File, $Width, $Height) {

		if ($File['size'] > 0) {
			if(!file_exists($File['tmp_name']))
				customdb::err_die(1, "Error: File Upload Problem.", $File['tmp_name'], realpath(__FILE__), __LINE__, true);

			$FileExt = strtolower(substr(strrchr($File['name'], '.'), 1));

			if (!media::IsValidMediaType($FileExt))
				return false;

			$FileID = 0;

			if ($FileExt == 'gif' || $FileExt == 'jpg' || $FileExt == 'png') {
				$WatermarkID = 0;
				if ($Object['object_type'] == 'PRODUCT' && intval($Site['site_product_media_watermark_small_file_id']) != 0) {
					$WatermarkID = $Site['site_product_media_watermark_small_file_id'];
				}
				elseif ($Object['object_type'] == 'ALBUM' && intval($Site['site_media_watermark_small_file_id']) != 0) {
					$WatermarkID = $Site['site_media_watermark_small_file_id'];
				}

				$FileID	= filebase::AddPhoto($File, $Width, $Height, $Site, $WatermarkID, $Object['object_id']);
			}
			else
				return false;

			if ($FileID !== false) {
				if ($Object['object_thumbnail_file_id'] != 0)
					filebase::DeleteFile($Object['object_thumbnail_file_id'], $Site);

				$query =	"	UPDATE	object " .
							"	SET		object_thumbnail_file_id = '" . intval($FileID) . "'" .
							"	WHERE	object_id =  '" . intval($Object['object_id']) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
				return $FileID;
			}
			return false;
		}
		return false;
	}

	public static function UpdateObjectSEOData($ObjectID, $MetaTitle, $MetaDesc, $MetaKeyword, $MetaFriendlyURL, $ObjectLangSwitchID = '') {
		$sql = '';
		if (isset($MetaTitle))
			$sql = $sql . " object_meta_title = '" . aveEscT($MetaTitle) . "',";
		if (isset($MetaDesc))
			$sql = $sql . " object_meta_description = '" . aveEscT($MetaDesc) . "',";
		if (isset($MetaKeyword))
			$sql = $sql . " object_meta_keywords = '" . aveEscT($MetaKeyword) . "',";
		if (isset($MetaFriendlyURL))
			$sql = $sql . " object_friendly_url = '" . aveEscT($MetaFriendlyURL) . "',";
		if (isset($ObjectLangSwitchID))
			$sql = $sql . " object_lang_switch_id = '" . aveEscT($ObjectLangSwitchID) . "',";

		if (strlen($sql) > 0) {
			$sql = substr($sql, 0, -1);

			$query	=	"	UPDATE	object " .
						"	SET		" . $sql .
						"	WHERE	object_id = '" . intval($ObjectID) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function UpdateObjectTimeStamp($ObjectID, $DataTime = null) {
		if ($DateTime == null)
			$DateTime = "NOW()";
		else
			$DateTime = "'" . aveEscT($DataTime) . "'";

		$query	=	"	UPDATE	object " .
					"	SET		modify_date	= " . $DateTime .
					"	WHERE	object_id			= '" . intval($ObjectID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function UpdateObjectPermission($ObjectID, $OwnerContentAdminID, $OwnerContentAdminGroupID, $PublisherContentAdminGroupID, $ObjPermissionBrowse, $ObjPermissionAdd, $ObjPermissionEdit, $ObjPermissionDelete, $UpdateChildMaxDepth = 0) {

		$UpdateObjectList = array();

		$TheObj = object::GetObjectInfo($ObjectID);

		if ($UpdateChildMaxDepth > 0) {
			$UpdateObjectList = object::GetAllChildrenObjForPermissionUpdate($TheObj, $UpdateChildMaxDepth);
		}
		array_push($UpdateObjectList, $TheObj);

		$sql = '';
		if (isset($OwnerContentAdminID))
			$sql = $sql . " object_owner_content_admin_id = '" . intval($OwnerContentAdminID) . "',";
		if (isset($OwnerContentAdminGroupID))
			$sql = $sql . " object_owner_content_admin_group_id = '" . intval($OwnerContentAdminGroupID) . "',";
		if (isset($PublisherContentAdminGroupID))
			$sql = $sql . " object_publisher_content_admin_group_id = '" . intval($PublisherContentAdminGroupID) . "',";
		if (isset($ObjPermissionBrowse))
			$sql = $sql . " object_permission_browse_children = '" . aveEscT($ObjPermissionBrowse) . "',";
		if (isset($ObjPermissionAdd))
			$sql = $sql . " object_permission_add_children = '" . aveEscT($ObjPermissionAdd) . "',";
		if (isset($ObjPermissionEdit))
			$sql = $sql . " object_permission_edit = '" . aveEscT($ObjPermissionEdit) . "',";
		if (isset($ObjPermissionDelete))
			$sql = $sql . " object_permission_delete = '" . aveEscT($ObjPermissionDelete) . "',";

		if (strlen($sql) > 0) {
			$sql = substr($sql, 0, -1);

			foreach ($UpdateObjectList as $O) {
				$query	=	"	UPDATE	object " .
							"	SET		" . $sql .
							"	WHERE	object_id = '" . intval($O['object_id']) . "' ";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}				
		}
	}

	public static function UpdateObjectCommonDataFromRequest($Object) {
		// Should handle the security level change request here!!!!!
		global $IsContentAdmin, $AdminInfo;

		$security_level_sql = '';

		if ($IsContentAdmin && acl::CheckObjPermission('publish', $Object)) {
			if (isset($_REQUEST['object_security_level']))
				$security_level_sql = "	object_security_level	= '" . intval($_REQUEST['object_security_level']) . "', ";				
		}
		else {
			if (2 > 1 || $Object['object_security_level'] > intval($_REQUEST['object_security_level'])) {
				// Create the workflow here!
				$ContentWriterList = array();
				$ContentAdminList = array();

				$Para = array();
				$Para['int_1'] = intval($_REQUEST['object_security_level']);
				$Para['int_2'] = intval($Object['object_security_level']);

				workflow::OverrideExistingRunningWorkflow($Object['object_id'], 'SECURITY_LEVEL_UPDATE_REQUEST');

				acl::GetObjectPublisherList($Object, $ContentWriterList, $ContentAdminList);
				$NewWorkflowID = workflow::NewWorkflow($Object['object_id'], 'SECURITY_LEVEL_UPDATE_REQUEST', $AdminInfo['content_admin_id'], $Object['object_publisher_content_admin_group_id'], '', $Para);

				$Msg = 'Security level update request from ' . $AdminInfo['email'];

				foreach ($ContentWriterList as $C) {
					workflow::NewContentAdminMsg($AdminInfo['content_admin_id'], $C['content_admin_id'], $NewWorkflowID, $Msg);
				}
				foreach ($ContentAdminList as $C) {
					workflow::NewContentAdminMsg($AdminInfo['content_admin_id'], $C['content_admin_id'], $NewWorkflowID, $Msg);
				}
			}
		}

		$ObjectArchiveDateText = aveEsc($_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute']);
		$ObjectPublishDateText = aveEsc($_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute']);

		$rgb_sql = GetCustomTextSQL("object", "rgb");

		$query	=	"	UPDATE	object " .
					"	SET		object_is_enable		= '" . ynval($_REQUEST['object_is_enable']) . "', " . $security_level_sql . $rgb_sql .
					"			object_archive_date		= '" . $ObjectArchiveDateText . "', " .
					"			object_publish_date		= '" . $ObjectPublishDateText . "' " .
					"	WHERE	object_id = '" . intval($Object['object_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query	=	"	UPDATE	object_link " .
					"	SET		object_link_is_enable	= '" . ynval($_REQUEST['object_is_enable']) . "' " . 
					"	WHERE	object_link_id = '" . intval($Object['object_link_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
//			if (intval($Object['object_link_id']) != 0) {
//				$query	=	"	UPDATE	object_link " .
//							"	SET		object_link_is_enable	= '" . ynval($_REQUEST['object_is_enable']) . "' " . 
//							"	WHERE	object_link_id = '" . $Object['object_link_id'] . "'";
//				$result = ave_mysql_query($query) or err_die(1, $query, mysql_error(), realpath(__FILE__), __LINE__);				
//			}
	}

	public static function GetAllVoteByUser($ObjID, $UserID) {
		//	An array of the following form will be return
		//	{ 'vote_rate_1' => 5, 'vote_rate_2' => 3, 'vote_rate_3' => 0, 'vote_rate_4' => 0, 'vote_rate_5' => 0, 'vote_rate_6' => 0, 'vote_rate_7' => 0, 'vote_rate_8' => 0, 'vote_rate_9' => 0 }

		$query	=	"	SELECT	* " .
					"	FROM	vote_table " .
					"	WHERE	object_id	=	'" . intval($ObjID) . "'" .
					"		AND	user_id		=	'" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$VoteRates = array();

		while ($myResult = $result->fetch_assoc()) {
			$VoteRates['vote_rate_' . $myResult['vote_no']] = $myResult['vote_rate'];
		}
		return $VoteRates;
	}

	public static function GetVoteXMLByUserID($ObjID, $UserID) {
		$smarty = new mySmarty();
		$VoteRates = object::GetAllVoteByUser($_REQUEST['object_id'], $_REQUEST['user_id']);
		$VoteRates['object_id'] = $ObjID;
		$VoteRates['user_id'] = $UserID;
		$smarty->assign('Object', $VoteRates);
		$VoteXML = $smarty->fetch('api/object_info/VOTE.tpl');
		return $VoteXML;
	}

	public static function GetVoteRate($ObjID, $UserID, $VoteNo) {
		$query	=	"	SELECT	* " .
					"	FROM	vote_table " .
					"	WHERE	object_id	=	'" . intval($ObjID) . "'" .
					"		AND	user_id		=	'" . intval($UserID) . "'" .
					"		AND	vote_no		=	'" . intval($VoteNo) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetVoteTable($ObjID) {
		$query	=	"	SELECT		* " .
					"	FROM		vote_table V	JOIN	user U	ON	(V.user_id = U.user_id) " .
					"	WHERE		V.object_id	=	'" . intval($ObjID) . "'" .
					"	ORDER BY	U.user_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$VoteTable = array();
		$VoteRates = array();
		$LastUserID = 0;

		while ($myResult = $result->fetch_assoc()) {
			if ($myResult['user_id'] != $LastUserID) {

				if ($LastUserID != 0)
					array_push($VoteTable, $VoteRates);

				$VoteRates = $myResult;
				$LastUserID = $myResult['user_id'];
			}
			$VoteRates['vote_rate_' . $myResult['vote_no']] = $myResult['vote_rate'];
		}
		if ($LastUserID != 0)
			array_push($VoteTable, $VoteRates);
		return $VoteTable;
	}

	public static function GetVoteTableXML($ObjID) {
		$smarty = new mySmarty();

		$VoteTableXML = '';
		$VoteTable = object::GetVoteTable($ObjID);
		foreach ($VoteTable as $V) {
			$smarty->assign('Object', $V);
			$VoteXML = $smarty->fetch('api/object_info/VOTE.tpl');
			$VoteTableXML = $VoteTableXML . $VoteXML;
		}
		$VoteTableXML = '<vote_list>' . $VoteTableXML . '</vote_list>';
		return $VoteTableXML;
	}

	public static function DeleteObject($ObjID) {
		$Object = object::GetObjectInfo($ObjID);
		$TheSite = site::GetSiteInfo($Object['site_id']);

		if ($Object['object_thumbnail_file_id'] != 0)
			filebase::DeleteFile($Object['object_thumbnail_file_id'], $TheSite);

		$query =	"	DELETE FROM	object " .
					"	WHERE	object_id = '" . intval($ObjID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	vote_table " .
					"	WHERE	object_id = '" . intval($ObjID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	object_structure_seo_url " .
					"	WHERE	object_id = '" . intval($ObjID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function DeleteObjectLink($ObjLinkID) {
		$query =	"	DELETE FROM	object_link " .
					"	WHERE	object_link_id = '" . intval($ObjLinkID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	object_structure_seo_url " .
					"	WHERE	object_link_id = '" . intval($ObjLinkID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetObjectsByObjectName($SiteID, $ObjName) {
		$query	=	"	SELECT	*, O.* " .
					"	FROM	object O LEFT JOIN object_link OL ON (O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"	WHERE	OL.object_name	=	'" . aveEscT($ObjName) . "'" .
					"		AND	O.site_id		=	'" . intval($SiteID) . "'" .
					"	GROUP BY O.object_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Objects = array();

		while ($myResult = $result->fetch_assoc())
			array_push($Objects, $myResult);
		return $Objects;
	}

	public static function GetSeoURL($Object, $Para, $LangID = 0, $TheSite = null) {
		global $Site;

		if ($TheSite == null)
			$TheSite = $Site;

		if ($TheSite['site_friendly_link_version'] == 'old')
			return object::GetOldSeoURL ($Object, $Para, $LangID);
		else if ($TheSite['site_friendly_link_version'] == 'structured')
			return "/" . object::GetStructuredSeoURL ($LangID, $TheSite['site_id'], $Object['object_id'], intval($Object['object_link_id']));
	}

	public static function GetOldSeoURL($Object, $Para, $LangID = 0) {
		global $Site;

		$FriendlyURL = 'seo';

		if ($Object['object_type'] == 'PRODUCT') {
			if (!array_key_exists('product_data_id', $Object)) {
				$ProductData = product::GetProductInfo($Object['object_id'], $LangID);
				$Object['object_friendly_url'] = $ProductData['object_friendly_url'];					
			}
		}
		else if ($Object['object_type'] == 'PRODUCT_CATEGORY') {

			if (!array_key_exists('product_category_data_id', $Object)) {
				$ProductCatData = product::GetProductCatInfo($Object['object_id'], $LangID);
				$Object['object_friendly_url'] = $ProductCatData['object_friendly_url'];				
			}
		}
		else if ($Object['object_type'] == 'ALBUM') {

			if (!array_key_exists('album_data_id', $Object)) {
				$AlbumData = album::GetAlbumInfo($Object['object_id'], $LangID);
				$Object['object_friendly_url'] = $AlbumData['object_friendly_url'];				
			}
		}
		else if ($Object['object_type'] == 'MEDIA') {

			if (!array_key_exists('media_data_id', $Object)) {
				$MediaData = media::GetMediaInfo($Object['object_id'], $LangID);
				$Object['object_friendly_url'] = $MediaData['object_friendly_url'];				
			}
		}

		if (strlen(ConvertToHyphen($Object['object_friendly_url'])) > 0)
			$FriendlyURL = ConvertToHyphen($Object['object_friendly_url']);

		if (intval($Object['object_link_id']) > 0)
			return "/" . $Site['site_http_friendly_link_path'] . "/l_" . intval($Object['object_link_id']) . "_" . intval($LangID) . "_" . $Para . "/" . $FriendlyURL . ".html";
		else
			return "/" . $Site['site_http_friendly_link_path'] . "/o_" . intval($Object['object_id']) . "_" . intval($LangID) . "_" . $Para . "/" . $FriendlyURL . ".html";
	}

	public static function GetSeoEncodedURL($Object, $Para, $LangID = 0, $Site = null) {
		return str_replace("%2F", '/', urlencode(object::GetSeoURL($Object, $Para, $LangID, $Site)));
	}

	public static function GetLangSwitchObjectListXML($Object, $Site = null) {
		if (trim($Object['object_lang_switch_id']) == '')
			return '<lang_switch_object_list></lang_switch_object_list>';

		if ($Site === null)
			$Site = site::GetSiteInfo ($Object['site_id']);

		$query = '';
		if ($Object['object_type'] == 'LAYOUT_NEWS') {
			$query	=	"	SELECT	* " .
						"	FROM	object O	JOIN	layout_news N ON (N.layout_news_id = O.object_id) " .
						"						JOIN	layout_news_root NR ON (NR.layout_news_root_id = N.layout_news_root_id) " .
						"	WHERE	O.object_lang_switch_id =	'" . aveEscT($Object['object_lang_switch_id']) . "'" .
						"		AND	O.site_id = '" . intval($Object['site_id']) . "'" .
						"	ORDER BY NR.language_id ";
		}
		else if ($Object['object_type'] == 'NEWS') {
			$query	=	"	SELECT	* " .
						"	FROM	object O	JOIN	news N ON (N.news_id = O.object_id) " .
						"						JOIN	news_root NR ON (NR.news_root_id = N.news_root_id) " .
						"	WHERE	O.object_lang_switch_id =	'" . aveEscT($Object['object_lang_switch_id']) . "'" .
						"		AND	O.site_id = '" . intval($Object['site_id']) . "'" .
						"	ORDER BY NR.language_id ";
		}
		else {
			$query	=	"	SELECT	* " .
						"	FROM	object O LEFT JOIN object_link OL ON (O.object_id = OL.object_id) " .
						"	WHERE	O.object_lang_switch_id =	'" . aveEscT($Object['object_lang_switch_id']) . "'" .
						"		AND	O.site_id = '" . intval($Object['site_id']) . "'" .
						"	ORDER BY OL.language_id ";
		}
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ObjectListXML = '';

		while ($myResult = $result->fetch_assoc()) {
			$ObjectXML = '<object><object_id>' . intval($myResult['object_id']) . '</object_id><object_link_id>' . intval($myResult['object_link_id']) . '</object_link_id><language_id>' . intval($myResult['language_id']) . '</language_id><object_seo_url>' . object::GetSeoEncodedURL($myResult, '', $myResult['language_id'], $Site) . '</object_seo_url></object>';
			$ObjectListXML = $ObjectListXML . $ObjectXML;
		}
		$ObjectListXML = '<lang_switch_object_list>' . $ObjectListXML . '</lang_switch_object_list>';

		return $ObjectListXML;
	}

	public static function GetParentObjForPermissionChecking($Object) {
		// Jeff (20130207) Luckily I did not delete it, function name renamed from GetParentObjForPermissionUpdate to GetParentObjForPermissionChecking

		// Jeff (20130205) Diu, this function became rubbish before becoming legendary!!! 
		//	This is a terrible logical dead loop... This function originally written for giving the default permission to the newly created object
		//	But under the current factory process, get object_id and then create object_link, you can never know parent id automagically when creating the object_id
		//	You must pass the parent object to do so...

		// Jeff (20121228) Haha, this function will become legendary!!!! Trust me!!!! 

//	No object link so far (So delete site should clean up all?????? Well, never actually delete site
// 'SITE_ROOT','LAYOUT','BLOCK_HOLDER', 'PRODUCT_SPECIAL_CATEGORY', 'NEWS_ROOT', 'NEWS_CATEGORY','BONUS_POINT_ITEM','LAYOUT_NEWS_ROOT','LAYOUT_NEWS_CATEGORY', 'USER_DATAFILE_HOLDER'
// 
// Object link:
// 'LIBRARY_ROOT','LANGUAGE_ROOT','BLOCK_DEF','BLOCK_CONTENT','SITE_BLOCK_HOLDER_ROOT','PRODUCT_ROOT','PRODUCT_ROOT_SPECIAL', 'ALBUM_ROOT', 'PRODUCT_OPTION', 'PRODUCT_BRAND','PRODUCT_BRAND_ROOT','DISCOUNT_PREPROCESS_RULE','DISCOUNT_POSTPROCESS_RULE',
// 
// Major Object:
// 'PAGE', 'FOLDER', 'LINK', 'PRODUCT_ROOT_LINK', 'MEDIA', 'NEWS_PAGE', 'LAYOUT_NEWS_PAGE', 'DATAFILE', PRODUCT_CATEGORY',
// 
// Special:
// 'PRODUCT' -> PRODUCT_CATEGORY / PRODUCT_ROOT
// 'ALBUM' -> ALBUM_ROOT
// 'NEWS' -> NEWS_ROOT
// 'LAYOUT_NEWS' -> LAYOUT_NEWS_ROOT
		$query = '';

		if ($Object['object_type'] == 'PRODUCT') {
			$query	=	"	SELECT		* " .
						"	FROM		object PO JOIN	object_link OL ON (PO.object_id = OL.parent_object_id AND OL.object_link_is_shadow = 'N') " .
						"	WHERE		OL.object_id	=	'" . intval($Object['object_id']) . "'" .
						"			AND	(PO.object_type	= 'PRODUCT_CATEGORY' OR PO.object_type = 'PRODUCT_ROOT') ";
		}
		else if ($Object['object_type'] == 'BLOCK_CONTENT') {
			$BlockHolder = block::GetBlockHolderByBlockContentID($Object['object_id']);

			if ($BlockHolder['page_id'] != 0) {
				// This can be PAGE / LAYOUT_NEWS
				$Object = object::GetObjectInfo($BlockHolder['page_id']);
				return $Object;
			}
			else
				return $BlockHolder;
		}
		else if ($Object['object_type'] == 'ALBUM') {
			$query	=	"	SELECT		* " .
						"	FROM		object PO JOIN	object_link OL ON (PO.object_id = OL.parent_object_id AND OL.object_link_is_shadow = 'N') " .
						"	WHERE		OL.object_id	=	'" . intval($Object['object_id']) . "'" .
						"			AND	PO.object_type	= 'ALBUM_ROOT' ";
		}
		else if ($Object['object_type'] == 'NEWS') {
			$query	=	"	SELECT		RO.* " .
						"	FROM		news N	JOIN	object RO	ON (N.news_root_id = RO.object_id) " .
						"	WHERE		N.news_id		=	'" . intval($Object['object_id']) . "'";
		}
		else if ($Object['object_type'] == 'LAYOUT_NEWS') {
			$query	=	"	SELECT		RO.* " .
						"	FROM		layout_news N	JOIN	object RO	ON (N.layout_news_root_id = RO.object_id) " .
						"	WHERE		N.layout_news_id	=	'" . intval($Object['object_id']) . "'";
		}
		else {
			$query	=	"	SELECT		* " .
						"	FROM		object PO JOIN	object_link OL ON (PO.object_id = OL.parent_object_id AND OL.object_link_is_shadow = 'N') " .
						"	WHERE		OL.object_id	=	'" . intval($Object['object_id']) . "'";
		}
		
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetAllChildrenObjForPermissionUpdate($Object, $MaxDepth = 999999) {
		global $PermissionPropagateTargetObjectList, $PermissionPropagateValidObjectList;
		return site::GetAllSubChildObjects($PermissionPropagateTargetObjectList, $PermissionPropagateValidObjectList, $Object, 0, 999999, $MaxDepth, false, false, 'ALL', 'ALL');
	}

	public static function GetNewObjectIDFromOriginalCloneFromID($ObjectIDCloneFrom, $DstSiteID, $DieOnNotFound = true) {
		if ($ObjectIDCloneFrom == 0)
			return 0;

		if (intval($DstSiteID) == 0)
			die("GetNewObjectIDFromOriginalCloneFromID: Invalid DstSiteID (CloneFrom: " . $ObjectIDCloneFrom . ")");

		$query	=	"	SELECT	* " .
					"	FROM	object " .
					"	WHERE	object_id_clone_from = '" . intval($ObjectIDCloneFrom) . "'" .
					"		AND	site_id = '" . intval($DstSiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			return $myResult['object_id'];
		}
		else {
			if ($DieOnNotFound)
				die("GetNewObjectIDFromOriginalCloneFromID: NOT FOUND (CloneFrom: " . $ObjectIDCloneFrom . ")");
			else
				return false;
		}
	}

	public static function GetSeoNameForOneLevel($Object, $LangID = 0) {
		
		// if PRODUCT_ROOT_LINK, replace it with PRODUCT_ROOT
		if ($Object['object_type'] == 'PRODUCT_ROOT_LINK') {
			$ProductRootLink = product::GetProductRootLink($Object['object_link_id']);
			
			return object::GetStructuredSeoURL($LangID, $Object['site_id'], $ProductRootLink['product_root_id']);
		}
		
		// those will be added .html to it
		$FinalObjArray = array(
			'PAGE', 'PRODUCT', 'MEDIA', 'NEWS', 'NEWS_PAGE', 'LAYOUT_NEWS', 'LAYOUT_NEWS_PAGE'
		);

		$RetVal = '';
		$TrimChrs = " \t\n\r\0\x0B/　"; // add full space and slash

		$ProductData = null;
		$ProductCatData = null;
		$AlbumData = null;
		$MediaData = null;

		if ($Object['object_type'] == 'PRODUCT') {
			if (!array_key_exists('product_data_id', $Object)) {
				$ProductData = product::GetProductInfo($Object['object_id'], $LangID);
				$Object['object_friendly_url'] = $ProductData['object_friendly_url'];					
			}
		}
		else if ($Object['object_type'] == 'PRODUCT_CATEGORY') {				
			if (!array_key_exists('product_category_data_id', $Object)) {
				$ProductCatData = product::GetProductCatInfo($Object['object_id'], $LangID);
				$Object['object_friendly_url'] = $ProductCatData['object_friendly_url'];				
			}
		}
		else if ($Object['object_type'] == 'PRODUCT_ROOT') {
			if (!array_key_exists('product_root_data_id', $Object)) {
				$ProductRootData = product::GetProductRootInfo($Object['object_id'], $LangID);
				$Object['object_friendly_url'] = $ProductRootData['object_friendly_url'];
			}
		}
		else if ($Object['object_type'] == 'ALBUM') {				
			if (!array_key_exists('album_data_id', $Object)) {
				$AlbumRootData = album::GetAlbumRootInfo($Object['object_id'], $LangID);
				$Object['object_friendly_url'] = $AlbumRootData['object_friendly_url'];
			}
		}
		else if ($Object['object_type'] == 'ALBUM_ROOT') {
			if (!array_key_exists('album_root_data_id', $Object)) {
				$ProductRootData = product::GetProductRootInfo($Object['object_id'], $LangID);
				$Object['object_friendly_url'] = $ProductRootData['object_friendly_url'];
			}
		}
		else if ($Object['object_type'] == 'MEDIA') {
			if (!array_key_exists('media_data_id', $Object)) {
				$MediaData = media::GetMediaInfo($Object['object_id'], $LangID);
				$Object['object_friendly_url'] = $MediaData['object_friendly_url'];
			}
		}

		$Object['object_friendly_url'] = trim($Object['object_friendly_url'], $TrimChrs);

		if ($Object['object_friendly_url'] == '{skip}' && !in_array($Object['object_type'], $FinalObjArray))
			return null;
		else if (strlen($Object['object_friendly_url']) == 0) {
			if ($Object['object_type'] == 'SITE_ROOT') {
				$Site = site::GetSiteInfo($Object['site_id']);
				if (strlen(trim($Site['site_http_friendly_link_path'], $TrimChrs)) > 0) {
					return $Site['site_http_friendly_link_path'] . "/";
				}
				else
					return null;
			}
			elseif ($Object['object_type'] == 'LANGUAGE_ROOT') {
				if (!array_key_exists('language_shortname', $Object)) {
					$LanguageRoot = language::GetSiteLanguageRootByLanguageRootID($Object['language_root_id'], $Site['site_id']);
					return $LanguageRoot['language_shortname'] . "/";
				}
				else {
					return $Object['language_shortname'] . "/";
				}
			}
			elseif ($Object['object_type'] == 'FOLDER') {
				$Object['object_friendly_url'] = trim($Object['object_name'], $TrimChrs);
			}
			elseif ($Object['object_type'] == 'PAGE') {
				if (!array_key_exists('page_title', $Object)) {
					$Object = page::GetPageInfo($Object['object_id']);
				}

				if (strlen(trim($Object['page_title'], $TrimChrs)) > 0)
					$Object['object_friendly_url'] = trim($Object['page_title'], $TrimChrs);
				else
					$Object['object_friendly_url'] = trim($Object['object_name'], $TrimChrs);
			}
			elseif ($Object['object_type'] == 'PRODUCT_CATEGORY') {				
				if (strlen(trim($ProductCatData['product_category_name'], $TrimChrs)) > 0)
					$Object['object_friendly_url'] = trim($ProductCatData['product_category_name'], $TrimChrs);
				else
					$Object['object_friendly_url'] = trim($Object['object_name'], $TrimChrs);
			}
			elseif ($Object['object_type'] == 'PRODUCT') {
				if (strlen(trim($ProductData['product_name'], $TrimChrs)) > 0)
					$Object['object_friendly_url'] = trim($ProductData['product_name'], $TrimChrs);
				else
					$Object['object_friendly_url'] = trim($Object['object_name'], $TrimChrs);
			}
			elseif ($Object['object_type'] == 'ALBUM') {
				if (strlen(trim($AlbumData['album_desc'], $TrimChrs)) > 0)
					$Object['object_friendly_url'] = trim($AlbumData['album_desc'], $TrimChrs);
				else
					$Object['object_friendly_url'] = trim($Object['object_name'], $TrimChrs);
			}
			elseif ($Object['object_type'] == 'MEDIA') {
				if (strlen(trim($MediaData['media_desc'], $TrimChrs)) > 0)
					$Object['object_friendly_url'] = trim($MediaData['media_desc'], $TrimChrs);
				else
					$Object['object_friendly_url'] = trim($Object['object_name'], $TrimChrs);
			}
			elseif ($Object['object_type'] == 'NEWS_CATEGORY') {
				if (!array_key_exists('news_category_name', $Object)) {
					$Object = news::GetNewsCategoryInfo($Object['object_id']);
				}				
				$Object['object_friendly_url'] = trim($Object['news_category_name'], $TrimChrs);
			}
			elseif ($Object['object_type'] == 'LAYOUT_NEWS_CATEGORY') {
				if (!array_key_exists('layout_news_category_name', $Object)) {
					$Object = layout_news::GetLayoutNewsCategoryInfo($Object['object_id']);
				}				
				$Object['object_friendly_url'] = trim($Object['layout_news_category_name'], $TrimChrs);
			}
			elseif ($Object['object_type'] == 'NEWS') {
				if (!array_key_exists('news_title', $Object)) {
					$Object = news::GetNewsInfo($Object['object_id']);
				}
				$Object['object_friendly_url'] = trim($Object['news_title'], $TrimChrs);
			}
			elseif ($Object['object_type'] == 'LAYOUT_NEWS') {
				if (!array_key_exists('layout_news_title', $Object)) {
					$Object = layout_news::GetLayoutNewsInfo($Object['object_id']);
				}
				$Object['object_friendly_url'] = trim($Object['layout_news_title'], $TrimChrs);
			}
			/* 
			 * @todo
			 * The following should be rewritten to support multi lang
			 * 
			 * {product_category_special}
			 * {product_root_special}: 
				{news_root}: 
				{layout_news_root}: 
			 */
			elseif ($Object['object_type'] == 'PRODUCT_ROOT_SPECIAL') {
				return "products/";
			}
			elseif ($Object['object_type'] == 'PRODUCT_ROOT') {
				$Object['object_friendly_url'] = trim($Object['object_name'], $TrimChrs);				
			}
			elseif ($Object['object_type'] == 'ALBUM_ROOT') {
				return "albums/";
			}
			elseif ($Object['object_type'] == 'NEWS_ROOT') {
				if (!array_key_exists('news_root_name', $Object)) {
					$Object = news::GetNewsRootInfo($Object['object_id']);
				}
				$Object['object_friendly_url'] = trim($Object['news_root_name'], $TrimChrs);
			}
			elseif ($Object['object_type'] == 'LAYOUT_NEWS_ROOT') {
				if (!array_key_exists('layout_news_root_name', $Object)) {
					$Object = layout_news::GetLayoutNewsRootInfo($Object['object_id']);
				}
				$Object['object_friendly_url'] = trim($Object['layout_news_root_name'], $TrimChrs);
			}
		}

		$Suffix = "";
		if (in_array($Object['object_type'], $FinalObjArray))
			$Suffix = ".html";
		else
			$Suffix = "/";

		if (strlen(ConvertToHyphen($Object['object_friendly_url'])) > 0)
			return ConvertToHyphen($Object['object_friendly_url']) . $Suffix;
		else
			return strtolower($Object['object_type']) . '-' . $Object['object_id'] . $Suffix;
	}

	public static function UpdateStructuredSeoURL($Object, $LangID, $Site, $Prefix = '', $ParentNewsRootID = 0) {
		// 2016-11-16
		// Jeff: PRODUCT_ROOT_LINK will always return the same URL as its PRODUCT_ROOT now, so this is the only exception case to allow same URL to two objects
		
		// 2015-10-29
		// Jeff: I like recursive! Still feel excited when I need to write big recursive function... This proves I am still young!
		$SeoName = object::GetSeoNameForOneLevel($Object, $LangID);
		if ($Object['object_type'] == 'PRODUCT_ROOT_LINK')
			$SeoUrl = $SeoName;
		else
			$SeoUrl = $Prefix . $SeoName;

		if ($SeoName !== null) {
			if ($Object['object_type'] != 'PRODUCT_ROOT_LINK' && object::DoesStructuredSeoUrlAlreadyExist($SeoUrl, $Site['site_id'], $Object['object_id'], $Object['object_link_id'], $LangID))
				$SeoUrl = $Prefix . $Object['object_id'] . "-" . $SeoName;

			$query =	"	INSERT INTO object_structure_seo_url " .
						"	SET	site_id			= '" . intval($Site['site_id']) . "', " .
						"		object_id		= '" . intval($Object['object_id']) . "', " .
						"		object_link_id	= '" . intval($Object['object_link_id']) . "', " .
						"		language_id		= '" . intval($LangID) . "', " .
						"		object_structure_seo_url = '" . aveEscT($SeoUrl) . "'" .
						"	ON DUPLICATE KEY UPDATE " .
						"		object_structure_seo_url = '" . aveEscT($SeoUrl) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		global $LanguageTreeObjectTypeList;

		if ($Object['object_type'] == 'SITE_ROOT') {
			$SiteLanguageRoots = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');
			foreach ($SiteLanguageRoots as $R) {
				object::UpdateStructuredSeoURL($R, $R['language_id'], $Site, $SeoUrl);
			}
		}
		elseif ($Object['object_type'] == 'LANGUAGE_ROOT') {
			// Product Root List Here
			$ProductRootList = product::GetProductRootList($Site);
			foreach ($ProductRootList as $R) {
				object::UpdateStructuredSeoURL($R, $LangID, $Site, $SeoUrl);
			}

			// Product Special Root
			$ProductRootSpecialValidObjectList = array('PRODUCT_ROOT_SPECIAL');
			$ProductRootSpecialChildrenObjects = site::GetAllChildObjects($ProductRootSpecialValidObjectList, $Object['object_id'], 999999, 'ALL', 'N', false, false, true);
			foreach ($ProductRootSpecialChildrenObjects as $O) {
				object::UpdateStructuredSeoURL($O, $LangID, $Site, $SeoUrl);
			}

			// Album Root Here
			$AlbumRoot = object::GetObjectInfo($Site['album_root_id']);
			object::UpdateStructuredSeoURL($AlbumRoot, $LangID, $Site, $SeoUrl);

			// News Root List Here
			$NewsRoots = news::GetNewsRootList($LangID, $Site['site_id']);
			foreach ($NewsRoots as $R) {
				object::UpdateStructuredSeoURL($R, $LangID, $Site, $SeoUrl);
			}

			// Layout News Root List Here				
			$LayoutNewsRoots = layout_news::GetLayoutNewsRootList($LangID, $Site['site_id']);
			foreach ($LayoutNewsRoots as $R) {
				object::UpdateStructuredSeoURL($R, $LangID, $Site, $SeoUrl);		
			}
			
			// Language Tree
			$LangTreeChildrenObjects = site::GetAllChildObjects($LanguageTreeObjectTypeList, $Object['object_id'], 999999, 'ALL', 'N', false, false, true);
			foreach ($LangTreeChildrenObjects as $O) {
				object::UpdateStructuredSeoURL($O, $LangID, $Site, $SeoUrl);
			}
		}
		elseif ($Object['object_type'] == 'FOLDER') {
			$ChildrenObjects = site::GetAllChildObjects($LanguageTreeObjectTypeList, $Object['object_id'], 999999, 'ALL', 'N', false, false, true);
			foreach ($ChildrenObjects as $O) {
				object::UpdateStructuredSeoURL($O, $LangID, $Site, $SeoUrl);
			}

			// Album
			$AlbumList = folder::GetAlbumList($Object['object_id'], $LangID, 999999, $TotalNoOfAlbum, 1, 999999, false, false, "ASC");
			foreach ($AlbumList as $A) {
				object::UpdateStructuredSeoURL($A, $LangID, $Site, $SeoUrl);
			}
		}
		elseif ($Object['object_type'] == 'ALBUM_ROOT') {
			$Albums = album::GetAlbumList($Object['object_id']);
			foreach ($Albums as $A) {
				object::UpdateStructuredSeoURL($A, $LangID, $Site, $SeoUrl);
			}
		}
		elseif ($Object['object_type'] == 'ALBUM') {
			$MediaList = media::GetMediaList($Object['object_id'], $LangID, $TotalMedia, 1, 999999, 999999, false, false);
			foreach ($MediaList as $M) {
				object::UpdateStructuredSeoURL($M, $LangID, $Site, $SeoUrl);
			}
		}
		elseif ($Object['object_type'] == 'PRODUCT_ROOT') {
			$ValidObjectList = array('PRODUCT', 'PRODUCT_CATEGORY');
			$ChildrenObjects = site::GetAllChildObjects($ValidObjectList, $Object['object_id'], 999999, 'ALL', 'N', false, false, true);
			foreach ($ChildrenObjects as $O) {
				object::UpdateStructuredSeoURL($O, $LangID, $Site, $SeoUrl);
			}
		}
		elseif ($Object['object_type'] == 'PRODUCT_ROOT_SPECIAL') {
			$ValidObjectList = array('PRODUCT_SPECIAL_CATEGORY');
			$ChildrenObjects = site::GetAllChildObjects($ValidObjectList, $Object['object_id'], 999999, 'ALL', 'N', false, false, true);
			foreach ($ChildrenObjects as $O) {
				object::UpdateStructuredSeoURL($O, $LangID, $Site, $SeoUrl);
			}
		}
		elseif ($Object['object_type'] == 'PRODUCT_CATEGORY') {
			$ValidObjectList = array('PRODUCT', 'PRODUCT_CATEGORY');
			$ChildrenObjects = site::GetAllChildObjects($ValidObjectList, $Object['object_id'], 999999, 'ALL', 'N', false, false, true);
			foreach ($ChildrenObjects as $O) {
				object::UpdateStructuredSeoURL($O, $LangID, $Site, $SeoUrl);
			}
		}
		elseif ($Object['object_type'] == 'PRODUCT_SPECIAL_CATEGORY') {
			$ValidObjectList = array('PRODUCT');
			$ChildrenObjects = site::GetAllChildObjects($ValidObjectList, $Object['object_id'], 999999, 'ALL', 'N', false, false, true);
			foreach ($ChildrenObjects as $O) {
				object::UpdateStructuredSeoURL($O, $LangID, $Site, $SeoUrl);
			}
		}
		elseif ($Object['object_type'] == 'NEWS_ROOT') {
			$NewsCatList = news::GetNewsCategoryList($LangID, $Site['site_id']);
			foreach ($NewsCatList as $C) {
				object::UpdateStructuredSeoURL($C, $LangID, $Site, $SeoUrl, $Object['object_id']);
			}
		}
		elseif ($Object['object_type'] == 'NEWS_CATEGORY') {
			$NewsList = news::GetNewsListByNewsRootID($ParentNewsRootID, $TotalNewsNum, 1, 999999, '', '', '', $Object['object_id'], '', false, false, null);
			foreach ($NewsList as $N) {
				object::UpdateStructuredSeoURL($N, $LangID, $Site, $SeoUrl);
			}
		}
		elseif ($Object['object_type'] == 'LAYOUT_NEWS_ROOT') {
			$LayoutNewsCatList = layout_news::GetLayoutNewsCategoryList($LangID, $Site['site_id']);
			foreach ($LayoutNewsCatList as $C) {
				object::UpdateStructuredSeoURL($C, $LangID, $Site, $SeoUrl, $Object['object_id']);
			}
		}
		elseif ($Object['object_type'] == 'LAYOUT_NEWS_CATEGORY') {
			$LayoutNewsList = layout_news::GetLayoutNewsListByLayoutNewsRootID($ParentNewsRootID, $TotalNewsNum, 1, 999999, '', '', '', $Object['object_id'], '');
			foreach ($LayoutNewsList as $N) {
				object::UpdateStructuredSeoURL($N, $LangID, $Site, $SeoUrl);
			}
		}
	}

	public static function DoesStructuredSeoUrlAlreadyExist($UnescapedSeoURL, $SiteID, $ObjectID, $ObjectLinkID, $LangID) {
		$query =	"	SELECT	* " .
					"	FROM 	object_structure_seo_url " .
					"	WHERE	site_id = '" . intval($SiteID) . "'" .
					"		AND	object_structure_seo_url = '" . aveEscT($UnescapedSeoURL) . "'" .
					"		AND	NOT(	object_id = '" . intval($ObjectID) . "'" .
					"				AND	object_link_id = '" . intval($ObjectLinkID) . "'" .
					"				AND	language_id = '" . intval($LangID) . "'" .
					"				) ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		return $result->num_rows > 0;
	}

	/** 
	 * $ObjectLinkID - if null is passed, this field will be ignored and pass whatever object_id can find. Used to find parent object.
	 * @param int $LangID
	 * @param int $SiteID
	 * @param int $ObjectID
	 * @param int $ObjectLinkID
	 * @return string
	 */
	public static function GetStructuredSeoURL($LangID, $SiteID, $ObjectID, $ObjectLinkID = null ) {

		$sql = '';
		if ($ObjectLinkID !== null)
			$sql =	"	AND	object_link_id = '" . intval($ObjectLinkID) . "'";

		$query =	"	SELECT	* " .
					"	FROM 	object_structure_seo_url " .
					"	WHERE	site_id = '" . intval($SiteID) . "'" .
					"		AND	object_id = '" . intval($ObjectID) . "'" . $sql .
					"		AND	language_id = '" . intval($LangID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result->fetch_assoc();

		return $myResult['object_structure_seo_url'];
	}

	public static function GetStructuredSeoURLInfo($StructuredSeoURL, $SiteID) {
		$query =	"	SELECT	U.* " .
					"	FROM 	object_structure_seo_url U JOIN object O ON (U.object_id = O.object_id)" .
					"	WHERE	U.site_id = '" . intval($SiteID) . "'" .
					"		AND	U.object_structure_seo_url = '" . aveEscT($StructuredSeoURL) . "'" .
					"		AND O.object_type != 'PRODUCT_ROOT_LINK' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetStructuredSeoURLInfoXML($StructuredSeoURL, $SiteID) {
		$smarty = new mySmarty();

		$SeoUrlInfo = object::GetStructuredSeoURLInfo($StructuredSeoURL, $SiteID);

		$smarty->assign('Object', $SeoUrlInfo);
		$SeoXML = $smarty->fetch('api/seo_get_structured_seo_url_info.tpl');

		return $SeoXML;
	}
}