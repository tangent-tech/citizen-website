<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class site {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetSiteInfoByAppSecret($SiteID, $AppSecret) {
		$query	=	"	SELECT	* " .
					"	FROM	site " .
					"	WHERE	site_rich_secret_key = '" . aveEscT($AppSecret) . "'" .
					"		AND	site_id = '" . intval($SiteID) . "'" .
					"		AND	site_is_enable = 'Y' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = null;
		if ($result->num_rows > 0) {			
			$myResult = $result->fetch_assoc();
			$myResult['HttpRootURL'] 		= 'http://' . $myResult['site_address'];
			$myResult['HttpFilebaseURL'] 	= 'http://' . $myResult['site_address'] . $myResult['site_http_userfile_path'] . "/";
			$myResult['FtpRootPath']		= 'ftp://' . $myResult['site_ftp_username'] . ':' . site::MyDecrypt($myResult['site_ftp_password']) . '@' . $myResult['site_address'] . '/';
			$myResult['FtpUserfilePath']	= substr($myResult['FtpRootPath'], 0, -1) . $myResult['site_ftp_userfile_dir'] . '/';
			$myResult['FtpFilebasePath']	= substr($myResult['FtpRootPath'], 0, -1) . $myResult['site_ftp_filebase_dir'] . '/';
		}
		return $myResult;
	}		

	public static function GetSiteInfoByAPI($ApiLogin, $ApiKey) {
		$query	=	"	SELECT	* " .
					"	FROM	site " .
					"	WHERE	site_api_login = '" . aveEscT($ApiLogin) . "'" .
					"		AND	site_api_key = '" . aveEscT($ApiKey) . "'" .
					"		AND	site_is_enable = 'Y' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = null;
		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			$myResult['HttpRootURL'] 		= 'http://' . $myResult['site_address'];
			$myResult['HttpFilebaseURL'] 	= 'http://' . $myResult['site_address'] . $myResult['site_http_userfile_path'] . "/";
			$myResult['FtpRootPath']		= 'ftp://' . $myResult['site_ftp_username'] . ':' . site::MyDecrypt($myResult['site_ftp_password']) . '@' . $myResult['site_address'] . '/';
			$myResult['FtpUserfilePath']	= substr($myResult['FtpRootPath'], 0, -1) . $myResult['site_ftp_userfile_dir'] . '/';
			$myResult['FtpFilebasePath']	= substr($myResult['FtpRootPath'], 0, -1) . $myResult['site_ftp_filebase_dir'] . '/';
		}
		return $myResult;
	}

	public static function GetSiteInfo($SiteID) {
		$query	=	"	SELECT	*, S.*, C.* " .
					"	FROM	site S	LEFT JOIN	currency C ON (S.site_default_currency_id = C.currency_id)	" .
					"					LEFT JOIN	currency_site_enable CS ON (CS.currency_id = C.currency_id) " .
					"	WHERE	S.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = null;
		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			$myResult['HttpRootURL'] 		= 'http://' . $myResult['site_address'];
			$myResult['HttpFilebaseURL'] 	= 'http://' . $myResult['site_address'] . $myResult['site_http_userfile_path'] . "/";
			$myResult['FtpRootPath']		= 'ftp://' . $myResult['site_ftp_username'] . ':' . site::MyDecrypt($myResult['site_ftp_password']) . '@' . $myResult['site_ftp_address'] . '/';
			$myResult['FtpWebPath']			= substr($myResult['FtpRootPath'], 0, -1) . $myResult['site_ftp_web_dir'] . '/';
			$myResult['FtpUserfilePath']	= substr($myResult['FtpRootPath'], 0, -1) . $myResult['site_ftp_userfile_dir'] . '/';
			$myResult['FtpFilebasePath']	= substr($myResult['FtpRootPath'], 0, -1) . $myResult['site_ftp_filebase_dir'] . '/';
		}
		return $myResult;
	}

	public static function GetAllSiteList($IsEnable = 'ALL') {
		$sql = '';
		if ($IsEnable != 'ALL')
			$sql = " AND S.site_is_enable = '" . aveEscT($IsEnable) . "'";

		$query =	"	SELECT	* " .
					"	FROM	site S" .
					"	WHERE	1 = 1 " . $sql .
					"	ORDER BY S.site_name ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$Sites = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($Sites, $myResult);
		}
		return $Sites;
	}

	public static function IsValidSiteID($SiteID) {
		$query	=	"	SELECT	* " .
					"	FROM	site " .
					"	WHERE	site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		return ($result->num_rows > 0);
	}

	public static function ConnectionTest($SiteID) {
		$TestResult = array(
						'Web'		=> array('read' => false, 'write' => false),
						'Userfile'	=> array('read' => false, 'write' => false),
						'Filebase'	=> array('read' => false, 'write' => false),
						'WebAddressMatch' => false,
						'HttpAddressMatch' => false,
						'FtpLogin'	=> false
						);
		$Site = site::GetSiteInfo($SiteID);

		$HttpStreamOptions = array('http' => array('method' => 'GET'));
		$HttpStreamContext = stream_context_create($HttpStreamOptions);

		$FtpStreamOptions = array('ftp' => array('overwrite' => true));
		$FtpStreamContext = stream_context_create($FtpStreamOptions);
		$conn_id = ftp_connect($Site['site_ftp_address']);
		if ($login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password'])))
			$TestResult['FtpLogin'] = true;
		else
			return $TestResult;
		// Try to make directory first

		if ($Site['site_ftp_need_passive'] == 'Y')
			ftp_pasv($conn_id, true);
		else
			ftp_pasv($conn_id, false);			

		@ftp_mkdir($conn_id, $Site['site_ftp_web_dir']);
		@ftp_mkdir($conn_id, $Site['site_ftp_userfile_dir']);
		@ftp_mkdir($conn_id, $Site['site_ftp_filebase_dir']);

		$TmpTestFile = tempnam("/tmp", "TmpTestFile");
		$TmpWebTestFile = tempnam("/tmp", "TmpWebTestFile");
		$TmpDownloadFile = tempnam("/tmp", "TmpTestFile");
		$TestFileContent = md5(rand(0, 999999));
		$TestWebFileContent = md5(rand(0, 999999) . '323052905j');
		file_put_contents($TmpTestFile, $TestFileContent);
		file_put_contents($TmpWebTestFile, $TestWebFileContent);

		if (@ftp_put($conn_id, $Site['site_ftp_web_dir'] . "/" . FTP_TEST_FILENAME, $TmpTestFile, FTP_BINARY, 0))
			$TestResult['Web']['write'] = true;
		if (@ftp_put($conn_id, $Site['site_ftp_userfile_dir'] . "/" . FTP_TEST_FILENAME, $TmpWebTestFile, FTP_BINARY, 0))
			$TestResult['Userfile']['write'] = true;
		if (@ftp_put($conn_id, $Site['site_ftp_filebase_dir'] . "/" . FTP_TEST_FILENAME, $TmpTestFile, FTP_BINARY, 0))
			$TestResult['Filebase']['write'] = true;

		@ftp_get($conn_id, $TmpDownloadFile, $Site['site_ftp_web_dir'] . "/" . FTP_TEST_FILENAME, FTP_BINARY, 0);
		if (file_get_contents($TmpTestFile) == file_get_contents($TmpDownloadFile))
			$TestResult['Web']['read'] = true;
		@ftp_get($conn_id, $TmpDownloadFile, $Site['site_ftp_userfile_dir'] . "/" . FTP_TEST_FILENAME, FTP_BINARY, 0);
		if (file_get_contents($TmpWebTestFile) == file_get_contents($TmpDownloadFile))
			$TestResult['Userfile']['read'] = true;
		@ftp_get($conn_id, $TmpDownloadFile, $Site['site_ftp_filebase_dir'] . "/" . FTP_TEST_FILENAME, FTP_BINARY, 0);
		if (file_get_contents($TmpTestFile) == file_get_contents($TmpDownloadFile))
			$TestResult['Filebase']['read'] = true;

		if (@file_get_contents($Site['HttpFilebaseURL'] . "/" . FTP_TEST_FILENAME, null, $HttpStreamContext) == $TestWebFileContent)
			$TestResult['HttpAddressMatch'] = true;
//			@ftp_get($conn_id, $TmpDownloadFile, $Site['site_ftp_web_dir'] . "/" . FTP_TEST_FILENAME, FTP_BINARY, 0);
//			if (@file_get_contents($Site['FtpWebPath'] . FTP_TEST_FILENAME, null, $HttpStreamContext) == file_get_contents($TmpDownloadFile))
		if (@file_get_contents($Site['HttpRootURL'] . "/" . FTP_TEST_FILENAME, null, $HttpStreamContext) == $TestFileContent)
			$TestResult['WebAddressMatch'] = true;

		@ftp_delete($conn_id, $Site['site_ftp_web_dir'] . FTP_TEST_FILENAME);
		@ftp_delete($conn_id, $Site['site_ftp_userfile_dir'] . FTP_TEST_FILENAME);
		@ftp_delete($conn_id, $Site['site_ftp_filebase_dir'] . FTP_TEST_FILENAME);
		@unlink($TmpTestFile);
		@unlink($TmpDownloadFile);

		return $TestResult;
	}

	public static function MyEncrypt($data) {
		return base64_encode(mcrypt_encrypt(MCRYPT_BLOWFISH, "39gh92hh", $data, MCRYPT_MODE_CBC, 'baid93h2'));
	}

	public static function MyDecrypt($data) {
		return rtrim(mcrypt_decrypt(MCRYPT_BLOWFISH, "39gh92hh", base64_decode($data), MCRYPT_MODE_CBC, 'baid93h2'), "\0\4");
	}

	public static function GetAllChildObjects($ValidObjectList, $ParentObjectID, $SecurityLevel = 0, $IsEnable = 'ALL', $IsRemoved = 'ALL', $HonorArchiveDate = false, $HonorPublishDate = false, $ExcludeShadowObjectLink = true) {
		$Object = object::GetObjectInfo($ParentObjectID);

		$sql = '';
		if ($IsEnable != 'ALL')
			$sql = " AND O.object_is_enable = '" . aveEscT($IsEnable) . "' AND L.object_link_is_enable = '" . aveEscT($IsEnable) . "'";
		if ($IsRemoved != 'ALL')
			$sql = $sql . " AND O.is_removed = '" . aveEscT($IsRemoved) . "'";
		if ($HonorArchiveDate)
			$sql = $sql . "	AND	O.object_archive_date > NOW() ";
		if ($HonorPublishDate)
			$sql = $sql . "	AND	O.object_publish_date < NOW() ";

		if ($Object['object_type'] == 'NEWS_ROOT') {
			$query	=	"	SELECT		O.* " .
						"	FROM		news N	JOIN	object O	ON (N.news_id = O.object_id) " .
						"	WHERE		N.news_root_id		=	'" . intval($ParentObjectID) . "'" .
						"			AND	O.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql;
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else if ($Object['object_type'] == 'LAYOUT_NEWS_ROOT') {
			$query	=	"	SELECT		O.* " .
						"	FROM		layout_news N	JOIN	object O	ON (N.layout_news_id = O.object_id) " .
						"	WHERE		N.layout_news_root_id	=	'" . intval($ParentObjectID) . "'" .
						"			AND	O.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql;
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else if ($Object['object_type'] == 'USER_ROOT') {
			$query	=	"	SELECT		O.* " .
						"	FROM		user_datafile_holder H	JOIN	object O	ON (H.user_datafile_holder_id = O.object_id) " .
						"	WHERE		O.site_id	=	'" . intval($Object['site_id']) . "'" .
						"			AND	O.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql;
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}			
		else {
			if ($ExcludeShadowObjectLink)
				$sql = $sql . " AND L.object_link_is_shadow = 'N' ";				

			$query =	"	SELECT	* " .
						"	FROM	object O JOIN object_link L ON (O.object_id = L.object_id) " .
						"	WHERE	L.parent_object_id = '" . intval($ParentObjectID) . "'" .
						"		AND	O.object_security_level <= '" . intval($SecurityLevel) . "'" . $sql .
						"	ORDER BY L.order_id ASC ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		$Objects = array();
		while ($myResult = $result->fetch_assoc()) {
			if (in_array($myResult['object_type'], $ValidObjectList))
				array_push($Objects, $myResult);
		}
		return $Objects;
	}

	public static function GetAllChildObjectsForAPI($ValidObjectList, $ParentObjectID, $LanguageID, $SecurityLevel = 0, $IsEnable = 'ALL', $IsRemoved = 'ALL') {
		$sql = '';
		if ($IsEnable != 'ALL')
			$sql = " AND O.object_is_enable = '" . aveEscT($IsEnable) . "' AND L.object_link_is_enable = '" . aveEscT($IsEnable) . "'";
		if ($IsRemoved != 'ALL')
			$sql = $sql . " AND O.is_removed = '" . aveEscT($IsRemoved) . "'";

		$query =	"	SELECT	*, O.*, PD.object_friendly_url AS p_url, CD.object_friendly_url AS pc_url " .
					"	FROM	object O 	JOIN 		object_link L ON (O.object_id = L.object_id AND L.object_link_is_shadow = 'N') " .
					"						LEFT JOIN	product_category_data CD	ON (O.object_id = CD.product_category_id AND CD.language_id = '" . intval($LanguageID) . "') " .
					"						LEFT JOIN	product_data PD				ON (O.object_id = PD.product_id AND PD.language_id = '" . intval($LanguageID) . "') " .
//						"						LEFT JOIN	product_category C			ON (O.object_id = C.product_category_id) " .
					"	WHERE	L.parent_object_id = '" . intval($ParentObjectID) . "'" .
					"		AND	O.object_security_level <= '" . intval($SecurityLevel) . "'" . 
					"		AND	O.object_archive_date > NOW() " . 
					"		AND	O.object_publish_date < NOW() " . $sql . 
					"	ORDER BY L.order_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$Objects = array();
		while ($myResult = $result->fetch_assoc()) {
			if (in_array($myResult['object_type'], $ValidObjectList)) {
				if ($myResult['object_type'] == 'PRODUCT')
					$myResult['object_friendly_url'] = $myResult['p_url'];
				else if ($myResult['object_type'] == 'PRODUCT_CATEGORY')
					$myResult['object_friendly_url'] = $myResult['pc_url'];

				array_push($Objects, $myResult);
			}
		}
		return $Objects;
	}

	public static function GetSiteTreeForMyAdmin(&$XHTML, $ValidObjectList, $ParentObjectID, $SecurityLevel = 0, $IsEnable = 'ALL', $IsRemoved = 'ALL', $ExcludeShadowObjectLink = true) {
		global $Site;

		$Objects = site::GetAllChildObjects($ValidObjectList, $ParentObjectID, $SecurityLevel, $IsEnable, $IsRemoved, false, false, $ExcludeShadowObjectLink);
		if (count($Objects) <= 0)
			return false;
		else {
			$XHTML .= '<ul>';
			foreach($Objects as $Obj) {
				$EnableText = '';
				if (!in_array($Obj['object_type'], $GLOBALS['AlwaysEnableObjectTypeList'])) {
					$EnableText = 'ENABLE_';
					if ($Obj['object_link_is_enable'] == 'N')
						$EnableText = 'DISABLE_';
				}

				if ($Obj['object_type'] == 'PRODUCT_ROOT_SPECIAL')
					$Obj['object_name'] = 'Special ' . $Site['site_label_product']. ' Categories';

				if ($Obj['object_type'] == 'PRODUCT_CATEGORY') {
					$ProductCat = product::GetProductCatInfo($Obj['object_id'], 0);

					if ($ProductCat['product_category_is_product_group'] == 'Y')
						$Obj['object_type'] = 'PRODUCT_GROUP';
				}				
				// I orginally use jquery.data() to store the value but later found that there is no data selector available (plugin available but not official).
				// Then I found that the html5 draft purpose data-* to use for data storage. So, why not? Much more elegant!
				$DataField = 'data-object_type="' . $Obj['object_type'] . '" data-object_link_id="' . $Obj['object_link_id'] . '" data-object_id="' . $Obj['object_id'] . '" data-object_system_flag="' . $Obj['object_system_flag'] . '"';

				$XHTML = $XHTML . '<li ' . $DataField . ' rel="' . $EnableText . $Obj['object_type'] . '" id="OL_' . $Obj['object_link_id'] . '"><a href="#"><ins>&nbsp;</ins>' . htmlentities($Obj['object_name'], ENT_QUOTES, 'UTF-8') . '</a>';

				site::GetSiteTreeForMyAdmin($XHTML, $ValidObjectList, $Obj['object_id'], $SecurityLevel, $IsEnable, $IsRemoved, $ExcludeShadowObjectLink);
				$XHTML .= "</li>";
			}
			$XHTML .= '</ul>';
			return true;
		}
	}

	public static function GenerateStaticPages($Site, $FtpConnID, $ValidObjectList, $ParentObjectID, $SecurityLevel = 0, $IsEnable = 'ALL', $IsRemoved = 'ALL', &$Counter) {
		$Objects = site::GetAllChildObjects($ValidObjectList, $ParentObjectID, $SecurityLevel, $IsEnable, $IsRemoved);
		if (count($Objects) <= 0)
			return false;
		else {
			foreach($Objects as $Obj) {
				$Counter++;

				if ($Counter % 50 == 0) {
					$query =	"	UPDATE	site " .
								"	SET		site_generate_link_no_of_files	= '" . intval($Counter) . "', " .
								"			site_generate_datetime			= NOW() " .
								"	WHERE	site_id = '" . $Site['site_id'] . "'";
					$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
				}

				if (!($Site['site_sitemap_ignore_folder'] == 'Y' && $Obj['object_type'] == 'FOLDER')) {
					// Get File And Write Here
					$url = 'http://' . $Site['site_address'] . '/load.php?link_id=' . $Obj['object_link_id'] . '&lang_id=' . $Obj['language_id'];
					$StaticPage = file_get_contents($url);
					$StaticPage = site::HTMLDynamicToStaticLink($Site, $StaticPage, $url);

					$TmpFileName = tempnam("/tmp", "FOO");
					$FP = fopen($TmpFileName, "w");
					fwrite($FP, $StaticPage);
					fclose($FP);

					if (strlen(trim($Obj['object_friendly_url'])) == 0)
						$Obj['object_friendly_url'] = 'page';
					$href = ConvertToHyphen($Obj['object_friendly_url']) . '-' . $Obj['object_link_id'] . '.html';
					$Filename = $Site['site_ftp_static_link_dir'] . '/' . $href;

					$upload_result = @ftp_put($FtpConnID, $Filename, $TmpFileName, FTP_BINARY, 0);
					unlink($TmpFileName);
				}


				site::GenerateStaticPages($Site, $FtpConnID, $ValidObjectList, $Obj['object_id'], $SecurityLevel, $IsEnable, $IsRemoved, $Counter);
			}
			return true;
		}
	}

	public static function GenerateStaticNews($Site, $FtpConnID, $LangID, &$Counter) {
		$NewsRoots = news::GetNewsRootList($LangID, $Site['site_id']);
		foreach ($NewsRoots as $NR) {
			$News = news::GetNewsListByNewsRootID($NR['news_root_id'], 0, 999999);
			foreach ($News as $Obj) {
				$Counter++;

				if ($Counter % 50 == 0) {
					$query =	"	UPDATE	site " .
								"	SET		site_generate_link_no_of_files	= '" . intval($Counter) . "', " .
								"			site_generate_datetime			= NOW() " .
								"	WHERE	site_id = '" . $Site['site_id'] . "'";
					$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
				}

				// Get File And Write Here
				$url = 'http://' . $Site['site_address'] . '/load_news.php?id=' . $Obj['object_id'] . '&lang_id=' . $Obj['language_id'];
				$StaticPage = file_get_contents($url);
				$StaticPage = site::HTMLDynamicToStaticLink($Site, $StaticPage, $url);

				$TmpFileName = tempnam("/tmp", "FOO");
				$FP = fopen($TmpFileName, "w");
				fwrite($FP, $StaticPage);
				fclose($FP);

				if (strlen(trim($Obj['object_friendly_url'])) == 0)
					$Obj['object_friendly_url'] = 'press-release';
				$href = ConvertToHyphen($Obj['object_friendly_url']) . '-news-' . $Obj['object_id'] . '.html';
				$Filename = $Site['site_ftp_static_link_dir'] . '/' . $href;

				$upload_result = @ftp_put($FtpConnID, $Filename, $TmpFileName, FTP_BINARY, 0);
				unlink($TmpFileName);
			}
		}
	}

	public static function GenerateStaticFiles($SiteID) {
		global $SiteGenerateStaticPagesObjectTypeList;

		$Site = site::GetSiteInfo($SiteID);
		$SiteLanguageRoots = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');

		$Counter = 0;
		$conn_id = ftp_connect($Site['site_ftp_address']);
		$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password']));

		if ($Site['site_ftp_need_passive'] == 'Y')
			ftp_pasv($conn_id, true);
		else
			ftp_pasv($conn_id, false);

		foreach ($SiteLanguageRoots as $L) {
		//	$SiteLanguageRoot = language::GetSiteLanguageRoot($_REQUEST['id'], $Site['site_id']);
			if ($L != null) {
				site::GenerateStaticPages($Site, $conn_id, $SiteGenerateStaticPagesObjectTypeList, $L['language_root_id'], 999999, 'ALL', 'N', $Counter);
				site::GenerateStaticNews($Site, $conn_id, $L['language_id'], $Counter);
			}
		}
		ftp_close($conn_id);

		return $Counter;
	}

	public static function HTMLDynamicToStaticLink($Site, $Content, $url) {
		$Doc = new DOMDocument();
		@$Doc->loadHTML($Content);
//			@$Doc->loadXML($Content);

		$Links = $Doc->getElementsByTagName('a');
		foreach ($Links as $L) {
			$href = $L->getAttribute('href');
			$href = site::URLDynamicToStatic($Site, $href, 0, $url);
			$L->setAttribute('href', $href);
		}

		$Options = $Doc->getElementsByTagName('option');
		foreach ($Options as $O) {
			$href = $O->getAttribute('value');
			$href = site::URLDynamicToStatic($Site, $href, 0, $url);
			$O->setAttribute('value', $href);
		}
/*
		$tidy = new tidy();
		$XHTML = @$tidy->repairString($Doc->saveHTML(), array(
												'output-xhtml' => true,
												'drop-paras' => false,
												'join-styles' => false,
												'merge-divs' => false,
												'merge-spans' => false,
												'tidy-mark' => false
											),
										'utf8'
									);
		return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . $XHTML;
*/
		return $Content;
	}

	public static function URLDynamicToStatic($Site, $URL, $Loop, $OrginalURL) {
		if ($Loop >= 5)
			return $URL;

		if (strpos($URL, 'load.php') !== false) {
			$Query = array();
			$URLInfo = parse_url(FullURL($Site, $URL));
			parse_str($URLInfo['query'], $Query);
			$Object = object::GetObjectLinkInfo($Query['link_id']);
			if ($Object['object_type'] == 'LINK') {
				$Link = link::GetLinkInfo($Object['object_id']);
LogFile(TEMP_LOG, $OrginalURL . ":");
LogFile(TEMP_LOG, $URL . " => " . $Link['link_url']);
				return Site::URLDynamicToStatic($Site, $Link['link_url'], ++$Loop, $OrginalURL);
			}
			else {
				if (strlen(trim($Object['object_friendly_url'])) == 0)
					$Object['object_friendly_url'] = 'page';
LogFile(TEMP_LOG, $OrginalURL . ":");
LogFile(TEMP_LOG, $URL . " => " . $Site['site_http_static_link_path'] . '/' . ConvertToHyphen($Object['object_friendly_url']) . '-' . $Object['object_link_id'] . '.html');
				return $Site['site_http_static_link_path'] . '/' . ConvertToHyphen($Object['object_friendly_url']) . '-' . $Object['object_link_id'] . '.html';
			}
		}
		elseif (strpos($URL, 'load_news.php') !== false) {
			$Query = array();
			$URLInfo = parse_url(FullURL($Site, $URL));
			parse_str($URLInfo['query'], $Query);
			$News = news::GetNewsInfo($Query['id']);
			if (strlen(trim($News['object_friendly_url'])) == 0)
				$News['object_friendly_url'] = 'press-release';
LogFile(TEMP_LOG, $OrginalURL . ":");
LogFile(TEMP_LOG, $URL . " => " . $Site['site_http_static_link_path'] . '/' . ConvertToHyphen($News['object_friendly_url']) . '-news-' . $News['news_id'] . '.html');
			return $Site['site_http_static_link_path'] . '/' . ConvertToHyphen($News['object_friendly_url']) . '-news-' . $News['news_id'] . '.html';
		}
		else
			return $URL;
	}

	public static function GenerateStaticSitemap($SiteID, $Filename = 'sitemap.xml') {
		global $SiteGenerateStaticPagesObjectTypeList;
		$smarty = new mySmarty();

		$Site = site::GetSiteInfo($SiteID);
		$SiteLanguageRoots = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');

		$TmpFileName = tempnam("/tmp", "FOO");
		$FP = fopen($TmpFileName, "w");

		$Counter = 0;
		$XHTML = '';
		foreach ($SiteLanguageRoots as $L) {
		//	$SiteLanguageRoot = language::GetSiteLanguageRoot($_REQUEST['id'], $Site['site_id']);
			if ($L != null) {
				site::GenerateStaticSitemapPageURL($Site, $SiteGenerateStaticPagesObjectTypeList, $L['language_root_id'], 0, 'ALL', 'N', $Counter, $XHTML);
				site::GenerateStaticSitemapNewsURL($Site, $L['language_id'], $Counter, $XHTML);
			}
		}
		$smarty->assign('urls', $XHTML);
		$Sitemap = $smarty->fetch('sitemap/sitemap.tpl');

		fwrite($FP, $Sitemap);
		fclose($FP);

		$conn_id = ftp_connect($Site['site_ftp_address']);
		$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password']));

		if ($Site['site_ftp_need_passive'] == 'Y')
			ftp_pasv($conn_id, true);
		else
			ftp_pasv($conn_id, false);

		$Filename = $Site['site_ftp_web_dir'] . '/' . $Filename;
		$upload_result = @ftp_put($conn_id, $Filename, $TmpFileName, FTP_BINARY, 0);
		unlink($TmpFileName);
		ftp_close($conn_id);

		return $Counter;
	}

	public static function GenerateStaticRSS($SiteID, $Filename = 'rss.xml', $NoOfItemLimit = 999999, $UpdateRate = 'hourly') {
		$smarty = new mySmarty();

		$Site = site::GetSiteInfo($SiteID);
		$SiteLanguageRoots = language::GetAllSiteLanguageRoot($Site['site_id'], 'N', 'Y');

		$TmpFileName = tempnam("/tmp", "FOO");
		$FP = fopen($TmpFileName, "w");

		$Counter = 0;
		$XHTML = '';
		foreach ($SiteLanguageRoots as $L) {
		//	$SiteLanguageRoot = language::GetSiteLanguageRoot($_REQUEST['id'], $Site['site_id']);
			if ($L != null) {
				site::GenerateNewsRSSItem($Site, $L['language_id'], $Counter, $XHTML, $NoOfItemLimit);
			}
		}
		$smarty->assign('urls', $XHTML);
		$smarty->assign('UpdateRate', $UpdateRate);
		$RSS = $smarty->fetch('sitemap/rss.tpl');

		fwrite($FP, $RSS);
		fclose($FP);

		$conn_id = ftp_connect($Site['site_ftp_address']);
		$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password']));

		if ($Site['site_ftp_need_passive'] == 'Y')
			ftp_pasv($conn_id, true);
		else
			ftp_pasv($conn_id, false);

		$Filename = $Site['site_ftp_web_dir'] . '/' . $Filename;
		$upload_result = @ftp_put($conn_id, $Filename, $TmpFileName, FTP_BINARY, 0);
		unlink($TmpFileName);
		ftp_close($conn_id);

		return $Counter;
	}

	private static function GenerateStaticSitemapPageURL($Site, $ValidObjectList, $ParentObjectID, $SecurityLevel = 0, $IsEnable = 'ALL', $IsRemoved = 'ALL', &$Counter, &$XHTML) {
		$smarty = new mySmarty();
		$Objects = site::GetAllChildObjects($ValidObjectList, $ParentObjectID, $SecurityLevel, $IsEnable, $IsRemoved, true, true);
		if (count($Objects) <= 0)
			return false;
		else {
			foreach($Objects as $Obj) {
				if (!($Site['site_sitemap_ignore_folder'] == 'Y' && $Obj['object_type'] == 'FOLDER')) {

					$Counter++;

					if ($Counter % 50 == 0) {
					}

					if (strlen(trim($Obj['object_friendly_url'])) == 0)
						$Obj['object_friendly_url'] = 'page';

//						$href = ConvertToHyphen($Obj['object_friendly_url']) . '-' . $Obj['object_link_id'] . '.html';

					// Get File And Write Here
//						$loc = 'http://' . $Site['site_address'] . $Site['site_http_static_link_path'] . '/' . $href;
					$loc = 'http://' . $Site['site_address'] . object::GetSeoEncodedURL($Obj, '', $LangID);
					$smarty->assign('loc', $loc);
					if ($Site['site_sitemap_always_now'] == 'Y')
						$smarty->assign('lastmod', date('Y-m-d'));
					else
						$smarty->assign('lastmod', date('Y-m-d', strtotime($Obj['modify_date'])));
					$XHTML = $XHTML . $smarty->fetch('sitemap/url.tpl');
				}

				site::GenerateStaticSitemapPageURL($Site, $ValidObjectList, $Obj['object_id'], $SecurityLevel, $IsEnable, $IsRemoved, $Counter, $XHTML);
			}
			return true;
		}
	}

	public static function GenerateStaticSitemapNewsURL($Site, $LangID, &$Counter, &$XHTML) {
		$smarty = new mySmarty();
		$NewsRoots = news::GetNewsRootList($LangID, $Site['site_id']);
		foreach ($NewsRoots as $NR) {
			$News = news::GetNewsListByNewsRootID($NR['news_root_id'], $TotalNewsNum, 1, 999999, '', '', '', '', '', true, true, 0);
			foreach ($News as $Obj) {
				$Counter++;

				if ($Counter % 50 == 0) {
				}
				if (strlen(trim($Obj['object_friendly_url'])) == 0)
					$Obj['object_friendly_url'] = 'press-release';
//					$href = ConvertToHyphen($Obj['object_friendly_url']) . '-news-' . $Obj['object_id'] . '.html';

				// Get File And Write Here
				$loc = 'http://' . $Site['site_address'] . object::GetSeoEncodedURL($Obj, '', $LangID);
				$smarty->assign('loc', $loc);
				if ($Site['site_sitemap_always_now'] == 'Y')
					$smarty->assign('lastmod', date('Y-m-d'));
				else
					$smarty->assign('lastmod', date('Y-m-d', strtotime($Obj['modify_date'])));
				$XHTML = $XHTML . $smarty->fetch('sitemap/url.tpl');
			}
		}
	}

	public static function GenerateNewsRSSItem($Site, $LangID, &$Counter, &$XHTML, $NoOfItemLimit = 999999) {
		$smarty = new mySmarty();
		$NewsRoots = news::GetNewsRootList($LangID, $Site['site_id']);
		foreach ($NewsRoots as $NR) {
			$News = news::GetNewsListByNewsRootID($NR['news_root_id'], $TotalNewsNum, 1, $NoOfItemLimit, '', '', '', '', '', true, true, 0);
			foreach ($News as $Obj) {
				$Counter++;

				if ($Counter % 50 == 0) {
				}
				if (strlen(trim($Obj['object_friendly_url'])) == 0)
					$Obj['object_friendly_url'] = 'press-release';
//					$href = ConvertToHyphen($Obj['object_friendly_url']) . '-news-' . $Obj['object_id'] . '.html';

				$tags = explode(",", substr($Obj['news_tag'], 1, -2));
				$smarty->assign('tags', $tags);

				// Get File And Write Here
				$loc = 'http://' . $Site['site_address'] . object::GetSeoEncodedURL($Obj, '', $LangID, $Site);
				$theloc = 'http://' . $Site['site_address'] . object::GetSeoURL($Obj, '', $LangID, $Site);
				$smarty->assign('pubDate', strftime ("%a, %d %b %Y %H:%M:%S %z", strtotime($Obj['object_publish_date'])));
				$smarty->assign('lastBuildDate', strftime ("%a, %d %b %Y %H:%M:%S %z", strtotime($Obj['modify_date'])));
				$smarty->assign('link', $loc);
				$smarty->assign('description', $Obj['object_meta_description']);
				$smarty->assign('title', $Obj['news_title']);

				if ($Site['site_sitemap_always_now'] == 'Y') {
					if ($LangID == 1)
						$smarty->assign('content', $Obj['news_content'] . "<br /> Original Post:<br /><a href='" . $theloc . "'>" . $theloc . "</a> <br /> <br /> Author︰ <br /> <a rel='author' href='https://plus.google.com/110915835525553170908?rel=author'><img src='https://ssl.gstatic.com/images/icons/gplus-16.png' width='16' height='16'> Jeff Chan</a>");
					elseif ($LangID == 2)
						$smarty->assign('content', $Obj['news_content'] . "<br /> 原文網址:<br /><a href='" . $theloc . "'>" . $theloc . "</a> <br /> 原文作者︰ <br /> <a rel='author' href='https://plus.google.com/110915835525553170908?rel=author'><img src='https://ssl.gstatic.com/images/icons/gplus-16.png' width='16' height='16'> Jeff Chan</a>");
				}
				else					
					$smarty->assign('content', $Obj['news_content']);

				$XHTML = $XHTML . $smarty->fetch('sitemap/rss_item.tpl');
			}
		}
	}

	public static function GetFolderTreeForAPI($ValidObjectList, $Object, $LanguageID, $CurrentDepth = 0, $SecurityLevel = 0, $MaxDepth = 99999, $IsEnabled = 'Y', $ObjDetailsTypeList = null) {
//			echo $ObjectID;
		$smarty = new mySmarty();
//			$smarty->clearAllAssign();
		if ($CurrentDepth > $MaxDepth)
			return;

		$Objects = null;
		if ($Object['object_type'] == 'PRODUCT_ROOT_LINK') {
			$ProductRootLink = product::GetProductRootLink($Object['object_link_id']);
			$Objects = site::GetAllChildObjectsForAPI($ValidObjectList, $ProductRootLink['product_root_id'], $LanguageID, $SecurityLevel, $IsEnabled, 'N');
		}
		else
			$Objects = site::GetAllChildObjectsForAPI($ValidObjectList, $Object['object_id'], $LanguageID, $SecurityLevel, $IsEnabled, 'N');

		if ($Object['object_type'] == 'PRODUCT' && $Object['product_name'] != null)
			$Object['object_name'] = $Object['product_name'];
		elseif ( ($Object['object_type'] == 'PRODUCT_CATEGORY' || $Object['object_type'] == 'PRODUCT_SPECIAL_CATEGORY')  && $Object['product_category_name'] != null )
			$Object['object_name'] = $Object['product_category_name'];

//			if (count($Objects) <= 0 || ($Object['object_type'] == 'PRODUCT_CATEGORY' && $Object['product_category_is_product_group'] == 'Y') ) {
		$ObjectsXML = '';
		if (count($Objects) > 0 ) {
			foreach($Objects as $Obj)
				$ObjectsXML .= site::GetFolderTreeForAPI($ValidObjectList, $Obj, $LanguageID, $CurrentDepth+1, $SecurityLevel, $MaxDepth, $IsEnabled, $ObjDetailsTypeList);
		}

		if ($Object['object_type'] == 'LINK') {
			$Link = link::GetLinkInfo($Object['object_id']);
			$Object['object_friendly_url'] = $Link['link_url'];
		}

		$ObjectDetailXML = '';
		if ($Object['object_type'] == 'PAGE' && in_array('PAGE', $ObjDetailsTypeList))
			$ObjectDetailXML = page::GetPageXML($Object['object_id'], 1, 999999, $SecurityLevel);
		else if ($Object['object_type'] == 'FOLDER' && in_array('FOLDER', $ObjDetailsTypeList))
			$ObjectDetailXML = folder::GetFolderXML ($Object['object_id']);

		$Object['object_seo_url'] = object::GetSeoURL($Object, '', $LanguageID, null);
		$smarty->assign('Object', $Object);
		$smarty->assign('ObjectsXML', $ObjectsXML);
		$smarty->assign('ObjectDetailXML', $ObjectDetailXML);
		return $smarty->fetch('api/object_info/OBJECT.tpl');			
	}

	public static function GetAllSubChildObjects($TargetObjectList, $ValidObjectList, $Object, $CurrentDepth = 0, $SecurityLevel = 0, $MaxDepth = 99999, $HonorArchiveDate = false, $HonorPublishDate = false, $IsEnable = 'Y', $IsRemoved = 'N', $ExcludeShadowObjectLink = 'Y') {
		$smarty = new mySmarty();

		$FoundObjects = array();
		$Objects = array();

//			$smarty->clearAllAssign();
		if ($CurrentDepth > $MaxDepth)
			return $FoundObjects;


		if (in_array($Object['object_type'], $ValidObjectList)) {
			if ($Object['object_type'] == 'PRODUCT_ROOT_LINK') {
				$ProductRootLink = product::GetProductRootLink($Object['object_link_id']);
				$ProudctRoot = object::GetObjectInfo($Object['object_link_id']);
				$Objects = site::GetAllChildObjects($ValidObjectList, $ProductRoot['object_id'], $SecurityLevel, $IsEnable, $IsRemoved, $HonorArchiveDate, $HonorPublishDate, $ExcludeShadowObjectLink);
			}
			else
				$Objects = site::GetAllChildObjects($ValidObjectList, $Object['object_id'], $SecurityLevel, $IsEnable, $IsRemoved, $HonorArchiveDate, $HonorPublishDate, $ExcludeShadowObjectLink);
		}

//echo $CurrentDepth . ":" . count($Objects) . "(" . $Object['object_id'] . ") " . "<br />";

		if (count($Objects) <= 0) {
			return $FoundObjects;
		}
		else {
			foreach($Objects as $Obj) {
				$FoundObjects = array_merge($FoundObjects, site::GetAllSubChildObjects($TargetObjectList, $ValidObjectList, $Obj, $CurrentDepth+1, $SecurityLevel, $MaxDepth, $HonorArchiveDate, $HonorPublishDate, $IsEnable, $IsRemoved, $ExcludeShadowObjectLink));			
				if (in_array($Obj['object_type'], $TargetObjectList))
					array_push($FoundObjects, $Obj);
			}
			return $FoundObjects;
		}
	}

	public static function GetFolderTreeInULLI(&$XHTML, $ValidObjectList, $ParentObjectID, $LanguageID, $CurrentDepth = 0, $SecurityLevel = 0, $MaxDepth = 99999, $FolderHref = '#', $WithUL = 'Y', $FriendlyLink = 'N', $BaseURL = '') {
		global $Site;

		if ($CurrentDepth >= $MaxDepth)
			return;

		$Objects = site::GetAllChildObjectsForAPI($ValidObjectList, $ParentObjectID, $LanguageID, $SecurityLevel, 'Y', 'N');
		if (count($Objects) <= 0)
			return false;
		else {
			if ($WithUL == 'Y')
				$XHTML .= '<ul>';
			foreach($Objects as $Obj) {
				$DataField = 'data-object_type="' . $Obj['object_type'] . '" data-object_link_id="' . $Obj['object_link_id'] . '" data-object_id="' . $Obj['object_id'] . '"';
				$href = $BaseURL . 'load.php?link_id=' . $Obj['object_link_id'];

				if ($Obj['object_type'] == 'FOLDER')
					$href = $FolderHref . '?link_id=' . $Obj['object_link_id'];

				if ($FriendlyLink == 'Y') {
					$href = object::GetSeoURL($Obj, '', $LanguageID, null);
				}

//					if ($FolderHref == '#' && $Obj['object_type'] == 'FOLDER')
//						$href = '#';
				if ($Obj['object_type'] == 'FOLDER' && $FolderHref != '')
					$href = $FolderHref;
				elseif ($Obj['object_type'] == 'FOLDER' && $FolderHref == '') {
					$Folder = folder::GetFolderDetails($Obj['object_id']);
					if ($Folder['folder_link_url'] != '')
						$href = $Folder['folder_link_url'];
					else {
						$href = $BaseURL . 'load.php?link_id=' . $Obj['object_link_id'];
						if ($FriendlyLink == 'Y')
							$href = object::GetSeoURL($Obj, '', $LanguageID, null);
					}
				}

				if ($Obj['object_type'] == 'PRODUCT' && $Obj['product_name'] != null)
					$Obj['object_name'] = $Obj['product_name'];
				elseif ( ($Obj['object_type'] == 'PRODUCT_CATEGORY' || $Obj['object_type'] == 'PRODUCT_SPECIAL_CATEGORY') && $Obj['product_category_name'] != null)
					$Obj['object_name'] = $Obj['product_category_name'];


				$XHTML = $XHTML . '<li ' . $DataField . ' id="OL_' . $Obj['object_link_id'] . '"><a href="' . $href . '"><span>' . htmlentities($Obj['object_name'], ENT_QUOTES, 'UTF-8') . '</span></a>';

				if ($Obj['object_type'] == 'PRODUCT_ROOT_LINK') {
					$ProductRootLink = product::GetProductRootLink($Obj['object_link_id']);
					site::GetFolderTreeInULLI($XHTML, $ValidObjectList, $ProductRootLink['product_root_id'], $LanguageID, $CurrentDepth+1, $SecurityLevel, $MaxDepth, $FolderHref, 'Y', $FriendlyLink, $BaseURL);
				}
				else
					site::GetFolderTreeInULLI($XHTML, $ValidObjectList, $Obj['object_id'], $LanguageID, $CurrentDepth+1, $SecurityLevel, $MaxDepth, $FolderHref, 'Y', $FriendlyLink, $BaseURL);

				$XHTML .= "</li>";
			}
			if ($WithUL == 'Y')
				$XHTML .= '</ul>';
			return true;
		}
	}

	public static function GetUserCustomFieldsDef($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	user_custom_fields_def " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetProductCustomFieldsDef($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	product_custom_fields_def " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetProductCategoryCustomFieldsDef($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	product_category_custom_fields_def " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetAlbumCustomFieldsDef($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	album_custom_fields_def " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetFolderCustomFieldsDef($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	folder_custom_fields_def " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetMediaCustomFieldsDef($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	media_custom_fields_def " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetDatafileCustomFieldsDef($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	datafile_custom_fields_def " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetMyorderCustomFieldsDef($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	myorder_custom_fields_def " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetUserFieldsShow($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	user_fields_show " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetProductFieldsShow($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	product_fields_show " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetProductBrandFieldsShow($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	product_brand_fields_show " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetProductBrandCustomFieldsDef($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	product_brand_custom_fields_def " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetProductCatFieldsShow($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	product_category_fields_show " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetObjectFieldsShow($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	object_fields_show " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetMyorderFieldsShow($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	myorder_fields_show " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function IsAPILoginExist($Login, $SiteID = 0) {
		$query	=	"	SELECT	* " .
					"	FROM	site " .
					"	WHERE	site_api_login = '" . aveEscT($Login) . "'" .
					"		AND	site_id != '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		return ($result->num_rows > 0);
	}

	public static function DeleteSiteLanguageTree($ObjectID, $Site) {
		// 'SITE_ROOT', 'LANGUAGE_ROOT', 'PAGE', 'FOLDER', 'LINK', 'PRODUCT_ROOT', 'ALBUM', 'NEWS_PAGE', 'LAYOUT_NEWS_PAGE'
		global $LanguageTreeObjectTypeList;
		$Objects = site::GetAllChildObjects($LanguageTreeObjectTypeList, $ObjectID, 999999, 'ALL', 'ALL');
		foreach($Objects as $Obj) {
			if ($Obj['object_type'] == 'PAGE')
				page::DeletePage($Obj['object_id'], $Site);
			elseif ($Obj['object_type'] == 'FOLDER')
				folder::DeleteFolderRecursive ($Obj['object_id'], $Site);
//					site::DeleteSiteLanguageTree($Obj['object_id'], $Site);
			elseif ($Obj['object_type'] == 'LINK')
				link::DeleteLink($Obj['object_id']);
			elseif ($Obj['object_type'] == 'PRODUCT_ROOT_LINK')
				product::DeleteProductRootLink($Obj['object_link_id']);
			elseif ($Obj['object_type'] == 'PRODUCT_ROOT')
				product::DeleteProductRootLink($Obj['object_link_id']);
			elseif ($Obj['object_type'] == 'ALBUM')
				album::DeleteAlbumRootLink($Obj['object_link_id']);
			elseif ($Obj['object_type'] == 'NEWS_PAGE')
				news::DeleteNewsPage($ObjectLink['object_id']);
			elseif ($Obj['object_type'] == 'LAYOUT_NEWS_PAGE')
				layout_news::DeleteLayoutNewsPage($ObjectLink['object_id']);
		}

		$Object = object::GetObjectInfo($ObjectID);
		if ($Object['object_type'] == 'LANGUAGE_ROOT')
			language::DeleteSiteLanguageRoot($Object['object_id'], $Site['site_id']);
	}

	public static function CallbackExec($Site, $CallbackURL, $Para) {
		if (!is_array($Para))
			$Para = array();

		$CallbackURL = $CallbackURL . '&api_login=' . $Site['site_api_login'] . '&api_key=' . $Site['site_api_key'];

		$CurlHandle = curl_init();
		$timeout = 30;
		curl_setopt ($CurlHandle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($CurlHandle, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt ($CurlHandle, CURLOPT_FRESH_CONNECT, false);
		curl_setopt ($CurlHandle, CURLOPT_DNS_USE_GLOBAL_CACHE, true);
		
		$counter = 0;
		$softFail = false;
		$hardFail = false;
		do {
			$DateTime = date('Y-m-d H:i:s');
			curl_setopt ($CurlHandle, CURLOPT_URL, $CallbackURL . '&datetime=' . urlencode($DateTime));
			$counter++;
			$CallbackResult = curl_exec($CurlHandle);
			
			if (trim($CallbackResult) != 'OK') {
				$softFail = true;
				if ($counter >= 5)
					$hardFail = true;
				sleep(5);
			}
			else
				$softFail = false;
			
			$query =	"	INSERT INTO	callback_log " .
						"	SET		id_1				= 	" . aveEsc($Para['id_1']) . ", " .
						"			id_2				= 	" . aveEsc($Para['id_2']) . ", " .
						"			id_3				= 	" . aveEsc($Para['id_3']) . ", " .
						"			string_1			= 	'" . aveEsc($Para['string_1']) . "', " .
						"			string_2			= 	'" . aveEsc($Para['string_2']) . "', " .
						"			string_3			= 	'" . aveEsc($Para['string_3']) . "', " .
						"			callback_result		= 	'" . aveEsc($CallbackResult) . "', " .
						"			callback_datetime	= 	'" . aveEsc($DateTime) . "', " .
						"			callback_hard_fail	=	'" . ynval($hardFail) . "', " .
						"			site_id				=	'" . intval($Site['site_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		} while($softFail && !$hardFail);

		return $CallbackResult;
	}

	public static function EmptyAPICache($SiteID) {
		$query =	"	DELETE FROM cache_citizensg.api_cache " .
					"	WHERE	site_id	= '" . intval($SiteID) . "'" .
					"		AND	api_server_type = '" . aveEscT(ENV) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$Site = site::GetSiteInfo($SiteID);

		if (trim($Site['site_empty_cache_url_callback']) != '') {

			$URL = trim($Site['site_empty_cache_url_callback']) . '?status=EmptyCache';
			$Para = array();
			$Para['string_1'] = 'Empty Cache';

			site::CallbackExec($Site, $URL, $Para);
		}
	}
	
	public static function DeleteSite($SiteID, $leftThisSiteInDbOnly = false) {		
		$Site = site::GetSiteInfo($SiteID);
		if ($Site == null)
			die ("Unknown Site " . $SiteID . "\n");

		$object_where_sql = '';
		$site_where_sql = '';
		
		if ($leftThisSiteInDbOnly) {
			echo "Delete All Site Except Site " . $SiteID . " \n";
			$object_where_sql = " AND O.site_id != '" . $SiteID . "'";
			$site_where_sql = " site_id != '" . $SiteID . "'";
		}
		else {
			echo "Delete Site " . $SiteID . " \n";
			$object_where_sql = " AND O.site_id = '" . $SiteID . "'";
			$site_where_sql = " site_id = '" . $SiteID . "'";
		}

		// -------------------------------------------------------------------------------
		echo "Start delete album, album_data \n";
		$query =	"	DELETE	A, D " .
					"	FROM	object O	LEFT JOIN album A ON (A.album_id = O.object_id) " .
					"						LEFT JOIN album_data D ON (D.album_id = O.object_id) " .
					"	WHERE	O.object_type = 'ALBUM' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);		
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up album DB \n";
		$query =	"	DELETE	A " .
					"	FROM	album A		LEFT JOIN object O ON (A.album_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up album_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	album_data A		LEFT JOIN object O ON (A.album_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------
		
		echo "Start delete album_custom_fields_def \n";
		$query =	"	DELETE FROM album_custom_fields_def WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up album_custom_fields_def DB \n";
		$query =	"	DELETE	D " .
					"	FROM	album_custom_fields_def D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete album_root_data \n";
		$query =	"	DELETE	D " .
					"	FROM	object O	LEFT JOIN album_root_data D ON (D.album_root_id = O.object_id) " .
					"	WHERE	O.object_type = 'ALBUM_ROOT' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up album_root_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	album_root_data A		LEFT JOIN object O ON (A.album_root_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete api_error_msg \n";
		$query =	"	DELETE FROM api_error_msg WHERE " . $site_where_sql . " AND site_id != 0 ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up api_error_msg DB \n";
		$query =	"	DELETE	A " .
					"	FROM	api_error_msg A		LEFT JOIN site S ON (A.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL AND A.site_id != 0 ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		// -------------------------------------------------------------------------------

		echo "Start delete api_stats \n";
		$query =	"	DELETE FROM api_stats WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up api_stats DB \n";
		$query =	"	DELETE	A " .
					"	FROM	api_stats A		LEFT JOIN site S ON (A.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		// -------------------------------------------------------------------------------

		echo "Start delete block_content \n";
		$query =	"	DELETE	B " .
					"	FROM	object O	LEFT JOIN block_content B ON (B.block_content_id = O.object_id) " .
					"	WHERE	O.object_type = 'BLOCK_CONTENT' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up block_content DB \n";
		$query =	"	DELETE	B " .
					"	FROM	block_content B		LEFT JOIN object O ON (B.block_content_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete block_definition \n";
		$query =	"	DELETE	B " .
					"	FROM	object O	LEFT JOIN block_definition B ON (B.block_definition_id = O.object_id) " .
					"	WHERE	O.object_type = 'BLOCK_DEF' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up block_definition DB \n";
		$query =	"	DELETE	B " .
					"	FROM	block_definition B		LEFT JOIN object O ON (B.block_definition_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete block_holder \n";
		$query =	"	DELETE	B " .
					"	FROM	object O	LEFT JOIN block_holder B ON (B.block_holder_id = O.object_id) " .
					"	WHERE	O.object_type = 'BLOCK_HOLDER' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up block_holder DB \n";
		$query =	"	DELETE	B " .
					"	FROM	block_holder B		LEFT JOIN object O ON (B.block_holder_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete bonus_point_item, bonus_point_item_data \n";
		$query =	"	DELETE	B, D " .
					"	FROM	object O	LEFT JOIN bonus_point_item B ON (B.bonus_point_item_id = O.object_id) " .
					"						LEFT JOIN bonus_point_item_data D ON (D.bonus_point_item_id = O.object_id) " .
					"	WHERE	O.object_type = 'BONUS_POINT_ITEM' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);		
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up bonus_point_item DB \n";
		$query =	"	DELETE	B " .
					"	FROM	bonus_point_item B		LEFT JOIN object O ON (B.bonus_point_item_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up bonus_point_item_data DB \n";
		$query =	"	DELETE	B " .
					"	FROM	bonus_point_item_data B		LEFT JOIN object O ON (B.bonus_point_item_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete callback_log \n";
		$query =	"	DELETE FROM callback_log WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up callback_log DB \n";
		$query =	"	DELETE	A " .
					"	FROM	callback_log A		LEFT JOIN site S ON (A.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		// -------------------------------------------------------------------------------

		echo "Start delete cart_bonus_point_item \n";
		$query =	"	DELETE FROM cart_bonus_point_item WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up cart_bonus_point_item DB \n";
		$query =	"	DELETE	A " .
					"	FROM	cart_bonus_point_item A		LEFT JOIN site S ON (A.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		// -------------------------------------------------------------------------------

		echo "Start delete cart_content \n";
		$query =	"	DELETE FROM cart_content WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up cart_content DB \n";
		$query =	"	DELETE	A " .
					"	FROM	cart_content A		LEFT JOIN site S ON (A.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		// -------------------------------------------------------------------------------

		echo "Start delete cart_details \n";
		$query =	"	DELETE FROM cart_details WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up cart_details DB \n";
		$query =	"	DELETE	A " .
					"	FROM	cart_details A		LEFT JOIN site S ON (A.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		// -------------------------------------------------------------------------------

		echo "Start delete content_admin \n";
		$query =	"	DELETE FROM content_admin WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up content_admin DB \n";
		$query =	"	DELETE	A " .
					"	FROM	content_admin A		LEFT JOIN site S ON (A.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		

		echo "Clean up content_admin_acl DB \n";
		$query =	"	DELETE	A " .
					"	FROM	content_admin_acl A		LEFT JOIN content_admin C ON (A.content_admin_id = C.content_admin_id) " .
					"	WHERE	C.content_admin_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		

		echo "Start delete content_admin_group \n";
		$query =	"	DELETE FROM content_admin_group WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up content_admin_group DB \n";
		$query =	"	DELETE	A " .
					"	FROM	content_admin_group A		LEFT JOIN site S ON (A.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		
		echo "Clean up content_admin_group_member_link DB \n";
		$query =	"	DELETE	A " .
					"	FROM	content_admin_group_member_link A		LEFT JOIN content_admin_group C ON (A.content_admin_group_id = C.content_admin_group_id) " .
					"	WHERE	C.content_admin_group_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		
		echo "Clean up content_admin_msg DB \n";
		$query =	"	DELETE	A " .
					"	FROM	content_admin_msg A		LEFT JOIN content_admin C ON (A.content_admin_id = C.content_admin_id) " .
					"	WHERE	C.content_admin_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";	
		// -------------------------------------------------------------------------------

		echo "Start delete currency_site_enable \n";
		$query =	"	DELETE FROM currency_site_enable WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up currency_site_enable DB \n";
		$query =	"	DELETE	A " .
					"	FROM	currency_site_enable A		LEFT JOIN site S ON (A.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		// -------------------------------------------------------------------------------

		echo "Start delete datafile, datafile_data \n";		
		$query =	"	DELETE	A, D " .
					"	FROM	object O	LEFT JOIN datafile A ON (A.datafile_id = O.object_id) " .
					"						LEFT JOIN datafile_data D ON (D.datafile_id = O.object_id) " .
					"	WHERE	O.object_type = 'DATAFILE' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);		
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up datafile DB \n";
		$query =	"	DELETE	A " .
					"	FROM	datafile A		LEFT JOIN object O ON (A.datafile_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up datafile_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	datafile_data A		LEFT JOIN object O ON (A.datafile_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete datafile_custom_fields_def \n";
		$query =	"	DELETE FROM datafile_custom_fields_def WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up datafile_custom_fields_def DB \n";
		$query =	"	DELETE	A " .
					"	FROM	datafile_custom_fields_def A		LEFT JOIN site S ON (A.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete discount_bundle_item_cost_aware_condition, discount_bundle_item_free_condition, discount_bundle_rule, discount_bundle_rule_data, discount_bundle_rule_price, discount_bundle_rule_product_link \n";
		$query =	"	DELETE	AC, FC, R, D, P, L " .
					"	FROM	object O	LEFT JOIN discount_bundle_item_cost_aware_condition AC ON (AC.discount_bundle_rule_id = O.object_id) " .
					"						LEFT JOIN discount_bundle_item_free_condition FC ON (FC.discount_bundle_rule_id = O.object_id) " .
					"						LEFT JOIN discount_bundle_rule R ON (R.discount_bundle_rule_id = O.object_id) " .
					"						LEFT JOIN discount_bundle_rule_data D ON (D.discount_bundle_rule_id = O.object_id) " .
					"						LEFT JOIN discount_bundle_rule_price P ON (P.discount_bundle_rule_id = O.object_id) " .
					"						LEFT JOIN discount_bundle_rule_product_link L ON (L.discount_bundle_rule_id = O.object_id) " .
					"	WHERE	O.object_type = 'DISCOUNT_BUNDLE_RULE' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);		
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up discount_bundle_item_cost_aware_condition DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_bundle_item_cost_aware_condition A		LEFT JOIN object O ON (A.discount_bundle_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up discount_bundle_item_free_condition DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_bundle_item_free_condition A		LEFT JOIN object O ON (A.discount_bundle_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up discount_bundle_rule DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_bundle_rule A		LEFT JOIN object O ON (A.discount_bundle_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up discount_bundle_rule_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_bundle_rule_data A		LEFT JOIN object O ON (A.discount_bundle_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up discount_bundle_rule_price DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_bundle_rule_price A		LEFT JOIN object O ON (A.discount_bundle_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up discount_bundle_rule_product_link DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_bundle_rule_product_link A		LEFT JOIN object O ON (A.discount_bundle_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		// -------------------------------------------------------------------------------
		
		echo "Start delete discount_postprocess_discount_level, discount_postprocess_rule, discount_postprocess_rule_data, discount_postprocess_rule_price \n";
		$query =	"	DELETE	L, R, D, P " .
					"	FROM	object O	LEFT JOIN discount_postprocess_discount_level L ON (L.discount_postprocess_rule_id = O.object_id) " .
					"						LEFT JOIN discount_postprocess_rule R ON (R.discount_postprocess_rule_id = O.object_id) " .
					"						LEFT JOIN discount_postprocess_rule_data D ON (D.discount_postprocess_rule_id = O.object_id) " .
					"						LEFT JOIN discount_postprocess_rule_price P ON (P.discount_postprocess_rule_id = O.object_id) " .
					"	WHERE	O.object_type = 'DISCOUNT_POSTPROCESS_RULE' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up discount_postprocess_discount_level DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_postprocess_discount_level A		LEFT JOIN object O ON (A.discount_postprocess_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up discount_postprocess_rule DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_postprocess_rule A		LEFT JOIN object O ON (A.discount_postprocess_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up discount_postprocess_rule_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_postprocess_rule_data A		LEFT JOIN object O ON (A.discount_postprocess_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up discount_postprocess_rule_price DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_postprocess_rule_price A		LEFT JOIN object O ON (A.discount_postprocess_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------
		
		echo "Start delete discount_preprocess_item_condition, discount_preprocess_item_except_condition, discount_preprocess_rule, discount_preprocess_rule_data, discount_preprocess_rule_price \n";
		$query =	"	DELETE	IC, EC, R, D, P " .
					"	FROM	object O	LEFT JOIN discount_preprocess_item_condition IC ON (IC.discount_preprocess_rule_id = O.object_id) " .
					"						LEFT JOIN discount_preprocess_item_except_condition EC ON (EC.discount_preprocess_rule_id = O.object_id) " .
					"						LEFT JOIN discount_preprocess_rule R ON (R.discount_preprocess_rule_id = O.object_id) " .
					"						LEFT JOIN discount_preprocess_rule_data D ON (D.discount_preprocess_rule_id = O.object_id) " .
					"						LEFT JOIN discount_preprocess_rule_price P ON (P.discount_preprocess_rule_id = O.object_id) " .
					"	WHERE	O.object_type = 'DISCOUNT_PREPROCESS_RULE' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up discount_preprocess_item_condition DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_preprocess_item_condition A		LEFT JOIN object O ON (A.discount_preprocess_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up discount_preprocess_item_except_condition DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_preprocess_item_except_condition A		LEFT JOIN object O ON (A.discount_preprocess_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up discount_preprocess_rule DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_preprocess_rule A		LEFT JOIN object O ON (A.discount_preprocess_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up discount_preprocess_rule_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_preprocess_rule_data A		LEFT JOIN object O ON (A.discount_preprocess_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up discount_preprocess_rule_price DB \n";
		$query =	"	DELETE	A " .
					"	FROM	discount_preprocess_rule_price A		LEFT JOIN object O ON (A.discount_preprocess_rule_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "TRUNCATE elasing_campaign, elasing_campaign_email, elasing_list, elasing_list_subscriber, elasing_mx_counter, elasing_site_subscriber, elasing_subscriber \n";
		$query =	"	TRUNCATE elasing_campaign "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$query =	"	TRUNCATE elasing_campaign_email "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$query =	"	TRUNCATE elasing_list "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$query =	"	TRUNCATE elasing_list_subscriber "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$query =	"	TRUNCATE elasing_mx_counter "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$query =	"	TRUNCATE elasing_site_subscriber "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$query =	"	TRUNCATE elasing_subscriber "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		// -------------------------------------------------------------------------------

		echo "TRUNCATE errorlog \n";
		$query =	"	TRUNCATE errorlog ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		// -------------------------------------------------------------------------------
		  
		echo "Start delete file_base \n";
		$query =	"	DELETE FROM file_base WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up file_base DB \n";
		$query =	"	DELETE	A " .
					"	FROM	file_base A		LEFT JOIN site S ON (A.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		// -------------------------------------------------------------------------------

		echo "Start delete folder \n";
		$query =	"	DELETE	F " .
					"	FROM	object O	LEFT JOIN folder F ON (F.folder_id = O.object_id) " .
					"	WHERE	O.object_type = 'FOLDER' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up folder DB \n";
		$query =	"	DELETE	A " .
					"	FROM	folder A		LEFT JOIN object O ON (A.folder_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------
		
		echo "Start delete folder_custom_fields_def \n";
		$query =	"	DELETE FROM folder_custom_fields_def WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up folder_custom_fields_def DB \n";
		$query =	"	DELETE	D " .
					"	FROM	folder_custom_fields_def D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "TRUNCATE git_action_queue, git_repo, git_repo_deploy \n";
		$query =	"	TRUNCATE git_action_queue "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$query =	"	TRUNCATE git_repo "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$query =	"	TRUNCATE git_repo_deploy "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		// -------------------------------------------------------------------------------

		echo "Start delete language_root \n";
		$query =	"	DELETE	R " .
					"	FROM	object O	LEFT JOIN language_root R ON (R.language_root_id = O.object_id) " .
					"	WHERE	O.object_type = 'LANGUAGE_ROOT' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up language_root DB \n";
		$query =	"	DELETE	A " .
					"	FROM	language_root A		LEFT JOIN object O ON (A.language_root_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete layout \n";
		$query =	"	DELETE	R " .
					"	FROM	object O	LEFT JOIN layout R ON (R.layout_id = O.object_id) " .
					"	WHERE	O.object_type = 'LAYOUT' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up layout DB \n";
		$query =	"	DELETE	A " .
					"	FROM	layout A		LEFT JOIN object O ON (A.layout_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete layout_news \n";
		$query =	"	DELETE	R " .
					"	FROM	object O	LEFT JOIN layout_news R ON (R.layout_news_id = O.object_id) " .
					"	WHERE	O.object_type = 'LAYOUT_NEWS' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up layout_news DB \n";
		$query =	"	DELETE	A " .
					"	FROM	layout_news A		LEFT JOIN object O ON (A.layout_news_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete layout_news_category \n";
		$query =	"	DELETE	R " .
					"	FROM	object O	LEFT JOIN layout_news_category R ON (R.layout_news_category_id = O.object_id) " .
					"	WHERE	O.object_type = 'LAYOUT_NEWS_CATEGORY' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up layout_news_category DB \n";
		$query =	"	DELETE	A " .
					"	FROM	layout_news_category A		LEFT JOIN object O ON (A.layout_news_category_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete layout_news_page \n";
		$query =	"	DELETE	R " .
					"	FROM	object O	LEFT JOIN layout_news_page R ON (R.layout_news_page_id = O.object_id) " .
					"	WHERE	O.object_type = 'LAYOUT_NEWS_PAGE' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up layout_news_page DB \n";
		$query =	"	DELETE	A " .
					"	FROM	layout_news_page A		LEFT JOIN object O ON (A.layout_news_page_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete layout_news_root \n";
		$query =	"	DELETE	R " .
					"	FROM	object O	LEFT JOIN layout_news_root R ON (R.layout_news_root_id = O.object_id) " .
					"	WHERE	O.object_type = 'LAYOUT_NEWS_ROOT' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up layout_news_root DB \n";
		$query =	"	DELETE	A " .
					"	FROM	layout_news_root A		LEFT JOIN object O ON (A.layout_news_root_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete link \n";
		$query =	"	DELETE	R " .
					"	FROM	object O	LEFT JOIN link R ON (R.link_id = O.object_id) " .
					"	WHERE	O.object_type = 'LINK' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up link DB \n";
		$query =	"	DELETE	A " .
					"	FROM	link A		LEFT JOIN object O ON (A.link_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete media, media_data \n";
		$query =	"	DELETE	A, D " .
					"	FROM	object O	LEFT JOIN media A ON (A.media_id = O.object_id) " .
					"						LEFT JOIN media_data D ON (D.media_id = O.object_id) " .
					"	WHERE	O.object_type = 'MEDIA' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);		
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up media DB \n";
		$query =	"	DELETE	A " .
					"	FROM	media A		LEFT JOIN object O ON (A.media_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up media_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	media_data A		LEFT JOIN object O ON (A.media_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------
		
		echo "Start delete media_custom_fields_def \n";
		$query =	"	DELETE FROM media_custom_fields_def WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up media_custom_fields_def DB \n";
		$query =	"	DELETE	D " .
					"	FROM	media_custom_fields_def D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete myorder \n";
		$query =	"	DELETE FROM myorder WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up myorder DB \n";
		$query =	"	DELETE	A " .
					"	FROM	myorder A		LEFT JOIN site S ON (A.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		
		echo "Clean up myorder_bonus_point_item DB \n";
		$query =	"	DELETE	I " .
					"	FROM	myorder_bonus_point_item I		LEFT JOIN myorder O ON (I.myorder_id = O.myorder_id) " .
					"	WHERE	O.myorder_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		
		echo "Clean up myorder_product DB \n";
		$query =	"	DELETE	I " .
					"	FROM	myorder_product I		LEFT JOIN myorder O ON (I.myorder_id = O.myorder_id) " .
					"	WHERE	O.myorder_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------
		
		echo "Start delete myorder_custom_fields_def \n";
		$query =	"	DELETE FROM myorder_custom_fields_def WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up myorder_custom_fields_def DB \n";
		$query =	"	DELETE	D " .
					"	FROM	myorder_custom_fields_def D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete myorder_fields_show \n";
		$query =	"	DELETE FROM myorder_fields_show WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up myorder_fields_show DB \n";
		$query =	"	DELETE	D " .
					"	FROM	myorder_fields_show D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------
		
		echo "Start delete news \n";
		$query =	"	DELETE	R " .
					"	FROM	object O	LEFT JOIN news R ON (R.news_id = O.object_id) " .
					"	WHERE	O.object_type = 'NEWS' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up news DB \n";
		$query =	"	DELETE	A " .
					"	FROM	news A		LEFT JOIN object O ON (A.news_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete news_category \n";
		$query =	"	DELETE	R " .
					"	FROM	object O	LEFT JOIN news_category R ON (R.news_category_id = O.object_id) " .
					"	WHERE	O.object_type = 'NEWS_CATEGORY' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up news_category DB \n";
		$query =	"	DELETE	A " .
					"	FROM	news_category A		LEFT JOIN object O ON (A.news_category_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete news_page \n";
		$query =	"	DELETE	R " .
					"	FROM	object O	LEFT JOIN news_page R ON (R.news_page_id = O.object_id) " .
					"	WHERE	O.object_type = 'NEWS_PAGE' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up news_page DB \n";
		$query =	"	DELETE	A " .
					"	FROM	news_page A		LEFT JOIN object O ON (A.news_page_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete news_root \n";
		$query =	"	DELETE	R " .
					"	FROM	object O	LEFT JOIN news_root R ON (R.news_root_id = O.object_id) " .
					"	WHERE	O.object_type = 'NEWS_ROOT' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up news_root DB \n";
		$query =	"	DELETE	A " .
					"	FROM	news_root A		LEFT JOIN object O ON (A.news_root_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete object_fields_show \n";
		$query =	"	DELETE FROM object_fields_show WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up object_fields_show DB \n";
		$query =	"	DELETE	D " .
					"	FROM	object_fields_show D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete object_structure_seo_url \n";
		$query =	"	DELETE FROM object_structure_seo_url WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up object_structure_seo_url DB \n";
		$query =	"	DELETE	D " .
					"	FROM	object_structure_seo_url D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------
		
		echo "Start delete page \n";
		$query =	"	DELETE	R " .
					"	FROM	object O	LEFT JOIN page R ON (R.page_id = O.object_id) " .
					"	WHERE	O.object_type = 'PAGE' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up page DB \n";
		$query =	"	DELETE	A " .
					"	FROM	page A		LEFT JOIN object O ON (A.page_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete product, product_data, product_price, product_price_level \n";
		$query =	"	DELETE	R, D, P, L " .
					"	FROM	object O	LEFT JOIN product R ON (R.product_id = O.object_id) " .
					"						LEFT JOIN product_data D ON (D.product_id = O.object_id) " .
					"						LEFT JOIN product_price P ON (P.product_id = O.object_id) " .
					"						LEFT JOIN product_price_level L ON (L.product_id = O.object_id) " .
					"	WHERE	O.object_type = 'PRODUCT' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product A		LEFT JOIN object O ON (A.product_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_data A		LEFT JOIN object O ON (A.product_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up product_price DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_price A		LEFT JOIN object O ON (A.product_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		

		echo "Clean up product_price_level DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_price_level A		LEFT JOIN object O ON (A.product_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		// -------------------------------------------------------------------------------

		echo "Start delete product_brand, product_brand_data \n";
		$query =	"	DELETE	R, D " .
					"	FROM	object O	LEFT JOIN product_brand R ON (R.product_brand_id = O.object_id) " .
					"						LEFT JOIN product_brand_data D ON (D.product_brand_id = O.object_id) " .
					"	WHERE	O.object_type = 'PRODUCT_BRAND' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_brand DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_brand A		LEFT JOIN object O ON (A.product_brand_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_brand_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_brand_data A		LEFT JOIN object O ON (A.product_brand_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";				
		// -------------------------------------------------------------------------------

		echo "Start delete product_brand_custom_fields_def \n";
		$query =	"	DELETE FROM product_brand_custom_fields_def WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_brand_custom_fields_def DB \n";
		$query =	"	DELETE	D " .
					"	FROM	product_brand_custom_fields_def D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------
		
		echo "Start delete product_brand_fields_show \n";
		$query =	"	DELETE FROM product_brand_fields_show WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_brand_fields_show DB \n";
		$query =	"	DELETE	D " .
					"	FROM	product_brand_fields_show D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete product_category, product_category_data, product_category_price_range \n";
		$query =	"	DELETE	C, D, R " .
					"	FROM	object O	LEFT JOIN product_category C ON (C.product_category_id = O.object_id) " .
					"						LEFT JOIN product_category_data D ON (D.product_category_id = O.object_id) " .
					"						LEFT JOIN product_category_price_range R ON (R.product_category_id = O.object_id) " .
					"	WHERE	O.object_type = 'PRODUCT_CATEGORY' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_category DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_category A		LEFT JOIN object O ON (A.product_category_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_category_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_category_data A		LEFT JOIN object O ON (A.product_category_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up product_category_price_range DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_category_price_range A		LEFT JOIN object O ON (A.product_category_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		// -------------------------------------------------------------------------------		
		
		echo "Start delete product_category_custom_fields_def \n";
		$query =	"	DELETE FROM product_category_custom_fields_def WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_category_custom_fields_def DB \n";
		$query =	"	DELETE	D " .
					"	FROM	product_category_custom_fields_def D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------
		
		echo "Start delete product_category_fields_show \n";
		$query =	"	DELETE FROM product_category_fields_show WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_category_fields_show DB \n";
		$query =	"	DELETE	D " .
					"	FROM	product_category_fields_show D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete product_category_special, product_category_special_data \n";
		$query =	"	DELETE	C, D " .
					"	FROM	object O	LEFT JOIN product_category_special C ON (C.product_category_special_id = O.object_id) " .
					"						LEFT JOIN product_category_special_data D ON (D.product_category_special_id = O.object_id) " .
					"	WHERE	O.object_type = 'PRODUCT_SPECIAL_CATEGORY' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_category_special DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_category_special A		LEFT JOIN object O ON (A.product_category_special_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_category_special_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_category_special_data A		LEFT JOIN object O ON (A.product_category_special_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------
		
		echo "Start delete product_custom_fields_def \n";
		$query =	"	DELETE FROM product_custom_fields_def WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_custom_fields_def DB \n";
		$query =	"	DELETE	D " .
					"	FROM	product_custom_fields_def D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete product_fields_show \n";
		$query =	"	DELETE FROM product_fields_show WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_fields_show DB \n";
		$query =	"	DELETE	D " .
					"	FROM	product_fields_show D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete product_option, product_option_data \n";
		$query =	"	DELETE	P, D " .
					"	FROM	object O	LEFT JOIN product_option P ON (P.product_option_id = O.object_id) " .
					"						LEFT JOIN product_option_data D ON (D.product_option_id = O.object_id) " .
					"	WHERE	O.object_type = 'PRODUCT_OPTION' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_option DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_option A		LEFT JOIN object O ON (A.product_option_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_option DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_option A		LEFT JOIN product P ON (A.product_id = P.product_id) " .
					"	WHERE	P.product_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up product_option_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_option_data A		LEFT JOIN object O ON (A.product_option_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------		

		echo "Start delete product_root_data \n";
		$query =	"	DELETE	D " .
					"	FROM	object O	LEFT JOIN product_root_data D ON (D.product_root_id = O.object_id) " .
					"	WHERE	O.object_type = 'PRODUCT_ROOT' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_root_data DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_root_data A		LEFT JOIN object O ON (A.product_root_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------		

		echo "Start delete product_root_link \n";
		$query =	"	DELETE	D " .
					"	FROM	object O	LEFT JOIN product_root_link D ON (D.product_root_link_id = O.object_id) " .
					"	WHERE	O.object_type = 'PRODUCT_ROOT_LINK' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up product_root_link DB \n";
		$query =	"	DELETE	A " .
					"	FROM	product_root_link A		LEFT JOIN object O ON (A.product_root_link_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------		

		echo "Start delete shop \n";
		$query =	"	DELETE FROM shop WHERE " . $site_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up shop DB \n";
		$query =	"	DELETE	D " .
					"	FROM	shop D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete site_freight \n";
		$query =	"	DELETE FROM site_freight WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up site_freight DB \n";
		$query =	"	DELETE	D " .
					"	FROM	site_freight D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete stock_in_out \n";
		$query =	"	DELETE FROM stock_in_out WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up stock_in_out DB \n";
		$query =	"	DELETE	D " .
					"	FROM	stock_in_out D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete stock_in_out_cart_details, stock_in_out_cart_content \n";
		$query =	"	DELETE	O, C " .
					"	FROM	stock_in_out_cart_details O	LEFT JOIN stock_in_out_cart_content C ON (O.stock_in_out_cart_id = C.stock_in_out_cart_id) " .
					"	WHERE	2 > 1 " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up stock_in_out_cart_details DB \n";
		$query =	"	DELETE	D " .
					"	FROM	stock_in_out_cart_details D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up stock_in_out_cart_content DB \n";
		$query =	"	DELETE	C " .
					"	FROM	stock_in_out_cart_content C		LEFT JOIN stock_in_out_cart_details D ON (D.stock_in_out_cart_id = C.stock_in_out_cart_id) " .
					"	WHERE	D.stock_in_out_cart_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete stock_shipment \n";
		$query =	"	DELETE FROM stock_shipment WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up stock_shipment DB \n";
		$query =	"	DELETE	D " .
					"	FROM	stock_shipment D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete stock_transaction, stock_transaction_product \n";
		$query =	"	DELETE	O, C " .
					"	FROM	stock_transaction O	LEFT JOIN stock_transaction_product C ON (O.stock_transaction_id = C.stock_transaction_id) " .
					"	WHERE	2 > 1 " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up stock_transaction DB \n";
		$query =	"	DELETE	D " .
					"	FROM	stock_transaction D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up stock_transaction_product DB \n";
		$query =	"	DELETE	C " .
					"	FROM	stock_transaction_product C		LEFT JOIN stock_transaction D ON (D.stock_transaction_id = C.stock_transaction_id) " .
					"	WHERE	D.stock_transaction_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete sync_log \n";
		$query =	"	DELETE FROM sync_log WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up sync_log DB \n";
		$query =	"	DELETE	D " .
					"	FROM	sync_log D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "TRUNCATE system_admin, system_admin_git_repo, system_admin_site_link \n";
		$query =	"	DELETE FROM system_admin WHERE system_admin_id != 1 "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$query =	"	TRUNCATE system_admin_git_repo "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$query =	"	TRUNCATE system_admin_site_link "; $result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		// -------------------------------------------------------------------------------

		echo "Start delete user, user_balance, user_bonus_point, wishlist \n";
		$query =	"	DELETE	O, B, P, L " .
					"	FROM	user O	LEFT JOIN user_balance B ON (O.user_id = B.user_id) " .
					"					LEFT JOIN user_bonus_point P ON (O.user_id = P.user_id) " .
					"					LEFT JOIN wishlist L ON (O.user_id = L.user_id) " .
					"	WHERE	2 > 1 " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up user DB \n";
		$query =	"	DELETE	D " .
					"	FROM	user D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Clean up user_balance DB \n";
		$query =	"	DELETE	C " .
					"	FROM	user_balance C		LEFT JOIN user D ON (D.user_id = C.user_id) " .
					"	WHERE	D.user_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		
		echo "Clean up user_bonus_point DB \n";
		$query =	"	DELETE	C " .
					"	FROM	user_bonus_point C		LEFT JOIN user D ON (D.user_id = C.user_id) " .
					"	WHERE	D.user_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		

		echo "Clean up wishlist DB \n";
		$query =	"	DELETE	C " .
					"	FROM	wishlist C		LEFT JOIN user D ON (D.user_id = C.user_id) " .
					"	WHERE	D.user_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		
		// -------------------------------------------------------------------------------
		
		echo "Start delete user_custom_fields_def \n";
		$query =	"	DELETE FROM user_custom_fields_def WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up user_custom_fields_def DB \n";
		$query =	"	DELETE	D " .
					"	FROM	user_custom_fields_def D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete user_fields_show \n";
		$query =	"	DELETE FROM user_fields_show WHERE " . $site_where_sql;
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up user_fields_show DB \n";
		$query =	"	DELETE	D " .
					"	FROM	user_fields_show D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete user_datafile_holder \n";
		$query =	"	DELETE	D " .
					"	FROM	object O	LEFT JOIN user_datafile_holder D ON (D.user_datafile_holder_id = O.object_id) " .
					"	WHERE	O.object_type = 'USER_DATAFILE_HOLDER' " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up user_datafile_holder DB \n";
		$query =	"	DELETE	A " .
					"	FROM	user_datafile_holder A		LEFT JOIN object O ON (A.user_datafile_holder_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------		

		echo "Start delete vote_table \n";
		$query =	"	DELETE	D " .
					"	FROM	object O	LEFT JOIN vote_table D ON (D.object_id = O.object_id) " .
					"	WHERE	2 > 1 " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up vote_table DB \n";
		$query =	"	DELETE	A " .
					"	FROM	vote_table A		LEFT JOIN object O ON (A.object_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------		

		echo "Start delete workflow \n";
		$query =	"	DELETE	D " .
					"	FROM	object O	LEFT JOIN workflow D ON (D.object_id = O.object_id) " .
					"	WHERE	2 > 1 " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up workflow DB \n";
		$query =	"	DELETE	A " .
					"	FROM	workflow A		LEFT JOIN object O ON (A.object_id = O.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		$query =	"	DELETE	A " .
					"	FROM	workflow A		LEFT JOIN content_admin O ON (A.sender_content_admin_id = O.content_admin_id) " .
					"	WHERE	O.content_admin_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";		
		// -------------------------------------------------------------------------------
		
		echo "Start delete object_link \n";
		$query =	"	DELETE	OL " .
					"	FROM	object_link OL	JOIN object O ON (O.object_id = OL.object_id " . $object_where_sql . ") ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		
		echo "Cleanu up object_link \n";
		$query =	"	DELETE	OL " .
					"	FROM	object_link OL	LEFT JOIN object O ON (O.object_id = OL.object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Cleanu up object_link \n";
		$query =	"	DELETE	OL " .
					"	FROM	object_link OL	LEFT JOIN object O ON (O.object_id = OL.parent_object_id) " .
					"	WHERE	O.object_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------

		echo "Start delete object \n";
		$query =	"	DELETE	O " .
					"	FROM	object O " .
					"	WHERE	2 > 1 " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";

		echo "Clean up object DB \n";
		$query =	"	DELETE	D " .
					"	FROM	object D		LEFT JOIN site S ON (D.site_id = S.site_id) " .
					"	WHERE	S.site_id IS NULL ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------
		
		echo "Start delete object \n";
		$query =	"	DELETE	O " .
					"	FROM	site O " .
					"	WHERE	2 > 1 " . $object_where_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		echo "Deleted " . customdb::mysqli()->affected_rows . "\n";
		// -------------------------------------------------------------------------------
	}

	private static function getSiteToSiteSQL($Table, $Type, $DataObj) {
		$sql = '';

		$max = 20;
		if ($Type == 'rgb')
			$max = NO_OF_CUSTOM_RGB_FIELDS;

		for ($i = 1; $i <= $max; $i++) {
			$sql = $sql . " " . $Table . "_custom_" . $Type . "_" . $i . " = '" . 
					aveEscT($DataObj[$Table . '_custom_' . $Type . '_' . $i]) . "',";
		}
		return substr($sql, 0, -1);
	}

	public static function CloneSiteSettingFromSiteToSite($SrcSite, $DstSite) {
		$SiteFieldToUpdate = array(
			"site_bonus_point_valid_days", "site_default_language_id", "site_default_currency_id", "site_default_security_level", "site_sitemap_ignore_folder", "site_sitemap_always_now", "site_country_show_other", "site_use_bonus_point_at_once", "site_media_small_width", "site_media_small_height", "site_media_big_width", "site_media_big_height", "site_media_resize", "site_watermark_position", "site_folder_media_small_width", "site_folder_media_small_height", "site_product_media_small_width", "site_product_media_small_height", "site_product_media_big_width", "site_product_media_big_height", "site_product_media_resize", "site_email_sent_monthly_quota", "site_email_default_content", "site_email_custom_footer", "site_email_user_sender_override_site_sender", "site_email_unsubscribe_hide_mailing_list", "site_module_article_enable", "site_module_article_quota", "site_module_news_enable", "site_module_news_quota", "site_module_layout_news_enable", "site_module_layout_news_quota", "site_module_discount_rule_enable", "site_module_product_enable", "site_module_product_quota", "site_module_album_enable", "site_module_member_enable", "site_module_bonus_point_enable", "site_module_order_enable", "site_module_elasing_enable", "site_module_elasing_multi_level", "site_module_elasing_sender_name", "site_module_elasing_sender_address", "site_module_vote_enable", "site_module_inventory_enable", "site_module_inventory_partial_shipment", "site_module_group_buy_enable", "site_module_content_writer_enable", "site_module_workflow_enable", "site_module_objman_enable", "site_order_show_redeem_tab", "site_product_allow_under_stock", "site_product_stock_threshold_quantity", "site_auto_hold_stock_status", "site_product_category_special_max_no", "site_admin_logo_url", "site_vote_multi", "site_vote_guest", "site_invoice_enable", "site_invoice_header", "site_invoice_footer", "site_invoice_tnc", "site_invoice_show_product_code", "site_invoice_show_bonus_point", "site_invoice_show_product_image", "site_dn_enable", "site_dn_header", "site_dn_footer", "site_dn_tnc", "site_dn_show_product_code", "site_dn_show_product_image", "site_friendly_link_enable", "site_http_friendly_link_path", "site_label_product", "site_label_news", "site_label_layout_news", "site_order_serial_next_reset_date", "site_redeem_serial_next_reset_date", "site_order_serial_reset_type", "site_redeem_serial_reset_type", "site_order_no_format", "site_redeem_no_format"
		);

		$sql = '';
		foreach ($SiteFieldToUpdate as $F) {
			$sql = $sql . $F . " = '" . aveEscT($SrcSite[$F]) . "', ";
		}
		$sql = substr($sql, 0, -2);

		$query =	"	UPDATE	site " .
					"	SET		" . $sql .
					"	WHERE	site_id = '" . $DstSite['site_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$AllSiteFreight = site::GetAllSiteFreightObjList($SrcSite['site_id']);
		foreach ($AllSiteFreight as $SF) {
			/* @var $SF siteFreight */
			$update_sql =
					"	currency_id = '" . $SF->currency_id . "', " .
					"	site_freight_1_free_min_total_price = '" . $SF->site_freight_1_free_min_total_price . "', " .
					"	site_freight_1_cost = '" . $SF->site_freight_1_cost . "', " .
					"	site_freight_1_free_min_total_price_def = '" . $SF->site_freight_1_free_min_total_price_def . "', " .
					"	site_freight_2_free_min_total_price = '" . $SF->site_freight_2_free_min_total_price . "', " .
					"	site_freight_2_cost_percent = '" . $SF->site_freight_2_cost_percent . "', " .
					"	site_freight_2_free_min_total_price_def = '" . $SF->site_freight_2_free_min_total_price_def . "', " .
					"	site_freight_2_total_base_price_def = '" . $SF->site_freight_2_total_base_price_def . "' ";

			$query	=	"	INSERT INTO	site_freight " .
						"	SET		site_id = '" . $DstSite['site_id'] . "', " . $update_sql .
						"	ON DUPLICATE KEY UPDATE " . $update_sql;
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		$ObjectFieldsShow = site::GetObjectFieldsShow($SrcSite['site_id']);
		$query	=	"	INSERT INTO	object_fields_show " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
					"			object_security_level		= '". ynval($ObjectFieldsShow['object_security_level']) . "'," .
					"			object_archive_date			= '". ynval($ObjectFieldsShow['object_archive_date']) . "'," .
					"			object_publish_date			= '". ynval($ObjectFieldsShow['object_publish_date']) . "', " .
					"			object_lang_switch_id		= '". ynval($ObjectFieldsShow['object_lang_switch_id']) . "', " .
					"			object_seo_tab				= '". ynval($ObjectFieldsShow['object_seo_tab']) . "' " .
					"	ON DUPLICATE KEY UPDATE " .
					"			object_security_level		= '". ynval($ObjectFieldsShow['object_security_level']) . "'," .
					"			object_archive_date			= '". ynval($ObjectFieldsShow['object_archive_date']) . "'," .
					"			object_publish_date			= '". ynval($ObjectFieldsShow['object_publish_date']) . "', " .
					"			object_lang_switch_id		= '". ynval($ObjectFieldsShow['object_lang_switch_id']) . "', " .
					"			object_seo_tab				= '". ynval($ObjectFieldsShow['object_seo_tab']) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$MyOrderCustomFieldsDef = site::GetMyorderCustomFieldsDef($SrcSite['site_id']);
		$query	=	"	INSERT INTO	myorder_custom_fields_def " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
						self::getSiteToSiteSQL("myorder", "text", $MyOrderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("myorder", "int", $MyOrderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("myorder", "double", $MyOrderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("myorder", "date", $MyOrderCustomFieldsDef) . 
					"	ON DUPLICATE KEY UPDATE " .
						self::getSiteToSiteSQL("myorder", "text", $MyOrderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("myorder", "int", $MyOrderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("myorder", "double", $MyOrderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("myorder", "date", $MyOrderCustomFieldsDef);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$UserCustomFieldsDef = site::GetUserCustomFieldsDef($SrcSite['site_id']);
		$query	=	"	INSERT INTO	user_custom_fields_def " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
						self::getSiteToSiteSQL("user", "text", $UserCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("user", "int", $UserCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("user", "double", $UserCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("user", "date", $UserCustomFieldsDef) . 
					"	ON DUPLICATE KEY UPDATE " .
						self::getSiteToSiteSQL("user", "text", $UserCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("user", "int", $UserCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("user", "double", $UserCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("user", "date", $UserCustomFieldsDef);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$UserFieldsShow = site::GetUserFieldsShow($SrcSite['site_id']);
		$query	=	"	INSERT INTO	user_fields_show " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
					"			user_datafile			= '". ynval($UserFieldsShow['user_datafile']) . "', " .
					"			user_thumbnail_file_id	= '". ynval($UserFieldsShow['user_thumbnail_file_id']) . "', " .
					"			user_security_level		= '". ynval($UserFieldsShow['user_security_level']) . "', " .
					"			user_title				= '". ynval($UserFieldsShow['user_title']) . "', " .
					"			user_company_name		= '". ynval($UserFieldsShow['user_company_name']) . "', " .
					"			user_city_name			= '". ynval($UserFieldsShow['user_city_name']) . "', " .
					"			user_region				= '". ynval($UserFieldsShow['user_region']) . "', " .
					"			user_postcode			= '". ynval($UserFieldsShow['user_postcode']) . "', " .
					"			user_address_1			= '". ynval($UserFieldsShow['user_address_1']) . "', " .
					"			user_address_2			= '". ynval($UserFieldsShow['user_address_2']) . "', " .
					"			user_country_id			= '". ynval($UserFieldsShow['user_country_id']) . "', " .
					"			user_hk_district_id		= '". ynval($UserFieldsShow['user_hk_district_id']) . "', " .
					"			user_tel_country_code	= '". ynval($UserFieldsShow['user_tel_country_code']) . "', " .
					"			user_tel_area_code		= '". ynval($UserFieldsShow['user_tel_area_code']) . "', " .
					"			user_tel_no				= '". ynval($UserFieldsShow['user_tel_no']) . "', " .
					"			user_fax_country_code	= '". ynval($UserFieldsShow['user_fax_country_code']) . "', " .
					"			user_fax_area_code		= '". ynval($UserFieldsShow['user_fax_area_code']) . "', " .
					"			user_fax_no				= '". ynval($UserFieldsShow['user_fax_no']) . "', " .
					"			user_how_to_know_this_website	= '". ynval($UserFieldsShow['user_how_to_know_this_website']) . "', " .
					"			user_join_mailinglist		= '". ynval($UserFieldsShow['user_join_mailinglist']) . "', " .
					"			user_language_id		= '". ynval($UserFieldsShow['user_language_id']) . "', " .
					"			user_currency_id		= '". ynval($UserFieldsShow['user_currency_id']) . "', " .
					"			user_first_name			= '". ynval($UserFieldsShow['user_first_name']) . "', " .
					"			user_last_name			= '". ynval($UserFieldsShow['user_last_name']) . "', " .
					"			user_balance			= '". ynval($UserFieldsShow['user_balance']) . "' " .
					"	ON DUPLICATE KEY UPDATE " .
					"			user_datafile			= '". ynval($UserFieldsShow['user_datafile']) . "', " .
					"			user_thumbnail_file_id	= '". ynval($UserFieldsShow['user_thumbnail_file_id']) . "', " .
					"			user_security_level		= '". ynval($UserFieldsShow['user_security_level']) . "', " .
					"			user_title				= '". ynval($UserFieldsShow['user_title']) . "', " .
					"			user_company_name		= '". ynval($UserFieldsShow['user_company_name']) . "', " .
					"			user_city_name			= '". ynval($UserFieldsShow['user_city_name']) . "', " .
					"			user_region				= '". ynval($UserFieldsShow['user_region']) . "', " .
					"			user_postcode			= '". ynval($UserFieldsShow['user_postcode']) . "', " .
					"			user_address_1			= '". ynval($UserFieldsShow['user_address_1']) . "', " .
					"			user_address_2			= '". ynval($UserFieldsShow['user_address_2']) . "', " .
					"			user_country_id			= '". ynval($UserFieldsShow['user_country_id']) . "', " .
					"			user_hk_district_id		= '". ynval($UserFieldsShow['user_hk_district_id']) . "', " .
					"			user_tel_country_code	= '". ynval($UserFieldsShow['user_tel_country_code']) . "', " .
					"			user_tel_area_code		= '". ynval($UserFieldsShow['user_tel_area_code']) . "', " .
					"			user_tel_no				= '". ynval($UserFieldsShow['user_tel_no']) . "', " .
					"			user_fax_country_code	= '". ynval($UserFieldsShow['user_fax_country_code']) . "', " .
					"			user_fax_area_code		= '". ynval($UserFieldsShow['user_fax_area_code']) . "', " .
					"			user_fax_no				= '". ynval($UserFieldsShow['user_fax_no']) . "', " .
					"			user_how_to_know_this_website	= '". ynval($UserFieldsShow['user_how_to_know_this_website']) . "', " .
					"			user_join_mailinglist		= '". ynval($UserFieldsShow['user_join_mailinglist']) . "', " .
					"			user_language_id		= '". ynval($UserFieldsShow['user_language_id']) . "', " .
					"			user_currency_id		= '". ynval($UserFieldsShow['user_currency_id']) . "', " .
					"			user_first_name			= '". ynval($UserFieldsShow['user_first_name']) . "', " .
					"			user_last_name			= '". ynval($UserFieldsShow['user_last_name']) . "', " .
					"			user_balance			= '". ynval($UserFieldsShow['user_balance']) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$MyOrderFieldsShow = site::GetMyorderFieldsShow($SrcSite['site_id']);
		$query	=	"	INSERT INTO	myorder_fields_show " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
					"			self_take					= '". ynval($MyOrderFieldsShow['self_take']) . "', " .
					"			show_bonus_point_tab		= '". ynval($MyOrderFieldsShow['show_bonus_point_tab']) . "', " .
					"			show_deliver_address_tab	= '". ynval($MyOrderFieldsShow['show_deliver_address_tab']) . "', " .
					"			invoice_country_id			= '". ynval($MyOrderFieldsShow['invoice_country_id']) . "', " .
					"			invoice_hk_district_id		= '". ynval($MyOrderFieldsShow['invoice_hk_district_id']) . "', " .
					"			invoice_first_name			= '". ynval($MyOrderFieldsShow['invoice_first_name']) . "', " .
					"			invoice_last_name			= '". ynval($MyOrderFieldsShow['invoice_last_name']) . "', " .
					"			invoice_company_name		= '". ynval($MyOrderFieldsShow['invoice_company_name']) . "', " .
					"			invoice_city_name			= '". ynval($MyOrderFieldsShow['invoice_city_name']) . "', " .
					"			invoice_region				= '". ynval($MyOrderFieldsShow['invoice_region']) . "', " .
					"			invoice_postcode			= '". ynval($MyOrderFieldsShow['invoice_postcode']) . "', " .
					"			invoice_phone_no			= '". ynval($MyOrderFieldsShow['invoice_phone_no']) . "', " .
					"			invoice_tel_country_code	= '". ynval($MyOrderFieldsShow['invoice_tel_country_code']) . "', " .
					"			invoice_tel_area_code		= '". ynval($MyOrderFieldsShow['invoice_tel_area_code']) . "', " .
					"			invoice_fax_country_code	= '". ynval($MyOrderFieldsShow['invoice_fax_country_code']) . "', " .
					"			invoice_fax_area_code		= '". ynval($MyOrderFieldsShow['invoice_fax_area_code']) . "', " .
					"			invoice_fax_no				= '". ynval($MyOrderFieldsShow['invoice_fax_no']) . "', " .
					"			invoice_shipping_address_2	= '". ynval($MyOrderFieldsShow['invoice_shipping_address_2']) . "', " .
					"			delivery_country_id			= '". ynval($MyOrderFieldsShow['delivery_country_id']) . "', " .
					"			delivery_hk_district_id		= '". ynval($MyOrderFieldsShow['delivery_hk_district_id']) . "', " .
					"			delivery_first_name			= '". ynval($MyOrderFieldsShow['delivery_first_name']) . "', " .
					"			delivery_last_name			= '". ynval($MyOrderFieldsShow['delivery_last_name']) . "', " .
					"			delivery_company_name		= '". ynval($MyOrderFieldsShow['delivery_company_name']) . "', " .
					"			delivery_city_name			= '". ynval($MyOrderFieldsShow['delivery_city_name']) . "', " .
					"			delivery_region				= '". ynval($MyOrderFieldsShow['delivery_region']) . "', " .
					"			delivery_postcode			= '". ynval($MyOrderFieldsShow['delivery_postcode']) . "', " .
					"			delivery_phone_no			= '". ynval($MyOrderFieldsShow['delivery_phone_no']) . "', " .
					"			delivery_tel_country_code	= '". ynval($MyOrderFieldsShow['delivery_tel_country_code']) . "', " .
					"			delivery_tel_area_code		= '". ynval($MyOrderFieldsShow['delivery_tel_area_code']) . "', " .
					"			delivery_fax_no				= '". ynval($MyOrderFieldsShow['delivery_fax_no']) . "', " .
					"			delivery_fax_country_code	= '". ynval($MyOrderFieldsShow['delivery_fax_country_code']) . "', " .
					"			delivery_fax_area_code		= '". ynval($MyOrderFieldsShow['delivery_fax_area_code']) . "', " .
					"			delivery_shipping_address_2	= '". ynval($MyOrderFieldsShow['delivery_shipping_address_2']) . "', " .
					"			delivery_email				= '". ynval($MyOrderFieldsShow['delivery_email']) . "', " .
					"			user_balance_tab			= '". ynval($MyOrderFieldsShow['user_balance_tab']) . "' " .
					"	ON DUPLICATE KEY UPDATE " .
					"			self_take					= '". ynval($MyOrderFieldsShow['self_take']) . "', " .
					"			show_bonus_point_tab		= '". ynval($MyOrderFieldsShow['show_bonus_point_tab']) . "', " .
					"			show_deliver_address_tab	= '". ynval($MyOrderFieldsShow['show_deliver_address_tab']) . "', " .
					"			invoice_country_id			= '". ynval($MyOrderFieldsShow['invoice_country_id']) . "', " .
					"			invoice_hk_district_id		= '". ynval($MyOrderFieldsShow['invoice_hk_district_id']) . "', " .
					"			invoice_first_name			= '". ynval($MyOrderFieldsShow['invoice_first_name']) . "', " .
					"			invoice_last_name			= '". ynval($MyOrderFieldsShow['invoice_last_name']) . "', " .
					"			invoice_company_name		= '". ynval($MyOrderFieldsShow['invoice_company_name']) . "', " .
					"			invoice_city_name			= '". ynval($MyOrderFieldsShow['invoice_city_name']) . "', " .
					"			invoice_region				= '". ynval($MyOrderFieldsShow['invoice_region']) . "', " .
					"			invoice_postcode			= '". ynval($MyOrderFieldsShow['invoice_postcode']) . "', " .
					"			invoice_phone_no			= '". ynval($MyOrderFieldsShow['invoice_phone_no']) . "', " .
					"			invoice_tel_country_code	= '". ynval($MyOrderFieldsShow['invoice_tel_country_code']) . "', " .
					"			invoice_tel_area_code		= '". ynval($MyOrderFieldsShow['invoice_tel_area_code']) . "', " .
					"			invoice_fax_country_code	= '". ynval($MyOrderFieldsShow['invoice_fax_country_code']) . "', " .
					"			invoice_fax_area_code		= '". ynval($MyOrderFieldsShow['invoice_fax_area_code']) . "', " .
					"			invoice_fax_no				= '". ynval($MyOrderFieldsShow['invoice_fax_no']) . "', " .
					"			invoice_shipping_address_2	= '". ynval($MyOrderFieldsShow['invoice_shipping_address_2']) . "', " .
					"			delivery_country_id			= '". ynval($MyOrderFieldsShow['delivery_country_id']) . "', " .
					"			delivery_hk_district_id		= '". ynval($MyOrderFieldsShow['delivery_hk_district_id']) . "', " .
					"			delivery_first_name			= '". ynval($MyOrderFieldsShow['delivery_first_name']) . "', " .
					"			delivery_last_name			= '". ynval($MyOrderFieldsShow['delivery_last_name']) . "', " .
					"			delivery_company_name		= '". ynval($MyOrderFieldsShow['delivery_company_name']) . "', " .
					"			delivery_city_name			= '". ynval($MyOrderFieldsShow['delivery_city_name']) . "', " .
					"			delivery_region				= '". ynval($MyOrderFieldsShow['delivery_region']) . "', " .
					"			delivery_postcode			= '". ynval($MyOrderFieldsShow['delivery_postcode']) . "', " .
					"			delivery_phone_no			= '". ynval($MyOrderFieldsShow['delivery_phone_no']) . "', " .
					"			delivery_tel_country_code	= '". ynval($MyOrderFieldsShow['delivery_tel_country_code']) . "', " .
					"			delivery_tel_area_code		= '". ynval($MyOrderFieldsShow['delivery_tel_area_code']) . "', " .
					"			delivery_fax_no				= '". ynval($MyOrderFieldsShow['delivery_fax_no']) . "', " .
					"			delivery_fax_country_code	= '". ynval($MyOrderFieldsShow['delivery_fax_country_code']) . "', " .
					"			delivery_fax_area_code		= '". ynval($MyOrderFieldsShow['delivery_fax_area_code']) . "', " .
					"			delivery_shipping_address_2	= '". ynval($MyOrderFieldsShow['delivery_shipping_address_2']) . "', " .
					"			delivery_email				= '". ynval($MyOrderFieldsShow['delivery_email']) . "', " .
					"			user_balance_tab			= '". ynval($MyOrderFieldsShow['user_balance_tab']) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductCustomFieldsDef = site::GetProductCustomFieldsDef($SrcSite['site_id']);
		$query	=	"	INSERT INTO	product_custom_fields_def " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
						self::getSiteToSiteSQL("product", "text", $ProductCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product", "int", $ProductCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product", "double", $ProductCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product", "date", $ProductCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product", "rgb", $ProductCustomFieldsDef) . ", " .
					"	product_price1 = '" . aveEsc($ProductCustomFieldsDef['product_price1']) . "', " .
					"	product_price2 = '" . aveEsc($ProductCustomFieldsDef['product_price2']) . "', " .
					"	product_price3 = '" . aveEsc($ProductCustomFieldsDef['product_price3']) . "', " .
					"	product_price4 = '" . aveEsc($ProductCustomFieldsDef['product_price4']) . "', " .
					"	product_price5 = '" . aveEsc($ProductCustomFieldsDef['product_price5']) . "', " .
					"	product_price6 = '" . aveEsc($ProductCustomFieldsDef['product_price6']) . "', " .
					"	product_price7 = '" . aveEsc($ProductCustomFieldsDef['product_price7']) . "', " .
					"	product_price8 = '" . aveEsc($ProductCustomFieldsDef['product_price8']) . "', " .
					"	product_price9 = '" . aveEsc($ProductCustomFieldsDef['product_price9']) . "' " .
					"	ON DUPLICATE KEY UPDATE " .
						self::getSiteToSiteSQL("product", "text", $ProductCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product", "int", $ProductCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product", "double", $ProductCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product", "date", $ProductCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product", "rgb", $ProductCustomFieldsDef) . ", " .
					"	product_price1 = '" . aveEsc($ProductCustomFieldsDef['product_price1']) . "', " .
					"	product_price2 = '" . aveEsc($ProductCustomFieldsDef['product_price2']) . "', " .
					"	product_price3 = '" . aveEsc($ProductCustomFieldsDef['product_price3']) . "', " .
					"	product_price4 = '" . aveEsc($ProductCustomFieldsDef['product_price4']) . "', " .
					"	product_price5 = '" . aveEsc($ProductCustomFieldsDef['product_price5']) . "', " .
					"	product_price6 = '" . aveEsc($ProductCustomFieldsDef['product_price6']) . "', " .
					"	product_price7 = '" . aveEsc($ProductCustomFieldsDef['product_price7']) . "', " .
					"	product_price8 = '" . aveEsc($ProductCustomFieldsDef['product_price8']) . "', " .
					"	product_price9 = '" . aveEsc($ProductCustomFieldsDef['product_price9']) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductFieldsShow = site::GetProductFieldsShow($SrcSite['site_id']);
		$query	=	"	INSERT INTO	product_fields_show " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
					"			product_color_id			= '". ynval($ProductFieldsShow['product_color_id']) . "'," .
					"			factory_code				= '". ynval($ProductFieldsShow['factory_code']) . "'," .
					"			product_code				= '". ynval($ProductFieldsShow['product_code']) . "'," .
					"			product_weight				= '". ynval($ProductFieldsShow['product_weight']) . "'," .
					"			product_size				= '". ynval($ProductFieldsShow['product_size']) . "'," .
					"			product_LWD					= '". ynval($ProductFieldsShow['product_LWD']) . "'," .
					"			product_name				= '". ynval($ProductFieldsShow['product_name']) . "'," .
					"			product_color				= '". ynval($ProductFieldsShow['product_color']) . "'," .
					"			product_packaging			= '". ynval($ProductFieldsShow['product_packaging']) . "'," .
					"			product_desc				= '". ynval($ProductFieldsShow['product_desc']) . "'," .
					"			product_tag					= '". ynval($ProductFieldsShow['product_tag']) . "', " .
					"			product_discount			= '". ynval($ProductFieldsShow['product_discount']) . "', " .
					"			product_special_category	= '". ynval($ProductFieldsShow['product_special_category']) . "', " .
					"			product_option				= '". ynval($ProductFieldsShow['product_option']) . "', " .
					"			product_option_show_no		= '". intval($ProductFieldsShow['product_option_show_no']) . "', " .
					"			product_datafile			= '". ynval($ProductFieldsShow['product_datafile']) . "', " .
					"			product_brand_id			= '". ynval($ProductFieldsShow['product_brand_id']) . "'" .
					"	ON DUPLICATE KEY UPDATE " .
					"			product_color_id			= '". ynval($ProductFieldsShow['product_color_id']) . "'," .
					"			factory_code				= '". ynval($ProductFieldsShow['factory_code']) . "'," .
					"			product_code				= '". ynval($ProductFieldsShow['product_code']) . "'," .
					"			product_weight				= '". ynval($ProductFieldsShow['product_weight']) . "'," .
					"			product_size				= '". ynval($ProductFieldsShow['product_size']) . "'," .
					"			product_LWD					= '". ynval($ProductFieldsShow['product_LWD']) . "'," .
					"			product_name				= '". ynval($ProductFieldsShow['product_name']) . "'," .
					"			product_color				= '". ynval($ProductFieldsShow['product_color']) . "'," .
					"			product_packaging			= '". ynval($ProductFieldsShow['product_packaging']) . "'," .
					"			product_desc				= '". ynval($ProductFieldsShow['product_desc']) . "'," .
					"			product_tag					= '". ynval($ProductFieldsShow['product_tag']) . "', " .
					"			product_discount			= '". ynval($ProductFieldsShow['product_discount']) . "', " .
					"			product_special_category	= '". ynval($ProductFieldsShow['product_special_category']) . "', " .
					"			product_option				= '". ynval($ProductFieldsShow['product_option']) . "', " .
					"			product_option_show_no		= '". intval($ProductFieldsShow['product_option_show_no']) . "', " .
					"			product_datafile			= '". ynval($ProductFieldsShow['product_datafile']) . "', " .
					"			product_brand_id			= '". ynval($ProductFieldsShow['product_brand_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductBrandCustomFieldsDef = site::GetProductBrandCustomFieldsDef($SrcSite['site_id']);
		$query	=	"	INSERT INTO	product_brand_custom_fields_def " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
						self::getSiteToSiteSQL("product_brand", "text", $ProductBrandCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product_brand", "int", $ProductBrandCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product_brand", "double", $ProductBrandCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product_brand", "date", $ProductBrandCustomFieldsDef) . 
					"	ON DUPLICATE KEY UPDATE " .
						self::getSiteToSiteSQL("product_brand", "text", $ProductBrandCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product_brand", "int", $ProductBrandCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product_brand", "double", $ProductBrandCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product_brand", "date", $ProductBrandCustomFieldsDef);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductBrandFieldsShow = site::GetProductBrandFieldsShow($SrcSite['site_id']);
		$query	=	"	INSERT INTO	product_brand_fields_show " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
					"			product_brand_name			= '". ynval($ProductBrandFieldsShow['product_brand_name']) . "'," .
					"			product_brand_desc			= '". ynval($ProductBrandFieldsShow['product_brand_desc']) . "'" .
					"	ON DUPLICATE KEY UPDATE " .
					"			product_brand_name			= '". ynval($ProductBrandFieldsShow['product_brand_name']) . "'," .
					"			product_brand_desc			= '". ynval($ProductBrandFieldsShow['product_brand_desc']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductCategoryFieldsShow = site::GetProductCatFieldsShow($SrcSite['site_id']);
		$query	=	"	INSERT INTO	product_category_fields_show " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
					"			product_category_media_list	= '". ynval($ProductCategoryFieldsShow['product_category_media_list']) . "', " .
					"			product_category_group_fields = '". ynval($ProductCategoryFieldsShow['product_category_group_fields']) . "' " .
					"	ON DUPLICATE KEY UPDATE " .
					"			product_category_media_list	= '". ynval($ProductCategoryFieldsShow['product_category_media_list']) . "', " .
					"			product_category_group_fields = '". ynval($ProductCategoryFieldsShow['product_category_group_fields']) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ProductCategoryCustomFieldsDef = site::GetProductCategoryCustomFieldsDef($SrcSite['site_id']);
		$query	=	"	INSERT INTO	product_category_custom_fields_def " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
						self::getSiteToSiteSQL("product_category", "text", $ProductCategoryCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product_category", "int", $ProductCategoryCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product_category", "double", $ProductCategoryCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product_category", "date", $ProductCategoryCustomFieldsDef) . 
					"	ON DUPLICATE KEY UPDATE " .
						self::getSiteToSiteSQL("product_category", "text", $ProductCategoryCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product_category", "int", $ProductCategoryCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product_category", "double", $ProductCategoryCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("product_category", "date", $ProductCategoryCustomFieldsDef);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$AlbumCustomFieldsDef = site::GetAlbumCustomFieldsDef($SrcSite['site_id']);
		$query	=	"	INSERT INTO	album_custom_fields_def " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
						self::getSiteToSiteSQL("album", "text", $AlbumCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("album", "int", $AlbumCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("album", "double", $AlbumCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("album", "date", $AlbumCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("album", "file", $AlbumCustomFieldsDef) .
					"	ON DUPLICATE KEY UPDATE " .
						self::getSiteToSiteSQL("album", "text", $AlbumCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("album", "int", $AlbumCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("album", "double", $AlbumCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("album", "date", $AlbumCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("album", "file", $AlbumCustomFieldsDef);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$MediaCustomFieldsDef = site::GetMediaCustomFieldsDef($SrcSite['site_id']);
		$query	=	"	INSERT INTO	media_custom_fields_def " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
						self::getSiteToSiteSQL("media", "text", $MediaCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("media", "int", $MediaCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("media", "double", $MediaCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("media", "date", $MediaCustomFieldsDef) . 
					"	ON DUPLICATE KEY UPDATE " .
						self::getSiteToSiteSQL("media", "text", $MediaCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("media", "int", $MediaCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("media", "double", $MediaCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("media", "date", $MediaCustomFieldsDef);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$FolderCustomFieldsDef = site::GetFolderCustomFieldsDef($SrcSite['site_id']);
		$query	=	"	INSERT INTO	folder_custom_fields_def " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
						self::getSiteToSiteSQL("folder", "text", $FolderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("folder", "int", $FolderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("folder", "double", $FolderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("folder", "date", $FolderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("folder", "rgb", $FolderCustomFieldsDef) .
					"	ON DUPLICATE KEY UPDATE " .
						self::getSiteToSiteSQL("folder", "text", $FolderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("folder", "int", $FolderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("folder", "double", $FolderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("folder", "date", $FolderCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("folder", "rgb", $FolderCustomFieldsDef);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$DataFileCustomFieldsDef = site::GetDatafileCustomFieldsDef($SrcSite['site_id']);
		$query	=	"	INSERT INTO	datafile_custom_fields_def " .
					"	SET		site_id = '" . $DstSite['site_id'] . "', " .
						self::getSiteToSiteSQL("datafile", "text", $DataFileCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("datafile", "int", $DataFileCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("datafile", "double", $DataFileCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("datafile", "date", $DataFileCustomFieldsDef) . 
					"	ON DUPLICATE KEY UPDATE " .
						self::getSiteToSiteSQL("datafile", "text", $DataFileCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("datafile", "int", $DataFileCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("datafile", "double", $DataFileCustomFieldsDef) . ", " .
						self::getSiteToSiteSQL("datafile", "date", $DataFileCustomFieldsDef);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);


	}

	public static function CloneSiteContentAndSettingFromSiteToSite($SrcSiteID, $DstSiteID) {
		$SrcSite = site::GetSiteInfo($SrcSiteID);
		$DstSite = site::GetSiteInfo($DstSiteID);

		$SrcSiteLanguageRoots = language::GetAllSiteLanguageRoot($SrcSite['site_id'], 'N', 'Y');

		foreach ($SrcSiteLanguageRoots as $R) {
			$DstSiteLanguageRoot = language::GetSiteLanguageRoot($R['language_id'], $DstSite['site_id']);

			if ($DstSiteLanguageRoot == null) {
				$TheLanguage = language::GetLanguageInfo($R['language_id']);

				$NewDstLanguageRootID = object::NewObject('LANGUAGE_ROOT', $DstSite['site_id'], 0);

				$query	=	"	INSERT INTO	language_root " .
							"	SET		language_id 			= '" . intval($R['language_id']) . "', " .
							"			index_link_id			= 0, " .
							"			language_root_id		= '". intval($NewDstLanguageRootID) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

				object::NewObjectLink($DstSite['site_root_id'], $NewDstLanguageRootID, $TheLanguage['language_native'], $TheLanguage['language_id'], 'normal', DEFAULT_ORDER_ID);

				object::TidyUpObjectOrder($DstSite['site_root_id']);
			}
		}

		site::CloneSiteSettingFromSiteToSite($SrcSite, $DstSite);

		// Reload the $DstSite setting
		$DstSite = site::GetSiteInfo($DstSiteID);

		// Clone Site Block
		block::CloneAllSiteBlockFromSiteToSite($SrcSite, $DstSite);

		// Clone All Album
		album::CloneAllAlbumFromSiteToSite($SrcSite, $DstSite);

		// Clone all layouts...
		$Layouts = layout::GetLayoutList($SrcSite['site_id']);
		foreach ($Layouts as $L) {
			layout::CloneLayout($SrcSite, $L, $DstSite);
		}

		foreach ($SrcSiteLanguageRoots as $R) {
		// Clone all news
			news::CloneAllNewsCategory($SrcSite, $R['language_id'], $R['language_id'], $DstSite);
			$NewsRoots = news::GetNewsRootList($R['language_id'], $SrcSite['site_id']);

			foreach ($NewsRoots as $NR) {
				news::CloneNewsRoot($NR, $SrcSite, $R['language_id'], $NewObjectID, 'N', $DstSite);
				echo "New News Root = " . $NewObjectID . " <br />\n";
			}

		// Clone all layout news
			layout_news::CloneAllLayoutNewsCategory($SrcSite, $R['language_id'], $R['language_id'], $DstSite);

			$LayoutNewsRoots = layout_news::GetLayoutNewsRootList($R['language_id'], $SrcSite['site_id']);

			foreach ($LayoutNewsRoots as $LNR) {
				layout_news::CloneLayoutNewsRoot($LNR, $SrcSite, $R['language_id'], $NewObjectID, 'N', $DstSite);
				echo "New Layout News Root = " . $NewObjectID . " <br />\n";
			}
		}

		// Clone All Product Brands
		product::CloneAllProductBrandFromSiteToSite($SrcSite, $DstSite);

		// Clone product category special 
		product::CloneProductCategorySpecialFromSiteToSite($SrcSite, $DstSite);

		// Clone All product
		product::CloneAllProductRootFromSiteToSite($SrcSite, $DstSite);

		foreach ($SrcSiteLanguageRoots as $SLR) {
			$DstSiteLanguageRoot = language::GetSiteLanguageRoot($SLR['language_id'], $DstSite['site_id']);
			language::CopyLanguageTree($SLR, $DstSiteLanguageRoot, $SrcSite, $DstSite);
		}

		site::EmptyAPICache($DstSite['site_id']);
	}

	public static function UpdateSiteStucturedSeoUrlTable($Site) {
		$query =	"	DELETE FROM 	object_structure_seo_url " .
					"	WHERE	site_id = '" . intval($Site['site_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$SiteRoot = object::GetObjectInfo($Site['site_root_id']);

		object::UpdateStructuredSeoURL($SiteRoot, 0, $Site, '', 0);

		site::EmptyAPICache($Site['site_id']);
	}

	/**
	 * 
	 * @param int $SiteID
	 * @param int $CurrencyID
	 * @return \siteFreight
	 */
	public static function GetSiteFreightObj($SiteID, $CurrencyID) {
		$query =	"	SELECT	* " .
					"	FROM	site_freight " .
					"	WHERE	site_id = '" . intval($SiteID) . "'" .
					"		AND	currency_id = '" . intval($CurrencyID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_object();
		else
			return new siteFreight($SiteID, $CurrencyID);
	}

	public static function GetAllSiteFreightObjList ($SiteID) {
		$query =	"	SELECT	* " .
					"	FROM	site_freight F LEFT JOIN currency C ON (F.currency_id = C.currency_id) " .
					"	WHERE	F.site_id = '" . intval($SiteID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$SiteFreightObjList = array();
		while ($myResult = $result->fetch_object()) {
			array_push($SiteFreightObjList, $myResult);
		}
		return $SiteFreightObjList;
	}

	public static function IncrementApiStats($SiteID, $FileName, $Remark = '') {
		$query =	"	INSERT INTO api_stats " .
					"	SET			site_id = '" . intval($SiteID) . "', " .
					"				filename = '" . aveEscT($FileName) . "', " .
					"				remark = '" . aveEscT($Remark) . "', " .
					"				counter = 1 " .
					"	ON DUPLICATE KEY UPDATE counter = counter + 1 ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	
	public static function GetCallbackLog($SiteID, &$TotalLog, $PageNo = 1, $LogPerPage = 50, $Status = "hard_fail", $excludeEmptyCache = "Y") {
		$Offset = intval(($PageNo -1) * $LogPerPage);

		$status_sql = '';
		if ($Status == "hard_fail")
			$status_sql = " AND L.callback_hard_fail = 'Y' ";			
		else if ($Status == 'not_ok_only')
			$status_sql = " AND L.callback_result != 'OK' ";
		
		$exclude_empty_cache_sql = '';
		if ($excludeEmptyCache == 'Y')
			$exclude_empty_cache_sql = " AND L.string_1 != 'Empty Cache' ";
		
		$site_sql = '';
		if ($SiteID != 0)
			$site_sql = " AND S.site_id = '" . intval($SiteID) . "'";
		$where_sql = $status_sql . $exclude_empty_cache_sql . $site_sql;
		if (strlen($where_sql) > 0)
			$where_sql = "WHERE " . substr ($where_sql, 4);
		
		$query =	"	SELECT	SQL_CALC_FOUND_ROWS * " .
					"	FROM	callback_log L JOIN site S ON (L.site_id = S.site_id) " .
					$where_sql .
					"	ORDER BY L.callback_log_id DESC " .
					"	LIMIT	" . $Offset . ", " . intval($LogPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalLog = $myResult[0];

		$LogList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($LogList, $myResult);
		}
		return $LogList;		
	}
}

class siteFreight {
	public $site_freight_id = 0;
	public $site_id;
	public $currency_id = 0;
	public $site_freight_1_free_min_total_price = 0;
	public $site_freight_1_cost = 0;
	public $site_freight_1_free_min_total_price_def = 0;
	public $site_freight_2_free_min_total_price = 0;
	public $site_freight_2_cost_percent = 0;
	public $site_freight_2_free_min_total_price_def = 0;
	public $site_freight_2_total_base_price_def = 0;

	public function siteFreight($_siteID, $_currencyID) {
		$this->site_id = $_siteID;
		$this->currency_id = $_currencyID;
	}
}