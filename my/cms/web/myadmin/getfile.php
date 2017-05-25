<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');

	$FileInfo = filebase::GetFileInfo($_REQUEST['id']);

	if ($FileInfo == null)
		die("No Such File!");
		
	if ($_SESSION['site_id'] != $FileInfo['site_id'])
		AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');

	$Site = site::GetSiteInfo($FileInfo['site_id']);

	global $_SERVER, $HTTP_USER_AGENT, $HTTP_SERVER_VARS;
	
	$FileID = $_REQUEST['id'];
	$FtpStreamOptions = array('ftp' => array('overwrite' => true));
	$FtpStreamContext = stream_context_create($FtpStreamOptions);
	$conn_id = ftp_connect($Site['site_ftp_address']);
	$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password']));

	if ($Site['site_ftp_need_passive'] == 'Y'){
		ftp_pasv($conn_id, true);
	}
	else{
		ftp_pasv($conn_id, false);
	}
	
	$TmpFile = tempnam("/tmp", "TmpGetFile");
	
	$src_filepath = filebase::GetPath($FileID, $Site['site_ftp_filebase_dir'] . "/");
	//$src_filename = $src_filepath . 'file-'. $FileID;   ///    This is original one
	if(ENV == "PRODUCTION"){
		$src_filepath = '/sg/web/' . $src_filepath;
	}
	if(ENV == "LOCAL"){
		$src_filepath = BASEDIR . "../citizen_client" . $src_filepath;
	}
	if(ENV == "DEV"){
		$src_filepath =  "/my/web/" . $src_filepath;
	}
	$src_filename = $src_filepath ."file-". $FileID;

	$download_result = ftp_get($conn_id, $TmpFile, $src_filename, FTP_BINARY, 0);

	ftp_close($conn_id);
	//fclose($TmpFile); // this removes the temp file
	
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

	unlink($TmpFile);
	exit;