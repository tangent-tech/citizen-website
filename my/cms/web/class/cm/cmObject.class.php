<?php

/**
 * @property cmObjectInfo $_cmObjectInfo
 * @property cmObjectMetaInfo $_cmObjectMetaInfo
 * @property cmSite $cmSite
 */

abstract class cmObject {

	function __construct($objectID, cmSite $cmSite) {
		$this->object_id = intval($objectID);
		$this->cmSite = $cmSite;
	}
	
	abstract protected function loadCmInfoFromDB();
	
	abstract protected function loadLangInfoFromDB();
	
	abstract protected function updateCmMetaInfoFromDB();
		
	protected function cloneObject(cmSite $cmSrcSite, cmSite $cmDstSite, &$retNewObjID) {
		
	}
	
	protected function saveCmInfoToDB() {
		$this->updateJsonAndXML();
		
		$repeat_sql = '';
		for ($i = 1; $i <=9; $i++) {
			$repeat_sql .= 
				"	object_vote_sum_" . $i . " = '" . intval($this->getCmInfo()->{'object_vote_sum_' . $i}) . "', " .
				"	object_vote_count_" . $i . " = '" . intval($this->getCmInfo()->{'object_vote_count_' . $i}) . "', " .
				"	object_vote_average_" . $i . " = '" . doubleval($this->getCmInfo()->{'object_vote_average_' . $i}) . "', " .
				"	object_custom_rgb_" . $i . " = '" . aveEscT($this->getCmInfo()->{'object_custom_rgb_' . $i}) . "', ";
		}
		
		$query =	" UPDATE object SET " .
					"	object_id = '" . intval($this->object_id) . "', " .
					"	object_type = '" . aveEscT($this->getCmInfo()->object_type) . "', " .
					"	site_id = '" . intval($this->getCmInfo()->site_id) . "', " .
					"	object_is_enable = '" . ynval($this->getCmInfo()->object_is_enable) . "', " .
					"	object_security_level = '" . aveEscT($this->getCmInfo()->object_security_level) . "', " .
					"	object_meta_title = '" . aveEscT($this->getCmInfo()->object_meta_title) . "', " .
					"	object_meta_description = '" . aveEscT($this->getCmInfo()->object_meta_description) . "', " .
					"	object_meta_keywords = '" . aveEscT($this->getCmInfo()->object_meta_keywords) . "', " .
					"	object_friendly_url = '" . aveEscT($this->getCmInfo()->object_friendly_url) . "', " .
					"	object_lang_switch_id = '" . aveEscT($this->getCmInfo()->object_lang_switch_id) . "', " .
					"	object_thumbnail_file_id = '" . intval($this->getCmInfo()->object_thumbnail_file_id) . "', " .
					"	create_date = '" . aveEscT($this->getCmInfo()->create_date) . "', " .
					"	counter_all_time = '" . intval($this->getCmInfo()->counter_alltime) . "', " .
					"	is_removed = '" . ynval($this->getCmInfo()->is_removed) . "', " .
					"	object_removed_date = '" . aveEscT($this->getCmInfo()->object_removed_date) . "', " . $repeat_sql .
					"	object_archive_date = '" . aveEscT($this->getCmInfo()->object_archive_date) . "', " .
					"	object_publish_date = '" . aveEscT($this->getCmInfo()->object_publish_date) . "', " .
					"	object_owner_content_admin_id = '" . intval($this->getCmInfo()->object_owner_content_admin_id) . "', " .
					"	object_owner_content_admin_group_id = '" . intval($this->getCmInfo()->object_owner_content_admin_group_id) . "', " .
					"	object_publisher_content_admin_group_id = '" . intval($this->getCmInfo()->object_publisher_content_admin_group_id) . "', " .
					"	object_permission_browse_children = '" . aveEscT($this->getCmInfo()->object_permission_browse_children) . "', " .
					"	object_permission_add_children = '" . aveEscT($this->getCmInfo()->object_permission_add_children) . "', " .
					"	object_permission_edit = '" . aveEscT($this->getCmInfo()->object_permission_edit) . "', " .
					"	object_permission_delete = '" . aveEscT($this->getCmInfo()->object_permission_delete) . "', " .
					"	object_global_order_id = '" . doubleval($this->getCmInfo()->object_global_order_id) . "', " .
					"	object_id_clone_from = " . aveEscQ($this->getCmInfo()->object_id_clone_from) . ", " .
					"	object_xml = " . aveEscTQ($this->getCmInfo()->object_xml) . ", " .
					"	object_json = " . aveEscTQ($this->getCmInfo()->object_json) . " ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	protected function updateJsonAndXML() {
		unset($this->_cmObjectInfo->object_json);
		unset($this->_cmObjectInfo->object_xml);
	}	
	
