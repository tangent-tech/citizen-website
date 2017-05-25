<?php
// Search XXXXXX for proper replacement

if (!defined('IN_CMS'))
	die("huh?");

if (file_exists(realpath(dirname(__FILE__) . '/local.php')))
	require_once('local.php');
else
	die("local.php missing. Please create one from local.php.sample");

@session_start();

$validViewValue = array('d', 'm');
if (isset($_REQUEST['view']) && in_array($_REQUEST['view'], $validViewValue)) {
	$_SESSION['view'] = $_REQUEST['view'];
}
else if (isset($_SESSION['view'])) {
}
else {
	
	/***
	 * IMPORTANT
	 * To Detect Mobile Or Desktop
	 */
	// Any mobile device (phones or tablets).
	require_once 'Mobile-Detect-2.8.22/Mobile_Detect.php';
	$DeviceDetect = new Mobile_Detect;

	//echo "IS Mobile: ";
	//var_dump($DeviceDetect->isMobile());

	//echo "Is Tablet: ";
	//var_dump($DeviceDetect->isMobile());
	
	if ($DeviceDetect->isMobile())
		$_SESSION['view'] = 'm';
	else
		$_SESSION['view'] = 'd';
}
if (IS_LOCAL) {
	define ("ENV", 'LOCAL');
} else {
	// !!! NO need to detect if only one dev site
	define("ENV", "PRODUCTION");
	// define("ENV", "PRODUCTION");
}

if (ENV == 'LOCAL') {

	define('API_BASEURL', 'http://local.cms.citizen-hk.com/api/');
	//define('API_BASEURL',	'http://www.369cms.com:8899/api/');
	define('api_login', 	'citizenweb');
	define('api_key',		'4b1835ee5a1f46a4e0c3d2148129990b');
	define('BASEWEBDIR',	BASEDIR . "web/");
	define('SITE_ID',		206);
	define('API_ENV',		'DEVELOPMENT');
	define('ENABLE_LOCAL_CACHE', true);
	define('CACHE_BASEDIR', BASEDIR . '/htmlsafe/localcache/');
	
	// Custom DB
	define('DB_HOST',	'localhost');	// host02.aveego.com or localhost
	define('DB_NAME',	'c127citizenproddb');
	define('DB_USER',	'root');
	define('DB_PASSWD',	'');

	define('DOMAIN_FIXED_WWW', 	 false);
}
else if (ENV == 'DEV') {

	define('BASEDIR',		'/var/www/apps/citizen/sg/web/');

	define('API_BASEURL',	'http://sg.citizen-cms.uat.my/api/');
	define('api_login', 	'citizenweb');
	define('api_key',		'4b1835ee5a1f46a4e0c3d2148129990b');
	define('BASEWEBDIR',	BASEDIR . "web/");
	define('SITE_ID',		206);
	define('API_ENV',		'DEVELOPMENT');
	define('BASEURL',		'http://sg.citizen.uat.my');
	define('REMOTE_BASEURL','http://sg.citizen.uat.my');
	define('ENABLE_LOCAL_CACHE', true);
	define('CACHE_BASEDIR', BASEDIR . '/htmlsafe/localcache/');
	
	// Custom DB
	define('DB_HOST',	'52.77.43.36');
	define('DB_NAME',	'www_citizensg');
	define('DB_USER',	'citizen');
	define('DB_PASSWD',	'18/dcuvfUsBRxw29o');

	define('DOMAIN_FIXED_WWW',			false);
	define('RUN_PROCESS_TIME',			false);
		
	define('CLIENT_NOREPLY_EMAIL',		'mktadv@citizen.com.hk');
	define('CLIENT_CONTACT_EMAIL',		'info@aveego.com');
	define('CLIENT_AVE1_EMAIL',			'info@aveego.com');
	define('CLIENT_AVE2_EMAIL',			'fung.chan@aveego.com');
}
else if (ENV == 'PRODUCTION') {
	define('BASEDIR',		'/home/citizen/sg/web/');

	define('API_BASEURL',	'http://cms.citizen.com.sg/api/');
	define('api_login', 	'citizenweb');
	define('api_key',		'4b1835ee5a1f46a4e0c3d2148129990b');
	define('BASEWEBDIR',	BASEDIR . "web/");
	define('SITE_ID',		206);
	define('API_ENV',		'PRODUCTION');
	define('BASEURL',		'https://www.citizen.com.sg');
	define('REMOTE_BASEURL','https://www.citizen.com.sg');
	define('ENABLE_LOCAL_CACHE', true);
	define('CACHE_BASEDIR', BASEDIR . '/htmlsafe/localcache/');
	
	// Custom DB
	define('DB_HOST',	'localhost');
	define('DB_NAME',	'www_citizensg');
	define('DB_USER',	'cms_citizen');
	define('DB_PASSWD',	'c1t1z3n');

	define('DOMAIN_FIXED_WWW',			true);
	define('RUN_PROCESS_TIME',			false);
		
	define('CLIENT_NOREPLY_EMAIL',		'mktadv@citizen.com.hk');
	define('CLIENT_CONTACT_EMAIL',		'mktadv@citizen.com.hk');
	define('CLIENT_AVE1_EMAIL',			'info@aveego.com');
	define('CLIENT_AVE2_EMAIL',			'info@aveego.com');
}

