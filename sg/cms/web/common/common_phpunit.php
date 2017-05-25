<?php
if (!defined('IN_CMS'))
	die("common.php is called directly " . realpath(__FILE__) . " " .  __LINE__);

require_once(BASEWEBDIR . '/common/constant.php');

// Delete all automatically register globals to prevent hacking
if (@ini_get('register_globals'))
{
	foreach ($_REQUEST as $var_name => $void)
	{
		unset(${$var_name});
	}
}

mysql_connect(DB_HOST, DB_USER, DB_PASSWD) or die("Could not connect : " . mysql_error());
mysql_select_db(DB_NAME) or die("Could not select database");
$query = " SET character_set_client = 'utf8'";
$result = mysql_query($query) or die(mysql_error());
$query = " SET character_set_results = 'utf8'";
$result = mysql_query($query) or die(mysql_error());
$query = " SET character_set_connection = 'utf8'";
$result = mysql_query($query) or die(mysql_error());

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

?>