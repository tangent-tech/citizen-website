<?php
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/filebase_common.php');

$File = filebase::GetFileInfo($_REQUEST['id']);

if ($File == null)
	die("No Such File!");

if (intval($File['object_security_level']) > intval($_SESSION['user_security_level']))
	die("You are not authorized to access this file.");


global $_SERVER, $HTTP_USER_AGENT, $HTTP_SERVER_VARS;

$filepath = filebase::GetPath($File['file_id'], FILEBASE_PATH);

	$filename = $filepath . 'file-'. $File['file_id'];
	if (!@file_exists($filename))
	{
		trigger_error('ERROR_NO_ATTACHMENT' . '<br /><br /> FILE_NOT_FOUND_404 ' . $filename);
	}

	// Determine the Browser the User is using, because of some nasty incompatibilities.
	// borrowed from phpMyAdmin. :)
	$user_agent = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : ((!empty($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) ? $HTTP_SERVER_VARS['HTTP_USER_AGENT'] : '');

	// Correct the mime type - we force application/octetstream for all files, except images
	// Please do not change this, it is a security precaution
//	if ($category == NONE_CAT && !strstr($FileInfo['mimetype'], 'image'))
//	{
//		$mimetype = ($browser_agent == 'ie' || $browser_agent == 'opera') ? 'application/octetstream' : 'application/octet-stream';
//	}

	if (stristr($File['mimetype'], 'image') || stristr($File['mimetype'], 'application/pdf'))
		$mimetype = $File['mimetype'];
	else	$mimetype = 'application/force-download';

	//	$mimetype = 'application/octet-stream';
		
	// Now the tricky part... let's dance
	@ob_end_clean();
	@ini_set('zlib.output_compression', 'Off');

//	header('Content-Description: File Transfer'); 
	header('Pragma: public');
	//header("Cache-control: private");
	header("Cache-control: public, max-age=604800 ");
	header('Content-Transfer-Encoding: none');

	// Send out the Headers
//$FileInfo['filename'] = 'haha.jpg';
	header('Content-Type: ' . $mimetype . '; name="' . $File['filename'] . '"');

	header('Content-Disposition: inline; filename="' . $File['filename'] . '"');
//	header('Content-Disposition: attachment; filename="' . $FileInfo['filename'] . '"');
	header('Content-Location: ' . $File['filename'] . '"');

	// Now send the File Contents to the Browser
	$size = @filesize($filename);
	if ($size)
	{
		header("Content-length: $size");
	}

	//echo "**************************************************************************************************";
	$result = @readfile($filename);

	if (!$result)
	{
		trigger_error('Unable to deliver file.<br />Error was: ' . $php_errormsg, E_USER_WARNING);
	}

	flush();

	exit;
?>
