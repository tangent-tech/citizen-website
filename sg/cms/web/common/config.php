<?php
if (!defined('IN_CMS'))
	die("huh?");

define('Z_SEO_RANDOM_INSERT', true);
define('Z_SEO_WHEEL_NO', 3);
// NOT RANDOM INSERT
// define(Z_SEO_WHEEL_NO, 4);

if (file_exists(realpath(dirname(__FILE__) . '/local.php')))
	require_once('local.php');
else
	die("local.php missing. Please create one from local.php.sample");

if (IS_LOCAL) {
	define('ENV', 'LOCAL');
}
else {
	//$FORCE_ENV = 'PRODUCTION';
	$FORCE_ENV = 'PRODUCTION';

	if (isset($FORCE_ENV)) {	
		define('ENV', $FORCE_ENV);
	}
	else {
		if (strpos(realpath(dirname(__FILE__)), 'client16/web60') > 0) {
			if (!isset($_SERVER['SERVER_NAME']) || $_SERVER['SERVER_NAME'] == 'demo.369cms.com')
				define('ENV', 'DEMO');
			elseif ($_SERVER['SERVER_NAME'] == 'hnkadmin.eksx.com')
				define('ENV', 'HNK');
			else // Command Line?
				define('ENV', 'DEMO');
		}
		elseif (strpos(realpath(dirname(__FILE__)), 'client16/web50') > 0) {
			if (!isset($_SERVER['SERVER_NAME']) || $_SERVER['SERVER_NAME'] == 'www.369cms.com')
				define('ENV', 'PRODUCTION');
			elseif ($_SERVER['SERVER_NAME'] == 'hnkadmin.eksx.com')
				define('ENV', 'HNK');
			else
				define('ENV', 'PRODUCTION');
		}
		elseif (strpos(realpath(dirname(__FILE__)), 'client184/web541') > 0) {
			define('ENV', 'HEROCROSS');
		}
		elseif (strpos(realpath(dirname(__FILE__)), 'client184/web566') > 0) {
			define('ENV', 'HEROCROSSDEV');
		}
		elseif (strpos(realpath(dirname(__FILE__)), 'client0/web1') > 0) {
			define('ENV', 'FLA');
		}
		elseif (strpos(realpath(dirname(__FILE__)), 'root') > 0) {
			define('ENV', 'PRODUCTION');
		}
	}	
}

$ENVS = array('PRODUCTION', 'DEMO', 'HNK', 'CUH', 'LOCAL', 'HEROCROSS', 'HEROCROSSDEV', 'POS', 'FLA', 'DEV');
if (!in_array(ENV, $ENVS))
	die('Critical Error: ENV detection failed! ' . getcwd() . "\n");


