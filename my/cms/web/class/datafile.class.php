<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class datafile {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetDatafileList($ParentObjectID, $LanguageID = 0, &$TotalDatafile, $PageNo = 1, $DatafilePerPage = 20, $SecurityLevel = 999999, $HonorArchiveDate = false, $HonorPublishDate = false) {
		$Offset = intval(($PageNo -1) * $DatafilePerPage);

		$sql = '';
		if ($HonorArchiveDate)
			$sql	=	$sql . "	AND	DO.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql	=	$sql . "	AND	DO.object_publish_date < NOW() ";

		$query =	"	SELECT	SQL_CALC_FOUND_ROWS *, D.* " .
					"	FROM	object_link OL	JOIN		object DO			ON (OL.object_id = DO.object_id) " .
					"							JOIN		datafile D			ON (D.datafile_id = DO.object_id) " .
					"							JOIN		file_base B			ON (B.file_id = D.datafile_file_id) " .
					"							LEFT JOIN	datafile_data DD	ON (DD.datafile_id = D.datafile_id AND DD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	OL.parent_object_id	= '" . intval($ParentObjectID) . "'" . 
					"		AND	DO.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql .
					"	ORDER BY OL.order_id ASC " .
					"	LIMIT	" . $Offset . ", " . intval($DatafilePerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);		
		$myResult = $result2->fetch_row();
		$TotalDatafile = $myResult[0];

		$DatafileList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($DatafileList, $myResult);
		}
		return $DatafileList;
	}

	public static function NewDatafileWithObject($File, $Site, $SecurityLevel = 0, $ArchiveDate = OBJECT_DEFAULT_ARCHIVE_DATE, $PublishDate = OBJECT_DEFAULT_PUBLISH_DATE, $IsEnable = 'Y') {
		if ($File['size'] > 0) {
			if(!file_exists($File['tmp_name']))
				customdb::err_die (1, "Error: File Upload Problem.", $File['tmp_name'], realpath(__FILE__), __LINE__, true);

			$FileExt = strtolower(substr(strrchr($File['name'], '.'), 1));

			$FileID = filebase::AddFile($File, $Site);

			$ObjectID = object::NewObject('DATAFILE', $Site['site_id'], $SecurityLevel, $ArchiveDate, $PublishDate, $IsEnable);
			$query =	"	INSERT INTO datafile " .
						"	SET		datafile_id			= '" . intval($ObjectID) . "', " .
						"			datafile_type		= '" . aveEscT($FileExt) . "', " .
						"			datafile_file_id	= '" . intval($FileID) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			filebase::UpdateFileParentObjectID($FileID, $ObjectID);

			return $ObjectID;
		}
		return 0;
	}

	public static function NewRemoteDatafileWithObject($Filename, $FileSize, $MimeType, $Site, $SecurityLevel = 0, $ArchiveDate = OBJECT_DEFAULT_ARCHIVE_DATE, $PublishDate = OBJECT_DEFAULT_PUBLISH_DATE, $IsEnable = 'Y', $FileMd5 = '') {
		if ($FileSize > 0) {
			$FileExt = strtolower(substr(strrchr($Filename, '.'), 1));

			$FileID = filebase::AddRemoteFile($Filename, $FileSize, $MimeType, $Site, 0, $FileMd5);

			$ObjectID = object::NewObject('DATAFILE', $Site['site_id'], $SecurityLevel, $ArchiveDate, $PublishDate, $IsEnable);
			$query =	"	INSERT INTO datafile " .
						"	SET		datafile_id			= '" . intval($ObjectID) . "', " .
						"			datafile_type		= '" . aveEscT($FileExt) . "', " .
						"			datafile_file_id	= '" . intval($FileID) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			filebase::UpdateFileParentObjectID($FileID, $ObjectID);

			return $ObjectID;
		}
		return 0;
	}

	public static function GetDatafileInfo($DatafileID, $LanguageID) {
		$query =	"	SELECT	*, D.* " .
					"	FROM	object_link OL	JOIN		object DO			ON (OL.object_id = DO.object_id) " .
					"							JOIN		datafile D			ON (D.datafile_id = DO.object_id) " .
					"							JOIN		file_base F			ON (D.datafile_file_id = F.file_id) " .
					"							LEFT JOIN	datafile_data DD	ON (D.datafile_id = DD.datafile_id AND DD.language_id = '" . intval($LanguageID) . "') " .
					"	WHERE	DO.object_id	= '" . intval($DatafileID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;

	}

	public static function TouchDatafileData($DatafileID, $LanguageID) {
		$query =	"	INSERT INTO datafile_data " .
					"	SET		datafile_id		= '" . intval($DatafileID) . "', " .
					"			language_id		= '" . intval($LanguageID) . "', " .
					"			datafile_desc	= ''" .
					"	ON DUPLICATE KEY UPDATE datafile_id = '" . intval($DatafileID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function UpdateDatafile($DatafileID, $File, $Site) {
		if ($File['size'] > 0) {
			$FileExt = strtolower(substr(strrchr($File['name'], '.'), 1));

			$FileID = filebase::AddFile($File, $Site, $DatafileID);

			$Datafile = datafile::GetDatafileInfo($DatafileID, 0);
			filebase::DeleteFile($Datafile['datafile_file_id'], $Site);	

			$query =	"	UPDATE	datafile " .
						"	SET		datafile_file_id	= '" . intval($FileID) . "' " .
						"	WHERE	datafile_id			= '" . intval($DatafileID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

	public static function DeleteDatafile($DatafileID, $Site, $CallByDeleteParent = false) {

		$Datafile = datafile::GetDatafileInfo($DatafileID, 0);
		filebase::DeleteFile($Datafile['datafile_file_id'], $Site);	

		$query =	"	DELETE FROM datafile " .
					"	WHERE	datafile_id	= '" . intval($DatafileID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM datafile_data " .
					"	WHERE	datafile_id	= '" . intval($DatafileID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		object::DeleteObject($DatafileID);

		if (!$CallByDeleteParent) {
			$query =	"	DELETE FROM	object_link " .
						"	WHERE		parent_object_id = '" . intval($DatafileID) . "'" .
						"			OR	object_id = '" . intval($DatafileID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			object::TidyUpObjectOrder($Datafile['parent_object_id'], 'DATAFILE');
		}
	}

	public static function GetDatafileXML($DatafileID, $LanguageID) {
		$smarty = new mySmarty();
		$Datafile = datafile::GetDatafileInfo($DatafileID, $LanguageID);
		if ($Datafile != null) {
			$Datafile['object_seo_url'] = object::GetSeoURL($Datafile, '', $LanguageID, null);
			$smarty->assign('Object', $Datafile);
			$DatafileXML = $smarty->fetch('api/object_info/DATAFILE.tpl');
			return $DatafileXML;
		}
		else
			return '';
	}

	public static function GetDatafileListXML($ParentObjectID, $LanguageID, &$TotalDatafile, $PageNo = 1, $DatafilePerPage = 20, $SecurityLevel = 999999) {
		$smarty = new mySmarty();
		$TotalDatafile = 0;
		$DatafileList = datafile::GetDatafileList($ParentObjectID, $LanguageID, $TotalDatafile, $PageNo, $DatafilePerPage, $SecurityLevel, true, true);
		$DatafileListXML = '';
		foreach ($DatafileList as $D) {
			$D['object_seo_url'] = object::GetSeoURL($D, '', $LanguageID, null);
			$smarty->assign('Object', $D);
			$DatafileListXML = $DatafileListXML . $smarty->fetch('api/object_info/DATAFILE.tpl');
		}
		return $DatafileListXML;
	}

	public static function UpdateTimeStamp($DatafileID) {

		object::UpdateObjectTimeStamp($DatafileID);

		$Datafile = datafile::GetDatafileInfo($DatafileID, 0);

		$ParentObject = object::GetObjectInfo($Datafile['parent_object_id']);

		if ($ParentObject['object_type'] == 'PRODUCT')
			product::UpdateTimeStamp($ParentObject['object_id']);

		// The following parent object type should not exist anyway. Only Product and Member supports datafile now. 2012/2/12
		elseif ($ParentObject['object_type'] == 'ALBUM')
			album::UpdateTimeStamp($ParentObject['object_id']);
		elseif ($ParentObject['object_type'] == 'BONUS_POINT_ITEM')
			bonuspoint::UpdateTimeStamp($ParentObject['object_id']);
	}

	public static function CloneDatafile($Datafile, $SrcSite, $DstParentObjID, &$NewObjectID, &$NewObjectLinkID, $ReorderSiblingLinkID = 'N', $AddCopyOfToObjectName = 'N', $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		if (intval($Datafile['object_link_id']) <= 0)
			customdb::err_die (1, "NULL Object Link ID", "", realpath(__FILE__), __LINE__, true);

		object::CloneObjectWithObjectLink($Datafile, $SrcSite, $DstParentObjID, 0, $NewObjectID, $NewObjectLinkID, $ReorderSiblingLinkID, $AddCopyOfToObjectName, $DstSite);

		$NewDataFileID	= filebase::CloneFile($Datafile['datafile_file_id'], $SrcSite, $NewObjectID, $DstSite);

		$sql = GetCustomTextSQL("datafile", "int", 0, $Datafile) . GetCustomTextSQL("datafile", "double", 0, $Datafile) . GetCustomTextSQL("datafile", "date", 0, $Datafile);
		if (strlen($sql) > 0)
			$sql = ", " . substr($sql, 0, -1);

		$query =	"	INSERT INTO datafile " .
					"	SET		datafile_id					= '" . intval($NewObjectID) . "', " .
					"			datafile_type				= '" . aveEscT($Datafile['datafile_type']) . "', " . 
					"			datafile_file_id 			= '" . intval($NewDataFileID) . "' " . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Datafile Data
		$query =	"	SELECT	* " .
					"	FROM	datafile_data " .
					"	WHERE	datafile_id = '" . intval($Datafile['datafile_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		while ($myResult = $result->fetch_assoc()) {
			$sql = GetCustomTextSQL("datafile", "text", 0, $myResult);
			if (strlen($sql) > 0)
				$sql = ", " . substr($sql, 0, -1);

			$query =	"	INSERT INTO datafile_data " .
						"	SET		datafile_id					= '" . intval($NewObjectID) . "', " .
						"			datafile_desc				= '" . aveEscT($myResult['datafile_desc']) . "', " .
						"			language_id					= '" . intval($myResult['language_id']) . "' " . $sql;
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}

}