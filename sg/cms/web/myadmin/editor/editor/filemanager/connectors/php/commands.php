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

function GetFolders( $resourceType, $currentFolder )
{
	global $Site ; // XXX
	$conn_id = ftp_connect($Site['site_ftp_address']); // XXX
	$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password'])); // XXX

	if ($Site['site_ftp_need_passive'] == 'Y')
		ftp_pasv($conn_id, true);
	else
		ftp_pasv($conn_id, false);
	
	// Map the virtual path to the local server path.
	$sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'GetFolders' ) ;

	// Array that will hold the folders names.
	$aFolders	= array() ;

//	$oCurrentFolder = @opendir( $sServerDir ) ;
	$oCurrentFolder = @opendir( CombinePaths($Site['FtpUserfilePath'], $sServerDir) ) ; // XXX

	if ($oCurrentFolder !== false)
	{
		while ( $sFile = readdir( $oCurrentFolder ) )
		{
//			if ( $sFile != '.' && $sFile != '..' && is_dir( $sServerDir . $sFile ) )
			if ( $sFile != '.' && $sFile != '..' && is_dir( CombinePaths($Site['FtpUserfilePath'] , $sServerDir) . $sFile ) ) // XXX
				$aFolders[] = '<Folder name="' . ConvertToXmlAttribute( $sFile ) . '" />' ;
		}
		closedir( $oCurrentFolder ) ;
	}

	// Open the "Folders" node.
	echo "<Folders>" ;

	natcasesort( $aFolders ) ;
	foreach ( $aFolders as $sFolder )
		echo $sFolder ;

	// Close the "Folders" node.
	echo "</Folders>" ;
}

function ftp_isdir($connect_id, $dir)
{
	$iFileSize = @ftp_size($connect_id, $dir ) ;
		
	if ($iFileSize >= 0)
		return false;
	else
		return true;
}

function GetFoldersAndFiles( $resourceType, $currentFolder )
{
	global $Site ; // XXX
	$conn_id = ftp_connect($Site['site_ftp_address']); // XXX
	$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password'])); // XXX

	if ($Site['site_ftp_need_passive'] == 'Y')
		ftp_pasv($conn_id, true);
	else
		ftp_pasv($conn_id, false);
	
	// Map the virtual path to the local server path.
	$sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'GetFoldersAndFiles' ) ;

	// Arrays that will hold the folders and files names.
	$aFolders	= array() ;
	$aFiles		= array() ;

//	$oCurrentFolder = @opendir( $sServerDir ) ;

//	if ($oCurrentFolder !== false || 1 > 0)
	if (true) { // XXX
		ftp_chdir($conn_id, $Site['site_ftp_userfile_dir'] . $sServerDir);
		$FTP_Files = ftp_nlist($conn_id, ""); // XXX
//		$FTP_Files = ftp_nlist($conn_id, $Site['site_ftp_userfile_dir'] . $sServerDir); // XXX
//		while ( $sFile = readdir( $oCurrentFolder ) )
		foreach ($FTP_Files as $sFile) { // XXX
			// Some FTP return full path... eChoice!
			$pos = strrpos($sFile, "/");
			
			if ($pos !== false)
				$sFile = substr($sFile, $pos+1);
			
			if ( $sFile != '.' && $sFile != '..' ) {
//				if ( is_dir( $sServerDir . $sFile ) )
			
				if ( ftp_isdir ($conn_id, $Site['site_ftp_userfile_dir'] . $sServerDir . $sFile)) // XXX
					$aFolders[] = '<Folder name="' . ConvertToXmlAttribute( $sFile ) . '" />' ;
				else
				{
//					$iFileSize = @filesize( $Site['site_ftp_userfile_dir'] . $sServerDir . $sFile ) ;
					$iFileSize = @ftp_size($conn_id, $Site['site_ftp_userfile_dir'] . $sServerDir . $sFile ) ; // XXX

					if ( !$iFileSize ) {
						$iFileSize = 0 ;
					}
					if ( $iFileSize > 0 )
					{
						$iFileSize = round( $iFileSize / 1024 ) ;
						if ( $iFileSize < 1 )
							$iFileSize = 1 ;
						
					}
					$aFiles[] = '<File name="' . ConvertToXmlAttribute( $sFile ) . '" size="' . $iFileSize . '" />' ;
				}
			}
		}
//		closedir( $oCurrentFolder ) ;
	}

	// Send the folders
	natcasesort( $aFolders ) ;
	echo '<Folders>' ;

	foreach ( $aFolders as $sFolder )
		echo $sFolder ;

	echo '</Folders>' ;

	// Send the files
	natcasesort( $aFiles ) ;
	echo '<Files>' ;

	foreach ( $aFiles as $sFiles )
		echo $sFiles ;

	echo '</Files>' ;
}