if (ENV == 'LOCAL') {

	define('GitCurrentBranch', exec('git rev-parse --abbrev-ref HEAD'));

	if (defined('PHPUNIT') && PHPUNIT) {
		define('DB_NAME',	'cms_citizenhk');
		define('DB_USER',	'root');
		define('DB_PASSWD',	'');
		define('DB_HOST',	'localhost');
	}
	else {
		if (!defined('LOCAL_SIM_ENV'))
			define('LOCAL_SIM_ENV', 'DEMO');
		
		if (LOCAL_SIM_ENV == 'DEMO') {
			require(__DIR__ . "/../dbconfig/demo_sim.php");
		}
		else if (LOCAL_SIM_ENV == 'HEROCROSS') {
			require(__DIR__ . "/../dbconfig/herocross_sim.php");
		}
		else if (LOCAL_SIM_ENV == 'HEROCROSSDEV') {
			require(__DIR__ . "/../dbconfig/herocrossdev_sim.php");
		}
		else if (LOCAL_SIM_ENV == 'PRODUCTION') {
			require(__DIR__ . "/../dbconfig/production.php");
		}
	}
	
	define('BASEWEBDIR',		BASEDIR . 'web/');
	define('BASEDIR_HTMLSAFE',	BASEDIR . 'htmlsafe/');
	define('BASEURL',			'http://local.cms.citizen-hk.com/myadmin/');
	define('BASEURL_ELASING',	'http://local.cms.citizen-hk.com/elasing/');
}
elseif (ENV == 'HEROCROSS') {
	require(__DIR__ . "/../dbconfig/herocross.php");
	define('BASEDIR',			'/var/www/hcadmin.eksx.com/');
	define('BASEWEBDIR',		BASEDIR . 'web/');
	define('BASEDIR_HTMLSAFE',	BASEDIR . 'htmlsafe/');
	define('BASEURL',			'http://hcadmin.eksx.com/myadmin/');
	define('BASEURL_ELASING',	'http://hcadmin.eksx.com/elasing/');
	define('GIT_REPO_STORAGE_PATH', '/git_repo/demo_cms/');
}
elseif (ENV == 'HEROCROSSDEV') {
	require(__DIR__ . "/../dbconfig/herocrossdev.php");
	define('BASEDIR',			'/var/www/hcadmindev.eksx.com/');
	define('BASEWEBDIR',		BASEDIR . 'web/');
	define('BASEDIR_HTMLSAFE',	BASEDIR . 'htmlsafe/');
	define('BASEURL',			'http://hcadmindev.eksx.com/myadmin/');
	define('BASEURL_ELASING',	'http://hcadmindev.eksx.com/elasing/');
	define('GIT_REPO_STORAGE_PATH', '/git_repo/demo_cms/');
}
elseif (ENV == 'DEMO') {
	require(__DIR__ . "/../dbconfig/demo.php");
	define('BASEDIR',			'/var/www/demo.369cms.com/');
	define('BASEWEBDIR',		BASEDIR . 'web/');
	define('BASEDIR_HTMLSAFE',	BASEDIR . 'htmlsafe/');
	define('BASEURL',			'http://demo.369cms.com/myadmin/');
	define('BASEURL_ELASING',	'http://demo.369cms.com/elasing/');
	define('GIT_REPO_STORAGE_PATH', '/git_repo/demo_cms/');
}
elseif (ENV == 'PRODUCTION') {
	require(__DIR__ . "/../dbconfig/production.php");

	define('BASEDIR',			'/home/citizen/sg/cms/');
	define('BASEWEBDIR',		BASEDIR . 'web/');
	define('BASEDIR_HTMLSAFE',	BASEDIR . 'htmlsafe/');
	define('BASEURL',			'http://cms.citizen.com.sg/myadmin/');
	define('BASEURL_ELASING',	'http://cms.citizen.com.sg/elasing/');
	define('GIT_REPO_STORAGE_PATH', '/git_repo/production_cms/');
}
elseif (ENV == 'HNK') {
	require(__DIR__ . "/../dbconfig/hnk.php");
	define('BASEDIR',			'/var/www/www.369cms.com/');
	define('BASEWEBDIR',		BASEDIR . 'web/');
	define('BASEDIR_HTMLSAFE',	BASEDIR . 'htmlsafe/');
	define('BASEURL',			'http://hnkadmin.eksx.com/myadmin/');
	define('BASEURL_ELASING',	'http://hnkadmin.eksx.com/elasing/');
}
elseif (ENV == 'FLA') {
	require(__DIR__ . "/../dbconfig/fla.php");
	define('BASEDIR',			'/var/www/cmsadmin.inseducation.org/');
	define('BASEWEBDIR',		BASEDIR . 'web/');
	define('BASEDIR_HTMLSAFE',	BASEDIR . 'htmlsafe/');
	define('BASEURL',			'http://cmsadmin.inseducation.org/myadmin/');
	define('BASEURL_ELASING',	'http://cmsadmin.inseducation.org/elasing/');
	define('GIT_REPO_STORAGE_PATH', '/git_repo/demo_cms/');
}
elseif (ENV == 'POS') {
	if (!defined('MYSQL_COMMAND'))
		die("MYSQL_COMMAND is not defined");
	if (!defined('SHOP_ID'))
		die("SHOP_ID is not defined");
	if (!defined('SITE_ID'))
		die("SITE_ID is not defined");
	if (!defined('DB_HOST'))
		die("DB_HOST is not defined");
	if (!defined('DB_NAME'))
		die("DB_NAME is not defined");
	if (!defined('DB_USER'))
		die("DB_USER is not defined");
	if (!defined('DB_PASSWD'))
		die("DB_PASSWD is not defined");
	if (!defined('BASEDIR'))
		die("BASEDIR is not defined");
	if (!defined('BASEWEBDIR'))
		die("BASEWEBDIR is not defined");
	if (!defined('BASEDIR_HTMLSAFE'))
		die("BASEDIR_HTMLSAFE is not defined");
	if (!defined('BASEURL'))
		die("BASEURL is not defined");
	if (!defined('API_BASEURL'))
		die("API_BASEURL is not defined");
	if (!defined('api_login'))
		die("api_login is not defined");
	if (!defined('api_key'))
		die("api_key is not defined");
}

