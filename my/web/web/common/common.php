<?php
if (!defined('IN_CMS'))
{
	die("common.php is called directly " . realpath(__FILE__) . " " .  __LINE__);
}

require_once(BASEWEBDIR . 'common/constant.php');
require_once(BASEWEBDIR . 'common/function.php');

@session_start();

if (substr($_SERVER["SERVER_NAME"], 0, 3) != 'www' && DOMAIN_FIXED_WWW) {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . BASEURL . '/index.php');
	die();
}

$GSTARTTIME = 0;
if (DEBUG) {
	$GSTARTTIME = microtime(true);
//	error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	error_reporting(E_ALL ^ E_NOTICE);
}
else
	error_reporting(0);

// Delete all automatically register globals to prevent hacking
if (@ini_get('register_globals'))
{
	foreach ($_REQUEST as $var_name => $void)
	{
		unset(${$var_name});
	}
}

if (ENABLE_MAGIC_QUOTE) {
	// addslashes to vars if magic_quotes_gpc is off
	if (!get_magic_quotes_gpc()) {
		slash_input_data ($_REQUEST);
		slash_input_data ($_GET);
		slash_input_data ($_POST);
		slash_input_data ($_COOKIE);
	}
}
else {
	// remove slashes this time!
	if (get_magic_quotes_gpc()) {
		deslash_input_data ($_REQUEST);
		deslash_input_data ($_GET);
		deslash_input_data ($_POST);
		deslash_input_data ($_COOKIE);		
	}
}

function slash_input_data(&$data)
{
	if (is_array($data))
	{
		foreach ($data as $k => $v)
		{
			$data[$k] = (is_array($v)) ? slash_input_data($v) : addslashes($v);
		}
	}
	return $data;
}

function deslash_input_data(&$data)
{
	if (is_array($data))
	{
		foreach ($data as $k => $v)
		{
			$data[$k] = (is_array($v)) ? deslash_input_data($v) : stripslashes($v);
		}
	}
	return $data;
}

$localCache = customLocalCache::Singleton();
//$Site = ApiQuery('site_get_info.php', __LINE__, '');
$Site = $localCache->getCache('xmlCacheSiteInfo', array(), false);

$smarty->assign('Site', $Site);

if (isset($_REQUEST['lang_id']))
	language::SetCurrentLanguage($_REQUEST['lang_id']);

$CurrentCurrency = currency::GetCurrentCurrency();
$smarty->assign('CurrentCurrency', $CurrentCurrency);

$CurrentLang = language::GetCurrentLanguage();
$smarty->assignByRef('CurrentLang', $CurrentLang);

$LanguageList = language::GetAllSiteLanguage();
$smarty->assign('LanguageList', $LanguageList);

require_once(BASEWEBDIR . 'common/' . $CurrentLang->language_root->language_id . '/constant.php');

if ( (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') > 0) || (strpos($_SERVER['HTTP_USER_AGENT'], 'iPod') > 0) ) {
	define('IsIOS', 1);
}

//for footer.php calc process time
if(RUN_PROCESS_TIME){
	$mtime = explode(" ", microtime()); 
	$starttime = $mtime[1] + $mtime[0];
}

$SessionUserSecurityLevel = 0;
if(isset($_SESSION["user_security_level"]) && intval($_SESSION["user_security_level"]) > 0)
	$SessionUserSecurityLevel = intval($_SESSION["user_security_level"]);