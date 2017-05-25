<?php
define('IN_CMS', true);
require_once(realpath(dirname(__FILE__)) . '/../../common/config.php');
require_once(realpath(dirname(__FILE__)) . '/../../common/constant.php');
require_once(realpath(dirname(__FILE__)) . '/../../common/function.php');

$FileInfo = filebase::GetFileInfo($_REQUEST['id']);
if ($FileInfo == null)
	die("No Such File!");

$Site = site::GetSiteInfo($FileInfo['site_id']);

global $_SERVER, $HTTP_USER_AGENT, $HTTP_SERVER_VARS;

$FileID = $_REQUEST['id'];

$src_filepath = filebase::GetPath($FileID, FILEBASE_PATH);
$TmpFile = $src_filepath . 'file-'. $FileID;

// Determine the Browser the User is using, because of some nasty incompatibilities.
// borrowed from phpMyAdmin. :)
$user_agent = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : ((!empty($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) ? $HTTP_SERVER_VARS['HTTP_USER_AGENT'] : '');

// Correct the mime type - we force application/octetstream for all files, except images
// Please do not change this, it is a security precaution
//	if ($category == NONE_CAT && !strstr($FileInfo['mimetype'], 'image'))
//	{
//		$mimetype = ($browser_agent == 'ie' || $browser_agent == 'opera') ? 'application/octetstream' : 'application/octet-stream';
//	}

if (stristr($FileInfo['mimetype'], 'image'))
	$mimetype = $FileInfo['mimetype'];
else	$mimetype = 'application/force-download';

//	$mimetype = 'application/octet-stream';

// Now the tricky part... let's dance
@ob_end_clean();
@ini_set('zlib.output_compression', 'Off');

//	header('Content-Description: File Transfer'); 
header('Pragma: public');
header("Cache-control: private");
header('Content-Transfer-Encoding: none');

// Send out the Headers
//$FileInfo['filename'] = 'haha.jpg';
header('Content-Type: ' . $mimetype . '; name="' . $FileInfo['filename'] . '"');

header('Content-Disposition: inline; filename="' . $FileInfo['filename'] . '"');
//	header('Content-Disposition: attachment; filename="' . $FileInfo['filename'] . '"');
header('Content-Location: ' . $FileInfo['filename'] . '"');

// Now send the File Contents to the Browser
$size = @filesize($TmpFile);

if ($size)
{
	header("Content-length: $size");
}

//echo "**************************************************************************************************";
//$result = readfile($filename, false, $FtpStreamContext);
$result = readfile($TmpFile);

if (!$result)
{
	trigger_error('Unable to deliver file.<br />Error was: ' . $php_errormsg, E_USER_WARNING);
}

flush();

exit;
?>