else if(ENV == 'DEV') {
	
	require(__DIR__ . "/../dbconfig/development.php");
	define('BASEDIR',			'/var/www/apps/citizen/sg/cms/');
	define('BASEWEBDIR',		BASEDIR . 'web/');
	define('BASEDIR_HTMLSAFE',	BASEDIR . 'htmlsafe/');
	define('BASEURL',			'http://sg.citizen-cms.uat.my/myadmin/');
	define('BASEURL_ELASING',	'http://sg.citizen-cms.uat.my/elasing/');
	define('GIT_REPO_STORAGE_PATH', '/git_repo/production_cms/');
}

if (ENV !== 'POS') {
	// WEB SITE!
	define('TERMINAL_ID', 0);
}

define('SMARTY_DIR',				BASEDIR_HTMLSAFE . 'smarty-3.1.30/libs/');
define('TPL_BASEPATH',				BASEDIR_HTMLSAFE . 'template/');
define('COMPILE_BASEPATH',			BASEDIR_HTMLSAFE . 'template_c/');
define('FCK_BASEPATH',				BASEWEBDIR . 'myadmin/editor/');
define('FCK_BASEURL',				BASEURL . 'editor/');
define('RICH_XML_BASEDIR',			BASEWEBDIR . 'rich_xml_data/');
define('FILEBASE_PATH',				BASEDIR_HTMLSAFE . 'pos_filebase/');
define('PHPMAILER',					BASEDIR_HTMLSAFE . 'phpmailer/class.phpmailer.php');
define('SYSTEM_ADMIN_LOG',			BASEDIR_HTMLSAFE . 'system_admin.log');
define('SQL_LOG',					BASEDIR_HTMLSAFE . 'sql.log');
define('API_LOG',					BASEDIR_HTMLSAFE . 'api.log');
define('POS_SYNC_LOG',				BASEDIR_HTMLSAFE . 'pos_sync.log');
define('TEMP_LOG',					BASEDIR_HTMLSAFE . 'temp.log');
define('SQL_HEAVY_LOG',				BASEDIR_HTMLSAFE . 'sql_heavy.log');
define('PAGE_HEAVY_LOG',			BASEDIR_HTMLSAFE . 'page_heavy.log');
define('SQL_HEAVY_VALUE',			0.5);
define('PAGE_HEAVY_VALUE',			0.5);
define('PASSWORD_HASH_COST',		10);
define('DEBUG', TRUE);

if (ENV == 'LOCAL')
	define('SQL_LOGGING', true);
else
	define('SQL_LOGGING', false);
	
define('API_LOGGING', true);
define('ENABLE_MAGIC_QUOTE', false);

// NO CHANGE BELOW THIS LINE! ^_^
require_once(SMARTY_DIR . 'Smarty.class.php');

