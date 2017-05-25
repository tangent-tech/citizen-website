<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class media {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetMediaList($ParentObjectID, $LanguageID = 0, &$TotalMedia, $PageNo = 1, $MediaPerPage = 20, $SecurityLevel = 999999, $HonorArchiveDate = false, $HonorPublishDate = false) {
		$Offset = intval(($PageNo -1) * $MediaPerPage);

		$sql = '';
		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	MO.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	MO.object_publish_date < NOW() ";

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, M.* " .
					"	FROM	object_link OL	JOIN		object MO		ON (OL.object_id = MO.object_id) " .
					"							JOIN		media M			ON (M.media_id = MO.object_id) " .
					"							LEFT JOIN	media_data MD	ON (MD.media_id = M.media_id AND MD.language_id = '" . intval($LanguageID) . "') " .
					"							LEFT JOIN	file_base B		ON (B.file_id = M.media_big_file_id) " .
					"	WHERE	OL.parent_object_id	= '" . intval($ParentObjectID) . "'" . 
					"		AND	MO.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql .
					"	ORDER BY OL.order_id ASC " .
					"	LIMIT	" . $Offset . ", " . intval($MediaPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalMedia = $myResult[0];

		$MediaList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($MediaList, $myResult);
		}
		return $MediaList;			
	}

	public static function IsValidMediaType($FileExt) {
		global $MediaTypeList;
		if (in_array($FileExt, $MediaTypeList))
			return true;
		else
			return false;
	}

	public static function NewMediaWithObject($File, $Site, $SmallWidth, $SmallHeight, $BigWidth, $BigHeight, $Resize = true, $WatermarkIDSmall = 0, $WatermarkIDBig = 0, $SecurityLevel = 0) {
		if ($File['size'] > 0) {
			if(!file_exists($File['tmp_name']))
				err_die(1, "Error: File Upload Problem.", $File['tmp_name'], realpath(__FILE__), __LINE__);

			$FileExt = strtolower(substr(strrchr($File['name'], '.'), 1));

			if (!media::IsValidMediaType($FileExt))
				return false;

			$SmallFileID = 0;
			$BigFileID = 0;

			if ($FileExt == 'gif' || $FileExt == 'jpg' || $FileExt == 'png') {
				$SmallFileID	= filebase::AddPhoto($File, $SmallWidth, $SmallHeight, $Site, $WatermarkIDSmall);

				if ($Resize)
					$BigFileID		= filebase::AddPhoto($File, $BigWidth, $BigHeight, $Site, $WatermarkIDBig);
				else
					$BigFileID		= filebase::AddFile($File, $Site);
			}
			elseif ($FileExt == 'avi' || $FileExt == 'wmv' || $FileExt == 'mov' || $FileExt == 'mpg' || $FileExt == 'mp3' || $FileExt == 'wma' || $FileExt == 'ra'  || $FileExt == 'mp4') {
				$Movie = new ffmpeg_movie($File['tmp_name'], false);
				if ($Movie->hasVideo()) {
					$MovieFrame = $Movie->getFrame(intval($Movie->getFrameCount() / 2));

//	seems the latest build does not support this function!!!! 2011/02/14 - JC
//						$MovieFrame->resize($SmallWidth, $SmallHeight);
					$TmpFile = tempnam("/tmp", "TmpImageFile");
					imagejpeg($MovieFrame->toGDImage(), $TmpFile, 80);

					$TheFile = array();
					$TheFile['name'] = 'temp.jpg';
					$TheFile['type'] = 'image/jpeg';
					$TheFile['size'] = filesize($TmpFile);
					$TheFile['tmp_name'] = $TmpFile;

//						$SmallFileID = filebase::AddFile($TheFile, $Site);
					$SmallFileID = filebase::AddPhoto($TheFile, $SmallWidth, $SmallHeight, $Site, $WatermarkIDSmall);
					$BigFileID = filebase::AddFile($File, $Site);

					unlink($TmpFile);
				}
				else
					$BigFileID = filebase::AddFile($File, $Site);
			}
			else
				customdb::err_die(1, "Error: File Upload Problem.", $FileExt, realpath(__FILE__), __LINE__, true);

			$ObjectID = object::NewObject('MEDIA', $Site['site_id'], $SecurityLevel);
			$query =	"	INSERT INTO media " .
						"	SET		media_id			= '" . intval($ObjectID) . "', " .
						"			media_type			= '" . aveEscT($FileExt) . "', " .
						"			media_small_file_id	= '" . intval($SmallFileID) . "', " .
						"			media_big_file_id	= '" . intval($BigFileID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			filebase::UpdateFileParentObjectID($SmallFileID, $ObjectID);
			filebase::UpdateFileParentObjectID($BigFileID, $ObjectID);

			return $ObjectID;
		}
		return 0;
	}

	public static function NewMediaData($MediaID, $LanguageID, $MediaDesc) {
		$query =	"	INSERT INTO media_data " .
					"	SET		media_id	= '" . intval($MediaID) . "', " .
					"			language_id = '" . intval($LanguageID) . "', " .
					"			media_desc	= '" . aveEscT($MediaDesc) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetMediaInfo($MediaID, $LanguageID) {
		$query =	"	SELECT	*, MD.*, M.* " .
					"	FROM	object_link OL	JOIN		object MO		ON (OL.object_id = MO.object_id) " .
					"							JOIN		media M			ON (M.media_id = MO.object_id) " .
					"							LEFT JOIN	media_data MD	ON (M.media_id = MD.media_id AND MD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	MO.object_id	= '" . intval($MediaID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;

	}

	public static function TouchMediaData($MediaID, $LanguageID) {
		$query =	"	INSERT INTO media_data " .
					"	SET		media_id	= '" . intval($MediaID) . "', " .
					"			language_id = '" . intval($LanguageID) . "', " .
					"			media_desc	= ''" .
					"	ON DUPLICATE KEY UPDATE media_id = '" . intval($MediaID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function UpdateMediaThumbnail($MediaID, $Site, $File, $SmallWidth, $SmallHeight) {
		if ($File['size'] > 0) {
			if(!file_exists($File['tmp_name']))
				customdb::err_die(1, "Error: File Upload Problem.", $File['tmp_name'], realpath(__FILE__), __LINE__, true);

			$FileExt = strtolower(substr(strrchr($File['name'], '.'), 1));

			if (!media::IsValidMediaType($FileExt))
				return false;

			$SmallFileID = 0;

			if ($FileExt == 'gif' || $FileExt == 'jpg' || $FileExt == 'png') {
				$SmallFileID	= filebase::AddPhoto($File, $SmallWidth, $SmallHeight, $Site, 0, $MediaID);
			}
			else
				return false;

			$Media = media::GetMediaInfo($MediaID, 0);
			if ($Media['media_small_file_id'] != 0)
				filebase::DeleteFile($Media['media_small_file_id'], $Site);

			$query =	"	UPDATE	media " .
						"	SET		media_small_file_id	= '" . intval($SmallFileID) . "'" .
						"	WHERE	media_id = '" . intval($MediaID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function UpdateMedia($MediaID, $File, $Site, $SmallWidth, $SmallHeight, $BigWidth, $BigHeight, $Resize = true, $WatermarkIDSmall = 0, $WatermarkIDBig = 0) {
		if ($File['size'] > 0) {
			$FileExt = strtolower(substr(strrchr($File['name'], '.'), 1));

			if (!media::IsValidMediaType($FileExt))
				return false;

			$SmallFileID = 0;
			$BigFileID = 0;

			if ($FileExt == 'gif' || $FileExt == 'jpg' || $FileExt == 'png') {
				$SmallFileID	= filebase::AddPhoto($File, $SmallWidth, $SmallHeight, $Site, $WatermarkIDSmall, $MediaID);

				if ($Resize)
					$BigFileID		= filebase::AddPhoto($File, $BigWidth, $BigHeight, $Site, $WatermarkIDBig, $MediaID);
				else
					$BigFileID		= filebase::AddFile($File, $Site, $MediaID);
			}
			elseif ($FileExt == 'avi' || $FileExt == 'wmv' || $FileExt == 'mov' || $FileExt == 'mpg' || $FileExt == 'mp3' || $FileExt == 'wma' || $FileExt == 'ra' ) {
				$Movie = new ffmpeg_movie($File['tmp_name'], false);
				if ($Movie->hasVideo()) {
					$MovieFrame = $Movie->getFrame(intval($Movie->getFrameCount() / 2));
					$MovieFrame->resize($SmallWidth, $SmallHeight);
					$TmpFile = tempnam("/tmp", "TmpImageFile");
					imagejpeg($MovieFrame->toGDImage(), $TmpFile, 80);

					$TheFile = array();
					$TheFile['name'] = 'temp.jpg';
					$TheFile['type'] = 'image/jpeg';
					$TheFile['size'] = filesize($TmpFile);
					$TheFile['tmp_name'] = $TmpFile;

					$SmallFileID = filebase::AddFile($TheFile, $Site, $MediaID);
					$BigFileID = filebase::AddFile($File, $Site, $MediaID);

					unlink($TmpFile);
				}
				else
					$BigFileID = filebase::AddFile($File, $Site, $MediaID);
			}
			else
				customdb::err_die(1, "Error: File Upload Problem.", $FileExt, realpath(__FILE__), __LINE__, true);

			$Media = media::GetMediaInfo($MediaID, 0);
			if ($Media['media_big_file_id'] != 0)
				filebase::DeleteFile($Media['media_big_file_id'], $Site);
			if ($Media['media_small_file_id'] != 0)
				filebase::DeleteFile($Media['media_small_file_id'], $Site);

			$query =	"	UPDATE	media " .
						"	SET		media_small_file_id	= '" . intval($SmallFileID) . "', " .
						"			media_big_file_id	= '" . intval($BigFileID) . "'" .
						"	WHERE	media_id = '" . intval($MediaID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function DeleteMedia($MediaID, $Site, $CallByDeleteParent = false) {
		$Media = media::GetMediaInfo($MediaID, 0);

		if ($Media['media_small_file_id'] != 0)
			filebase::DeleteFile($Media['media_small_file_id'], $Site);
		if ($Media['media_big_file_id'] != 0)
			filebase::DeleteFile($Media['media_big_file_id'], $Site);

		$query =	"	DELETE FROM media " .
					"	WHERE	media_id	= '" . intval($MediaID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM media_data " .
					"	WHERE	media_id	= '" . intval($MediaID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($MediaID);

		if (!$CallByDeleteParent) {
			$query =	"	DELETE FROM	object_link " .
						"	WHERE		parent_object_id = '" . intval($MediaID) . "'" .
						"			OR	object_id = '" . intval($MediaID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			object::TidyUpObjectOrder($Media['parent_object_id'], 'MEDIA');
		}
	}

	public static function GetMediaXML($MediaID, $LanguageID) {
		$smarty = new mySmarty();
		$Media = media::GetMediaInfo($MediaID, $LanguageID);
		if ($Media != null) {
			$Media['object_seo_url'] = object::GetSeoURL($Media, '', $LanguageID, null);
			$smarty->assign('Object', $Media);
			$MediaXML = $smarty->fetch('api/object_info/MEDIA.tpl');
			return $MediaXML;
		}
		else
			return '';
	}

	public static function GetMediaListXML($ParentObjectID, $LanguageID, &$TotalMedia, $PageNo = 1, $MediaPerPage = 20, $SecurityLevel = 999999) {
		$smarty = new mySmarty();
		$TotalMedia = 0;
		$MediaList = media::GetMediaList($ParentObjectID, $LanguageID, $TotalMedia, $PageNo, $MediaPerPage, $SecurityLevel, true, true);
		$MediaListXML = '';
		foreach ($MediaList as $M) {
			$M['object_seo_url'] = object::GetSeoURL($M, '', $LanguageID, null);
			$smarty->assign('Object', $M);
			$MediaListXML = $MediaListXML . $smarty->fetch('api/object_info/MEDIA.tpl');
		}
		return $MediaListXML;
	}

	public static function GetRandomMediaXML($SiteID, $LanguageID, $SecurityLevel, $NoOfMedia, $MediaTypeArray, $ParentType) {
		$MediaTypeSQL = '';

		if (count($MediaTypeArray) > 0) {
			$MediaTypeSQL = ' AND ( ';
			foreach ($MediaTypeArray as $T) {
				$MediaTypeSQL = $MediaTypeSQL . " M.media_type = '" . aveEscT($T) . "' OR ";
			}
			$MediaTypeSQL = $MediaTypeSQL . ' 1 > 2 ) ';
		}

		$ParentTypeSQL = '';
		if ($ParentType != 'all') {
			$ParentTypeSQL = " AND PO.object_type = '" . aveEscT($ParentType) . "'";
		}

		$query =	"	SELECT	*, MO.*, M.* " .
					"	FROM	object_link OL	JOIN		object MO		ON (OL.object_id = MO.object_id) " .
					"							JOIN		media M			ON (M.media_id = MO.object_id) " .
					"							LEFT JOIN	media_data MD	ON (MD.media_id = M.media_id AND MD.language_id = '" . intval($LanguageID) . "') " .
					"							LEFT JOIN	file_base B		ON (B.file_id = M.media_big_file_id) " .
					"							JOIN		object PO		ON (OL.parent_object_id = PO.object_id) " .
					"	WHERE	MO.site_id	= '" . intval($SiteID) . "'" .
					"		AND	MO.object_security_level <= '" . intval($SecurityLevel) . "'" .
					"		AND	MO.object_archive_date > NOW() " .
					"		AND	MO.object_publish_date < NOW() " .
					$ParentTypeSQL . $MediaTypeSQL;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$loop = 0;
		$TotalMedia = $result->num_rows;

		if ($NoOfMedia > $TotalMedia)
			$NoOfMedia = $TotalMedia;

		if ($TotalMedia == 0)
			return;

		$smarty = new mySmarty();
		$MediaListXML = '';
		$rand_ids = array();
		for ($i = 0; $i < $NoOfMedia; $i++) {
			$IsUnique = true;
			$j = rand(0, $TotalMedia -1);
			do {
				$IsUnique = true;
				$loop++;
				if (in_array($j, $rand_ids))
					$IsUnique = false;
				else
					array_push($rand_ids, $j);
				$j++;
				if ($j >= $TotalMedia)
					$j = 0;

				if ($loop > 10000)
					break;
			} while (!$IsUnique);
			$result->data_seek($j);
			$myResult = $result->fetch_assoc();
			$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $LanguageID, null);
			$smarty->assign('Object', $myResult);
			$MediaListXML = $MediaListXML . $smarty->fetch('api/object_info/MEDIA.tpl');
		}
		return $MediaListXML;
	}

	public static function UpdateTimeStamp($MediaID) {
		// Update the Album Itself
		object::UpdateObjectTimeStamp($MediaID);

		$Media = media::GetMediaInfo($MediaID, 0);

		$ParentObject = object::GetObjectInfo($Media['parent_object_id']);

		if ($ParentObject['object_type'] == 'ALBUM')
			album::UpdateTimeStamp($ParentObject['object_id']);
		elseif ($ParentObject['object_type'] == 'PRODUCT')
			product::UpdateTimeStamp($ParentObject['object_id']);
		elseif ($ParentObject['object_type'] == 'BONUS_POINT_ITEM')
			bonuspoint::UpdateTimeStamp($ParentObject['object_id']);
	}

	//	return TRUE if error seems temporary
	//	return FALSE if error seems fatal (e.g. Over Quota, No Site Language is enabled)
	//	specfic $ParentObjLinkID only if the function is called by parent import (e.g. import_product.php)
	//	ParentObjLinkID = 0 && $RealWrite = 'N' will skip checking as probably the whole product is not created in parent import (as this is probably another sim)
	//	for pure media import, specific the parent_object_link_id in the XML!
	public static function ImportMedia($Site, $ParentObjLinkID, $MediaXML, &$NoOfMediaParsed, &$NoOfMediaImported, &$NoOfMediaFailed, &$SuccessXMLString, &$ErrorXMLString, $RealWrite = 'N', $NewOrUpdate = 'new') {
		$smarty = new mySmarty();

		$NoOfMediaParsed++;
		$smarty->assign('msg', '');
		$smarty->assign('import_ref_id', $MediaXML->import_ref_id);

		$TheObject = null;
		if ($NewOrUpdate == 'update') {
			$TheObject = object::GetObjectsByObjectName($Site['site_id'], $MediaXML->object_name);
			if (count($TheObject) < 1) {
				$smarty->assign('msg', 'object_name: Not Found!');
				$NoOfMediaFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
				return true;
			}
			if (count($TheObject) > 1) {
				$smarty->assign('msg', 'More than one objects with same object name found.');
				$NoOfMediaFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
				return true;
			}
		}

		$SiteLanguageRoots = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');
		if (count($SiteLanguageRoots) == 0) {
			$smarty->assign('msg', ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED);
			$NoOfMediaFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
			return false;
		}

		$ObjectLink = null;
		if ($ParentObjLinkID != 0)
			$ObjectLink = object::GetObjectLinkInfo($ParentObjLinkID);
		elseif (intval($MediaXML->parent_object_link_id) > 0)
			$ObjectLink = object::GetObjectLinkInfo($MediaXML->parent_object_link_id);

		if ($RealWrite != 'N' && $ObjectLink == null) {
			$smarty->assign('msg', 'parent_object_link_id: not found!');
			$NoOfMediaFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
			return true;
		}
		if ($RealWrite != 'N' && $ObjectLink['site_id'] != $Site['site_id']) {
			$smarty->assign('msg', 'parent_object_link_id: this is not your object!');
			$NoOfMediaFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
			return true;
		}

		if ($ObjectLink != null && object::ValidateCreateObjectInTree(array('BONUS_POINT_ITEM', 'ALBUM', 'PRODUCT'), $ObjectLink, 'inside', $Site['site_id'], false) === false) {
			$smarty->assign('msg', 'parent_object_link_id: invalid parent object type');
			$NoOfMediaFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
			return true;
		}

		// Media Data Checking
		$MediaDataList = $MediaXML->media_data_list;

		$NoOfValidMediaData = 0;
		foreach ($SiteLanguageRoots as $R) {
			$MediaData = $MediaDataList->xpath("media_data[language_id='" . $R['language_id'] . "']");
			if (count($MediaData) > 0)
				$NoOfValidMediaData++;
		}
		if (count($MediaDataList->children()) != $NoOfValidMediaData) {
			if (count($MediaDataList->children()) > $NoOfValidMediaData)
				$smarty->assign('msg', 'media_data: invalid language_id found (not enabled?) ');
			elseif (count($MediaDataList->children()) < $NoOfValidMediaData)
				$smarty->assign('msg', 'media_data: not enough data (some language_id is enabled but not found in XML ');
			$NoOfMediaFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
			return true;
		}

		// File Checking
		if (strlen(trim($MediaXML->media_file_url)) == 0) {
			$smarty->assign('msg', 'media_file_url: blank?');
			$NoOfMediaFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
			return true;
		}

		$PathInfo = pathinfo(trim($MediaXML->media_file_url));
		$MediaFile = file_get_contents(trim($MediaXML->media_file_url));
		$TmpFile = tempnam("/tmp", "TmpImportImageFile");
		file_put_contents($TmpFile, $MediaFile);

		$TheFile = array();
		$TheFile['name'] = $PathInfo['basename'];
		$TheFile['size'] = filesize($TmpFile);
		$TheFile['tmp_name'] = $TmpFile;

		if ($TheFile['size'] <= 0) {
			$smarty->assign('msg', 'media file size is zero');
			$NoOfMediaFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
			unlink($TmpFile);
			return true;
		}			

		$FileExt = strtolower(substr(strrchr(trim($MediaXML->media_file_url), '.'), 1));

		if (!media::IsValidMediaType($FileExt)) {
			$smarty->assign('msg', 'media_file_url: unsupported file extension');
			$NoOfMediaFailed++;
			$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
			unlink($TmpFile);
			return true;
		}

		$im = null;
		$TheFileType = '';
		if ($FileExt == 'gif') {
			$TheFile['type'] = 'image/gif';
			$TheFileType = 'image';
		}
		elseif ($FileExt == 'jpg') {
			$TheFile['type'] = 'image/jpeg';
			$TheFileType = 'image';
		}
		elseif ($FileExt == 'png') {
			$TheFile['type'] = 'image/png';
			$TheFileType = 'image';
		}
		elseif ($FileExt == 'wmv') {
			$TheFile['type'] = 'video/x-ms-wmv';
			$TheFileType = 'video';
		}
		elseif ($FileExt == 'avi') {
			$TheFile['type'] = 'video/x-msvideo';
			$TheFileType = 'video';
		}
		elseif ($FileExt == 'mov') {
			$TheFile['type'] = 'video/quicktime';
			$TheFileType = 'video';
		}
		elseif ($FileExt == 'mpg') {
			$TheFile['type'] = 'video/mpeg';
			$TheFileType = 'video';
		}
		elseif ($FileExt == 'mp3') {
			$TheFile['type'] = 'audio/mpeg';
			$TheFileType = 'audio';
		}
		elseif ($FileExt == 'wma') {
			$TheFile['type'] = 'audio/x-ms-wma';
			$TheFileType = 'audio';
		}
		elseif ($FileExt == 'ra') {
			$TheFile['type'] = 'audio/x-pn-realaudio';
			$TheFileType = 'audio';
		}

		if ($TheFileType == 'image') {
			$ImgInfo = @getimagesize(trim($MediaXML->media_file_url));

			if ($ImgInfo[0] == 0) {
				$smarty->assign('msg', 'media_file_url: cannot load image');
				$NoOfMediaFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
				unlink($TmpFile);
				return true;
			}
			elseif ($ImgInfo[2] > 3) { // 1 = GIF, 2 = JPG, 3 = PNG
				$smarty->assign('msg', 'media_file_url: unsupported image type');
				$NoOfMediaFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
				unlink($TmpFile);
				return true;
			}
		}
		else {
			$Movie = new ffmpeg_movie($TmpFile, false);
			if (!$Movie->hasAudio() && !$Movie->hasVideo()) {
				$smarty->assign('msg', 'media_file_url: cannot load video/audio');
				$NoOfMediaFailed++;
				$ErrorXMLString = $smarty->fetch('api/import/MEDIA.tpl');
				unset($Movie);
				unlink($TmpFile);
				return true;
			}
			unset($Movie);
		}

		if ($RealWrite == 'Y') {
			$SmallWidth = 0;
			$SmallHeight = 0;
			$BigWidth = 0;
			$BigHeight = 0;
			$Resize = true;
			$MediaID = 0;

			if ($ObjectLink['object_type'] == 'PRODUCT') {
				$SmallWidth = $Site['site_product_media_small_width'];
				$SmallHeight = $Site['site_product_media_small_height'];
				$BigWidth = $Site['site_product_media_big_width'];
				$BigHeight = $Site['site_product_media_big_height'];

				if ($Site['site_product_media_resize'] != 'Y')
					$Resize = false;
			}
			elseif ($ObjectLink['object_type'] == 'BONUS_POINT_ITEM') {
				$SmallWidth = $Site['site_product_media_small_width'];
				$SmallHeight = $Site['site_product_media_small_height'];
				$BigWidth = $Site['site_product_media_big_width'];
				$BigHeight = $Site['site_product_media_big_height'];

				if ($Site['site_product_media_resize'] != 'Y')
					$Resize = false;
			}
			elseif ($ObjectLink['object_type'] == 'ALBUM') {
				$SmallWidth = $Site['site_media_small_width'];
				$SmallHeight = $Site['site_media_small_height'];
				$BigWidth = $Site['site_media_big_width'];
				$BigHeight = $Site['site_media_big_height'];

				if ($Site['site_media_resize'] != 'Y')
					$Resize = false;
			}

			$MediaID = 0;
			if ($NewOrUpdate == 'update') {
				$MediaID = $TheObject[0]['object_id'];
				media::UpdateMedia($MediaID, $TheFile, $Site, $SmallWidth, $SmallHeight, $BigWidth, $BigHeight, $Resize);
			}
			else {
				$MediaID = media::NewMediaWithObject($TheFile, $Site, $SmallWidth, $SmallHeight, $BigWidth, $BigHeight, $Resize);

				if ($MediaID !== false && $MediaID != 0) {
					object::NewObjectLink($ObjectLink['object_id'], $MediaID, $MediaXML->object_name, 0, 'normal', DEFAULT_ORDER_ID);
					object::TidyUpObjectOrder($ObjectLink['object_id']);
				}
			}

			$query	=	"	UPDATE	object " .
						"	SET		object_security_level	= '" . intval($MediaXML->object_security_level) . "' " .
						"	WHERE	object_id = '" . intval($MediaID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			object::UpdateObjectSEOData($MediaID, trim($MediaXML->object_meta_title), trim($MediaXML->object_meta_description), trim($MediaXML->object_meta_keywords), trim($MediaXML->object_friendly_url));

			foreach ($SiteLanguageRoots as $R) {
				$MediaData = $MediaDataList->xpath("media_data[language_id='" . $R['language_id'] . "']");
				media::TouchMediaData($MediaID, $R['language_id']);
				$query	=	"	UPDATE	media_data " .
							"	SET		media_desc = '" . aveEscT($MediaData[0]->media_desc) . "'" .
							"	WHERE	media_id = '" . intval($MediaID) . "'" .
							"		AND	language_id = '" . intval($R['language_id']) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
			media::UpdateTimeStamp($MediaID);
			site::EmptyAPICache($_SESSION['site_id']);
		}
		$smarty->assign('media_id', $MediaID);
		$SuccessXMLString = $smarty->fetch('api/import/MEDIA.tpl');
		$NoOfMediaImported++;
		unlink($TmpFile);
		return true;
	}

	public static function CloneMedia($Media, $SrcSite, $DstParentObjID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($Media['object_link_id']) <= 0)
			err_die(1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__);

		object::CloneObjectWithObjectLink($Media, $SrcSite, $DstParentObjID, 0, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName, $DstSite);

		$NewSmallFileID	= filebase::CloneFile($Media['media_small_file_id'], $SrcSite, $NewObjectID, $DstSite);
		$NewBigFileID	= filebase::CloneFile($Media['media_big_file_id'], $SrcSite, $NewObjectID, $DstSite);

		$sql = GetCustomTextSQL("media", "int", 0, $Media) . GetCustomTextSQL("media", "double", 0, $Media) . GetCustomTextSQL("media", "date", 0, $Media);
		if (strlen($sql) > 0)
			$sql = ", " . substr($sql, 0, -1);

		$query =	"	INSERT INTO media " .
					"	SET		media_id					= '" . intval($NewObjectID) . "', " .
					"			media_type					= '" . aveEscT($Media['media_type']) . "', " .
					"			media_small_file_id			= '" . intval($NewSmallFileID) . "', " .
					"			media_big_file_id			= '" . intval($NewBigFileID) . "' " . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Media Data
		$query =	"	SELECT	* " .
					"	FROM	media_data " .
					"	WHERE	media_id = '" . intval($Media['media_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			$sql = GetCustomTextSQL("media", "text", 0, $myResult);
			if (strlen($sql) > 0)
				$sql = ", " . substr($sql, 0, -1);

			$query =	"	INSERT INTO media_data " .
						"	SET		media_id					= '" . intval($NewObjectID) . "', " .
						"			media_desc					= '" . aveEscT($myResult['media_desc']) . "', " .
						"			language_id					= '" . aveEscT($myResult['language_id']) . "', " .
						"			object_meta_title			= '" . aveEscT($myResult['object_meta_title']) . "', " .
						"			object_meta_description		= '" . aveEscT($myResult['object_meta_description']) . "', " .
						"			object_meta_keywords		= '" . aveEscT($myResult['object_meta_keywords']) . "', " .
						"			object_friendly_url			= '" . aveEscT($myResult['object_friendly_url']) . "' " . $sql;
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}			
	}
}