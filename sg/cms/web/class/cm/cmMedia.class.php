<?php

/**
 * @property cmMediaInfo $_cmObjectInfo
 * @property cmMediaLangDataInfo[] $_langInfoArray
 */
class cmMedia extends cmObject {

	function __construct($mediaID, cmMediaInfo $cmMediaInfo = null, cmSite $cmSite) {
		parent::__construct($mediaID, $cmSite);
		$this->_cmObjectInfo = $cmMediaInfo;
	}
	
	protected function loadCmInfoFromDB() {
		$query =	" SELECT * FROM " .
					"	media M	JOIN object O ON (M.media_id = O.object_id) " .
					" WHERE O.object_id = '" . $this->object_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->_cmObjectInfo = $result->fetch_object('cmMediaInfo');
	}
	
	protected function loadLangInfoFromDB() {
		$this->_langInfoArray = array();
		
		$query =	" SELECT * " .
					" FROM media_data " .
					" WHERE media_id = '" . $this->object_id . "'" .
					" ORDER BY language_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		while ($myResult = $result->fetch_object('cmMediaLangDataInfo')) {
			/* @var $myResult cmMediaLangDataInfo */
			$this->_langInfoArray[intval($myResult->language_id)] = $myResult;
		}
	}
	
	protected function updateCmMetaInfoFromDB() {}
	
	public function saveCmInfoToDB() {
		parent::saveCmInfoToDB();
		
		$objName = 'media';
		$customSql =
					self::getCustomFieldUpdateSQL($objName, 'int', NUM_OF_CUSTOM_INT_FIELDS) .
					self::getCustomFieldUpdateSQL($objName, 'double', NUM_OF_CUSTOM_DOUBLE_FIELDS) .
					self::getCustomFieldUpdateSQL($objName, 'date', NUM_OF_CUSTOM_DATE_FIELDS);
		$customSql = substr($customSql, 0, -2);
		
		$query =	" UPDATE media SET " .
					"	cm_site_id = '" . intval($this->cmSite->site_id) . "', " . $customSql .
					" WHERE media_id = '" . intval($this->object_id) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($this->_langInfoArray != null) {
			foreach ($this->_langInfoArray as $I) {
				
				$updateSql =	self::getCustomFieldUpdateSQL($objName, 'text', NUM_OF_CUSTOM_TEXT_FIELDS) .
								" cm_site_id = '" . intval($this->cmSite->site_id) . "', " .
								" object_meta_title = '" . aveEscT($I->object_meta_title) . "', " .
								" object_meta_description = '" . aveEscT($I->object_meta_description) . "', " . 
								" object_meta_keywords = '" . aveEscT($I->object_meta_keywords) . "', " . 
								" object_friendly_url = '" . aveEscT($I->object_friendly_url) . "', " . 
								" media_desc = '" . aveEscT($I->media_desc) . "'";
				
				$query =	" INSERT INTO media_data SET " .
							"	media_id = '" . intval($this->object_id) . "', " .
							"	language_id = '" . intval($I->language_id) . "', " . $updateSql .
							" ON DUPLICATE KEY UPDATE " . $updateSql;
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);							
			}
		}
	}
	
	public static function newCmMediaToDB(cmSite $cmSite, &$ErrorMsg) {
		
	}
	
}

class cmMediaInfo extends cmObjectInfo {
	public $cm_site_id;
	public $media_id;
	public $media_type;
	public $media_small_file_id;
	public $media_big_file_id;
	public $media_custom_int_1 = null;
	public $media_custom_int_2 = null;
	public $media_custom_int_3 = null;
	public $media_custom_int_4 = null;
	public $media_custom_int_5 = null;
	public $media_custom_int_6 = null;
	public $media_custom_int_7 = null;
	public $media_custom_int_8 = null;
	public $media_custom_int_9 = null;
	public $media_custom_int_10 = null;
	public $media_custom_int_11 = null;
	public $media_custom_int_12 = null;
	public $media_custom_int_13 = null;
	public $media_custom_int_14 = null;
	public $media_custom_int_15 = null;
	public $media_custom_int_16 = null;
	public $media_custom_int_17 = null;
	public $media_custom_int_18 = null;
	public $media_custom_int_19 = null;
	public $media_custom_int_20 = null;
	public $media_custom_double_1 = null;
	public $media_custom_double_2 = null;
	public $media_custom_double_3 = null;
	public $media_custom_double_4 = null;
	public $media_custom_double_5 = null;
	public $media_custom_double_6 = null;
	public $media_custom_double_7 = null;
	public $media_custom_double_8 = null;
	public $media_custom_double_9 = null;
	public $media_custom_double_10 = null;
	public $media_custom_double_11 = null;
	public $media_custom_double_12 = null;
	public $media_custom_double_13 = null;
	public $media_custom_double_14 = null;
	public $media_custom_double_15 = null;
	public $media_custom_double_16 = null;
	public $media_custom_double_17 = null;
	public $media_custom_double_18 = null;
	public $media_custom_double_19 = null;
	public $media_custom_double_20 = null;
	public $media_custom_date_1 = null;
	public $media_custom_date_2 = null;
	public $media_custom_date_3 = null;
	public $media_custom_date_4 = null;
	public $media_custom_date_5 = null;
	public $media_custom_date_6 = null;
	public $media_custom_date_7 = null;
	public $media_custom_date_8 = null;
	public $media_custom_date_9 = null;
	public $media_custom_date_10 = null;
	public $media_custom_date_11 = null;
	public $media_custom_date_12 = null;
	public $media_custom_date_13 = null;
	public $media_custom_date_14 = null;
	public $media_custom_date_15 = null;
	public $media_custom_date_16 = null;
	public $media_custom_date_17 = null;
	public $media_custom_date_18 = null;
	public $media_custom_date_19 = null;
	public $media_custom_date_20 = null;
	
}

class cmMediaLangDataInfo extends cmObjectDataInfo {
	public $cm_site_id;
	public $language_id;
	public $media_data_id;
	public $object_meta_title;
	public $object_meta_description;
	public $object_meta_keywords;
	public $object_meta_description;
	public $object_friendly_url;
	public $media_desc;
	public $media_custom_text_1;
	public $media_custom_text_2;
	public $media_custom_text_3;
	public $media_custom_text_4;
	public $media_custom_text_5;
	public $media_custom_text_6;
	public $media_custom_text_7;
	public $media_custom_text_8;
	public $media_custom_text_9;
	public $media_custom_text_10;
	public $media_custom_text_11;
	public $media_custom_text_12;
	public $media_custom_text_13;
	public $media_custom_text_14;
	public $media_custom_text_15;
	public $media_custom_text_16;
	public $media_custom_text_17;
	public $media_custom_text_18;
	public $media_custom_text_19;
	public $media_custom_text_20;
}