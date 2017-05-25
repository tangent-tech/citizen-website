<?php
if (!defined('IN_CMS'))
{
	die("common.php is called directly " . realpath(__FILE__) . " " .  __LINE__);
}

require_once(BASEWEBDIR . 'common/constant.php');
require_once(BASEWEBDIR . 'common/function.php');

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
?>
