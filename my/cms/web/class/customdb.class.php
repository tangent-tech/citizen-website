<?php
//	Version: 1.0 
//	
//
class customdb {
	
	function __construct() {
	}
	
	public static function Singleton() {
		static $instance = null;
		
		if ($instance === null) {
			$instance = new customdb();
			$instance->mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
			$instance->mysqli->set_charset('utf8');
		}
		return $instance;
	}
		
	public static function ave_mysqli_query($query, $filename, $lineno, $dieOnError = true) {
		$starttime = 0;
		$endtime = 0;
		if (DEBUG) {
			$starttime = microtime(true);
		}

		$result = self::mysqli()->query($query);

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
			self::Singleton()->err_die(1, $query, self::mysqli()->error, $filename, $lineno, $dieOnError);
		}
		
		return $result;
	}
	
	public static function escape($escapestr, $withSingleQuoteBeginEnd = false, $withDoubleQuoteBeginEnd = false) {
		if ($escapestr === NULL)
			return "NULL";
		elseif ($withSingleQuoteBeginEnd)
			return "'" . customdb::Singleton()->mysqli->real_escape_string($escapestr) . "'";
		elseif ($withDoubleQuoteBeginEnd)
			return '"' . customdb::Singleton()->mysqli->real_escape_string($escapestr) . '"';
		else
			return customdb::Singleton()->mysqli->real_escape_string($escapestr);			
	}

	public static function escapeT($escapestr, $withSingleQuoteBeginEnd = false, $withDoubleQuoteBeginEnd = false) {
		return self::escape(trim($escapestr), $withSingleQuoteBeginEnd, $withDoubleQuoteBeginEnd);
	}
	
	/**
	 * 
	 * @return mysqli
	 */
	public static function mysqli() {
		return customdb::Singleton()->mysqli;
	}
	
	public function err_die($error_no, $detail1, $detail2, $filename, $lineno, $dieOnError) {
		customdb::mysqli()->select_db(DB_NAME);
		
		if (!isset($_SESSION['UserID']))
			$UserID = 0;
		else
			$UserID = $_SESSION['UserID'];

		if ($error_no != 2) {
			$ip = ip2long(getenv ("REMOTE_ADDR"));

			$query =	"	INSERT INTO errorlog " .
						"	SET " .
						"		error_no = " . intval($error_no) . ", " . 
						"		errorlog_detail_1 = '" . customdb::escapeT($detail1) . "', " .
						"		errorlog_detail_2 = '" . customdb::escapeT($detail2) . "', " .
						"		errorlog_filename = '" . customdb::escapeT($filename) . "', " .
						"		errorlog_lineno = '" . intval($lineno) . "', " .
						"		user_id = " . $UserID . ", " .
						"		user_ip = '" . $ip . "'";
			$result = self::mysqli()->query($query);
			
			/* @var $result mysqli_result */
			$error_ticket_no = self::mysqli()->insert_id;
		}

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
		
	private $mysqli = null;	
}