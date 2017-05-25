<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

if (site::IsAPILoginExist($_REQUEST['site_api_login'], $_REQUEST['site_id'])) {
	header( 'Location: site_edit.php?site_id=' . $_REQUEST['site_id'] . '&ErrorMessage=' . urlencode(ADMIN_ERROR_API_LOGIN_EXIST));
	exit();
}


$site_ftp_password_sql = '';
if (strlen(trim($_REQUEST['site_ftp_password'])) > 0) {
	$site_ftp_password_sql = ", site_ftp_password = '" . aveEscT(site::MyEncrypt(trim($_REQUEST['site_ftp_password']))) . "'";
}

$query	=	"	UPDATE	site " .
			"	SET		site_is_enable 					= '" . ynval($_REQUEST['site_is_enable']) . "', " .
			"			site_name						= '" . aveEscT($_REQUEST['site_name']) . "', " .
			"			site_address					= '" . aveEscT($_REQUEST['site_address']) . "', " .
			"			site_ftp_address				= '" . aveEscT($_REQUEST['site_ftp_address']) . "', " .
			"			site_ftp_web_dir				= '" . aveEscT($_REQUEST['site_ftp_web_dir']) . "', " .
			"			site_ftp_userfile_dir			= '" . aveEscT($_REQUEST['site_ftp_userfile_dir']) . "', " .
			"			site_http_userfile_path 		= '" . aveEscT($_REQUEST['site_http_userfile_path']) . "', " .
			"			site_ftp_filebase_dir			= '" . aveEscT($_REQUEST['site_ftp_filebase_dir']) . "', " .
			"			site_ftp_static_link_dir		= '" . aveEscT($_REQUEST['site_ftp_static_link_dir']) . "', " .
			"			site_http_static_link_path 		= '" . aveEscT($_REQUEST['site_http_static_link_path']) . "', " .	
			"			site_empty_cache_url_callback 	= '" . aveEscT($_REQUEST['site_empty_cache_url_callback']) . "', " .
			"			site_sitemap_ignore_folder		= '" . ynval($_REQUEST['site_sitemap_ignore_folder']) . "', " .
			"			site_ftp_need_passive			= '" . ynval($_REQUEST['site_ftp_need_passive']) . "', " .
			"			site_ftp_username				= '" . aveEscT($_REQUEST['site_ftp_username']) . "', " .
			"			site_api_login					= '" . aveEscT($_REQUEST['site_api_login']) . "'" . $site_ftp_password_sql .
			"	WHERE	site_id = '" . intval($_REQUEST['site_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

site::EmptyAPICache($_REQUEST['site_id']);

header( 'Location: site_edit.php?site_id=' . $_REQUEST['site_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));