	public function setDirty() {
		$this->_cmObjectInfo = null;
		$this->_cmObjectMetaInfo = null;
		$this->_langInfoArray = null;
	}
		
	final public function getCmMetaInfo() {
		if ($this->_cmObjectMetaInfo == null) {
			$this->updateCmMetaInfoFromDB();
		}
		return $this->_cmObjectMetaInfo;
	}
	
	final public function getLangInfo() {
		if ($this->_langInfoArray == null) {
			$this->loadLangInfoFromDB();
		}
		return $this->_langInfoArray;
	}

	/**
	 * 
	 * @param string $ObjType
	 * @return newObjectID
	 */
	protected static function newCmObjectToDB($ObjType, cmSite $CmSite) {
		global $ObjectTypeList;
		if (!in_array($ObjType, $ObjectTypeList)) {
			customdb::err_die(1, "Invalid Object Type", "Try to create an unknown object", __FILE__, __LINE__, true);
		}
		
		$query	=	"	INSERT INTO object " .
					"	SET " .
					"		object_type = '" . aveEscT($ObjType) . "', " .
					"		site_id = '" . $CmSite->site_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		return customdb::mysqli()->insert_id;
	}
	
	final public function getCmInfo() {
		if ($this->_cmObjectInfo === null) {
			$this->loadCmInfoFromDB();
		}
		return $this->_cmObjectInfo;
	}	
	
	protected $object_id;

	/* @var $cmSite cmSite */
	protected $cmSite;
	
	/* @var $_cmObjectInfo cmObjectInfo */
	protected $_cmObjectInfo = null;
	
	/* @var $_cmObjectMetaInfo cmObjectInfo */
	protected $_cmObjectMetaInfo = null;
	
	protected $_langInfoArray = null;

	protected static $xmlTagName = 'object';

	protected static function getCustomFieldUpdateSQL($objName = '', $fieldName = '', $maxCustomFieldNo = NUM_OF_GENERAL_CUSTOM_FIELDS) {
		$sql = '';
		
		for ($i = 1; $i <= $maxCustomFieldNo; $i++) {
			$sql = $sql . " " . aveEscT($objName) . "_custom_" . aveEscT($fieldName) . "_" . $i . " = "  . aveEscTQ($this->getCmInfo()->{$objName . "_custom_" . $fieldName . "_" . $i}) . "', ";
		}

		return $sql;
	}
}

class cmObjectInfo {
	function __construct() {
	}
		
	public $object_id;
	public $object_type;
	public $site_id;
	public $object_is_enable;
	public $object_security_level;
	public $object_meta_title;
	public $object_meta_description;
	public $object_meta_keywords;
	public $object_friendly_url;
	public $object_lang_switch_id;
	public $object_thumbnail_file_id;
	public $modify_date;
	public $create_date;
	public $counter_alltime;
	public $is_removed;
	public $object_removed_date;
	public $object_vote_sum_1;
	public $object_vote_count_1;
	public $object_vote_average_1;
	public $object_vote_sum_2;
	public $object_vote_count_2;
	public $object_vote_average_2;
	public $object_vote_sum_3;
	public $object_vote_count_3;
	public $object_vote_average_3;
	public $object_vote_sum_4;
	public $object_vote_count_4;
	public $object_vote_average_4;
	public $object_vote_sum_5;
	public $object_vote_count_5;
	public $object_vote_average_5;
	public $object_vote_sum_6;
	public $object_vote_count_6;
	public $object_vote_average_6;
	public $object_vote_sum_7;
	public $object_vote_count_7;
	public $object_vote_average_7;
	public $object_vote_sum_8;
	public $object_vote_count_8;
	public $object_vote_average_8;
	public $object_vote_sum_9;
	public $object_vote_count_9;
	public $object_vote_average_9;
	public $object_archive_date = '2038-01-01 00:00:00';
	public $object_publish_date = '2012-01-01 00:00:00';
	public $object_owner_content_admin_id;
	public $object_owner_content_admin_group_id;
	public $object_publisher_content_admin_group_id;
	public $object_permission_browse_children;
	public $object_permission_add_children;
	public $object_permission_edit;
	public $object_permission_delete;
	public $object_custom_rgb_1;
	public $object_custom_rgb_2;
	public $object_custom_rgb_3;
	public $object_custom_rgb_4;
	public $object_custom_rgb_5;
	public $object_custom_rgb_6;
	public $object_custom_rgb_7;
	public $object_custom_rgb_8;
	public $object_custom_rgb_9;
	public $object_global_order_id;
	public $object_id_clone_from = null;
	public $object_xml = null;
	public $object_json = null;
	
	/* @var $object_lang_data cmObjectLangInfo */
	public $object_lang_data = array();
}

/**
 * The META means data not stored in db directly
 */
class cmObjectMetaInfo {
	
}

class cmObjectLangDataInfo {
	
}