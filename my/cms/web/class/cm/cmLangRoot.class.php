<?php

/**
 * @property cmSite $cmSite
 * @property cmLangRootInfo $_cmObjectInfo
 * @method cmLangRootInfo getCmInfo()
 */
class cmLangRoot extends cmObject {

	function __construct($langRootID, cmLangRootInfo $cmLangRootInfo = null, cmSite $cmSite) {
		parent::__construct($langRootID, $cmSite);
		$this->_cmObjectInfo = $cmLangRootInfo;
	}
	
	/**
	 * 
	 * @param int $LangID
	 * @param cmSite $cmSite
	 * @return \cmLangRoot
	 */
	public static function getCmLangRootByLangID($LangID, cmSite $cmSite) {
		$query =	"	SELECT		* " .
					"	FROM		language_root R " .
					"		JOIN	object O ON (O.object_id = R.language_root_id AND O.site_id = '" . $cmSite->site_id . "' ) " .
					"		JOIN	language L ON (R.language_id = L.language_id AND L.language_id = '" . intval($LangID) . "' )  ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		/* @var $cmLangRootInfo cmLangRootInfo */
		$cmLangRootInfo = $result->fetch_object('cmLangRootInfo');
		
		if ($cmLangRootInfo === null)
			return null;
		else {
			$cmLangRoot = new cmLangRoot($cmLangRootInfo->language_root_id, $cmLangRootInfo);
			return $cmLangRoot;
		}
	}

	protected function loadCmInfoFromDB() {
		$query =	"	SELECT		* " .
					"	FROM		language_root R " .
					"		JOIN	language L ON (R.language_id = L.language_id AND R.language_root_id = '" . $this->object_id . "')  " .
					"		JOIN	object O ON (O.object_id = R.language_root_id) ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$this->_cmObjectInfo = $result->fetch_object('cmLangRootInfo');
	}
	
	protected function loadLangInfoFromDB() {}
	
	protected function updateCmMetaInfoFromDB() {}
	
	public static function newCmLangRootToDB($LangID, cmSite $cmSite, &$ErrorMsg) {
		if (cmLangInfo::getLangInfo($LangID) == null) {
			$ErrorMsg = "Invalid language_id";
			return false;
		}
		
		if (self::getCmLangRootByLangID($LangID) != null) {
			$ErrorMsg = "Language has already been added to site.";
			return false;
		}
		
		$newLangRootID = cmObject::newCmObjectToDB('LANGUAGE_ROOT');
		
		$query =	"	INSERT INTO language_root SET " .
					"		cm_site_id = '" . $cmSite->site_id . "', " .
					"		language_root_id = '" . intval($newLangRootID) . "', " .
					"		language_id = '" . intval($LangID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$cmLangRoot = new cmLangRoot($newLangRootID, null, $cmSite);
		
		cmObjectLink::newObjectLinkToDB($cmSite, $cmSite->getCmInfo()->site_root_id, $newLangRootID, $cmLangRoot->getCmInfo()->language_native, $cmLangRoot->getCmInfo()->language_id, 'normal', DEFAULT_ORDER_ID, 'Y', 'N', 0, 1);
		
		cmObjectLink::tidyUpObjectOrder($cmSite->getCmInfo()->site_root_id, 'ANY');
		
		$cmSite->emptyApiCache();
		
		return $cmLangRoot;
	}
	
	public function saveCmInfoToDB() {
		parent::saveCmInfoToDB();
		
		$query =	"	UPDATE language_root SET " .
					"		cm_site_id = '" . $this->cmSite->site_id . "', " . 
					"		language_root_id = '" . intval($this->getCmInfo()->language_root_id) . "', " .
					"		language_id = '" . intval($this->getCmInfo()->language_id) . "', " .
					"		index_link_id = '" . intval($this->getCmInfo()->index_link_id) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

class cmLangRootInfo extends cmObjectInfo {
	public $cm_site_id;
	public $language_id;
	public $language_shortname;
	public $language_longname;
	public $language_native;
	public $paydollar_code;
	public $language_root_id;
	public $index_link_id;
}