function CreateFolder( $resourceType, $currentFolder )
{
	global $Site ; // XXX

	if (!isset($_GET)) {
		global $_GET;
	}
	$sErrorNumber	= '0' ;
	$sErrorMsg		= '' ;

	if ( isset( $_GET['NewFolderName'] ) )
	{
		$sNewFolderName = $_GET['NewFolderName'] ;
		$sNewFolderName = SanitizeFolderName( $sNewFolderName ) ;

		if ( strpos( $sNewFolderName, '..' ) !== FALSE )
			$sErrorNumber = '102' ;		// Invalid folder name.
		else
		{
			// Map the virtual path to the local server path of the current folder.
			$sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'CreateFolder' ) ;

//			if ( is_writable( $sServerDir ) )

// Notice that 5 > 3 here as is_writable is buggy, see php doc's note
			if (5 > 3 || is_writable( CombinePaths ($Site['FtpUserfilePath'], $sServerDir) )) // XXX
			{
				$sServerDir .= $sNewFolderName ;

				$sErrorMsg = CreateServerFolder( $sServerDir ) ;

				switch ( $sErrorMsg )
				{
					case '' :
						$sErrorNumber = '0' ;
						break ;
					case 'Invalid argument' :
					case 'No such file or directory' :
						$sErrorNumber = '102' ;		// Path too long.
						break ;
					default :
						$sErrorNumber = '110' ;
						break ;
				}
			}
			else
				$sErrorNumber = '103' . CombinePaths ($Site['FtpUserfilePath'], $sServerDir) ;
		}
	}
	else
		$sErrorNumber = '102' ;

	// Create the "Error" node.
	echo '<Error number="' . $sErrorNumber . '" />' ;
}

function FileUpload( $resourceType, $currentFolder, $sCommand )
{
	global $Site ; // XXX
	if (!isset($_FILES)) {
		global $_FILES;
	}
	$sErrorNumber = '0' ;
	$sFileName = '' ;

	if ( isset( $_FILES['NewFile'] ) && !is_null( $_FILES['NewFile']['tmp_name'] ) )
	{
		global $Config ;

		$oFile = $_FILES['NewFile'] ;

		// Map the virtual path to the local server path.
		$sServerDir = ServerMapFolder( $resourceType, $currentFolder, $sCommand ) ;

		// Get the uploaded file name.
		$sFileName = $oFile['name'] ;
		$sFileName = SanitizeFileName( $sFileName ) ;

		$sOriginalFileName = $sFileName ;

		// Get the extension.
		$sExtension = substr( $sFileName, ( strrpos($sFileName, '.') + 1 ) ) ;
		$sExtension = strtolower( $sExtension ) ;

		if ( isset( $Config['SecureImageUploads'] ) )
		{
			if ( ( $isImageValid = IsImageValid( $oFile['tmp_name'], $sExtension ) ) === false )
			{
				$sErrorNumber = '202' ;
			}
		}

		if ( isset( $Config['HtmlExtensions'] ) )
		{
			if ( !IsHtmlExtension( $sExtension, $Config['HtmlExtensions'] ) &&
				( $detectHtml = DetectHtml( $oFile['tmp_name'] ) ) === true )
			{
				$sErrorNumber = '202' ;
			}
		}

		// Check if it is an allowed extension.
		if ( !$sErrorNumber && IsAllowedExt( $sExtension, $resourceType ) )
		{
			$iCounter = 0 ;
			$conn_id = ftp_connect($Site['site_ftp_address']); // XXX
			$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password'])); // XXX

			if ($Site['site_ftp_need_passive'] == 'Y')
				ftp_pasv($conn_id, true);
			else
				ftp_pasv($conn_id, false);
			
			while ( true )
			{
				$sFilePath = $sServerDir . $sFileName ;

//				if ( is_file( $sFilePath ) )
				if ( ftp_is_file($conn_id, CombinePaths($Site['FtpFilebasePath'], $sFilePath) ) ) // XXX - again... is_file always return false on our FTP setting..... permission problem?
				{
					$iCounter++ ;
					$sFileName = RemoveExtension( $sOriginalFileName ) . '(' . $iCounter . ').' . $sExtension ;
					$sErrorNumber = '201' ;

					if ($iCounter > 100) {
						$sErrorNumber = '202' ;
						break;
					}
				}
				else
				{
//					move_uploaded_file( $oFile['tmp_name'], $sFilePath ) ;
					$upload_result = @ftp_put($conn_id, CombinePaths($Site['site_ftp_userfile_dir'],$sFilePath), $oFile['tmp_name'], FTP_BINARY, 0);
					ftp_close($conn_id);

					if (!$upload_result)
						$sErrorNumber = '202' ;

					break;// XXX - No need to check chmod below as this will be done by FTP server umask
					// Should not reach here

					if ( is_file( $sFilePath ) )
					{
						if ( isset( $Config['ChmodOnUpload'] ) && !$Config['ChmodOnUpload'] )
						{
							break ;
						}

						$permissions = 0777;

						if ( isset( $Config['ChmodOnUpload'] ) && $Config['ChmodOnUpload'] )
						{
							$permissions = $Config['ChmodOnUpload'] ;
						}

						$oldumask = umask(0) ;
						chmod( $sFilePath, $permissions ) ;
						umask( $oldumask ) ;
					}

					break ;
				}
			}

//			if ( file_exists( $sFilePath ) )
			if ( 3 > 5 && file_exists( $sFilePath ) ) // XXX
			{
				//previous checks failed, try once again
				if ( isset( $isImageValid ) && $isImageValid === -1 && IsImageValid( $sFilePath, $sExtension ) === false )
				{
					@unlink( $sFilePath ) ;
					$sErrorNumber = '202' ;
				}
				else if ( isset( $detectHtml ) && $detectHtml === -1 && DetectHtml( $sFilePath ) === true )
				{
					@unlink( $sFilePath ) ;
					$sErrorNumber = '202' ;
				}
			}
		}
		else
			$sErrorNumber = '202' ;
	}
	else
		$sErrorNumber = '202' ;


	$sFileUrl = CombinePaths( GetResourceTypePath( $resourceType, $sCommand ) , $currentFolder ) ;
	$sFileUrl = CombinePaths( $sFileUrl, $sFileName ) ;

	SendUploadResults( $sErrorNumber, $sFileUrl, $sFileName ) ;

	exit ;
}


