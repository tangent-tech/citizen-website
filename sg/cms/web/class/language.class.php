<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class language {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function SetCurrentLanguage($LangID) {
		setcookie('LangID', $LangID, time()+60*60*24*365, '/');
		$_COOKIE['LangID'] = $LangID;
		$_SESSION['LangID'] = $LangID;
	}

	public static function GetCurrentLanguage() {			
		if (isset($_COOKIE['LangID']))
			$_SESSION['LangID'] = $_COOKIE['LangID'];

		if (!language::IsValidLanguageID($_SESSION['LangID'])) {
			if (isset($_COOKIE['LangID']))
				$_SESSION['LangID'] = $_COOKIE['LangID'];
			else
				language::SetCurrentLanguage(1);
		}
		if ($_SESSION['LangID'] != 1 && $_SESSION['LangID'] != 2) {
			$_SESSION['LangID'] = 1;
		}
		return language::GetLanguageInfo($_SESSION['LangID']);
//			return language::GetLanguageInfo(1);
	}

	public static function GetAllLanguageList() {
		$query =	"	SELECT	* " .
					"	FROM 	language " .
					"	ORDER BY language_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$Language = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($Language, $myResult);
		}
		return $Language;
	}

	public static function GetAllLanguageOption() {
		$query =	"	SELECT	* " .
					"	FROM 	language " .
					"	ORDER BY language_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$Language = array();
		while ($myResult = $result->fetch_assoc()) {
			$Language[$myResult['language_id']] = $myResult['language_longname'];
		}
		return $Language;
	}

	public static function GetLanguageInfo($LangID) {
		$query =	"	SELECT	* " .
					"	FROM	language " .
					"	WHERE	language_id  = '" . intval($LangID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function CopyLanguageTree($SrcSiteLanguageRoot, $DstSiteLanguageRoot, $SrcSite, $DstSite = null) {
		if ($DstSite == null)
			$DstSite = $SrcSite;

		// Get Dest 1st level nodes and set their order id to negative (make sure the will be on top)
		global $APIFolderTreeObjectTypeList;
		$ChildObjects = site::GetAllChildObjects($APIFolderTreeObjectTypeList, $DstSiteLanguageRoot['language_root_id'], 99999999, 'ALL', 'ALL', false, false);

		$TheOrder = -999999;
		foreach ($ChildObjects as $O) {
			$query	=	"	UPDATE	object_link " .
						"	SET		order_id = '". $TheOrder++ . "'" .
						"	WHERE	object_link_id = '" . $O['object_link_id'] . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		// Start cloning
		$ChildObjects = site::GetAllChildObjects($APIFolderTreeObjectTypeList, $SrcSiteLanguageRoot['language_root_id'], 99999999, 'ALL', 'ALL', false, false);
		foreach ($ChildObjects as $O) {
			$NewChildObjectID = 0;
			$NewChildObjectLinkID = 0;

			if ($O['object_type'] == 'FOLDER') {
				$TheFolder = folder::GetFolderDetails($O['object_id']);
				folder::CloneFolder($TheFolder, $SrcSite, $DstSiteLanguageRoot['language_root_id'], $DstSiteLanguageRoot['language_id'], $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite);
			}
			elseif ($O['object_type'] == 'PAGE') {
				$NoOfPages = page::GetNoOfPage($DstSite['site_id']);
				if ($NoOfPages >= $DstSite['site_module_article_quota'])
					return;
				$Page = page::GetPageInfo($O['object_id']);
				page::ClonePage($Page, $SrcSite, $DstSiteLanguageRoot['language_root_id'], $DstSiteLanguageRoot['language_id'], $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite);
			}
			elseif ($O['object_type'] == 'LINK') {
				$Link = link::GetLinkInfo($O['object_id']);
				link::CloneLink($Link, $SrcSite, $DstSiteLanguageRoot['language_root_id'], $DstSiteLanguageRoot['language_id'], $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite);
			}
			elseif ($O['object_type'] == 'NEWS_PAGE') {
				$NewsPage = news::GetNewsPageInfo($O['object_id']);
				news::CloneNewsPage($NewsPage, $SrcSite, $DstSiteLanguageRoot['language_root_id'], $DstSiteLanguageRoot['language_id'], $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite);
			}
			elseif ($O['object_type'] == 'LAYOUT_NEWS_PAGE') {
				$LayoutNewsPage = layout_news::GetLayoutNewsPageInfo($O['object_id']);
				layout_news::CloneLayoutNewsPage($LayoutNewsPage, $SrcSite, $DstSiteLanguageRoot['language_root_id'], $DstSiteLanguageRoot['language_id'], $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite);
			}
			elseif ($O['object_type'] == 'PRODUCT_ROOT_LINK') {
				$ProductRootLink = product::GetProductRootLink($O['object_link_id']);
				product::CloneProductRootLink($ProductRootLink, $SrcSite, $DstSiteLanguageRoot['language_root_id'], $DstSiteLanguageRoot['language_id'], $NewChildObjectID, $NewChildObjectLinkID, 'N', 'N', $DstSite);
			}
			elseif ($O['object_type'] == 'ALBUM') {
				$DstObject = $O;
				if ($DstSite['site_id'] != $SrcSite['site_id']) {

					$DstAlbumObjID = object::GetNewObjectIDFromOriginalCloneFromID($O['object_id'], $DstSite['site_id'], false);

					if ($DstAlbumObjID !== false) {
						$DstObject = object::GetObjectInfo($DstAlbumObjID);
						object::CloneObjectLink($DstObject, $SrcSite, $NewObjectID, $DstLanguageID, $NewChildObjectLinkID, 'N', 'N');							
					}
				}
				else
					object::CloneObjectLink($DstObject, $SrcSite, $NewObjectID, $DstLanguageID, $NewChildObjectLinkID, 'N', 'N');
			}
		}

		object::TidyUpObjectOrder($DstSiteLanguageRoot['language_root_id'], 'ANY');

		if ($DstSite['site_id'] != $SrcSite['site_id']) {
			$SrcIndexLinkInfo = object::GetObjectLinkInfo($SrcSiteLanguageRoot['index_link_id']);
			$DstLanguageRootIndexLinkID = object::GetNewObjectIDFromOriginalCloneFromID($SrcIndexLinkInfo['object_id'], $DstSite['site_id'], false);
			if ($DstLanguageRootIndexLinkID !== false) {
				$DstIndexLinkInfo = object::GetObjectInfo($DstLanguageRootIndexLinkID);

				$query =	"	UPDATE	language_root " .
							"	SET 	index_link_id = '" . intval($DstIndexLinkInfo['object_link_id']) . "'" .
							"	WHERE	language_root_id = '" . intval($DstSiteLanguageRoot['language_root_id']) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
		}
	}

	public static function IsValidLanguageID($LanguageID) {
		$query =	"	SELECT	* " .
					"	FROM 	language " .
					"	WHERE	language_id = '" . intval($LanguageID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		return ($result->num_rows > 0);
	}

	public static function GetSiteLanguageRoot($LanguageID, $SiteID) {
		$query =	"	SELECT	* " .
					"	FROM 	language_root R JOIN object O ON (R.language_root_id = O.object_id) " .
					"							JOIN language L ON (L.language_id = R.language_id) " .
					"							JOIN object_link OL ON (OL.object_id = O.object_id) " .
					"	WHERE	R.language_id = '" . intval($LanguageID) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetSiteLanguageRootByLanguageRootID($LanguageRootID, $SiteID) {
		$query =	"	SELECT	* " .
					"	FROM 	language_root R JOIN object O ON (R.language_root_id = O.object_id) " .
					"							JOIN language L ON (L.language_id = R.language_id) " .
					"							JOIN object_link OL ON (OL.object_id = O.object_id) " .
					"	WHERE	R.language_root_id = '" . intval($LanguageRootID) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetAllSiteLanguageRoot($SiteID, $IsRemoved = 'ALL', $IsEnable = 'ALL') {
		$sql = '';
		if ($IsEnable != 'ALL')
			$sql .= " AND O.object_is_enable = '" . aveEscT($IsEnable) . "'";
		if ($IsRemoved != 'ALL')
			$sql .= " AND O.is_removed = '" . aveEscT($IsRemoved) . "'";

		$query =	"	SELECT	* " .
					"	FROM 	language_root R JOIN object O ON (R.language_root_id = O.object_id) " .
					"							JOIN language L ON (L.language_id = R.language_id) " .
					"	WHERE	O.site_id = '" . intval($SiteID) . "'" . $sql .
					"	ORDER BY R.language_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$LanguageRoot = array();
		while ($myResult = $result->fetch_assoc())
			array_push($LanguageRoot, $myResult);
		return $LanguageRoot;
	}

	public static function GetAllLanguageWithNoSiteLanguageRootList($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM 	language L " .
					"	WHERE	L.language_id NOT IN ( " .
					"		SELECT 	R.language_id " .
					"		FROM 	language_root R JOIN object O ON (R.language_root_id = O.object_id) " .
					"		WHERE	O.site_id = '" . intval($SiteID) . "'" .
					"	)" .
					"	ORDER BY L.language_id ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Language = array();
		while ($myResult = $result->fetch_assoc())
			array_push($Language, $myResult);
		return $Language;
	}

	public static function GetSiteLanguageRootXML($LanguageID, $SiteID) {
		$smarty = new mySmarty();
		$SiteLanguageRoot = language::GetSiteLanguageRoot($LanguageID, $SiteID);
		if ($SiteLanguageRoot != null) {
			$smarty->assign('Object', $SiteLanguageRoot);
			$SiteLanguageRootXML = $smarty->fetch('api/object_info/LANGUAGE_ROOT.tpl');
			return $SiteLanguageRootXML;
		}
		else
			return '';
	}

	public static function GetAllSiteLanguageRootXML($SiteID) {
		$smarty = new mySmarty();
		$LanguageRootList = language::GetAllSiteLanguageRoot($SiteID, 'N', 'Y');
		$AllSiteLanguageRootXML = '';
		foreach ($LanguageRootList as $R) {
//				$smarty->clearAllAssign();
			$smarty->assign('Object', $R);
			$AllSiteLanguageRootXML .= $smarty->fetch('api/object_info/LANGUAGE_ROOT.tpl');
		}
		$AllSiteLanguageRootXML = '<language_root_list>' . $AllSiteLanguageRootXML . '</language_root_list>';
		return $AllSiteLanguageRootXML;
	}

	public static function DeleteSiteLanguageRoot($ObjectID, $SiteID) {
		$SiteLanguageRoot = language::GetSiteLanguageRootByLanguageRootID($ObjectID, $SiteID);

		$LayoutNewsRootList = layout_news::GetLayoutNewsRootList($SiteLanguageRoot['language_id'], $SiteID);
		foreach ($LayoutNewsRootList as $L)
			layout_news::DeleteLayoutNewsRoot($L['layout_news_root_id'], $Site);

		$NewsRootList = news::GetNewsRootList($SiteLanguageRoot['language_id'], $SiteID);
		foreach ($NewsRootList as $L)
			news::DeleteNewsRoot($L['news_root_id'], $Site);

		$query =	"	DELETE	C, O " .
					"	FROM 	news_category C	JOIN	object O	ON (C.news_category_id = O.object_id) " .
					"	WHERE	C.language_id = '" . intval($SiteLanguageRoot['language_id']) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE	D " .
					"	FROM 	album_data D JOIN object O ON (D.album_id = O.object_id) " .
					"	WHERE	D.language_id = '" . intval($SiteLanguageRoot['language_id']) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE	D " .
					"	FROM 	bonus_point_item_data D JOIN object O ON (D.bonus_point_item_id = O.object_id) " .
					"	WHERE	D.language_id = '" . intval($SiteLanguageRoot['language_id']) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE	D " .
					"	FROM 	media_data D JOIN object O ON (D.media_id = O.object_id) " .
					"	WHERE	D.language_id = '" . intval($SiteLanguageRoot['language_id']) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE	D " .
					"	FROM 	product_category_data D JOIN object O ON (D.product_category_id = O.object_id) " .
					"	WHERE	D.language_id = '" . intval($SiteLanguageRoot['language_id']) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE	D " .
					"	FROM 	product_category_special_data D JOIN object O ON (D.product_category_special_id = O.object_id) " .
					"	WHERE	D.language_id = '" . intval($SiteLanguageRoot['language_id']) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE	D " .
					"	FROM 	product_data D JOIN object O ON (D.product_id = O.object_id) " .
					"	WHERE	D.language_id = '" . intval($SiteLanguageRoot['language_id']) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE	L, O " .
					"	FROM 	language_root L	JOIN	object O	ON (L.language_root_id = O.object_id) " .
					"	WHERE	O.object_id	= '" . intval($SiteLanguageRoot['language_root_id']) . "'" .
					"		AND	O.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}