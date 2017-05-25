<?php

if (!defined('IN_CMS'))
{
	die("common.php is called directly " . realpath(__FILE__) . " " .  __LINE__);
}

session_start();

require_once(BASEWEBDIR . '/common/constant.php');

$GSTARTTIME = 0;

if (DEBUG) {
	$GSTARTTIME = microtime(true);
	error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
//	error_reporting(E_ALL);
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

//ini_set("memory_limit","300M");
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

if (isset($_REQUEST['lang_id']))
	language::SetCurrentLanguage($_REQUEST['lang_id']);

$CurrentLang = language::GetCurrentLanguage();

$smarty->assign('CurrentLang', $CurrentLang);
$smarty->assign('CurrentLangID', $CurrentLang['language_id']); // for smarty template loading

$LanguageOption = language::GetAllLanguageOption();
//	array_pop($LanguageOption);
$smarty->assign('LanguageOption', $LanguageOption);

require_once(BASEWEBDIR . '/common/' . $CurrentLang['language_id'] . '/constant.php');

$AdminInfo = null;
$IsSuperAdmin = false;
$IsSiteAdmin = false;
$IsContentAdmin = false;
$IsElasingUser = false;
$IsContentWriter = false;
$EffectiveACL	= array();
$EffectiveContentAdminGroup	= array();

$ObjectFieldsShow = site::GetObjectFieldsShow($_SESSION['site_id']);
$smarty->assign('ObjectFieldsShow', $ObjectFieldsShow);

?>
