<?php

/**
 * @property cmAlbumInfo $_cmObjectInfo
 * @property cmAlbumMetaInfo $_cmObjectMetaInfo
 * @method cmAlbumInfo getCmInfo()
 */
class cmAlbum extends cmObject {
	
	function __construct($AlbumID) {
		parent::__construct($AlbumID);
	}
	
	public function loadCmInfoFromDB() {
		parent::loadCmInfoFromDB();
		
		$query =	"	SELECT	* " .
					"	FROM	album " .
					"	WHERE	album_id = '" . intval($this->object_id) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		/* @var $cmAlbumInfo cmAlbumInfo */
		$cmAlbumInfo = $result->fetch_object('cmAlbumInfo');
		
		copyObjProperty($this->_cmObjectInfo, $cmAlbumInfo, $this->_cmObjectInfo);
		
		$this->_cmObjectInfo = $cmAlbumInfo;
	}
	
	private function updateCmMetaInfoFromDB() {
		$this->_cmObjectMetaInfo = new cmAlbumMetaInfo();
		//todo: update Meta
	}
	
	public function saveCmInfoToDB() {
		parent::saveCmInfoToDB();
		
		$objName = 'album';
		$update_sql =
				"	site_id = '" . intval($this->getCmInfo()->site_id) . "', " .
				"	album_id = '" . intval($this->getCmInfo()->album_id) . "', " .
				self::getCustomFieldUpdateSQL($objName, 'int') .
				self::getCustomFieldUpdateSQL($objName, 'double') .
				self::getCustomFieldUpdateSQL($objName, 'date') .
				self::getCustomFieldUpdateSQL($objName, 'file_id');
		$update_sql = substr($update_sql, 0, -2);
		
		$query =	"	INSERT INTO album " .
					"	SET site_id = '" . intval($this->getCmInfo()->site_id) . "', " . $update_sql . 
					"	ON DUPLICATE KEY UPDATE " . $update_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	
	private function updateJsonAndXML() {
		parent::updateJsonAndXML();
		
		
	}
	
	protected static $xmlTagName = 'album';	
}

class cmAlbumInfo extends cmObjectInfo {	
	public $album_id;
	public $album_custom_int_1 = null;
	public $album_custom_int_2 = null;
	public $album_custom_int_3 = null;
	public $album_custom_int_4 = null;
	public $album_custom_int_5 = null;
	public $album_custom_int_6 = null;
	public $album_custom_int_7 = null;
	public $album_custom_int_8 = null;
	public $album_custom_int_9 = null;
	public $album_custom_int_10 = null;
	public $album_custom_int_11 = null;
	public $album_custom_int_12 = null;
	public $album_custom_int_13 = null;
	public $album_custom_int_14 = null;
	public $album_custom_int_15 = null;
	public $album_custom_int_16 = null;
	public $album_custom_int_17 = null;
	public $album_custom_int_18 = null;
	public $album_custom_int_19 = null;
	public $album_custom_int_20 = null;
	public $album_custom_double_1 = null;
	public $album_custom_double_2 = null;
	public $album_custom_double_3 = null;
	public $album_custom_double_4 = null;
	public $album_custom_double_5 = null;
	public $album_custom_double_6 = null;
	public $album_custom_double_7 = null;
	public $album_custom_double_8 = null;
	public $album_custom_double_9 = null;
	public $album_custom_double_10 = null;
	public $album_custom_double_11 = null;
	public $album_custom_double_12 = null;
	public $album_custom_double_13 = null;
	public $album_custom_double_14 = null;
	public $album_custom_double_15 = null;
	public $album_custom_double_16 = null;
	public $album_custom_double_17 = null;
	public $album_custom_double_18 = null;
	public $album_custom_double_19 = null;
	public $album_custom_double_20 = null;
	public $album_custom_date_1 = null;
	public $album_custom_date_2 = null;
	public $album_custom_date_3 = null;
	public $album_custom_date_4 = null;
	public $album_custom_date_5 = null;
	public $album_custom_date_6 = null;
	public $album_custom_date_7 = null;
	public $album_custom_date_8 = null;
	public $album_custom_date_9 = null;
	public $album_custom_date_10 = null;
	public $album_custom_date_11 = null;
	public $album_custom_date_12 = null;
	public $album_custom_date_13 = null;
	public $album_custom_date_14 = null;
	public $album_custom_date_15 = null;
	public $album_custom_date_16 = null;
	public $album_custom_date_17 = null;
	public $album_custom_date_18 = null;
	public $album_custom_date_19 = null;
	public $album_custom_date_20 = null;
	public $album_custom_file_id_1 = null;
	public $album_custom_file_id_2 = null;
	public $album_custom_file_id_3 = null;
	public $album_custom_file_id_4 = null;
	public $album_custom_file_id_5 = null;
	public $album_custom_file_id_6 = null;
	public $album_custom_file_id_7 = null;
	public $album_custom_file_id_8 = null;
	public $album_custom_file_id_9 = null;
	public $album_custom_file_id_10 = null;
	public $album_custom_file_id_11 = null;
	public $album_custom_file_id_12 = null;
	public $album_custom_file_id_13 = null;
	public $album_custom_file_id_14 = null;
	public $album_custom_file_id_15 = null;
	public $album_custom_file_id_16 = null;
	public $album_custom_file_id_17 = null;
	public $album_custom_file_id_18 = null;
	public $album_custom_file_id_19 = null;
	public $album_custom_file_id_20 = null;
}

class cmAlbumMetaInfo extends cmObjectMetaInfo {
	public $total_no_of_media;
	public $media_list;
	public $page_no = 1;
}