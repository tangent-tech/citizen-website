<?php
// The file has been completely patched by Jeff @ 2010/03/24
// Normally I can embed something like "ftp://user:pass@host02.aveego.com" in the BasePath
// But any warning will result in revealing the FTP password. And I don't like this at all.
// So I patch EVERY file operation to match our FTP protocol for saving and retrieving data
// Crazy? Yes, but for once. It's fine. :D
// Notice: 
// if URL -> use $Site['site_http_userfile_path']
// if PATH -> use $Site['FtpUserfilePath']
// for upload: just rewrite that as filebase.class.php
// SEARCH "XXX" FOR MODIFIED CODE

/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2010 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * This is the File Manager Connector for PHP.
 */

function ftp_mksubdirs($ftpcon,$ftpbasedir,$ftpath){
	$cur_basedir = $ftpbasedir;
	$parts = explode('/',$ftpath); // 2013/06/11/username
	foreach($parts as $part){
		if(!@ftp_chdir($ftpcon, $cur_basedir . "/" . $part)){
			ftp_chdir($ftpcon, $cur_basedir . "/" . $part);
			ftp_mkdir($ftpcon, $part);
			//ftp_chmod($ftpcon, 0777, $part);
		}
		$cur_basedir = $cur_basedir . "/" . $part;
	}
//	
//	
//	
//	
//	echo "<cur_top_dir>" . ftp_pwd($ftpcon) . "</cur_top_dir>";
//   ftp_chdir($ftpcon, $ftpbasedir); // /var/www/uploads
//echo "<cur_top_dir2>" . ftp_pwd($ftpcon) . "</cur_top_dir2>";
//   $parts = explode('/',$ftpath); // 2013/06/11/username
//   foreach($parts as $part){
//echo "<part>" . $part . "</part>";
//      if(!@ftp_chdir($ftpcon, $part)){
//echo "<cur_dir_inner>" . ftp_pwd($ftpcon) . "</cur_dir_inner>";
//         ftp_mkdir($ftpcon, $part);
//         ftp_chdir($ftpcon, $part);
//         //ftp_chmod($ftpcon, 0777, $part);
//      }
//   }

}

function CombinePaths( $sBasePath, $sFolder )
{
	return RemoveFromEnd( $sBasePath, '/' ) . '/' . RemoveFromStart( $sFolder, '/' ) ;
}
function GetResourceTypePath( $resourceType, $sCommand )
{
	global $Config ;

	if ( $sCommand == "QuickUpload")
		return $Config['QuickUploadPath'][$resourceType] ;
	else
		return $Config['FileTypesPath'][$resourceType] ;
}

function GetResourceTypeDirectory( $resourceType, $sCommand )
{
	global $Config ;
	if ( $sCommand == "QuickUpload")
	{
		if ( strlen( $Config['QuickUploadAbsolutePath'][$resourceType] ) > 0 )
			return $Config['QuickUploadAbsolutePath'][$resourceType] ;

		// Map the "UserFiles" path to a local directory.
		return Server_MapPath( $Config['QuickUploadPath'][$resourceType] ) ;
	}
	else
	{
		if ( strlen( $Config['FileTypesAbsolutePath'][$resourceType] ) > 0 )
			return $Config['FileTypesAbsolutePath'][$resourceType] ;

		// Map the "UserFiles" path to a local directory.
		return Server_MapPath( $Config['FileTypesPath'][$resourceType] ) ;
	}
}

function GetUrlFromPath( $resourceType, $folderPath, $sCommand )
{
	return CombinePaths( GetResourceTypePath( $resourceType, $sCommand ), $folderPath ) ;
}

function RemoveExtension( $fileName )
{
	return substr( $fileName, 0, strrpos( $fileName, '.' ) ) ;
}

function ServerMapFolder( $resourceType, $folderPath, $sCommand )
{
	// Get the resource type directory.
	$sResourceTypePath = GetResourceTypeDirectory( $resourceType, $sCommand ) ;

	// Ensure that the directory exists.
	$sErrorMsg = CreateServerFolder( $sResourceTypePath ) ;
	if ( $sErrorMsg != '' )
		SendError( 1, "Error creating folder \"{$sResourceTypePath}\" ({$sErrorMsg})" ) ;

	// Return the resource type directory combined with the required path.
	return CombinePaths( $sResourceTypePath , $folderPath ) ;
}

function GetParentFolder( $folderPath )
{
	$sPattern = "-[/\\\\][^/\\\\]+[/\\\\]?$-" ;
	return preg_replace( $sPattern, '', $folderPath ) ;
}