define('ENABLE_MAGIC_QUOTE', true);

if(ENV == "DEV") {
	define('API_DB_HOST',	'52.77.43.36'); // default is host02.aveego.com and customized is 52.76.118.13
	define('API_DB_NAME',	'cache_citizensg'); // default is c16cmsapi and customized is cms_api_cache
	define('API_DB_USER',	'citizen'); // default is c16cmsapi and customized is citizen
	define('API_DB_PASSWD',	'18/dcuvfUsBRxw29o'); // default is gospeedlinggo and customized is 18/dcuvfUsBRxw29o
	define('DB_CMS', 'cms_citizensg'); // default is c16369cms
}

if(ENV == "LOCAL") { 
	define('API_DB_HOST',	'localhost'); // default is host02.aveego.com and customized is 52.76.118.13
	define('API_DB_NAME',	'cms_api_cache'); // default is c16cmsapi and customized is cms_api_cache
	define('API_DB_USER',	'root'); // default is c16cmsapi and customized is citizen
	define('API_DB_PASSWD',	''); // default is gospeedlinggo and customized is 18/dcuvfUsBRxw29o
}

if(ENV == "PRODUCTION") {
	define('API_DB_HOST',	'localhost'); // default is host02.aveego.com and customized is 52.76.118.13
	define('API_DB_NAME',	'cache_citizensg'); // default is c16cmsapi and customized is cms_api_cache
	define('API_DB_USER',	'cms_citizen'); // default is c16cmsapi and customized is citizen
	define('API_DB_PASSWD',	'c1t1z3n'); // default is gospeedlinggo and customized is 18/dcuvfUsBRxw29o
	define('DB_CMS', 'cms_citizensg'); // default is c16369cms

}
// CMS DB (for get file.php)
define('SMARTY_DIR',		BASEDIR . 'htmlsafe/smarty-3.1.27/libs/');
define('FILEBASE_PATH',		BASEDIR . 'filebase/');

define('PHPMAILER',			BASEDIR . 'htmlsafe/PHPMailer-5.2.13/class.phpmailer.php');

define('API_LOG',			BASEDIR . 'htmlsafe/api' . date("Ymd") . '.log');
define('AVE_LOG',			BASEDIR . 'htmlsafe/ave' . date("Ymd") . '.log');
define('SQL_LOG',			BASEDIR . 'htmlsafe/sql' . date("Ymd") . '.log');
define('TEMP_LOG',			BASEDIR . 'htmlsafe/temp' . date("Ymd") .'.log');
define('SQL_HEAVY_LOG',		BASEDIR . 'htmlsafe/sql_heavy' . date("Ymd") . '.log');
define('PAGE_HEAVY_LOG',	BASEDIR . 'htmlsafe/page_heavy' . date("Ymd") . '.log');
define('SQL_HEAVY_VALUE',	0.5);
define('PAGE_HEAVY_VALUE',	0.5);
define('DEBUG',				true);
define('SQL_LOGGING',		false);
define('API_LOGGING',		false);
define('API_CALL_LIB',		'CURL');

define('PAYPAL_SHORTCUT_IMAGE_URL', 'https://fpdbs.paypal.com/dynamicimageweb?cmd=_dynamic-image&buttontype=ec_shortcut&locale=');
define('PAYPAL_MARK_IMAGE_URL',		'https://fpdbs.paypal.com/dynamicimageweb?cmd=_dynamic-image&buttontype=ec_mark&locale=');
define('PAYPAL_TEST',				true);
define('PAYPAL_API_VERSION',		72);// AS ON 2011/06/08

define('PAYPAL_FAIL_URL',			BASEURL . '/cart.php');
define('PAYPAL_RETURN_URL',			BASEURL . '/cart_confirm_payment.php');
define('PAYPAL_CANCEL_URL',			BASEURL . '/cart.php');

if (PAYPAL_TEST) {
	define('PAYPAL_NVP_SERVER',		'https://api-3t.sandbox.paypal.com/nvp');
	define('PAYPAL_WEBSCR_SERVER',	'https://www.sandbox.paypal.com/cgi-bin/webscr');
	define('PAYPAL_API_USERNAME',	'info_api1.aveego.com');
	define('PAYPAL_API_PASSWORD',	'RJ6U3YLMH57F3RAT');
	define('PAYPAL_API_SIGNATURE',	'A2JUZw44yhkpYIEePiLeSbq4VaSgA8Wtxk6L7cXu4m-qfjsnxaCRheUH');
	define('PAYPAL_NAME',			'PayPal Sandbox');
}

