<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class filebase{
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function UpdateFileParentObjectID($FileID, $ParentObjectID) {
		$query =	"	UPDATE	file_base " .
					"	SET		file_parent_object_id	= '" . intval($ParentObjectID) . "'" .
					"	WHERE	file_id = '" . intval($FileID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function AddPhoto($file, $width, $height, $Site, $WatermarkID = 0, $ParentObjectID = 0) {
		if ($file['size'] > 0) {

			if(!file_exists($file['tmp_name']))
				customdb::err_die (1, "Error: File Upload Problem.", $file['tmp_name'], realpath(__FILE__), __LINE__, true);

			$WatermarkSrc = null;
			$conn_id = ftp_connect($Site['site_ftp_address']);
			$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password']));

			if ($Site['site_ftp_need_passive'] == 'Y')
				ftp_pasv($conn_id, true);
			else
				ftp_pasv($conn_id, false);

			if ($WatermarkID != 0) {
				$WatermarkSrc = tempnam("/tmp", "TmpWatermarkFile");
				$filepath = filebase::GetPath($WatermarkID, $Site['site_ftp_filebase_dir'] . "/");
				$filename = 'file-'. $WatermarkID;
				$fullpath_filename = $filepath . $filename;
				$download_result = @ftp_get($conn_id, $WatermarkSrc, $fullpath_filename, FTP_BINARY, 0);
			}
			// Resample and SAVE!
			$src = $file['tmp_name'];
			// Begin
			$img = new imaging;
			$img->set_img($src, $file['type']);
			$img->set_quality(100);

			$img->set_watermark($WatermarkSrc, $Site['site_watermark_position']);

			// Small thumbnail
			if ($width != 0)
				$img->set_size($width);
			else
				$img->set_size($img->get_width());

			//$TmpFile = tmpfile();
			$TmpFile = tempnam("/tmp", "TmpImageFile");

			if ($width != 0 || $WatermarkID != 0)
				$img->save_img($TmpFile);
			else
				copy ($src, $TmpFile);
			$img->clear_cache();

			$newfilesize = filesize($TmpFile);
			if ($newfilesize == 0)
				$newfilesize = $file['size'];

			$file_md5 = md5_file($TmpFile);

			$query =	"	INSERT INTO file_base " .
						"	SET filename					= '" . aveEscT($file['name']) . "', " .
						"			size					= '" . $newfilesize . "', " .
						"			mimetype				= '" . aveEscT($file['type']) . "', " .
						"			site_id					= '" . intval($Site['site_id']) . "', " .
						"			file_parent_object_id	= '" . intval($ParentObjectID) . "', " .
						"			file_md5				= '" . aveEsc($file_md5) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			$fileid = customdb::mysqli()->insert_id;

			$filepath = filebase::CreatePath($fileid, $Site['site_ftp_filebase_dir'] . "/", $conn_id);

			$filepath = filebase::GetPath($fileid, $Site['site_ftp_filebase_dir'] . "/");
			$filename = 'file-'. $fileid;
			$fullpath_filename = '/sg/web' . $filepath . $filename;

			$upload_result = ftp_put($conn_id, $fullpath_filename, $TmpFile, FTP_BINARY, 0);

			ftp_close($conn_id);

			//fclose($TmpFile); // this removes the temp file
			unlink($TmpFile);
			if ($WatermarkID != 0)
				unlink($WatermarkSrc);

			// Finalize
			return $fileid;
		}
		return false;
	}

	public static function AddRemoteFile($Filename, $FileSize, $MimeType, $Site, $ParentObjID, $FileMd5 = '') {
		$query =	"	INSERT INTO file_base " .
					"	SET filename				= '" . aveEscT($Filename) . "', " .
					"		size					= '" . intval($FileSize) . "', " .
					"		mimetype				= '" . aveEscT($MimeType) . "', " .
					"		site_id					= '" . intval($Site['site_id']) . "', " .
					"		file_parent_object_id	= '" . intval($ParentObjID) . "', " .
					"		file_md5				= '" . aveEsc($FileMd5) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$fileid = customdb::mysqli()->insert_id;

		return $fileid;
	}

	public static function AddFile($file, $Site, $ParentObjectID = 0) {
		if ($file['size'] > 0) {
			die(' i de');
			if(!file_exists($file['tmp_name']))
				err_die(1, "Error: File Upload Problem.", $file['tmp_name'], realpath(__FILE__), __LINE__);

			// Resample and SAVE!
			$src = $file['tmp_name'];

			$file_md5 = md5_file($src);

			$query =	"	INSERT INTO file_base " .
						"	SET filename				= '" . aveEscT($file['name']) . "', " .
						"		size					= '" . intval($file['size']) . "', " .
						"		mimetype				= '" . aveEscT($file['type']) . "', " .
						"		site_id					= '" . intval($Site['site_id']) . "', " .
						"		file_parent_object_id	= '" . intval($ParentObjectID) . "', " .
						"		file_md5				= '" . aveEsc($file_md5) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$fileid = customdb::mysqli()->insert_id;

			$conn_id = ftp_connect($Site['site_ftp_address']);
			$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password']));

			if ($Site['site_ftp_need_passive'] == 'Y')
				ftp_pasv($conn_id, true);
			else
				ftp_pasv($conn_id, false);

			$filepath = filebase::CreatePath($fileid, $Site['site_ftp_filebase_dir'] . "/", $conn_id);
			$filepath = filebase::GetPath($fileid, $Site['site_ftp_filebase_dir'] . "/");
			$filename = 'file-'. $fileid;
			$fullpath_filename = $filepath . $filename;

			// I have no idea why the below line does not work as it said it accepts the Context in php.net
			// But the result comes out is that the file is partially uploaded
			// copy($src, $filename);
			// echo file_put_contents($filename, file_get_contents($src, FILE_BINARY), null, $FtpStreamContext);
			$upload_result = @ftp_put($conn_id, $fullpath_filename, $src, FTP_BINARY, 0);
			ftp_close($conn_id);

//				if (!$upload_result)
//					return false;

			return $fileid;
		}
		return false;
	}

	public static function DeleteFile($FileID, $Site) {

		if (defined('SKIP_DELETE_FTP_FILE')) {

			$query =	"	DELETE	FROM file_base " .
						"	WHERE	file_id = '" . intval($FileID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			return (customdb::mysqli()->affected_rows > 0);
		}

		$FtpStreamOptions = array('ftp' => array('overwrite' => true));
		$FtpStreamContext = stream_context_create($FtpStreamOptions);
		$conn_id = ftp_connect($Site['site_ftp_address']);
		$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password']));

		if ($Site['site_ftp_need_passive'] == 'Y')
			ftp_pasv($conn_id, true);
		else
			ftp_pasv($conn_id, false);

		$filepath = filebase::GetPath($FileID, $Site['site_ftp_filebase_dir'] . "/");
		@ftp_delete($conn_id, $filepath . 'file-'. $FileID);
		ftp_close($conn_id);
//			@unlink($filepath . 'file-'. $FileID);

		$query =	"	DELETE	FROM file_base " .
					"	WHERE	file_id = '" . intval($FileID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		return (customdb::mysqli()->affected_rows > 0);
	}

	public static function GetPath($fileid, $prefixpath = '/') {
		umask(0);
		$pathdepth = ceil(GetNoOfDigits($fileid) / 2);

		for ($i = 0; $i < $pathdepth; $i++)
		{
			if ($fileid %100 < 10)
				$prefixpath = $prefixpath . "0" . $fileid%100 . "/";
			else
				$prefixpath = $prefixpath . $fileid%100 . "/";

			$fileid = intval($fileid / 100);
		}

		return $prefixpath;
	}

	public static function CreatePath($fileid, $prefixpath = '/', $ConnID = null) {
		umask(0);
		$pathdepth = ceil(GetNoOfDigits($fileid) / 2);
		$prefixpath = '/sg/web/filebase/';
		for ($i = 0; $i < $pathdepth; $i++)
		{
			if ($fileid %100 < 10){
				$prefixpath = $prefixpath . "0" . $fileid%100 . "/";
			}
			else{
				$prefixpath = $prefixpath . $fileid%100 . "/";
			}

			ftp_mkdir($ConnID, $prefixpath);
			$fileid = intval($fileid / 100);
		}
		return $prefixpath;
	}

	public static function GetFileInfo($FileID) {
		$query =	"	SELECT	*	" .
					"	FROM	file_base " .
					"	WHERE	file_id = '" . intval($FileID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $myResult = $result->fetch_assoc();
		else
			return null;
	}

	public static function CloneFile($FileID, $SrcSite, $NewParentObjectID = 0, $DstSite = null) {
		// Here we download and save the file temporarily and then upload.... stupid method.....
		//	Luckily this stupid method is used... new option to support cross site copying...

		$File = filebase::GetFileInfo($FileID);
		if ($File['site_id'] != $SrcSite['site_id'] || $File == null)
			return false;

		if ($DstSite == null)
			$DstSite = $SrcSite;

		$query =	"	INSERT INTO file_base " .
					"	SET filename				= '" . aveEscT($File['filename']) . "', " .
					"		size					= '" . intval($File['size']) . "', " .
					"		mimetype				= '" . aveEscT($File['mimetype']) . "', " .
					"		site_id					= '" . intval($DstSite['site_id']) . "', " .
					"		file_parent_object_id	= '" . intval($NewParentObjectID) . "', " .
					"		file_md5				= '" . aveEscT($File['file_md5']) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$NewFileID = customdb::mysqli()->insert_id;

		$FtpStreamOptions = array('ftp' => array('overwrite' => true));
		$FtpStreamContext = stream_context_create($FtpStreamOptions);
		$conn_id = ftp_connect($SrcSite['site_ftp_address']);
		$login_result = ftp_login($conn_id, $SrcSite['site_ftp_username'], site::MyDecrypt($SrcSite['site_ftp_password']));

		if ($SrcSite['site_ftp_need_passive'] == 'Y')
			ftp_pasv($conn_id, true);
		else
			ftp_pasv($conn_id, false);

		$TmpFile = tempnam("/tmp", "TmpImageFile");

		$src_filepath = filebase::GetPath($FileID, $SrcSite['site_ftp_filebase_dir'] . "/");
		$src_filename = $src_filepath . 'file-'. $FileID;

		$download_result = ftp_get($conn_id, $TmpFile, $src_filename, FTP_BINARY, 0);

		$dest_filepath = filebase::GetPath($NewFileID, $DstSite['site_ftp_filebase_dir'] . "/");
		$dest_filename = 'file-'. $NewFileID;
		$fullpath_filename = $dest_filepath . $dest_filename;
		// copy($src_filename, $TmpFile);

		if ($SrcSite['site_id'] != $DstSite['site_id']) {
			$dst_conn_id = ftp_connect($DstSite['site_ftp_address']);
			$login_result = ftp_login($dst_conn_id, $DstSite['site_ftp_username'], site::MyDecrypt($DstSite['site_ftp_password']));

			if ($DstSite['site_ftp_need_passive'] == 'Y')
				ftp_pasv($dst_conn_id, true);
			else
				ftp_pasv($dst_conn_id, false);

			filebase::CreatePath($NewFileID, $DstSite['site_ftp_filebase_dir'] . "/", $dst_conn_id);

			$upload_result = ftp_put($dst_conn_id, $fullpath_filename, $TmpFile, FTP_BINARY, 0);
			ftp_close($dst_conn_id);
			ftp_close($conn_id);
		}
		else {
			filebase::CreatePath($NewFileID, $DstSite['site_ftp_filebase_dir'] . "/", $conn_id);
			$upload_result = ftp_put($conn_id, $fullpath_filename, $TmpFile, FTP_BINARY, 0);
			ftp_close($conn_id);
		}

		//fclose($TmpFile); // this removes the temp file
		unlink($TmpFile);

		return $NewFileID;
	}

	public static function GetFileFtpURL($FileID, $Site) {
		$File = filebase::GetFileInfo($FileID);
		if ($File['site_id'] != $Site['site_id'] || $File == null)
			return false;

		$src_filepath = filebase::GetPath($FileID, $Site['FtpFilebasePath'] . "/");
		$src_filename = $src_filepath . 'file-'. $FileID;
		return $src_filename;
	}

	public static function GetFileXML($FileID) {
		$smarty = new mySmarty();
		$File = filebase::GetFileInfo($FileID);
		if ($File != null) {
			$ParentObj = object::GetObjectInfo($File['file_parent_object_id']);
			$smarty->assign('ParentObjectID', $File['file_parent_object_id']);
			$smarty->assign('ObjectSecurityLevel', $ParentObj['object_security_level']);

			$smarty->assign('Object', $File);
			$FileXML = $smarty->fetch('api/object_info/FILE.tpl');
			return $FileXML;
		}
		return '';
	}

	public static function GetMaxFileID($SiteID) {
		$query  =	" 	SELECT	MAX(file_id) as max_file_id " .
					"	FROM	file_base " .
					"	WHERE	site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$myResult = $result->fetch_assoc();

		return $myResult['max_file_id'];			
	}
}