class mySmarty extends Smarty {
	public static $SiteID = 0;
	
	private static $CustomDef = null;
	
	function __construct() {
		parent::__construct();
		$this->template_dir = TPL_BASEPATH;
		$this->compile_dir = COMPILE_BASEPATH;
		$this->assignCustomFieldDef();
	}
	
	public static function loadCustomFieldDef($forceReload = false) {
		if ($forceReload || (self::$SiteID != 0 && self::$CustomDef === NULL)) {
			$CustomDef = array();
			$CustomDef['UserCustomFieldsDef'] = Site::GetUserCustomFieldsDef(self::$SiteID);
			$CustomDef['ProductCustomFieldsDef'] = Site::GetProductCustomFieldsDef(self::$SiteID);
			$CustomDef['ProductBrandCustomFieldsDef'] = Site::GetProductBrandCustomFieldsDef(self::$SiteID);
			$CustomDef['ProductCategoryCustomFieldsDef'] = Site::GetProductCategoryCustomFieldsDef(self::$SiteID);
			$CustomDef['AlbumCustomFieldsDef'] = Site::GetAlbumCustomFieldsDef(self::$SiteID);
			$CustomDef['FolderCustomFieldsDef'] = Site::GetFolderCustomFieldsDef(self::$SiteID);
			$CustomDef['MediaCustomFieldsDef'] = Site::GetMediaCustomFieldsDef(self::$SiteID);
			$CustomDef['DatafileCustomFieldsDef'] = Site::GetDatafileCustomFieldsDef(self::$SiteID);
			$CustomDef['MyorderCustomFieldsDef'] = Site::GetMyorderCustomFieldsDef(self::$SiteID);
			self::$CustomDef = $CustomDef;
		}
	}
	
	public function assignCustomFieldDef() {
		if (self::$SiteID != 0) {
			self::loadCustomFieldDef();
			$this->assign('UserCustomFieldsDef', self::$CustomDef['UserCustomFieldsDef']);
			$this->assign('ProductCustomFieldsDef', self::$CustomDef['ProductCustomFieldsDef']);
			$this->assign('ProductBrandCustomFieldsDef', self::$CustomDef['ProductBrandCustomFieldsDef']);
			$this->assign('ProductCategoryCustomFieldsDef', self::$CustomDef['ProductCategoryCustomFieldsDef']);
			$this->assign('AlbumCustomFieldsDef', self::$CustomDef['AlbumCustomFieldsDef']);
			$this->assign('FolderCustomFieldsDef', self::$CustomDef['FolderCustomFieldsDef']);
			$this->assign('MediaCustomFieldsDef', self::$CustomDef['MediaCustomFieldsDef']);
			$this->assign('DatafileCustomFieldsDef', self::$CustomDef['DatafileCustomFieldsDef']);
			$this->assign('MyorderCustomFieldsDef', self::$CustomDef['MyorderCustomFieldsDef']);			
		}
	}
}

$smarty = new mySmarty();

/**
 * 
 * @param string $query
 * @param string $filename
 * @param int $lineno
 * @param bool $dieOnError
 * @return mysqli_result
 */
function ave_mysqli_query ($query, $filename, $lineno, $dieOnError = true) {
	return customdb::ave_mysqli_query($query, $filename, $lineno, $dieOnError);
}

/**
 * 
 * @param string $query
 * @param resource $link
 * @return mysql_result
 */
