<?php
// parameters:
//	media_id
//	object_name
//	security_level
//	archive_date
//	publish_date
//	is_enable
//	object_meta_title
//	object_meta_description
//	object_meta_keywords
//	object_friendly_url
//	media_desc[lang_id]
//	media_url - you may pass http full path
//	media_ftp_path - absolute path relative to the site ftp login (note: on our system, ftp is chrooted)
//	media_custom_int_1 .. media_custom_int_20
//	media_custom_double_1 .. media_custom_double_20
//	media_custom_date_1 .. media_custom_date_20
//	media_custom_text_1[lang_id] .. media_custom_text_20[lang_id]
//	add_watermark - you must upload the watermark via backend first, default: N
//	order_id - use fraction to move between two media (e.g. use 2.5 to move between 2 and 3)
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$IsContentAdmin = true;

if ($Site['site_module_objman_enable'] != 'Y')
	APIDie(array('desc' => 'Module ObjMan is not enabled'));

if (!isset($_REQUEST['archive_date']))
	$_REQUEST['archive_date'] = OBJECT_DEFAULT_ARCHIVE_DATE;
if (!isset($_REQUEST['publish_date']))
	$_REQUEST['publish_date'] = OBJECT_DEFAULT_PUBLISH_DATE;
if (!isset($_REQUEST['is_enable']))
	$_REQUEST['is_enable'] = 'Y';
if (!isset($_REQUEST['object_name']))
	$_REQUEST['object_name'] = 'Untitled Object';

$Media = media::GetMediaInfo($_REQUEST['media_id'], 0);
if ($Media['site_id'] != $Site['site_id'])
	APIDie(array('desc' => 'Invalid media_id'));

$ObjectLink = object::GetObjectLinkInfo($Media['parent_object_id']);

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	APIDie(array('desc' => ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED));

// File Checking
//if (strlen(trim($_REQUEST['media_url'])) == 0 && strlen(trim($_REQUEST['media_ftp_path'])) == 0)
//	APIDie(array('desc' => 'Invalid media_url and invalid media_ftp_path'));

if (strlen(trim($_REQUEST['media_url'])) > 0 || strlen(trim($_REQUEST['media_ftp_path'])) > 0) {
	if (strlen(trim($_REQUEST['media_ftp_path'])) > 0) {
		$PathInfo = pathinfo(trim($_REQUEST['media_ftp_path']));

		$conn_id = ftp_connect($Site['site_ftp_address']);
		$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password']));

		if ($Site['site_ftp_need_passive'] == 'Y')
			ftp_pasv($conn_id, true);
		else
			ftp_pasv($conn_id, false);

		$TmpFile = tempnam("/tmp", "TmpImportImageFile");
		$download_result = @ftp_get($conn_id, $TmpFile, trim($_REQUEST['media_ftp_path']), FTP_BINARY, 0);
	}
	else if (strlen(trim($_REQUEST['media_url'])) > 0) {
		$PathInfo = pathinfo(trim($_REQUEST['media_url']));
		$MediaFile = file_get_contents(trim($_REQUEST['media_url']));
		$TmpFile = tempnam("/tmp", "TmpImportImageFile");
		file_put_contents($TmpFile, $MediaFile);	
	}

	$TheFile = array();
	$TheFile['name'] = $PathInfo['basename'];
	$TheFile['size'] = filesize($TmpFile);
	$TheFile['tmp_name'] = $TmpFile;

	$FileExt = strtolower(substr(strrchr(trim($PathInfo['basename']), '.'), 1));

	if (!media::IsValidMediaType($FileExt)) {
		unlink($TmpFile);
		APIDie(array('desc' => 'media_file: unsupported file extension'));
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
	//	$ImgInfo = @getimagesize(trim($_REQUEST['media_url']));
		$ImgInfo = @getimagesize($TmpFile);

		if ($ImgInfo[0] == 0) {
			unlink($TmpFile);
			APIDie(array('desc' => 'media_file_url: cannot load image'));
		}
		elseif ($ImgInfo[2] > 3) { // 1 = GIF, 2 = JPG, 3 = PNG
			unlink($TmpFile);
			APIDie(array('desc' => 'media_file_url: unsupported image type'));
		}
	}
	else {
		$Movie = new ffmpeg_movie($TmpFile, false);
		if (!$Movie->hasAudio() && !$Movie->hasVideo()) {
			unset($Movie);
			unlink($TmpFile);
			APIDie(array('desc' => 'media_file_url: cannot load video/audio'));
		}
		unset($Movie);
	}

	$SmallWidth = 0;
	$SmallHeight = 0;
	$BigWidth = 0;
	$BigHeight = 0;
	$Resize = true;
	$MediaID = 0;

	if ($ObjectLink['object_type'] == 'PRODUCT' || $ObjectLink['object_type'] == 'PRODUCT_CATEGORY') {
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

	$WatermarkIDSmall = 0;
	$WatermarkIDBig = 0;

	if ($_REQUEST['add_watermark'] == 'Y') {
		$WatermarkIDBig = $Site['site_media_watermark_big_file_id'];
		$WatermarkIDSmall = $Site['site_media_watermark_small_file_id'];
	}

	media::UpdateMedia($_REQUEST['media_id'], $TheFile, $Site, $SmallWidth, $SmallHeight, $BigWidth, $BigHeight, $Resize, $WatermarkIDSmall, $WatermarkIDBig);
	media::UpdateTimeStamp($_REQUEST['media_id']);
	
	unlink($TmpFile);
}

$MediaID = $_REQUEST['media_id'];

$query	=	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['is_enable']) . "', " . 
			"			object_security_level	= '" . intval($_REQUEST['security_level']) . "', " .
			"			object_archive_date		= '" . aveEscT($_REQUEST['archive_date']) . "', " .
			"			object_publish_date		= '" . aveEscT($_REQUEST['publish_date']) . "' " .
			"	WHERE	object_id = '" . intval($MediaID) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::UpdateObjectSEOData($MediaID, trim($_REQUEST['object_meta_title']), trim($_REQUEST['object_meta_description']), trim($_REQUEST['object_meta_keywords']), trim($_REQUEST['object_friendly_url']));

foreach ($SiteLanguageRoots as $R) {
	media::TouchMediaData($MediaID, $R['language_id']);

	$sql = GetCustomTextSQL("media", "text", $R['language_id']);
	if (strlen($sql) > 0)
		$sql = ", " . substr($sql, 0, -1);	
	
	$query	=	"	UPDATE	media_data " .
				"	SET		media_desc = '" . aveEscT($_REQUEST['media_desc'][$R['language_id']]) . "'" . $sql .
				"	WHERE	media_id = '" . intval($MediaID) . "'" .
				"		AND	language_id = '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$sql = GetCustomTextSQL("media", "int") . GetCustomTextSQL("media", "double") . GetCustomTextSQL("media", "date");
if (strlen($sql) > 0) {
	$query =	"	UPDATE	media " .
				"	SET		" . substr($sql, 0, -1) .
				"	WHERE	media_id = '" . intval($MediaID) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

if (isset($_REQUEST['order_id'])) {
	$query	=	"	UPDATE	object_link " .
				"	SET		order_id = '" . intval($_REQUEST['order_id']) . "' " .
				"	WHERE	object_link_id = '" . intval($Media['object_link_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	object::TidyUpObjectOrder($ObjectLink['object_id'], 'MEDIA');
}

media::UpdateTimeStamp($MediaID);
site::EmptyAPICache($Site['site_id']);

$smarty->assign('Data', "<media_id>" . $MediaID . "</media_id>");
$smarty->display('api/api_result.tpl');