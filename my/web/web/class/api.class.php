<?php
//  Version: 1.2 - 20161128 (Jeff)
//		Add returnRAW parameter
//		
//	Version: 1.1 - 20150114 (Jeff)
//		[This version should be backward compatible. But you need to update the wrapper function ApiQuery in config.php]
//			
//			function ApiQuery($api_call, $line_no, $parameter = '', $Cache = true, $Dump = false, $PostValueArray = null, $StripSlashes = false) {
//				return api::Singleton()->ApiQuery($api_call, $line_no, $parameter, $Cache, $Dump, $PostValueArray, $StripSlashes);
//			}
//		
//		ApiQuery Changes (Skip to explaination if not interested):
//			1) Will automatically die at the end when $Dump is true so that you can view the XML in browser
//			2) will use POST instead of GET if $PostValueArray is not null. This is useful when large amount of data is needed to pass via API.  
//			3) You need to pass $api_call, always! $parameter is ignored if $PostValueArray is used (NO NEED url_encode)
//			4) Will use md5 value for cache searching key... how dumb I was...
//			
//		Explaination:
//		ApiQuery($api_call, $line_no, $parameter = '', $Cache = true, $Dump = false, $PostValueArray = null, $StripSlashes = false)
//			$parameter - only needed when you are using the old method call (submit by get as url parameter, you will need to urlencode)
//			$PostValueArray - if this is not null, post method will be used (perferred method). 
//				This should be ALWAYS an one dimensional array and NO NEED to urlencode the value.
//					CORRECT:	$PostValueArray['product_desc[1]'] = "Product Desc For 'English' !&%";
//					WRONG:		$PostValueArray['product_desc'][1] = "Product Desc For 'English' !&%";
//					WRONG:		$PostValueArray['product_desc[1]'] = urlencode("Product Desc For 'English' !&%");
//			$StripSlashes - If you enabled ENABLE_MAGIC_QUOTE and pass something like this $PostValueArray['username'] = $_REQUEST['username'];, pass true to remove the slash.
//				All values pass via API should be original no slash text. 
//					CORRECT:	$PostValueArray['good'] = "i'm a boy" 
//					WRONG:		$PostValueArray['good'] = "i\'m a boy"
//			$StripSlashes = true will turn "i\'m a boy" => "i'm a boy". If ENABLE_MAGIC_QUOTE is enable, $_REQUEST will be "i\'m a boy"
//	Version: 1.0 - Initial Release
class api {
	
	function __construct() {
	}
	
