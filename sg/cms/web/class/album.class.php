<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class album {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetAlbumList($AlbumRootID) {
		$query =	"	SELECT	* " .
					"	FROM	object_link OL	JOIN	object AO	ON (OL.object_id = AO.object_id) " .
					"							JOIN	album A		ON (A.album_id = AO.object_id) " .
					"	WHERE	OL.parent_object_id	= '" . intval($AlbumRootID) . "'" .
					"	ORDER BY OL.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$Albums = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($Albums, $myResult);
		}
		return $Albums;
	}

	public static function NewAlbum($ObjectID) {
		$query =	"	INSERT INTO album " .
					"	SET		album_id = '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function NewAlbumData($AlbumID, $LanguageID, $AlbumDesc) {
		$query =	"	INSERT INTO album_data " .
					"	SET		album_id	= '" . intval($AlbumID) . "', " .
					"			language_id = '" . intval($LanguageID) . "', " .
					"			album_desc	= '" . aveEscT($AlbumDesc) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function TouchAlbumData($AlbumID, $LanguageID) {
		$query =	"	INSERT INTO album_data " .
					"	SET		album_id	= '" . intval($AlbumID) . "', " .
					"			language_id = '" . intval($LanguageID) . "', " .
					"			album_desc	= ''" .
					"	ON DUPLICATE KEY UPDATE album_id = '" . intval($AlbumID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetAlbumInfo($AlbumID, $LanguageID) {
		$query =	"	SELECT	*, AD.*, A.* " .
					"	FROM	object_link OL	JOIN		object AO		ON (OL.object_id = AO.object_id) " .
					"							JOIN		album A			ON (A.album_id = AO.object_id) " .
					"							LEFT JOIN	album_data AD	ON (A.album_id = AD.album_id AND AD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	AO.object_id	= '" . intval($AlbumID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetAlbumInfoByObjectLinkID($ObjLinkID, $LanguageID) {
		$query =	"	SELECT	*, A.* " .
					"	FROM	object_link OL	JOIN		object AO		ON (OL.object_id = AO.object_id) " .
					"							JOIN		album A			ON (A.album_id = AO.object_id) " .
					"							LEFT JOIN	album_data AD	ON (A.album_id = AD.album_id AND AD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	OL.object_link_id	= '" . intval($ObjLinkID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function DeleteAlbum($AlbumID, $Site) {
		// Delete all media objects	
		$TotalMedia = 0;
		$MediaList = media::GetMediaList($AlbumID, 0, $TotalMedia, 1, 999999, 999999, false, false);
		if ($TotalMedia > 0) {
			foreach ($MediaList as $M)
				media::DeleteMedia($M['media_id'], $Site, true);
		}
		$Album = Album::GetAlbumInfo($AlbumID, 0);

		// DELETE OBJECT AND ALBUM RECORD
		object::DeleteObject($AlbumID);

		$query =	"	DELETE FROM	album " .
					"	WHERE	album_id = '" . intval($AlbumID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	album_data " .
					"	WHERE	album_id = '" . intval($AlbumID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Delete all object links
		$query =	"	DELETE FROM	object_link " .
					"	WHERE		parent_object_id = '" . intval($AlbumID) . "'" .
					"			OR	object_id = '" . intval($AlbumID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($Album['object_thumbnail_file_id'] != 0)
			filebase::DeleteFile($Album['object_thumbnail_file_id'], $Site);

		object::TidyUpObjectOrder($Album['parent_object_id']);
	}

	public static function EmptyAlbum($AlbumID, $Site) {
		// Delete all media objects
		$TotalMedia = 0;
		$MediaList = media::GetMediaList($AlbumID, 0, $TotalMedia, 1, 999999, 999999, false, false);
		foreach ($MediaList as $M)
			media::DeleteMedia($M['media_id'], $Site, true);

		object::TidyUpObjectOrder($AlbumID);
	}

	public static function GetAlbumXML($ObjectID, $ObjLinkID, $LanguageID, $MediaPageNo = 1, $MediaPerPage = 999999, $SecurityLevel = 999999) {
		$smarty = new mySmarty();

		if ($ObjLinkID != 0)
			$Album = album::GetAlbumInfoByObjectLinkID($ObjLinkID, $LanguageID);
		else
			$Album = album::GetAlbumInfo($ObjectID, $LanguageID);

		$TotalNoOfMedia = 0;
		$MediaListXML = media::GetMediaListXML($ObjectID, $LanguageID, $TotalNoOfMedia, $MediaPageNo, $MediaPerPage, $SecurityLevel);
		$smarty->assign('MediaListXML', $MediaListXML);

		$Album['object_seo_url'] = object::GetSeoURL($Album, '', $LanguageID, null);
		$smarty->assign('Object', $Album);
		$smarty->assign('TotalNoOfMedia', $TotalNoOfMedia);
		$smarty->assign('MediaPageNo', $MediaPageNo);

		$AlbumXML = $smarty->fetch('api/object_info/ALBUM.tpl');

		return $AlbumXML;
	}

	public static function DeleteAlbumRootLink($ObjectLinkID) {
		$ObjectLink = object::GetObjectLinkInfo($ObjectLinkID);

		$query =	"	DELETE FROM	object_link " .
					"	WHERE	object_link_id = '" . intval($ObjectLinkID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::TidyUpObjectOrder($ObjectLink['parent_object_id']);
	}

	public static function UpdateTimeStamp($AlbumID) {
		// Update the Album Itself
		object::UpdateObjectTimeStamp($AlbumID);

		// Update all corresponding News and Page
		$query =	"	SELECT	* " .
					"	FROM	news " .
					"	WHERE	album_id = '" . intval($AlbumID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc())
			object::UpdateObjectTimeStamp($myResult['news_id']);

		$query =	"	SELECT	* " .
					"	FROM	page " .
					"	WHERE	album_id = '" . intval($AlbumID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc())
			object::UpdateObjectTimeStamp($myResult['page_id']);
	}

	public static function UpdateAlbumCustomFile($Album, $CustomFieldID, $Site, $File) {
		if ($File['size'] > 0) {
			$FileID = filebase::AddFile($File, $Site, $Album['album_id']);

			if ($FileID !== false) {
				album::DeleteAlbumCustomFile($Album, $CustomFieldID, $Site);
				$query =	"	UPDATE	album " .
							"	SET		album_custom_file_id_" . intval($CustomFieldID) . " = '" . intval($FileID) . "'" .
							"	WHERE	album_id =  '" . intval($Album['album_id']) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
			return $FileID;
		}
		return false;
	}

	public static function DeleteAlbumCustomFile($Album, $CustomFieldID, $Site) {
		if ($Album['album_custom_file_id_' . $CustomFieldID] > 0) {
			filebase::DeleteFile($Album['album_custom_file_id_' . $CustomFieldID], $Site);
			$query =	"	UPDATE	album " .
						"	SET		album_custom_file_id_" . intval($CustomFieldID) . " = 0 " .
						"	WHERE	album_id =  '" . intval($Album['album_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}		

	public static function ImportAlbum($Site, $AlbumXML, &$NoOfAlbumParsed, &$NoOfAlbumImported, &$NoOfAlbumFailed, &$SuccessXMLString, &$ErrorXMLString, $RealWrite = 'N', $NewOrUpdate = 'new') {
		$smarty = new mySmarty();

		$NoOfAlbumParsed++;
		$smarty->assign('msg', '');
		$smarty->assign('import_ref_id', $AlbumXML->import_ref_id);

		$TheObject = null;
		if ($NewOrUpdate == 'update') {
			$TheObject = object::GetObjectsByObjectName($Site['site_id'], $AlbumXML->object_name);
			if (count($TheObject) < 1) {
				$smarty->assign('msg', 'object_name: Not Found!');
				$NoOfAlbumFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/ALBUM.tpl');
				return true;
			}
			if (count($TheObject) > 1) {
				$smarty->assign('msg', 'More than one objects with same object name found.');
				$NoOfAlbumFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/ALBUM.tpl');
				return true;
			}
		}

		if ($Site['site_module_album_enable'] != 'Y') {
			$smarty->assign('msg', ADMIN_MSG_MODULE_DISABLED_ALBUM);
			$NoOfAlbumFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/ALBUM.tpl');
			return false;
		}

		$SiteLanguageRoots = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');
		if (count($SiteLanguageRoots) == 0) {
			$smarty->assign('msg', ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED);
			$NoOfAlbumFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/ALBUM.tpl');
			return false;
		}

		// Album Data Checking
		$AlbumDataList = $AlbumXML->album_data_list;

		$NoOfValidAlbumData = 0;
		foreach ($SiteLanguageRoots as $R) {
			$AlbumData = $AlbumDataList->xpath("album_data[language_id='" . $R['language_id'] . "']");
			if (count($AlbumData) > 0)
				$NoOfValidAlbumData++;
		}
		if (count($AlbumDataList->children()) != $NoOfValidAlbumData) {
			if (count($AlbumDataList->children()) > $NoOfValidAlbumData)
				$smarty->assign('msg', 'album_data: invalid language_id found (not enabled?) ');
			elseif (count($AlbumDataList->children()) < $NoOfValidAlbumData)
				$smarty->assign('msg', 'album_data: not enough data (some language_id is enabled but not found in XML ');
			$NoOfAlbumFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/ALBUM.tpl');
			return true;
		}

		// Object Thumbnail Check
		$ObjectThumbnailInfo = array();
		if (strlen(trim($AlbumXML->object_thumbnail_url)) > 0) {
			$ObjectThumbnailInfo = @getimagesize($AlbumXML->object_thumbnail_url);

			if ($ObjectThumbnailInfo[0] == 0) {
				$smarty->assign('msg', 'object_thumbnail_url: cannot load image');
				$NoOfAlbumFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/ALBUM.tpl');
				return true;
			}
			elseif ($ObjectThumbnailInfo[2] > 3) { // 1 = GIF, 2 = JPG, 3 = PNG
				$smarty->assign('msg', 'object_thumbnail_url: unsupported image type');
				$NoOfAlbumFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/ALBUM.tpl');
				return true;
			}
		}

		// Media Checking
		$NoOfMediaParsed = 0;
		$NoOfMediaImported = 0;
		$NoOfMediaFailed = 0;
		$gSuccessMediaListXMLString = '';
		$gErrorMediaListXMLString = '';

		foreach ($AlbumXML->media_list->children() as $Media) {
			$SuccessMediaListXMLString = '';
			$ErrorMediaListXMLString = '';
			$ImportResult = media::ImportMedia($Site, 0, $Media, $NoOfMediaParsed, $NoOfMediaImported, $NoOfMediaFailed, $SuccessMediaListXMLString, $ErrorMediaListXMLString, 'N', 'new');

			$gSuccessMediaListXMLString = $gSuccessMediaListXMLString . $SuccessMediaListXMLString;
			$gErrorMediaListXMLString	= $gErrorMediaListXMLString . $ErrorMediaListXMLString;

			if ($ImportResult == false)
				break;
		}

		$AlbumImportMsg = '';
		if (strlen($gErrorMediaListXMLString) > 0) {
			$smarty->assign('no_of_media_parsed', $NoOfMediaParsed);
			$smarty->assign('no_of_media_imported', $NoOfMediaImported);
			$smarty->assign('no_of_media_failed', $NoOfMediaFailed);
			$smarty->assign('ErrorMediaListXMLString', $gErrorMediaListXMLString);
			$smarty->assign('SuccessMediaListXMLString', $gSuccessMediaListXMLString);
			$smarty->assign('msg', 'Error in importing media');
			$NoOfAlbumFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/ALBUM.tpl');
			return true;
		}

		// SHOULD BE ALL CLEAR HERE!!!!
		if ($RealWrite != 'Y') {
			$smarty->assign('no_of_media_parsed', $NoOfMediaParsed);
			$smarty->assign('no_of_media_imported', $NoOfMediaImported);
			$smarty->assign('no_of_media_failed', $NoOfMediaFailed);
			$smarty->assign('ErrorMediaListXMLString', $gErrorMediaListXMLString);
			$smarty->assign('SuccessMediaListXMLString', $gSuccessMediaListXMLString);
			$NoOfAlbumImported++;
			$SuccessXMLString = $smarty->fetch('api/import/ALBUM.tpl');
			return true;
		}
		else {
			// DO REAL IMPORT STUFF HERE!!!!!!!!!!!!!!!!!!!
			$AlbumID = 0;
			if ($NewOrUpdate == 'update') {
				$AlbumID = $TheObject[0]['object_id'];
				album::EmptyAlbum($AlbumID, $Site);
			}
			else {
				$AlbumID = object::NewObject('ALBUM', $Site['site_id'], $_REQUEST['object_security_level'], OBJECT_DEFAULT_ARCHIVE_DATE, OBJECT_DEFAULT_PUBLISH_DATE, 'Y', 'Y', null);
				album::NewAlbum($AlbumID);
				object::NewObjectLink($Site['album_root_id'], $AlbumID, $AlbumXML->object_name, 0, 'normal', DEFAULT_ORDER_ID);
			}
			$smarty->assign('album_id', $AlbumID);

			$query =	"	UPDATE	object " .
						"	SET		object_is_enable		= '" . ynval($AlbumXML->object_is_enable) . "', " .
						"			object_security_level	= '" . intval($AlbumXML->object_security_level) . "' " .
						"	WHERE	object_id = '" . $AlbumID . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			object::UpdateObjectSEOData($AlbumID, $AlbumXML->object_meta_title, $AlbumXML->object_meta_description, $AlbumXML->object_meta_keywords, $AlbumXML->object_friendly_url);

			$query =	"	UPDATE	album " .
						"	SET		album_custom_int_1		= '" . intval($AlbumXML->album_custom_int_1) . "', " .
						"			album_custom_int_2		= '" . intval($AlbumXML->album_custom_int_2) . "', " .
						"			album_custom_int_3		= '" . intval($AlbumXML->album_custom_int_3) . "', " .
						"			album_custom_int_4		= '" . intval($AlbumXML->album_custom_int_4) . "', " .
						"			album_custom_int_5		= '" . intval($AlbumXML->album_custom_int_5) . "', " .
						"			album_custom_double_1	= '" . doubleval($AlbumXML->album_custom_double_1) . "', " .
						"			album_custom_double_2	= '" . doubleval($AlbumXML->album_custom_double_2) . "', " .
						"			album_custom_double_3	= '" . doubleval($AlbumXML->album_custom_double_3) . "', " .
						"			album_custom_double_4	= '" . doubleval($AlbumXML->album_custom_double_4) . "', " .
						"			album_custom_double_5	= '" . doubleval($AlbumXML->album_custom_double_5) . "', " .
						"			album_custom_date_1		= '" . aveEscT($AlbumXML->album_custom_date_1) . "', " .
						"			album_custom_date_2		= '" . aveEscT($AlbumXML->album_custom_date_2) . "', " .
						"			album_custom_date_3		= '" . aveEscT($AlbumXML->album_custom_date_3) . "', " .
						"			album_custom_date_4		= '" . aveEscT($AlbumXML->album_custom_date_4) . "', " .
						"			album_custom_date_5		= '" . aveEscT($AlbumXML->album_custom_date_5) . "' " .
						"	WHERE	album_id = '" . intval($AlbumID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			object::TidyUpObjectOrder($Site['album_root_id']);

			foreach ($SiteLanguageRoots as $R) {
				$AlbumData = $AlbumDataList->xpath("album_data[language_id='" . $R['language_id'] . "']");

				album::TouchAlbumData($AlbumID, $R['language_id']);
				$query	=	"	UPDATE	album_data " .
							"	SET		album_desc			= '" . aveEscT($AlbumData[0]->album_desc) . "', " .
							"			album_custom_text_1	= '" . aveEscT($AlbumData[0]->album_custom_text_1) . "', " .
							"			album_custom_text_2	= '" . aveEscT($AlbumData[0]->album_custom_text_2) . "', " .
							"			album_custom_text_3	= '" . aveEscT($AlbumData[0]->album_custom_text_3) . "', " .
							"			album_custom_text_4	= '" . aveEscT($AlbumData[0]->album_custom_text_4) . "', " .
							"			album_custom_text_5	= '" . aveEscT($AlbumData[0]->album_custom_text_5) . "' " .
							"	WHERE	album_id = '" . intval($AlbumID) . "'" .
							"		AND	language_id = '" . intval($R['language_id']) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}

			$Album = album::GetAlbumInfo($AlbumID, 0);

			if (strlen(trim($AlbumXML->object_thumbnail_url)) > 0) {
				$TheFile = array();
				$PathInfo = pathinfo(trim($AlbumXML->object_thumbnail_url));
				$ObjectThumbnailFile = file_get_contents(trim($AlbumXML->object_thumbnail_url));
				$TmpFile = tempnam("/tmp", "TmpImportImageFile");
				file_put_contents($TmpFile, $ObjectThumbnailFile);

				$TheFile = array();
				$TheFile['name'] = $PathInfo['basename'];
				$TheFile['size'] = filesize($TmpFile);
				$TheFile['tmp_name'] = $TmpFile;
				$TheFile['type'] = $ObjectThumbnailInfo['mime'];

				object::UpdateObjectThumbnail($Album, $Site, $TheFile, $Site['site_media_small_width'], $Site['site_media_small_height']);
			}

			$NoOfMediaParsed = 0;
			$NoOfMediaImported = 0;
			$NoOfMediaFailed = 0;
			$gSuccessMediaListXMLString = '';
			$gErrorMediaListXMLString = '';

			foreach ($AlbumXML->media_list->children() as $Media) {
				$SuccessMediaListXMLString = '';
				$ErrorMediaListXMLString = '';
				$ImportResult = media::ImportMedia($Site, $Album['object_link_id'], $Media, $NoOfMediaParsed, $NoOfMediaImported, $NoOfMediaFailed, $SuccessMediaListXMLString, $ErrorMediaListXMLString, 'Y', 'new');

				$gSuccessMediaListXMLString = $gSuccessMediaListXMLString . $SuccessMediaListXMLString;
				$gErrorMediaListXMLString	= $gErrorMediaListXMLString . $ErrorMediaListXMLString;
			}

			album::UpdateTimeStamp($AlbumID);
			site::EmptyAPICache($Site['site_id']);

			$smarty->assign('no_of_media_parsed', $NoOfMediaParsed);
			$smarty->assign('no_of_media_imported', $NoOfMediaImported);
			$smarty->assign('no_of_media_failed', $NoOfMediaFailed);
			$smarty->assign('ErrorMediaListXMLString', $gErrorMediaListXMLString);
			$smarty->assign('SuccessMediaListXMLString', $gSuccessMediaListXMLString);
			$NoOfAlbumImported++;
			$SuccessXMLString = $smarty->fetch('api/import/ALBUM.tpl');
			return true;
		}
	}

	public static function CloneAlbum($Album, $SrcSite, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($Album['object_link_id']) <= 0)
			customdb::err_die (1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__, true);

		object::CloneObjectWithObjectLink($Album, $SrcSite, $DstSite['album_root_id'], 0, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName, $DstSite);

		$sql = GetCustomTextSQL("album", "int", 0, $Album) . GetCustomTextSQL("album", "double", 0, $Album) . GetCustomTextSQL("album", "date", 0, $Album);

		// Clone custom file
		for ($i = 1; $i <= 20; $i++) {
			if (intval($Album['album_custom_file_id_' . $i]) > 0 ) {
				$NewFileID = filebase::CloneFile($Album['album_custom_file_id_' . $i], $SrcSite, $NewObjectID, $DstSite);
				$sql = $sql . 'album_custom_file_id_' . $i . " = '" . $NewFileID . "', ";
			}
		}

		if (strlen($sql) > 0)
			$sql = ", " . substr($sql, 0, -1);

		$query =	"	INSERT INTO album " .
					"	SET		album_id = '" . intval($NewObjectID) . "' " . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Album Data
		$query =	"	SELECT	* " .
					"	FROM	album_data " .
					"	WHERE	album_id = '" . intval($Album['album_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			$sql = GetCustomTextSQL("album", "text", 0, $myResult);
			if (strlen($sql) > 0)
				$sql = ", " . substr($sql, 0, -1);

			$query =	"	INSERT INTO album_data " .
						"	SET		album_id	= '" . intval($NewObjectID) . "', " .
						"			album_desc	= '" . aveEscT($myResult['album_desc']) . "', " .
						"			language_id	= '" . intval($myResult['language_id']) . "', " . 
						"			object_meta_title		= '" . aveEscT($myResult['object_meta_title']) . "', " .
						"			object_meta_description = '" . aveEscT($myResult['object_meta_description']) . "', " .
						"			object_meta_keywords	= '" . aveEscT($myResult['object_meta_keywords']) . "', " .
						"			object_friendly_url		= '" . aveEscT($myResult['object_friendly_url']) . "' " . $sql;
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		// Now clone media
		$MediaList = media::GetMediaList($Album['album_id'], 0, $TotalMedia, 1, 999999, 999999, false, false);

		foreach ($MediaList as $M) {
			media::CloneMedia($M, $SrcSite, $NewObjectID, $NewMediaID, $NewMediaLinkID, 'N', 'N', $DstSite);
		}
	}

	public static function CloneAllAlbumFromSiteToSite($SrcSite, $DstSite) {
		if ($SrcSite['site_id'] == $DstSite['site_id'])
			die("CloneAllAlbum failed: cannot clone to itself");
		if ($DstSite['album_root_id'] == 0)
			die("CloneAllAlbum failed: album_root_id = 0?");

		$Albums = album::GetAlbumList($SrcSite['album_root_id']);

		foreach($Albums as $A) {
			album::CloneAlbum($A, $SrcSite, $NewAlbumID, $NewAlbumLinkID, 'N', 'N', $DstSite);
		}
	}

	public static function GetAlbumRootInfo($AlbumRootID, $LanguageID) {
		$query =	"	SELECT	O.*, D.*, OL.* " .
					"	FROM	object O	" . 
					"				JOIN		object_link OL ON (OL.object_id = O.object_id AND OL.object_link_is_shadow = 'N') " .
					"				LEFT JOIN	album_root_data D ON (D.album_root_id = O.object_id AND D.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	O.object_id =  '" . intval($AlbumRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;			
	}

	public static function TouchAlbumRootData($AlbumRootID, $LanguageID) {
		$query =	"	INSERT INTO album_root_data " .
					"	SET		album_root_id	= '" . intval($AlbumRootID) . "', " .
					"			language_id = '" . intval($LanguageID) . "' " .
					"	ON DUPLICATE KEY UPDATE album_root_id = '" . intval($AlbumRootID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

}