else {
	define('PAYPAL_NVP_SERVER',		'https://api-3t.paypal.com/nvp');
	define('PAYPAL_WEBSCR_SERVER',	'https://www.paypal.com/cgi-bin/webscr');
	define('PAYPAL_API_USERNAME',	'');
	define('PAYPAL_API_PASSWORD',	'');
	define('PAYPAL_API_SIGNATURE',	'');
	define('PAYPAL_NAME',			'PayPal');
}

// NO CHANGE BELOW THIS LINE! ^_^
$PayPalAPICommon =	'USER=' . urlencode(PAYPAL_API_USERNAME) . '&' .
					'PWD=' . urlencode(PAYPAL_API_PASSWORD) . '&' .
					'SIGNATURE=' . urlencode(PAYPAL_API_SIGNATURE) . '&' .
					'VERSION=' . urlencode(PAYPAL_API_VERSION);
					
require_once(SMARTY_DIR . 'Smarty.class.php');
class mySmarty extends Smarty {	
	function __construct() {
		parent::__construct();
		
		
		if($_SESSION['view'] == 'm') {
			$this->template_dir = BASEDIR . 'htmlsafe/template_mobile/';
			$this->compile_dir = BASEDIR . 'htmlsafe/template_mobile_c/';
		}
		else {
			$this->template_dir = BASEDIR . 'htmlsafe/template/';
			$this->compile_dir = BASEDIR . 'htmlsafe/template_c/';
		}
		$this->assign("BASEURL", BASEURL);
		$this->assign("REMOTE_BASEURL", REMOTE_BASEURL);
		$this->assign('MyCurrency', 'SGD$');
	}
}
$smarty = new mySmarty();

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

function Autoload($class_name) {
	try
	{
		require_once(BASEWEBDIR . "/class/" . $class_name . '.class.php');
	}
    catch (Exception $e)
	{
		print get_class($e)." thrown within the exception handler. Message: ".$e->getMessage()." on line ".$e->getLine();
	}
}
spl_autoload_register("Autoload");

function err_die($error_no, $detail1, $detail2, $filename, $lineno) {
	api::Singleton()->err_die($error_no, $detail1, $detail2, $filename, $lineno);
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

	$parsed_url = parse_url($pageURL);
		
	$Arg = array();
	$ExcludeArgFieldNameList = array('msg_key');
	
	$UriData = explode("&", $parsed_url['query']);
	foreach ($UriData as $Var) {
		$Temp = explode("=", $Var);
		$Arg[$Temp[0]] = urldecode($Temp[1]);
	}

	$query_string = '';
	foreach ($Arg as $aKey => $aValue) {
		if (!in_array($aKey, $ExcludeArgFieldNameList))
			$query_string = $query_string . urlencode($aKey) . '=' . urlencode($aValue) . '&';
	}
	$query_string = substr($query_string, 0, -1);

	$scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : ''; 
	$host     = isset($parsed_url['host']) ? $parsed_url['host'] : ''; 
	$port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : ''; 
	$user     = isset($parsed_url['user']) ? $parsed_url['user'] : ''; 
	$pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : ''; 
	$pass     = ($user || $pass) ? "$pass@" : ''; 
	$path     = isset($parsed_url['path']) ? $parsed_url['path'] : ''; 
	$query    = strlen($query_string) > 0 ? '?' . $query_string : ''; 
	$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : ''; 
	return $scheme . $user . $pass . $host. $port . $path . $query .$fragment; 	
}

function LogVar($mixed = null) {
  ob_start();
  var_dump($mixed);
  $content = ob_get_contents();
  ob_end_clean();
  LogApi($content);
}

//Must Write
function LogAve($data){
	$fp = fopen(AVE_LOG, "a");
	if ($fp) {
		fwrite( $fp, date("y-m-j H:i:s") . "\n" );
		fwrite( $fp, $data . "\n\n" );
	}
	fclose($fp);
}

function ApiQuery($api_call, $line_no, $parameter = '', $Cache = true, $Dump = false, $PostValueArray = null, $StripSlashes = false, $returnRaw = false) {

	return api::Singleton()->ApiQuery($api_call, $line_no, $parameter, $Cache, $Dump, $PostValueArray, $StripSlashes, $returnRaw);
}

function ave_mysql_query($query, $filename, $lineno, $dieOnError = true) {
	return customdb::ave_mysql_query($query, $filename, $lineno, $dieOnError);
}

function filebase_mysql_query($query, $filename, $lineno, $dieOnError = true) {
	return api::ave_mysql_query($query, $filename, $lineno, $dieOnError);
}