function ave_mysql_query ($query, $link = '') {
	$starttime = 0;
	$endtime = 0;
	if (DEBUG) {
		$starttime = microtime(true);
	}

	$result = null;
	if ($link != '')
		$result = mysql_query ($query, $link);
	else
		$result = mysql_query ($query);

	if (DEBUG) {
		$endtime = microtime(true);

		if (($endtime - $starttime) > SQL_HEAVY_VALUE) {
			$fp = fopen(SQL_HEAVY_LOG, "a");
			if ($fp) {
				fwrite( $fp, date("y-m-j H:i:s") . "\n" );
				fwrite( $fp, "URL: " . curPageURL() . "\n");
				fwrite( $fp, "Time used: " . ($endtime - $starttime) . "\n" );
				fwrite( $fp, trim($query) . "\n\n" );
			}
			fclose($fp);
		}

		if (SQL_LOGGING) {
			$fp = fopen(SQL_LOG, "a");
			if ($fp) {
				fwrite( $fp, date("y-m-j H:i:s") . "\n" );
				fwrite( $fp, "Time used: " . ($endtime - $starttime) . "\n" );
				fwrite( $fp, trim($query) . "\n\n" );
			}
			fclose($fp);
		}
	}
	return $result;
}

function LogAPI($data) {
	if (API_LOGGING) {
		$fp = fopen(API_LOG, "a");
		if ($fp) {
			fwrite( $fp, date("y-m-j H:i:s") . "\n" );
			fwrite( $fp, $data . "\n\n" );
		}
		fclose($fp);
	}
}

function LogPosSync($data) {
	if (API_LOGGING) {
		$fp = fopen(POS_SYNC_LOG, "a");
		if ($fp) {
			fwrite( $fp, date("y-m-j H:i:s") . " : " . $data . "\n" );
		}
		fclose($fp);
	}
}

function LogFile($Filename, $data) {
	$fp = fopen($Filename, "a");
	if ($fp) {
		fwrite( $fp, $data . "\n" );
	}
	fclose($fp);
}

function Autoload($class_name) {
	if (substr($class_name, 0, 2) == 'cm') {
		require_once(BASEWEBDIR . "/class/cm/" . $class_name . '.class.php');
		return;		
	}
	else if (file_exists(BASEWEBDIR . "/class/" . $class_name . '.class.php')) {
		require_once(BASEWEBDIR . "/class/" . $class_name . '.class.php');
		return;
	}
}
spl_autoload_register("Autoload");

function err_die($error_no, $detail1, $detail2, $filename, $lineno, $dieOnError) {
	customdb::err_die($error_no, $detail1, $detail2, $filename, $lineno, $dieOnError);
}

function acl_die($Details, $Filename, $Permission, $XMLDie) {
	$Details = $Details . " (" . $Permission . ")";
	
	if ($XMLDie)
		XMLDie(__LINE__, $Details);
	
	$smarty = new mySmarty();
	$smarty->assign('Details', $Details);
	$smarty->display('myadmin/acl_die.tpl');
	die();
}

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function LogTime() {
	global $GSTARTTIME;
	if (DEBUG) {
		$endtime = microtime(true);

		if ($endtime-$GSTARTTIME > PAGE_HEAVY_VALUE) {
			$fp = fopen(PAGE_HEAVY_LOG, "a");
			if ($fp) {
				fwrite( $fp, "URL: " . curPageURL() . "\n");
				fwrite( $fp, "Time used: " . ($endtime - $GSTARTTIME) . "\n" );
			}
			fclose($fp);
		}
	}
}

function LogVar($mixed = null) {
  ob_start();
  var_dump($mixed);
  $content = ob_get_contents();
  ob_end_clean();
  LogApi($content);
}

/**
 * Shortcut for mysqli_real_escape
 * @param string $str
 * @return string
 */
function aveEsc($str) {
	return customdb::escape($str, false, false);
}

/**
 * Shortcut for mysqli_real_escape + trim
 * @param string $str
 * @return string
 */
function aveEscT($str) {
	return customdb::escapeT($str, false, false);
}

/**
 * Shortcut for mysqli_real_escape + trim + single quote at begin and end
 * @param string $str
 * @return string
 */
function aveEscTQ($str) {
	return customdb::escapeT($str, true, false);
}

/**
 * Shortcut for mysqli_real_escape + single quote at begin and end
 * @param string $str
 * @return string
 */
function aveEscQ($str) {
	return customdb::escape($str, true, false);
}