function CreateServerFolder( $folderPath, $lastFolder = null )
{
	global $Config ;
	global $Site ; // XXX
	$sParent = GetParentFolder( $folderPath ) ;

	// Ensure the folder path has no double-slashes, or mkdir may fail on certain platforms
	while ( strpos($folderPath, '//') !== false )
	{
		$folderPath = str_replace( '//', '/', $folderPath ) ;
	}

	// Check if the parent exists, or create it.
//	if ( !empty($sParent) && !file_exists( $sParent ) )
	if ( !empty($sParent) && (5 > 3 || !file_exists(CombinePaths($Site['FtpUserfilePath'], $sParent)) ) ) // XXX
	{
		//prevents agains infinite loop when we can't create root folder
		if ( !is_null( $lastFolder ) && $lastFolder === $sParent) {
			return "Can't create $folderPath directory" ;
		}

		$sErrorMsg = CreateServerFolder( $sParent, $folderPath ) ;
		if ( $sErrorMsg != '' )
			return $sErrorMsg ;
	}

	//if ( !file_exists( $folderPath ) )
	if ( 5 > 3 || !file_exists(CombinePaths($Site['FtpUserfilePath'], $folderPath) ) ) // XXX
	{
		// Turn off all error reporting.
		error_reporting( 0 ) ;

		$php_errormsg = '' ;
		// Enable error tracking to catch the error.
		ini_set( 'track_errors', '1' ) ;

		if ( isset( $Config['ChmodOnFolderCreate'] ) && !$Config['ChmodOnFolderCreate'] )
		{
//			mkdir( $folderPath ) ;
//			mkdir( CombinePaths($Site['FtpUserfilePath'], $folderPath) ) ; // XXX
		
			global $Site ; // XXX
			$conn_id = ftp_connect($Site['site_ftp_address']); // XXX
			$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password'])); // XXX

			if ($Site['site_ftp_need_passive'] == 'Y')
				ftp_pasv($conn_id, true);
			else
				ftp_pasv($conn_id, false);
			
			ftp_mksubdirs($conn_id, $Site['site_ftp_userfile_dir'], $folderPath);
		}
		else
		{
			
			$permissions = 0777 ;
			if ( isset( $Config['ChmodOnFolderCreate'] ) )
			{
				$permissions = $Config['ChmodOnFolderCreate'] ;
			}
			// To create the folder with 0777 permissions, we need to set umask to zero.
			$oldumask = umask(0) ;
//			mkdir( $folderPath, $permissions ) ;
//			mkdir( CombinePaths($Site['FtpUserfilePath'] , $folderPath), $permissions ) ; // XXX
			

			global $Site ; // XXX
			$conn_id = ftp_connect($Site['site_ftp_address']); // XXX
			$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password'])); // XXX

			if ($Site['site_ftp_need_passive'] == 'Y')
				ftp_pasv($conn_id, true);
			else
				ftp_pasv($conn_id, false);
			
			ftp_mksubdirs($conn_id, $Site['site_ftp_userfile_dir'], $folderPath);
						
			umask( $oldumask ) ;
		}

		$sErrorMsg = $php_errormsg ;

		// Restore the configurations.
		ini_restore( 'track_errors' ) ;
		ini_restore( 'error_reporting' ) ;

		return $sErrorMsg ;
	}
	else
		return '' ;
}

function GetRootPath()
{
	die("GetRootPath was called?"); // XXX
	if (!isset($_SERVER)) {
		global $_SERVER;
	}
	$sRealPath = realpath( './' ) ;
	// #2124 ensure that no slash is at the end
	$sRealPath = rtrim($sRealPath,"\\/");

	$sSelfPath = $_SERVER['PHP_SELF'] ;
	$sSelfPath = substr( $sSelfPath, 0, strrpos( $sSelfPath, '/' ) ) ;

	$sSelfPath = str_replace( '/', DIRECTORY_SEPARATOR, $sSelfPath ) ;

	$position = strpos( $sRealPath, $sSelfPath ) ;

	// This can check only that this script isn't run from a virtual dir
	// But it avoids the problems that arise if it isn't checked
	if ( $position === false || $position <> strlen( $sRealPath ) - strlen( $sSelfPath ) )
		SendError( 1, 'Sorry, can\'t map "UserFilesPath" to a physical path. You must set the "UserFilesAbsolutePath" value in "editor/filemanager/connectors/php/config.php".' ) ;

	return substr( $sRealPath, 0, $position ) ;
}

// Emulate the asp Server.mapPath function.
// given an url path return the physical directory that it corresponds to
function Server_MapPath( $path )
{
	// Don't fucking care! Give me the untouched path!
	return $path;
	
	// This function is available only for Apache
	if ( function_exists( 'apache_lookup_uri' ) )
	{
		$info = apache_lookup_uri( $path ) ;
		return $info->filename . $info->path_info ;
	}

	// This isn't correct but for the moment there's no other solution
	// If this script is under a virtual directory or symlink it will detect the problem and stop
	return GetRootPath() . $path ;
}