	public static function Singleton() {
		static $instance = null;

		if ($instance === null) {
			$instance = new api();
			$instance->mysqli = mysqli_connect(API_DB_HOST, API_DB_USER, API_DB_PASSWD, API_DB_NAME);
			$instance->mysqli->set_charset('utf8');
		}
		return $instance;
	}
	
	
	public function ApiQuery($api_call, $line_no, $parameter = '', $Cache = true, $Dump = false, $PostValueArray = null, $StripSlashes = false, $returnRaw = false) {

		$this->PrepareApiSelectStmt();

		if ($Cache && in_array($api_call, $this->CacheableAPICalls)) {
			$SITE_ID = SITE_ID;
			$API_ENV = API_ENV;

			$Md5Key = md5($api_call . "?" . $parameter);

			if ($PostValueArray != null)
				$Md5Key = md5(json_encode($PostValueArray)); // This is faster than serialize

//			$this->api_select_stmt->bind_param("isss", $SITE_ID, $API_ENV, $api_call, $parameter);
			$this->api_select_stmt->bind_param("iss", $SITE_ID, $API_ENV, $Md5Key);
			$this->api_select_stmt->execute();
			$this->api_select_stmt->store_result();
			$this->api_select_stmt->bind_result($api_result_xml);


			if ($this->api_select_stmt->fetch()) {
				if ($Dump) {
					header('Content-type: text/xml');
					echo $api_result_xml;
//					echo "<query>" . xmlentities($Query) . "</query>";
					die();
					return;
				}
				else {
					$xml = new SimpleXMLElement($api_result_xml);
					return $xml;					
				}
			}
		}
		$Result = false;

		if (API_CALL_LIB == 'CURL' && 1==2) {

			if ($this->curl_connection == null) {
				$this->curl_connection = api::InitCURL('citizen-cms.tangent.sg');				/*
				$this->curl_connection = curl_init();
				$timeout = 30;
				curl_setopt ($this->curl_connection, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($this->curl_connection, CURLOPT_CONNECTTIMEOUT, $timeout);
				curl_setopt ($this->curl_connection, CURLOPT_FRESH_CONNECT, false);
				curl_setopt ($this->curl_connection, CURLOPT_DNS_USE_GLOBAL_CACHE, true);
	//			register_shutdown_function('ApiQueryEnd');
		*/
			}

			if ($PostValueArray != null) {
				curl_setopt ($this->curl_connection, CURLOPT_POST, true);
				$PostValueArray['api_login'] = api_login;
				$PostValueArray['api_key'] = api_key;

				if ($StripSlashes) {
					foreach ($PostValueArray as $k => $v)
						$PostValueArray[$k] = stripslashes($v); // No recursive needed here as $PostValueArray should be one dimension, http post value is one dimension only.
				}

				curl_setopt ($this->curl_connection, CURLOPT_POSTFIELDS, $PostValueArray);
				$Query = API_BASEURL . $api_call;
				curl_setopt ($this->curl_connection, CURLOPT_URL, $Query);
			}
			else {
				curl_setopt ($this->curl_connection, CURLOPT_POST, false);
				$Query = API_BASEURL . $api_call . '?api_login=' . api_login . '&api_key=' . api_key . '&' . $parameter;
				curl_setopt ($this->curl_connection, CURLOPT_URL, $Query);			
			}

			$startime = 0;
			if (API_LOGGING && in_array($api_call, $this->LogAPICalls)) {
				$startime = microtime(true);
				LogAPI($Query);
			}
		//	$Result = @file_get_contents($Query);
			$Result = curl_exec($this->curl_connection);

			if (API_LOGGING && in_array($api_call, $this->LogAPICalls)) {
				$endtime = microtime(true);
				LogAPI($Result);
				LogAPI('API Return Time: ' . ($endtime-$startime));
			}
		}
		else {
			$Query = API_BASEURL . $api_call . '?api_login=' . api_login . '&api_key=' . api_key . '&' . $parameter;
			
			$startime = 0;
			if (API_LOGGING && in_array($api_call, $this->LogAPICalls)) {
				$startime = microtime(true);
				LogAPI($Query);
			}

			$Result = file_get_contents($Query);

			if (API_LOGGING && in_array($api_call, $this->LogAPICalls)) {
				$endtime = microtime(true);
				LogAPI($Result);
				LogAPI('API Return Time: ' . ($endtime-$startime));
			}	
		}

		if ($Result === false)

			die('API Error: Error connecting to server. (' . $line_no . ')');
		if (API_LOGGING && in_array($api_call, $this->LogAPICalls)) {
			$startime = microtime(true);
		}
		if ($Dump) {
			header('Content-type: text/xml');
			echo $Result;
//			echo "<query>" . xmlentities($Query) . "</query>";
			die();
			return;
		}

		if ($returnRaw) {
			return $Result;
		}
		$xml = new SimpleXMLElement($Result);

		if (API_LOGGING) {
			$endtime = microtime(true);
			LogAPI('XML Parse Time: ' . ($endtime-$startime));
		}

		if ($xml->data->result == 'Fail')
			die('API Error ' . $xml->data->error_code . ': ' . $xml->data->error_string . '(' . $line_no . ')');

		if (in_array($api_call, $this->CacheableAPICalls)) {
			$this->PrepareApiInsertStmt();

			$SITE_ID = SITE_ID;
			$API_ENV = API_ENV;
//			$this->api_insert_stmt->bind_param('issss', $SITE_ID, $API_ENV, $api_call, $parameter, $Result);
			$this->api_insert_stmt->bind_param('isss', $SITE_ID, $API_ENV, $Md5Key, $Result);
			$this->api_insert_stmt->execute();
		}

		return $xml;
	}

	public static function ave_mysql_query($query, $filename, $lineno, $dieOnError = true) {
		$starttime = 0;
		$endtime = 0;
		if (DEBUG) {
			$starttime = microtime(true);
		}

		$result = api::Singleton()->mysqli->query($query);

		if (DEBUG) {
			$endtime = microtime(true);

			if (($endtime - $starttime) > SQL_HEAVY_VALUE) {
				$fp = fopen(SQL_HEAVY_LOG, "a");
				if ($fp) {
					fwrite( $fp, "URL: " . curPageURL() . "\n");
					fwrite( $fp, "Time used: " . ($endtime - $starttime) . "\n" );
					fwrite( $fp, trim($query) . "\n\n" );
				}
				fclose($fp);
			}

			if (SQL_LOGGING) {
				$fp = fopen(SQL_LOG, "a");
				if ($fp) {
					fwrite( $fp, "Time used: " . ($endtime - $starttime) . "\n" );
					fwrite( $fp, trim($query) . "\n\n" );
				}
				fclose($fp);
			}
		}

		if ($result === false) {
			api::Singleton()->err_die(1, $query, api::Singleton()->mysqli->error, $filename, $lineno, $dieOnError);
		}
		
		return $result;
	}	
	