function DeleteFile( $resourceType, $currentFolder ) {
	global $Site ; // XXX
	$conn_id = ftp_connect($Site['site_ftp_address']); // XXX
	$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password'])); // XXX

	if ($Site['site_ftp_need_passive'] == 'Y')
		ftp_pasv($conn_id, true);
	else
		ftp_pasv($conn_id, false);
	
    $file = CombinePaths($Site['site_ftp_userfile_dir'], urldecode($_GET['FileUrl']));
    if (ftp_is_file($conn_id, $file)) {
        ftp_delete($conn_id, $file);
    } else {
        echo '<error number="1" originaldescription="unable to locate file">' . xmlentities($file) . '</error>';
    }
}
function DeleteFolder( $resourceType, $currentFolder ) {
	global $Site ; // XXX
	$conn_id = ftp_connect($Site['site_ftp_address']); // XXX
	$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password'])); // XXX

	if ($Site['site_ftp_need_passive'] == 'Y')
		ftp_pasv($conn_id, true);
	else
		ftp_pasv($conn_id, false);
	
	$folder = CombinePaths($Site['site_ftp_userfile_dir'], $_GET['FolderName']);
    if (ftp_is_dir($conn_id, $folder) )   {
        DELETE_RECURSIVE_DIRS($conn_id, $_GET['FolderName']);
    } else {
        echo '<error number="2" originaldescription="unable to locate folder">';
    }
}
function DELETE_RECURSIVE_DIRS($conn_id, $parentdirname) { // recursive function to delete
	global $Site ; // XXX
    // all subdirectories and contents:
    $dirname = CombinePaths($Site['site_ftp_userfile_dir'], $parentdirname);
    if(ftp_is_dir($conn_id, $dirname))$dir_handle=opendir(CombinePaths($Site['FtpUserfilePath'], $parentdirname));
    while($file=readdir($dir_handle)) {
        if($file!="." && $file!="..") {
            if(!ftp_is_dir($conn_id, $dirname."/".$file)) {
                ftp_delete($conn_id, $dirname."/".$file);
            } else {
                DELETE_RECURSIVE_DIRS($parentdirname."/".$file);
            }
        }
    }
    closedir($dir_handle);
    ftp_rmdir($conn_id, $dirname);
}
?>
