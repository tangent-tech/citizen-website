<?php
/* 
Please do NOT think this as an OOP object, I just use the class to group the related functions...
*/

	if (!defined('IN_CMS'))
		die("huh?");

	class filebase{
		public function __construct() {
			die('Do not create me. I am not an object!');
		}
		
		public static function GetFileInfo($fileid) {
			$query	=	"	SELECT	* 
							FROM	" . DB_CMS . ".file_base
							WHERE	file_id = '" . intval($fileid) . "'";
			$result = filebase_mysql_query($query, __FILE__, __LINE__, true);
			
			if ($result->num_rows > 0) {
				$FileInfo = $result->fetch_assoc();
				return $FileInfo;
			}
			else
				return null;
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

		public static function CreatePath($fileid, $prefixpath = '/') {
			umask(0);
			$pathdepth = ceil(GetNoOfDigits($fileid) / 2);

			for ($i = 0; $i < $pathdepth; $i++)
			{
				if ($fileid %100 < 10)
					$prefixpath = $prefixpath . "0" . $fileid%100 . "/";
				else
					$prefixpath = $prefixpath . $fileid%100 . "/";

				@mkdir($prefixpath, 0777);

				$fileid = intval($fileid / 100);
			}

			return $prefixpath;
		}
		
		public static function AddFile($FileID, $FileFullPathLocation) {
			if(!file_exists($FileFullPathLocation))
				err_die(999, "Error: File path is incorrect.", $FileFullPathLocation, realpath(__FILE__), __LINE__);

			// Resample and SAVE!
			$filepath = filebase::CreatePath($FileID, FILEBASE_PATH);
			$filename = 'file-'. $FileID;
			$fullpath_filename = $filepath . $filename;
			copy($FileFullPathLocation, $fullpath_filename);
			return true;
		}
	}
?>