	public function err_die($error_no, $detail1, $detail2, $filename, $lineno, $dieOnError) {
		if (!isset($_SESSION['UserID']))
			$UserID = 0;
		else
			$UserID = $_SESSION['UserID'];

		$ip = ip2long(getenv ("REMOTE_ADDR"));

		$query =	"	INSERT INTO errorlog " .
					"	SET error_no			= " . $error_no . ", " . 
					"		errorlog_detail_1	= '" . $this->mysqli->real_escape_string($detail1) . "', " .
					"		errorlog_detail_2	= '" . $this->mysqli->real_escape_string($detail2) . "', " .
					"		errorlog_filename	= '" . $this->mysqli->real_escape_string($filename) . "', " .
					"		errorlog_lineno		= '" . $lineno . "', " .
					"		user_id				= " . $UserID . ", " .
					"		user_ip				= '" . $ip . "', " .
					"		site_id				= '" . SITE_ID . "', " .
					"		api_server_type		= '" . API_ENV . "'";

		$result = $this->mysqli->query($query) or ("Query failed at line ". __LINE__ . ": " . $this->mysqli->error);
		$error_ticket_no = $this->mysqli->insert_id;
		$GLOBALS["smarty"]->assign('errorticketno',$error_ticket_no);


		if ($dieOnError) {
			if (DEBUG) {
				die(
					"Error No: " . $error_no . "<hr />" .
					"Detail 1: " . $detail1 . "<hr />" .
					"Detail 2: " . $detail2 . "<hr />" .
					"Filename: " . $filename . "<hr />" .
					"Line No: " . $lineno . "<hr />"
				);				
			}
			else {
				die(
					"Error No: " . $error_no . "<hr />" .
					"Filename: " . $filename . "<hr />" .
					"Line No: " . $lineno . "<hr />"
				);
			}
		}
	}	
	
	public static function InitCURL($url) {
		$ch = curl_init();
		$timeout = 30;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	//		curl_setopt ($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
	//		curl_setopt($ch, CURLOPT_USERPWD, 'fb_cv:fb_cv');
		return $ch;
	}	

	private function PrepareApiSelectStmt() {

		if ($this->api_select_stmt == null) {
//			$query	=	'
//							SELECT	api_result_xml 
//							FROM	api_cache
//							WHERE	site_id				= ?
//								AND	api_server_type		= ?
//								AND	api_call			= ?
//								AND	api_query_string	= ?
//						';
			$query	=	'
							SELECT	api_result_xml 
							FROM	api_cache
							WHERE	site_id				= ?
								AND	api_server_type		= ?
								AND api_md5_key			= ?
						';
			$this->api_select_stmt = $this->mysqli->stmt_init();

			if (!$this->api_select_stmt->prepare($query)){
				die("Line " . __LINE__ . ": Statment Prepare Error: " . $this->api_select_stmt->error);
			}
		}
		else{
			@$this->api_select_stmt->reset();
		}
	}
	
	private function PrepareApiInsertStmt() {
		if ($this->api_insert_stmt == null) {
//			$query =	'
//							INSERT INTO	api_cache
//							SET		site_id				= ?,
//									api_server_type		= ?,
//									api_call			= ?,
//									api_query_string	= ?,
//									api_result_xml		= ?,
//									api_md5_key			= ?
//						';
			$query =	'
							INSERT INTO	api_cache
							SET		site_id				= ?,
									api_server_type		= ?,
									api_md5_key			= ?,
									api_result_xml		= ?
						';
			$this->api_insert_stmt = $this->mysqli->stmt_init();

			if (!$this->api_insert_stmt->prepare($query))
				die("Line " . __LINE__ . ": Statment Prepare Error: " . $this->api_insert_stmt->error);
		}
		else
			$this->api_insert_stmt->reset();		
	}
	
	private $mysqli = null;
	private $api_select_stmt = null;
	private $api_insert_stmt = null;
	private $curl_connection = null;
	
	private $CacheableAPICalls =
		array(
			'album_get_info.php',
			'bonus_point_item_details.php',
			'country_list.php',
			'currency_info.php',
			'currency_list.php',
			'file_get_info.php',
			'folder_find_by_name.php',
			'folder_get_tree.php',
			'folder_get_tree_in_ulli.php',
			'hk_district_list.php',
			'language_root_info.php',
			'language_root_list.php',
			'layout_news_category_list.php',
			'layout_news_get_info.php',
			'layout_news_list.php',
			'layout_news_page_get_info.php',
			'link_get_info.php',
			'news_category_list.php',
			'news_get_info.php',
			'news_list.php',
			'news_page_get_info.php',
			'object_get_info.php',
			'object_link_get_info.php',
			'object_link_get_path.php',
			'page_get_info.php',
			'product_category_info.php',
			'product_get_category_path.php',
			'product_get_info.php',
			'site_get_info.php',
			'siteblock_get_info.php',
			'product_category_get_tree.php',
			'product_category_special_list.php',
			'product_root_link_info.php'
		);
		
		private $LogAPICalls = array(
			'search.php'
		);
		
}