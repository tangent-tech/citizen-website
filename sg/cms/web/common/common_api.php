<?php

if (!defined('IN_CMS'))
	die("common.php is called directly " . realpath(__FILE__) . " " .  __LINE__);

header('Content-type: text/xml');
echo("<?xml version=\"1.0\" encoding=\"utf-8\" ?>");

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

//mysql_connect(DB_HOST, DB_USER, DB_PASSWD) or die("Could not connect : " . mysql_error());
//mysql_select_db(DB_NAME) or die("Could not select database");
//$query = " SET character_set_client = 'utf8'";
//$result = mysql_query($query) or die(mysql_error());
//$query = " SET character_set_results = 'utf8'";
//$result = mysql_query($query) or die(mysql_error());
//$query = " SET character_set_connection = 'utf8'";
//$result = mysql_query($query) or die(mysql_error());

ini_set("memory_limit","300M");

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

$Site = site::GetSiteInfoByAPI($_REQUEST['api_login'], $_REQUEST['api_key']);

mySmarty::$SiteID = intval($Site['site_id']);
$smarty->assignCustomFieldDef();

if (!isset($_REQUEST['error_lang_id']))
	$_REQUEST['error_lang_id'] = DEFAULT_API_ERROR_LANG_ID;
$API_ERROR = errormsg::GetSiteEffectiveErrorMsg($Site['site_id'], $_REQUEST['error_lang_id']);

//$UserCustomFieldsDef = Site::GetUserCustomFieldsDef($Site['site_id']);
//$smarty->assign('UserCustomFieldsDef', $UserCustomFieldsDef);
//
//$ProductCustomFieldsDef = Site::GetProductCustomFieldsDef($Site['site_id']);
//$smarty->assign('ProductCustomFieldsDef', $ProductCustomFieldsDef);
//
//$ProductBrandCustomFieldsDef = Site::GetProductBrandCustomFieldsDef($Site['site_id']);
//$smarty->assign('ProductBrandCustomFieldsDef', $ProductBrandCustomFieldsDef);
//
//$ProductCategoryCustomFieldsDef = Site::GetProductCategoryCustomFieldsDef($Site['site_id']);
//$smarty->assign('ProductCategoryCustomFieldsDef', $ProductCategoryCustomFieldsDef);
//
//$AlbumCustomFieldsDef = Site::GetAlbumCustomFieldsDef($Site['site_id']);
//$smarty->assign('AlbumCustomFieldsDef', $AlbumCustomFieldsDef);
//
//$FolderCustomFieldsDef = Site::GetFolderCustomFieldsDef($Site['site_id']);
//$smarty->assign('FolderCustomFieldsDef', $FolderCustomFieldsDef);
//
//$MediaCustomFieldsDef = Site::GetMediaCustomFieldsDef($Site['site_id']);
//$smarty->assign('MediaCustomFieldsDef', $MediaCustomFieldsDef);
//
//$DatafileCustomFieldsDef = Site::GetDatafileCustomFieldsDef($Site['site_id']);
//$smarty->assign('DatafileCustomFieldsDef', $DatafileCustomFieldsDef);
//
//$MyorderCustomFieldsDef = Site::GetMyorderCustomFieldsDef($Site['site_id']);
//$smarty->assign('MyorderCustomFieldsDef', $MyorderCustomFieldsDef);

if ($Site['site_is_enable'] != 'Y')
	APIDie($API_ERROR['API_ERROR_AUTH_FAIL']);