function IsAllowedExt( $sExtension, $resourceType )
{
	global $Config ;
	// Get the allowed and denied extensions arrays.
	$arAllowed	= $Config['AllowedExtensions'][$resourceType] ;
	$arDenied	= $Config['DeniedExtensions'][$resourceType] ;

	if ( count($arAllowed) > 0 && !in_array( $sExtension, $arAllowed ) )
		return false ;

	if ( count($arDenied) > 0 && in_array( $sExtension, $arDenied ) )
		return false ;

	return true ;
}

function IsAllowedType( $resourceType )
{
	global $Config ;
	if ( !in_array( $resourceType, $Config['ConfigAllowedTypes'] ) )
		return false ;

	return true ;
}

function IsAllowedCommand( $sCommand )
{
	global $Config ;

	if ( !in_array( $sCommand, $Config['ConfigAllowedCommands'] ) )
		return false ;

	return true ;
}

function GetCurrentFolder()
{
	if (!isset($_GET)) {
		global $_GET;
	}
	$sCurrentFolder	= isset( $_GET['CurrentFolder'] ) ? $_GET['CurrentFolder'] : '/' ;

	// Check the current folder syntax (must begin and start with a slash).
	if ( !preg_match( '|/$|', $sCurrentFolder ) )
		$sCurrentFolder .= '/' ;
	if ( strpos( $sCurrentFolder, '/' ) !== 0 )
		$sCurrentFolder = '/' . $sCurrentFolder ;

	// Ensure the folder path has no double-slashes
	while ( strpos ($sCurrentFolder, '//') !== false ) {
		$sCurrentFolder = str_replace ('//', '/', $sCurrentFolder) ;
	}

	// Check for invalid folder paths (..)
	if ( strpos( $sCurrentFolder, '..' ) || strpos( $sCurrentFolder, "\\" ))
		SendError( 102, '' ) ;

	if ( preg_match(",(/\.)|[[:cntrl:]]|(//)|(\\\\)|([\:\*\?\"\<\>\|]),", $sCurrentFolder))
		SendError( 102, '' ) ;

	return $sCurrentFolder ;
}

// Do a cleanup of the folder name to avoid possible problems
function SanitizeFolderName( $sNewFolderName )
{
	$sNewFolderName = stripslashes( $sNewFolderName ) ;

	// Remove . \ / | : ? * " < >
	$sNewFolderName = preg_replace( '/\\.|\\\\|\\/|\\||\\:|\\?|\\*|"|<|>|[[:cntrl:]]/', '_', $sNewFolderName ) ;

	return $sNewFolderName ;
}

// Do a cleanup of the file name to avoid possible problems
function SanitizeFileName( $sNewFileName )
{
	global $Config ;

	$sNewFileName = stripslashes( $sNewFileName ) ;

	// Replace dots in the name with underscores (only one dot can be there... security issue).
	if ( $Config['ForceSingleExtension'] )
		$sNewFileName = preg_replace( '/\\.(?![^.]*$)/', '_', $sNewFileName ) ;

	// Remove \ / | : ? * " < >
	$sNewFileName = preg_replace( '/\\\\|\\/|\\||\\:|\\?|\\*|"|<|>|[[:cntrl:]]/', '_', $sNewFileName ) ;

	return $sNewFileName ;
}

// This is the function that sends the results of the uploading process.
function SendUploadResults( $errorNumber, $fileUrl = '', $fileName = '', $customMsg = '' )
{
	// Minified version of the document.domain automatic fix script (#1919).
	// The original script can be found at _dev/domain_fix_template.js
	echo <<<EOF
<script type="text/javascript">
(function(){var d=document.domain;while (true){try{var A=window.parent.document.domain;break;}catch(e) {};d=d.replace(/.*?(?:\.|$)/,'');if (d.length==0) break;try{document.domain=d;}catch (e){break;}}})();
EOF;

	if ($errorNumber && $errorNumber != 201) {
		$fileUrl = "";
		$fileName = "";
	}
	global $Site ; // XXX

	$rpl = array( '\\' => '\\\\', '"' => '\\"' ) ;
//	echo 'window.parent.OnUploadCompleted(' . $errorNumber . ',"' . strtr( $fileUrl, $rpl ) . '","' . strtr( $fileName, $rpl ) . '", "' . strtr( $customMsg, $rpl ) . '") ;' ;
	echo 'window.parent.OnUploadCompleted(' . $errorNumber . ',"' . strtr( $Site['HttpFilebaseURL'] . $fileUrl, $rpl ) . '","' . strtr( $fileName, $rpl ) . '", "' . strtr( $customMsg, $rpl ) . '") ;' ; // XXX
	echo '</script>' ;
	exit ;
}

?>