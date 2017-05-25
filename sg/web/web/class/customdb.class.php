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
		
	public static function ave_mysql_query($query, $filename, $lineno, $dieOnError = true) {
		$starttime = 0;
		$endtime = 0;
		if (DEBUG) {
			$starttime = microtime(true);
		}

		$result = customdb::Singleton()->mysqli->query($query);

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
			api::Singleton()->err_die(1, $query, customdb::Singleton()->mysqli->error, $filename, $lineno, $dieOnError);
		}
		
		return $result;
	}
	
	public static function escape($escapestr) {
		return customdb::Singleton()->mysqli->real_escape_string($escapestr);
	}
	
	public static function mysqli() {
		return customdb::Singleton()->mysqli;
	}
		
	private $mysqli = null;	
}

?>
