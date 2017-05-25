<?php
//	Special Build for POS Sync - 20151210
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
		}
		
		return $instance;
	}
	
	public function ApiQuery($api_call, $line_no, $parameter = '', $Cache = true, $Dump = false, $PostValueArray = null, $StripSlashes = false) {

		if ($this->curl_connection == null) {
			$this->curl_connection = curl_init();
			$timeout = 30;
			curl_setopt ($this->curl_connection, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($this->curl_connection, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt ($this->curl_connection, CURLOPT_FRESH_CONNECT, false);
			curl_setopt ($this->curl_connection, CURLOPT_DNS_USE_GLOBAL_CACHE, true);
//			register_shutdown_function('ApiQueryEnd');
		}

		if ($PostValueArray != null) {
			curl_setopt ($this->curl_connection, CURLOPT_POST, true);
			$PostValueArray['api_login'] = api_login;
			$PostValueArray['api_key'] = api_key;
			$PostValueArray['shop_id'] = SHOP_ID;

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
			$Query = API_BASEURL . $api_call . '?api_login=' . api_login . '&api_key=' . api_key . '&shop_id=' . SHOP_ID . '&' . $parameter;
			curl_setopt ($this->curl_connection, CURLOPT_URL, $Query);			
		}

		$startime = 0;
		if (API_LOGGING && in_array($api_call, $this->LogAPICalls)) {
			$startime = microtime(true);
			LogAPI($Query);
		}
		$Result = curl_exec($this->curl_connection);
		if (API_LOGGING && in_array($api_call, $this->LogAPICalls)) {
			$endtime = microtime(true);
			LogAPI($Result);
			LogAPI('API Return Time: ' . ($endtime-$startime));
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

		$xml = new SimpleXMLElement($Result);
		if (API_LOGGING) {
			$endtime = microtime(true);
			LogAPI('XML Parse Time: ' . ($endtime-$startime));
		}

		if ($xml->result == 'Fail')
			die('API Error ' . $xml->error_code . ': ' . $xml->error_string . '(' . $line_no . ')');

		return $xml;
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
	
	public function InitCURL($url) {
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
	
	private $curl_connection = null;
		
	private $LogAPICalls = array(

	);
		
}

?>
